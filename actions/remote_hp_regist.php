<?php
$no_hp = $_GET['no_hp'];

function validate($no_hp)
{
    include '../koneksi.php';

    $sql = $conn->prepare("SELECT no_hp FROM member WHERE no_hp = ? ");
    $sql->bind_param("s", $no_hp);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $resp = false;
    } else {
        $resp = true;
    }
    return $resp;
}

$filter_nomor = validate($no_hp);
echo json_encode($filter_nomor);
