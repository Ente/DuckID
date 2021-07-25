<!DOCTYPE html>
<html>
<?php
setlocale(LC_ALL,"de_DE.UTF-8");
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


$t_sql = "SELECT * FROM tickets WHERE creator = '{$user->id}' LIMIT 1;";
$t_res = mysqli_query($conn, $t_sql);
$t_count = mysqli_num_rows($t_res);

if($t_count == 1){
    $t_tp = mysqli_fetch_assoc($t_res);
    $t_tp1 = json_decode($t_tp["ticket_infos"], true);
} else {
    $t_tp = "No tickets yet.";
}

if($tp["status"] == "user"){
    die(header("Location: profile.php?error=t_n0"));
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - DuckID</title>
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
                    <li class="nav-item"><a class="nav-link active" href="all_tickets.php"><i class="fas fa-table"></i><span>All Tickets</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="your_tickets.php"><i class="fa fa-th-list"></i><span>Your Tickets</span></a><a class="nav-link" href="login.php"><i class="far fa-user-circle"></i><span>Login</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
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
            <h3 class="text-dark mb-4"></h3>
            <div class="card shadow">
                <div class="card-header py-3">
                    <p class="text-primary m-0 font-weight-bold">Tickets</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-nowrap">
                            <div hidden id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label>Show&nbsp;<select class="form-control form-control-sm custom-select custom-select-sm"><option value="10" selected="">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>&nbsp;</label></div>
                        </div>
                        <div class="col-md-6">
                            <form action="" method="GET"><div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input type="checkbox" name="only_open1"> Only Open Tickets?</label>  <label><input type="number" class="form-control form-control-sm" aria-controls="dataTable" name="d_list" placeholder="ID to start from" value="<?php echo $_GET["d_list"]; ?>" style="border-color:red;"></label><button type="submit" required>Search!</button></form></div>
                        </div>
                    </div>
                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Ticket Name</th>
                                    <th>Status</th>
                                    <th>Ticket ID</th>
                                    <th>Created</th>
                                    <th>Assigned</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!isset($_GET["d_list"])){
                                    $d_list = 0;
                                }
                                if(isset($_GET["d_list"])){
                                    if(!is_numeric($_GET["d_list"])) {
                                        $d_list = 0;
                                    } else {
                                        $d_list = $_GET["d_list"];
                                    }
                                    $d_list2 = $_GET["d_list"] + 10;
                                    if(isset($_GET["only_open1"])){
                                        $sql1 = "SELECT * FROM tickets WHERE ticket_id BETWEEN {$d_list} AND {$d_list2} AND ticket_id = 'open';";
                                    } else {
                                        $sql1 = "SELECT * FROM tickets WHERE ticket_id BETWEEN {$d_list} AND {$d_list2};";
                                    }
                                    $res1 = mysqli_query($conn, $sql1);
                                    if(mysqli_num_rows($res1) >= 1){
                                    while($row = mysqli_fetch_assoc($res1)){
                                        $data1 = json_decode($row["ticket_infos"], true);
                                        $ts = strftime("%x, %T", $data1["zeit"]);

                                        if($row["agent"] == null){
                                            $row["agent"] = "None, yet";
                                        };

                                        if($row["status"] == "open"){
                                            $c = "darkgreen";
                                            $img = "assets/img/icons/check.svg";
                                        } else {
                                            if($row["status"] == "closed"){
                                            $c = "red";
                                            $img = "assets/img/icons/closed.svg";
                                            } else {
                                                $c = "orange";
                                                $img = "assets/img/icons/warning.svg";
                                            }
                                        }
                                        echo <<< DATA
                                        <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="{$img}">{$data1["author"]}</td>
                                        <td>{$data1["title"]}</td>
                                        <td style="color:{$c}">{$row["status"]}</td>
                                        <td>{$row["ticket_id"]}</td>
                                        <td>{$ts}</td>
                                        <td>{$row["agent"]}</td>
                                        <td><a href="your_tickets.php?agent={$user->id}&ticket_id={$row["ticket_id"]}">Open Ticket</a></td>
                                        </tr>




                                    DATA;

                                    }
                                    } else {
                                        echo "<tr><td style='color:red;'>No Data!</td></tr>";
                                    }
                                } else {
                                    $d_list = "N/A";
                                    $d_list2 = "N/A";
                                    echo "<span style='color:red;'>No value given!</span>";
                                }

                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Name</strong></td>
                                    <td><strong>Ticket Name</strong></td>
                                    <td><strong>Status</strong></td>
                                    <td><strong>Ticket ID</strong></td>
                                    <td><strong>Created</strong></td>
                                    <td><strong>Assigned</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing <b><?php echo $d_list; ?></b> to <b><?php echo $d_list2; ?></b></p>
                        </div>
                        <div class="col-md-6">
                            <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">

                            </nav>
                        </div>
                    </div>
                </div>
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