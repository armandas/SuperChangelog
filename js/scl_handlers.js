$(document).ready(function()
{
	$('#menu a').on('click', function()
	{
		displayPage(this.hash);
	});

	$('form:has(.products)').not(':novalidate').on('submit', function()
	{
		if ($(this).find('input:checked').length == 0) {
			$(this).find('.products').addClass('error');
			return false;
		}
	});

	$('.products').on('change', 'input', function()
	{
		$(this).parents('.products').removeClass('error');
	});

	$('.products').on('change', 'input[name=download]', function()
	{
		$.ajax({
			url: SCL_BACKEND_URL,
			type: 'post',
			dataType: 'text',
			data: {
				'download': $(this).val(),
				'view': 1
			},
			success: function(data) {
				$('#log-text').text(data);
			},
			error: function(xhr, statusMsg, errorMsg) {
				$('#log-text').text('AJAX Error.');
			}
		});
	});

	$('.products').on('change', 'input[name=release]', function()
	{
		var phText = 'Enter a new version number.';

		for (var i in scl_products) {
			if (scl_products[i].id == $(this).val())
				phText += ' Current release is ' + scl_products[i].release;
		}

		$('#release-text').attr('placeholder', phText);
	});

	$('#footer').on('dblclick', function()
	{
		displayPage('#admin');
		document.getSelection().removeAllRanges();
	});
});
