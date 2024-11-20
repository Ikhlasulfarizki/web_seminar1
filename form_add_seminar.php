<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <link rel="icon" href="" type="">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
</head>
<?php
include "functions.php";
if (validate_auth_token(!empty($_SESSION["auth_token"]) ? $_SESSION["auth_token"] : "")) {
    header("location: ../../login");
}
if (authorization("create seminar") != true) {
    header("location:../home");
}

?>

<body>
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
    <div class="loading">
        <div class="gear">
            <i class="fa-solid fa-gear" id="gear1"></i>
            <i class="fa-solid fa-gear" id="gear2"></i>
        </div>
    </div>
    <div class="main">
        <?php
        include "component/navbar.php";
        ?>
        <div class="container-tb">
            <?php
            include "component/sidebar.php";
            ?>
            <div class="container-content">
                <div class="content">
                    <div class="tb">
                        <div class="container-form">
                            <form action="../../actions/action_add_seminar.php" method="POST" id="form" class="form-action" >
                                <div class="form">
                                    <div class="tittle">
                                        <h1>Tambah Data</h1>
                                        <a id="exit" href="../table_create_seminar">Back</a>
                                    </div>
                                    <div class="parent">
                                        <div class="input">
                                            <input type="hidden" name="id_user" value="<?= $_SESSION['user_id'] ?>">
                                            <div class="group">
                                                <label for="">Judul Seminar</label>
                                                <input type="text" name="judul" required placeholder="Masukan Judul Seminar">
                                            </div>
                                            <div class="group">
                                                <label for="">Link</label>
                                                <input type="text" name="link" placeholder="Masukan Link Seminar">
                                            </div>
                                            <div class="group">
                                                <label for="">Tanggal Mulai</label>
                                                <input type="datetime-local" name="waktu_mulai">
                                            </div>
                                        </div>
                                        <div class="select">
                                            <div class="group">
                                                <label for="">Gambar</label>
                                                <input type="file" name="files" class="files">
                                                <div class="img-prev-container">
                                                    <img src="../../props/thumbnail.jpg" alt="" class="prev-img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button">
                                        <button type="submit">Tambah</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../asset/jquery.min.js"></script>
    <script src="../../asset/jquery.validate.min.js"></script>    
    <script>
        $(window).on("load", function() {
            setTimeout(function() {
                $('.loading').fadeOut(300);
            }, 800);
        });
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
        $(document).ready(function() {
            $(".files").change(function() {
                    let img = $(this).siblings(".img-prev-container").find("img")
                    let reader = new FileReader();
                    if (this.files && this.files[0]) {
                        reader.onload = function(e) {
                            img.attr("src", e.target.result)
                        }
                    }
                    let resp = reader.readAsDataURL((this.files[0]))
                }),
                $("#form").validate({
                    rules: {
                        link: {
                            url: true
                        }
                    },
                    messages: {
                        judul: {
                            required: "Harap Masukan Nama judul Terlebih Dahulu",
                            remote: "judul ini Sudah Ada"
                        },
                        waktu_mulai: "Tentukan Waktu Mulai Terlebih Dahulu",
                        link: {
                            url: "Harap Masukan Url yang Valid"
                        }
                    },
                    errorElement: "hr",
                    submitHandler: function(form) {
                        let url = $(form).attr("action");
                        let method = $(form).attr("method");
                        let data = new FormData(form);
                        $.ajax({
                            url: url,
                            data: data,
                            method: method,
                            dataType: "json",
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function(resp) {
                                if (resp.status == "success") {
                                    $('#notif').text("Success !");
                                    $('.notif').css({
                                        "background-color": "#198754"
                                    });
                                    $('#success').text(resp.message);
                                    $('#check').empty().append(resp.svg);
                                    $('.notif').fadeIn(300);
                                    setTimeout(function() {
                                        $('.notif').fadeOut(300);
                                        location.href = resp.redirect;
                                    }, 2000);
                                } else {
                                    $('#check').empty().append(resp.svg);
                                    $('#notif').text("Failed !");
                                    $('#success').text(resp.message);
                                    $('.notif').css({
                                        "background-color": "#dc3545"
                                    });
                                    $('.notif').fadeIn(300);
                                    setTimeout(function() {
                                        $('.notif').fadeOut(300);
                                    }, 2000);
                                }
                            }
                        });
                    }
                });
        });
    </script>