<?php
require "../inc/discord.inc.php";

session_start();

// Start the login process by sending the user to Discord's authorization page
if(get('action') == 'login') {

  $params = array(
    'client_id' => OAUTH2_CLIENT_ID,
    'redirect_uri' => 'http://enti.ddns.net:8099/api/handling/discord_login.php?discord=true', # 'http://dev-base.dd:8099/api/handling/discord_login.php?discord=true
    'response_type' => 'code',
    'scope' => 'identify email',
  );

  // Redirect the user to Discord's authorization page
  header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params));
  die();
}


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if(get('code')) {

  // Exchange the auth code for a token
  $token = apiRequest($tokenURL, array(
    "grant_type" => "authorization_code",
    'client_id' => OAUTH2_CLIENT_ID,
    'client_secret' => OAUTH2_CLIENT_SECRET,
    'redirect_uri' => 'http://enti.ddns.net:8099/api/handling/discord_login.php?discord=true', # http://dev-base.dd:8099/api/handling/discord_login.php?discord=true
    'code' => get('code')
  ));
  $logout_token = $token->access_token;
  $_SESSION['access_token'] = $token->access_token;


  header('Location: ' . $_SERVER['PHP_SELF']);
}

if(session('access_token')) {
/*  $user = apiRequest($apiURLBase);
    echo $_SESSION["access_token"];
  echo '<h3>Logged In</h3>';
  echo '<h4>Welcome, ' . $user->username . '</h4>';
  echo '<pre>';
    print_r($user->id);
  echo '</pre>';
*/
#header("Location: ../../menu.php");
header("Location: login.php");
} else {
  header("Location: " . $_SERVER["PHP_SELF"] . "/?action=login");
}


if(get('action') == 'logout') {
    apiRequest($revokeURL, array(
        'token' => session('access_token'),
        'client_id' => OAUTH2_CLIENT_ID,
        'client_secret' => OAUTH2_CLIENT_SECRET,
      ));
    unset($_SESSION['access_token']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    }
?>
