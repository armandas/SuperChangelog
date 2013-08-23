function message_setTypeText()
{
	if ($('#is_bug_fix input').is(':checked'))
		$('#is_bug_fix span').text('Bug fix');
	else
		$('#is_bug_fix span').text('Feature');
}
