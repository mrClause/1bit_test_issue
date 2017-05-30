<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$arComponentParameters = array(
    "PARAMETERS" => array(
        "SEF_MODE" => Array(
            "sections" => array(
                "NAME" => GetMessage("SECTIONS_SEF_DESCRIPTION"),
                "DEFAULT" => "/",
                "VARIABLES" => array(),
            ),
            "section" => array(
                "NAME" => GetMessage("SECTION_SEF_DESCRIPTION"),
                "DEFAULT" => "#SECTION_CODE#/",
                "VARIABLES" => array("SECTION_CODE"),
            ),
            "element" => array(
                "NAME" => GetMessage("ELEMENT_SEF_DESCRIPTION"),
                "DEFAULT" => "#SECTION_CODE#/#ELEMENT_CODE#",
                "VARIABLES" => array("SECTION_CODE", "ELEMENT_CODE"),
            ),
        ),
    ),
);
?>