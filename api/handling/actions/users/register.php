<?php
ini_set("display_errors", 1);
require "../../../inc/db.inc.php";
require_once "../../../inc/discord.inc.php";

session_start();

if(isset($_SESSION["access_token"])) {

    $user = apiRequest($apiURLBase);

    $sql = "SELECT user_id FROM users WHERE user_id = '{$user->id}';";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1) {
        $_SESSION["a_reg"] = "true";
        header("Location: ../../profile.php?info=a_reg");
    } else {
        $reg_date = time();
        $username = $user->username;
        /**
         * @var array
         * 
         * 
         */
        $infos = [
            "username" => $user->username,
            "username_a" => $user->username ."#". $user->discriminator,
            "email" => $user->email,
            "id" => $user->id,
            "locale" => $user->locale,
            "additional" => NULL
        ];

        $in = json_encode($infos);

        $sql = "INSERT INTO users (user_id, reg_date, username, email, status, banned, infos) VALUES ('{$user->id}', '{$reg_date}', '{$username}', '{$user->email}', 'user', 0, '{$in}');";
        $_SESSION["info"] = [
            "info_code" => "1",
            "info_message" => "Your Account was successfully created!"
        ];
        header("Location: ../../../../index.php");

        if(!mysqli_query($conn, $sql)) {
            $error_msg = urlencode(mysqli_error($conn));
            header("Location: ../../index.php?error=reg_insert_1&msg={$error_msg}");
        }
    }

}



?>