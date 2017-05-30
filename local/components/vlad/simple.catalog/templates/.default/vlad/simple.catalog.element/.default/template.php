<div id="product" class="col-md-12">
    <div class="col-md-5">
        <a class="link_product_image" href="<?=$arResult['DETAIL_PICTURE']['FULL_LINK']?>">
        <div class="_detail_image col-md-12" style="background-image: url(<?=$arResult['DETAIL_PICTURE']['src']?>)">
            <div class="_sku">
                <?=$arResult['PROPERTY']['SKU']['VALUE']?>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-7">
        <?/*<div class="_label">
            <?=$arResult['NAME']?>
        </div>*/?>
        <div class="_properties col-md-12">
            <div class="col-md-6">
                <span class="_bold"><?=$arResult['PROPERTY']['WATER']['NAME']?></span> -
                <?=$arResult['PROPERTY']['WATER']['VALUE_ENUM']?>
            </div>
            <div class="col-md-6 _product_price">
                <span class="_bold"><?=$arResult['PROPERTY']['PRICE']['NAME']?></span> -
                <?=$arResult['PROPERTY']['PRICE']['VALUE']?>
            </div>
        </div>
        <div class="_description col-md-12">
            <?=$arResult['DETAIL_TEXT']?>
        </div>

    </div>
</div>



