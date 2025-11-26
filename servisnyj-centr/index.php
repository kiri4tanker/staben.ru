<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Сервисный центр компании Стабильная Энергия 8 (495) 789-49-43.");
$APPLICATION->SetPageProperty("description", "Сервисный центр. Компания Стабильная Энергия — продажа стабилизаторов напряжения, бытовых и промышленных электростанций.  Наш телефон в Москве: +7 (495) 789-49-43.");
$APPLICATION->SetPageProperty("keywords", "Сервисный центр");
$APPLICATION->SetTitle("Сервисный центр");
?>
<div id="content" class="col-sm-9">      
	<p>«Уважаемые покупатели! Вы можете обратиться к нам за помощью в решении сложностей, возникших в процессе приобретения товаров или 
услуг нашего магазина. Оставьте, пожалуйста, заявку в форме обратной связи или обратитесь по указанному телефону.»</p>
	<p><br></p>
	<div id="popup-phone-wrapper" data-toggle="tooltip" data-placement="left" style="margin-left:0px;">
		<span style="background-color: #d20000;
			border: 0 none;
			color: #fff;
			font-family: Roboto Condensed,font-in-site;
			font-size: 14px;
			font-weight: bold;
			padding: 10px 10px;
			text-transform: uppercase;
			width: 110px;">
		<a class="fancybox" style="background-color: #d20000;
			border: 0 none;
			color: #fff;
			font-family: Roboto Condensed,font-in-site;
			font-size: 14px;
			font-weight: bold;
			padding: 10px 10px;
			text-transform: uppercase;
			width: 110px;" onclick="get_revpopup_phone()">Обратная связь</a>
		</span>
	</div>
	<br>
	<h2>Режим работы отдела претензий</h2>
	<p>Время работы по претензиям: Пн.-Пт.: 8.00-17.00</p>
	<p>Консультирование по товарам: Пн.-Вс.: 8.00-20.00</p>
	<br>
	<style>
		.pretentionPageTable th {
			background: #e9e9e9 none repeat scroll 0 0;
			font-size: 15px;
			height: 45px;
			line-height: 18px;
			margin: 0;
			padding: 0 14px;
			text-align: left;
		}
		.pretentionPageTable .col-name {
			width: 282px;
		}
		.pretentionPageTable td {
			border-bottom: 1px solid #d2d2d2;
			font-size: 13px;
			line-height: 17px;
			margin: 0;
			padding: 14px;
			vertical-align: middle;
		}
		.pretentionPageTable {
			border-collapse: collapse;
			margin: 35px 0 0;
			padding: 30px 0 0;
			width: 100%;
		}
	</style>
	<table class="pretentionPageTable">
		<thead> 
		<tr>
			<th class="col-name lh-20">Контактное лицо</th>
			<th class="col-phone">Телефон</th>
			<th class="col-email">Email</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="col-name">Дмитрий</td>
				<td class="col-phone">+7 (495) 789-49-43</td>
				<td class="col-email">zakaz@enstab.ru</td>
			</tr>
		</tbody>
	</table>
	<br>
	<p>«Стабильная Энергия» является авторизованным сервисным центром производителя стабилизаторов Lider. Мы осуществляем 
<a href="/stabilizatory/lider/remont/garant-remont-stab">гарантийный ремонт и техническое обслуживание</a> стабилизаторов марки Lider 
всех типов.»</p>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>