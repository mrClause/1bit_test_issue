<?
use \Bitrix\Main\Loader as Loader;
Loader::includeModule('iblock');

$dbSection = CIBlockSection::GetList();

while ($section = $dbSection->GetNext())
{
    $aMenuLinks[] = array($section['NAME'], $section["SECTION_PAGE_URL"], array(), array());
}
?>