<?php
/**
 * Created by PhpStorm.
 * User: Tudor
 * Date: 3/30/14
 * Time: 1:21 PM
 */

require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');
ORM::configure('id_column_overrides', array(
        'pw_user' => 'usr_id',
        'pw_article' => 'art_id',
        'pw_category' => 'cat_id'
    ));

//id - daca id nu este definit sau este vid
if(!isset($_POST['id'])|| empty($_POST['id'])){
    echo ('id');
    exit;
}else{
    $article_id = $_POST['id'];
}


if(!is_numeric($article_id)){
    echo ('id');
    exit;
}

//title - daca titlul nu este definit sau este vid
if(!isset($_POST['title'])|| empty($_POST['title'])){
    echo ('title');
    exit;
}else{
    $title = $_POST['title'];
}


//content - daca continutul nu este definit sau este vid
if(!isset($_POST['content'])|| empty($_POST['content'])){
    echo ('content');
    exit;
}else{
    $content = $_POST['content'];
}

//author - daca autorul nu este setat, este vid sau nu exista in baza de date
if(!isset($_POST['author'])|| empty($_POST['author'])){
    echo ('author');
    exit;
}else{
    $author_id = $_POST['author'];
}

//cat_id - daca categoriile nu sunt setate, campul este gol sau
//exista una sau mai multe catgorii ce nu se regasesc in baza de date

if(!isset($_POST['cat_id'])|| empty($_POST['cat_id'])){
    echo ('cat_id');
    exit;
}else{
    $category_id = $_POST['cat_id'];
}
$category = ORM::for_table('pw_category')->where('cat_id', $category_id)->find_one();
if(!$category){
    echo ('cat_id');
    exit;
}

$article_to_edit =  ORM::for_table('pw_article')->where('art_id', $article_id)->find_one();
$article_to_edit->art_title = $title;
$article_to_edit->art_content = $content;
$article_to_edit->art_author = $author_id;
$article_to_edit->art_update_date = date("Y-m-d H:i:s");
$article_to_edit->save();

//$to_delete = ORM::for_table('pw_article_category')
//    ->where('artc_art_id', $article_id)->find_one()->delete();
ORM::get_db()->exec('DELETE from pw_article_category WHERE artc_art_id='.$article_id.' ');

$new_entry = ORM::for_table('pw_article_category')->create();
$new_entry->artc_art_id = $article_id;
$new_entry->artc_cat_id = $category_id;
$new_entry->save();
echo('ok');
