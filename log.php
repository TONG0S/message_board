<?php
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DOLLARS</title>
    <link href="css/log.css" rel="stylesheet" type="text/css">
    <style>
        input{
            border-radius: 15px;
        }
    </style>
    <script>
        <
    </script>
</head>
<body >
<div id="main">
    <div id="middle">
        <div id="logo">
        </div>
        <form action="deal.php" method="post">
            <table>
                <tr>
                    <td>username:</td>
                    <td><input type="text" name="username" required="required"></td>
                </tr>
                <tr>
                    <td>password:</td>
                    <td><input type="password" name="password" required="required"></td>
                </tr>
                <tr style="height: 20px"><td><input type="hidden"></td><td></td></tr>
                <tr align="center">
                    <td colspan="2"><input type="submit" value="LOG IN" id="confirm" name="login" >
                        <a href="signup.php"><input type="button" value="SIGN UP" id="confirm"name="signup"  ></a> </td>

                </tr>
            </table>
        </form>
    </div>

</div>

</body>
</html>
