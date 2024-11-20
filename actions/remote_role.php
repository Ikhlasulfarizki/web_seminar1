<?php
include '../koneksi.php';

$role = mysqli_real_escape_string($conn, $_GET['role']);

function validate($role){
    include '../koneksi.php';

    $sql = $conn->prepare("SELECT role_name FROM roles WHERE role_name = ? ");
    $sql->bind_param("s" , $role);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0){
        $resp = false;
    }else{
        $resp =  true;
    }
    return $resp;
}
$filter_role = validate($role);
echo json_encode($filter_role);
?>