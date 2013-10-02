<?php

require_once "login.php";

if ($action == "newtodo" and $text != "") {
	$hash = md5("добавим немножко соли, что бы вкусно было".$text.$date.$time.$user[3]);
	$rfrom = array('\n',"сегодня");
	$repto = array("<br/>",$date);
	$text = str_replace($rfrom,$repto, $text);
	$q = "INSERT INTO todo (hash, date, time, status, text, user, created) VALUES ('$hash', '$date', '$time', '1', '$text', '$user[0]', '$datetime');";
}

if ($action == "updatetodo" and $hash and $text != "") {
	$q = "UPDATE todo SET date='$date', time='$time', text='$text' WHERE hash='$hash' ";
}

if ($action == "report" and $text != "") {
	$text .= '<br/>от '.rawurldecode($user[1]).'</small>';
	$hash = md5($text);
	$q = "INSERT INTO todo (hash, date, time, status, text, user, created) VALUES ('$hash', '$date', '$time', '1', '$text', '1', '$datetime');";
}

if ($action == "update" and $hash and $value) {
	switch($value) {
		case "del": $status = 0; break;
		case "new": $status = 1; break;
		case "inc": $status = 2; break;
		case "end": $status = 3; break;
		case "out": $status = 4; break;
		case "fal": $status = 5; break;
		case "arh": $status = 200; break;
		default: $status = 1;
	}
	$q = "UPDATE todo SET status='$status', date='$date', time='$time' WHERE hash='$hash' ";
}

if ($action == "erase" and $value) {
	switch($value) {
		case "del": $q = "DELETE FROM todo WHERE status = 0 AND user = '$user[0]'"; break;
		case "end": $q = "DELETE FROM todo WHERE status = 3 AND user = '$user[0]'"; break;
		case "all": $q = "DELETE FROM todo WHERE status = 0 AND user = '$user[0]' OR status = 3 AND user = '$user[0]'"; break;
		default: $q = false;
	}
	if ($user[0] == 1 and $value == "all") {$q = "DELETE FROM todo WHERE status = 0 OR status = 3";}
}

if ($q) {$r = mysql_query($q) or die(mysql_error($db)); $q = false;}


if ($action == "view" and $value) {
	switch ($value) {
		case "del": $status = 0; break;
		case "new": $status = 1; break;
		case "inc": $status = 2; break;
		case "end": $status = 3; break;
		case "out": $status = 4; break;
		case "fal": $status = 5; break;
		case "arh": $status = 200; break;
		default: $status = 1;
	}
	if ($value == "std") {$q = "SELECT * FROM todo WHERE status >= 1 AND status <> 3 AND status <> 5 AND status <> 200 AND user = '$user[0]' ORDER BY number DESC LIMIT 0,100";
	} elseif ($value == "all") {
		if ($user[0] == 1) {$q = "SELECT * FROM todo ORDER BY number DESC,user ASC";}
		else {$q = "SELECT * FROM todo WHERE status <> 200 AND user = '$user[0]' ORDER BY number DESC";}
	} else {$q = "SELECT * FROM todo WHERE status = '$status' AND user = '$user[0]' ORDER BY number DESC";}
} 

if ($action == "search" and $find) {
	if (substr($find,0,9) == "дата:") {
		$q = "SELECT * FROM todo WHERE created LIKE '%".substr($find,9)."%' AND user = '$user[0]' ORDER BY number DESC";
	} else {
		$q = "SELECT * FROM todo WHERE text LIKE '%".$find."%' AND user = '$user[0]' ORDER BY number DESC";
	}
}


if ($q) {
	$r = mysql_query($q) or die(mysql_error($db));
	$numr = mysql_num_rows($r);
}

