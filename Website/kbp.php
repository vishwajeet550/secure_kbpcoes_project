<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page

if(!isset($_SESSION["loggedin1"]) || $_SESSION["loggedin1"] !== true){
    header("location: KBP_SignIn.php");
    exit;
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
            /* height: 3.5rem; */
            text-align:center;
            font-size: 42px;
        }
        .icon{
        display:flex;
        align-items: center;
        font-size: 25px;  
        grid-template-columns: 1fr 1fr;
        padding: 10px 12rem;
        background:lightgray;
        margin-bottom:0.3rem;
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
        .clg-name a{
            text-decoration: none;
            text-align: center;
        } 
        .img12{
            border: 2px solid black;
            width: 90%;
            height: 55vh;
            text-align: center;
            margin: 1% 5%;
            box-shadow: 1px 1px 10px 3px black;
        }
        .marquee{
            background-color: rgba(128, 167, 211, 0.801);
            border: 1.5px solid black;
            font-size: 20px;
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
            /* height: 3.7rem; */
            text-align:center;
            font-size: 22px;
        }
        .icon{
        display:flex;
        align-items: center;
        text-align: center;
        font-size: 18px;  
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
        .clg-name a{
            text-decoration: none;
            text-align: center;
        }
        .img12{
            border: 2px solid black;
            width: 90%;
            height: 40vh;
            text-align: center;
            margin: 2% 5%;
            box-shadow: 1px 1px 10px 3px black;
        }
        .marquee{
            background-color: rgba(128, 167, 211, 0.801);
            border: 1.5px solid black;
            font-size: 20px;
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
            /* height: 4rem; */
            text-align:center;
            font-size: 29.5px;
        }
        .icon{
        display:flex;
        align-items: center;
        font-size: 17px;  
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
        .clg-name a{
            text-decoration: none;
            text-align: center;
        }
        .img12{
            border: 2px solid black;
            width: 90%;
            height: 75vh;
            text-align: center;
            margin: 2% 5%;
            box-shadow: 1px 1px 10px 3px black;
        }
        .marquee{
            background-color: rgba(128, 167, 211, 0.801);
            border: 1.5px solid black;
            font-size: 20px;
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
                <li><a href="list-clg.html"><b> Dashboard</a></li>
                <li><a href="logout.php">Sign Out </a></li>
                </ul>
            </div>
        </div>	
        </header>
        <h3 class="list">Karmveer Bhaurao Patil College of Engineering Satara</h3><br>
        <div class="marquee">
            <marquee direction="left"> Note : This site is only for KBP College Students, Faculty, Staffs and those who have college ID-Card. This site is effect from Jan-22 So, update your informaion to office.</marquee>
        </div><br>
        <div class="row">
            <div class="icon">
                <img src="kbp2.jpg" id="slide" class="img12">
            </div>
        </div><br>
        <div class="row">
            <div class="icon">
                <div class="clg-name">
                    <h2> Kindly check your Information </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="icon">
                <div class="clg-name">
                    <?php   
                        require_once "KBP_User_DB.php";
                        if($_SESSION['idCard']){
                            $SESSION = $_SESSION['idCard'];
                            $result = mysqli_query($link, "SELECT * FROM `kbp2_users2` WHERE `idCard` = '$SESSION'");
                            $show=mysqli_fetch_assoc($result);
                            echo "<br />";
                            echo "Username : "; echo $show['name1']."<br />";
                            echo "<br />";
                            echo "\r\n Email-Id : "; echo $show['email']."<br />";
                            echo "<br />";
                            echo "\r\n ID-Card : "; echo $show['idCard']."<br />";
                            echo "<br />";
                            echo "\r\n Vaccines : "; echo $show['vaccination_doses']."<br />";
                            echo "<br />";
                        }
                    ?>
                </div>
            </div> <br>
            <div class="icon" style="color: green; text-decoration: none;">
                <?php
                    $Color = "green";
                    $string1 = ' <a href="uploadImage.php"> !!! You have successfully completed your vaccination doses, 
                    Click here to upload your live image !!! </a></span>';

                    $string = "You do not completed your vaccination doses, 
                    \r\n <br /> Please get fully vaccinated or if you have already did then submit your 
                    vaccination certificates to your college admin.";

                    $vaccines = $show['vaccination_doses'];
                    if($vaccines >= 2) {
                        echo $string1;
                    }

                    else{
                        echo '<span style="color: red;"> ' .$string; 
                    }
                ?>
            </div>
        </div><br>
        <footer> <img src="logo.jpg"><br>
            <p style="color: rgba(255, 255, 255, 0.822);">Last Update  30-May-21</p>
            <br>
            <p>Contact &#8644; <a style="color: rgba(255, 255, 255, 0.822)" href="mailto: vishwajeetkadam14@gmail.com">Vishwajeet Kadam</a></p>
        </footer>
    </div> 
</body>

<script>
    var images = ["kbp2.jpg", "kbp1.jpg","kbp3.jpg"]
    var i=0;
    function slides(){
        document.getElementById("slide").src = images[i];
        if(i<(images.length-1))
        i++;
        else
        i=0;
    }
    setInterval(slides, 2000)
</script>
</html>