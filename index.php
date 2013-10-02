<?php require_once "init.php"; ?>
<!doctype html>
<html lang="ru">

<head>
	<meta charset="utf-8" />
	<title>Web ToDo</title>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="jquery.noty.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="tipsy.css" media="screen" />
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="alternate" type="application/rss+xml" href="rss.php?bnVsbA==" title="ToDo RSS" />
	<meta name="keywords" content="web todo list веб список задач html5 css3 jquery rss balduev ilya todo.yalic.pw" />
	<meta name="description" content="Ваш список задач в современном вебприложении — Web ToDo" />
	<meta name="author" content="Балдуев Илья" />
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<style type="text/css">
	.clear {zoom: 1;display: block;}
	body {font-family: "Comic Sans MS" !important;} /*	8-D))) LOL	*/
	</style>
	<![endif]-->
</head>

<header>
<section id="headlinks">
	<a rel="nofollow" href="#" id="auth" title="Войти или зарегистрироваться"><span class="hedic auth">&nbsp;</span>Рег./Вход</a>
	<a rel="nofollow" href="rss.php" id="rss" title="Читать задачи через личную RSS ленту" style="margin-left:20px;">
		<span class="hedic rss">&nbsp;</span>RSS</a>
	<a rel="nofollow" href="lite.php" id="litev" title="Перейти к минималистичной версии" style="margin-left:20px;">
		<span class="hedic mobile">&nbsp;</span>Lite</a>
	<span id="username">&mdash;</span>
	<div id="wait"></div>
</section>

<hgroup>
	<h6 id="wtdinfo" title="Статистика"></h6>
	<h1><a href="http://todo.yalicprj.net/" title="Перейти на главную">Web&nbsp;ToDo</a><span class="version">v&nbsp;1.1.1</span></h1>
	<h2>Всё&nbsp;проще&nbsp;чем&nbsp;кажется</h2>
</hgroup>

<nav>
	<ul id="menu">
		<li><h6>Задачи</h6>
			<ul>
				<li id="todocreate" title="Открыть поле редактирования"><span class="micon todocreate">&nbsp;</span>Создать</li>
				<li id="todosave" title="Сохранить введённую задачу"><span class="micon todosave">&nbsp;</span>Сохранить</li>
				<li id="todoabort" title="Очистить и закрыть поле редактирования"><span class="micon todoabort">&nbsp;</span>Отменить</li>
			</ul>
		</li>
		<li><h6>Вид</h6>
			<ul id="chview">
				<li id="view-std" title="Показать новые, выполняемые и отложенные задачи"><span class="micon vstd">&nbsp;</span>Обычный</li>
				<li id="view-all" title="Показать все имеющиеся задачи"><span class="micon vall">&nbsp;</span>Полный</li>
				<li id="view-new" title="Показать только новые задачи"><span class="micon vnew">&nbsp;</span>Новые</li>
				<li id="view-inc" title="Показать только выполняемые задачи"><span class="micon vinc">&nbsp;</span>В проц.</li>
				<li id="view-end" title="Показать только решённые задачи"><span class="micon vend">&nbsp;</span>Готовые</li>
				<li id="view-out" title="Показать только отложенные задачи"><span class="micon vout">&nbsp;</span>Отложен.</li>
				<li id="view-fal" title="Показать только проваленные задачи"><span class="micon vfal">&nbsp;</span>Провал.</li>
				<li id="view-arh" title="Показать задачи в архиве"><span class="micon varh">&nbsp;</span>Архив</li>
				<li id="view-del" title="Показать только удалённые задачи"><span class="micon vdel">&nbsp;</span>Удалён.</li>
			</ul>
		</li>
		<li><h6>Очистить</h6>
			<ul id="cleartds">
				<li id="clear-del" title="Убрать навсегда удалённые задачи"><span class="micon cleardel">&nbsp;</span>Удалён.</li>
				<li id="clear-end" title="Убрать навсегда решённые задачи"><span class="micon clearend">&nbsp;</span>Завершён.</li>
				<li id="clear-all" title="Убрать удалённые и решённые задачи"><span class="micon clearall">&nbsp;</span>Ненужные</li>
			</ul>
		</li>
		<li><h6>О проекте</h6>
			<ul><li id="info" title="Показать полезную информацию о сайте"><span class="micon info">&nbsp;</span>Информ.</li></ul>
		</li>
	</ul>

	<section id="search">
		<input type="search" id="findbox" name="find" maxlength="64" placeholder="Что ищем?" title="Наберите часть искомой задачи" />
	</section>
</nav>
</header>

<section>
	<div id="newtodo">
		<div id="instrument">
			<input type="date" id="datepicker" value="<?php echo $date ?>" /><button id="insertdate">Вставить дату</button>
		</div>
		<textarea id="newtodotext" maxlength="1024" placeholder="Задача..." required autofocus title="Поле ввода новой задачи"></textarea>
	</div>

	<div id="overlay"></div>
	<div id="user">
		<form action="login.php" method="POST" id="userloginform">
		<input type="text" name="login" id="login" placeholder="Ваш логин" required autofocus title="Ваше имя, на любом языке. От 1 до 32 символов" />
		<input type="password" name="pass" id="pass" placeholder="Ваш пароль" required title="Кодовое слово. От 1 до 32 символов" />
		<input type="submit" id="whoiswho" value="Опознать!" title="Продолжить авторизацию" />
		</form>
	</div>

	<section id="today">&nbsp;</section>
</section>

<section id="main" role="main">
</section>

<footer>
	<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/" style="float:left; opacity:0.5;" rel="nofollow">
		<img alt="Лицензия Creative Commons" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png" title="Лицензия Creative Commons" />
	</a>
	<a rel="nofollow" href="http://metrika.yandex.ru/stat/?id=15883417&amp;from=informer" style="float:right; opacity:0.5;" target="_blank">
		<img src="//bs.yandex.ru/informer/15883417/1_0_FFEC20FF_FFCC00FF_0_pageviews"
		style="width:80px; height:15px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры)"
		onclick="try{Ya.Metrika.informer({i:this,id:15883417,type:0,lang:'ru'});return false}catch(e){}" />
	</a>
	<span>
		<a rel="nofollow" href="http://validator.w3.org/check?uri=http%3A%2F%2Ftodo.yalic.pw%2F" title="Соответствует стандарту HTML5">HTML5&nbsp;Valid</a>
		&bull;&nbsp;<a rel="nofollow" href="http://todo.yalic.pw/" title="Адрес сайта">http://todo.yalic.pw/</a>
		&bull;&nbsp;<?php echo date("Y"); ?> &bull;&nbsp;Идея&nbsp;и&nbsp;реализация:
		<a href="mailto:webmaster@yalic.pw" title="Отправить автору эл.письмо">Балдуев&nbsp;Илья</a>
	</span>
</footer>

<script src="//yandex.st/jquery/1.7.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="jquery-1.7.2.min.js"%3E%3C/script%3E'))</script>
<script src="jquery.timers.js"></script>
<script src="jquery.noty.js"></script>
<script src="jquery.tipsy.js"></script>
<script src="script.js"></script>

</html>
