<?php
include "judge.php";
if ($_SERVER["REQUEST_METHOD"]=="POST") {
session_start();
    $conn=new mysqli('127.0.0.1','root','root','message');
    if (isset($_POST['exit'])) {
        $online=0;
        $username=$_SESSION['username'];
        $sql2 = "UPDATE user SET online='{$online}'WHERE username='{$username}'; ";
        $conn->query($sql2);
        unset($_SESSION['username']);
        unset($_SESSION['id']);

        $conn->close();
     echo '<script>window.location.href="index.php"</script>';
    }



    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        foreach ($id as $onevalue) {
            $sql = "DELETE FROM ms_message WHERE id='{$onevalue}'";
            $conn->query($sql);
            $sql1 = "DELETE FROM coomment WHERE aid='{$onevalue}'";
            $conn->query($sql1);

        }
        $conn->close();
        echo '<script>window.location.href="index.php"</script>';
    }

    if (isset($_POST['deleteuser'])) {
        $id = $_POST['userid'];
        foreach ($id as $onevalue) {
            $sql1 = "SELECT * FROM user WHERE id='{$onevalue}'";
            $res=$conn->query($sql1);
            $ros=mysqli_fetch_array($res);
            $c_username=$ros['username'];
            $sql1 = " DELETE FROM comment WHERE c_username='{$c_username}'";
            $conn->query($sql1);
            $sql2 = " DELETE FROM ms_message WHERE username='{$c_username}'";
            $conn->query($sql2);
            $sql = "DELETE FROM user WHERE id='{$onevalue}'";

            $conn->query($sql);


        }
        $conn->close();
        echo '<script>window.location.href="index.php"</script>';
    }
    if ($_POST['reply']){

        if (isset($_SESSION['username'])){

            $a_username = $_POST['a_username'];
            $aid = $_POST['aid'];
            $c_content = $_POST['commentt'];
            $c_username = $_SESSION['username'];

            $a_username=mysqli_real_escape_string($conn,$a_username);
            $c_content=mysqli_real_escape_string($conn,$c_content);
            $c_username=mysqli_real_escape_string($conn,$c_username);

            $sql = "INSERT INTO comment(c_username,a_username,c_content,aid) VALUE ('{$c_username}','{$a_username}','{$c_content}','{$aid}')";

            $conn->query($sql);
            $conn->close();
            echo '<script>window.location.href="index.php"</script>';
        }
        else {
            echo '<script>alert("您尚未登录，请登录后再操作")</script>';
            echo '<script>window.location.href="log.php"</script>';

        }
    }


                //判断是否登录
                if(isset($_SESSION['username'])){

                    if($_POST['message_post']=="message"){

                        $content = $_POST['content'];
                        echo $content;
                        $username = $_SESSION['username'];
                        $content=mysqli_real_escape_string($conn,$content);
                        $username=mysqli_real_escape_string($conn,$username);
                        $sql = "INSERT INTO ms_message(content,username) VALUE ('{$content}','{$username}')";

                        $conn->query($sql);
                        echo '<script>alert("留言成功！")</script>';
                        echo '<script>window.location.href="index.php"</script>';
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




        $conn->close();
        echo '<script>window.location.href="index.php"</script>';


}
