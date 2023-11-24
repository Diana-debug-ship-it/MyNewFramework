<?php

namespace wfm;

class Pagination
{
    // текущая страница
    public $currentPage;
    // сколько товаров на одну страницу
    public $perpage;
    public $total;
    public $countPages;

    // параметры запроса
    public $uri;

    /**
     *  номер страницы @param $page
     *  сколько товаров на транице @param $perpage
     *  всего товаров @param $total
     */
    public function __construct($page, $perpage, $total)
    {
        $this->perpage = $perpage;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
        $this->uri = $this->getParams();
    }

    public function __toString(): string
    {
        return $this->getHtml();
    }

    private function getCountPages()
    {
        return ceil($this->total / $this->perpage) ?: 1;
    }

    private function getCurrentPage($page)
    {
        if (!$page || $page<1) $page=1;
        if ($page > $this->countPages) $page = $this->countPages;
        return $page;
    }

    public function getStart() {
        return ($this->currentPage - 1) * $this->perpage;
    }

    private function getParams()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0];
        if (isset($url[1]) && $url[1]!='') {
            $uri.='?';
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!preg_match("#page=#", $param)) $uri.="{$param}&";
            }
        }
        return $uri;
    }

    private function getHtml()
    {
        $back = null; //ссылка НАЗАД
        $forward = null; //ссылка ВПЕРЕД
        $startpage = null; //ссылка В НАЧАЛО
        $endpage = null; //ссылка В КОНЕЦ
        $page2left = null; //ссылка ВТОРАЯ СТРАНИЦА СЛЕВА
        $page1left = null; //ссылка ПЕРВАЯ СТРАНИЦА СЛЕВА
        $page2right = null; //ссылка ВТОРАЯ СТРАНИЦА СПРАВА
        $page1right = null; //ссылка ПЕРВАЯ СТРАНИЦА СПРАВА

        //back
        if ($this->currentPage > 1) {
            $back = "<li class='page-item'><a class='page-link' href='" .
                $this-> getLink($this->currentPage-1) . "'>&lt</a></li>";
        }

        //forward
        if ($this->currentPage < $this->countPages) {
            $forward = "<li class='page-item'><a class='page-link' href='" .
                $this-> getLink($this->currentPage+1) . "'>&gt</a></li>";
        }

        //startpage
        if ($this->currentPage>3) {
            $startpage = "<li class='page-item'><a class='page-link' href='" .
            $this-> getLink(1) . "'>&laquo</a></li>";
        }

        //endpage
        if ($this->currentPage<($this->countPages-2)) {
            $endpage = "<li class='page-item'><a class='page-link' href='" .
                $this-> getLink($this->countPages) . "'>&raquo</a></li>";
        }

        //page2left
        if ($this->currentPage-2>0) {
            $page2left = "<li class='page-item'><a class='page-link' href='" .
                $this-> getLink($this->currentPage-2) . "'>". ($this->currentPage-2) ."</a></li>";
        }

        //page1left
        if ($this->currentPage-1>0) {
            $page1left = "<li class='page-item'><a class='page-link' href='" .
                $this-> getLink($this->currentPage-1) . "'>". ($this->currentPage-1) ."</a></li>";
        }

        //page2right
        if ($this->currentPage+2<=$this->countPages) {
            $page2right = "<li class='page-item'><a class='page-link' href='" .
                $this-> getLink($this->currentPage+2) . "'>". ($this->currentPage+2) ."</a></li>";
        }

        //page1right
        if ($this->currentPage+1<=$this->countPages) {
            $page1right = "<li class='page-item'><a class='page-link' href='" .
                $this-> getLink($this->currentPage+1) . "'>". ($this->currentPage+1) ."</a></li>";
        }

        return '<nav aria-label="Page navigation example"><ul class="pagination">' . $startpage .
            $back . $page2left . $page1left . '<li class="page-item active"><a class="page-link">' . $page1right . $page2right . $forward . $endpage . '</ul></nav>';
    }

    public function getLink($page)
    {
        if ($page==1) {
            return rtrim($this->uri, '?&');
        }

        if (str_contains($this->uri, '&')) {
            return "{$this->uri}page={$page}";
        } else {
            if (str_contains($this->uri, '?')) {
                return "{$this->uri}page={$page}";
            } else {
                return "{$this->uri}?page={$page}";
            }
        }
    }


}