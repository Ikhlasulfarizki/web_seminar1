<?php
$path = dirname($_SERVER["REQUEST_URI"]);
$path2 = dirname($_SERVER["REQUEST_URI"], 2);
$base2 = basename($path2);
$base = basename($path);
$url = basename($_SERVER["REQUEST_URI"]);
$array = profile(isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : '');
if ($base2 == "table_create_seminar") {
    $dashboard = "../../home";
    $profile = "../../profile";
    $password = "../../password";
    $event = "../table_seminar";
    $data_user = "../../table";
    $create_event = "../../table_create_seminar";
    $roles = "../../table_role";
    $exit = "../../../web_seminar";
    $logout = "../../../actions/action_logout.php";
} elseif ($base == "dashboard") {
    $dashboard = "home";
    $event = "table_seminar";
    $profile = "profile";
    $password = "password";
    $data_user = "table";
    $create_event = "table_create_seminar";
    $roles = "table_role";
    $exit = "../web_seminar";
    $logout = "../actions/action_logout.php";
} elseif ($base == "web_seminar") {
    $dashboard = "../dashboard/home";
    $profile = "../dashboard/profile";
    $password = "../dashboard/password";
    $event = "../dashboard/table_seminar";
    $data_user = "../dashboard/table";
    $create_event = "../dashboard/table_create_seminar";
    $roles = "../dashboard/table_role";
    $exit = "../web_seminar";
    $logout = "../actions/action_logout.php";
} else {
    $dashboard = "../home";
    $profile = "../profile";
    $password = "../password";
    $event = "../table_seminar";
    $data_user = "../table";
    $create_event = "../table_create_seminar";
    $roles = "../table_role";
    $exit = "../../web_seminar";
    $logout = "../../actions/action_logout.php";
}
?>
<div class="navbar">
    <div class="nav">
        <div class="left">
            <div class="bars" id="bars">
                <i class="fa-solid fa-bars" id="side"></i>
            </div>
            <div class="content-nav">
                <div class="title">
                    <h2><a href="<?= $exit ?>">Web Seminar</a></h2>
                </div>
            </div>
        </div>
        <div class="right">
            <?php
            if (validate_auth_token_signed(!empty($_SESSION["auth_token"]) ? $_SESSION["auth_token"] : "")) {
            ?>
                <div class="bars">
                    <div class="trigger">
                        <p class="profile"><?= $array["name"] ?></p>
                        <i class="fa-solid fa-circle-user"></i>
                    </div>
                </div>
                <div class="profile-nav-dashboard ">
                    <div class="content-prof top">
                        <div class="profiles">
                            <i class="fa-solid fa-circle-user"></i>
                            <p><?= $array["name"] ?></p>
                        </div>
                        <a href="<?= $profile ?>">
                            <i class="fa-solid fa-user"></i>
                            Ubah Profile
                        </a>
                        <a href="<?= $dashboard ?>">
                            <i class="fa-solid fa-house"></i>
                            Dashboard
                        </a>
                        <a href="<?= $event ?>" class="evnt">
                            <i class="fa-solid fa-calendar-days"></i>
                            Event
                        </a>
                    </div>
                    <div class="content-prof">
                        <a href="<?= $password ?>" class="">
                            <i class="fa-solid fa-lock"></i>
                            Password
                        </a>
                        <a href="<?= $logout ?>" class="">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            Logout
                        </a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="btn-login">
                    <a href="login">Login</a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>