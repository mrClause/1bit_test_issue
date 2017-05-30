<?
/**
 * Вызов компонента элемент детально
 */
$APPLICATION->IncludeComponent(
    'vlad:simple.catalog.element',
    '',
    array(
        'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
        'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
        'FIELD_TO_DETAIL' => $arResult['FIELD_TO_DETAIL'],
        "PAGE_404" => $arResult["PAGE_404"],
    ),
    $component
);
?>



<?
/**
 * Вызов компонента связанных товаров
 */
/**
 * Генерируем компоненты исходя из массива RELATED_PROPERTY_IDS в вызове компонента в index.php
 */
for($i = 0; $i < count($arResult['RELATED_PROPERTY_IDS']); $i++ )
{
    $APPLICATION->IncludeComponent(
        'vlad:simple.related.products',
        '',
        array(
            'COMPONENT_LABEL' => $arResult['RELATED_PROPERTY_IDS'][$i]['LABEL'],
            'IBLOCK_ID' => $arResult['IBLOCK_ID'],
            'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
            'PROPERTY_ID' => $arResult['RELATED_PROPERTY_IDS'][$i]["ID"],
        ),
        $component
    );
}
?>
