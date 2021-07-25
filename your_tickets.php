<!DOCTYPE html>
<html>
<?php
#ini_set("display_errors", 1);
require_once "api/inc/db.inc.php";
require_once "api/inc/discord.inc.php";
include "api/vars.php";

session_start();
checkID();
$user = apiRequest($apiURLBase);

$img_link = "{$imageURL}{$user->id}/{$user->avatar}.png";


$sql = "SELECT * FROM users WHERE user_id = '{$user->id}';";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if($count == 1){
    $tp = mysqli_fetch_assoc($res);

    $tp1 = json_decode($tp["infos"], true);
} else {
    die("No Data found in Database!");
}
$fullurl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos("action=close", $fullurl)){
    $d_sql = "UPDATE `tickets` SET `status` = `closed` WHERE ticket_id = '{$_GET["ticket_id"]}'";
    $d_res = mysqli_query($conn, $d_sql);
    $d_count = mysqli_num_rows($d_res);
}


if(isset($_GET["ticket_id"])){
    if(isset($_GET["agent"])){
        if($tp["status"] == "agent" || "moderator" || "admin" || "owner"){
            $sql1 = "SELECT * FROM tickets WHERE ticket_id = '{$_GET["ticket_id"]}';";
            $close_button = "<button type='button' class='btn btn-danger'><a href='{$_SERVER["PHP_SELF"]}?action=close&ticket_id={$_GET["ticket_id"]}'>Close Ticket</a></button>";
        }
    } else {

        $sql1 = "SELECT * FROM tickets WHERE ticket_id = '{$_GET["ticket_id"]}' AND creator = '{$user->id}';";
        $close_button = "<button type='button' class='btn btn-danger'><a href='{$_SERVER["PHP_SELF"]}?action=close&ticket_id={$_GET["ticket_id"]}'>Close Ticket</a></button>";

    };
    $res1 = mysqli_query($conn, $sql1);
    $count1 = mysqli_num_rows($res);

    if($count1 == 1){
        $data = mysqli_fetch_assoc($res1);
        $data_js_infos = json_decode($data["ticket_infos"], true);
        $data_js_messages = json_decode($data["messages"], true);
    } else {
        header("Location: profile.php?error=t_3");
    }
} else {
    header("Location: profile.php?error=t_2");
}

?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Ticket - DuckID</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-ticket-alt"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>DuckID</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Manage Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="create_ticket.php"><i class="fas fa-table"></i><span>Create Ticket</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="all_tickets.php"><i class="fas fa-table"></i><span>All Tickets</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="your_tickets.php"><i class="fa fa-th-list"></i><span>Your Tickets</span></a><a class="nav-link" href="login.php"><i class="far fa-user-circle"></i><span>Login</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for Ticket">
                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for Ticket">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"></div>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"></div>
                                </div>
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small"><?php echo $tp["username"]; ?></span><img class="border rounded-circle img-profile" src="<?php echo $img_link; ?>"></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a>
                                        <div
                                            class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
            </div>
            </li>
            </ul>
        </div>
        </nav>
        <div class="container-fluid">
            <h3 class="text-dark mb-1"><?php echo $data_js_infos["title"];  ?></h3>
        </div>
        <div class="card shadow mb-4">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <?php

                    $infos = [
                        "ticket_id" => "{$data["ticket_id"]}",
                        "message" => [
                            "author" => "{$user->username}#{$user->discriminator}",
                            "author_id" => "{$user->id}",
                            "zeit"=> time()
                        ]
                    ];
                    $json_infos = urlencode(json_encode($infos));
                    ?>
                   <form action="api/handling/actions/tickets/update_ticket.php" method="POST"><input type="text" name="infos" value='<?php echo $json_infos; ?>' hidden> <div class="float-none"><textarea class="d-inline-block" style="width: 400px;height: 55px;" name="text_message" placeholder="Enter your message here"></textarea><button class="btn btn-success btn-circle ml-1" role="button" type="submit"><i class="fas fa-check d-inline-block text-white"></i></button></div></form>
                </div>
            </div>
            <div class="card-header py-3">
                <h6 class="text-primary m-0 font-weight-bold">"<?php echo $data_js_infos["title"]; ?>" | Ticket ID: #<?php echo $data["ticket_id"]; ?></h6>
                <?php echo $close_button;  ?>
            </div>
            <div class="card-body">
                <?php

                    foreach($data_js_messages as $js){
                        if($js["author"] == $user->id){
                            $color = "color: grey;";
                            $float = "float: right;";
                            
                        } else {
                            $float = null;
                            $color = $float;
                        }

                        $js1 = urldecode($js["message"]);
                            echo <<< DATA

                            <p class="m-0" style="{$color}{$float}padding: 20px;border:solid;border-radius:2%;margin:5px;"><b>{$js["author"]}</b>: "{$js1}"</p>

                            DATA;
                    }

                ?>
            </div>
        </div>
    </div>
    <footer class="bg-white sticky-footer">
        <div class="container my-auto">
            <div class="text-center my-auto copyright"><span>Copyright © DuckID 2020</span></div>
        </div>
    </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>