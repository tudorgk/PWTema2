<?php
require_once 'idiorm.php';
ORM::configure('sqlite:./db.sqlite');

//creating pw_user table
ORM::get_db()->exec('DROP TABLE IF EXISTS pw_user;');
ORM::get_db()->exec(
    'CREATE TABLE pw_user (' .
        'usr_id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
        'usr_username VARCHAR(256), ' .
        'usr_password CHAR(40), '.
        'usr_salt CHAR(32), '.
        'usr_register_date DATETIME, '.
        'usr_last_login DATETIME)'
);

//creating pw_article table
ORM::get_db()->exec('DROP TABLE IF EXISTS pw_article');
ORM::get_db()->exec(
    'CREATE TABLE pw_article (' .
    'art_id INTEGER PRIMARY KEY AUTOINCREMENT,' .
    'art_title TEXT, '.
    'art_content TEXT, '.
    'art_views INTEGER, '.
    'art_publish_date DATETIME, '.
    'art_update_date DATETIME, '.
    'art_author INTEGER REFERENCES pw_user(usr_id))'
);

//creating pw_category table
ORM::get_db()->exec('DROP TABLE IF EXISTS pw_category');
ORM::get_db()->exec(
    'CREATE TABLE pw_category (' .
    'cat_id INTEGER PRIMARY KEY AUTOINCREMENT,' .
    'cat_title VARCHAR(254))'
);

//creating pw_article_category table
ORM::get_db()->exec('DROP TABLE IF EXISTS pw_article_category');
ORM::get_db()->exec(
    'CREATE TABLE pw_article_category (' .
    'artc_art_id INTEGER REFERENCES pw_article(art_id),' .
    'artc_cat_id INTEGER REFERENCES pw_category(cat_id)) '
);

//initializing data for pw_user
function init_user($username, $password,$salt, $register_date, $last_login) {
    $person = ORM::for_table('pw_user')->create();
    $person->usr_username = $username;
    $person->usr_salt= $salt;
    $person->usr_password = $password;
    $person->usr_register_date = $register_date;
    $person->usr_last_login =$last_login;
    $person->save();
    return $person;
}

init_user(
    'UKOFsDGAZa',
    'eb5c99dcab36c803a7726d5512ce12dffab224c6',
    'S26ig0BAEU55ndD3gSPbGpNHtJ7kYlSh',
    '2014-03-01 13:15:34',
    '0000-00-00 00:00:00');
init_user(
    'cFhXLByD1f',
    '60a870fdec95fe097b2b23a7e18747dab40db7ea',
    'B46Z69MttGv9UxdC91oYo00NnOxbijVJ',
    '2014-03-28 23:51:04',
    '0000-00-00 00:00:00');
init_user(
    'PFxocIcuMx',
    '8232dbe81b3b183cd6838ae16f0c333e36035c5e',
    'I6KSHPBv1eTLf4X6txCwjngsPMHSDuhh',
    '2014-03-26 20:09:10',
    '0000-00-00 00:00:00');

//initializing data for pw_article
function init_article($title, $content,$views, $publish_date, $update_date, $author) {
    $article = ORM::for_table('pw_article')->create();
    $article->art_title = $title;
    $article->art_content= $content;
    $article->art_views = $views;
    $article->art_publish_date= $publish_date;
    $article->art_update_date =$update_date;
    $article->art_author=$author;
    $article->save();
    return $article;
}

