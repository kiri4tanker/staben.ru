<? if (filter_input(INPUT_GET, "key") != "nw0wnbvpwnpjj4s0i--04w333")
    die(403); ?>
<pre>
<?
// require_once $_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php";

// use Bitrix\Main\Loader;
// Loader::includeModule("main");
// Loader::includeModule("iblock");
// Loader::includeModule("catalog");


// $step = (int) filter_input(INPUT_GET, "step") ?: 0;
// $tpl = "/dist/desc_";
// $filename = __DIR__ . $tpl . ($step ? $step : "0") . ".json";
// if (($step * 1) > 200 || !file_exists($filename)) {
//     die(400); 
// }
// $batch = json_decode(file_get_contents($filename), true);
// $batchLength = count($batch);
// $descMap = [];
// for ($i = 0; $i < $batchLength; $i++) {
//     $descMap[$batch[$i]["CODE"]] = htmlspecialchars_decode($batch[$i]["DETAIL_TEXT"]);
// }
// $codes = array_keys($descMap);
// $arElements = CIBlockElement::GetList(["ID" => "ASC"], ["IBLOCK_ID" => 38, "CODE" => $codes], null, null, ["CODE", "ID"]);
// $upd = [];
// $elemObj = new CIBlockElement();
// while ($elem = $arElements->Fetch()) {
//     $text = $descMap[$elem["CODE"]];
//     if ($text) {
//         $elemObj->Update(
//             $elem["ID"],
//             [
//                 "DETAIL_TEXT" => $text,
//                 "DETAIL_TEXT_TYPE" => "html"
//             ]
//         );
//     }

// }
// LocalRedirect('?key=nw0wnbvpwnpjj4s0i--04w333&step=' . ($step + 1 ));
?></pre>