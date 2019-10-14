<?php

function generateMDGUID() {
	$theMDGUID = "";
	if(function_exists("com_create_guid") === true) { $theMDGUID = md5(time()) . "-" . trim(com_create_guid(), "{}"); }
	$data = openssl_random_pseudo_bytes(16);
	$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
	$data[8] = chr(ord($data[8]) & 0x3f | 0x80);
	$theMDGUID = md5(time()) . "-" . vsprintf("%s%s-%s-%s-%s-%s%s%s", str_split(bin2hex($data), 4));
	return $theMDGUID;
}