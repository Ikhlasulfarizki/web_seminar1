<?php
$password = $_POST["password"] != "" && $_POST["password"] != null ? $_POST["password"] : "";
$password_new = $_POST["password_new"] != "" && $_POST["password_new"] != null ? password_hash($_POST['password_new'], PASSWORD_BCRYPT) : "";

function password($password, $password_new)
{
    include "../koneksi.php";
    include "../functions.php";
    if ($password && $password_new !== " ") {
        $arr = profile($_SESSION["user_id"]);
        if (password_verify($password , $arr["password"])) {
            $query = $conn->prepare("UPDATE member SET password = ? WHERE id = ?");
            $query->bind_param("si", $password_new, $arr["id"]);
            $query->execute();
            $resp =  [
                "status" => "success",
                "message" => 'Data Diubah',
                'svg' => '<i class="fa-solid fa-check-to-slot"></i>',
            ];
        }else{
            $resp = [
                "status" => "error",
                "message" => 'Password Lama Tidak Sesuai',
                'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"
            ];    
        }
    } else {
        $resp = [
            "status" => "error",
            "message" => 'Gagal Mengubah Data',
            'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"
        ];
    }
    return $resp;
}
echo json_encode(password($password, $password_new));
