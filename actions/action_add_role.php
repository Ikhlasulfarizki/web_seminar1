<?php
$role = isset($_POST['role']) ? strip_tags( $_POST["role"]) : '' ;
$permission = isset($_POST['permission']) ? $_POST["permission"] : "";

function add_role($role , $permission){
    include "../koneksi.php";
    $role_clean = mysqli_real_escape_string($conn , strtolower($role));
    $permission_clean = $permission != "" ? json_encode($permission) : null;
    if($role_clean != ""){     
        $query = $conn->prepare("INSERT INTO roles (role_name , permission) VALUES (? , ?)");
        $query->bind_param("ss" , $role_clean , $permission_clean);
        $query->execute();
        $resp = [
            "status" => "success" , 
            "message" => "Role Ditambahkan",
            'svg' => '<i class="fa-solid fa-check-to-slot"></i>',
            "redirect" => '../table_role'
        ];
    }else{
        $resp = [
            "status" => "error" , 
            "message" => "Gagal Menambah Role",
            'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"
        ];   
    }
    return json_encode($resp);
}
echo add_role($role, $permission);
?>