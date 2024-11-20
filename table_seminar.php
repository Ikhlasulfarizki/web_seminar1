<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<?php
include "functions.php";
if (validate_auth_token(!empty($_SESSION["auth_token"]) ? $_SESSION["auth_token"] : "")) {
    header("location: ../login");
}
$perm = log_role($_SESSION["role"]);
$array = profile(isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : '');
$datas = detail_seminar($array["email"]);
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
            <?php
            include "component/sidebar.php"
            ?>
            <div class="container-content">
                <div class="content">
                    <div class="title-content">
                        <h1>Data Seminar</h1>
                    </div>
                    <div class="tb">
                        <div class="table">
                            <table id="tables" class="nowrap ">
                                <thead>
                                    <tr>
                                        <th data-priority="1">Nomor Registrasi</th>
                                        <th data-priority="3">Detail Seminar</th>
                                        <th>Link</th>
                                        <th data-priority="2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datas as $data) {
                                        $date = date_create(isset($data["waktu_mulai"]) ? $data["waktu_mulai"] : "");
                                        if($data["status"] == "pending" ){
                                            $class = "pending";
                                        }elseif($data["status"] == "accepted" ){
                                            $class = "accept";
                                        }else{
                                            $class = "reject";
                                        }
                                    ?>
                                        <tr>
                                            <td><img src="../upload/<?= $data["filename"] ?>" alt="" class="img-seminar"></td>
                                            <td>
                                                <div>
                                                    <h3><?= $data["judul"] != null || $data["judul"] != "" ? $data["judul"] : "<i>Event Sudah Tidak Ditemukan</i>" ?></h3>
                                                </div>
                                                <div class="date"> <?= date_format($date, "d F Y | H:i:s") ?> WIB</div>
                                                <div class="<?= $data["status_seminar"] != "upcoming event" ? "reject" : "accept" ?>"> <?= $data["status_seminar"] != null || $data["status_seminar"] != ""  ? ucwords($data["status_seminar"]) : "Missed Event" ?> </div>
                                            </td>
                                            <td>
                                                <div class="link-seminar">
                                                    <?= $data["link"] != null && $data["link"] != "" ? "<a href=" . $data["link"] . "> " . $data["link"] . " </a>" : "<i> Link Belum Tersedia </i>" ?>
                                                </div>
                                            </td>
                                            <td><span class="<?= $class ?>"><?= ucfirst($data["status"]) ?></span></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
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
</script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $(".trigger").click(function() {
            let display = $(".profile-nav-dashboard").css("display")
            if (display == "none") {
                $(".profile-nav-dashboard").fadeIn(200);
            } else {
                $(".profile-nav-dashboard").fadeOut(200);
            }
        })
        $('#tables').DataTable({
            // responsive: true,
            order: true,
            // paging: false,
            language: {
                info: "" // Mengosongkan teks info
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
    });
</script>

</html>