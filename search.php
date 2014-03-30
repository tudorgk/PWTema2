<?php
/**
 * Created by PhpStorm.
 * User: Tudor
 * Date: 3/30/14
 * Time: 2:27 PM
 */

require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');
ORM::configure('id_column_overrides', array(
        'pw_user' => 'usr_id',
        'pw_article' => 'art_id',
        'pw_category' => 'cat_id'
    ));

//s - daca sirul de caractere de cautat nu este setat sau este vid

if(!isset($_GET['s']) || empty($_GET['s'])){
    echo ('s');
    exit;
}else{
    $string = $_GET['s'];
}

//cat_id - daca categoriile nu sunt setate, campul este gol sau
//exista una sau mai multe catgorii ce nu se regasesc in baza de date

if(isset($_POST['cat_id'])|| !empty($_POST['cat_id'])){
    $category_id = $_POST['cat_id'];
}

if(!isset($category_id)){
    $search_results = ORM::for_table('pw_article')
        ->join('pw_user', array('pw_article.art_author', '=', 'pw_user.usr_id'))
        ->where_raw("`art_title` GLOB '*".$string."*' OR `art_content` GLOB '*".$string."*'")
        ->order_by_desc('art_publish_date')
        ->find_many();
}else{
    $article_category_array = ORM::for_table('pw_article_category')
        ->where('artc_cat_id', $category_id)
        ->find_many();

    $article_ids = array();
    foreach($article_category_array as $artc){
        $article_ids[] = $artc->artc_art_id;
    }

    $search_results = ORM::for_table('pw_article')
        ->join('pw_user', array('pw_article.art_author', '=', 'pw_user.usr_id'))
        ->where_raw("`art_title` GLOB '*".$string."*' OR `art_content` GLOB '*".$string."*'")
        ->where_in('art_id', $article_ids)
        ->order_by_desc('art_publish_date')
        ->find_many();
}

$array_to_encode = array();
foreach($search_results as $result){
    $array_to_encode[] = array(
        "id" => $result->art_id,
        "title" => $result->art_title,
        "content" => $result->art_content,
        "views" => $result->art_views,
        "author" => $result->usr_username,
        "publish_date" => $result->art_publish_date,
        "update_date" => $result->art_update_date
    );
}
echo(json_encode($array_to_encode));