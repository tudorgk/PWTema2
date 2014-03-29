<?php
/**
 * Created by PhpStorm.
 * User: Tudor
 * Date: 3/29/14
 * Time: 6:44 PM
 */
require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');

$username = $_GET['username'];
$password = $_GET['password'];
$password_confirm = $_GET['password_confirm'];


//echo($username . ' ');
//echo($password . ' ');
//echo($password_confirm . ' ');

//username - daca numele de utilizator nu este definit,
//este vid sau are o lungime mai mica de 6 caractere
if(strlen($username) < 6 || !isset($username) ){
    echo ('username');
    exit;
}

//password - daca parola nu este definita,
//este vida sau are o lungime mai mica de 6 caractere
if(strlen($password) < 6 || !isset($password) ){
    echo ('password');
    exit;
}

//confirm - daca confirmarea parolei nu coincide cu parola
if(strcmp($password,$password_confirm)!=0 ){
    echo ('confirm');
    exit;
}

//password_strength - daca parola nu este suficient de puternica
$errorArray = checkPassword($password, $errors);
if($errors){
    echo ('password_strength');
    exit;
}


//TODO: needs testing
//user_exists - daca exista deja un cont cu acest nume de utilizator
echo('OK!');
echo('<br/>');
exit;

//
//$person = ORM::for_table('pw_user')->create();
//$person->usr_username = $username;
//$person->age = 20;
//$person->set_expr('added', 'NOW()');
//$person->save();

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


//localhost/register.php?username=pula?password=in?password_confirm=pizda