 LOGIN :
    <?=$login?>
 <br>
<? if ( isset($_GET['access']) ): ?>
    <h2>Access to service for - <?=$login?> - isn't allowed!</h2>
<? endif ?>
 <br>
<a href="index.php?c=article&a=Add">To Add  an Article</a>
<br>
<ul>
    <?php
    foreach ( $articles as $article):?>

        <hr/>
        <li><h2><?=$article['id_article']?>.<?=$article['title_article']?></h2>
            Views quantity : <?=$article['views']?>
            <br><br>Intro : <?=$article['intro']?>
            <br><br>Comments :<br> <?=$article['comment']?>

            <br><br>
            <a href="index.php?c=article&a=Look&id=<?=$article['id_article']?>
                ">To Look the Article</a> |
            <a href="index.php?c=article&a=Edit&id=<?=$article['id_article']?>
                ">To Edit the Article</a> |
            <a href="index.php?c=article&a=Delete&id=<?=$article['id_article']?>
                ">To Delete the Article</a> |
            <a href="index.php?c=article&a=Add_comment&id=<?=$article['id_article']?>&comments=<?=$article['comment']?>
                ">To Add comment to the Article</a>
            <br><br>
        </li>
<!--        <hr/> -->

    <?php endforeach;?>
</ul>