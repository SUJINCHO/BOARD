<?php
$Connect = mysqli_connect("localhost", "root","autoset","ycj_test");

$title  = $_GET['title'];
$text   = $_GET['text'];
if ($title == ""){
    echo "<script>alert('제목을 입력하세요.'); history.back()</script>";
}
else if ($text == ""){
    echo "<script>alert('내용을 입력하세요.'); history.back()</script>";
}
else {
    $TEXT = nl2br($text);
    /*echo $title;
    echo $text;*/
    $user_name = $_SESSION["loginOK"];
    $user_ID = $_SESSION["user_ID"];
    $date = date("Y-m-d-H-i-s");
    $query = "insert into board_9_11(board_pid, user_id, user_name, 
subject, contents, hits, reg_date) values(0,'$user_ID ','$user_name','$title','$TEXT',0,'$date')";

    if ($result = mysqli_query($Connect, $query)) {
        echo "<script>alert('저장되었습니다.'); location.assign('list.php')</script>";
    }
}
?>