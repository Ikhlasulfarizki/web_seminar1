<?php
$path = dirname($_SERVER["REQUEST_URI"]);
$path2 = dirname($_SERVER["REQUEST_URI"], 2);
$base = basename($path);
$base2 = basename($path2);
$url = basename($_SERVER["REQUEST_URI"]);
$array = profile(isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : '');
if( $base == "web_seminar"){
    $all = "event_mendatang";
    $profile = "../dashboard/profile";
    $dashboard = "../dashboard/home";
    $event = "../dashboard/table_seminar";
    $data_user = "../dashboard/table";
    $create_event = "../dashboard/table_create_seminar";
    $roles = "../dashboard/table_role";
    $beranda = "../web_seminar"; 
    $logout = "../actions/action_logout.php";
}else{
    $all = "web_seminar/event_mendatang";
    $profile = "dashboard/profile";
    $dashboard = "dashboard/home";
    $event = "dashboard/table_seminar";
    $data_user = "dashboard/table";
    $create_event = "dashboard/table_create_seminar";
    $roles = "dashboard/table_role";
    $beranda = "web_seminar"; 
    $logout = "actions/action_logout.php";
}
?>
<div class="navbar1">
    <div class="nav">
        <div class="left">
            <div class="bars" id="bars">
                <i class="fa-solid fa-graduation-cap side"></i>
            </div>
            <div class="content-nav">
                <div class="title">
                    <h2><a href="<?= $dashboard ?>">Web Seminar</a></h2>
                </div>
            </div>
        </div>
        <div class="mid">
            <a href="<?= $beranda ?>" class=" <?= $url == "web_seminar" ? "actived" : " " ?>">Beranda</a>
            <a href="<?= $all ?>" class=" <?= $url == "event_mendatang" ? "actived" : " " ?>">Seminar</a>
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
                    <div class="profile-nav">
                        <div class="content-prof top">
                            <div class="profiles">
                                <i class="fa-solid fa-circle-user"></i>
                                <p><?= $array["name"] ?></p>
                            </div>
                            <a href="<?= $profile ?>" class=" <?= $url == "home" ? "active" : " " ?>">
                            <i class="fa-solid fa-user"></i>
                            Ubah Profile
                            </a>
                            <a href="<?= $dashboard ?>" class=" <?= $url == "home" ? "active" : " " ?>">
                                <i class="fa-solid fa-house  <?= $url == "home" ? "active" : " " ?>"></i>
                                Dashboard
                            </a>
                            <a href="<?= $event ?>" class=" <?= $url == "table-seminar" ? "active" : " " ?> evnt">
                                <i class="fa-solid fa-calendar-days <?= $url == "table-seminar" ? "active" : " " ?>"></i>
                                Event
                            </a>
                        </div>
                        <?php if(authorization("create seminar")){?>
                            <div class="content-prof bott">
                            <a href="<?= $create_event ?>">
                                <i class="fa-solid fa-calendar-plus calendar-plus"></i>
                                Create Event
                            </a>
                        </div>
                        <?php } ?>
                        <div class="content-prof">
                            <a href="<?= $logout ?>">
                                <i class="fa-solid fa-arrow-right-from-bracket <?= $url == "table" ||  $base == "table"  ? "active" : " " ?>"></i>
                                Logout
                            </a>
                        </div>
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