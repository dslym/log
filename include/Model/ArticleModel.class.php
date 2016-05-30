<?php

//取出文章模型
class ArticleModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MyMysqli();
    }

    /**
     * @param int $num 每页显示数据数量
     * @param int $botton 翻页按钮数量
     * @return array
     */
    public function redartlist($num = 10, $botton = 10)
    {
        if (!$this->db->bind_query('SELECT count(id) AS num FROM `news` WHERE 1')) {
            zmMsg($this->db->get_stmt_error());
        }
        if (($row = $this->db->fetch(true)) === false) {
            zmMsg($this->db->get_stmt_error());
        }
        $show = new Page($row['num'], $num, $botton);
        if (!$this->db->bind_query('SELECT * FROM `news` GROUP BY `id` DESC LIMIT %d,%d', array($show->first_rows, $show->page_num_rows))) {
            zmMsg($this->db->get_stmt_error());
        }
        if (($rows = $this->db->fetch()) === false) {
            zmMsg($this->db->get_stmt_error());
        }

        return ['rows' => $rows, 'row' => $row, 'show' => $show->show()];
    }


    //写入数据
    public function writartlist($values_arr)
    {
        if (!$this->db->bind_query('INSERT INTO `news`( `title`, `content`,`excerpt`,`postdate`) 
           VALUES (%s,%s,%s,%d)', $values_arr))
        {
            zmMsg($this->db->get_stmt_error());
        } else {
            $this->db->free_result();
            $this->db->stmt_close();
            $this->db->mysql_close();
            return true;
        }
    }

    //修改数据
    public function updateartlist($values_arr)
    {
        if (!$this->db->bind_query('UPDATE `news` SET `title`=%s, `content`=%s,`excerpt`=%s,`postdate`=%d WHERE `id`=%d', $values_arr)){
            zmMsg($this->db->get_stmt_error());
        }else{
            $this->db->free_result();
            $this->db->stmt_close();
            $this->db->mysql_close();
            return true;
        }
    }

    //展示某篇文章
    public function showone($id){
        if (!$this->db->bind_query('SELECT * FROM `news` WHERE `id`= %d LIMIT 1',array($id))) {
            zmMsg($this->db->get_stmt_error());
        }
        if (($row = $this->db->fetch(true)) === false) {
            zmMsg($this->db->get_stmt_error());
        }
        $this->db->free_result();
        $this->db->stmt_close();
        $this->db->mysql_close();
        return $row;
    }

    //id查询某篇文章
    public function showatcname($id){
        if (!$this->db->bind_query('SELECT `title` FROM `news` WHERE `id`= %d ',array($id))) {
            zmMsg($this->db->get_stmt_error());
        }
        if (($row = $this->db->fetch(true)) === false) {
            zmMsg($this->db->get_stmt_error());
        }
        $this->db->free_result();
        $this->db->stmt_close();
        $this->db->mysql_close();
        return $row;
    }

    //删除数据
    public function del_artlist($did=array()){
        $where=implode(',',array_pad(array(),count($did),'%d'));
        $sql='DELETE FROM `news` WHERE `id` IN ('.$where.')';
        if (!$this->db->bind_query($sql,$did)){
            zmMsg($this->db->get_stmt_error());
        }
        $aff=$this->db->get_affected_rows();
        return $aff;
    }
    
}