var SCL_GET_PRODUCTS_URL = 'scl.php?product_list';
var SCL_GET_CHANGELOG_URL = 'log.txt';//'scl.php;
var SCL_DEFAULT_PAGE = '#log';
var SCL_PAGE_LIST = ['#log', '#download', '#release', '#admin']

var scl_products;

function displayPage(id)
{
	target = id || window.location.hash || SCL_DEFAULT_PAGE;

	if ($.inArray(target, SCL_PAGE_LIST) < 0)
		target = SCL_DEFAULT_PAGE;

	window.location.hash = target;

	$('.page').hide();
	$(target + '-page').show();
}

function createProductMenu()
{
	for (var i in scl_products) {
		if (scl_products[i].active == '0') {
			if ($(this).attr('data-page') != 'admin')
				continue;
		}

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
			'value': scl_products[i].id,
			'checked': (scl_products[i].active == '0')
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

