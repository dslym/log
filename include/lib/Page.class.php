<?php

//分页类
class Page
{
    #数据总数
    private $all_num_rows;
    #每页数据条数
    public $page_num_rows;
    #总页数
    private $all_num_pages;
    #当前页数
    private $this_page;
    #数据起始行数
    public $first_rows;
    private $page_num_buttons;
    private $page_name;

    public function __construct($all_num_rows, $page_num_rows = 10, $page_num_buttons = 10, $page_name = 'page')
    {
        $this->page_name = $page_name;
        $this->all_num_rows = $all_num_rows;
        $this->page_num_rows = !empty($page_num_rows) ? $page_num_rows : 10;
        #计算总页数
        $this->all_num_pages = intval (ceil (($this->all_num_rows / $this->page_num_rows)));
        #获取当前页数
        $this->this_page = $this->get_this_page ();
        #当前页数起始数据条数
        $this->first_rows = ($this->this_page - 1) * $this->page_num_rows;
        #每页显示按钮个数
        $this->page_num_buttons = abs($page_num_buttons < $this->all_num_pages ? $page_num_buttons : $this->all_num_pages);

//        $this->get_query_string ();
    }

    /**获取并处理 传入的页码
     * @return int
     */
    private function get_this_page()
    {
        #从地址栏获取页码判断合法性
        $page = isset($_REQUEST[$this->page_name]) ? abs (intval ($_REQUEST[$this->page_name])) : 1;
        #二次判断处理
        $page = !empty($page) ? $page : 1;
        return $page;
    }

    private function get_query_string()
    {
        $string = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        parse_str ($string, $arr);
        unset($arr[$this->page_name]);
        $aa = http_build_query ($arr);
        return !empty($aa) ? '?' . $aa . '&' : '?';

//        var_dump ($url);
    }

    public function show()
    {
        if ($this->all_num_pages==1||$this->all_num_rows==0){
            return '';
        }
        $url = $this->get_query_string ();
//      var_dump ($url.'page=吴凡挖吧');
        $html = '<nav><ul class="pagination">';
        $c = intval ($this->page_num_buttons / 2);

        if ($this->this_page <= 1) {
//            $html .= '<li class="disabled"><a href="javascript:void(0)">首页</a>';
            $html .= '<li class="disabled"><a href="javascript:void(0)"><上一页</a>';
        } else {
//            $html .= '<li><a href="' . $url . $this->page_name . '=' . 1 . '">首页</a>';
            $html .= '<li><a href="' . $url . $this->page_name . '=' . ($this->this_page - 1) . '"><上一页</a>';
        }

//开头页码循环
        if ($this->this_page <= $this->page_num_buttons - $c && $this->this_page <= $this->all_num_pages - ($this->page_num_buttons - $c)) {
            for ($i = 1; $i <= $this->page_num_buttons; $i++) {
                if ($this->this_page == $i) {
                    $html .= '<li class="active"><a href="' . $url . $this->page_name . '=' . $i . '">' . $i . '</a>';
                } else {
                    $html .= '<li><a href="' . $url . $this->page_name . '=' . $i . '">' . $i . '</a>';

                }
            }
            $html.='<li><a href="javascript:void(0)">···</a>';
            $html.='<li><a href="' . $url . $this->page_name . '=' . $this->all_num_pages . '">'.$this->all_num_pages.'</a>';
        }

//中间部分页码循环
        if ($this->this_page > $this->page_num_buttons - $c && $this->this_page <= $this->all_num_pages - $this->page_num_buttons + $c) {
               $html.='<li><a href="' . $url . $this->page_name . '=' . 1 . '">1</a>';
               $html.='<li><a href="javascript:void(0)">···</a>';


            for ($i = $this->this_page - $c; $i <= $this->this_page + $c; $i++) {
                if ($this->this_page == $i) {
                    $html .= '<li class="active"><a href="' . $url . $this->page_name . '=' . $i . '">' . $i . '</a>';
                } else {
                    $html .= '<li><a href="' . $url . $this->page_name . '=' . $i . '">' . $i . '</a>';

                }
            }

                $html.='<li><a href="javascript:void(0)">···</a>';
                $html.='<li><a href="' . $url . $this->page_name . '=' . $this->all_num_pages . '">'.$this->all_num_pages.'</a>';
        }
//尾部页码循环
        if ($this->this_page > $this->all_num_pages - $this->page_num_buttons + $c) {
            $html.='<li><a href="' . $url . $this->page_name . '=' . 1 . '">1</a>';
            $html.='<li><a href="javascript:void(0)">···</a>';
            for ($i = $this->all_num_pages - $this->page_num_buttons + 1; $i <= $this->all_num_pages; $i++) {
                if ($this->this_page == $i) {
                    $html .= '<li class="active"><a href="' . $url . $this->page_name . '=' . $i . '">' . $i . '</a>';
                } else {
                    $html .= '<li><a href="' . $url . $this->page_name . '=' . $i . '">' . $i . '</a>';

                }
            }
        }

        if ($this->this_page >= $this->all_num_pages) {
            $html .= '<li class="disabled"><a href="javascript:void(0)">下一页></a>';
//            $html .= '<li class="disabled"><a href="javascript:void(0)">首页</a>';

        } else {
            $html .= '<li><a href="' . $url . $this->page_name . '=' . ($this->this_page + 1) . '">下一页></a>';
//            $html .= '<li><a href="' . $url . $this->page_name . '=' . $this->all_num_pages . '">尾页</a>';
        }
        $html.='<li><form action="" method="get"><input type="text" name="'.$this->page_name.'" value="" style="width: 55px"><input type="submit"  value="跳转"></form>
';
        $html .= '</ul></nav>';

        return $html;
    }

    public function test()
    {
        return $this->get_query_string ();
    }
}

