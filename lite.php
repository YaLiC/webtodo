<?php 
require_once "core.php";
?>
<!doctype html><!-- Универсальный -->
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<title>Web ToDo [lite]</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="lite.css" media="all" />
	<link rel="alternate" type="application/rss+xml" href="rss.php?<?php echo base64_encode($user[3]) ?>" title="MyRSS" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0" />
	<meta name="keywords" content="web todo list список задач lite version balduev ilya" />
	<meta name="description" content="Ваш список задач в современном вебприложении — Web ToDo" />
	<meta name="author" content="Балдуев Илья" />
</head>

<body>

<div id="header">
	<h1><a href="lite.php">Web&nbsp;ToDo&nbsp;[lite]</a></h1>
	<h2>Всё&nbsp;проще&nbsp;чем&nbsp;кажется</h2>
</div>

<div id="auth">
	<?php
	if ($user[0] == 0) {
	echo '
	<form action="lite.php" method="post"><div>
	<fieldset>	<legend>Авторизация</legend>
	Логин:<input type="text" name="login" />
	Пароль:<input type="password" name="pass" />
	<input type="submit" value="Представиться" />
	</fieldset></div></form>
	';
	} else {echo 'Пользователь: '.$user[1];}
	?>
</div>

<div id="main">

	<div id="newtodo">
		<form action="lite.php" method="post"><div>
		<fieldset>	<legend>Новая задача</legend>
		<textarea name="text" rows="3" cols="10"></textarea>
		<input type="hidden" name="action" value="newtodo" />
		<input type="submit" value="Сохранить" />
		</fieldset></div></form>
	</div>

	<?php
	$q = "SELECT * FROM todo WHERE status >= 1 AND status <> 200 AND user = '$user[0]' ORDER BY number DESC LIMIT 0,30";
	$r = mysql_query($q) or die(mysql_error($db));
	$numr = mysql_num_rows($r);

	if ($numr != 0) {

		while($row = mysql_fetch_array($r)) {echo '
<div class="todo status-'.$txtstatus[0][$row['status']].'">'.rawurldecode($row['text']).'<div class="controls">
<a href="?action=update&hash='.$row['hash'].'&value=end">готово</a>&nbsp;|
<a href="?action=update&hash='.$row['hash'].'&value=fal">провал</a>&nbsp;|
<a href="?action=update&hash='.$row['hash'].'&value=arh">в&nbsp;архив</a>&nbsp;|
<a href="?action=update&hash='.$row['hash'].'&value=del">удалить</a>
</div>
</div>';}

	} elseif ($q and $numr == 0) {echo '<p>Задачи не найдены.</p>';}
	?>

</div>

<div id="footer">
	<a href="http://todo.yalicprj.net/">todo.yalicprj.net</a>&nbsp;&bull;&nbsp;<?php echo date("Y"); ?>&nbsp;&bull;&nbsp;&copy;
	<a href="mailto:admin@yalicprj.net">Балдуев&nbsp;Илья</a>
</div>

</body>

</html>
