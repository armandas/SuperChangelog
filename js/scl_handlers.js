$(document).ready(function()
{
	$('#menu a').on('click', function()
	{
		displayPage(this.hash);
	});

	$('input[name=is_bug_fix]').on('change', function()
	{
		if ($(this).is(':checked'))
			$(this).siblings('span').text('Bug Fix');
		else
			$(this).siblings('span').text('Feature');
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
		$('#log-text').load(SCL_GET_CHANGELOG_URL + '?view=' + $(this).val());
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
