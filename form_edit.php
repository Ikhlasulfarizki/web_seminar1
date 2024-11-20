<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Edit</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
</head>
<?php
include "functions.php";
if (validate_auth_token(empty($_SESSION["auth_token"]) ? "" : $_SESSION["auth_token"])) {
    header("location: ../css/login");
}
if (authorization("user") != true) {
    header("../location: home");
}
$id = $_GET["id"]
?>

<body>
    <div class="loading">
        <div class="gear">
            <i class="fa-solid fa-gear" id="gear1"></i>
            <i class="fa-solid fa-gear" id="gear2"></i>
        </div>
    </div>
    <?php
    include 'koneksi.php';
    $data = profile($id)
    ?>
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
                            <form action="../../actions/action_edit.php" method="POST" id="form" class="form-action">
                                <div class="form">
                                    <div class="tittle">
                                        <h2>Edit Data</h2>
                                        <a id="exit" href="../table">Back</a>
                                    </div>
                                    <div class="parent">
                                        <div class="input">
                                            <input type="hidden" value="<?= $data['id'] ?>" id="id" name="id">
                                            <div class="group">
                                                <label for="">Nama Lengkap</label>
                                                <input type="text" name="name" placeholder="Masukan Nama Lengkap" id="name" value="<?= $data['name'] ?>" required>
                                            </div>
                                            <div class="group">
                                                <label for="">Asal Sekolah</span></label>
                                                <input value="<?= $data['asal_sekolah'] ?>" type="text" name="asal_sekolah" placeholder="Masukan Nama Sekolah" id="asal_sekolah" required>
                                            </div>
                                            <div class="group">
                                                <label for="">Kelas</label>
                                                <select name="kelas" id="kelas" value="" required>
                                                    <option value="" selected disabled>Pilih Kelas</option>
                                                    <option value="X" <?= ($data['kelas'] == 'X') ? 'selected' : '' ?>>X</option>
                                                    <option value="XI" <?= ($data['kelas'] == 'XI') ? 'selected' : '' ?>>XI</option>
                                                    <option value="XII" <?= ($data['kelas'] == 'XII') ? 'selected' : '' ?>>XII</option>
                                                </select>
                                            </div>
                                            <div class="group">
                                                <label for="">Email</label>
                                                <input value="<?= $data['email'] ?>" type="email" name="email" placeholder="Masukan Email" id="email" required>
                                            </div>
                                            <div class="group">
                                                <label for="">No Hp</label>
                                                <input value="<?= $data['no_hp'] ?>" type="text" name="no_hp" placeholder="Masukan Nomor HP" id="no_hp" required>
                                            </div>
                                        </div>
                                        <div class="select">
                                            <div class="group">
                                                <label for="">Provinsi</label>
                                                <select value="<?= $data['provinces'] ?>" name="provinces" id="provinces" data-provname="<?= $data['provinces'] ?>" required>
                                                    <option value="" selected disabled>Pilih Provinsi</option>
                                                </select>
                                            </div>
                                            <div class="group">
                                                <label for="">Kabupaten</label>
                                                <select value="<?= $data['kabupaten'] ?>" name="kabupaten" id="kabupaten" data-kabname="<?= $data['kabupaten'] ?>" required>
                                                    <option value="" selected disabled>Pilih Kabupaten</option>
                                                </select>
                                            </div>
                                            <div class="group">
                                                <label for="">Kecamatan</label>
                                                <select name="kecamatan" value="<?= $data['kecamatan'] ?>" id="kecamatan" data-kecname="<?= $data['kecamatan'] ?>" required>
                                                    <option value="" selected disabled>Pilih Kecamatan</option>
                                                </select>
                                            </div>
                                            <div class="group">
                                                <label for="">Kelurahan</label>
                                                <select name="kelurahan" value="<?= $data['kelurahan'] ?>" id="kelurahan" data-kelname="<?= $data['kelurahan'] ?>" required>
                                                    <option value="" selected disabled>Pilih Kelurahan</option>
                                                </select>
                                            </div>
                                            <div class="group">
                                                <label for="">Role</label>
                                                <div class="check-box">
                                                    <select name="id_role" id="roles" >
                                                        <option value="" selected disabled>Silahkan Masukan Role</option>
                                                        <?php
                                                        $roles = roles();
                                                        foreach ($roles as $role) {
                                                        ?>
                                                            <option value="<?= $role["id"] ?>" <?= $role["id"] == $data["id_role"] ? "selected" : "" ?>><?= $role["role_name"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
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
</body>
<script src="../../asset/jquery.min.js"></script>
<script>
    $(window).on("load", function() {
        setTimeout(function() {
            $('.loading').fadeOut(300);
        }, 1000);
    });
</script>
<script src="../../asset/jquery.validate.min.js"></script>
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
        let id = $('#id').val();
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
        let provname = $('#provinces').data('provname');
        $.ajax({
            url: "../../json/provinces.json",
            dataType: 'json',
            success: function(prov) {
                prov.forEach(function(provinces) {
                    let selectProv = (provname == provinces.name ? 'selected' : '');
                    $('#provinces').append('<option value="' + provinces.name + '"  data-id="' + provinces.id + '" ' + selectProv + '>' + provinces.name + '</option>')
                });
            }
        });

        setTimeout(function() {
            let provid = $('#provinces').find(":selected").data('id');
            console.log(provid)
            let kabname = $('#kabupaten').data('kabname');
            $.ajax({
                url: '../../json/regencies.json',
                dataType: 'json',
                success: function(kab) {
                    kab.forEach(function(kabupaten) {
                        let selectkab = (kabname == kabupaten.name ? 'selected' : '')
                        if (kabupaten.province_id == provid) {
                            $('#kabupaten').append('<option value="' + kabupaten.name + '" data-id="' + kabupaten.id + '" ' + selectkab + '>' + kabupaten.name + '</option>');
                        }
                    });
                }
            });
        }, 50);
        setTimeout(function() {
            let kabid = $('#kabupaten').find(":selected").data('id');
            let kecname = $('#kecamatan').data('kecname');
            $.ajax({
                url: '../../json/districts.json',
                dataType: 'json',
                success: function(kec) {
                    kec.forEach(function(kecamatan) {
                        let selectKec = (kecname == kecamatan.name ? 'selected' : '');
                        if (kecamatan.regency_id == kabid) {
                            $('#kecamatan').append('<option value="' + kecamatan.name + '" data-id="' + kecamatan.id + '" ' + selectKec + '> ' + kecamatan.name + ' </option>')
                        }
                    });
                }
            });
        }, 100);

        setTimeout(function() {
            let kecid = $('#kecamatan').find(':selected').data('id');
            let kelname = $('#kelurahan').data('kelname')
            $.ajax({
                url: '../../json/villages.json',
                dataType: 'json',
                success: function(kel) {
                    kel.forEach(function(kelurahan) {
                        let selectKel = (kelname == kelurahan.name ? 'selected' : '')
                        if (kelurahan.district_id == kecid) {
                            $('#kelurahan').append('<option value="' + kelurahan.name + '" data-id="' + kelurahan.id + '"  ' + selectKel + '> ' + kelurahan.name + ' </option>')
                        }
                    });
                }
            });
        }, 150)

        $('#provinces').change(function() {
            let provid = $(this).find(":selected").data('id');
            if ($('#kabupaten').find(':selected').val() !== "") {
                $('#kabupaten').empty().append('<option selected disabled>Pilih Kabupaten</option>');
                $('#kecamatan').empty().append('<option selected disabled>Pilih Kecamatan</option>');
                $('#kelurahan').empty().append('<option selected disabled>Pilih Kelurahan</option>');
            }

            $.ajax({
                url: '../../json/regencies.json',
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
                url: '../../json/districts.json',
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
                url: '../../json/villages.json',
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

        $(form).validate({
            rules: {
                email: {
                    email: true,
                    remote: {
                        url: "../../actions/remote_email_edit.php",
                        data: {
                            id: id
                        },
                    },
                },
                no_hp: {
                    number: true,
                    minlength: 12,
                    remote: {
                        url: "../../actions/remote_hp_edit.php",
                        data: {
                            id: id
                        },
                    }
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
                    remote: "Nomor Sudah Dipakai",

                },
                provinces: "Pilih Provinsi Dulu",
                kabupaten: "Pilih Kabupaten Dulu",
                kecamatan: "Pilih Kecamatan Dulu",
                kelurahan: "Pilih Kelurahan Dulu",
            },
            errorElement: "hr",
            submitHandler: function(form) {
                let url = $(form).attr('action');
                let method = $(form).attr('method');
                let data = $(form).serialize();
                console.log(data)
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: function(data) {
                        $('.notif').fadeIn(300);
                        let obj = JSON.parse(data);
                        if (obj.success) {
                            $('#notif').text(obj.notif);
                            $('.notif').css({
                                "background-color": "#198754"
                            });
                            $('#success').empty().text(obj.success);
                            $('#check').empty().append(obj.svg);
                            setTimeout(function() {
                                $('.notif').fadeOut(300);
                                window.location = '../table';
                            }, 2000);
                        } else {
                            $('#check').empty().append(obj.svg);
                            $('#notif').text(obj.notif);
                            $('#success').text(obj.error);
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

</html>