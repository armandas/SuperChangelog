{$product} CHANGELOG
{function="tpl_underline('=', $product, ' CHANGELOG')"}
{loop="releases"}
{$value.date} Release {$key}
	{loop="value.changes"}
	* {$value}{else}
	No changes have been made in version {$key1}.
	{/loop}
{else}
	No changes to {$product}.
{/loop}
