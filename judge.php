<?php

function log_judge($conn){
    //判断是否登录
    if (isset($_SESSION['username'])){
        $sql1="SELECT * FROM ms_message where username='{$_SESSION['username']}'";
        $res = $conn -> query($sql1);
        $sql2="SELECT * FROM user where username='{$_SESSION['username']}'";
        $res1 = $conn -> query($sql2);
        $resall=mysqli_fetch_array($res1);
        $uid=$resall['uid'];
        if($uid==1) {
            echo '<div id="infoall" style="border-style: solid;background-color:rgb(87,101,101,0.2)" ><p align="center">我的留言</p>' . '<form action="data_deal.php" method="post"><input type="submit" name="delete" value="删除"><br>';
            while ($row = mysqli_fetch_assoc($res)) {
                echo '<label><input type="checkbox" name="id[]" value=' . $row['Id'] . '>' . $row['content'] . '</label><br>';
            }
            echo '</form></div>';
        }
        else{
            $sql3="SELECT * FROM  ms_message";
            $res3 = $conn -> query($sql3);
            echo '<div id="info" ><h2 align="center">所有留言</h2>' . '<form action="data_deal.php" method="post"><input type="submit" name="delete" value="删除"><br>';
            while ($row = mysqli_fetch_assoc($res3)) {
                echo '<label><input type="checkbox" name="id[]" value=' . $row['Id'] . '>' . $row['content'] . '</label><br>';
            }
            echo '</form></div>';
        }
    }
}
function comment_display($conn,$aid){
    $sql_comment="SELECT * FROM comment WHERE aid='{$aid}'";

    $res = $conn -> query($sql_comment);

    while($row = mysqli_fetch_assoc($res)) {

//        echo '<input type="text" name="comment" class="c_content" readonly="readonly" value='.$row['c_username'].'回复'.$row['a_username'].'：'.$row['c_content'].'>';
        echo '<div class="c_comment">'. '<span style="color: #9bf334">' ."{$row['c_username']}".'</span>'.'回复'. '<span style="color: #4f80e5">' .$row['a_username'].'</span>：';
        echo $row['c_content'];


        echo '</div>';
//        <<<EOF
//<input type="text" name="comment" class="c_content" readonly="readonly" value={$row['c_username']}回复{$row['a_username']}：{$row['c_content']}>;
//EOF;

    }


}
//添加留言
function message($conn){

    if ($conn->connect_error){
    }
    else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //判断是否登录
            if(isset($_SESSION['username'])){

                if(isset($_POST['message_submit'])) {

                    $content = $_POST['content'];
                    $username = $_SESSION['username'];
                    $content=mysqli_real_escape_string($conn,$content);
                    $username=mysqli_real_escape_string($conn,$username);
                    $sql = "INSERT INTO ms_message(content,username) VALUE ('{$content}','{$username}')";
                    $conn->query($sql);
                    echo '<script>alert("留言成功！")</script>';
                }
                elseif (isset($_POST['reply'])){
                    $c_content = $_POST['content'];
                    $id = $_SESSION['mid'];

                }
            }
            else{
                mysqli_close($conn);
                echo '<script>alert("您尚未登陆，请登录后再操作！")</script>';
                echo '<script>window.location.href="log.php"</script>';
            }
        } else {

        }
    }
    $sql="SELECT * FROM ms_message";
    $sql_comment="SELECT * FROM comment";
    $res = $conn -> query($sql);
    $res_comment = $conn -> query($sql_comment);

    while($row = mysqli_fetch_assoc($res)) {
        $sql_comment="SELECT * FROM user WHERE username='{$row['username']}'";

        $r_photo = $conn -> query($sql_comment);
        $photo_row=mysqli_fetch_array($r_photo);
        $photo=$photo_row['photo'];
        $photo="'.\image\photo\\".$photo."'";

        echo '<div class="mess" ><div class="mess_left" align="center">'. "<img src=".$photo.">".'<div >'.$row['username'].'</div>
                </div><div class="mess_right">'. $row["content"].'</div>';
        echo '<form action="data_deal.php" method="post">';
        echo '<input type="text" name="commentt" class="comm_content"><input type="submit" value="回复" name="reply">';
        echo '<input type="hidden" value="'.$row['username'].'" name="a_username">';
        echo '<input type="hidden" value="'.$row['Id'].'" name="aid">
                </form>
                </div>';
        $aid=$row['Id'];
        comment_display($conn,$aid);

    }

    mysqli_close($conn);

}

