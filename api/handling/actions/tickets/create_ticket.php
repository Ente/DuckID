<?php

ini_set("display_errors", 1);
setlocale(LC_ALL,"de_DE.UTF-8");
require_once "api/inc/db.inc.php";
require_once "api/inc/discord.inc.php";
$user = apiRequest($apiURLBase);

/**
 * @var array
 * Ticket Array sollte immer beinhalten
 * - Wer hat das Ticket erstellt?
 * - Wann wurde es erstellt?
 * - Welchen Titel hat es?
 * - Welche Nachricht?
 * - Priorität?
 * - Nutzerdaten?
 * - Welcher Bereich?
 * 
 * Optional bzw. erst später hinzuzufügen:
 * 
 * - Wem wurde das Ticket zugeteilt?
 * - Wann wurde es geschlossen?
 * - Von wem wurde es geschlossen?
 * - Wer hat alles drin geschrieben?
 * - Alle Nachrichten innerhalb des Tickets?
 * - Flags?
 */
$ticket = [
    "author" => "{$user->username}#{$user->discriminator}",
    "zeit" => time(),
    "title" => "{$_POST["ticket_title"]}",
    "message" => "{$_POST["ticket_message"]}",
    "priority" => "normal",
    "userdata" => [
        "username" => "{$user->username}#{$user->discriminator}",
        "user_id" => "{$user->id}"
    ],
    "bereich" => "{$_POST["ticket_bereich"]}",
    "conversation" => [
        NULL
    ]
];

$param_ticket = json_encode($ticket);

$ticket_message = $ticket["message"];

if(!empty($_FILES["uploaded_file"])){
    $path_dir = "../../public/uploads";
    $path = $path_dir . basename($_FILES["uploaded_file"]["name"]);
    $filetype = strtolower($path, PATHINFO_EXTENSION);
    $upload = 1;

    if($filetype != "jpg" || "png" || "PNG" || "JPG"){
        $_SESSION["errors"] = json_encode(array(
            "error_code" => "1",
            "error_message" => "Your file is not supported. Supported file types are: JPG and PNG!",
            "error_priority" => "red"
        ));
        header("Location: index.php");
    }

    if($upload == 1){
        if(move_uploaded_file($_FILES["uploaded_file"]["name"], $path)){
            $_SESSION["images_filepath"] = $path;
        } else {
            die("Error uploading your Image! YOUR TICKET WAS NOT CREATED!");
        }
    }
} else {
    $_SESSION["images_filepath"] = "No images provided!";
}
$alt_id = rand(111111, PHP_INT_MAX);
/**
 * @var array|null
 * Might come as an array or as NULL
 */
$ticket_attachements = $_SESSION["images_filepath"];

$sql = "INSERT INTO tickets (`ticket_infos`, `ticket_message`, `ticket_attachements`, `alt_id`) VALUES ('{$param_ticket}', '{$ticket_message}', '{$ticket_attachements}', '{$alt_id}')";
$res = mysqli_query($conn, $sql);

if(mysqli_error($conn)){

    echo mysqli_error($conn);
}

$sql1 = "SELECT * FROM tickets WHERE `ticket_id` = '$alt_id';";
$res1 = mysqli_query($conn, $sql1);
$count = mysqli_num_rows($res1);

if($count == 1){
    $_SESSION["info"] = [
        "info" => "Successfully created ticket!"
    ];
    header("Location: ../../../index.php");
} else {
    if(mysqli_error($conn)){
        echo mysqli_error($conn);
    } else {
        echo "error";
    }
};



?>