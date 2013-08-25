var SCL_GET_PRODUCTS_URL = 'products.json';//'scl.php?getProducts';

var scl_default_page = '#log';
var scl_products;

function displayPage(id)
{
	target = id || window.location.hash || scl_default_page;
	window.location.hash = target;

	$('.page').hide();
	$(target + '-page').show();
}

var createProductMenu = function(products)
{
	return function()
	{
		for (var i in products) {
			var label_class = 'cb-button ' + $(this).attr('data-page') + '-btn';
			var input_type = $(this).attr('data-choice') == 'multiple' ? 'checkbox' : 'radio'

			e1 = $('<label></label>', {'class': label_class, 'data-product': products[i].value});
			e2 = $('<input>', {'type': input_type, 'name': $(this).attr('data-page'), 'value': products[i].value, 'required': ''});
			e3 = $('<span></span>', {'text': products[i].name});

			e1.append(e2, e3);
			$(this).append(e1);
		}

		e4 = $('<span></span>', {'class': 'clear'});
		$(this).append(e4);
	}
}

function processProductList(data)
{
	$('.products').each(createProductMenu(data));
}

$(document).ready(function()
{
	$.getJSON(SCL_GET_PRODUCTS_URL, processProductList);
	displayPage();
});

