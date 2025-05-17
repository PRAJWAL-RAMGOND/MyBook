<?php
    
    include("classes/connect.php");
    include("classes/signup.php");

    $first_name = "";
    $last_name = "";
    $gender = "";
    $email = "";

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $signup=new Signup();
        $result=$signup->evaluate($_POST);


        if($result != "")
        {   
            echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
            echo "The following errors occured<br>";
            echo $result;
            echo "</div>";
        }
        else
        {
            header("Location: login.php");
            die;
        }

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
    }



?>
<html>
<head>
    <title>MyBook | SignUp</title>
</head>
<style>
    #bar {
        height: 100px;
        background-color: rgb(59, 89, 152);
        color: white;
        padding: 4px;
    }

    #signup_button {
        background-color: #42b72a;
        width: 70px;
        text-align: center;
        padding: 4px;
        border-radius: 4px;
        float: right;
    }

    #login-bar {
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
</style>
<body style="font-family: tahoma; background-color: rgb(233,235,238);">
<div id="bar">
    <div style="font-size: 40px;">MyBook</div>
    <div id="signup_button">
        <a href="login.php" style="color:white;text-decoration:none;">LogIn</a>
    </div>
</div>

<div id="login-bar">
    SignUp to MyBook<br><br>

    <form method="post" action="">
        <input value="<?php echo $first_name ?>" name="first_name" type="text" id="text" placeholder="First Name"><br><br>
        <input value="<?php echo $last_name ?>" name="last_name" type="text" id="text" placeholder="Last Name"><br><br>

        <span style="font-weight: normal; padding: 14px;">Gender:</span><br>
        <select id="text" name="gender">
            <option> <?php echo "Select an Option" ?></option>
            <option >Male</option>
            <option >Female</option>
        </select>
        <br><br>

        <input value="<?php echo $email ?>" name="email" type="email" id="text" placeholder="Email address"><br><br>
        <input name="password" type="password" id="text" placeholder="Password"><br><br>
        <input name="password2" type="password" id="text" placeholder="Re-Enter Password"><br><br>
        <input type="submit" id="button" value="SignUp"><br><br>
    </form>
</div>
</body>
</html>
