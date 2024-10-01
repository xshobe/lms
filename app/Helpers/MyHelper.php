<?php

function getCustomerName($obj)
{
    return $obj->first_name .' '. $obj->last_name;
}

function getProfileImageUrl($obj)
{
	$url = ($obj->profile_image != '') ? $obj->profile_image : 'public/images/placeholder.jpg';
	return asset($url);
}

function getFormattedDate($date, $format = 'd/m/Y')
{
	if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00')
		return;
	else
		return date_format(date_create($date), $format);
}

function numberFormat($val=NULL, $decimals=2, $dec_point='.', $tSep='')
{
	$val=($val!=NULL) ? $val : 0;
	return @number_format($val, $decimals, $dec_point, $tSep);
}

function pr($value)
{
	echo "<pre>";
	print_r($value);
	echo "</pre>";
}
