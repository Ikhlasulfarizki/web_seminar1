<?php

$id = $_GET['id'];
function delete_question($id){
    include '../koneksi.php';

    if ($id != ' '){ 
        $data = [
            "status" => "success",
            "message" => "Data Terhapus",
            "svg" => '<i class="fa-solid fa-circle-check"></i>'
        ];
    }else{
        $data = [ 
            "status" => "error",
            "message" => "Data Tidak Ditemukan"
        ];
    }
    return $data; 
}
$del = delete_question($id);
echo json_encode($del);
?>