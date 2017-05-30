<? use Bitrix\Main\Page\Asset; ?>

<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/libs/bootstrap/css/bootstrap.min.css"); ?>
    <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/libs/fancybox/fancybox.min.css"); ?>
    <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/libs/jquery/jquery.min.js"); ?>
    <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/libs/fancybox/fancybox.min.js"); ?>
    <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/scripts/custom.js"); ?>
<?$APPLICATION->ShowHead()?>
<title><?$APPLICATION->ShowTitle()?></title>
</head>

<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<div class="container-fluid">
    <div class="row">
        <div id="header" class="col-md-12">
          <div id="header_text">
            Здесь какой-то хедер
          </div>

            <a href="/" title="Главная" id="company_logo"></a>

        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div id="lef_menu" class="col-md-2">
            <?$APPLICATION->IncludeComponent("bitrix:menu",".default",Array(
                    "ROOT_MENU_TYPE" => "left",
                    "MAX_LEVEL" => "1",
                    "USE_EXT" => "N",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => ""
                )
            );?>
        </div>
        <div class="_inner col-md-10">
        <div class="col-md-12">
            <h1 id="pagetitle"><?$APPLICATION->ShowTitle(false)?></h1>
        </div>

