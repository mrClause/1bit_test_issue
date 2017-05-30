<?
if(count($arResult['ITEMS']) == 0)
{
    echo GetMessage("EMPTY_SECTION");
    return false;
}?>

<div id="catalog_wrapper" class="col-md-12">
    <? foreach ($arResult['ITEMS'] as $arItem): ?>
        <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
        <div id="product_<?=$arItem["ID"]?>" class="col-md-3 _product_card">
            <div class="_inner col-md-12">
                <div class="col-md-12 _picture" style="background-image: url(<?=$arItem['PREVIEW_PICTURE']['src']?>);">
                    <div class="_article text-right pull-right">
                        <?=$arItem['PROPERTY']['SKU']['VALUE']?>
                    </div>
                </div>
                <div class="col-md-12 _label">
                    <span><?=$arItem['NAME']?></span>
                </div>
                <div class="col-md-12 _short_description">
                    <?=$arItem['PREVIEW_TEXT']?>
                </div>
            </div>
        </div>
        </a>
    <? endforeach; ?>
</div>

<script type="text/javascript">
    new SimpleSection({params: {classCard: '._inner'}});
</script>