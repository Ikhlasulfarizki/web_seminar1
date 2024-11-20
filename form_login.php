<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Seminar</title>
    <link rel="icon" href="" type="">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>
<?php
include "functions.php";
if (validate_auth_token_signed(empty($_SESSION["auth_token"]) ? "" : $_SESSION["auth_token"])) {
    header("location: dashboard/table");
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
    <div class="container-login">
        <form action="actions/action_login.php" method="POST" id="form-login">
            <div class="form-login">
                <div class="title1">
                    <div class="tittle-login">
                        <div class="back">
                            <a href="web_seminar"><i class="fa-solid fa-arrow-left"></i>Kembali</a>
                        </div>
                        <h1>Login</h1>
                        <h4>Masuk Ke Akun Anda</h4>
                    </div>
                </div>
                <div class="parent">
                    <input type="hidden" value="<?= $token ?>" name="token">
                    <div class="input-login">
                            <div class="group">
                                <label for="">Email</label>
                                <input type="text" name="email" placeholder="Masukan Email Anda" id="name" value="" required>
                            </div>
                            <div class="group">
                                <label for="">Password</label>
                                <div class="password">
                                    <input type="password" placeholder="Masukan Password" class="password-input" name="password" required>
                                    <button type="button" class="eye-login">
                                        <i class="fa-solid fa-eye" id="icon"></i>
                                    </button>
                                </div>
                            </div>
                        <div class="button-login">
                            <button type="submit">Masuk</button>
                        </div>
                        <div class="link-regist">
                            <p>Belum punya akun?</p>
                            <a href="registrasi">Daftar disini</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

</body>
<script src="asset/jquery.min.js"></script>
<script src="asset/jquery.validate.min.js"></script>
<script>
    $(window).on("load", function() {
        setTimeout(function() {
            $('.loading').fadeOut(300);
        }, 800);
    });
    $(document).ready(function() {
        $(".eye-login").click(function() {
            let password = $(this).siblings(".password-input").attr("type");
            if (password == "password") {
                $("#icon").removeClass("fa-solid fa-eye").addClass("fa-solid fa-eye-slash");
                $(".password-input").attr("type", "text");
            } else {
                $("#icon").removeClass("fa-solid fa-eye-slash").addClass("fa-solid fa-eye");
                $(".password-input").attr("type", "password");
            }
        });

        $('#form-login').validate({
            rules: {
                email: {
                    email: true
                }
            },
            messages: {
                email: {
                    email: "Harap Masukan Email yang Valid",
                    required: "Harap Masukan Email Terlebih Dahulu!"
                },
                password: "Masukan Password Terlebih Dahulu"
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.closest(".group"));
            },
            errorElement: "hr",
            submitHandler : function(form){
                let url = $("#form-login").attr("action");
            let method = $("#form-login").attr("method");
            let data = $("#form-login").serialize();
            console.log(data);
            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: "json",
                success: function(resp) {
                    if (resp.status == "success") {
                        setTimeout(function() {}, 3000);
                        $('#notif').text('Berhasil!');
                        $('.notif').css({
                            "background-color": "#198754"
                        });
                        $("#check").empty().append(resp.svg);
                        $('#success').empty().text(resp.message);
                        $(".no_reg").text(resp.no_reg);
                        $('.notif').fadeIn(300);
                        setTimeout(function() {
                            $('.notif').fadeOut(300);
                            window.location = resp.redirect;
                        }, 2000)
                    } else {
                        $('#notif').text('Error!');
                        $('#success').text(resp.message);
                        $("#check").empty().append(resp.svg);
                        $('.notif').css({
                            "background-color": "#dc3545"
                        }).fadeIn(300);
                        setTimeout(function() {
                            $('.notif').fadeOut(300);
                        }, 2000);
                    }
                },
                error: function(resp) {
                    $('#notif').text('Error!');
                    $("#check").empty().append('<i class="fa-solid fa-triangle-exclamation"></i>');
                    $('#success').text('Terjadi Kesalahan!');
                    $('.notif').css({
                        "background-color": "#dc3545"
                    }).fadeIn(300);
                    setTimeout(function() {
                        $('.notif').fadeOut(300);
                    }, 2000);
                }
            });
            }
        })
    });
</script>


</html>