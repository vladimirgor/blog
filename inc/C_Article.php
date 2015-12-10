<?php

class C_Article extends C_Base{
    protected $alist;
    protected $user;
    function  __construct(){
        parent:: __construct();
    }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// Look at the entered id article function
    public  function Action_look (){
        $this->title .= "::Look";
        $id_article = $_GET['id'];
        $article = M_Article::articles_get($id_article);
        $article = $article[0];
        $article['views']++;
        M_Article::articles_edit($id_article, $article['title'],
            $article['content'],$article['views']);
        $this->content = $this->Template('theme/v_one.php',
          ['content'=> $article['content']]);
    }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// Edit the entered id article function
    public  function Action_edit (){
        $this->title .= "::Edit";

        $mUsers = M_Users::Instance();// connection to DB
        // by calling M_Mysql::GetInstance in the __construct M_Users

        $user = $mUsers->Get();

// Is it allowed to user to edit articles?
        if (!$mUsers->Can('EDIT_ARTICLE',$user['id_role']))
             {
// Access to service isn't allowed!
            header('Location: /index.php?c=article&a=Show_all&access=0');

            }
// Access to service is allowed!
        $id_article = $_GET['id'];


        if( $this->IsPOST() ) {

            $title = $_POST['title'];
            $content = $_POST['content'];

            M_Article::articles_edit($id_article, $title, $content);

            header('Location: /index.php?c=article&a=Show_all');
            exit();
       }


        $article = M_Article::articles_get($id_article);
        $article = $article[0];
        $this->content = $this->Template('theme/v_edit.php',
            ['title'=> $article['title'],
             'content'=> $article['content'],
             'head_line1' => 'Article title:',
             'head_line2' => 'Article content:']);
    }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// Delete the  entered id article function
    public  function Action_delete (){
        $this->title .= "::Delete";

        $mUsers = M_Users::Instance();// connection to DB
        // by calling M_Mysql::GetInstance in the __construct M_Users


        $user = $mUsers->Get();

// Is it allowed to user to delete articles?
        if ( !$mUsers->Can('DELETE_ARTICLE',$user['id_role']) )
            {
// Access to service isn't allowed!
            header('Location: /index.php?c=article&a=Show_all&access=0');
            exit();
            }

        $id_article = $_GET['id'];

        M_Article::articles_delete($id_article);

        header('Location: /index.php?c=article&a=Show_all');
        exit();

    }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// Addition  an article function
    public  function Action_add (){
        $this->title .= "::Add";

        $mUsers = M_Users::Instance();// connection to DB
        // by calling M_Mysql::GetInstance in the __construct M_Users

        $user = $mUsers->Get();

        // Может ли пользователь добавлять статьи?
        if (!$mUsers->Can('ADD_ARTICLE',$user['id_role']))
        {
// Access to service isn't allowed!
            header('Location: /index.php?c=article&a=Show_all&access=0');

        }
// Access to service is allowed!
        if( $this->IsPOST() ) {

            $title = $_POST['title'];
            $content = $_POST['content'];

            M_Article::articles_new($title, $content);

            header('Location: /index.php?c=article&a=Show_all');
            exit();
        }

        $this->content = $this->Template('theme/v_edit.php',
            ['head_line1' => 'Article title:',
             'head_line2' => 'Article content:']);
    }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// Addition  comment to the article function
    public  function Action_add_comment (){
        $this->title .= "::Add comment";

        $id_article = $_GET['id'];


        $comments = $_GET{'comments'};
        if ( $comments == '') $del = ''; else $del = '<br>';
            
        if(
        $this->IsPOST() ) {

            $name = $_POST['title'];
            $comment = $_POST['content'];
            $comments = $comments . $del . $name . ' : '. $comment;
            M_Article::articles_add_comment($id_article, $comments);

            header('Location: /index.php?c=article&a=Show_all');
            exit();
        }

            $this->content = $this->Template('theme/v_edit.php',
                ['head_line1' => 'Your name, please:',
                 'head_line2' => 'Your comment, please:']);
    }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// Articles list show function
    public function Action_Show_all()
    {

        $this->title .= "::Show_all";
// connection to the data base
// selecting all records from the data base
        $articles = M_Article::articles_all();
// creating array - alist from data base
        $a = [];
        foreach ($articles as $article) {
//creating one C_Article class object a from each record

            $a['id_article'] = $article['id_article'];
            $a['title_article'] = $article['title'];
            $a['content'] = $article['content'];
            $a['views'] = $article['views'];
            $a['comment'] = $article['comment'];
// article introduction - intro forming
            $i = 150;

            $a['intro'] = M_Article::intro($a['content'], $i);

            $this->alist[] = $a;


        }

        $mUsers = M_Users::Instance();// connection to DB
        // by calling M_Mysql::GetInstance in the __construct M_Users


        $this->user = $mUsers->Get();

       $this->content = $this->Template('theme/v_all.php',
           ['articles' => $this->alist,'login' => $this->user['login']]);

    }
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
}