
; /* Start:"a:4:{s:4:"full";s:117:"/local/components/vlad/simple.catalog/templates/.default/vlad/simple.catalog.section/.default/script.js?1496070155332";s:6:"source";s:103:"/local/components/vlad/simple.catalog/templates/.default/vlad/simple.catalog.section/.default/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
/**
 * @params JSON
 */
var SimpleSection = function(params)
{
    //this.classCard = params.classCard;
    this.classCard = '._product_card ._inner';

    $(this.classCard).on('mouseenter', function()
        {
           this.mouseMove();
        }
    )
}

var SimpleSection.prototype.mouseMove = function()
{
    alert('ddd');
}
/* End */
;; /* /local/components/vlad/simple.catalog/templates/.default/vlad/simple.catalog.section/.default/script.js?1496070155332*/