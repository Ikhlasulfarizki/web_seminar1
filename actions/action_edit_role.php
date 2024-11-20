<?php
$id = $_POST["id"];
$role = $_POST["role"];
$permission = isset($_POST["permission"]) ? $_POST["permission"] : "";
function edit_role($role, $permission, $id)
{
    include "../koneksi.php";
    $permission_clean = $permission != "" ? json_encode($permission) : null;
    if ($role && $id !== "") {
        $query = $conn->prepare("UPDATE roles SET role_name = ? , permission = ? WHERE id = ?");
        $query->bind_param("ssi", $role, $permission_clean, $id);
        $query->execute();
        $resp =  [
            "status" => "success",
            "message" => 'Data Diubah',
            'svg' => '<i class="fa-solid fa-check-to-slot"></i>',
            "redirect" => "../table_role"
        ];
    } else {
        $resp = [
            "status" => "error",
            "message" => 'Gagal Mengubah Data',
            'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"
        ];
    }
    return $resp;
}
echo json_encode(edit_role($role, $permission, $id));