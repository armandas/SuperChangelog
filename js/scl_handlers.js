$('#menu a').click(function()
{
	displayPage(this.hash);
});

$('#is_bug_fix').click(function()
{
	if ($(this).find('input').is(':checked'))
		$(this).find('span').text('Bug Fix');
	else
		$(this).find('span').text('Feature');
});

$('#log-form').submit(function()
{
	if (!$(this).find('input[name=log-prod]:checked'))
		return false;
});

$('.view-btn').click(function()
{
	$('#log-text').text('Loading ' + $(this).attr('data-product') + ' changelog.');
	//$('#log-text').load('scl.php?viewLog=' + $(this).attr('data-product'));
});

$('.release-btn').click(function()
{
	var phText = 'Enter a new version number. Current release is ';

	$('#release-text').attr('placeholder', phText);
	//$(this).attr('data-product')
});
