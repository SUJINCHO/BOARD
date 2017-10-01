<style>
    input{
        margin: 2px 0 2px 0 ;
    }
</style>
<?php
    $Connect = mysqli_connect("localhost", "root","autoset","ycj_test");
    @$join = $_GET['join'];
    if (isset($_GET['IDInput']) == false) {
        echo "<form action='join.php' method='get'>
           <table> 
               <tr>
                   <td>아이디</td>
                   <td><input type='text' name='IDInput'></td>
                   <td><input type='submit' value='중복확인' name='join'></td>
               </tr>
               <tr>
                   <td>비밀번호 </td>
                   <td><input type='password' name='PWInput'></td>
               </tr>
               <tr>
                   <td>이름</td>
                   <td><input type='text' name='NameInput'></td>
               </tr>
               <tr>
                   <td>나이</td>
                   <td><input type='number' name='AGEInput'></td>
               </tr>
           </table>
           <input type='submit' value='가입하기' name='join'>
           </form>
           ";
    }
    else if ($join == '가입하기'){
        @$ID = $_GET['IDInput'];
        @$PW = $_GET['PWInput'];
        @$Name = $_GET['NameInput'];
        @$age = $_GET['AGEInput'];
        echo "환영합니다." . $Name . "님!!";

        $query = "insert into user_info_9_19(user_id, password, user_name, user_age) 
              values('$ID', '$PW', '$Name', '$age')";
        $user_info_result = mysqli_query($Connect, $query);

        echo "<form action='login.php' method='get'><input type='submit' value='로그인하기'></form>";
    }

?>
