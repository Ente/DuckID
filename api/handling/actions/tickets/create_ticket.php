<?php

#ini_set("display_errors", 1);
setlocale(LC_ALL,"de_DE.UTF-8");
require_once "../../../inc/db.inc.php";
require_once "../../../inc/discord.inc.php";
$user = apiRequest($apiURLBase);
$_POST["ticket_bereich"] = "general";
$_POST["alt_id"] = $_GET["alt_id"]; 

$encoded_message = urlencode($_POST["ticket_message"]);
/**
 * @var array
 * Ticket Array should always contain
 * - who created the Ticket
 * - when it was created
 * - the ticket title
 * - the message
 * - priority
 * - data about the user
 * - which section it belongs to
 * 
 * Filled out later:
 * 
 * - ticket agent
 * - when it was closed
 * - who closed it
 * - all messages in the ticket
 * - flags
 */
$ticket = [
    "author" => "{$user->username}#{$user->discriminator}",
    "zeit" => time(),
    "title" => "{$_POST["ticket_title"]}",
    "message" => "{$encoded_message}",
    "priority" => "normal",
    "userdata" => [
        "username" => "{$user->username}#{$user->discriminator}",
        "user_id" => "{$user->id}"
    ],
    "bereich" => "{$_POST["ticket_bereich"]}",
];

$messages = [
    "1" => [
        "author" => "{$user->username}#{$user->discriminator}",
        "author_id" => "{$user->id}",
        "zeit"=> time(),
        "message" => "{$encoded_message}",
    ]
];

$message1 = json_encode($messages);

$param_ticket = json_encode($ticket);

$ticket_message = $ticket["message"];

if(!empty($_FILES["uploaded_file"])) {
    $path_dir = "../../public/uploads";
    $path = $path_dir . basename($_FILES["uploaded_file"]["name"]);
    $filetype = strtolower($path, PATHINFO_EXTENSION);
    $upload = 1;

    if($filetype != "jpg" || "png" || "PNG" || "JPG") {
        $_SESSION["errors"] = json_encode(array(
            "error_code" => "1",
            "error_message" => "Your file is not supported. Supported file types are: JPG and PNG!",
            "error_priority" => "red"
        ));
        header("Location: index.php");
    }

    if($upload == 1) {
        if(move_uploaded_file($_FILES["uploaded_file"]["name"], $path)) {
            $_SESSION["images_filepath"] = $path;
        } else {
            die("Error uploading your Image! YOUR TICKET WAS NOT CREATED!");
        }
    }
} else {
    $_SESSION["images_filepath"] = "No images provided!";
}
$alt_id = $_POST["alt_id"];
/**
 * @var array|null
 * Might come as an array or as NULL
 */
$ticket_attachements = $_SESSION["images_filepath"];

$sql = "INSERT INTO tickets (`ticket_infos`, `ticket_message`, `ticket_attachements`, `alt_id`, `messages`, `creator`, `status`) VALUES ('{$param_ticket}', '{$ticket_message}', '{$ticket_attachements}', '{$alt_id}', '{$message1}', '{$user->id}', 'open')";
$res = mysqli_query($conn, $sql);

if(mysqli_error($conn)) {

    echo mysqli_error($conn);
}

$sql1 = "SELECT * FROM tickets WHERE `alt_id` = '$alt_id';";
$res1 = mysqli_query($conn, $sql1);
$count = mysqli_num_rows($res1);

if($count == 1) {
    header("Location: ../../../../login.php?error=e_1");
} else {
    echo mysqli_error($conn);
};





?>