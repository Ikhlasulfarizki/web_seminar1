<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<?php
include "functions.php";
if (validate_auth_token(!empty($_SESSION["auth_token"]) ? $_SESSION["auth_token"] : "")) {
    header("location: ../login");
}
$perm = log_role($_SESSION["role"]);
$data = detail_seminar($_SESSION["user_id"])
?>
<body>
    <div class="loading">
        <div class="gear">
            <i class="fa-solid fa-gear" id="gear1"></i>
            <i class="fa-solid fa-gear" id="gear2"></i>
        </div>
    </div>
    <div class="main">
        <?php
        include "component/navbar.php"
        ?>
        <div class="container-tb">
            <div class="container-sidebar">
                <?php
                include "component/sidebar.php"
                ?>
            </div>
            <div class="container-content">
                <div class="content">
                    <div class="title-content">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(window).on("load", function() {
        setTimeout(function() {
            $('.loading').fadeOut(300);
        }, 800);
    });
    $(document).ready(function() {
        $(".trigger").click(function() {
            let display = $(".profile-nav-dashboard").css("display")
            if (display == "none") {
                $(".profile-nav-dashboard").fadeIn(200);
            } else {
                $(".profile-nav-dashboard").fadeOut(200);
            }
        })
        $("#bars").click(function() {
            let marg = $(".sidebar").css("margin-left");
            console.log(marg)
            if (marg == "0px") {
                $(".sidebar").css({
                    "margin-left": "-13rem"
                });
                $(".container-content").width("100%");
            } else {
                $(".sidebar").css({
                    "margin-left": "0rem"
                });
                $(".container-content").width("calc(100% - 13rem)");
            }
        });
    })
</script>

</html>