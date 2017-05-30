
; /* Start:"a:4:{s:4:"full";s:117:"/local/components/vlad/simple.catalog/templates/.default/vlad/simple.catalog.section/.default/script.js?1496070842373";s:6:"source";s:103:"/local/components/vlad/simple.catalog/templates/.default/vlad/simple.catalog.section/.default/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
/**
 * @params JSON
 */
function SimpleSection(parameters)
{
    //var params = parameters.params;
    //this.classCard = params.classCard;
    this.classCard = '._product_card ._inner';


    $(this.classCard).on('mouseenter', function()
        {
            SimpleSection.cardMove();
        }
    )
}

SimpleSection.prototype.cardMove = function()
{
    alert('ddd');
}
/* End */
;; /* /local/components/vlad/simple.catalog/templates/.default/vlad/simple.catalog.section/.default/script.js?1496070842373*/
