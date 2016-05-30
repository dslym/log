<?php

//评论模型】

class CommentModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MyMysqli();
    }

    //取出评论数据
    public function comment($atcid)
    {
        $atcid = intval($atcid);
        $sql = 'SELECT * FROM `comment` WHERE `atcid`=%d';
        $this->db->bind_query($sql, array($atcid));
        $rows = $this->db->fetch();
//        var_dump($rows);

        return $rows;
    }

    //评论
    public function writecomment($values_arr)
    {
        if (!$this->db->bind_query('INSERT INTO `comment`( `atcid`, `name`,`content`,`time`) 
           VALUES (%d,%s,%s,%d)', $values_arr)
        ) {
            zmMsg($this->db->get_stmt_error());
        } else {
            $this->db->free_result();
            $this->db->stmt_close();
            $this->db->mysql_close();
            return true;
        }
    }

    //查询评论
    public function redacomment($num = 10, $botton = 10)
    {
        if (!$this->db->bind_query('SELECT count(id) AS num FROM `news` WHERE 1')) {
            zmMsg($this->db->get_stmt_error());
        }
        if (($row = $this->db->fetch(true)) === false) {
            zmMsg($this->db->get_stmt_error());
        }
        $show = new Page($row['num'], $num, $botton);
        if (!$this->db->bind_query('SELECT * FROM `comment` GROUP BY `id` DESC LIMIT %d,%d', array($show->first_rows, $show->page_num_rows))) {
            zmMsg($this->db->get_stmt_error());
        }
        if (($rows = $this->db->fetch()) === false) {
            zmMsg($this->db->get_stmt_error());
        }

        return ['rows' => $rows, 'row' => $row, 'show' => $show->show()];
    }

    //回复评论
    public function returncomment($values_arr)
    {

        var_dump($values_arr);
//        exit();
        if (!$this->db->bind_query('UPDATE `comment` SET `return`=%s WHERE `id`=%d', $values_arr))
        {
            zmMsg($this->db->get_stmt_error());
        } else {
            $this->db->free_result();
            $this->db->stmt_close();
            $this->db->mysql_close();
            return true;
        }
    }
}