<?php
/**
 * Created by PhpStorm.
 * User: Tudor
 * Date: 3/30/14
 * Time: 1:56 PM
 */

require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');
ORM::configure('id_column_overrides', array(
        'pw_user' => 'usr_id',
        'pw_article' => 'art_id',
        'pw_category' => 'cat_id'
    ));


//wrong_table - daca numele de tabel contine si alte caractere
//in afara de cifre, litere si underscores sau daca tabelul nu exista
if(!isset($_GET['table'])){
    echo ('wrong_table');
    exit;
}else{
    $table = $_GET['table'];
    if(!preg_match('/^[a-zA-Z0-9_]+$/',$table)){
        echo ('wrong_table');
        exit;
    }
    $result = ORM::for_table('')->raw_query("SELECT name FROM sqlite_master WHERE type='table' AND name='". $table ."'")->find_one();
    if(!$result){
        echo ('wrong_table');
        exit;
    }
}

$table_entries_array = ORM::for_table($table)->find_array();
echo(json_encode($table_entries_array));