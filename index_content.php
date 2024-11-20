<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<!-- <div class="search">
    <input type="text" name="search" id="search" placeholder="Masukan No Registrasi Anda" autocomplete="off">
        <div class="result">
            <div class="results"></div>
        </div>
</div> -->
<?php
include "functions.php";
$validated = validate_auth_token_signed(isset($_SESSION["auth_token"]) ? $_SESSION["auth_token"] : "");
$arr = all_seminar_display();
include "component/navbar1.php";
?>

<body>
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
    <div class="container1">
        <div class="modal">
            <div class="modal-container">
                <div class="modal-padding">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h3>Apakah Anda Ingin Mengikuti Seminar ini?</h3>
                            <i class="fa-solid fa-xmark exit-modal"></i>
                        </div>
                        <div class="modal-content">
                            <span class="tittle-modal"></span>
                        </div>
                        <div class="modal-footer">
                            <form action="" id="regist">
                                <button type="button" class="modal-button decline exit-modal">Tutup</button>
                                <button type="submit" class="modal-button agree">Ikuti</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main">
            <div class="content1">
                <div class="banner-container">
                    <div class="banner-bg">
                        <img src="../props/download.jpg" alt="">
                    </div>
                </div>
                <div class="main-content">
                    <div class="event-container">
                        <div class="event">
                            <div class="event-tittle">
                                <h2>Event Mendatang</h2>
                            </div>
                            <div class="event-card">
                                <?php foreach ($arr as $row) {
                                    $profile = profile(id: $row["id_user"]);
                                    $date = date_create(isset($row["waktu_mulai"]) ? $row["waktu_mulai"] : "");
                                ?>
                                    <div class="event-content">
                                        <div class="img-thumbnail">
                                            <div class="img-relative">
                                                <img src="../upload/<?= $row["filename"] ?>" alt="Thumbnail" class="img-seminar outside">
                                                <div class="date-content">
                                                    <div class="event-inside"><?= date_format($date, "d M Y | H:i") ?> WIB</div>
                                                </div>
                                            </div>
                                            <div class="tittle-event">
                                                <div class="event-inside"><span><?= $profile["name"] ?></div>
                                                <h3><?= $row["judul"] ?></h3>
                                            </div>
                                        </div>
                                        <div class="event-padding">
                                            <div class="event-button">
                                                <span data-id="<?= $row["id"] ?>" data-judul="<?= $row["judul"] ?>" class="join">Daftar</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-top">
            <i class="fa-solid fa-caret-up"></i>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $(window).on("scroll", function() {
            let scroll = $(window).scrollTop();
            if (scroll > 200) {
                $(".scroll-top").css({
                    "right": "20px"
                })
                $(".navbar1").css({
                    "padding": "0px "
                });
            } else {
                $(".navbar1").css({
                    "padding": "5px 0px"
                });
                $(".scroll-top").css({
                    "right": "-60px"
                })
            }
        });

        $("#regist").submit(function(e) {
            e.preventDefault()
            let url = $(this).attr('action');
            $.ajax({
                dataType: 'json',
                url: url,
                success: function(data) {
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

        $('.join').click(function() {
            let data = $(this).data("id");
            let judul = $(this).data("judul");
            $(".tittle-modal").text(judul)
            $(".modal").fadeIn(300);
            $("#regist").attr("action", "../actions/action_regist_seminar.php?id=" + data);
        });

        $(".exit-modal").click(function() {
            $(".modal").fadeOut(300);
            $("#regist").attr("action", "../actions/action_regist_seminar.php");
        });
        $(".scroll-top").click(function() {
            let scroll = $(window).scrollTop();
            if (scroll > 0) {
                $("html").animate({
                    scrollTop: 0
                }, 500);
            }
        });

        $(".trigger").click(function() {
            let display = $(".profile-nav").css("display")
            if (display == "none") {
                $(".profile-nav").fadeIn(200);
            } else {
                $(".profile-nav").fadeOut(200);
            }
        })
    });
</script>

</html>