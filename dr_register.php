<?php
$success = 0;
$user = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $education = $_POST['edu'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $sql = "select * from `registration` where username ='$username'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $user = 1;
        } else {
            $sql = "insert into `registration`(username , password , address , edu , contact , email) values('$username' , '$password' , '$address', '$education' , '$contact' , '$email')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $success = 1;
                // Redirect to login_signup_dr.php webpage
                header("Location: login_signup_dr.php");
                exit(); // Make sure to exit after header redirection
            } else {
                die(mysqli_error($con));
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Registration</title>
    <style>
        
html{
    font-size: 62.5%;
    font-family: 'Poppins', sans-serif;
    overflow: visible;
    scroll-padding-top: 7rem;
    scroll-behavior: smooth;
    background-color: #16a085;
    background-image: url('pngtree-health-medical-hospital-medicine-blue-banner-advertisement-image_177364.jpg');
    background-size: cover;
    background-position: center;
}

.header{
    padding: 1rem 9%;
    position: fixed;
    top: 0;left: 0;right: 0;
    z-index: 1000;
    box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: white  ;
    
}
.header .logo{   
    display: flex;
    justify-content : start;                                             
    font-size: 2.8rem;
    color: var(--black);
}
.header .logo i{
    color: var(--green);
}
.header .navbar a{
    font-size: 1.7rem;
    color: var(--light-color);
    color: grey;
    margin-left: 2rem;
    text-decoration:none;

    
}
.header .navbar a:hover{
    color:var(--green);
    color : #16a085;
}
.main{
    position: absolute;
    display : flex;
    flex-direction : column;
    justify-content : space-between;
    top: 150px;
    font-size : 20px;
    align-text : center;
}
button {
    position: absolute;
    margin-top : 50px;
    margin-left : 48%;
    background-color: blue;
    color: white;
    padding: 10px 15px;
    font-size : 20px;
    border: none;
    cursor: pointer;
    border-radius : 30px;
    margin-bottom :50px;
}

button:hover{
    opacity: 0.7;
}
label { 
    margin-top : 10px;

}
.textb{
    height : 40px;
    width: 550px;
    display : flex;
    flex-direction : column;
    border : none;
    margin-top : 20px;
    margin-bottom : 10px;
    margin-left : 100%;

}

.textb input{
    border : none;
    padding-top : 10px;
    padding-bottom : 10px;
    border-radius : 10px;
    width: 550px;
    margin : 10px;

}

.textb label{
    color : black;  
}
</style>
</head>
<body>
<header class = "header">
            <a href = " index.html" ><img src = "Screenshot 2023-10-21 003337.png" class = "logo" width = "120" height="70"><i class = "fas fa-heartbeat"></i></img></a>
             <nav class = "navbar">
              <a href = "index.html">HOME</a>
              <a href = "Vaccine.html" target = "_blank">VACCINES </a>
              
             </nav>
            
        </header>

        <form action = "dr_register.php" method = "post">
        <div class="main">
            <div class = "textb">
            <label for = "one">Enter your name</label>
            <input id = "one" type= "text" name = "username" required placeholder = 
            "Enter your Username" class = "text">
            <label for = "two">Set your password</label>
            <input id = "two" type= "password" name = "password" required placeholder = 
            "Enter your password" class = "text">
            <label for = "three">Enter your address</label>
            <input id = "three" type="text" name = "address" required placeholder = 
            "Enter your Address" class = "text">
            <label for = "four">Enter your education</label>
            <input id = "four" type="text" name = "edu" required placeholder = 
            "Enter your Education" class = "text">
            <label for = "five">Enter your contact no.</label>
            <input id = "five" type="text" name = "contact" required placeholder = 
            "Enter your Contact no." class = "text">
            <label for = "six">Enter your email</label>
            <input id = "six" type="text" name = "email" required placeholder = 
            "Enter your Email" class = "text">
            <div class = "button">
            <button type = "submit" class = "btn btn-primary">Submit</button>
        </div>
</div>

</div>
</form>
</body>
</html>