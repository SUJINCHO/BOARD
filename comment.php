<?php
$Connect = mysqli_connect("localhost", "root","autoset","ycj_test");

$comment = $_GET['comment'];
$user_name = $_SESSION['loginOK'];
$board_id = $_SESSION['alter'];
$date = date("Y-m-d-H-i-s");

if (isset($_GET['del']) == true){
    $del = $_GET['del'];
    $query = "delete from comment where comment_id =".$del;
    $result = mysqli_query($Connect, $query);
    echo "<script>alert('삭제되었습니다.'); history.back();</script>";
}
else {
    if ($comment == "") {
        echo "<script>alert('내용을 입력하세요.'); location.assign('read.php')</script>";
    } else {
        $query = "insert into comment(user_name, board_id, contents, reg_date) values('$user_name',$board_id  ,'$comment','$date')";

        if ($result = mysqli_query($Connect, $query)) {
            echo "<script>alert('저장되었습니다.'); history.back();</script>";
        }
    }
}

?>