init_article(
    ' CZ9Lme3Q 87sqMz cM86e 2lxI txkaleFli PJb',
    ' 2kCst KDMkU09 3ak2F vcJH cGMiSw PAH g9bRiV 99KsZy GrJr57nua JXR vdD U4ttGTRG1 JbFiy3 3kUd9vQ2 4q3ds rnFsXf8A FSKEZj3N s5U JVef btA9 Q3IO5XjRp THv3 qDprCuAQo s6jLl v86Dx63l U4N1fu al8jxW Oee2W WtarhwrD xfxhlzJQi iWf3PgxF 2ZEIZY Kjk77L 2WwZd ku6MpJFv 4o2Jke URGqdvGYo HIE0JfH eEK 9xxYZZi HCH Ku0 6cU fREo 4V0 UYQw ugtkJ72Cn HUEYpOia owapg2j w4s KkVO32zf VJv bhANzwWi jyQ1 Sw2 SV1X28 okLl cUA D8He6zTPz S4vTSNSs m9BhBiU SMsSZzS k9eoJt7C 0DAxJn 97r b7pO do1qnYBO3 LZfO koKb tFnjYE2 PiQv H3d3sn QE1DTSH EfE86l QHfItqy nJoXoBj1 vq8Epk35M Z0A FKich SczD rKW2xwt3 83O9i1N deXNC LxI ddeg SoSl9Vrs 0O5 plFZj cArH7g1I AMgzG aw7bNK0LX Vo1q hQjK9Jlld vmcDgR Qztkv hotfSf53l cii 8rOhKtuv PqCTv lBXW n9cYxz5PW daVq dki0Fwh Lkjje RXg VTAlWdq',
    '6',
    '2014-03-24 06:26:07',
    '2014-03-25 15:43:03',
    '2');

init_article(
    ' R1i0 I1AFN7ZNZ EmvhzY4xc',
    ' xwaHC0sIC 9DUMlHi ED9j8D 5qq6l eo1dMwB hk3Mr RpuQ S9KRiDHuf 3lPsDnD O4LIpoN6 NQ8LgtxI OvtL Lmeryf qytqt1R bEMCEF4 sN4yIf U0K3Zrw KAgv ydHGW4a P5KvO MIZS8WXC7 OmBJ8QU 1gUE4nUS mNqxX LEn1Phly7 4kB3iH RcuuAx2k wdeEQ FFKiB XnvFFrllC A41rctAy Cx1U8Bc 40Wf3r La8WX0 ojFHLMJv Qjsct fq7Q7XMvN T2t r3TiUDgt niGU eKTdL E07 ak14T H2OtQ nYHyznY RNTFc 9Z4w07rw oMU E3gGfJG0 MLw FBpYn qlmqKgA6 4xT DaqnhXLc RwWGnNPD 9y3wHn C3Y8agBZ YXG3 g3PF rWl6 mSz9ymS vnIAG1j 1Tpt24cD apznhg7 ZsCt fWh4k 38UQL JDSh An3 4HAhVQ etgMuA 8OAjDnkoQ aBSHVXjnW gc5ojRHVy BsAa9rv cST14dQg qXacYkY PynisIC Qpo5sKWqf YmGbH KYQPULD 89LgSe L7Cvpk 22u6N 2T0 XloP z9Rj82Ba eUg u65m 2Bg 3gYcZ3 Odq zxmuakkp qi8laJJQo O4smrfc f6X jQAidbqm4 jbs5B ty8s wflhbMQL 5rf0 5k5 h5JAX9GqC 9fc0Qpb 0JyEkA y1OMNQK4 ZeBeaC 5CJOG3WU5 48UftXe ZkEuYJh6f Gxb XXA I8Qw3 MBx2 1hIxKS0z q6Dw L70cbP 858ZoGR yIlXIns3u xGXZp HSqTPhrU UNl6Zj8Wf MwTLe ESYQJy gR7EPfq16 Pzcb8eH JtIjriP B88m4YdI hc5N Dbe EflbPYu gAu yOHa RYSxrDMW wTyD1Eub 1l8CucKU1 Ha5OeeD 3ra3 DDQYa IZTJeb OvL H8s1SctS jxDqy 8fwaIdiGd u6Z0b TgZ6fxZ TOLTcyq ZJyf OgfVM8U 4fsr dCQ48Bi A88z qe6YcUi G078zS1 7mZP0Ou t3uMesr wQlL1 EjZskw SQu FaNg9My cDmd chuP WJBSpb phxgx 3ld9pSW QIEj5dPE bstj0 ReumqQ06e o9TqY ulCyDOElo Vjo',
    '77',
    '2014-03-20 12:46:30',
    '2014-03-26 16:12:05',
    '3');

