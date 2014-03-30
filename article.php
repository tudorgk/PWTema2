<?php
/**
 * Created by PhpStorm.
 * User: Tudor
 * Date: 3/30/14
 * Time: 1:41 PM
 */


require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');
ORM::configure('id_column_overrides', array(
        'pw_user' => 'usr_id',
        'pw_article' => 'art_id',
        'pw_category' => 'cat_id'
    ));

//wrong_art - daca id-ul articolului nu este numar
//intreg sau daca articolul cu id-ul respectiv nu exista

if(!isset($_GET['art_id'])){
    echo ('wrong_art');
    exit;
}else{
    $article_id = $_GET['art_id'];
}

if(!is_numeric($article_id)){
    echo ('wrong_art');
    exit;
}

$result = ORM::for_table('pw_article')
    ->join('pw_user', array('pw_article.art_author', '=', 'pw_user.usr_id'))
    ->where('art_id', $article_id)
    ->find_one();

if(!$result){
    echo('wrong_art');
    exit;
}

if($result){
    $array_to_encode = array(
        "id" => $result->art_id,
        "title" => $result->art_title,
        "content" => $result->art_content,
        "views" => $result->art_views,
        "author" => $result->usr_username,
        "publish_date" => $result->art_publish_date,
        "update_date" => $result->art_update_date
    );
    echo(json_encode($array_to_encode));
}else{
    echo('[]');
}


$result->art_views +=1;
$result->save();
