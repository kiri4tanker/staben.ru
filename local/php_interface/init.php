<?
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
$tester_id = 1;
//Функции для отладки
function add2log($ob)
{
  if (!defined(LOG_FILENAME))
    define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
  if (is_array($ob))
  {
		AddMessage2Log(print_r($ob,true));
  }
  else
    AddMessage2Log($ob);
}
function prf($ob, $for = "t") //$for = t - только для пользователя с заданным ID (умолч.), = a - для всех
{
  global $tester_id;
  if ($for !== 'a')
  {
    global $USER;
    if ($USER->GetID()!=$tester_id)
      return false;
  }
  if (is_array($ob))
  {
    echo '<pre>';
    print_r($ob);
    echo '</pre>';
  }
  else
    echo $ob;             
}

// AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "OnAfterIBlockElementAddHandler");
// AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementAddHandler");

function OnAfterIBlockElementAddHandler($arFields)
{
	if($arFields["ID"]>0 && $arFields["IBLOCK_ID"] == 26)
	{
		add2log($arFields);
		if($arFields["DETAIL_PICTURE_ID"])
		{
			// Загружали новую картинку
			if($arFields["NAME"])
			{
				$arParams = array("replace_space"=>"-","replace_other"=>"-", "change_case" => "L");
				$trans = Cutil::translit($arFields["NAME"],"ru",$arParams);
				// renameFileDBbyID($arFields["DETAIL_PICTURE_ID"], $trans);
			}
			else
				add2log('no code');

		}
		// AddMessage2Log("Запись с кодом ".$arFields["ID"]." добавлена.");
	}
}

// function renameFileDBbyID($id, $newName = null){
//     $connection = Bitrix\Main\Application::getConnection();
    
//     $sql = "SELECT * FROM b_file WHERE ID = $id";
//     $recordset = $connection->query($sql);
//     if ($record = $recordset->fetch())
//     {
//         if(!preg_match('/-/', $record['FILE_NAME'])) {
//             if (preg_match('/.png/', $record['FILE_NAME']))
//                 $newName = $newName.'.png';
//             else
//                 $newName = $newName.'.jpg';

//             renameFile($id, $newName);

//             $connection->queryExecute("UPDATE b_file SET FILE_NAME = '$newName' WHERE ID = $id ");
//         }
//     }
// }
// function renameFile($id, $newName = null){
//     $fileArr = CFile::GetFileArray($id);
//     $path = '/upload/'.$fileArr['SUBDIR'].'/'.$fileArr['FILE_NAME'];
//     $newPath = '/upload/'.$fileArr['SUBDIR'].'/'.$newName;

//     $file = new \Bitrix\Main\IO\File(\Bitrix\Main\Application::getDocumentRoot().$path);
//     $file->rename(\Bitrix\Main\Application::getDocumentRoot().$newPath);

// }


// автозагрузка класса
CModule::AddAutoloadClasses(
    '', // не указываем имя модуля
    array(
        // ключ - имя класса с простанством имен, значение - путь относительно корня сайта к файлу
        'img\DeleteImgClass' => '/local/php_interface/DeleteImgClass.php',
    )
);
// функция для агента
function deleteImgClass() {
    //$deleteAmg = new img\DeleteImgClass();
    return "deleteImgClass();";
}