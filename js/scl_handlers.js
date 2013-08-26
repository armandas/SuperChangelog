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

$('#log-form').on('submit', function()
{
	if (!$(this).find('input[name=log-prod]:checked'))
		return false;
});

$('.products').on('change', 'input[name=download]', function()
{
	$('#log-text').load(SCL_GET_CHANGELOG_URL + '?view=' + $(this).val());
});

$('.products').on('change', 'input[name=release]', function()
{
	var phText = 'Enter a new version number.';

	for (var i in scl_products) {
		if (scl_products[i].value == $(this).val())
			phText += ' Current release is ' + scl_products[i].release;
	}

	$('#release-text').attr('placeholder', phText);
});

