var scl_default_page = '#log';

function displayPage(id)
{
	target = id || window.location.hash || scl_default_page;
	window.location.hash = target;

	$('.container').hide();
	$(target + '-cont').show();
}

$(document).ready(
	function()
	{
		displayPage();
	}
);