init_article(
    ' cV0 yau XZjrTwIS',
    ' qtIwD 3G5 NVZ2UO3DR vCDt4i VYwYoUE 16wFliuwv mu4Yw39 MbkIw H5xuQ d7Sr aomo7 e4XILL dcl ye7SQ5W Fva78FDxO GBOF9 Jro4D gVaC5inY aSBt0KL MB9k wZBv6ZpTs y68Tq hIQjrAa KJeTLQnb arASpMA Ne9u19K lnkore 7zASj Mh4eE 0Hx9b4 5e2fM QgeI FTRh KeSzf aenwSFB7e SkVIHed 0pNuhY ruwcI68Yb pVa qfvyOHztD bEuhGx lV6bpg IFvGFQ27 aG7 kN9pAca DfFlGNBeu qGed iDi aWex QoGyAAzLR FAU1 ErrU1Fitj V8BBa uem65smQ Yvyd0Dcrg fJY GHRVWp7s tvH ZdvZw cjcYCjBX8 PaALsh DAx85 EqygP10t gWzOZj9x AidNJA 3d9Ob0y wAUkUUN HskxJb Zky 9ny KbE YBO yZvWHbG 9wPr7Q mkuplYkgZ GYoZpu9j hlXPkzDH WAk 1w18VE RfIza4U 20X3W74 Q10gdOWb 4BW TdmjTvOe G8t tEug efQ de39 ouydd ErET rbzl MPR TNX0w2l 6Ff2Dh SyWYU hIr0nRmXO YbH 9FCkdRF 1Kr5 M29JW29PH h20agH YkFGz hu23 KZEkT dWUbrA 7y5W hNoCPyATU 0MM7BU76 l9wKGCII2 vK0agiE PmAw oUmelc gIyXts Ed2lJjq V753rt E0J oPIXRDN 8EO2Pz e2E YkzkKP ux6miMg AsUI 26dwutn i5q2p 5ViYzS VBeMvoPPj ZwrEBPu Yew XHa UHvrEc IyF ur3',
    '12',
    '2014-03-11 11:14:33',
    '2014-03-21 16:21:15',
    '3');

init_article(
    ' 32RAY3kBg 9JfZpcNlH eq8sqbh',
    ' 5f9S7D0 Kw1VW SY9GOj Eyj3u MaOM6 Ic55 j6k4iZRe 4ckjdgYhK f1w2Je ay9FVhteL spF Mx6mG 2FTyWm DM1y21L DDawJ5juc OyoTL 7GKnKcR47 HLzKl XdqrChZ nUFbB x48dcJ kJqZS PuljcFF3 Rl3a kTHc6G3xB Ygl Ddf9MLOED 04UuiuPR v5bvdWi d4zdAJPuW qanXcds u7im9O mwN7Gr M3g AHPB7jsos 2jd SOtLPSQuf ojX3JUkBX bBETSu ceglaCn22 Nzvl02ORW EL7 gVszlEt 8O6RlKPY jBFo U4b7ILgA PQ2cRF kYWMOKog he6 9aFH qLmPKM jjwPxSl3 D6o0j8 X8hP0 SmfyMTh6 SbFnj XgEwcOR 6op1UPg jtUo bh6khT SCGZUx RDT EM1l zKzQIs VqXyi BM3YeV JctAWlo2 1af63 OYNBPb5I qhw3Wd2Xr HF8b NKoRrv Na7wL6NC PhlaqMA1 0EN8bo W29qZM JU8CNKiv 91NFavj psqMY8Yhr hSVW x015 MFMoQCB3 5qDHN CbWVZkg ceY0duMW bVq3U6 jMyVfmZ7 MCfzA EoVS Llq9 X3rz tmrEU Kp42XJbX eYU YEJczW H72PYbHi T716P1 q4C2n Expp EubkJ DVB oOCk dDlCQY NWvACcxd QXF9 4pxFKoX j5vbCtMy 0S7 FoCVU fDJvJ zOigpUEn S1Ysk8q6 bxCwU uXwGEeK BtN9jenOd KIkfAc5 77s2 NVT 6slDmwu q5VZ',
    '64',
    '2014-03-14 19:50:37',
    '2014-03-23 22:15:11',
    '2');

