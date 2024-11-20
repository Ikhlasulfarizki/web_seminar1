<?php
$search = isset($_GET["search"]) ? strip_tags(trim($_GET["search"])) : '';

function search($search){
    include "../koneksi.php";
    $search_clean = $conn->real_escape_string($search);
    $query = $conn->prepare("SELECT * FROM peserta_seminar WHERE no_regist = ?");
    $query->bind_param("s" , $search_clean);
    $query->execute();
    $result = $query->get_result();
    $arr = $result->fetch_assoc();
    if($result->num_rows > 0){
        $resp = [
         "status" => "success" ,
         "resp" => ' <table>
                        <thead>
                            <tr>
                                <th>No Registrasi</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>'.$arr["no_regist"].'</td>
                                <td>'.$arr["email_peserta"].'</td>
                                <td>'.$arr["status"].'</td>
                            </tr>
                        </tbody>
                    </table>'
        ];
    }else{
        $resp = [
        "status" => "error" ,
        "resp" => "Data Tidak Ditemukan"
        ];
    }
    return $resp;
}
$searching = search($search);
echo json_encode($searching);
?>