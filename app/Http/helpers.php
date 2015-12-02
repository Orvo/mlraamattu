<?php

function css($styling)
{
	$validated = [];
	
	foreach($styling as $class => $condition)
	{
		if($condition)
		{
			$validated[] = $class;
		}
	}
	
	return implode(' ', $validated);
}