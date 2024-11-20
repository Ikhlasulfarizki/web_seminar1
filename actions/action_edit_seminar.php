    <?php
    $judul = isset($_POST["judul"]) ? strip_tags($_POST["judul"]) : "";
    $waktu_mulai = isset($_POST["waktu_mulai"]) ? strip_tags($_POST["waktu_mulai"]) : "";
    $link = isset($_POST["link"]) ? strip_tags($_POST["link"]) : "";
    $status_seminar = isset($_POST["status_seminar"]) ? strip_tags($_POST["status_seminar"]) : "";
    $id = isset($_POST["id"]) ? strip_tags($_POST["id"]) : "";
    $files = isset($_FILES["files"]["name"]) == "" || $_FILES["files"]["name"] == null ? "" : $_FILES["files"]["name"];
    $filestemp = isset($_FILES["files"]["tmp_name"]) ? $_FILES["files"]["tmp_name"] : "";

    function edit_seminar($judul, $waktu_mulai, $link, $status_seminar, $files, $filestemp, $id)
    {
        include "../functions.php";
        include "../koneksi.php";
        $val = get_data_seminar($id);
        $judul_clear = $conn->real_escape_string($judul);
        $waktu_clear = $conn->real_escape_string($waktu_mulai);
        $link_clear = $conn->real_escape_string($link);
        $id_clear = $conn->real_escape_string($id);
        $filename = $files == "" && $files == null ? $val["filename"] : rand() . "-" . $files;
        $dirname = "../upload/" . $filename;
        if ($judul_clear && $waktu_clear != "") {
            if ($files != "" && $files == "thumbnail.jpg") {
                unlink($curentfile);
                move_uploaded_file($filestemp, $dirname);
            }else{
                move_uploaded_file($filestemp, $dirname);
            }

            $query = $conn->prepare("UPDATE seminar SET judul = ? , waktu_mulai = ? , link = ? , status_seminar = ? , filename = ?  WHERE id = ?");
            $query->bind_param("sssssi", $judul_clear, $waktu_clear, $link_clear, $status_seminar, $filename, $id_clear);
            $query->execute();
            $resp = [
                "status" => "success",
                "message" => "Seminar Telah Diubah",
                "svg" => '<i class="fa-solid fa-check-to-slot"></i>',
                "redirect" => "../table_create_seminar"
            ];
        } else {
            $resp = [
                'status' => 'error',
                'message' => 'Gagal Menambah Seminar',
                'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"
            ];
        }
        return $resp;
    }
    $add = edit_seminar($judul, $waktu_mulai, $link, $status_seminar, $files, $filestemp,  $id);
    echo json_encode($add);
