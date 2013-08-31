{$product} CHANGELOG
{function="tpl_underline('=', $product, ' CHANGELOG')"}
{loop="releases"}
{$value.date} Release {$value.version}
	{loop="value.changes"}
	* {$value}{else}
	No changes have been made in version {$value1.version}.
	{/loop}
{else}
	No changes for {$product}.
{/loop}
