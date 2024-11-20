<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Seminar</title>
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

    <div class="container">
        <form action="actions/action_regist.php" method="POST" id="form" class="form-action">
            <div class="form">
                <div class="tittle">
                    <h1>Registrasi Seminar</h1>
                </div>
                <div class="parent">
                    <div class="input">
                        <div class="group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="name" placeholder="Masukan Nama Lengkap" id="name" value="">
                        </div>
                        <div class="group">
                            <label for="">Asal Sekolah</span></label>
                            <input value="" type="text" name="asal_sekolah" placeholder="Masukan Nama Sekolah" id="asal_sekolah" required>
                        </div>
                        <div class="group">
                            <label for="">Kelas</label>
                            <select name="kelas" id="kelas" value=" " required>
                                <option value="" selected disabled>Pilih Kelas</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="group">
                            <label for="">Email</label>
                            <input value="" type="email" name="email" placeholder="Masukan Email Anda (cth: ikhlas@example.com)" id="email" required>
                        </div>
                        <div class="group">
                            <label for="">No Hp</label>
                            <input value="" type="text" name="no_hp" placeholder="Masukan Nomor HP Anda (cth: 0895 1552 9348)" id="no_hp" required>
                        </div>
                    </div>
                    <div class="select">
                        <div class="group">
                            <label for="">Password</label>
                            <div class="password">
                                <input type="password" placeholder="Buat Password" class="password-input" name="password" required>
                                <button type="button" class="eye">
                                    <i class="fa-solid fa-eye" id="icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="group">
                            <label for="">Provinsi<span id="provinces-err"></span></label>
                            <select value="" name="provinces" id="provinces" value="" required>
                                <option value="" selected disabled>Pilih Provinsi</option>
                            </select>
                        </div>
                        <div class="group">
                            <label for="">Kabupaten<span id="kabupaten-err"></span></label>
                            <select name="kabupaten" id="kabupaten" required>
                                <option value="" selected disabled>Pilih Kabupaten</option>
                            </select>
                        </div>
                        <div class="group">
                            <label for="">Kecamatan<span id="kecamatan-err"></span></label>
                            <select name="kecamatan" id="kecamatan" required>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="group">
                            <label for="">Kelurahan<span id="kelurahan-err"></span></label>
                            <select name="kelurahan" id="kelurahan" required>
                                <option value="" selected disabled>Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="button">
                    <button type="submit">Daftar</button>
                </div>
                <div class="link-regist">
                    <p>Sudah punya akun?</p>
                    <a href="login">Login disini</a>
                </div>

            </div>
        </form>
        <script src="asset/jquery.min.js"></script>
        <script src="asset/jquery.validate.min.js"></script>
        <script>
            $(window).on("load", function() {
                setTimeout(function() {
                    $('.loading').fadeOut(300);
                }, 800);
            });
            $(document).ready(function() {
                $.ajax({
                    url: "json/provinces.json",
                    dataType: 'json',
                    success: function(prov) {
                        prov.forEach(function(provinces) {
                            $('#provinces').append('<option value="' + provinces.name + '"  data-id="' + provinces.id + '">' + provinces.name + '</option>')
                        });
                    }
                });

                $('#provinces').change(function() {
                    let provid = $(this).find(":selected").data('id');
                    if ($('#kabupaten').find(':selected').val() !== "") {
                        $('#kabupaten').empty().append('<option selected disabled>Pilih Kabupaten</option>');
                        $('#kecamatan').empty().append('<option selected disabled>Pilih Kecamatan</option>');
                        $('#kelurahan').empty().append('<option selected disabled>Pilih Kelurahan</option>');
                    }

                    $.ajax({
                        url: 'json/regencies.json',
                        dataType: 'json',
                        success: function(kab) {
                            kab.forEach(function(kabupaten) {
                                if (kabupaten.province_id == provid) {
                                    $('#kabupaten').append('<option value="' + kabupaten.name + '" data-id="' + kabupaten.id + '" >' + kabupaten.name + '</option>');
                                }
                            });
                        }
                    });
                });

                $('#kabupaten').change(function() {
                    let kabid = $(this).find(':selected').data('id')
                    if ($('#kecamatan').find(':selected').val() !== "") {
                        $('#kecamatan').empty().append('<option selected disabled >Pilih Kecamatan</option>');
                        $('#kelurahan').empty().append('<option selected disabled>Pilih Kelurahan</option>');
                    }
                    $.ajax({
                        url: 'json/districts.json',
                        dataType: 'json',
                        success: function(kec) {
                            kec.forEach(function(kecamatan) {
                                if (kecamatan.regency_id == kabid) {
                                    $('#kecamatan').append('<option value="' + kecamatan.name + '" data-id="' + kecamatan.id + '"> ' + kecamatan.name + ' </option>')
                                }
                            });
                        }
                    });
                });

                $('#kecamatan').change(function() {
                    let kecid = $(this).find(':selected').data('id')
                    if ($('#kelurahan').find(':selected').val() !== "") {
                        $('#kelurahan').empty().append('<option selected disabled>Pilih Kelurahan</option>');
                    }
                    $.ajax({
                        url: 'json/villages.json',
                        dataType: 'json',
                        success: function(kel) {
                            kel.forEach(function(kelurahan) {
                                if (kelurahan.district_id == kecid) {
                                    $('#kelurahan').append('<option value="' + kelurahan.name + '" data-id="' + kelurahan.id + '"> ' + kelurahan.name + ' </option>')
                                }
                            });
                        }
                    });
                });

                $(".eye").click(function() {
                    let password = $(this).siblings(".password-input").attr("type");
                    if (password == "password") {
                        $("#icon").removeClass("fa-solid fa-eye").addClass("fa-solid fa-eye-slash");
                        $(".password-input").attr("type", "text");
                    } else {
                        $("#icon").removeClass("fa-solid fa-eye-slash").addClass("fa-solid fa-eye");
                        $(".password-input").attr("type", "password");
                    }
                })


                $("#form").validate({
                    rules: {
                        email: {
                            email: true,
                            remote: "actions/remote_email_regist.php",
                        },
                        no_hp: {
                            number: true,
                            minlength: 12,
                            remote: "actions/remote_hp_regist.php"
                        }
                    },
                    messages: {
                        name: "Harap Masukan Nama Terlebih Dahulu",
                        email: {
                            required: "Harap Masukan Email Terlebih Dahulu",
                            email: "Harap Masukan Email yang Valid",
                            remote: "Email Sudah Dipakai",
                        },
                        asal_sekolah: "Harap Masukan Asal Sekolah dulu",
                        kelas: "Pilih Kelas Dulu",
                        no_hp: {
                            required: "Harap Masukan NoHp Dulu",
                            number: "Harap Harap Masukan Angka",
                            minlength: "Harap Masukan Minimal {0} Angka!",
                            remote: "Nomor Ini Sudah Digunakan"
                        },
                        password: "Harap Buat Password Anda",
                        provinces: "Pilih Provinsi Dulu",
                        kabupaten: "Pilih Kabupaten Dulu",
                        kecamatan: "Pilih Kecamatan Dulu",
                        kelurahan: "Pilih Kelurahan Dulu",
                    },
                    errorPlacement: function(error, element) {
                        error.appendTo(element.closest(".group"));
                    },
                    errorElement: "hr",

                    submitHandler: function(form) {
                        let url = $('#form').attr('action');
                        let method = $('#form').attr('method');
                        let data = $('#form').serialize();
                        $.ajax({
                            url: url,
                            type: method,
                            dataType: 'json',
                            // contentType: "aplication/json",
                            data: data,
                            success: function(data) {
                                console.log(data)
                                if (data.success) {
                                    $('#name').empty().val('');
                                    $('#asal_sekolah').empty().val('');
                                    $('#no_hp').empty().val('');
                                    $('#email').empty().val('');
                                    $('.password-input').empty().val('');
                                    $('#kelas').val('');
                                    $('#provinces').val('');
                                    $('#kabupaten').append('<option selected disabled>Pilih Kabupaten</option>').val();
                                    $('#kelurahan').append('<option selected disabled>Pilih Kecamatan</option>').val();
                                    $('#kecamatan').append('<option selected disabled>Pilih Keluarahan</option>').val();
                                    $('#notif').text(data.notif);
                                    $('.notif').css({
                                        "background-color": "#198754"
                                    });
                                    $('#success').empty().text(data.success);
                                    $('#check').empty().append(data.svg);
                                    $('.notif').fadeIn(300);
                                    setTimeout(function() {
                                        $('.notif').fadeOut(300);
                                    }, 3000);
                                } else {
                                    $('#check').empty().append(data.svg);
                                    $('#notif').text(data.notif);
                                    $('#success').text(data.error);
                                    $('.notif').css({
                                        "background-color": "#dc3545"
                                    });
                                    setTimeout(function() {
                                        $('.notif').fadeOut(300);
                                    }, 3000);
                                }
                            }
                        });
                    }
                });
            });
        </script>
</body>

</html>