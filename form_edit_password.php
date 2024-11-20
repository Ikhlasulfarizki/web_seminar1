<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <link rel="icon" href="" type="">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<?php
include "functions.php";
if (validate_auth_token(!empty($_SESSION["auth_token"]) ? $_SESSION["auth_token"] : "")) {
    header("location: ../../login");
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
                            <form action="../actions/action_edit_password.php" method="POST" id="form" class="form-action">
                                <div class="form">
                                    <div class="tittle">
                                        <h1>Ubah Password</h1>
                                        <a id="exit" href="home">Back</a>
                                    </div>
                                    <div class="parent-role">
                                        <div class="input-role">
                                            <div class="group">
                                                <label for="">Password</label>
                                                <div class="password">
                                                    <input type="password" placeholder="Buat Password" class="password-input" name="password" id="password" required>
                                                    <button type="button" class="eye">
                                                        <i class="fa-solid fa-eye icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="group">
                                                <label for="">Password Baru</label>
                                                <div class="password">
                                                    <input type="password" placeholder="Password Baru" class="password-input" name="password_new" id="password-new" required>
                                                    <button type="button" class="eye">
                                                        <i class="fa-solid fa-eye icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="group">
                                                <label for="">Konfirmasi Password</label>
                                                <div class="password">
                                                    <input type="password" placeholder="Konfirmasi Password" class="password-input" name="password_confirm"  required>
                                                    <button type="button" class="eye">
                                                        <i class="fa-solid fa-eye icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="button">
                                            <button type="submit">Edit</button>
                                        </div>
                                    </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../asset/jquery.min.js"></script>
    <script src="../../asset/jquery.validate.min.js"></script>    <script>
        $(window).on("load", function() {
            setTimeout(function() {
                $('.loading').fadeOut(300);
            }, 800);
        });
        $(".eye").click(function() {
            let password = $(this).siblings(".password-input").attr("type");
            let siblings = $(this).siblings(".password-input");
            let icon = $(this).find("i");
            if (password == "password") {
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
                siblings.attr("type", "text");
            } else {
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
                siblings.attr("type", "password");
            }
        })
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
            $("#form").validate({
                rules: {
                    password_confirm:{
                        equalTo: "#password-new"
                    }
                },
                messages: {
                    password: "Harap Masukan Password Anda",
                    password_new: "Harap Masukan Password Baru Anda",
                    password_confirm: {
                        required: "Harap Konfirmasi Password Anda",
                        equalTo: "Password Tidak Sesuai"
                    }
                },
                errorElement: "hr",
                errorPlacement: function(error, element) {
                    error.appendTo(element.closest(".group"));
                },
                submitHandler: function(form) {
                    let url = $(form).attr("action");
                    let method = $(form).attr("method");
                    let data = $(form).serialize();
                    $.ajax({
                        url: url,
                        data: data,
                        method: method,
                        dataType: "json",
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