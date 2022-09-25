<?php

header('Content-type:application/json;charset=utf-8');
 
function sanitize_output($buffer)
{
 
$search = array(
'/\>[^\S ]+/s', // strip whitespaces after tags, except space
'/[^\S ]+\</s', // strip whitespaces before tags, except space
'/(\s)+/s', // shorten multiple whitespace sequences
'/<!--(.|\s)*?-->/' // Remove HTML comments
);
 
$replace = array(
'>',
'<',
'\\1',
''
);
 
$buffer = preg_replace($search, $replace, $buffer);
 
return $buffer;
}
 
function post_data($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, br");
    $return = sanitize_output(curl_exec($ch));
    curl_close($ch);
 
    return $return;
}
 
echo post_data("https://www.instagram.com/web/search/topsearch/?query=instagram");
