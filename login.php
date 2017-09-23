<?php
echo "<link rel='stylesheet' media='screen' href='bootstrap/bootstrap.min.css'/>";
$Connect = mysqli_connect("localhost", "root","autoset","ycj_test");
$query = "select * from user_info_9_19 ";
$user_info_result = mysqli_query($Connect,$query);

@$logout = $_GET["LogOut"];

$ox = false;
//로그인
if (isset($_GET['ID']) == false) {
    echo "<br><div class='row' style='width: auto; margin: 0 auto'>
          <div class='col-lg-6'>
            <div class='well bs-component'>
              <form class='form-horizontal' action='login.php' method='get'>
                <fieldset>
                  <legend>로그인</legend>
                  <div class='form-group'>
                    <label for='inputEmail' class='col-lg-2 control-label'>ID</label>
                    <div class='col-lg-10'>
                      <input type='text' class='form-control' name='ID' id='inputEmail' placeholder='ID'>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label for='inputPassword' class='col-lg-2 control-label'>Password</label>
                    <div class='col-lg-10'>
                      <input type='password' class='form-control' name='Password' id='inputPassword' placeholder='Password'>
                    </div>
                  </div>
                  <div class='form-group'>
                    <div class='col-lg-10 col-lg-offset-2'>
                      <input type='submit' class='btn btn-primary' value='로그인'>
                      <input type='button' value='목록으로' class='btn btn-default' onclick='listback()'>
                    </div>
                   </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>";
}
else {
    $ID = $_GET['ID'];
    $PW = $_GET['Password'];
    while ($log = mysqli_fetch_array($user_info_result)){
        if ($log[0] == $ID){ // id가 맞을 경우
            if ($log[1] == $PW){ // 페스워드가 맞을경우
                echo "<script>alert('로그인 되었습니다.'); location.assign('list.php')</script>";
                $_SESSION["user_ID"] = $log[1];
                $_SESSION["loginOK"] = $log[2];
                $ox = true;
            }
        }
    }
    if ($ox == false){
        unset($_GET['ID']);
        echo "<script>alert('아이디와 비밀번호를 확인해주세요.')</script>";
        echo "<script>
                  location.assign('login.php');  
              </script>";
    }
}
echo "<form action='join.php' method='get'>
       <!--<input type='submit' value='회원가입'>-->
       </form>";

//로그아웃
if (isset($logout) == true){
    unset($_SESSION['loginOK']);
    echo "<script>alert('로그아웃되었습니다.'); location.assign('list.php')</script>";
}
?>
<script>
    function listback() {
        location.assign("list.php");
    }
</script>