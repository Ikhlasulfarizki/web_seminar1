<?php
$id = $_GET['id'];
$role = $_GET['role'];

function validate($id , $role){
    include '../koneksi.php';

    $query = $conn->prepare("SELECT role_name , id FROM roles WHERE id = ? ");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();

    $validate = $conn->prepare( "SELECT role_name FROM roles WHERE role_name = ?");
    $validate->bind_param("s" , $role);
    $validate->execute();
    $validated = $validate->get_result();

    if($validated->num_rows > 0){
        $resp = false;
        if($role == $result['role_name']){
            $resp = true;
        }
    }else{
        $resp = true;        
    }
    
    return $resp;
}

$validated = validate($id , $role );
echo json_encode($validated);
?>