<?php

function fetchUrl($url, array $params = array(), $method = 'GET', $customOptions = array()) {

	$options = array(
		CURLOPT_RETURNTRANSFER	=> true,	// return web page
		CURLOPT_HEADER			=> false,	// don't return headers
		CURLOPT_FOLLOWLOCATION	=> true,	// follow redirects
		CURLOPT_ENCODING		=> '',		// handle all encodings
		CURLOPT_USERAGENT		=> 'Mozilla/4.0 (compatible; MSIE 6.0; Windows XP;)',		// who am i
		CURLOPT_AUTOREFERER		=> true,	// set referer on redirect
		CURLOPT_CONNECTTIMEOUT	=> 15,		// timeout on connect
		CURLOPT_TIMEOUT			=> 20,		// timeout on response
		CURLOPT_MAXREDIRS		=> 7,		// stop after 10 redirects
		CURLOPT_SSL_VERIFYPEER	=> FALSE,
		CURLOPT_SSL_VERIFYHOST	=> 2,
	);

	foreach ($customOptions as $customOption => $customVal)
		$options[$customOption] = $customVal;

	if (strtoupper($method) == 'POST') {
		$options[CURLOPT_POST] = 1;
		$options[CURLOPT_POSTFIELDS] = http_build_query($params);
	} elseif (!empty($params)) {
		$url = $url.'?'.http_build_query($params);
	}

	$ch = curl_init($url);
	curl_setopt_array($ch, $options);
	$content = curl_exec($ch);
	$err = curl_errno($ch);
	$errmsg = curl_error($ch);
	$header = curl_getinfo($ch);
	curl_close($ch);

	$header['errno'] = $err;
	$header['errmsg'] = $errmsg;
	$header['content'] = $content;

	return $header['content'];
}


function html_header($title = '') {
	require TPL.'header.php';
}

function html_footer() {
	require TPL.'footer.php';
}

