<?php
    session_start();
    include("classes/connect.php");
    include("classes/login.php");


    $email = "";
    $password = "";

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $login=new Login();
        $result=$login->evaluate($_POST);


        if($result != "")
        {   
            echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
            echo "The following errors occured<br>";
            echo $result;
            echo "</div>";
        }
        else
        {
            header("Location: profile.php");
            die;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

    }



?>

<!DOCTYPE html>
<html>
<head>
    <title>MyBook | Login</title>
    <style>
        body {
            font-family: Tahoma;
            background-color: rgb(233, 235, 238);
        }

        #bar {
            height: 100px;
            background-color: rgb(59, 89, 152);
            color: white;
            padding: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #bar div {
            font-size: 32px;
            margin-left: 10px;
        }

        #signup_button {
            background-color: #42b72a;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 4px;
            color: white;
            margin-right: 10px;
            text-decoration: none;
        }

        #login-box {
            background-color: white;
            width: 800px;
            margin: auto;
            margin-top: 60px;
            padding: 10px;
            padding-top: 50px;
            text-align: center;
            font-weight: bold;
        }

        #text {
            height: 40px;
            width: 300px;
            border-radius: 4px;
            border: solid 1px #ddd;
            padding: 4px;
            font-size: 14px;
        }

        #button {
            width: 300px;
            height: 40px;
            border-radius: 4px;
            font-weight: bold;
            border: none;
            background-color: rgb(59, 89, 152);
            color: white;
        }

        .error {
            color: red;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div id="bar">
        <div>MyBook</div>
        <a href="signup.php" id="signup_button">SignUp</a>
    </div>

    <div id="login-box">
        Login to MyBook<br><br>



        <form method="post">
            <input value="<?php echo $email ?>" type="text" name="email"  id="text" placeholder="Email"><br><br>
            <input value="<?php echo $password ?>" type="password" name="password" id="text" placeholder="Password"><br><br>
            <input type="submit" id="button" value="Log In"><br><br>
        </form>
    </div>
</body>
</html>
