<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>

<?
$APPLICATION->IncludeComponent(
	"vlad:simple.catalog", 
	".default", 
	array(
		"SEF_MODE" => "Y",
        "SEF_FOLDER" => "/catalog/",
        "SEF_URL_TEMPLATES" => array(
            "sections" => "index.php",
            "section" => "#SECTION_CODE#/",
            "element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
        ),
        "SEF_VARIABLES" => array( // Необходимо для вызова титульной страницы каталога
        	'section' => 'SECTION_CODE',
			'element' => 'ELEMENT_CODE',
		),
        "IBLOCK_ID" => 1, // ID инфоблока
		"FILTER" => array( // Базовый фильтр для секции
			"IBLOCK_ID" => 1,
		),
		"ORDER" => array("ID" => "DESC"), // Направление сортировки в секции
		"LIMIT" => 20, // Выводить n-количество элементов
		"FIELD_TO_SECTION" => array( // Выбирать следующие поля для страницы секции
			'ID', 'IBLOCK_ID', 'NAME', 'CODE', 'IBLOCK_SECTION', "PREVIEW_TEXT", "PREVIEW_PICTURE"
		),
        "FIELD_TO_DETAIL" => array( // Выбирать следующие поля элемента для страницы детального просмотра
            'ID', 'IBLOCK_ID', 'NAME', 'CODE', 'IBLOCK_SECTION', "DETAIL_TEXT", "DETAIL_PICTURE"
        ),
		"RELATED_PROPERTY_IDS" => array( // Какие свойства использовать для связанных товаров
			0 => array('ID' => 4, 'LABEL' => 'С этими рыбками живут:'),
			1 => array('ID' => 5, 'LABEL' => 'Похожие рыбки:'),
		),
        "PAGE_404" => '/404.php',
	),
	true
);
?>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>