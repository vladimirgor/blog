<form method="POST">
    <?=$head_line1?>
    <br>
    <input type="text" required name="title" value="<?=$title?>"/>
    <br>
    <?=$head_line2?>
    <br>
    <textarea name="content" required ><?=$content?></textarea>
    <br>
    <input type="submit" value="Save" >
</form>