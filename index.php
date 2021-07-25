<?php
#ini_set("display_errors", 1);
require_once "api/inc/discord.inc.php";
require_once "api/inc/db.inc.php";
    header("Location: login.php");
$user = apiRequest($apiURLBase);

   print_r($user);

   echo "<br><br>";

   echo "<pre>";
   print_r($_SESSION);
   echo "</pre>";

?>