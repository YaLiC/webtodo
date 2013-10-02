<?php ?>

<section class="txtinmain">
<p><b>Web&nbsp;ToDo &mdash; вебприложение для организации запланированных дел.</b></p><br/>
<p>Web&nbsp;ToDo, <i>поможет Вам не запутаться в большом количестве запланированных дел. 
Это приложение в первую очередь ориентировано на деловых людей, которые значительную часть своего времени чем либо заняты, 
однако надёжность хранения и лёгкость управления, подойдут практически любому.</i></p><br/>
<p>P.S.: Дела &mdash; это сложно... А с Web ToDo, всё проще чем кажется!</p>
<div class="hrline"></div>
<p><u>Что здесь можно делать:</u><br/>
Создавать новые задачи. Менять статус их выполнения. Удалять в корзину, а затем очищать. 
Редактировать задачи на месте, для этого клините на тексте. Менять вид просмотра. Видеть статитику вверху справа страницы, она обновляется после изменения статуса либо при клике на текст. Искать задачи по ключевой фразе.</p><br/>
<p><u>Как начать пользоваться:</u><br/>Для того, чтобы начать использование, необходимо авторизоваться. 
Сделать это очень просто, нажмите на ссылку Войти вверху страницы, далее наберите ваше имя и пароль, нажмите кнопку Представиться.
При следующем заходе необходимо будет заново повторить эти действия, для того, чтобы приложение Вас узнало.</p>
<div class="hrline"></div>
<details>	<summary><h4>Читать далее...</h4></summary>
<p><u>Форма принятия жалоб и предложений</u></p><br/>
<form action="core.php" method="POST" id="bugform"><input type="hidden" name="action" value="report">
<textarea name="text" placeholder="Жалоба или предложение?" required title="Поле для ввода жалоб и предложений"></textarea>
<input type="submit" value="Отправить!" title="Сообщить автору" />
</form>
<script>
	$("#bugform").submit(function(e){
		e.preventDefault();
		var form_method=$(this).attr("method");
		var form_action=$(this).attr("action");
		var form_data=$(this).serialize();
		$.ajax({
			type: form_method, url: form_action, data: form_data,
			beforeSend:function(){$("#bugform").fadeTo("fast");},
			success: function(){
				$("#bugform textarea").attr("value",""); 
				noty({"text":"Отправлено","type":"success","timeout":500});
			}
		});
	});
</script>
<div class="hrline"></div>
<p class="versionhistory"><u>История версий:</u><br/>
v.1.1.1 &mdash; большое обновление. +lite версия. <br/>
v.1.0.10 &mdash; добавлены баллы, поиск по дате вида &ndash; дата:2012-12-31.<br/>
v.1.0.9 &mdash; добавлен новый статус. изменён дизайн.<br/>
v.1.0.8 &mdash; малозначительные изменения.<br/>
v.1.0.7 &mdash; модернизация кода. улучшен дизайн.<br/>
v.1.0.6 &mdash; значительные внутренние изминения. улучшен дизайн.<br/>
v.1.0.5 &mdash; добавлена форма обратной связи. изменено оформление.<br/>
v.1.0.4 &mdash; модернизация кода и оформления. улучшена логика интерфэйса.<br/>
v.1.0.3 &mdash; исправления в коде и оформлении. поддержка редактирования на месте.<br/>
v.1.0.2 &mdash; задачи сортируются от новых к старым. добавлен пункт Помощь.<br/>
v.1.0.1 &mdash; исправления в оформлении и коде.<br/>
v.1.0.0 &mdash; первая версия, запущеная в открытое бетатестирование.
</p>
<div class="hrline"></div>
<p rel="license"><u>Правовые моменты:</u><br/><i>
Обратите внимаение! Материалы (програмный код и изображения) данного сайта взяты из свободных источников и соответствуют не проеприетарным (платным, закрытым) лицензиям, таким как "Creative Commons", "GNU GPL", "MIT" и подобным.
В то время как, ответственность за контент несёт непосредственно сам пользователь.
Информация размещённая в базе данных данного сайта не передаётся третьим лицам так как является личной тайной конкретного пользователя,
за исключением случаев предусмотренных законодательством той страны к которой относится пользователь.
Так же, автор отмечает, что физически сервера на которых работает данный сайт находятся за пределами границ Российской Федерации,
а доменное имя является международным, следовательно законы РФ на ограничение доступа к информации через Интернет не применимы к данному сайту.
Автор сайта обещает, но не даёт каких либо гарантий, на стабилную и бесперебойную работу данного сайта.
</i></p>
</details>
</section>
<script src="details.js"></script>


