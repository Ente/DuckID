<?php
require "../inc/db.inc.php";
require_once "../inc/discord.inc.php";

session_start();

checkID();

if($_SESSION["log_checkid"] == true) {
    header("Location: ../../profile.php");
}

?>