if ($q and $numr != 0) {
	echo '<ul class="todo">';
	while($row = mysql_fetch_array($r)) {echo '
<li class="todo status-'.$txtstatus[0][$row['status']].'" id="'.$row['hash'].'">
	<div class="todohead">
		<div class="mst">
			<span class="status">'.$txtstatus[1][$row['status']].'</span>
			<span class="hiic">
				<span class="mstic vnew" data-chstto="new" title="В новое">&nbsp;</span>
				<span class="mstic vinc" data-chstto="inc" title="Выполнять">&nbsp;</span>
				<span class="mstic vend" data-chstto="end" title="Готово">&nbsp;</span>
				<span class="mstic vout" data-chstto="out" title="Отложить">&nbsp;</span>
				<span class="mstic vfal" data-chstto="fal" title="Провалено">&nbsp;</span>
				<span class="mstic varh" data-chstto="arh" title="В архив">&nbsp;</span>
			</span>
		</div>
	<div class="link"><a href="core.php?action=gettodo&hash='.$row['hash'].'" title="Постоянная ссылка">#'.$row['number'].'</a></div>
	<div class="datetime" title="Время создания/изменения">'.$row['created'].'<span class="datech">&nbsp;/&nbsp;'.$row['date'].'&nbsp;'.$row['time'].'</span></div>
';
	if ($row['status'] != 0) echo '<div class="deltodo" title="Удалить в корзину"></div><div class="saveedit" title="Применить изменения"></div>'; 
	echo '</div>
	<section class="todocontent">'.rawurldecode($row['text']).'</section>
</li>';}
	echo '</ul>';
} elseif ($q and $numr == 0) {echo '<div style="margin:20px; color:#f33;">Задачи запрошенного типа не найдены. Попробуйте изменить вид или создайте новую задачу.</div>';}

if ($action == "gettodo" and $hash) {
	$q = "SELECT * FROM todo WHERE hash='$hash'";
	$r = mysql_query($q) or die(mysql_error($db));
	$todo = mysql_fetch_row($r);
	header("Content-type: text/plain; charset=utf-8");

	echo rawurldecode($todo[5]);
}

if ($ajax == "script") {
	echo "<script>
$('#username').html('".rawurldecode($user[1])."');
$('link[rel=alternate]').attr('href','rss.php?".base64_encode($user[3])."');
$('a#rss').attr('href','rss.php?".base64_encode($user[3])."');

</script>";
}

if ($ajax == "wtdinfo") {
	$score = array();
	$score['all'] = mysql_num_rows(mysql_query("SELECT * FROM todo WHERE user = '".$user[0]."'"));
	$score['del'] = mysql_num_rows(mysql_query("SELECT * FROM todo WHERE status = 0 AND user = '".$user[0]."'"));
	$score['new'] = mysql_num_rows(mysql_query("SELECT * FROM todo WHERE status = 1 AND user = '".$user[0]."'"));
	$score['inc'] = mysql_num_rows(mysql_query("SELECT * FROM todo WHERE status = 2 AND user = '".$user[0]."'"));
	$score['end'] = mysql_num_rows(mysql_query("SELECT * FROM todo WHERE status = 3 AND user = '".$user[0]."'"));
	$score['out'] = mysql_num_rows(mysql_query("SELECT * FROM todo WHERE status = 4 AND user = '".$user[0]."'"));
	$score['fal'] = mysql_num_rows(mysql_query("SELECT * FROM todo WHERE status = 5 AND user = '".$user[0]."'"));
	$score['weight'] = ($score['all']) + ($score['inc']*0.5) + ($score['out']*0.3) + ($score['fal']*0.1) + ($score['end']*1.5);
	$wtdinfo = '<div id="statistic" data-all="'.$score['all'].'">'.$score['all'].'&nbsp;&mdash;&nbsp;задач<br/>';
	$wtdinfo .= $score['new'].'&nbsp;&mdash;&nbsp;новых<br/>';
	$wtdinfo .= $score['end'].'&nbsp;&mdash;&nbsp;решено<br/>';
	$wtdinfo .= $score['del'].'&nbsp;&mdash;&nbsp;удалено</br>';
	$wtdinfo .= $score['weight'].'&nbsp;&mdash;&nbsp;балл</div>';
	echo $wtdinfo;
}

if ($ajax == "todayinfo") {
	$todayinfo = array();
	$todayinfo['n'] = mysql_num_rows(mysql_query("SELECT * FROM todo WHERE text LIKE '%".$date."%' AND user = '".$user[0]."' "));
	$todayinfo['text'] = 'Сегодня: '.$date.'. Намеченных задач &mdash; '.$todayinfo['n'];
	echo $todayinfo['text'];
}

?>
