<?php
include '../koneksi.php';

$id = mysqli_real_escape_string($conn, $_POST['id']);
$name = isset($_POST['name']) ? strip_tags(mysqli_real_escape_string($conn , $_POST['name'])) : ''; 
$asal_sekolah = isset($_POST['asal_sekolah']) ? strip_tags(mysqli_real_escape_string($conn , $_POST['asal_sekolah'])) : '' ;
$email = isset($_POST['email']) ? strip_tags(mysqli_real_escape_string($conn , $_POST['email'])) : '' ;
$no_hp = isset($_POST['no_hp']) ? strip_tags(mysqli_real_escape_string($conn , $_POST['no_hp'])) : '' ;
$kelas = isset($_POST['kelas']) ? strip_tags(mysqli_real_escape_string($conn , $_POST['kelas'])): '' ;
$provinces = isset($_POST['provinces']) ? strip_tags(mysqli_real_escape_string($conn , $_POST['provinces'])) : '' ;
$kabupaten = isset($_POST['kabupaten']) ? strip_tags(mysqli_real_escape_string($conn , $_POST['kabupaten'])) : '' ;
$kecamatan = isset($_POST['kecamatan']) ? strip_tags(mysqli_real_escape_string($conn ,$_POST['kecamatan'])) : '' ;
$kelurahan = isset($_POST['kelurahan']) ? strip_tags(mysqli_real_escape_string($conn , $_POST['kelurahan'])) : '' ;
$id_role = isset($_POST['id_role']) ? strip_tags(mysqli_real_escape_string($conn , $_POST['id_role'])) : '' ;

function edit($id, $name, $asal_sekolah, $email, $no_hp, $provinces, $kabupaten, $kecamatan, $kelurahan, $kelas, $id_role){
    include '../koneksi.php';

if ($name && $asal_sekolah && $email && $no_hp && $provinces && $kabupaten && $kecamatan && $kelurahan && $kelas && $id_role != ""){
    $stmt = mysqli_prepare($conn,"UPDATE member SET name = ? , asal_sekolah = ? , email = ? , no_hp = ? , provinces = ? , kabupaten = ? , kecamatan = ? , kelurahan = ? , kelas = ? , id_role = ? WHERE id = ?") ;
    $stmt->bind_param("sssssssssii", $name,$asal_sekolah, $email, $no_hp, $provinces, $kabupaten, $kecamatan, $kelurahan, $kelas, $id_role, $id);
    $stmt->execute();

    $data = ['success' => 'Data Diubah' , 'notif' => 'Berhasil!' ,  'svg' => '<i class="fa-solid fa-check-to-slot"></i>'];
    }else{
    $data = ['error' => 'Gagal Mengubah Data' , 'notif' => 'Error!'  , 'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"];
}
    echo json_encode( $data);
}

edit ($id,$name, $asal_sekolah, $email, $no_hp, $provinces, $kabupaten, $kecamatan, $kelurahan,$kelas ,$id_role);
?>