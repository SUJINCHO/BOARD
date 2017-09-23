<?php
echo "<link rel='stylesheet' media='screen' href='bootstrap/bootstrap.min.css'/>";
$alter = $_GET['alter'];
$Connect = mysqli_connect("localhost", "root","autoset","ycj_test");

$query = "select * from board_9_11 where board_id =".$_SESSION['alter'];

$result = mysqli_query($Connect,$query);
$row = mysqli_fetch_array($result);

    switch ($alter) {
        case '수정':

            echo "<div class='row'>
        <div class='col-lg-6'>
            <div class='well bs-component'>
                <form  action='save.php' method='get' class='form-horizontal'>
                    <fieldset>
                        <legend>글수정</legend>
                        <div class='form-group'>
                            <label for='inputEmail' class='col-lg-2 control-label'>제목</label>
                            <div class='col-lg-10'>
                                <input type='text' value='$row[4]' name='title' class='form-control' id='inputEmail' placeholder='title'>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label for='textArea' class='col-lg-2 control-label'>내용</label>
                            <div class='col-lg-10'>
                                <textarea name='text' class='form-control'rows='3' id='textArea' style='height: 300px'>$row[5]</textarea>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='col-lg-10 col-lg-offset-2'>
                                <input type='submit' class='btn btn-default' value=' 저장' >
                                <input type='button' class='btn btn-primary' value=' 취소 ' onclick='back()'>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>";
            break;
        case '삭제':
            $query = "delete from board_9_11 where board_id =" . $_SESSION['alter'];
            if ($result = mysqli_query($Connect, $query)) {
                echo "<script>alert('삭제되었습니다.');location.assign('list.php')</script>";
            }
            break;
    }

?>
<script>
    function back() {
        history.back();
    }
</script>
