<?php
$judul = isset($_POST["judul"]) ? strip_tags($_POST["judul"]) : "";
$waktu_mulai = isset($_POST["waktu_mulai"]) ? strip_tags($_POST["waktu_mulai"]) : "";
$link = isset($_POST["link"]) ? strip_tags($_POST["link"]) : null;
$id = isset($_POST["id_user"]) ? strip_tags($_POST["id_user"]) : "";
$files = isset($_FILES["files"]["name"]) == "" || $_FILES["files"]["name"] == null ? "thumbnail.jpg" : $_FILES["files"]["name"];
$filestemp = isset($_FILES["files"]["tmp_name"]) ? $_FILES["files"]["tmp_name"] : "";

function add_seminar($judul, $waktu_mulai, $id, $files, $filestemp, $link)
{
    include "../koneksi.php";
    $judul_clear = $conn->real_escape_string($judul);
    $waktu_clear = $conn->real_escape_string($waktu_mulai);
    $link_clear = $conn->real_escape_string($link);
    $id_clear = $conn->real_escape_string($id);
    $filename = $files != "thumbnail.jpg" ? rand() . "-" . $files : $files;
    $dirname = "../upload/" . $filename;

    if ($judul_clear && $waktu_clear && $id_clear !=  "") {
        $query = $conn->prepare("INSERT INTO seminar(judul , waktu_mulai , filename , link , id_user) VALUES (? , ? , ? , ? , ?)");
        $query->bind_param("ssssi", $judul_clear, $waktu_clear, $filename,  $link_clear, $id_clear);
        $query->execute();
        if($files != "thumbnail.jpg"){
            move_uploaded_file($filestemp, $dirname);
        }
        $resp = [
            "status" => "success",
            "message" => "Seminar Berhasil Ditambahkan",
            "svg" => '<i class="fa-solid fa-check-to-slot"></i>',
            "redirect" => "../table_create_seminar"
        ];
    } else {
        $resp = [
            'status' => 'error',
            'message' => 'Gagal Menambah Seminar',
            'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"
        ];
    }
    return $resp;
}
$add = add_seminar($judul, $waktu_mulai, $id, $files, $filestemp, $link);
echo json_encode($add);
