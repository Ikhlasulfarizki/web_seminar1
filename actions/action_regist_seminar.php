<?php
$id_seminar = isset($_GET["id"]) ? $_GET["id"] : "";
function regist_seminar($id_seminar)
{
    include "../koneksi.php";
    include "../functions.php";
    $arr = profile(isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : '' );
    
    if(validate_auth_token_signed(isset($_SESSION["auth_token"]) ? $_SESSION["auth_token"] : "" ) ){
        $check = $conn->prepare("SELECT email_peserta FROM peserta_seminar WHERE email_peserta = ?  AND id_seminar = ?");
        $check->bind_param("si" , $arr["email"] , $id_seminar);
        $check->execute();
        $result = $check->get_result();
        if($result->num_rows < 1){
            $id_seminar_clear = $conn->real_escape_string($id_seminar);
            $no_reg = bin2hex(random_bytes(length: 5));
            $query = $conn->prepare("INSERT INTO peserta_seminar (no_regist, id_seminar, email_peserta) VALUES (?, ?, ?)");
            $query->bind_param("sis", $no_reg, $id_seminar_clear, $arr["email"]);
            $query->execute();
            $resp = ["status" => "success", "message" => "Berhasil Mendaftar", "svg" => '<i class="fa-solid fa-check-to-slot"></i>', "no_reg" => 'NO REGISTRASI : ' . $no_reg];
        }else{
            $resp = ["status" => "failed", "message" => "Anda Sudah Terdaftar", "svg" => '<i class="fa-solid fa-check-to-slot"></i>'];
        }
    } else {
        $resp = ["status" => "error", "message" => "Harap Login Terlebih Dahulu", "svg" => '<i class="fa-solid fa-check-to-slot"></i>', "redirect" => "login"];
    }
    return $resp;
}

$log = regist_seminar( $id_seminar);
echo json_encode($log);