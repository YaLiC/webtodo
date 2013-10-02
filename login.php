<?php

require_once "init.php";

$user = false;

if ($uid) {
	$q = "SELECT * FROM user WHERE hash='". $uid ."';";
	$r = mysql_query($q) or die(mysql_error($db));
	$user = mysql_fetch_row($r);
	if ($uid != $user[3]) {
		$_SESSION['uid'] = null;
		$user = false;
	}
}

if ($login and $pass) {
	$hash = md5($login.$pass);	// добавить соли

	$q = "SELECT * FROM user WHERE login='".$login."';";
	$r = mysql_query($q) or die(mysql_error($db));
	$users = mysql_num_rows($r);
	$user = mysql_fetch_row($r);

	if ($user[1] == $login) {
		$q = "SELECT * FROM user WHERE login='".$login."' AND pass='".$pass."';";
		$r = mysql_query($q) or die(mysql_error($db));
		if (mysql_num_rows($r) == 1) {
			$user = mysql_fetch_row($r);
			$_SESSION['uid'] = $hash;
			echo "Вы вошли под пользователем ".rawurldecode($user[1]);
		} else {echo "Неверный пароль";}
	} elseif ($users == 0) {
		$q = "INSERT INTO user (login, pass, hash) VALUES ('".$login."', '".$pass."', '".$hash."');";
		$r = mysql_query($q) or die(mysql_error($db));
		if ($r) {
			$_SESSION['uid'] = $hash;
			$user = array("0",$login,$pass,$hash);
			echo "Пользователь создан.";
		}
	} else {echo "Этот логин уже занят или пароль не правильный";}
}


if (!$user) {$user = array("0","Anonymous","null","null");}

if ($action == "saymyuid") {echo $user[3];}

?>
