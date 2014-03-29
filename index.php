<!DOCTYPE html>
<html>
    <head>
        <!-- Trebuie setat pentru a afisa caracterele cu dicaritice -->
        <meta charset="utf-8">
    </head>
    <body>


<?php
require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');

//------------------------------------------------------

echo "<h2>EX 1</h2>";

$result = ORM::for_table('person')->limit(1)->find_many();
echo "<p>" . $result[0]->name . ", " . $result[0]->age ."</p>";

//------------------------------------------------------

echo "<h2>EX 2</h2>";

$result = ORM::for_table('person')->find_many();
echo "<ul>";
foreach($result as $person)
    echo "<li>" . $person->name . "</li>";
echo "</ul>";

//------------------------------------------------------

echo "<h2>EX 3</h2>";

$result = ORM::for_table('person')->where_like('name', '%lia')->find_many();
echo "<ul>";
foreach($result as $person)
    echo "<li>" . $person->name . "</li>";
echo "</ul>";
$result = ORM::for_table('person')->where_like('name', '%an')->find_many();
echo "<ul>";
foreach($result as $person)
    echo "<li>" . $person->name . "</li>";
echo "</ul>";

//------------------------------------------------------

echo "<h2>EX 5</h2>";

$result = ORM::for_table('person')->find_many();
echo "<ul>";
foreach($result as $person)
{
    $count = ORM::for_table('message')->where('person_id', $person->id)->count();
    echo "<li>" . $person->name . ", " . $count . "</li>";
}
echo "</ul>";


//------------------------------------------------------

echo "<h2>EX 6</h2>";
$result = ORM::for_table('person')->find_many();

echo "<ul>";
foreach($result as $person)
{
    echo "<li>" . $person->name;
    
    $messageList = ORM::for_table('message')->where('person_id', $person->id)->find_many();
    echo "<ul>";
    foreach($messageList as $message)
        echo "<li>" . $message->text . "</li>";
    echo "</ul>";
    
    
    echo "</li>";
}
echo "</ul>";

//------------------------------------------------------

echo "<h2>EX 7</h2>";
$result = ORM::for_table('person')->where_lte('age', 40)->find_many();
echo "<ul>";
foreach($result as $person){
    $messagesForPerson = ORM::for_table('message')->where('person_id', $person->id)->find_many();
    
    echo "<li>" . $person->name;
    echo "<ul>";
        foreach($messagesForPerson as $message)
            echo "<li>" . $message->text . "</li>";
    echo "</ul>" ;
    echo "</li>";
    }
echo "</ul>";

//------------------------------------------------------

echo "<h2>EX 9</h2>";
$result = ORM::for_table('person')->find_many();
echo "<ul>";
foreach($result as $person){
    $numberOfFriends = ORM::for_table('friend')->where('person1_id', $person->id)->count();
    echo "<li>" . $person->name . ", " . $numberOfFriends . "</li>";
    }
echo "</ul>";

//------------------------------------------------------

echo "<h2>EX 10</h2>";
$result = ORM::for_table('person')->find_many();
echo "<ul>";
foreach($result as $person)
{
    echo "<li>" . $person->name;
    
    $friendsOfPerson = ORM::for_table('friend')->join('person', array('friend.person2_id', '=', 'person.id'))->where('person1_id', $person->id)->find_many();
    echo "<ul>";
    foreach($friendsOfPerson as $friend)
        echo "<li>" . $friend->name . "</li>";
    echo "</ul>";
    
    echo "</li>";
}
echo "</ul>";

?>

    </body>
</html>
