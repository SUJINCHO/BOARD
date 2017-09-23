<?php
$Connect = mysqli_connect("localhost", "root","autoset","ycj_test");

$query = "select * from board_9_11";
$result = mysqli_query($Connect,$query);
$title = $_GET['title'];
$text = $_GET['text'];

$TEXT = nl2br($text);
$query = "update board_9_11 set subject='$title' WHERE board_id =".$_SESSION['alter'];
$result = mysqli_query($Connect, $query);
$query = "update board_9_11 set contents = '$TEXT' where board_id =".$_SESSION['alter'];
if ($result= mysqli_query($Connect, $query)){
    echo "<script>alert('수정되었습니다.');location.assign('list.php')</script>";
}
?>
