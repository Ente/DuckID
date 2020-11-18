<!DOCTYPE html>
<html>
<?php
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
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profile - DuckID</title>
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
                    <li class="nav-item"><a class="nav-link active" href="profile.php"><i class="fas fa-user"></i><span>Manage Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="all_tickets.php"><i class="fas fa-table"></i><span>All Tickets</span></a></li>
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
            <h3 class="text-dark mb-4">Profile</h3>
            <div class="row mb-3">
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="<?php echo $img_link; ?>" width="160" height="160">
                            <div class="mb-3"><?php echo $tp1["username_a"]; ?></div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="text-primary font-weight-bold m-0">Tickets</h6>
                            <div class="card">
                                <div class="card-body"><a class="card-link" href="#"><?php echo $t_tp1["title"];  ?> | Ticket ID: #<?php echo $t_tp["ticket_id"]; ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row mb-3 d-none">
                        <div class="col">
                            <div class="card text-white bg-primary shadow">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <p class="m-0">Peformance</p>
                                            <p class="m-0"><strong>65.2%</strong></p>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                    </div>
                                    <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-white bg-success shadow">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <p class="m-0">Peformance</p>
                                            <p class="m-0"><strong>65.2%</strong></p>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                    </div>
                                    <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold">User Settings</p>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group"><label for="username"><strong>Username</strong></label><input disabled class="form-control" type="text" placeholder="user.name" value="<?php echo $tp["username"]; ?>" name="username"></div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group"><label for="email"><strong>Email Address</strong></label><input disabled class="form-control" type="email" placeholder="user@example.com" value="<?php echo $tp["email"]; ?>" name="email"></div>
                                            </div>
                                        </div>
                                        <div class="form-group"><button class="btn btn-primary btn-sm" type="submit" disabled>Save Settings</button></div>
                                        <i><span style="color:red;">Not editable.</span></i>
                                    </form>
                                </div>
                            </div>
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 font-weight-bold">Contact Settings</p>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group"><label for="address"><strong>Email</strong><br></label><input disabled class="form-control" type="text" name="email-add" value="<?php echo $tp["email"]; ?>" placeholder="your@email.com"></div>
                                        <div class="form-row"></div>
                                        <div class="form-group"><button class="btn btn-primary btn-sm" type="submit" disabled>Save&nbsp;Settings</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-5">
                <div class="card-header py-3">
                    <p class="text-primary m-0 font-weight-bold">Account Settings</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <div class="form-group"><label for="signature"><br></label></div>
                                <div class="form-group">
                                    <p><strong><em>No Settings available currently!</em></strong></p>
                                </div>
                                <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
                            </form>
                        </div>
                        <div class="col"><a class="btn btn-danger btn-icon-split" role="button"><span class="text-white-50 icon"><i class="fas fa-trash"></i></span><span class="text-white text">Delete Account permanently*</span></a><p>To delete your account, please contact <?php echo $st_administrator_email; ?></p></div>
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