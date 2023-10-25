admin:
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
        
    <title>Login</title>

    
    
</head>
<body>
    <?php

    //learn from w3schools.com
    //Unset all the server side variables

    session_start();

    $_SESSION["user"]="";
    $_SESSION["usertype"]="";
    
    // Set the new timezone
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');

    $_SESSION["date"]=$date;
    

    //import database
    include("connection.php");

    



    if($_POST){

        $email=$_POST['useremail'];
        $password=$_POST['userpassword'];
        
        $error='<label for="promter" class="form-label"></label>';

        $result= $database->query("select * from webuser where email='$email'");
        if($result->num_rows==1){
            $utype=$result->fetch_assoc()['usertype'];
            if ($utype=='p'){
                $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                if ($checker->num_rows==1){


                    //   Patient dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='p';
                    
                    header('location: patient/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }elseif($utype=='a'){
                $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                if ($checker->num_rows==1){


                    //   Admin dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='a';
                    
                    header('location: admin/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }


            }elseif($utype=='d'){
                $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                if ($checker->num_rows==1){


                    //   doctor dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='d';
                    header('location: doctor/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }
            
        }else{
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
        }






        
    }else{
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }

    ?>





    <center>
    <div class="container">
        <table border="0" style="margin: 0;padding: 0;width: 60%;">
            <tr>
                <td>
                    <p class="header-text">Welcome Back!</p>
                </td>
            </tr>
        <div class="form-body">
            <tr>
                <td>
                    <p class="sub-text">Login with your details to continue</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td">
                    <label for="useremail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <label for="userpassword" class="form-label">Password: </label>
                </td>
            </tr>

            <tr>
                <td class="label-td">
                    <input type="Password" name="userpassword" class="input-text" placeholder="Password" required>
                </td>
            </tr>


            <tr>
                <td><br>
                <?php echo $error ?>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" value="Login" class="login-btn btn-primary btn">
                </td>
            </tr>
        </div>
            <tr>
                <td>
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                    <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                    <br><br><br>
                </td>
            </tr>
                        
                        
    
                        
                    </form>
        </table>

    </div>
</center>
</body>
</html>
Connection:
<?php

    $database= new mysqli("localhost","root","","edoc");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>
Create Account:
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title>Create Account</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
<?php

//learn from w3schools.com
//Unset all the server side variables

session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$_SESSION["date"]=$date;


//import database
include("connection.php");





if($_POST){

    $result= $database->query("select * from webuser");

    $fname=$_SESSION['personal']['fname'];
    $lname=$_SESSION['personal']['lname'];
    $name=$fname." ".$lname;
    $address=$_SESSION['personal']['address'];
    $nic=$_SESSION['personal']['nic'];
    $dob=$_SESSION['personal']['dob'];
    $email=$_POST['newemail'];
    $tele=$_POST['tele'];
    $newpassword=$_POST['newpassword'];
    $cpassword=$_POST['cpassword'];
    
    if ($newpassword==$cpassword){
        $result= $database->query("select * from webuser where email='$email';");
        if($result->num_rows==1){
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
        }else{
            
            $database->query("insert into patient(pemail,pname,ppassword, paddress, pnic,pdob,ptel) values('$email','$name','$newpassword','$address','$nic','$dob','$tele');");
            $database->query("insert into webuser values('$email','p')");

            //print_r("insert into patient values($pid,'$email','$fname','$lname','$newpassword','$address','$nic','$dob','$tele');");
            $_SESSION["user"]=$email;
            $_SESSION["usertype"]="p";
            $_SESSION["username"]=$fname;

            header('Location: patient/index.php');
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>';
        }
        
    }else{
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Reconfirm Password</label>';
    }



    
}else{
    //header('location: signup.php');
    $error='<label for="promter" class="form-label"></label>';
}

?>


    <center>
    <div class="container">
        <table border="0" style="width: 69%;">
            <tr>
                <td colspan="2">
                    <p class="header-text">Let's Get Started</p>
                    <p class="sub-text">It's Okay, Now Create User Account.</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <label for="newemail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="newemail" class="input-text" placeholder="Email Address" required>
                </td>
                
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="tele" class="form-label">Mobile Number: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="tel" name="tele" class="input-text"  placeholder="ex: 9076545676" pattern="[9]{1}[0-9]{9}" >
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="newpassword" class="form-label">Create New Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="newpassword" class="input-text" placeholder="New Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cpassword" class="form-label">Confirm Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required>
                </td>
            </tr>
     
            <tr>
                
                <td colspan="2">
                    <?php echo $error ?>

                </td>
            </tr>
            
            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>
            </tr>

                    </form>
            </tr>
        </table>

    </div>
</center>
</body>
</html>
Logout:
<?php 

	session_start();

	$_SESSION = array();

	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400, '/');
	}

	session_destroy();

	// redirecting the user to the login page
	header('Location: login.php?action=logout');

 ?>
Signup:
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title>Sign Up</title>
    
</head>
<body>
<?php

//learn from w3schools.com
//Unset all the server side variables

session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$_SESSION["date"]=$date;



if($_POST){

    

    $_SESSION["personal"]=array(
        'fname'=>$_POST['fname'],
        'lname'=>$_POST['lname'],
        'address'=>$_POST['address'],
        'nic'=>$_POST['nic'],
        'dob'=>$_POST['dob']
    );


    print_r($_SESSION["personal"]);
    header("location: create-account.php");




}

?>


    <center>
    <div class="container">
        <table border="0">
            <tr>
                <td colspan="2">
                    <p class="header-text">Let's Get Started</p>
                    <p class="sub-text">Add Your Personal Details to Continue</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <label for="name" class="form-label">Name: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="text" name="fname" class="input-text" placeholder="First Name" required>
                </td>
                <td class="label-td">
                    <input type="text" name="lname" class="input-text" placeholder="Last Name" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="address" class="form-label">Address: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="address" class="input-text" placeholder="Address" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="nic" class="form-label">NIC: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="nic" class="input-text" placeholder="NIC Number" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="dob" class="form-label">Date of Birth: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="date" name="dob" class="input-text" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                </td>
            </tr>

            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Next" class="login-btn btn-primary btn">
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>
            </tr>

                    </form>
            </tr>
        </table>

    </div>
</center>
</body>
</html>
SQL Database:
-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 19, 2022 at 01:39 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`aemail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aemail`, `apassword`) VALUES
('admin@edoc.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `appoid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `scheduleid` int(10) DEFAULT NULL,
  `appodate` date DEFAULT NULL,
  PRIMARY KEY (`appoid`),
  KEY `pid` (`pid`),
  KEY `scheduleid` (`scheduleid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appoid`, `pid`, `apponum`, `scheduleid`, `appodate`) VALUES
(1, 1, 1, 1, '2022-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
CREATE TABLE IF NOT EXISTS `doctor` (
  `docid` int(11) NOT NULL AUTO_INCREMENT,
  `docemail` varchar(255) DEFAULT NULL,
  `docname` varchar(255) DEFAULT NULL,
  `docpassword` varchar(255) DEFAULT NULL,
  `docnic` varchar(15) DEFAULT NULL,
  `doctel` varchar(15) DEFAULT NULL,
  `specialties` int(2) DEFAULT NULL,
  PRIMARY KEY (`docid`),
  KEY `specialties` (`specialties`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`docid`, `docemail`, `docname`, `docpassword`, `docnic`, `doctel`, `specialties`) VALUES
(1, 'doctor@edoc.com', 'Test Doctor', '123', '000000000', '0110000000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pemail` varchar(255) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pnic` varchar(15) DEFAULT NULL,
  `pdob` date DEFAULT NULL,
  `ptel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pid`, `pemail`, `pname`, `ppassword`, `paddress`, `pnic`, `pdob`, `ptel`) VALUES
(1, 'patient@edoc.com', 'Test Patient', '123', 'Sri Lanka', '0000000000', '2000-01-01', '0120000000'),
(2, 'emhashenudara@gmail.com', 'Hashen Udara', '123', 'Sri Lanka', '0110000000', '2022-06-03', '0700000000');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `scheduleid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `nop` int(4) DEFAULT NULL,
  PRIMARY KEY (`scheduleid`),
  KEY `docid` (`docid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleid`, `docid`, `title`, `scheduledate`, `scheduletime`, `nop`) VALUES
(1, '1', 'Test Session', '2050-01-01', '18:00:00', 50),
(2, '1', '1', '2022-06-10', '20:36:00', 1),
(3, '1', '12', '2022-06-10', '20:33:00', 1),
(4, '1', '1', '2022-06-10', '12:32:00', 1),
(5, '1', '1', '2022-06-10', '20:35:00', 1),
(6, '1', '12', '2022-06-10', '20:35:00', 1),
(7, '1', '1', '2022-06-24', '20:36:00', 1),
(8, '1', '12', '2022-06-10', '13:33:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

DROP TABLE IF EXISTS `specialties`;
CREATE TABLE IF NOT EXISTS `specialties` (
  `id` int(2) NOT NULL,
  `sname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `sname`) VALUES
(1, 'Accident and emergency medicine'),
(2, 'Allergology'),
(3, 'Anaesthetics'),
(4, 'Biological hematology'),
(5, 'Cardiology'),
(6, 'Child psychiatry'),
(7, 'Clinical biology'),
(8, 'Clinical chemistry'),
(9, 'Clinical neurophysiology'),
(10, 'Clinical radiology'),
(11, 'Dental, oral and maxillo-facial surgery'),
(12, 'Dermato-venerology'),
(13, 'Dermatology'),
(14, 'Endocrinology'),
(15, 'Gastro-enterologic surgery'),
(16, 'Gastroenterology'),
(17, 'General hematology'),
(18, 'General Practice'),
(19, 'General surgery'),
(20, 'Geriatrics'),
(21, 'Immunology'),
(22, 'Infectious diseases'),
(23, 'Internal medicine'),
(24, 'Laboratory medicine'),
(25, 'Maxillo-facial surgery'),
(26, 'Microbiology'),
(27, 'Nephrology'),
(28, 'Neuro-psychiatry'),
(29, 'Neurology'),
(30, 'Neurosurgery'),
(31, 'Nuclear medicine'),
(32, 'Obstetrics and gynecology'),
(33, 'Occupational medicine'),
(34, 'Ophthalmology'),
(35, 'Orthopaedics'),
(36, 'Otorhinolaryngology'),
(37, 'Paediatric surgery'),
(38, 'Paediatrics'),
(39, 'Pathology'),
(40, 'Pharmacology'),
(41, 'Physical medicine and rehabilitation'),
(42, 'Plastic surgery'),
(43, 'Podiatric Medicine'),
(44, 'Podiatric Surgery'),
(45, 'Psychiatry'),
(46, 'Public health and Preventive Medicine'),
(47, 'Radiology'),
(48, 'Radiotherapy'),
(49, 'Respiratory medicine'),
(50, 'Rheumatology'),
(51, 'Stomatology'),
(52, 'Thoracic surgery'),
(53, 'Tropical medicine'),
(54, 'Urology'),
(55, 'Vascular surgery'),
(56, 'Venereology');

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

DROP TABLE IF EXISTS `webuser`;
CREATE TABLE IF NOT EXISTS `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('admin@edoc.com', 'a'),
('doctor@edoc.com', 'd'),
('patient@edoc.com', 'p'),
('emhashenudara@gmail.com', 'p');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
admin:
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Doctor</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    

    //import database
    include("../connection.php");



    if($_POST){
        //print_r($_POST);
        $result= $database->query("select * from webuser");
        $name=$_POST['name'];
        $nic=$_POST['nic'];
        $spec=$_POST['spec'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        
        if ($password==$cpassword){
            $error='3';
            $result= $database->query("select * from webuser where email='$email';");
            if($result->num_rows==1){
                $error='1';
            }else{

                $sql1="insert into doctor(docemail,docname,docpassword,docnic,doctel,specialties) values('$email','$name','$password','$nic','$tele',$spec);";
                $sql2="insert into webuser values('$email','d')";
                $database->query($sql1);
                $database->query($sql2);

                //echo $sql1;
                //echo $sql2;
                $error= '4';
                
            }
            
        }else{
            $error='2';
        }
    
    
        
        
    }else{
        //header('location: signup.php');
        $error='3';
    }
    

    header("location: doctors.php?action=add&error=".$error);
    ?>
    
   

</body>
</html>
Css:
.container{
    display: flex;
    flex-wrap: wrap;
    height: 100vh;


}
.menu{
    border-right: 1.5px solid rgb(235, 235, 235);
    width: 21%;
    height: 100vh;
    box-shadow: 0 0px 0px 2px rgba(240, 240, 240, 0.3);
}
.dash-body{
    width: 79%;
    height: 100vh;
}

.menu-container{
    width: 100%;
    border-spacing: 0;
    
}

.profile-title{
    font-weight: 500;
    color: #161c2d;
    font-size: 22px;
    margin: 0;
    text-align: left;
    padding-left: 8%;
}

.profile-subtitle{
    font-weight: 300;
    color: #8492a6;
    font-size: 15px;
    margin: 0;
    text-align: left;
    padding-left: 8%;
}

.logout-btn{
    margin-top: 30px;
    width: 85%;
}

.profile-container{
    border-bottom: 1.5px solid rgb(235, 235, 235);
    /*border-radius: 6px;*/
    padding-top: 18%;
    padding-bottom: 12%;
    /*box-shadow: 0 0 3px rgba(52,58,64,0.08);*/
    text-align: center;
    
}


/*.menu-items1{
    font-weight: 500;
    text-align: left;
    padding: 0;
    margin: 0;
    color: #161c2def;
    
}

.menu-td1{
    padding-right: 10px;
}


.menu-button:hover{
    cursor: pointer;
    background-color:var(--btnice);
}

.menu-active{
    color:var(--btnnicetext);
    
}

.menu-items1-active{
    color:var(--btnnicetext);
    background-image: url('../img/search.svg');
    background-position: 10px 50%;
    background-repeat: no-repeat;
}



*/










.heading-main12{
    font-weight: 500;
    font-size: 25px;
}

.heading-sub12{
    font-weight: 500;
    font-size: 20px;
    text-align: right;
}


.header-search{
    display: flex;
    justify-content: center;

    
}
.header-searchbar{
    width: 75%;
    background-color: rgba(255, 255, 255, 0.705);
    border: 0.5px solid rgba(190, 190, 190, 0.884);
    
    
}

.add-doc-form-container{
    padding: 25px;
    margin-top: 30px;
    
}
/*These transition are from youtube*/

@keyframes transitionIn-X{
    from {
            opacity: 0;
            transform: translateX(-10px);

    }

    to {
            opacity: 1;
            transform: translateX(0);
    }
}
    


@keyframes transitionIn-Y-over{
    from {
            opacity: 0;
            transform: translateY(-10px);

    }

    to {
            opacity: 1;
            transform: translateY(0);
    }
}
    
@keyframes transitionIn-Y-bottom{
    from {
            opacity: 0;
            transform: translateY(30px);

    }

    to {
            opacity: 1;
            transform: translateY(0);
    }
}
    

/* Transition end */
@font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 400;
    src: local('Inter'), url('fonts/inter/Inter-Regular.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: italic;
    font-weight: 400;
    src: local('Inter'), url('fonts/inter/Inter-Italic.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 100;
    src: local('Inter'), url('fonts/inter/Inter-Thin-BETA.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: italic;
    font-weight: 100;
    src: local('Inter'), url('fonts/inter/Inter-ThinItalic-BETA.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 200;
    src: local('Inter'), url('fonts/inter/Inter-ExtraLight-BETA.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: italic;
    font-weight: 200;
    src: local('Inter'), url('fonts/inter/Inter-ExtraLightItalic-BETA.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 300;
    src: local('Inter'), url('fonts/inter/Inter-Light-BETA.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: italic;
    font-weight: 300;
    src: local('Inter'), url('fonts/inter/Inter-LightItalic-BETA.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 500;
    src: local('Inter'), url('fonts/inter/Inter-Medium.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: italic;
    font-weight: 500;
    src: local('Inter'), url('fonts/inter/Inter-MediumItalic.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 600;
    src: local('Inter'), url('fonts/inter/Inter-SemiBold.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: italic;
    font-weight: 600;
    src: local('Inter'), url('fonts/inter/Inter-SemiBoldItalic.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 700;
    src: local('Inter'), url('fonts/inter/Inter-Bold.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: italic;
    font-weight: 700;
    src: local('Inter'), url('fonts/inter/Inter-BoldItalic.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 800;
    src: local('Inter'), url('fonts/inter/Inter-ExtraBold.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: italic;
    font-weight: 800;
    src: local('Inter'), url('fonts/inter/Inter-ExtraBoldItalic.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: normal;
    font-weight: 900;
    src: local('Inter'), url('fonts/inter/Inter-Black.woff') format('woff');
}
@font-face {
    font-family: 'Inter';
    font-style: italic;
    font-weight: 900;
    src: local('Inter'), url('fonts/inter/Inter-BlackItalic.woff') format('woff');
}
body{
    background-image: url(../img/bg01.jpg);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    height: 100%;
}

html, body {
    height: 100%;
    margin: 0;
  }
  
.full-height {
    background: rgba(26, 26, 26, 0.548);
    background-attachment: fixed;
    max-height: 100vh;
    height: 100vh;


}
table{
    width: 100%;
    padding-top: 5px;
    
}
.heading-text{
    color: white;
    font-size: 42px;
    font-weight: 700;
    line-height: 63px;
    margin-top: 15%;
    text-align: center;
    margin-bottom: 0;
}

.sub-text2{
    color: rgba(255, 255, 255, 0.5);
    font-size: 17px;
    line-height: 27px;
    font-weight: 400;
    text-align: center;
    margin-top: 0;
}


.register-btn{
    background-color: rgba(240, 248, 255, 0.589);
    color: #345cc4;
}


.edoc-logo{
    color: white;
    font-weight: bolder;
    font-size: 20px;
    padding-left: 20px;
    animation: transitionIn-Y-over 0.5s;
}

.edoc-logo-sub{
    color: rgba(255, 255, 255, 0.733);
    font-size: 12px;

}


.nav-item{
    color: rgba(255, 255, 255, 0.671);
    text-align: center;
    font-size: 15px;
    font-weight: 500;
    animation: transitionIn-Y-over 0.5s;
}

.nav-item:hover{
    color: #f0f0f0;

}

.footer-hashen{
    position: absolute;
    bottom: 0;
    left: 45%;
    font-size: 13px;
    animation: transitionIn-Y-over 0.5s;
}

body{
    margin: 7%;
    background-color: #F6F7FA;
}



.container{
    width: 45%;
    background-color: white;
    border: 1px solid rgb(235, 235, 235);
    border-radius: 8px;
    margin: 0;
    padding: 0;
    box-shadow: 0 3px 5px 0 rgba(240, 240, 240, 0.3);
    animation: transitionIn-Y-over 0.5s;

}
td{
    text-align: center;

}
.header-text{
    font-weight: 600;
    font-size: 30px;
    letter-spacing: 1px;
    margin-bottom: 10px;

}

.sub-text{
    font-size: 15px;
    color: rgb(138, 138, 138);
}

.form-label{
    color: rgb(44, 44, 44);
    text-align: left;
    font-size: 14px;
}
.label-td{
    text-align: left;
    padding-top: 10px;
}

.hover-link1{
    font-weight: bold;
}


.hover-link1:hover{
    opacity: 0.8;
    transition: 0.5s;


}.login-btn{
    /*margin-top: 15px;*/
    margin-bottom: 15px;
    width: 100%;
}
@import url('font-inter.css');
:root {
  --primarycolor: #0A76D8;
  --primarycolorhover: #006dd3;
  --btnice:#D8EBFA;
  --btnnicetext:#1b62b3;
}

body{
    margin: 0;
    padding: 0;
    border-spacing: 0;
    font-family: 'Inter', sans-serif;
    
}

*, ::after, ::before{
    box-sizing: border-box;
}


/*------custom-scroll-bar - from w3schools.com------------------*/
/* width */
::-webkit-scrollbar {
    width: 5px;
  }
  
  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f1; 
  }
   
  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 12px;
  }
  
  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #555; 
  }





.input-text{
    border-radius: 4px;
    border: 0.5px solid rgb(226, 226, 226);
    padding: 10px;
    width: 92%;
    transition: 0.2s;
    outline: none;
}

.input-text{
    border: 1px solid #e9ecef;
    font-size: 14px;
    line-height: 26px;
    background-color: #fff;
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-weight: 300;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.input-text:hover{
    background-color: rgb(250, 250, 250);
    transition: 0.2s;
    outline: none;
}

.input-text:focus{
    border: 1px solid rgb(10,118,216);
    transition: 0.2s;
}

.input-text::placeholder{
    font-family: 'Inter', sans-serif;
}



/* -----------Buttons---------------*/
.btn{
    cursor: pointer;
    padding: 8px 20px;
    outline: none;
    text-decoration: none;
    font-size: 15px;
    letter-spacing: 0.5px;
    transition: all 0.3s;
    border-radius: 5px;
    font-family: 'Inter', sans-serif;
}


.btn:hover{
    background-color: var(--primarycolorhover);
    box-shadow: none;
    transition: all 0.5s;
    font-family: 'Inter', sans-serif;

}


.btn-primary{
    background-color: var(--primarycolor) ;
    border: 1px solid var(--primarycolor) ;
    color: #fff ;
    box-shadow: 0 3px 5px 0 rgba(57,108,240,0.3);
}

.btn-primary-soft{
    background-color: #D8EBFA ;
    /*border: 1px solid rgba(57,108,240,0.1) ;*/    color: #1969AA;
    font-weight: 500;
    font-size: 16px;
    border: none;
    /*box-shadow: 0 3px 5px 0 rgba(57,108,240,0.3)*/
}


.btn-primary-soft:hover{
    background-color: var(--primarycolor) ;
    /*border: 1px solid rgba(57,108,240,0.1) ;*/
    color: #fff ;
    box-shadow: 0 3px 5px 0 rgba(57,108,240,0.3);
}


.btn-in-text{
    font-size: 15px;
    letter-spacing: 0.5px;
}

.non-style-link:link, .non-style-link:visited, .non-style-link:hover, .non-style-link:active{
    text-decoration: none;
    color: rgb(43, 43, 43);
}




.btn-label{
    margin-left: 10px;
    padding: 12px 12px;
    outline: none;
    text-decoration: none;
    font-size: 15px;
    letter-spacing: 0.5px;
    transition: all 0.3s;
    border-radius: 5px;
    background-color: #f0f0f073;
    border: 1px solid rgba(57,108,240,0.1) ;
    font-family: 'Inter', sans-serif;
}


.sub-table{
    border: 1px solid #ebebeb;
    border-radius: 8px;
    
}

.filter-container{
  width: 92.5%;
  border: 1px solid #ebebeb;
  border-radius: 8px;
  margin-bottom: 20px;
  border-spacing: 0;
  padding: 0;
}

.filter-container-items{
  margin-top: 7.5px;
  margin-left: 20px;


}
.table-headin{
    font-size: 16px;
    font-weight: 500;
    padding: 10px;
    border-bottom: 3px solid var(--primarycolor);
}

.abc{
  width: 100%;
  height: 550px;
  overflow: auto;
}





        
.overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    transition: opacity 500ms;
    opacity: 1;
  }
  .overlay:target {
    visibility: visible;
    opacity: 1;
    
  }
  
  .popup {
    margin: 70px auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    width: 50%;
    position: relative;
    transition: all 5s ease-in-out;
  }
  
  .popup h2 {
    margin-top: 0;
    color: #333;
  }
  .popup .close {
    position: absolute;
    top: 20px;
    right: 30px;
    transition: all 200ms;
    font-size: 30px;
    font-weight: bold;
    text-decoration: none;
    color: #333;
  }
  .popup .close:hover {
    color: var(--primarycolorhover);
  }
  .popup .content {
    max-height: 30%;
    overflow: auto;
  }
  
  @media screen and (max-width: 700px){
    .box{
      width: 70%;
    }
    .popup{
      width: 70%;
    }
  }


input[type=search] {
    background-image: url('../img/search.svg');
    background-position: 10px 50%;
    background-repeat: no-repeat;
    transition: 0.5s;
    padding: 8px 20px 8px 40px;
}

input[type=search]:focus {
    transition: 0.5s;
}

.box {
  width: 120px;
  height: 30px;
  border: 1px solid #e9ecef;
  font-size: 14px;
  color: #212529;
  background-color: #fff;
  line-height: 26px;
  font-weight: 300;
  border-radius: .25rem;
  padding: .375rem .75rem;
  line-height: 1.5;
  width: 100%;
  background-clip: padding-box;
  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}



.btn-primary-gray{
  background-color: #fff;
  border: 2px solid #c9cbce9f;
  color: #212529d0;
  box-shadow: 0 3px 5px 0 rgba(95, 95, 97, 0.3);
}



.btn-primary-gray:hover{
  background-color: #5185ffa9;
  box-shadow: 0 3px 5px 0 rgba(95, 95, 97, 0.3);
}



.button-icon{
  
  background-position: 10px 50%;
  background-repeat: no-repeat;
  transition: 0.5s;
  padding: 8px 20px 8px 40px;
}



.menu-btn{
  padding:6px;
  color: #3b3b3b;
  background-position: 30% 50%;
  background-repeat: no-repeat;
  transition: 0.5s;
  
}

.menu-text{
  padding-left: 40%;
  font-weight: 500;
  font-size: 16px;
  
}


.menu-active{
  color: var(--primarycolor);
  border-right: 7px solid var(--primarycolor);
  background-color: var();
}

.menu-btn:hover{
  background-color: var(--btnice);
  color: var(--primarycolor);
}

.non-style-link-menu:link, .non-style-link-menu:visited,  .non-style-link-menu:active{
  text-decoration: none;
  color: #3b3b3b;
}
.non-style-link-menu:hover{
  text-decoration: none;
  color: var(--primarycolor);
}

.non-style-link-menu-active:link, .non-style-link-menu-active:visited,  .non-style-link-menu-active:active{
  text-decoration: none;
  color: var(--primarycolor);
}



.menu-icon-dashbord{
  background-image: url('../img/icons/dashboard.svg');
}


.menu-icon-doctor{
  background-image: url('../img/icons/doctors.svg');
}
.menu-icon-schedule{
  background-image: url('../img/icons/schedule.svg');
}
.menu-icon-appoinment{
  background-image: url('../img/icons/book.svg');
}
.menu-icon-patient{
  background-image: url('../img/icons/patients.svg');
}
.menu-icon-settings{
  background-image: url('../img/icons/settings.svg');
}

.menu-icon-session{
  background-image: url('../img/icons/session.svg');
}
.menu-icon-home{
  background-image: url('../img/icons/home.svg');
}



.menu-icon-dashbord:hover,.menu-icon-dashbord-active{
  color: var(--primarycolor);

  background-image: url('../img/icons/dashboard-hover.svg');
}


.menu-icon-doctor:hover,.menu-icon-doctor-active{
  color: var(--primarycolor);
  background-image: url('../img/icons/doctors-hover.svg');
}
.menu-icon-schedule:hover,.menu-icon-schedule-active{
  color: var(--primarycolor);
  
  background-image: url('../img/icons/schedule-hover.svg');
}
.menu-icon-appoinment:hover,.menu-icon-appoinment-active{
  color: var(--primarycolor);
  
  background-image: url('../img/icons/book-hover.svg');
}
.menu-icon-patient:hover,.menu-icon-patient-active{
  color: var(--primarycolor);
  
  background-image: url('../img/icons/patients-hover.svg');
}

.menu-icon-settings:hover,.menu-icon-settings-active{
  color: var(--primarycolor);
  
  background-image: url('../img/icons/settings-iceblue.svg');
}

.menu-icon-session:hover,.menu-icon-session-active{
  color: var(--primarycolor);
  
  background-image: url('../img/icons/session-iceblue.svg');
}
.menu-icon-home:hover,.menu-icon-home-active{
  color: var(--primarycolor);
  
  background-image: url('../img/icons/home-iceblue.svg');
}





.btn-icon-back{
  background-image: url('../img/icons/back-iceblue.svg');
  background-position: 18px 50%;
  background-repeat: no-repeat;
  transition: 0.5s;
  padding: 8px 20px 8px 40px;
}

.btn-icon-back:hover{
  background-image: url('../img/icons/back-white.svg');
}


.btn-edit{
  background-image: url('../img/icons/edit-iceblue.svg');
}
.btn-edit:hover{
  background-image: url('../img/icons/edit-white.svg');
}

.btn-view{
  background-image: url('../img/icons/view-iceblue.svg');
}
.btn-view:hover{
  background-image: url('../img/icons/view-white.svg');
}

.btn-delete{
  background-image: url('../img/icons/delete-iceblue.svg');
}
.btn-delete:hover{
  background-image: url('../img/icons/delete-white.svg');
}

.btn-filter{
  background-image: url('../img/icons/filter-iceblue.svg');
  background-position: 15px 50%;
}
.btn-filter:hover{
  background-image: url('../img/icons/filter-white.svg');
}




.dashboard-items{
  
  border: 2px solid #c9cbce9f;
  border-radius: 7px;
  color: var(--primarycolor);
  /*background-color: #d8ebfa25 ;*/
  /*box-shadow: 0 3px 5px 0 rgba(95, 95, 97, 0.3);*/
}


.h1-dashboard{
  margin: 0;
  padding: 0;
  font-size: 25px;
  font-weight: 600;
  line-height: 0;
  padding-top: 20px;
}

.h3-dashboard{
  margin: 0;
  padding: 0;
  font-size: 20px;
  font-weight: 500;
  color: #212529e3;
}

.dashboard-icons{
  background-color: rgba(184, 184, 184, 0.247);
  padding-top: 30px;
  padding-bottom: 30px;
  border-radius: 7px;
  margin-left: 40px;
  margin-right: 0px;
  
}
.dashboard-icons-setting{
  background-color: rgba(184, 184, 184, 0.247);
  padding-top: 30px;
  padding-bottom: 30px;
  border-radius: 7px;
  margin-left: 5px;
  margin-right: 20px;
  
}

.setting-tabs:hover{
  background-color: #d6d6d657;
}


.doctor-header{
  background-image: url(../img/b8.jpg);
  color: rgba(0, 0, 0, 0.87);
  background-size: 100%;
  background-repeat: no-repeat;
  padding: 20px;
  padding-left: 35px;
}

.patient-header{
  background-image: url(../img/b3.jpg);
}

.search-items{
  padding:20px;
  margin:10px;
  width:95%;
  display: flex;
  padding-left:0;
  padding-left: 30px;
  box-sizing: border-box;
  line-height: 1.5;
  box-shadow: 0 3px 5px 0 rgba(95, 95, 97, 0.068);
}


.h1-search{
  margin: 0;
  padding: 0;
  font-size: 23px;
  font-weight: 600;
  padding-top: 20px;
  padding-bottom: 10px;
}

.h3-search{
  margin: 0;
  padding: 0;
  font-size: 15px;
  font-weight: 500;
  color: #212529e3;
  
}

.h4-search{
  margin: 0;
  padding: 0;
  font-size: 13px;
  font-weight: 400;
  color: #212529e3;
}

.btn-book{
  background-image: url('../img/icons/book-balck.svg');
  background-position: 68% 50%;
  background-repeat: no-repeat;
  transition: 0.5s;
}
body{
    border-spacing: 0;
    margin: 0;
    padding: 0
}
.container{
    display: flex;
    flex-wrap: wrap;
    height: 100vh;


}
.menu{
    border-right: 1.5px solid rgb(235, 235, 235);
    width: 24%;
    height: 100%;
    box-shadow: 0 0px 0px 2px rgba(240, 240, 240, 0.3);
}
.dash-body{
    width: 76%;
    height: 100%;
}

.menu-container{
    width: 100%;
    border-spacing: 0;
    
}

.profile-title{
    font-weight: 500;
    color: #161c2d;
    font-size: 22px;
    margin: 0;
    text-align: left;
    padding-left: 8%;
}

.profile-subtitle{
    font-weight: 300;
    color: #8492a6;
    font-size: 15px;
    margin: 0;
    text-align: left;
    padding-left: 8%;
}

.logout-btn{
    margin-top: 20px;
    width: 85%;
}

.profile-container{
    border: 1.5px solid rgb(235, 235, 235);
    border-radius: 6px;
    padding-top: 12%;
    padding-bottom: 12%;
    box-shadow: 0 0 3px rgba(52,58,64,0.08);
    text-align: center;
    
}


.menu-items1{
    font-weight: 500;
    text-align: left;
    padding: 0;
    margin: 0;
    color: #161c2def;
}

.menu-td1{
    padding-right: 10px;
}


.menu-button:hover{
    cursor: pointer;
    background-color:#396df01f;
}

.menu-active{
    background-color:#27272710;
}


.header-container{
    margin-top: 25px;
    margin-bottom: 5%;
    background-image: url(../img/bg01.jpg);
    
    background-repeat: no-repeat;
    background-size:cover;
    height: 300px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 3px 5px 0 rgba(240, 240, 240, 0.3);
    border-spacing: 0;
    
}

.header-items{
    background: rgba(26, 26, 26, 0.548);
    border-radius: 10px;
    border-spacing: 0;
}

#header-heading{
    font-size: 30px;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.938);
}

#header-sub-heading{
    font-size: 17px;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.5)
    ;
}

.header-search{
    display: flex;
    justify-content: center;

    
}
.header-searchbar{
    width: 40%;
    background-color: rgba(255, 255, 255, 0.705);
    border: 0.5px solid rgba(190, 190, 190, 0.884);
    
    
}

body{
    margin: 2%;
    background-color: #F6F7FA;
}
.container{
    width: 45%;
    background-color: white;
    border: 1px solid rgb(235, 235, 235);
    border-radius: 8px;
    margin: 0;
    padding: 0;
    box-shadow: 0 3px 5px 0 rgba(240, 240, 240, 0.3);
    animation: transitionIn-Y-over 0.5s;

}
td{
    text-align: center;

}
.header-text{
    font-weight: 600;
    font-size: 30px;
    letter-spacing: -1px;
    margin-bottom: 10px;
}

.sub-text{
    font-size: 15px;
    color: rgb(138, 138, 138);
}

.form-label{
    color: rgb(44, 44, 44);
    text-align: left;
    font-size: 14px;
}
.label-td{
    text-align: left;
    padding-top: 10px;
}

.hover-link1{
    font-weight: bold;
}


.hover-link1:hover{
    opacity: 0.8;
    transition: 0.5s;


}.login-btn{
    margin-top: 15px;
    margin-bottom: 15px;
    width: 100%;
}


