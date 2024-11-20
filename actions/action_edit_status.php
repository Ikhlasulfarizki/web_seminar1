<?php
$id = isset($_POST["id"]) ? strip_tags($_POST["id"]) : "";
$val = isset($_POST["val"]) ? strip_tags($_POST["val"]) : "";

function update_status($id , $val){
    include "../koneksi.php";
        $id_clear = $conn->real_escape_string($id);
        $val_clear = $conn->real_escape_string($val);
        if($id_clear && $val_clear != ""){
            $query = $conn->prepare("UPDATE peserta_seminar SET status = ? WHERE no_regist = ?");
            $query->bind_param("ss" , $val_clear , $id_clear);
            $query->execute();

                if($val_clear == "accepted"){
                    $class = "accept";
                }else{
                    $class = "reject";
                }

            $resp = [
                "status" => "success",
                "message" => "Status Telah Diubah",
                "svg" => '<i class="fa-solid fa-check-to-slot"></i>',    
                "append" => '<span class="resp '. $class .'">'.$val_clear.'</span>'
            ];
        }else{
            $resp = [
                "status" => "error",
                'message' => 'Gagal Menambah Seminar',
                'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"    
            ];
        }
        return $resp;
}
$update = update_status($id , $val);
echo json_encode($update);
?>
