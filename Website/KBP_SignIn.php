<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin1"]) && $_SESSION["loggedin1"] === true){
    header("location: kbp.php");
    exit;
}
 
// Include config file
//
require_once "KBP_User_DB.php";
//

// Define variables and initialize with empty values
$email = $idCard = "";
$email_err = $idCard_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "<br>Please enter email (Email-Id)";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if idCard is empty
    if(empty(trim($_POST["idCard"]))){
        $idCard_err = "<br>Please enter your idCard (ID-Card)";
    } else{
        $idCard = trim($_POST["idCard"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($idCard_err)){
        // Prepare a select statement
        $sql = "SELECT * FROM kbp2_users2 WHERE idCard = '$idCard' AND email = '$email'";
        $result =  mysqli_query($link, $sql);
        if($result === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($row) {
            // Store data in session variables
            $_SESSION["loggedin1"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["email"] = $email;  
            $_SESSION["idCard"] = $idCard; 

            $user_name = $row['name1'];
            $user_id_card = $row['idCard'];
            $user_vaccines = $row['vaccination_doses'];

            // Redirect user to welcome page
            header("location: kbp.php");
        }
        else {
            // idCard is not valid, display a generic error message
            $login_err = "<br> Invalid email or idCard.";
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KBPCOE Satara  </title>

    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">

<style>
    *{
    padding: 0;
    margin: 0;
    }
    @media screen 
        and (min-width: 1024px)
        and (max-device-width: 3360px)
        /* and (min-device-height: 4000px) */
        and (-webkit-min-device-pixel-ratio: 1) 
        { 
        .main-data{
        /* border:1px solid black; */
        margin-left:0;
        margin-right:0;
        width:100%; 
        }
        .main-data::before{
        content:'';
        display:block;
        height:2.5rem;
        background: rgba(128, 167, 211, 0.801);

        }
        header{
            /* border: 2px solid yellow; */
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:0 1rem;
        }
        .logo{
        width: 100px;
        border-radius: 10px;
        }
        .navbar ul{
            /* border: 2px solid green; */
            margin: 1.5% 0;
            padding-right: 2%;
            right: 0%;
            padding: 1% 1%;
            position: absolute;
            display: inline-flex;
            
        }
        .navbar ul li{
            border: 2px solid black;
            border-radius: 10px;
            margin: 0px 10px;
            list-style: none;
            display: inline-block;
            padding-left: 10px;
            padding-right: 10px;
            font-size: 28px;
            text-align: center;
            text-decoration: none;
            background-color: lightblue;
            opacity: 0.75;
        }
        .navbar ul li a{
            text-decoration: none;
            color: maroon;
        }
        .navbar ul li:hover{
            opacity: 0.9;
        }
        .navbar ul li a:hover, .navbar li a::after{
            width: 100%;
            text-decoration: underline;
            color: blue;
            transition: 0.5s;
        }
        .list{
            border: 1.8px solid black;
            background:rgba(128, 167, 211, 0.801);
            height: 3.5rem;
            text-align:center;
            font-size: 42px;
        }
        .icon{
            display: block;
            align-items: center;
            text-align: center;
            font-size: 25px;  
            grid-template-columns: 1fr 1fr;
            padding: 10px 15rem;
            background:lightgray;
        }
        img{
        width: 100px;
        border-radius: 10px;
        margin: 5px 5px;
        }
        footer{
        width: 100%;
        padding: 1% 0;
        /* bottom: inherit; */
        background-color: black;
        color: skyblue;
        text-align: center;
        text-decoration: none;
        }
        h2{
            color: black;
            text-decoration: none;
            text-align: center;
        }
        .clg-name {
            margin: 5% 0;
            padding: 2% 2%;
            background-color: rgba(128, 167, 211, 0.801);
            border: 2px solid black;
            border-radius: 15px;
            text-decoration: none;
            text-align: center;
        } 
        .form-group{
        /* border: 1px solid red; */
        margin: 10px 10px;
        font-size: 25PX;
        }
        .form-control{
            font-size: large;
        }
        .btn{
            border: 2px solid red;
            padding: 1% 1%;
            border-radius: 6px;
            font-size: 20PX;
        }
        .btn:hover{
            border: 2px solid green;
            padding: 1% 1%;
            border-radius: 6px;
            font-size: 20PX;
            font-weight: bold;
        }
    }
    @media screen and (min-width: 90px) and (max-width: 1024px) 
    and (min-device-height: 405px) and (max-device-height: 1366px)  
    and (orientation: portrait) 
    {
        .main-data{
        /* border:1px solid black; */
        margin-left:0;
        margin-right:0;
        width:100%; 
        }
        .main-data::before{
        content:'';
        display:block;
        height:2.5rem;
        background: rgba(128, 167, 211, 0.801);

        }
        header{
            /* border: 2px solid yellow; */
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:0 1rem;
        }
        .logo{
        width: 80px;
        border-radius: 10px;
        }
        .navbar ul{
            width: 150px;
            text-align: right;
            right: 0%;
            padding: 1.5% 1%;
            position: absolute;
            display: inline-block;    
        }
        .navbar ul li{
            border: 2px solid black;
            border-radius: 10px;
            margin: 3px;
            right: 0%;
            list-style: none;
            display: inline-block;
            padding-left: 10px;
            padding-right: 10px;
            font-size: 20px;
            text-align: center;
            text-decoration: none;
            background-color: lightblue;
            opacity: 0.75;
        }
        .navbar ul li a{
            text-decoration: none;
            color: maroon;
        }
        .navbar ul li:hover{
            opacity: 0.9;
        }
        .navbar ul li a:hover, .navbar li a::after{
            width: 100%;
            text-decoration: underline;
            color: blue;
            transition: 0.5s;
        }
        .list{
            border: 1.5px solid black;
            background:rgba(128, 167, 211, 0.801);
            height: 3.7rem;
            text-align:center;
            font-size: 22px;
        }
        .icon{
        display:block;
        align-items: center;
        text-align: center;
        font-size: 15px;  
        grid-template-columns: 1fr 1fr;
        padding: 10px 1rem;
        background:lightgray;
        margin-bottom:0.3rem;
        }
        img{
        width: 70px;
        border-radius: 10px;
        margin: 5px 5px;
        }
        footer{
        width: 100%;
        padding: 1% 0;
        /* bottom: inherit; */
        background-color: black;
        color: skyblue;
        text-align: center;
        text-decoration: none;
        }
        h2{
            color: black;
            text-decoration: none;
        }
        .clg-name {
            margin: 5% 0;
            padding: 2% 2%;
            background-color: rgba(128, 167, 211, 0.801);
            border: 2px solid black;
            border-radius: 15px;
            text-decoration: none;
            text-align: center;
        } 
        .form-group{
        /* border: 1px solid red; */
        margin: 10px 10px;
        font-size: 20PX;
        }
        .form-control{
            font-size: small;
        }
        .btn{
            border: 2px solid red;
            padding: 1% 1%;
            border-radius: 6px;
            font-size: 20PX;
        }
        .btn:hover{
            border: 2px solid green;
            padding: 1% 1%;
            border-radius: 6px;
            font-size: 20PX;
            font-weight: bold;
        }
    }
    @media (min-width: 500px) and (max-width: 1024px) and (min-device-height: 200px) 
        and (max-device-height: 811px)  and (orientation: landscape) 
        {
            .main-data{
        /* border:1px solid black; */
        margin-left:0;
        margin-right:0;
        width:100%; 
        }
        .main-data::before{
        content:'';
        display:block;
        height:2.5rem;
        background: rgba(128, 167, 211, 0.801);

        }
        header{
            /* border: 2px solid yellow; */
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:0 1rem;
        }
        .logo{
        width: 80px;
        border-radius: 10px;
        }
        .navbar ul{
            width: 150px;
            text-align: right;
            right: 0%;
            padding: 1.5% 1%;
            position: absolute;
            display: inline-block;
        }
        .navbar ul li{
            border: 2px solid black;
            border-radius: 10px;
            margin: 3px;
            /* margin-left: 20%; */
            right: 0%;
            list-style: none;
            display: inline-block;
            padding-left: 10px;
            padding-right: 10px;
            font-size: 20px;
            text-align: center;
            text-decoration: none;
            background-color: lightblue;
            opacity: 0.75;
        }
        .navbar ul li a{
            text-decoration: none;
            color: maroon;
        }
        .navbar ul li:hover{
            opacity: 0.9;
        }
        .navbar ul li a:hover, .navbar li a::after{
            width: 100%;
            text-decoration: underline;
            color: blue;
            transition: 0.5s;
        }
        .list{
            border: 1.5px solid black;
            background:rgba(128, 167, 211, 0.801);
            height: 2.5rem;
            text-align:center;
            font-size: 25px;
        }
        .icon{
        display:block;
        align-items: center;
        text-align: center;
        font-size: 15px;  
        grid-template-columns: 1fr 1fr;
        padding: 10px 1rem;
        background:lightgray;
        margin-bottom:0.3rem;
        }
        img{
        width: 70px;
        border-radius: 10px;
        margin: 5px 5px;
        }
        footer{
        width: 100%;
        padding: 1% 0;
        /* bottom: inherit; */
        background-color: black;
        color: skyblue;
        text-align: center;
        text-decoration: none;
        }
        h2{
            color: black;
            text-decoration: none;
        }
        .clg-name {
            margin: 5% 0;
            padding: 2% 2%;
            background-color: rgba(128, 167, 211, 0.801);
            border: 2px solid black;
            border-radius: 15px;
            text-decoration: none;
            text-align: center;
        } 
        .form-group{
        /* border: 1px solid red; */
        margin: 10px 10px;
        font-size: 20PX;
        }
        .form-control{
            font-size: medium;
        }
        .btn{
            border: 2px solid red;
            padding: 1% 1%;
            border-radius: 6px;
            font-size: 20PX;
        }
        .btn:hover{
            border: 2px solid green;
            padding: 1% 1%;
            border-radius: 6px;
            font-size: 20PX;
            font-weight: bold;
        }
    }


</style>
    
</head>
<body>
    <div class="main-data">
        <header>
            <div class="navbar">
                <img src="kbp.png" class="logo" usemap="#workmap">
                <map name="workmap">
                <area shape="rect" coords="34,44,270,350" alt="Computer" href="https://www.kbpcoes.edu.in/"></map>
                <ul>
                <li><a href="index2.html"><b> Home </a></li>
                <li><a href="reg1.html"> Dashboard </a></li>
                </ul>
            </div>
        </div>	
        </header>
        <h3 class="list">Karmveer Bhaurao Patil College of Engineering Satara</h3><br>
        <br>
        <div class="row">
            <div class="icon">
            
            <div class="clg-name">
                <h2>Login</h2><br>
                <h3><i>Please fill below credentials to login.</i></h3><br>
               
                <?php 
                if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }        
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label> Username : </label>
                        <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div> 
                    <div class="form-group">
                        <label> Password : </label>
                        <input type="idCard" name="idCard" class="form-control <?php echo (!empty($idCard_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $idCard_err; ?></span>
                    </div><br>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                </form><br>

                <h3>For credentials contact to your college admin.</h3><br>
            </div>
        </div><br>
        
        <br>
        <footer> <img src="logo.jpg"><br>
            <p style="color: rgba(255, 255, 255, 0.822);">Last Update  9-Dec-21</p>
            <br>
            <p>Contact &#8644; <a style="color: rgba(255, 255, 255, 0.822)" href="mailto: vishwajeetkadam14@gmail.com">Vishwajeet Kadam</a></p>
        </footer>
    </div>
   
</body>
</html>