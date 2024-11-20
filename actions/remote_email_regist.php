<?php
$email = $_GET['email'];

function validate($email)
{
    include '../koneksi.php';

    $sql = $conn->prepare("SELECT email FROM member WHERE email = ? ");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $resp = false;
    } else {
        $resp = true;
    }
    return $resp;
}

$filter_nomor = validate($email);
echo json_encode($filter_nomor);
