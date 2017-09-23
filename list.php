<?php
echo "<link rel='stylesheet' media='screen' href='bootstrap/bootstrap.min.css'/>";
$Connect = mysqli_connect("localhost", "root","autoset","ycj_test");

@$search = $_GET['search'];//검색
/*=========================================================================================================*/
/*---로그인---*/
echo "<nav class='navbar navbar-inverse'>
<ul  class='nav navbar-nav'>";
unset($_SESSION["agein"]);
if (isset($_SESSION['loginOK']) == false) {
    echo "<li><a href='login.php'>로그인</a></li>
           <li><a href='join.php'>회원가입</a></li>
          ";
}
else {
    echo "<li><a class='nav navbar-nav2'>환영합니다. ".$_SESSION['loginOK']." 님</a></li>";
    echo "<li><a href='login.php?LogOut=로그아웃'>로그아웃</a></li>";
}
echo "</ul>";
/*=========================================================================================================*/
/*---게시글 수---*/
//if (isset($_GET['search']) == false) {
    $query = "select * from board_9_11";
    $result = mysqli_query($Connect,$query);

    $data = mysqli_num_rows($result);
/*}
else if (isset($_GET['search']) == true){
    $query = "select * from board_9_11 where subject = '$search'";
    $result = mysqli_query($Connect,$query);
    $data = mysqli_num_rows($result);
}*/

echo "<div style='float: right'><form class='navbar-form navbar-left' role='search' action='list.php' method='get'>
 <div class='form-group'>
<input type='text' name='search' class='form-control' placeholder='Search'>
</div>
<input type='submit' value='검색' class='btn btn-default'></form></div>";
echo "</nav>";
/*=========================================================================================================*/
/*---페이지 네이션---*/
$Page           = 2;//한 페이지에 들어갈 글 수
$BlockInPage    = 3;//한 블럭에 들어갈 페이지 수
//ceil 반올림
$PageTheNumber  = ceil($data / $Page);//페이지의 갯수
$Writing        = ceil($data/$Page);//한 블럭에서 보일 게시글 수
$Block          = ceil($Writing/$BlockInPage);//블럭의 수
//페이지 넘기기
//@ : 에러제어자
@$PageNationBlock  = $_GET['PageNationInBlock'];//페이지 다음/이전
@$PageNationNumber = ($_GET['PageNumber']) ? $_GET['PageNumber'] : 1 ;//페이지 번호
//현재 페이지 유지(다음이나 이전을 클릭했을 때도 그 페이지를 유지)
if(isset($_GET['PageNumber']) == true) {
    $_SESSION['PageNation'] = $PageNationNumber;
}

//버튼
/*if ($BlockInPage >= $PageTheNumber){
    $_SESSION['start']  = 1;
    $_SESSION['end']    = $PageTheNumber;
}
else {*/

    if ($PageNationBlock == '다음') {
        if ($_SESSION['end'] != $PageTheNumber) {
            $start = $_SESSION['start'] + $BlockInPage;
            $end = $start + $BlockInPage - 1;
            if ($end > $PageTheNumber) {//마지막 페이지
                $minus = $end - $PageTheNumber;
                $end = $end - $minus;
            }
            $_SESSION['start'] = $start;
            $_SESSION['end'] = $end;
        }
    } else if ($PageNationBlock == '이전') {
        if ($_SESSION['start'] != 1) {
            $start = $_SESSION['start'] - $BlockInPage;
            $end = $start + $BlockInPage - 1;
            $_SESSION['start'] = $start;
            $_SESSION['end'] = $end;
        }
    } //초기 데이터
    else {
        $start = 1;
        $end = $BlockInPage;

    }
//}


if (isset($_SESSION['PageNation']) == false){
    $_SESSION['PageNation'] = 1;
}
$OutputData = $Page * ($_SESSION['PageNation']-1);//페이지 번호에 따른 출력될 데이터

/*=========================================================================================================*/
/*---검색---*/
if (isset($_GET['search']) == true){
    $query      = "select * from board_9_11 where subject = '$search'";
    $result     = mysqli_query($Connect,$query);
}
else if (isset($_GET['search']) == false) {
    $query      = "select * from board_9_11 order by reg_date desc limit $OutputData, $Page";
    $result     = mysqli_query($Connect, $query);
}

/*=========================================================================================================*/
/*---테이블 출력---*/
/*echo " <div class='bs-docs-section'>
        <div class='row'>
          <div class='col-lg-12'>
            <div class='page-header'>
              <h1 id='tables'>Tables </h1>
              게시글 수 ".$data."
            </div>";*/
echo "<div style='width:900px; margin:0 auto'>
              <h1 id='tables'>게시판 </h1>
              <b style='float: right'>게시글 수 : ".$data."</b></div>";
echo "<div class='bs-component' style='width:900px; margin:0 auto'>";
echo "<table class='table table-striped table-hover' border='1'>
<tr>
    <tr><td width='50px'>번호</td>
    <td width='200px'>제목</td>
    <td width='50px'>작성자</td>
    <td width='50px'>조회수</td>
    <td width='160px'>작성일</td>
</tr>";
while ($row = @mysqli_fetch_array($result)){
    echo "<tr  class='info'>
        <td width='50px'>$row[0]</td>
        <td width='200px'><a href='read.php?board_id=$row[0]'>$row[4]</td>
        <td width='50px'>$row[3]</td>
        <td width='50px'>$row[6]</td>
        <td width='160px'>$row[7]</td>
    </tr>";
}
echo "</table><br>";
/*=========================================================================================================*/
/*---글쓰기---*/
if (isset($_SESSION["loginOK"]) == true) {
   echo "<ul class='pagination'  style=' float: right'>";
    echo "<li><a href='WRITE.html'>글쓰기</a>";
   echo "</ul>";
}
echo "</div>";
/*=========================================================================================================*/
/*---페이지 출력---*/
echo "<div style='width: 900px; margin: 0 auto;text-align: center'>";
echo "<ul class='pagination' >";
if (isset($_GET['search']) == true){
    echo "<li><a href='list.php'>새로고침</a></li>";
}
else {
//이전 블럭
    if (@$_SESSION['start'] > 1) {
        echo "<li><a href='list.php?PageNationInBlock=이전'><이전</a></li>";
    }
//페이지 번호 출력
//세션이 있을경우 저장된 페이지부터 출력
    if (isset($_SESSION['start']) == true) {
        for ($Number = $_SESSION['start']; $Number <= $_SESSION['end']; $Number++) {
            echo "<li><a href='list.php?PageNumber=$Number'>$Number</a></li>";
        }
    } //세션이 없을 경우
    else {
        for ($Number = $start; $Number <= $BlockInPage; $Number++) {
            echo "<li><a href='list.php?PageNumber=$Number'>$Number</a></li>";
        }
        $_SESSION['start'] = $start;
        $_SESSION['end'] = $end;
    }

// 다음 블럭
    if ($_SESSION['end'] < $PageTheNumber) {
        echo "<li><a href='list.php?PageNationInBlock=다음'>다음 ></a></li>";
    }
}
echo "</ul>";
echo "</div>";


?>
