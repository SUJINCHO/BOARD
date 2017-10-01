
<?php
echo "<link rel='stylesheet' media='screen' href='bootstrap/bootstrap.min.css'/>";
$Connect = mysqli_connect("localhost", "root","autoset","ycj_test");
//글 출력
$board_id = $_GET['board_id'];
$query = "select * from board_9_11 where board_id = $board_id";
$_SESSION['alter'] = $board_id;
$result = mysqli_query($Connect,$query);
$row = mysqli_fetch_array($result);
//댓글 출력
$Cquery = "select * from comment where board_id = $board_id";
$Cresult = mysqli_query($Connect,$Cquery);
//조회수
$count = $row[6];
$count = $count + 1;
echo "     <div class='well bs-component' style='width:600px; margin: 0 auto'>
                <fieldset>
                  <legend><h2>$board_id. $row[4]</h2><h5 style='float: right'>조회수 : ".$count."</h5></legend>
                    <div style='height: 300px'>
                      <b>$row[5]</b>
                    </div>
                    <div>
                    <!--수정 및 삭제 버튼 -로그인 된 사용자가 글쓴이와 같을 경우에만-->
                    <form action='Alter.php' method='get' style='float: right'>";
                    if (isset($_SESSION['loginOK']) == true && $_SESSION['loginOK'] == $row[3]) {
                        echo "<input type='submit' class='btn btn-default' value='수정' name='alter'> ";
                        echo "<input type='submit' class='btn btn-default' value='삭제' name='alter'> ";
                    }
                    echo "<input type='button' class='btn btn-primary' value='목록으로' onclick='back()'>
                    </form>
                    </div><br><br>
                  <div>";
                    //댓글 -> 로그인이 되어있을 경우에만
                    if (isset($_SESSION["loginOK"]) == true) {
                        echo "<form action='comment.php' method='get'>
                     <div style='float: left; width: 470px'>
                            <input type='text' name='comment' class='form-control' id='inputEmail' placeholder='내용을 입력하세요'> 
                     </div>
                     <div style='float: right'>
                            <input type='submit' class='btn btn-default' value='댓글저장'>
                      </div>";
                     }
                      echo "</form>
                     </div>
                <div> <br>
                <!--댓글을 출력-->
                <table width='500px'>";
                    while ($Crow = @mysqli_fetch_array($Cresult)) {
                        echo "
                    <tr class='info'>
                        <td><b style='float: left'>$Crow[2]</b></td>
                        <td><h5 style='float: right'>$Crow[4] <a href='comment.php?del=$Crow[0]'>삭제</a></h5></td>
                    </tr>
                    <tr>
                        <td><h4>$Crow[3]</h4></td>
                    </tr>";
                        }
                echo "</table></div>
                </fieldset>
            </div>
          </div>";
$query = "update board_9_11 set hits = $count where board_id = $board_id";
$result = mysqli_query($Connect,$query);
?>
<script>
    function back() {
        location.assign("list.php");
    }
</script>
