<?php

$id = $_GET['id'];
function delete($id){
    include '../koneksi.php';

    if ($id != ' '){ 
        $query = mysqli_query($conn, "DELETE FROM roles WHERE id = '$id'");   
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
$del = delete($id);
echo json_encode($del);
?>