<?php
include "../koneksi.php";
include "../functions.php";

$email = strip_tags(mysqli_real_escape_string($conn, $_POST['email']));
$password = strip_tags(mysqli_real_escape_string($conn, $_POST['password']));
$token = strip_tags(mysqli_real_escape_string($conn, $_POST['token']));

function login($email, $password, $token)
{
    include "../koneksi.php";
    if($token == $_SESSION['csrf_token']){
        $email_query = $conn->prepare("SELECT * FROM member WHERE email = ?");
        $email_query->bind_param("s", $email);
        $email_query->execute();
        $result_email = $email_query->get_result();
        $array = $result_email->fetch_assoc();
        if (mysqli_num_rows(result: $result_email) > 0) {
            if(password_verify($password , $array["password"])){
                    $auth_token = create_token_auth();
                    $update = $conn->prepare("UPDATE member SET token = ? where email = ?");
                    $update->bind_param("ss", $auth_token, $email);
                    $update->execute();
                    $_SESSION["user_id"] = $array["id"];
                    $_SESSION["role"] = $array["id_role"];
                    $name = profile($_SESSION["user_id"]);
                    $resp = ["status" => "success", "message" => "Selamat Datang" ." ".  $name["name"] ."!"  , "redirect" => "web_seminar", "svg" => '<i class="fa-solid fa-circle-check"></i>'];
                }else{
                    $resp = ["status" => "failed", "message" => "Email dan Password Tidak Valid!", "svg" => "<i class='fa-solid fa-circle-exclamation'></i>"];
                }
        }else{
            $resp = ["status" => "failed", "message" => "Email Belum Terdaftar", "svg" => "<i class='fa-solid fa-circle-exclamation'></i>"];
        }
    }else{
        $resp = ["status" => "failed", "message" => "Token Tidak Valid!", "svg" => '<i class="fa-solid fa-triangle-exclamation"></i>'];
    }
    return $resp;
}

$log = login($email, $password, $token);
echo json_encode($log);