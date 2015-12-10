<?php

abstract class C_Base extends C_Controller{

    public $title;
    public $id_article;
    public $title_article;
    public $content;
    public $intro;
    public $views;
    public function __construct(){

        $this->title = 'My_Blog';
        $this->id_article = 'MyId';
        $this->title_article = 'MyTitle';
        $this->content = 'MyContent.';
        $this->views = '0';
        $this->intro = '';

    }

    public function Before(){
//        include_once('M_Mysql.php');
//        $db = M_Mysql::GetInstance();
//        $db ->Connect();
        $this->title = 'G&V_Blog';
        $this->content = 'MyContent';
    }
    public function Render(){

        $page = $this->Template('theme/v_main.php',
            ['title' => $this->title,
                'content' => $this->content]);
        echo $page;
    }
}
?>