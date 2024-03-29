<?php

#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300);

error_reporting(E_ALL);

///////////////////////////////////////////////////////////////////////
define('OAUTH2_CLIENT_ID', OAUTH2_CLIENT_ID);                                                                        #
define('OAUTH2_CLIENT_SECRET', OAUTH2_CLIENT_SECRET);                 # Replace with values from the Discord Developer Page
define('OAUTH_REDIRECT_URI', OAUTH_REDIRECT_URI);                     #
///////////////////////////////////////////////////////////////////////



$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';
$revokeURL = 'https://discordapp.com/api/oauth2/token/revoke';
$imageURL = 'https://cdn.discordapp.com/avatars/';

function apiRequest($url, $post=FALSE, $headers=array()) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  
    $response = curl_exec($ch);
  
  
if($post)
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  
  $headers[] = 'Accept: application/json';
  
  if(session('access_token'))
    $headers[] = 'Authorization: Bearer ' . session('access_token');
  
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
    $response = curl_exec($ch);
    return json_decode($response);
}
  
  function get($key, $default=NULL) {
    return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}
  
  function session($key, $default=NULL) {
    return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}

  /*

  Important:

    $user = apiRequest($apiURLBase);


  */
?>