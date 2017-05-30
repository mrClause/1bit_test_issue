
; /* Start:"a:4:{s:4:"full";s:117:"/local/components/vlad/simple.catalog/templates/.default/vlad/simple.catalog.section/.default/script.js?1496069950307";s:6:"source";s:103:"/local/components/vlad/simple.catalog/templates/.default/vlad/simple.catalog.section/.default/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
/**
 * @params JSON
 */
var SimpleSection = function(params)
{
    //this.classCard = params.classCard;
    this.classCard = '._product_card ._inner';
}

SimpleSection.prototype.mouseMove = function(e)
{
    $(this.classCard).on('mouseenter', function()
        {
            alert('ddd');
        }
    )
}
/* End */
;; /* /local/components/vlad/simple.catalog/templates/.default/vlad/simple.catalog.section/.default/script.js?1496069950307*/
