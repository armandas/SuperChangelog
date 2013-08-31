<?php

/*
 * Functions for use in your template can be added below.
 */



/*
 * Function for generating a line of $chr characters,
 * which is equal in length to the sum of lengths of
 * of all $word arguments.
 *
 * Usage:	tpl_underline('=', $word1, $word2, $word3_etc);
 */
function tpl_underline()
{
	$argc = func_num_args();

	if ($argc < 2) {
		return "* Incorrect usage of function tpl_underline() *";
	}

	$argv = func_get_args();

	return str_repeat($argv[0], strlen(implode('', array_slice($argv, 1))));
}

?>
