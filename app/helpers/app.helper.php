<?php

// return a formatted string to show in the meta title
function browserTitle($title='')
{
	$app_title = Config::get('site.title');
	return !empty($title) ? $title . ' - ' . $app_title : $app_title;
}