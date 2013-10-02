<?php

require_once "init.php";

echo "!!! Установка WebTODO... ";

if ($host["query"] == "reinstall") {
	$q = "DROP DATABASE ".$mysql["db"];
	$r = mysql_query($q) or die("DB: ".mysql_error($db));
}

$q = "CREATE DATABASE IF NOT EXISTS ".$mysql["db"]." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
$r = mysql_query($q) or die("DB1: ".mysql_error($db));
if ($r) echo " -> Успешна создана БД.";

mysql_select_db($mysql["db"]) or die("DB2: ".mysql_error($db));

$q = "CREATE TABLE IF NOT EXISTS todo (number INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY (number),
	hash VARCHAR(32) NOT NULL,
	date DATE NOT NULL,
	time TIME NOT NULL,
	status TINYINT UNSIGNED NOT NULL,
	text VARCHAR(1024),
	user INT UNSIGNED NOT NULL,
	created DATETIME NOT NULL);";
$r = mysql_query($q) or die("DB3: ".mysql_error($db));
if ($r) echo " -> Успешна создана таблица задач.";

$q = "CREATE TABLE IF NOT EXISTS user (number INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY (number),
	login VARCHAR(128) NOT NULL,
	pass VARCHAR(64) NOT NULL,
	hash VARCHAR(32) NOT NULL);";
$r = mysql_query($q) or die(mysql_error($db));
if ($r) echo " -> Успешна создана таблица пользователей.";

$text = "Web Todo к Вашим услугам!<br/>Ваше первое задание: зарегистрироваться и составить список задач. :)";
$hash = md5($text);

$q = "INSERT INTO todo (hash, date, time, status, text, user, created) VALUES ('$hash', '$date', '$time', '1', '$text', '0', '$datetime');";
$r = mysql_query($q) or die("DB: ".mysql_error($db));
if ($r) echo " -> Успешно создано первое задание.";

echo "!!! Готово.";

/*
ALTER TABLE 'todo' ADD 'created' DATETIME NOT NULL AFTER user;
*/
?>
