<?php
#ini_set("display_errors", 1);
require_once "../inc/db.inc.php";
require_once "../inc/discord.inc.php";

// Funktionen, welche Drittanbietern ermöglicht auf Nutzerdaten zuzugreifen.
// Drittanbieter können keine Daten löschen, bearbeiten oder hinzufügen. Sie können nur Daten einsehen.

// Ente (c) 2020 | All rights reserved. Do not copy.
// API Version 0.0.1

function publicAPIviewData(){
    global $conn;
    if(isset($_GET["token"])) {
        $token = $_GET["token"];
        $user_id = $_GET["user_id"];
    } else {
        $token = $_POST["token"];
        $user_id = $_POST["user_id"];
    }

    $sql = "SELECT * FROM api_tokens WHERE token = '{$token}';";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if(mysqli_error($conn)) {
        return mysqli_error($conn);
    }
    if($count == 1){
        $sql1 = "SELECT user_id, username, status, banned, reg_date FROM users WHERE user_id = '{$user_id}';";
        $res1 = mysqli_query($conn, $sql1);
        $count1 = mysqli_num_rows($res1);

        if($count1 == 1){
            $data = mysqli_fetch_assoc($res1);
            return json_encode($data);
        } else {
            return "none";
        }
    } else {
        return "not found";
    }
};
publicAPIviewData();
?>
<?php print_r(publicAPIviewData()) ?>