<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
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
include "component/navbar1.php";
$arr = all_seminar_displayed();
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
                        <img src="props/download.jpg" alt="">
                    </div>
                </div>
                <div class="main-content">
                    <div class="content-tittle">
                        <h1>Kategori Seminar</h1>
                    </div>
                    <div class="category-container">
                        <div class="category-box">
                            <div class="category-content">
                                <img src="props/android.jpg" alt="">
                                <div class="category-tittle">
                                    <span>Android Developer</span>
                                </div>
                            </div>
                            <div class="category-content">
                                <div class="category-inside">
                                    <img src="props/frontend.jpg" alt="">
                                    <div class="category-tittle">
                                        <span>Front-End Developer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="category-content">
                                <div class="category-inside">
                                    <img src="props/backend.jpg" alt="">
                                    <div class="category-tittle">
                                        <span>Back-End Developer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="category-content">
                                <div class="category-inside">
                                    <img src="props/ios.jpg" alt="">
                                    <div class="category-tittle">
                                        <span>iOS Developer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="event-container">
                        <div class="event">
                            <div class="event-tittle">
                                <h2>Event Mendatang</h2>
                                <h4><a href="web_seminar/event_mendatang">Lihat Selengkapnya</a></h4>
                            </div>
                            <div class="event-card">
                                <?php if ($arr != []) {
                                    foreach ($arr as $row) {
                                        $date = date_create(isset($row["waktu_mulai"]) ? $row["waktu_mulai"] : "");
                                        $profile = profile(id: $row["id_user"]);
                                ?>
                                        <div class="event-content">
                                            <div class="img-thumbnail">
                                                <div class="img-relative">
                                                <img src="upload/<?= $row["filename"] ?>" alt="Thumbnail" class="img-seminar outside">
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
                                                <div>
                                                </div>
                                                <div class="event-button">
                                                    <span data-id="<?= $row["id"] ?>" data-judul="<?= $row["judul"] ?>" class="join">Daftar</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="event-content">
                                        <div class="img-thumbnail">
                                            <img src="upload/thumbnail.jpg" alt="Thumbnail" class="img-seminar outside">
                                        </div>
                                        <div class="event-padding">
                                            <div>
                                                <div class="tittle-event">
                                                    <h3>Belum Ada Event</h3>
                                                </div>
                                            </div>
                                            <div class="event-button">
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
        <!-- <div class="scroll-top">
            <i class="fa-solid fa-caret-up"></i>
        </div> -->
        <footer>
            <div class="container-footer">
                <div class="desc-footer">
                    <h2>Website Seminar</h2>
                    <span>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo voluptatum commodi blanditiis ab minima molestias ea ducimus repellendus numquam deserunt. Ex odit non aperiam accusantium autem laudantium magni molestiae maiores?
                    </span>
                </div>
                <div class="about-footer">
                    <h2>Kontak</h2>
                    <div class="group-footer">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Jl. Rosela 9-13, Sumber Rejo, Kec. Kemiling, Kota Bandar Lampung, Lampung 35155</span>
                    </div>
                    <div class="group-footer">
                        <i class="fa-solid fa-phone"></i>
                        <span>+6289515519428</span>
                    </div>
                    <div class="group-footer">
                        <i class="fa-solid fa-envelope"></i>
                        <span>ikhlasikhlasul383@gmail.com</span>
                    </div>
                </div>
                <div class="contact-footer">
                    <h2>Link</h2>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-tiktok"></i>
                    <i class="fa-brands fa-linkedin"></i>
                </div>
            </div>
            <div class="footer-foot">

            </div>
        </footer>
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
            $("#regist").attr("action", "actions/action_regist_seminar.php?id=" + data);
        });

        $(".exit-modal").click(function() {
            $(".modal").fadeOut(300);
            $("#regist").attr("action", "actions/action_regist_seminar.php");
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