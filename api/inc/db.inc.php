<?php
#ini_set("display_errors", 1);
date_default_timezone_set("Europe/Berlin");
# Datenbank Anmeldedaten


////////////////////////////////////////////////////////////////////////////////////////////////
$db = "duckid";
$db_username = "root";
$db_password = null;
$db_host = "localhost";
////////////////////////////////////////////////////////////////////////////////////////////////
// DO NOT CHANGE BELOW THIS LINE!

require_once "discord.inc.php";



$conn = mysqli_connect($db_host, $db_username, $db_password, $db);
if(mysqli_connect_error()) {
     die(mysqli_connect_error());
};

session_start();
function checkID() {
     if($_SESSION["access_token"]) {
         global $apiURLBase;
         global $conn;
         $user = apiRequest($apiURLBase);
         $id = $user->id;
         $sql = "SELECT user_id FROM users WHERE user_id = '$id';";
         $res = mysqli_query($conn, $sql);
         $count = mysqli_num_rows($res);
 
         if($count == 1) {
             return $_SESSION["log_checkid"] = true;
         } else {
             header("Location: /api/handling/actions/users/register.php");
         }
     } else {
         header("Location: /api/handling/discord_login.php");
     }
};
 $all_codes = [
    "code_0",
    "code_1",
    "code_2",
    "code_3",

    # Kategorie: Nutzer, Turnier

    "c_1",
    "c_2",
    "c_3",
    "c_4",
    "c_5",
    "c_6",
    "c_7",
    "c_8",
    "c_9",
    "t_1",
    "t_2",
    "t_3",
    "t_4"
];

$all_codes_des = [
    "code_0" => "Unknown error.[code_0]",
    "code_1" => "Error while the registration process, please read the error notice.[code_1]",
    "code_2" => "User not found in DataBase.[code_2]",
    "code_3" => "User already registered.[code_3]",

    # Kategorie: Nutzer, Ticket

    "c_1" => "N/A Status: 'Shadowbanned'.[code_c_1]",
    "c_2" => "N/A .[code_c_2]",
    "c_3" => "N/A (Status: 'in progress').[code_c_3]",
    "c_4" => "N/A (Status: 'shadowbanned').[code_c_4]",
    "c_5" => "N/A (Status: 'temp ban').[code_c_5]",
    "c_6" => "User banned (permanent).[code_c_6]",
    "c_7" => "An answer is expected by the User by the Organisation.[code_c_7]",
    "c_8" => "The confirmation could not be sent.[code_c_8]",
    "c_9" => "N/A .[code_c_9]",
    "t_1" => "Timeout.[code_t_1]",
    "t_2" => "Arguement invalid or not found.[code_t_2]",
    "t_3" => "Code not recognizable or not found.[code_t_3]",
    "t_4" => "Not found in DataBase.[code_t_4]",

    # Kategorie: Erfolg

    "e_1" => "Ticket was created successfully.[code_e_1]"
];
/**
 * Used to check if one of the following codes in `$all_codes` is in URI
 * Attention: Function somehow duplicating output
 * 
 * @param optional $return boolean Specifies if the function should return a value or not
 */
 function checkCodes(){
    global $all_codes;
    global $all_codes_des;
    $fullUrl = "{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}";

    foreach($all_codes as $code) {
        if(strpos($fullUrl, $code)) {
            $code_des = $all_codes_des[$code];
            echo "<div class='alert alert-danger'>
            <strong>Achtung: Error Code: [$code] </strong>$code_des</div>";
        };
    };
 };
/**
 * Diese Funktion überprüft in der Datenbank, ob eine Statusmeldung vorliegt.
 * 
 * @return string|empty
 */
 function checkStatus(){
     global $conn;
     $sql = "SELECT * FROM status WHERE st = 'message' AND color = 1";
     $res = mysqli_query($conn, $sql);
     $count = mysqli_num_rows($res);

     if($count == 1){
         $dt = mysqli_fetch_assoc($res);

         echo "<div class='alert alert-danger'><b>Attention: </b> {$dt["description"]}</div><br>";
     };

 };

 function st_bridge() {
    global $conn;
    global $st_bridge_status;
    $ts = time();
    $time = date("d.m.Y H:i:s", $ts);

    if($st_bridge_status == "true"){
        $sql = "UPDATE `settings` SET `description` ='Last checked and active: $time (Timestamp: $ts)' WHERE settings.id = 1";
        if(!mysqli_query($conn, $sql)) {
            echo "Error: " . mysqli_error($conn);
        }
    };
 };
/**
 * Funktion zum erhalten aller Daten der Datenbank in einem JSON-Format
 */
function checkBadges($user_id, $output){
    global $conn;
    $sql = "SELECT * FROM regs WHERE user_id = '$user_id';";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1){
        $data = mysqli_fetch_assoc($res);
        if($output == "json") {
            switch($data["role"]){
                case("official"):
                    return json_encode(array("role"=>"official"));
                case("partner"):
                    return json_encode(array("role"=>"partner"));
                default:
                    return null;
            
            };
        } else {
            switch($data["role"]){
                case("official"):
                    return "<i class=\"material-icons\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" title=\"Offical Account\" style=\"color: rgb(0,255,25);\">check_circle</i>";
                case("partner"):
                    return "<i class=\"material-icons\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" style=\"color: #89938c;\" title=\"Partner\">check</i>";
                default:
                    return null;
            
            };
        }
    } else {
        return "Error: not found.";
    }
};

function data($user_id){
    global $conn;
    $sql = "SELECT * FROM users WHERE user_id = '$user_id';";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1){
        $data = mysqli_fetch_assoc($res);
        return json_encode($data);
    }
};

/* Ente (c) 2020 | All rights reserved. Do not copy. */
?>