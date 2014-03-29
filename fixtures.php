<?php
require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');
 
ORM::get_db()->exec('DROP TABLE IF EXISTS person;');
ORM::get_db()->exec(
    'CREATE TABLE person (' .
        'id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
        'name TEXT, ' .
        'age INTEGER)'
);
 
function create_person($name, $age, $message_list = array()) {
    $person = ORM::for_table('person')->create();
    $person->name = $name;
    $person->age = $age;
    $person->save();
    return $person;
}
 
$person_list = array(
    create_person('Corina', 41),
    create_person('Delia', 43),
    create_person('Tudor', 56),
    create_person('Adina', 32),
    create_person('Ada', 50),
    create_person('Camelia', 40),
    create_person('Vlad', 72),
    create_person('Emil', 27),
    create_person('Ștefan', 46),
    create_person('Dan', 63),
    create_person('Roxana', 67),
    create_person('Octavian', 34),
    create_person('Radu', 78),
    create_person('Marina', 63),
    create_person('Cezar', 19),
    create_person('Laura', 36),
    create_person('Andreea', 61),
    create_person('George', 28),
    create_person('Liviu', 44),
    create_person('Eliza', 19),
);
 
echo('ok<br>');
echo('person ' . ORM::for_table('person')->count() . '<br>');


// EX 4
ORM::get_db()->exec('DROP TABLE IF EXISTS message');
ORM::get_db()->exec(
    'CREATE TABLE message (' .
        'id INTEGER PRIMARY KEY AUTOINCREMENT,' .
        'person_id INTEGER REFERENCES person(id),' .
        'text TEXT)'
);

function create_message($person_id, $text)
{
    $message = ORM::for_table('message')->create();
    $message->person_id = $person_id;
    $message->text = $text;
    $message->save();
    return $message;
}

$text_list = array(
    "Nu da vrabia din mână pentru cioara de pe gard.",
    "Lumea muncește și sapă și eu duc câinii la apă.",
    "Caută o femeie care-ți place ție, nu la alții.",
    "A bate găina cu lanțul.",
    "Cine nu-ncearcă, nici nu câștigă.",
    "Cine fură azi un ou, mâine va fura un bou.",
    "Tinerii înaintea bătrânilor, să aibă urechi, nu gură!",
    "Nu e dracul așa de negru.",
    "Toate drumurile/căile duc la Roma.",
    "Cine seamănă vânt, culege furtună.",
    "Cele rele sâ se spele, cele bune să se-adune.",
    "Râde hârb/ciob de oală spartă",
    "Prostul nu se lasă până când nu spune tot ce știe",
    "Ce ție nu-ți place, altuia nu-i face.",
    "Nu lăuda ziua înainte de asfințit.",
    "Foamea e cel mai bun bucătar.",
    "A face bortă în apă.",
    "Nu tot ce zboară se mănâncă.",
    "Bunul gospodar își face vara sanie și iarna car.",
    "Cine aleargă după doi iepuri nu prinde niciunul.",
    "Nu haina îl face pe om.",
    "Ce poți face azi, nu lăsa pe mâine.",
    "Cine are/face carte are patru ochi.",
    "Nevoia te învață.",
    "A avea de-a face cu cineva",
    "Cine dă nu uită, uită cel care ia.",
    "După război mulți viteji se arată.",
    "Haina nu îl face pe om",
    "Să fii domn e o întâmplare, să fii om e lucru mare.",
    "A face cuiva ochi dulci.",
    "Ai, dai, n-ai. Ia nu da, să vezi cum ai.",
    "Din talpa casei nu se face obadă de roată.",
    "A bate apa-n piuă",
    "A face pe cineva cu ou și cu oțet.",
    "Lauda de sine nu miroase a bine.",
    "Cu fundul în două luntre."
);

for ($i = 0; $i < 25; $i++)
{
    create_message($i % count($person_list) + 1,$text_list[$i % count($text_list)]);
}

echo('ok<br>');
echo('message ' . ORM::for_table('message')->count() . '<br>');


ORM::get_db()->exec('DROP TABLE IF EXISTS friend');
ORM::get_db()->exec(
    'CREATE TABLE friend (' .
        'id INTEGER PRIMARY KEY AUTOINCREMENT,' .
        'person1_id INTEGER REFERENCES person(id),' .
        'person2_id INTEGER REFERENCES person(id))'
);

function create_friend($person1_id, $person2_id)
{
    $friend = ORM::for_table('friend')->create();
    $friend->person1_id = $person1_id;
    $friend->person2_id = $person2_id;
    $friend->save();
    
    $friend = ORM::for_table('friend')->create();
    $friend->person1_id = $person2_id;
    $friend->person2_id = $person1_id;
    $friend->save();
}

create_friend(14, 2);
create_friend(2, 5);
create_friend(4, 2);

echo('ok<br>');
echo('friend ' . ORM::for_table('friend')->count() . '<br>');

