<?php

ini_set("display_errors", 1);
setlocale(LC_ALL,"de_DE.UTF-8");
require_once "api/inc/db.inc.php";
require_once "api/inc/discord.inc.php";
$user = apiRequest($apiURLBase);

checkID();

/**
 * @var int
 * ID des Tickets
 */
$t_id = $_POST["ticket_id"];


/**
 * @var string
 * Token, benötigt um sich zu authentifizieren.
 */
$t_token = $_POST["token"];


if(!empty($t_id)){
    $_SESSION["error"] = [
        "error_code" => "1",
        "error_message" => "The ticket ID was not included within the POST Request"
    ];
    header("Location: ../../index.php");
} else {

    $sql = "SELECT * FROM tickets WHERE ticket_id = '{$t_id}';";
    $res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);


    if($count == 1){
        $sql1 = "SELECT * FROM tokens WHERE token = '{$token}';";
        $res1 = mysqli_query($conn, $sql1);
        $count1 = mysqli_num_rows($res1);

        if($count1 == 1){
            $sql3 = "DELETE FROM tickets WHERE ticket_id = '{$t_id}';";
            $res3 = mysqli_query($conn, $res3);

            if(mysqli_error($conn)){
                die(mysqli_error($conn));
            }
        } else {
            $_SESSION["error"] = [
                "error_code" => "4",
                "error_message" => "The token was not found. Please enter a valid token."

            ];
            header("Location ../../index.php");
        }
    } else {
        $_SESSION["error"] = [
            "error_code" => "3",
            "error_message" => "The Ticket ID was not found, therefore no Ticket was deleted."

        ];
        header("Location ../../index.php");
    }

}




?>