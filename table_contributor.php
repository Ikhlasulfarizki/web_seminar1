<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="stylesheet" href="../asset/css/datatables.min.css">
    <link rel="stylesheet" href="../asset/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <style>
    </style>
</head>
<?php
include "functions.php";
if (validate_auth_token(empty($_SESSION["auth_token"]) ? "" : $_SESSION["auth_token"])) {
    header("location: ../login");
}
if (authorization("create seminar") != true) {
    header("location: home");
}
?>

<body>
    <div class="content-wrap">
        <div class="loading">
            <div class="gear">
                <i class="fa-solid fa-gear" id="gear1"></i>
                <i class="fa-solid fa-gear" id="gear2"></i>
            </div>
        </div>
        <div class="notif">
            <div class="card">
                <div class="svg">
                    <i id="check"></i>
                </div>
                <div class="succ">
                    <div class="suc">
                        <p class="success" id="notif"></p>
                        <p id="success"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="main">
            <div class="modal">
                <div class="modal-container">
                    <div class="modal-padding">
                        <div class="modal-body">
                            <div class="modal-header">
                                <h3>Apakah Anda Ingin Menghapus Data Ini??</h3>
                                <i class="fa-solid fa-xmark exit-modal"></i>
                            </div>
                            <div class="modal-content">
                                <span class="tittle-modal"></span>
                            </div>
                            <div class="modal-footer">
                                <form action="" id="regist">
                                    <button type="button" class="modal-button decline exit-modal">Tutup</button>
                                    <button type="submit" class="modal-button agree">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php
            include "component/navbar.php";
            ?>
            <div class="container-tb">
                <?php
                include "component/sidebar.php";
                ?>
                <div class="container-content">
                    <div class="content">
                        <div class="title-content">
                            <h1>Data User</h1>
                            <a href="table_create_seminar/tambah_seminar">Tambah Seminar</a>
                        </div>
                        <div class="tb">
                            <div class="table">
                                <table id="tables" class=" nowrap">
                                    <thead>
                                        <tr>
                                            <th data-priority="4">Gambar</th>
                                            <th data-priority="1">Detail Seminar</th>
                                            <th>Link</th>
                                            <th data-priority="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $array = table_seminar($_SESSION["user_id"]);
                                        foreach ($array as $arr) {;
                                            $date = date_create(isset($arr["waktu_mulai"]) ? $arr["waktu_mulai"] : "");
                                        ?>
                                            <tr>
                                                <td><img src="../upload/<?= $arr["filename"] ?>" alt="Image" class="img-seminar"></td>
                                                <td>
                                                    <div>
                                                        <h3><?= $arr["judul"] != null || $arr["judul"] != "" ? $arr["judul"] : "<i>Event Sudah Tidak Ditemukan</i>" ?></h3>
                                                    </div>
                                                    <div class="date"> <?= date_format($date, "d F Y | H:i:s") ?> WIB</div>
                                                    <div class="<?= $arr["status_seminar"] != "upcoming event" ? "reject" : "accept" ?>"> <?= $arr["status_seminar"] != null || $arr["status_seminar"] != ""  ? ucwords($arr["status_seminar"]) : "Missed Event" ?> </div>
                                                </td>
                                                <td><?= $arr["link"] != null ? $arr["link"] : "Link Belum Tersedia" ?></td>
                                                <td class="actions-td">
                                                    <input type="hidden" placeholder="a">
                                                    <a href="table_create_seminar/<?= $arr['id'] ?>" class="edit"> <i class="fa-regular fa-pen-to-square"></i></a>
                                                    <a data-id="<?= $arr['id'] ?>" data-name="<?= $arr["judul"] ?>" class="del"><i class="fa-regular fa-trash-can"></i></a>
                                                    <a href="table_create_seminar/<?= $arr["id"] ?>/partisipan" class="total"><i class="fa-solid fa-users"></i> <?= count_partisipan($arr["id"])  ?></a>
                                                </td>
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
    </div>
</body>
<script src="../asset/jquery.min.js"></script>
<script>
    $(window).on("load", function() {
        setTimeout(function() {
            $('.loading').fadeOut(300);
        }, 800);
    });
</script>
<script src="../asset/datatables.min.js"></script>
<script src="../asset/dataTables.responsive.min.js"></script>
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
        // $('.dt-empty').text('Tidak Ada Data')
        $('.del').click(function() {
            let data = $(this).data("id");
            let judul = $(this).data("name");
            $(".tittle-modal").text(judul)
            $(".modal").fadeIn(300);
            $("#regist").attr("action", "../actions/action_delete_seminar.php?id=" + data);
            $("#regist").data("tr", $(this).closest("tr"));
        });
        $(".exit-modal").click(function() {
            $(".modal").fadeOut(300);
            $("#regist").attr("action", "actions/action_regist_seminar.php");
        });
        $("#regist").submit(function(e) {
            e.preventDefault()
            let url = $(this).attr('action');
            let remove = $(this).data("tr");
            $.ajax({
                dataType: 'json',
                url: url,
                success: function(data) {
                    remove.remove()
                    $(".modal").fadeOut(100)
                    if (data.status == "success") {
                        $('#notif').text('Berhasil');
                        $('.notif').css({
                            "background-color": "#198754"
                        });
                        $('#success').empty().text(data.message);
                        $('#check').empty().append(data.svg);
                        $('.notif').fadeIn(300);
                        setTimeout(function() {
                            $('.notif').fadeOut(300);
                        }, 3000);
                    } else {
                        $('#notif').text('Error');
                        $('#success').text(data.message);
                        $('#check').empty().append(data.svg);
                        $('.notif').css({
                            "background-color": "#dc3545"
                        }).fadeIn(300);
                        setTimeout(function() {
                            if (data.status == "error") {
                                window.location = data.redirect;
                            }
                            $('.notif').fadeOut(300);
                        }, 2000);
                    }
                }
            });

        })
        $(".inside").click(function() {
            $(this).addClass(".active");
        });
    });
</script>

</html>