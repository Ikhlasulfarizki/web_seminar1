<?php

$id = $_GET['id'];
$email = $_GET['email'];

function validate($id , $email){
    include '../koneksi.php';

    $query = $conn->prepare("SELECT email , id FROM member WHERE id = ? ");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();
    $validate = $conn->prepare( "SELECT email FROM member WHERE email = ?");
    $validate->bind_param("s" , $email);
    $validate->execute();
    $validated = $validate->get_result();


    if($validated->num_rows > 0){
        $resp = false;
    }else{
        $resp = true;        
    }if($email == $result['email']){
        $resp = true;
    }
    return $resp;
}

$validated = validate($id , $email );
echo json_encode($validated);
?>