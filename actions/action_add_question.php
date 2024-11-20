<?php
$question = isset($_POST['question']) ? strip_tags( $_POST["question"]) : '' ;
$answer = isset($_POST['answer']) ? $_POST["answer"] : "";

function add_question($question , $answer){
    include "../koneksi.php";
    $question_clean = $conn->real_escape_string($question);
    $answer_clean =  $conn->real_escape_string($answer);
    if($question_clean != ""){     
        $query = $conn->prepare("INSERT INTO questions (question , answer) VALUES (? , ?)");
        $query->bind_param("ss" , $question_clean , $answer_clean);
        $query->execute();
        $resp = [
            "status" => "success" , 
            "message" => "Pertanyaan Sudah Ditambahkan",
            'svg' => '<i class="fa-solid fa-check-to-slot"></i>',
            "redirect" => '../table_question'
        ];
    }else{
        $resp = [
            "status" => "error" , 
            "message" => "Gagal Menambah Pertanyaan",
            'svg' => "<i class='fa-solid fa-circle-exclamation'></i>"
        ];   
    }
    return json_encode($resp);
}
echo add_question($question , $answer);
?>