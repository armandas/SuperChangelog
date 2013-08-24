var scl_default_page = 'add_log_message';

$(
	function()
	{
		$('.container').not('#' + scl_default_page).hide();
	}
);

function showContainer(id)
{
	$('.container').not('#' + id).hide();
	$('#' + id).show();
}

function message_setTypeText()
{
	if ($('#is_bug_fix input').is(':checked'))
		$('#is_bug_fix span').text('Bug Fix');
	else
		$('#is_bug_fix span').text('Feature');
}
