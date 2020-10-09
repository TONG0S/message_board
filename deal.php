<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_SESSION['username'])) {
        unset($_SESSION['username']);
    }
    if ($_POST['username'] && $_POST['password']) {
        $username = $_POST['username'];
        $password = $_POST['password'];


        /*       获取时间和ip                */
        //这个网站可以获取公网ip
        $externalContent = file_get_contents('http://checkip.dyndns.com/');

        //获取结果：Current IP Address: 36.125.11.1
        preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
        $Ip = $m[1];
        //设置时区
        date_default_timezone_set("PRC");
        $data = date('Y-m-d H:i:s');

        $conn = new mysqli('127.0.0.1', 'root', 'root', 'message');

        //登录查询数据库
        if (isset($_POST['login'])) {
            $sql = "SELECT * FROM user where username='$username' and password='$password'";
            $res = $conn->query($sql);
            $row = mysqli_fetch_array($res);
            $id=$row['Id'];

            $ipinfo = "";
            if (isset($row)) {
                $online=1;
                if (strcmp($Ip, $row['ip'])) {
                    echo '<script >alert("' . $username . '和上次登录IP不相符");</script>';

                }
                if (isset($Ip)) {
                    $sql2 = "UPDATE user SET ip='{$Ip}',data='{$data}',online='{$online}'WHERE username='{$username}'; ";
                    $ipinfo = $Ip;
                } else {
                    $sql2 = "UPDATE user SET data='{$data}',online='{$online}'WHERE username='{$username}'; ";
                    $ipinfo = "您未连接网络。";
                }
                $res2 = $conn->query($sql2);
                echo '<script >alert("' . $username . $ipinfo . '");</script>';
                echo '<script >alert("' . $username . '登入成功");</script>';
                mysqli_close($conn);
                session_start();
                //设置session
                 $_SESSION['id'] = $id;
                 $_SESSION['username'] = $username;

                echo '<script>window.location.href="index.php"</script>';
            } else {
                mysqli_close($conn);
                echo '<script>alert("账户密码错误")</script>';
                echo '<script>window.location.href="log.php"</script>';
            }
        }
        //注册插入数据库
        elseif (isset($_POST['signup'])) {
            $sql1 = "SELECT * FROM user where username='$username'";
            $res1 = $conn->query($sql1);
            $row1 = mysqli_fetch_array($res1);

            if (isset($row1)) {
                mysqli_close($conn);
                echo '<script>alert("该账户已存在！请登录！！！")</script>';
                echo '<script>window.location.href="log.php"</script>';
            } else {
                $email = $_POST['email'];
                //上传头像

                if (isset($_FILES['photo'])){
                    if (empty($_FILES['photo']['name'])){
                        $photo_name="photo.png";   //设置个默认的图片
                    }
                    else {

                        move_uploaded_file($_FILES['photo']['tmp_name'], "./image/photo/{$_FILES['photo']['name']}");
                        $photo_name = $_FILES['photo']['name'];
                    }
                }
                else{
                    $photo_name="photo.png";
                }
                if (isset($Ip)) {
                    $ipinfo = $Ip;
                } else {
                    $Ip=$_SERVER['REMOTE_ADDR'];
                }

                $sql = "INSERT INTO user(username,password,data,ip,uid,email,photo) VALUE ('{$username}','{$password}','{$data}','{$Ip}','1','{$email}','{$photo_name}')";
                $conn->query($sql);
                mysqli_close($conn);
                echo '<script>alert("注册成功，请登录！")</script>';
                echo '<script>window.location.href="log.php"</script>';
            }
        }
    }
}