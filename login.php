<?php
/**
 * Created by PhpStorm.
 * User: Tudor
 * Date: 3/29/14
 * Time: 8:31 PM
 */

require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');
ORM::configure('id_column_overrides', array(
        'pw_user' => 'usr_id',
        'pw_article' => 'art_id',
        'pw_category' => 'cat_id'
    ));


//username - daca numele de utilizator nu este definit,
//este vid sau are o lungime mai mica de 6 caractere

if(!isset($_POST['username']) || empty($_POST['username'])){
    echo ('username');
    exit;
}else{
    $username = $_POST['username'];
}

if( strlen($username) < 6 ){
    echo ('username');
    exit;
}

//password - daca parola nu este definita,
//este vida sau are o lungime mai mica de 6 caractere
if(!isset($_POST['password'])|| empty($_POST['password'])){
    echo ('password');
    exit;
}else{
    $password = $_POST['password'];
}

if(strlen($password) < 6 ){
    echo ('password');
    exit;
}

//user_doesnt_exist - daca nu exista un utilizator cu acest username
$user = ORM::for_table('pw_user')->where('usr_username', $username)->find_one();
if(!$user){
    echo('user_doesnt_exist');
    exit;
}

//wrong_password - daca exista un utilizator cu acest username,
//dar parola este gresita; (bonus) parola va fi verificata folosind
//algoritmul SHA1 aplicat asupra concatenarii intre parola trimisa
//de utilizator si valoarea din campul usr_salt corespunzator
$salt = $user->usr_salt;
$passwordHash = sha1($password.$salt);
if(strcmp($passwordHash,$user->usr_password)!=0){
    echo('wrong_password');
    exit;
}

//ok - daca nu s-a intors niciun raspuns din cele de mai sus
$user->usr_last_login = date("Y-m-d H:i:s");
$user->save();
echo ('ok');
exit;
