<?php
$path = dirname($_SERVER["REQUEST_URI"]);
$path2 = dirname($_SERVER["REQUEST_URI"], 2);
$base2 = basename($path2);
$base = basename($path);
$url = basename($_SERVER["REQUEST_URI"]);

if ($base2 == "table_create_seminar") {
    $dashboard = "../../home";
    $event = "../../table_seminar";
    $data_user = "../../table";
    $create_event = "../../table_create_seminar";
    $roles = "../../table_role";
}elseif($base == "dashboard"){
    $dashboard = "home";
    $event = "table_seminar";
    $data_user = "table";
    $create_event = "table_create_seminar";
    $roles = "table_role";
}elseif( $base == "web_seminar"){
    $dashboard = "../dashboard/home";
    $event = "../dashboard/table_seminar";
    $data_user = "../dashboard/table";
    $create_event = "../dashboard/table_create_seminar";
    $roles = "../dashboard/table_role";
    $exit = "../web_seminar"; 
    $logout = "../actions/action_logout.php";
}else{
    $dashboard = "../home";
    $event = "../table_seminar";
    $data_user = "../table";
    $create_event = "../table_create_seminar";
    $roles = "../table_role";
}
?>
<div class="sidebar">
    <div class="upper">
        <div class="side-tittle">
            <p>Home</p>
        </div>
        <div class="content-side main-side">
                <a href="<?= $dashboard ?>" class=" <?= $url == "home" ? "active" : " " ?>">
                    <i class="fa-solid fa-house  <?= $url == "home" ? "active" : " " ?>"></i>
                    Dashboard
                </a>
        </div>
        <div class="side-tittle">
            <p>Content</p>
        </div>
        <?php
        if (authorization("user")) {
        ?>
            <div class="content-side">
                <a href="<?= $data_user ?>" class=" <?= $url == "table" ||  $base == "table" ||  $url == "tambah-data" ? "active" : " " ?>">
                    <i class="fa-solid fa-users <?= $url == "table" ||  $base == "table"  ? "active" : " " ?>"></i>
                    Data User
                </a>
            </div>
        <?php } ?>
        <div class="content-side main-side">
            <a href="<?= $event ?>" class=" <?= $url == "table_seminar" ? "active" : " " ?>">
                <i class="fa-solid fa-calendar-days <?= $url == "table_seminar" ? "active" : " " ?>"></i>
                Event
            </a>
        </div>
        <?php
        if (authorization("create seminar")) {
        ?>
            <div class="content-side">
                <a href="<?= $create_event ?>" class=" <?= $url == "table_create_seminar" || $url == "partisipan" || $base == "table_create_seminar" ? "active" : " " ?> role-link">
                    <i class="fa-solid fa-calendar-plus <?= $url == "table_create_seminar" || $url == "partisipan" || $base == "table_create_seminar" ? "active" : " " ?> event"></i>
                    Create Event
                </a>
            </div>
        <?php } ?>
        <?php
        if (authorization("role")) {
        ?>
            <div class="content-side">
                <a href="<?= $roles ?>" class=" <?= $url == "table_role" || $base == "table_role" ? "active" : " " ?> role-link">
                <i class="fa-solid fa-user-gear <?= $url == "table_role" || $base == "table_role" ? "active" : " " ?>"></i>
                    Roles
                </a>
            </div>
        <?php } ?>
    </div>
</div>