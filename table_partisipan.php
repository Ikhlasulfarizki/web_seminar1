<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="../../../css/style1.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
    <link rel="stylesheet" href="../../../fontawesome/css/all.min.css">
</head>
<?php
$id = $_GET["id"];
include "functions.php";
if (validate_auth_token(!empty($_SESSION["auth_token"]) ? $_SESSION["auth_token"] : "")) {
    header("location: ../login");
}
if (authorization("create seminar") != true) {
    header("location:../home");
}
if (validate_contributor($_SESSION["user_id"], $id)) {
    header("location: ../table_create_seminar");
}

$datas = partisipan(id_seminar: $id);
?>

<body>
    <!-- <div class="loading">
        <div class="gear">
            <i class="fa-solid fa-gear" id="gear1"></i>
            <i class="fa-solid fa-gear" id="gear2"></i>
        </div>
    </div> -->
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
                                <span class="tittle-modal"></>
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
                            <a class="back-partisipan" href="../../table_create_seminar">Back</a>
                        </div>
                        <div class="tb">
                            <div class="table">
                                <table id="tables" class="nowrap ">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">Nomor Registrasi</th>
                                            <th data-priority="3">Email</th>
                                            <th data-priority="2">Waktu Mendaftar</th>
                                            <th data-priority="2">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($datas as $data) {
                                            $date = date_create(isset($data["waktu_daftar"]) ? $data["waktu_daftar"] : "");
                                        ?>
                                            <tr>
                                                <td><?= $data["no_regist"] ?></td>
                                                <td><?= $data["email_peserta"] ?></td>
                                                <td><?= date_format($date, "d F Y | H:i:s") ?> WIB</td>
                                                <td class="response">
                                                    <div class="btn-status">
                                                        <?php if ($data["status"] == "pending") { ?>
                                                            <a class="button-status accept" data-id="<?= $data["no_regist"] ?>" data-email="<?= $data["email_peserta"] ?>" data-val="accepted">Accept</a>
                                                            <a class="button-status reject" data-id="<?= $data["no_regist"] ?>" data-email="<?= $data["email_peserta"] ?>" data-val="rejected">Reject</a>
                                                        <?php } else {  ?>
                                                            <div class="resp <?= $data["status"] == "accepted" ? "accept" : "reject" ?>"><?= $data["status"] ?></div>
                                                        <?php } ?>
                                                    </div>
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
        $('.button-status').click(function() {
            let data = $(this).data("id");
            let judul = $(this).data("email");
            $(".tittle-modal").text(data + " | " + judul);
            $(".modal").fadeIn(300);
            $("#regist").attr("action", "../../../actions/action_edit_status.php");
            $("#regist").data("id", $(this).data("id"));
            $("#regist").data("val", $(this).data("val"));
            $("#regist").data("div", $(this).closest(".btn-status"));
        });
        $(".exit-modal").click(function() {
            $(".modal").fadeOut(300);
            $("#regist").attr("action", "../../../actions/action_edit_status.php");
        });
        $("#regist").submit(function(e) {
            e.preventDefault()
            let url = $(this).attr('action');
            let id = $(this).data("id");
            let val = $(this).data("val");
            let div = $(this).data("div");
            $.ajax({
                method: "POST",
                data: {
                    id: id,
                    val: val
                },
                dataType: 'json',
                url: url,
                success: function(data) {
                    $(".modal").fadeOut(100);
                    $(div).remove();
                    $(".response").append(data.append)
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
                                $('#notif').text('Error');
                                $('#success').text(data.message);
                                $('#check').empty().append(data.svg);
                                $('.notif').css({
                                    "background-color": "#dc3545"
                                }).fadeIn(300);
                            }
                            $('.notif').fadeOut(300);
                        }, 2000);
                    }
                }
            });

        })
        $(".trigger").click(function() {
            let display = $(".profile-nav-dashboard").css("display")
            if (display == "none") {
                $(".profile-nav-dashboard").fadeIn(200);
            } else {
                $(".profile-nav-dashboard").fadeOut(200);
            }
        })
        $('#tables').DataTable({
            responsive: true,
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