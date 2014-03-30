<?php
/**
 * Created by PhpStorm.
 * User: Tudor
 * Date: 3/29/14
 * Time: 6:44 PM
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
if(!isset($_POST['password'])  || empty($_POST['password'])){
    echo ('password');
    exit;
}else{
    $password = $_POST['password'];
}

if(strlen($password) < 6 ){
    echo ('password');
    exit;
}

//password_strength - daca parola nu este suficient de puternica
$errorArray = checkPassword($password, $errors);
if($errors){
    echo ('password_strength');
    exit;
}


//confirm - daca confirmarea parolei nu coincide cu parola
if(!isset($_POST['confirm']) || empty($_POST['confirm'])){
    echo('confirm');
    exit;
}else{
    $password_confirm = $_POST['confirm'];
}

if(strcmp($password,$password_confirm)!=0 ){
    echo ('confirm');
    exit;
}
//TODO: needs testing
//user_exists - daca exista deja un cont cu acest nume de utilizator
$person = ORM::for_table('pw_user')->where('usr_username', $username)->find_one();

if($person){
    echo ('user_exists');
    exit;
}

//ok - daca nu s-a intors niciun raspuns din cele de mai sus
create_user($username,$password);


function create_user($username, $password) {
    $person = ORM::for_table('pw_user')->create();
    $person->usr_username = $username;

    $salt = generateRandomString();
    $passwordHash = sha1($password.$salt);
    $person->usr_password = $passwordHash;
    $person->usr_salt = $salt;

    $person->usr_register_date = date("Y-m-d H:i:s");
    $person->usr_last_login = date("Y-m-d H:i:s");
    $person->save();
    return $person;
}

function checkPassword($pwd, &$errors) {
    $errors_init = $errors;

    if (strlen($pwd) < 6) {
        $errors[] = "Password too short!";
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors[] = "Password must include at least one number!";
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $errors[] = "Password must include at least one letter!";
    }

    return ($errors == $errors_init);
}

function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

echo ('ok');
exit;
//http://localhost/register.php?username=unusersmechersafda&password=abcabc1&password_confirm=abcabc1

