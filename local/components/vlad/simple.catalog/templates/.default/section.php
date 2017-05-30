<?
/**
 * Вызов компонента секции
 */
$APPLICATION->IncludeComponent(
    'vlad:simple.catalog.section',
    '',
    array(
        "SEF_FOLDER" => $arResult["FOLDER"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "FILTER" => $arResult["FILTER"],
        "ORDER" => $arResult["ORDER"],
        "LIMIT" => $arResult["LIMIT"],
        "FIELD_TO_SECTION" => $arResult["FIELD_TO_SECTION"],
        "URL_TEMPLATES" => $arResult["URL_TEMPLATES"],
        "URL_VARIABLES" => $arResult["VARIABLES"],
        "PAGE_404" => $arResult["PAGE_404"],
    ),
    $component);
?>