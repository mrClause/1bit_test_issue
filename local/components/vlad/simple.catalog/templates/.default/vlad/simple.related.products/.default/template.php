<div class="_relateds col_md-12">
    <div class="col-md-12">
        <h2><?=$arResult['LABEL']?></h2>
    </div>
    <? foreach($arResult['ITEMS'] as $arItem): ?>
        <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
            <div class="_rel_card col-md-3">
                <div class="_picture" style="background-image: url(<?=$arItem['PREVIEW_PICTURE']['src']?>)"></div>
                <div class="name">
                    <?=$arItem['NAME']?>
                </div>
            </div>
        </a>
    <? endforeach; ?>
</div>
