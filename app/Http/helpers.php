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

function abort_unauthorized($user_id_compare = null)
{
	$user = \Auth::user();
	if(!$user->isAdmin() && $user->canAccessAjax())
	{
		if(!is_null($user_id_compare) && $user->id == $user_id_compare)
		{
			return false;
		}
	}
	
	if($user->isAdmin())
	{
		return false;
	}
	
	// throw new \Exception("Unauthorized Ajax Request", 1337);
	abort(401, "Unauthorized");
}

function resource_url($url)
{
	$na_url = $url[0] == '/' ? substr($url, 1) : $url;
	return $url . '?v=' . filemtime($na_url);
}