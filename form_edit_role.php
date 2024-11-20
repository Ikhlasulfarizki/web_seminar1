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

if (authorization("role") != true) {
    header("location:../home");
}

$id = $_GET["id"];
$id_role = id_role($id);
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
                            <form action="../../actions/action_edit_role.php" method="POST" id="form" class="form-action">
                                <input type="hidden" name="id" value="<?= $id_role["id"] ?>" id="id_role">
                                <div class="form">
                                    <div class="tittle">
                                        <h1>Tambah Data</h1>
                                        <a id="exit" href="../table_role">Back</a>
                                    </div>
                                    <div class="parent-role">
                                        <div class="input-role">
                                            <div class="group">
                                                <label for="">Role</label>
                                                <input type="text" name="role" value="<?= $id_role["role_name"] ?>" required>
                                            </div>
                                            <div class="group">
                                                <label for="">Permission</label>
                                                <div class="check-box-role">
                                                    <div class="cb-gap">
                                                        <input type="checkbox" class="cb-role" name="permission[]" value="user" <?= authrole_check("user" , $id)== true ? "checked" : ""  ?> id="user" >
                                                        <label for="user">User</label>
                                                    </div>
                                                    <div class="cb-gap">
                                                        <input type="checkbox" class="cb-role" name="permission[]" value="role" <?= authrole_check("role" , $id) == true ? "checked" : ""  ?> id="role" >
                                                        <label for="role">Role</label>
                                                    </div>
                                                    <div class="cb-gap">
                                                        <input type="checkbox" class="cb-role" name="permission[]" value="create seminar" <?= authrole_check("create seminar" , $id)== true ? "checked" : ""  ?> id="create_seminar" >
                                                        <label for="create_seminar">Create&nbsp;Seminar</label>
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
    <script src="../../asset/jquery.min.js"></script>
    <script src="../../asset/jquery.validate.min.js"></script>    <script>
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
            $("#form").validate({
                rules: {
                    role: {
                        remote: {
                            url : "../../actions/remote_role_edit.php",
                            data : {
                                id: $("#id_role").val()
                            },
                        }
                    }
                },
                messages: {
                    role: {
                        required : "Harap Masukan Nama Role Terlebih Dahulu",
                        remote: "Role ini Sudah Ada"
                    },
                },
                errorElement: "hr",
                submitHandler: function(form){
                    let url = $(form).attr("action");
                    let method = $(form).attr("method");
                    let data = $(form).serialize();
                    $.ajax({
                        url: url,
                        data: data,
                        method: method,
                        dataType: "json",
                        success : function(resp){
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