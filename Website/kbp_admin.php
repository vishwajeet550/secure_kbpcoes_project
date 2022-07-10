<?php
// Include config file
require_once "KBP_User_DB.php";
 
// Define variables and initialize with empty values
$name1 = $email = $idCard = $vaccination_doses = "";
$name1_err =$email_err = $idCard_err = $vaccination_doses_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    if(empty(trim($_POST["name1"]))){
        $name1_err = "<br> Please enter a name.";     
    } elseif(!preg_match("/^[a-zA-z\040]*$/", trim($_POST["name1"]))){
        $name1_err = "<br>Name can only contains characters"; 
    } else{
        $name1 = trim($_POST["name1"]);
    }
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "<br>Please enter a email.";
    } elseif(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", trim($_POST["email"]))){
        $email_err = "<br>Email is invalid";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM kbp2_users2 WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "<br>This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } 
            else{
                echo "<br>Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate idCard
    $minDigits = 0;
    $maxDigits = 4;
    if(empty(trim($_POST["idCard"]))){
        $idCard_err = "<br> Please enter a idCard Number.";     
    } elseif(!preg_match('/^[0-9]{'.$minDigits.','.$maxDigits.'}\z/', trim($_POST["idCard"]))){
        $idCard_err = "<br>idCard can only contains 4 digits and 0 to 4 numbers"; 
    } else{
        $idCard = trim($_POST["idCard"]);
    }

    $maxDigits1 = 1;
    // Validate vaccination_doses
    if(empty(trim($_POST["vaccination_doses"]))){
        $vaccination_doses_err = "<br> Please enter the number of vaccination doses.";     
    } elseif(!preg_match('/^[1-3]{'.$minDigits.','.$maxDigits1.'}\z/', trim($_POST["vaccination_doses"]))){
        $vaccination_doses_err = "<br>vaccination doses can only contains 1 digit and 1 to 3 numbers"; 
    } else{
        $vaccination_doses = trim($_POST["vaccination_doses"]);
    }

    // Check input errors before inserting in database
    if(empty($name1_err) && empty($email_err) && empty($idCard_err) && empty($vaccination_doses_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO kbp2_users2 (name1, email, idCard, vaccination_doses) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name1, $param_email, $param_idCard, $param_vaccination_doses);
            
            // Set parameters
            $param_name1 = $name1;
            $param_email = $email;
            $param_idCard = $idCard; 
            $param_vaccination_doses = $vaccination_doses;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: KBP_SignIn.php");
            } else{
                echo "<br> Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
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
    <title>KBPCOE User Registration  </title>

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
            padding-left: 50px;
            text-align: left;
            margin: 10px 10px;
            font-size: 22PX;
            width: 50rem;
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
            background:rgba(128, 167, 211, 0.801);
            height: 3.7rem;
            text-align:center;
            font-size: 22px;
        }
        .icon{
        display:block;
        align-items: center;
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
            background:rgba(128, 167, 211, 0.801);
            height: 2.5rem;
            text-align:center;
            font-size: 25px;
        }
        .icon{
        display:block;
        align-items: center;
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
                <li><a href="reg1.html">Dashboard </a></li>
                </ul>
            </div>
        </div>	
        </header>
        <h3 class="list">Karmveer Bhaurao Patil College of Engineering Satara</h3><br>
        <br>
        <div class="row">
            <div class="icon">
            
            <div class="clg-name">
                <h2>Registration Of User</h2><br>
                <h3><i>Please fill the following information for user.</i></h3><br>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Name : &emsp; </label>
                        <input type="text" name="name1" class="form-control <?php echo (!empty($name1_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name1; ?>">
                        <span class="invalid-feedback"><?php echo $name1_err; ?></span>
                    </div> 
                    <div class="form-group">
                        <label>Email Id : </label>
                        <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>    
                    <div class="form-group">
                        <label>ID-Card : </label>
                        <input type="int" name="idCard" class="form-control <?php echo (!empty($idCard_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $idCard; ?>">
                        <span class="invalid-feedback"><?php echo $idCard_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Vaccines : </label>
                        <input type="int" name="vaccination_doses" class="form-control <?php echo (!empty($vaccination_doses_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $vaccination_doses; ?>">
                        <span class="invalid-feedback"><?php echo $vaccination_doses_err; ?></span>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        
                    </div>
                    <br>
                </form>
            </div>
            <br>
            </div>
        <footer> <img src="logo.jpg"><br>
            <p style="color: rgba(255, 255, 255, 0.822);">Last Update  30-May-21</p>
            <br>
            <p>Contact &#8644; <a style="color: rgba(255, 255, 255, 0.822)" href="mailto: vishwajeetkadam14@gmail.com">Vishwajeet Kadam</a></p>
        </footer>    
        
    </div>

</body>
</html>