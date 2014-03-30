<?php
/**
 * Created by PhpStorm.
 * User: Tudor
 * Date: 3/29/14
 * Time: 9:12 PM
 */

require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');
ORM::configure('id_column_overrides', array(
        'pw_user' => 'usr_id',
        'pw_article' => 'art_id',
        'pw_category' => 'cat_id'
    ));

//wrong_cat - daca id-ul categoriei nu este numar intreg
//sau daca categoria cu id-ul respectiv nu exista

if(!isset($_GET['cat_id'])){
    echo ('wrong_cat');
    exit;
}else{
    $category_id = $_GET['cat_id'];
}

if(!is_numeric($category_id)){
    echo ('wrong_cat');
    exit;
}

$category = ORM::for_table('pw_category')->where('cat_id', $category_id)->find_one();
if(!$category){
    echo('wrong_cat');
    exit;
}

$art_id_array = ORM::for_table('pw_article_category')
    ->where('pw_article_category.artc_cat_id', $category_id)
    ->find_many();

$articles = array();

foreach($art_id_array as $art_id){
    $results = ORM::for_table('pw_article')
        ->join('pw_user', array('pw_article.art_author', '=', 'pw_user.usr_id'))
        ->where('art_id', $art_id->artc_art_id)
        ->order_by_desc('art_publish_date')
        ->find_one();

    $articles[] = $results;
}

$to_encode_array =array();

foreach($articles as $article){
    $to_encode_array[] = array(
        "id"  => $article->art_id,
        "title" => $article->art_title,
        "content" => $article->art_content,
        "views" => $article->art_views,
        "author" => $article->usr_username,
        "publish_date" => $article->art_publish_date,
        "update_date" => $article->art_update_date
    );
}
echo(json_encode($to_encode_array));
