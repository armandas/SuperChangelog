$('#menu a').click(
	function()
	{
		displayPage(this.hash);
	}
);



$('#is_bug_fix').click(
	function()
	{
		if ($(this).find('input').is(':checked'))
			$(this).find('span').text('Bug Fix');
		else
			$(this).find('span').text('Feature');
	}
);
