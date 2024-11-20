<?php

$id = $_GET['id'];
$no_hp = $_GET['no_hp'];

function validate($id , $no_hp){
    include '../koneksi.php';

    $query = $conn->prepare("SELECT no_hp , id FROM member WHERE id = ? ");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();
    $validate = $conn->prepare( "SELECT no_hp FROM member WHERE no_hp = ?");
    $validate->bind_param("s" , $no_hp);
    $validate->execute();
    $validated = $validate->get_result();


    if($validated->num_rows > 0){
        $resp = false;
    }else{
        $resp = true;        
    }if($no_hp == $result['no_hp']){
        $resp = true;
    }
    return $resp;
}

$validated = validate($id , $no_hp );
echo json_encode($validated);
?>