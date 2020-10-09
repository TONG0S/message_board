
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>index</title>


    <link href="css/index.css" rel="stylesheet" type="text/css">
    <?php include "judge.php";?>
    <style>
        #info {
            width:18%;
            height: 70%;
            position: fixed;
z-index: 5;

            /*background-color: #9e97e0;*/
            overflow:auto;
            border: none;
            outline: none;
            background: transparent;

        }
        #infoall {
            width:18%;
            height: 83%;
            position: fixed;
            z-index: 5;
            background-color: #9e97e0;
            left: -250px;
            overflow:auto;
            border: none;
            outline: none;
            background: transparent;

        }
        #infoall input{
            border: none;
            /*background-color: #9e97e0;*/
        }
        #info1 {
            width:13%;
            height: 30%;
            position: fixed;
            margin-top: 11%;
            z-index: 5;
            padding-left: 1%;
            padding-right: 1%;
            font-size: 10px;
            /*background-color: #9e97e0;*/
            overflow:auto;
            border: none;
            outline: none;
            background: transparent;

        }
        .c_comment{
            width: 80%;
            height: 5%;
            /*background-color: #6f6f9a;*/
            margin-top: 1%;
            margin-left: 17%;
            border-color: #8da0a5;
            border-width: 2px;
            border-style: solid;
        }

        #info::-webkit-scrollbar {
            display: none;
        }
        #message{
            position: fixed;
            margin-left: 27%;
            margin-top: 30%;
/*background-color: #9e97e0;*/
            height: 17%;
            z-index: 5;
            width: 55%;
        }
        #content{
            /*margin-left: 5%;*/
            width: 100%;
            /*margin-top: 10%;*/
            /*background-color: aquamarine;*/
            border-color: #373e3e;
            border-radius: 15px;
        }
        #confirm{
            margin-left: 26%;
            margin-top: 0%;

            width: 35%;
            height: 20%;
            background-color: #f8f9fa;
            color: #151414;
            border-color: #373e3e;
            border-radius: 15px;
        }
        .comm_content{
            /*background-color: #9e97e0;*/
            width: 77%;
            height: 25%;
            margin-left: 18%;


        }
        .c_content{
            background-color: ;
            width: 77%;
            height: 7%;
            margin-left: 18%;
            margin-top: 1%;

        }
        #log_inup{
            margin-top: -1%;
            /*background-color: #9e97e0;*/
            width: 15%;
            margin-left:85%;
        }

        #log_inup input{
            /*border: none;*/
            border-radius: 25px;
            height: 5%;
            font-weight: bold;
        }
        textarea{
            border-radius: 15px;
        }
        li{
            color: #6ead57;
        }
#message_judge{
    position: absolute;
    width: 5%;
    height: 5%;
    margin-top: -3%;
}
    </style>
</head>
<body >

<h1 align="center">留言板</h1>

<div id="log_inup">
<!--    登录注册连接-->

    <a href="log.php"><input type="button" value="LOG IN" id="log_in"></a>
    <a href="signup.php"><input type="button" value="SIGN UP" id="sign_up"></div></a>
<hr>
<!--//留言表单-->

<div id="message">
    <textarea name="content"  rows="5" cols="90" id="message_content" required="required"  >
    </textarea>
    <br>
    <input type="submit" value="POST" id="confirm" name="message_submit">
<!--</form>-->

</div>
<?php
session_start();
if(isset($_SESSION['username'])) {
    $judge_session =1;

}else{
    $judge_session =0;
}
echo '<input type="hidden" id="judge_session" value='.$judge_session.'>';
$conn=new mysqli('127.0.0.1','root','root','message');
//我的留言 or 所有留言
log_judge($conn);

?>
<div id="right">
    <?php
    if (isset($_SESSION['username'])){
        $sql2="SELECT * FROM user where username='{$_SESSION['username']}'";
        $res2 = $conn -> query($sql2);
        $row2=mysqli_fetch_array($res2);

        $sql_online="SELECT * FROM user where online=1";
        $res_online = $conn -> query($sql_online);
//        $row_online=mysqli_fetch_array($res_online);

        if($row2['uid']){
            echo '  昵称：'.$row2['username'].'<br><br>最后一次登录时间：<br>';

            echo $row2['data'].'<br><br>当前ip:<br>';
            echo $row2['ip'];
            echo '<br><p align="center"><form action="data_deal.php" method="post"><input type="submit" value="退出"  name="exit">
    </form></p>';
            echo '<div id="info1" style="margin-left: -3%;border-style: solid" align="center"><span style="color: #44ff05">在线用户</span><hr>';
            while($row_online = mysqli_fetch_assoc($res_online)) {
                echo '<li>'.$row_online['data']. '<br><span style="color:#095cea;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户：' . $row_online['username'].'</span></li><br>';
            }
            echo '</div>';
        }
        else{
            $sql3="SELECT * FROM user ";
            $res3= $conn -> query($sql3);
            echo '管理员：'.$row2['username'];
            echo '<br><p align="center"><form action="data_deal.php" method="post"><input type="submit" value="退出"  name="exit">
    </form></p>';
            echo '<div id="info" ><h2 >用户</h2>'.'<form action="data_deal.php" method="post"><input type="submit" name="deleteuser" value="删除"><br>';
            while($row3 = mysqli_fetch_assoc($res3)) {
                echo '<label><input type="checkbox" name="userid[]" value=' .$row3['Id'].'>'. $row3['username'].'</label><br>';
            }
            echo '</form></div>';
        }
    }

    ?>


</div>
<input type="button" value="message" id="message_judge">
<div id="main" >
    <div id="middle">
        <?php
        message($conn);
        ?>
    </div>
</div>

<div>

</div>
<script>
    var xhr=new XMLHttpRequest();
    //留言页面刷新
    var confirm=document.getElementById('confirm');
    var judge_session=document.getElementById('judge_session').value;
    var log_in=document.getElementById('log_in');
    var sign_up=document.getElementById('sign_up');
    var message_judge=document.getElementById('message_judge');
    var infoall=document.getElementById('infoall');

    var left_lenght=-260;
    function aa() {
        if(left_lenght<10) {

            infoall.style.left = left_lenght + 'px';
            setTimeout('aa()', 30);
            left_lenght += 10;
        }
        else {

            infoall.style.left = left_lenght + 'px';
        }
    }
    function bb() {
        if(left_lenght>=-260) {

            infoall.style.left = left_lenght + 'px';
            setTimeout('bb()', 30);
            left_lenght -= 10;
        }
        else {

            infoall.style.left = left_lenght + 'px';
        }
    }
    message_judge.onclick=function (){

        if (judge==1){

                if(left_lenght<0){
                    aa();
                }
                else{
                }

            judge=0;
            }
        else{

            bb();
            judge=1;
        }
        console.log(judge);
        }
    var judge=1;
    confirm.onclick=function (){
        if(judge_session==1) {
            var content = document.getElementById('message_content').value;
            var ress = "message_post=message&content=" + content;
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    //刷新界面
                    window.location.reload();
                }
            }
            xhr.open("POST", "/message_board/data_deal.php", true);

            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(ress);
        }
        else{
            alert("您尚未登录，请先登录！");
            window.location.href="log.php";
        }


    }

    if (judge_session=='1'){

        sign_up.style.display="none";
        log_in.style.display="none";
        message_judge.style.display="show";

    }
    else{
        sign_up.style.display="show";
        log_in.style.display="show";
        message_judge.style.display="none";
    }


</script>
</body>
</html>
