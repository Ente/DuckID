<?php
ini_set("display_errors", 1);
setlocale(LC_ALL,"de_DE.UTF-8");
require_once "api/inc/db.inc.php";
require_once "api/inc/discord.inc.php";
checkID();
$user = apiRequest($apiURLBase);

#print_r($user->username . "#" . $user->discriminator);


$sql1 = "SELECT * FROM tickets WHERE `ticket_id` = '1';";
$res1 = mysqli_query($conn, $sql1);
$count = mysqli_num_rows($res1);

if($count == 1){
    $data = mysqli_fetch_assoc($res1);
} else {
    if(mysqli_error($conn)){
        echo mysqli_error($conn);
    } else {
        echo "error";
    }
};

$tp = json_decode($data["ticket_infos"], true);

$ts = strftime("%d.%m.%Y, %x, %T", $tp["zeit"]);
echo "<b>". $ts ."</b>";
?>


<pre><?php print_r($tp["zeit"]);  ?></pre>
<br><br><br>
<pre><?php print_r($tp["userdata"]["username"]); ?></pre>