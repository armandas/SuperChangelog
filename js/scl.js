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
		if ($(this).attr('data-choice') == 'multiple') {
			var input_type = 'checkbox';
			var input_name = $(this).attr('data-page') + '[]';
		}
		else {
			var input_type = 'radio';
			var input_name = $(this).attr('data-page');
		}

		var label = $('<label></label>', {'class': 'cb-button'});
		var input = $('<input>', {
			'type': input_type,
			'name': input_name,
			'value': scl_products[i].id
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

