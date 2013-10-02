<?php
header("Content-type: text/xml; charset=utf-8");
define('DATE_FORMAT_RFC822','r');

require_once "settings.php";

$txtstatus = array('Задача в корзине','Новая задача','Задача выполняется','Задача выполнена','Задача отложена','Задача провалена');
$lastbuilddate = date(DATE_FORMAT_RFC822);
$uid  = isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:false;


$db = mysql_connect($mysql["host"], $mysql["user"], $mysql["pass"]) or die ("Не удалось подключиться к SQL");
mysql_select_db($mysql["db"]) or die("Не найдена БД");

if ($uid) {
	$uid = base64_decode($uid);
	$q = "SELECT * FROM user WHERE hash='". $uid ."';";
	$r = mysql_query($q) or die(mysql_error($db));
	$user = mysql_fetch_row($r);
	if ($uid != $user[3]) {
		$user = false;
	}
} else {die("?!");}


echo '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">

<channel>
	<title>Web ToDo RSS</title>
	<link>http://todo.yalicprj.net</link>
	<description>Все ваши задачи в одной ленте</description>
	<pubDate>'.$lastbuilddate.'</pubDate>
	<lastBuildDate>'.$lastbuilddate.'</lastBuildDate>
';

$result = MYSQL_QUERY("SELECT * FROM todo WHERE user = '".$user[0]."'");
while ($row = MYSQL_FETCH_ARRAY($result)) {
	$title = $row['hash'];
	$text = rawurldecode($row['text']);
	$pubdate = date(DATE_FORMAT_RFC822, strtotime($row['created']));

	echo '<item>
	<title>Задача #'.$row['number'].'</title>
	<link>http://todo.yalicprj.net/core.php?action=gettodo&amp;hash='.$row['hash'].'</link>
	<description><![CDATA['.$text.'<br/>Статус: '.$txtstatus[$row['status']].']]></description>
	<pubDate>'.$pubdate.'</pubDate>
	<author>'.$user[1].'</author>
</item>

';
}

echo '

</channel>
</rss>';      

?>
