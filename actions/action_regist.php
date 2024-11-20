<?php
include '../koneksi.php';
isset($_POST['name']) ? $name = strip_tags(mysqli_real_escape_string($conn , $_POST['name'])) : ''; 
isset($_POST['asal_sekolah']) ? $asal_sekolah = strip_tags(mysqli_real_escape_string($conn , $_POST['asal_sekolah'])) : '' ;
isset($_POST['email']) ? $email = strip_tags(mysqli_real_escape_string($conn , $_POST['email'])) : '' ;
isset($_POST['no_hp']) ? $no_hp = strip_tags(mysqli_real_escape_string($conn , $_POST['no_hp'])) : '' ;
isset($_POST['kelas']) ? $kelas = strip_tags(mysqli_real_escape_string($conn , $_POST['kelas'])): '' ;
isset($_POST['password']) ? $password = strip_tags(mysqli_real_escape_string($conn , password_hash($_POST['password'], PASSWORD_BCRYPT))) : '' ;
isset($_POST['provinces']) ? $provinces = strip_tags(mysqli_real_escape_string($conn , $_POST['provinces'])) : '' ;
isset($_POST['kabupaten']) ? $kabupaten = strip_tags(mysqli_real_escape_string($conn , $_POST['kabupaten'])) : '' ;
isset($_POST['kecamatan']) ? $kecamatan = strip_tags(mysqli_real_escape_string($conn ,$_POST['kecamatan'])) : '' ;
isset($_POST['kelurahan']) ? $kelurahan = strip_tags(mysqli_real_escape_string($conn , $_POST['kelurahan'])) : '' ;

function regist($name, $asal_sekolah, $email, $no_hp, $password, $provinces, $kabupaten, $kecamatan, $kelurahan,$kelas){
    include '../koneksi.php';
    if ($name && $asal_sekolah && $email && $no_hp && $provinces && $kabupaten && $kecamatan && $kelurahan && $kelas){
        if ($name && $asal_sekolah && $email && $no_hp && $provinces && $kabupaten && $kecamatan && $kelurahan && $kelas != ""){
            $role_name = "user";
            $query = $conn->prepare("SELECT id FROM roles WHERE role_name = ?");
            $query->bind_param("s" , $role_name);
            $query->execute();
            $id_role = $query->get_result()->fetch_assoc();
    
            $stmt = $conn->prepare("INSERT INTO member (name, asal_sekolah, email, no_hp, password,  provinces, kabupaten, kecamatan, kelurahan, kelas, id_role) VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?)");
            $stmt->bind_param("ssssssssssi", $name, $asal_sekolah, $email, $no_hp, $password, $provinces, $kabupaten, $kecamatan, $kelurahan, $kelas , $id_role["id"]);
            $stmt->execute();
            $data = [
            'success' => 'Berhasil Mendaftar' ,
            'notif' => 'Berhasil!' ,  
            'svg' => '<i class="fa-solid fa-check-to-slot"></i>'
        ];
    }else{
        $data = [
        'error' => 'Gagal Menambah Data' ,
        'notif' => 'Error!'  , 
        'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"
    ];
    }
    echo json_encode($data);
}
}
// header("Content-Type: aplication/json");
regist($name, $asal_sekolah, $email, $no_hp, $password, $provinces, $kabupaten, $kecamatan, $kelurahan,$kelas);
?>