init_article(
    ' xUm oV4aV7jfc U8PodjT 4J0tP fNjGc6TEZ pKb3brS 4HG2qYF',
    ' fsP Z69ba bOgW 6dOQ vWoC7U 1vPxtE 4k0m pxF85 iCbyPv4s 3yqvW VlpfVtbDS s1MsYK50V Ld34hbA Bucldfao 2ak Yq1TCFM 57tQY rYmZwE l4nwMU5Z ogl nTaf pybG 6McxUgzA mapbhNZ KQM5Z K5H oo7gDCWkZ q0oGfDkc 4L1mEac eun18eB dlvZPi9sN a1t BUI 5QQpH I72 FXcB WLUHvQ YC0EH n2JVxcpy ozB5iAy agoo XzT8w3f ijx2 kmr yOBOY fR2vBl pnAvkNsm ygJ3UTBy FrrHqd 5wodV WNVAk8kK PPC1XE K8w cqFpk MyCi6C ylY jJq bXlbehy 5oqPNvMj mYI aPZHEIBS twU rdTMsFp7R yewbU KGB6pOcO 2OaTj1RU U9I 6JGIFO Vd8UxOU w5Rlm cH0 DKVjom adR ah7xSlrgp H7lMeyN Syl YA5w BCzr6 DY2 qmRnapzZz CRSqYA z7fwM0rN 6hQdo nDlIB UZf6zi lhbbxx oxhEUGZT PD7ciHqUW nN7 64Esa TPF9Gq TnKT OLiUkVv6M 9du5 tkww CZWLcra rngKbKPt 1YaYahvf QKnrfBI Bg6 uuTT0 UCKVwZ 6y0NGn5L NflubWCDm b6H 831m gGQ UwI JSp5WBV f1I1T0Lg TwCwvYI dzCAQi EKBLQLuGT oN12 IWsEu nsKx7aA9y zr0GOCkU pQVX1qGxa FJ5CP upEV D5A7DCf fdwN ltTcXJhI mbe4Xj ZDU iYF r3Oxov3 CnDk igp m9db8 6dJ VnJ 18f drRc NEgR8f7tW ZzbFBvkb 8lRn HNugnAdZ jLK1zRUr Ij2A3i 15Ibn T9JEHb 6sKk81N sJPA qMSns fTFT Aot2 uRaRiwJ FrlWU 5LU yzZSP ZtwwhFI Fp1vwbw GYNitd',
    '96',
    '2014-02-27 13:48:02',
    '2014-03-20 20:08:58',
    '3');

//initializing data for pw_category
function init_category($title) {
    $category = ORM::for_table('pw_category')->create();
    $category->cat_title = $title;
    $category->save();
    return $category;
}

init_category(
    ' TtN9HV9 wJMmd'
   );

init_category(
    ' 17JF 4mCxqd k0g0'
);

init_category(
    ' X8AM aZ9G'
);

//initializing data for pw_article_category
function init_article_category($art_id,$cat_id) {
    $art_cat = ORM::for_table('pw_article_category')->create();
    $art_cat->artc_art_id = $art_id;
    $art_cat->artc_cat_id = $cat_id;
    $art_cat->save();
    return $art_cat;
}

init_article_category(
    '1',
    '1'
);

init_article_category(
    '2',
    '1'
);

init_article_category(
    '3',
    '3'
);

init_article_category(
    '4',
    '1'
);

init_article_category(
    '5',
    '1'
);

echo('ok');

