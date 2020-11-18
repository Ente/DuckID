<?php

ini_set("display_errors", 1);
setlocale(LC_ALL,"de_DE.UTF-8");
require_once "../../../inc/db.inc.php";
require_once "../../../inc/discord.inc.php";
$user = apiRequest($apiURLBase);

checkID();

$sql = "SELECT * FROM users WHERE user_id = '{$user->id}';";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if($count == 1){
    $tp = mysqli_fetch_assoc($res);

    $tp1 = json_decode($tp["infos"], true);
} else {
    die("No Data found in Database!");
}

$data1 = urldecode($_POST["infos"]);
$data2 = json_decode($data1, true);

$data = [
    "infos" => $data2,
    "message" => "{$_POST["text_message"]}"
];

if($user->id == $data["infos"]["message"]["author_id"]){
    $sql = "SELECT * FROM tickets WHERE ticket_id = '{$data["infos"]["ticket_id"]}';";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1){
        $dat = mysqli_fetch_assoc($res);
        $n_d = json_decode($dat["messages"], true);
        $n = array_key_last($n_d) + 1;
        $message = [
            "{$n}" => [
                "author" => "{$data["infos"]["message"]["author"]}",
                "author_id" => "{$data["infos"]["message"]["author_id"]}",
                "zeit" => "{$data["infos"]["message"]["zeit"]}",
                "message" => "{$data["message"]}"
            ]
        ];

        $new_d = array_merge($n_d, $message);
        $d_json = json_encode($new_d);

        $sql = "UPDATE tickets SET messages = '{$d_json}' WHERE ticket_id = '{$data["infos"]["ticket_id"]}';";
        echo $sql;
        mysqli_query($conn, $sql);
        if(mysqli_error($conn)){
            die("Error occured: " . mysqli_error($conn));
        } else {
            if($tp["status"] == "admin" || "moderator" || "agent"){
                $agent = "&agent={$user->id}";
            } else {
                $agent = "";
            }
            header("Location: /your_tickets.php?ticket_id={$data["infos"]["ticket_id"]}{$agent}");
        }
    }
} else {
    header("Location: /profile.php?error=c_uK");
}



 
?>