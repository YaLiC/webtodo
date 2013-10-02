<?php

require_once "settings.php";

$txtstatus[0] = array('del','new','inc','end','out','fal');
$txtstatus[0][200] = "arh";

$txtstatus[1] = array('В корзине','Новая задача','Выполняется','Выполнена','Отложена','Провалена');
$txtstatus[1][200] = "В архиве";

# Открываем сессию
session_start();

# Получаем свойства хоста
$host["agent"]  = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"*";
$host["ip"]     = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:"0.0.0.0"; 
$host["name"]   = gethostbyaddr($ip);
$host["ref"]    = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"*";
$host["uri"]    = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"*";
$host["query"]  = isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:"*";
$date	=	date("Y-m-d");
$time	=	date("H:i:s");
$datetime = date("Y-m-d H:i:s");

//function timemachine($to) {return date("Y-d-m", mktime(date("s"), date("i"), date("H"), date("d")+$to, date("m"), date("Y"))); }

$uid	=	isset($_SESSION['uid'])? filter_var($_SESSION['uid'], FILTER_SANITIZE_ENCODED) : false;

$login	=	isset($_POST['login'])? mysql_escape_string($_POST['login']) : false;
$pass	=	isset($_POST['pass'])? mysql_escape_string($_POST['pass']) : false;

$action	=	isset($_POST['action'])? filter_var($_POST['action'], FILTER_SANITIZE_ENCODED) : false;
$value	=	isset($_POST['value'])? filter_var($_POST['value'], FILTER_SANITIZE_ENCODED) : false;
$number	=	isset($_POST['number'])? filter_var($_POST['number'], FILTER_SANITIZE_ENCODED) : false;
$text	=	isset($_POST['text'])? mysql_escape_string($_POST['text']) : false;
$hash	=	isset($_POST['hash'])? filter_var($_POST['hash'], FILTER_SANITIZE_ENCODED) : false;
$find	=	isset($_POST['find'])? mysql_escape_string($_POST['find']) : false;
$ajax	=	isset($_POST['ajax'])? filter_var($_POST['ajax'], FILTER_SANITIZE_ENCODED) : false;

if ($_GET) {
$action	=	isset($_GET['action'])? filter_var($_GET['action'], FILTER_SANITIZE_ENCODED) : false;
$value	=	isset($_GET['value'])? filter_var($_GET['value'], FILTER_SANITIZE_ENCODED) : false;
$number	=	isset($_GET['number'])? filter_var($_GET['number'], FILTER_SANITIZE_ENCODED) : false;
$text	=	isset($_GET['text'])? mysql_escape_string($_GET['text']) : false;
$hash	=	isset($_GET['hash'])? filter_var($_GET['hash'], FILTER_SANITIZE_ENCODED) : false;
$find	=	isset($_GET['find'])? mysql_escape_string($_GET['find']) : false;
$ajax	=	isset($_GET['ajax'])? filter_var($_GET['ajax'], FILTER_SANITIZE_ENCODED) : false;
}

$db = mysql_connect($mysql["host"], $mysql["user"], $mysql["pass"]) or die ("Не удалось подключиться к SQL");
mysql_select_db($mysql["db"]) or die("Не найдена БД");

?>
