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

function findByProperty($haystack, $key, $value)
{
	foreach($haystack as $object)
	{
		if(@$object->{$key} == $value)
		{
			return $object;
		}
	}
	
	return false;
}

function alt($text, $alt_text)
{
	return strlen(trim($text)) > 0 ? $text : $alt_text;
}