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