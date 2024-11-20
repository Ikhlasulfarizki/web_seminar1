<?php
session_start();
function validate_auth_token_signed($token)
{
    include "koneksi.php";
    if ($token != "") {
        $query = $conn->prepare("SELECT token FROM member WHERE token = ?");
        $query->bind_param("s", $token);
        $query->execute();
        $result = $query->get_result();
        $array = $result->fetch_assoc();
        $conn->close();
        if ($token == isset($array["token"])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function validate_auth_token($token)
{
    include "koneksi.php";
    if ($token != "") {
        $query = $conn->prepare("SELECT token FROM member WHERE token = ?");
        $query->bind_param("s", $token);
        $query->execute();
        $result = $query->get_result();
        $array = $result->fetch_assoc();
        $conn->close();
        if ($token != $array["token"]) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function create_csrf_token()
{
    if (empty($_SESSION["csrf_token"])) {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(25));
    }
    return $_SESSION["csrf_token"];
}
$token = create_csrf_token();
function create_token_auth()
{
    if (empty($_SESSION['auth_token'])) {
        $_SESSION['auth_token'] = bin2hex(random_bytes(25));
    }
    return $_SESSION['auth_token'];
}
function profile($id)
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM member WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();
    $conn->close();
    return $result;
}

function roles()
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM roles");
    $query->execute();
    $array = $query->get_result();
    if ($array->num_rows > 0) {
        while ($role = $array->fetch_assoc()) {
            $arr[] = [
                "id" => $role["id"],
                "role_name" => $role["role_name"],
                "permission" => $role["permission"] != "" ? json_decode($role["permission"]) : null,
            ];
        }
    } else {
        $arr = [];
    }
    $conn->close();
    return $arr;
}

function log_role($id)
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT id,permission FROM roles WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $array = $query->get_result();
    if ($array->num_rows > 0) {
        $arr = $array->fetch_assoc();
        $resp = [
            "permission" => $arr["permission"] != null ? json_decode($arr["permission"]) : "",
        ];
    } else {
        $resp = [];
    }
    $conn->close();
    return $resp;
}

function authorization($pages)
{
    $log_perm = log_role($_SESSION["role"]);
    if ($log_perm != [] && $log_perm != "" && $log_perm["permission"] != null) {
        foreach ($log_perm['permission'] as $perm) {
            if ($perm == $pages) {
                $resp = true;
                break;
            } else {
                $resp = false;
            }
        }
    } else {
        $resp = false;
    }

    return $resp;
}

function id_role($id)
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM roles WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $arr = $query->get_result()->fetch_assoc();
    return $arr;
}

function authrole_check($pages, $id)
{
    $perm = log_role($id);
    if ($perm != [] && $perm['permission'] != "") {
        foreach ($perm["permission"] as $permission) {
            if ($permission == $pages) {
                $resp = true;
                break;
            } else {
                $resp = false;
            }
        }
    } else {
        $resp = false;
    }
    return $resp;
}

function data_seminar($email)
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM peserta_seminar WHERE email_peserta = ?");
    $query->bind_param("i", $email);
    $query->execute();
    $arr = $query->get_result()->fetch_assoc();
    return $arr;
}

function detail_seminar($email)
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM peserta_seminar LEFT JOIN seminar ON peserta_seminar.id_seminar = seminar.id WHERE peserta_seminar.email_peserta = ? ORDER BY waktu_daftar DESC");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = [
                "filename" => $row["filename"],
                "judul" => $row["judul"],
                "no_regist" => $row["no_regist"],
                "waktu_mulai" => $row["waktu_mulai"],
                "status_seminar" => $row["status_seminar"],
                "link" => $row["link"],
                "status" => $row["status"],
            ];
        }
    } else {
        $arr = [];
    }

    return $arr;
}

function all_seminar_displayed()
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT id_user, judul , waktu_mulai , id , filename FROM seminar LIMIT 3");
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = [
                "filename" => $row["filename"],
                "id_user" => $row["id_user"],
                "id" => $row["id"],
                "judul" => $row["judul"],
                "waktu_mulai" => $row["waktu_mulai"],
            ];
        }
    } else {
        return $arr = [];
    }
    return $arr;
}

function all_seminar_display()
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT id_user , judul , waktu_mulai , id , filename FROM seminar");
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = [
                "filename" => $row["filename"],
                "id_user" => $row["id_user"],
                "id" => $row["id"],
                "judul" => $row["judul"],
                "waktu_mulai" => $row["waktu_mulai"],
            ];
        }
    } else {
        return $arr = [];
    }
    return $arr;
}

function table_seminar($id)
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM seminar WHERE id_user = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = [
                "filename" => $row["filename"],
                "id" => $row["id"],
                "judul" => $row["judul"],
                "waktu_mulai" => $row["waktu_mulai"],
                "link" => $row["link"],
                "status_seminar" => $row["status_seminar"]
            ];
        }
    } else {
        return $arr = [];
    }
    return $arr;
}

function get_data_seminar($id)
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM seminar WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();

    return $result;
}

function count_partisipan($id_seminar)
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT COUNT(id_seminar) AS jumlah_partisipan FROM peserta_seminar WHERE id_seminar = ?");
    $query->bind_param("i", $id_seminar);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();
    return $result["jumlah_partisipan"];
}

function partisipan($id_seminar)
{
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM peserta_seminar WHERE id_seminar = ? ORDER BY waktu_daftar");
    $query->bind_param("i", $id_seminar);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = [
                "no_regist" => $row["no_regist"],
                "waktu_daftar" => $row["waktu_daftar"],
                "status" => $row["status"],
                "email_peserta" => $row["email_peserta"],
            ];
        }
    } else {
        $arr = [];
    }

    return $arr;
}

function validate_contributor($id_user , $id_seminar){
    include "koneksi.php";
    $query = $conn->prepare("SELECT id , id_user FROM seminar WHERE id = ?");
    $query->bind_param("i" , $id_seminar);
    $query->execute();
    $result = $query->get_result();
    $array = $result->fetch_assoc();
        if($array["id_user"] != $id_user){
            $resp = true;
        }else{
            $resp = false;
        }
    return $resp;
}

function get_data_faq(){
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM questions");
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $arr[] = [
                "id" => $row["id"],
                "question" => $row["question"],
                "answer" => $row["answer"],
            ];
        }
    } else {
        $arr = [];
    }
    return $arr;
}
function get_data_edit_faq($id){
    include "koneksi.php";
    $query = $conn->prepare("SELECT * FROM questions WHERE id = ?");
    $query-> bind_param("i" , $id);
    $query-> execute();
    $result = $query->get_result();
    if($result->num_rows > 0){
        $resp = $result->fetch_assoc();
    }else{
        header("location: ../table_question");
    }
    return $resp;
}