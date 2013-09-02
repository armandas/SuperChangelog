var SCL_BACKEND_URL = 'scl.php';
var SCL_GET_PRODUCTS_URL = SCL_BACKEND_URL + '?product_list';
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

function product_isValid(product, page)
{
	switch (page) {
	/* All products are valid for admin page */
	case 'admin':
		return true;

	/* Hide inactive products from all pages (except admin). */
	default:
		if (product.active == '0')
			return false;
	}

	return true;
}

function product_createMenu()
{
	for (var i in scl_products) {
		if (!product_isValid(scl_products[i], $(this).attr('data-page')))
			continue;

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
		var product_span = $('<span></span>', {'text': scl_products[i].name});
		var release_span = $('<span></span>', {
			'text': scl_products[i].release,
			'class': 'cb-release'
		});

		product_span.append(release_span);
		label.append(input, product_span);
		$(this).append(label);
	}

	var span_clear = $('<span></span>', {'class': 'clear'});
	$(this).append(span_clear);
}

function product_processList(data)
{
	scl_products = data;
	$('.products').each(product_createMenu);
}

$(document).ready(function()
{
	$.getJSON(SCL_GET_PRODUCTS_URL, product_processList);
	displayPage();
});
