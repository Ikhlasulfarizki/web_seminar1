<?php
$id = $_GET['id'];
function delete($id){
    include '../koneksi.php';
    include '../functions.php';

    if ($id != ''){ 
        $val = get_data_seminar($id);
        $curentfile = "../upload/" . $val["filename"];
        if($val["filename"] != "thumbnail.jpg"){
            unlink($curentfile);
        }
        $query = $conn->prepare("DELETE FROM seminar WHERE id = ?");   
        $query->bind_param("i" , $id);
        $query->execute();
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