var SCL_GET_PRODUCTS_URL = 'scl.php?product_list';
var SCL_GET_CHANGELOG_URL = 'log.txt';//'scl.php;

var scl_default_page = '#log';
var scl_products;

function displayPage(id)
{
	target = id || window.location.hash || scl_default_page;
	window.location.hash = target;

	$('.page').hide();
	$(target + '-page').show();
}

function createProductMenu()
{
	for (var i in scl_products) {
		var input_type = $(this).attr('data-choice') == 'multiple' ? 'checkbox' : 'radio'

		var label = $('<label></label>', {'class': 'cb-button'});
		var input = $('<input>', {
			'type': input_type,
			'name': $(this).attr('data-page'),
			'value': scl_products[i].value
		});
		var span = $('<span></span>', {'text': scl_products[i].name});

		label.append(input, span);
		$(this).append(label);
	}

	var span_clear = $('<span></span>', {'class': 'clear'});
	$(this).append(span_clear);
}

function processProductList(data)
{
	scl_products = data;
	$('.products').each(createProductMenu);
}

$(document).ready(function()
{
	$.getJSON(SCL_GET_PRODUCTS_URL, processProductList);
	displayPage();
});

