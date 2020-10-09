<?php
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIGN UP</title>
    <link href="css/log.css" rel="stylesheet" type="text/css">
    <style >
#logo_background{
    width: 37%;
    height: 77%;
    /*background-color: #9e97e0;*/
    margin-top: -40%;
    margin-left: 28%;
    background-image: url("image/logo.png");
    background-repeat: no-repeat;
}
input{
    border-radius: 15px;
}
    </style>
    <script>

    </script>
</head>
<body >

<div id="main">

    <div id="middle">

        <form action="deal.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>username:</td>
                    <td><input type="text" name="username" required="required"></td>
                </tr>
                <tr>
                    <td>password:</td>
                    <td><input type="password" name="password" required="required"></td>
                </tr>
                <tr>
                    <td>email:</td>
                    <td><input type="email" name="email" required="required"></td>
                </tr>
                <tr>
                    <td>photo:</td>
                    <td><input type="file" name="photo" style="border-style: none" accept="image/*"></td>
                </tr>
                <tr style="height: 20px"><td><input type="hidden"></td><td></td></tr>
                <tr align="center">
                    <td colspan="2">
                        <input type="submit" value="SIGN UP" id="confirm"name="signup"  ></td>

                </tr>
            </table>
        </form>
    </div>
    <div id="logo_background">

    </div>


</div>

</body>
</html>
