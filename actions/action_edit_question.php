<?php
$id = $_POST["id"];
$question = $_POST["question"];
$answer = isset($_POST["answer"]) ? $_POST["answer"] : "";
function edit_question($question, $answer, $id)
{
    include "../koneksi.php";
    $question_clean = $conn->real_escape_string($question);
    $answer_clean = $conn->real_escape_string($answer);
    if ($question && $id !== "") {
        $query = $conn->prepare("UPDATE questions SET question = ? , answer = ? WHERE id = ?");
        $query->bind_param("ssi", $question_clean, $answer_clean, $id);
        $query->execute();
        $resp =  [
            "status" => "success",
            "message" => 'Data Diubah',
            'svg' => '<i class="fa-solid fa-check-to-slot"></i>',
            "redirect" => "../table_question"
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
echo json_encode(edit_question($question, $answer, $id));