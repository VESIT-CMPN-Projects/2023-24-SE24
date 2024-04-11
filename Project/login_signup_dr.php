<?php
session_start();

// Assuming you have a connection to the database
$conn = mysqli_connect("localhost", "root", "", "signupform" , 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from the form
    $username = isset($_POST['username']) ? $_POST['username'] : $username;
    $password = isset($_POST['password']) ? $_POST['password'] : $password;

    // Your existing login logic (replace this with your actual login check)
    $loginSql = "SELECT * FROM `registration` WHERE username = '$username' AND password = '$password'";
    $loginResult = mysqli_query($conn, $loginSql);

    if ($loginResult !== false && $loginResult->num_rows > 0) {
        // Login successful
        // Store user data in the session
        $user = $loginResult->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to the doctor's homepage
        header("Location: dr_homepage.php");
        exit();
    } else {
        // If login fails, you can display an error message or perform other actions
        echo "Login failed. Please check your credentials.";
    }
}
// Close the database connection
$conn->close();
?>

<!-- ALL HTML CSS MATERIAL HERE -->
<!DOCTYPE html>
<html>
    <head>
        <title>login/signup</title>
        <style>
html{
    font-size: 62.5%;
    overflow: visible;
    scroll-padding-top: 7rem;
    scroll-behavior: smooth;
    background-color: #16a085;  
  }


/* Control the right side */


/* If you want the content centered horizontally and vertically */
.centered {
  position: absolute;
  top: 50%;
  font-size : 12px;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.header{
    padding: 2rem 9%;
    position: fixed;
    height : 85px;
    top: 0;left: 0;right: 0;
    z-index: 1000;
    box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: white  ;
    
}
.header .logo{                                               
    font-size: 2.5rem;
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
}
.header .navbar a:hover{
    color:var(--green);
    color : #16a085;
}
#menu-btn{
    font-size: 2.5rem;
    border-radius: .5rem;
    background: hsla(150, 12%, 97%, 0.933);
    color:var(--green);
    cursor: pointer;
    padding: 1rem 1.5rem;
    display: none;
}
html{
    font-size: 62.5%;
    overflow: visible;
    scroll-padding-top: 7rem;
    scroll-behavior: smooth;
}
:root{
    --green:#16a085;
    --black:#444;
    --light-color:#777;
    --box-shadow:.5rem .5rem 0 rgba(22 , 160 , 133 , .2);
    --text-shadow: .4rem .4rem 0 rgba(0,0,0,.2);
    --border:.2rem solid var(var(--green));
}
label { 
  font-size : 16px;
}

*{
    font-family: 'Poppins', sans-serif;
    margin:0; padding: 0;
    box-sizing : border-box;
    outline: none; border: none;
    text-transform: capitalize;
    transition: all .2s ease-out;
    text-decoration: none;
}
.split img {
  border-radius: 50%;
  margin-top: 100%;
}

.split h1 {
    font-size: 30px;
    font-family: 'Poppins', sans-serif;
    margin-top: 10%;
}

.split .centered p{
    font-size: 20px;
    margin-top: 10px;
    margin-bottom: 10pxx;
   
}

.split .centered label{
    font-family: 'Poppins', sans-serif;
    left: 80px;
    font-size: 20px;  
    line-height: 50px; 
    align-items:last baseline; 
    
}

form1 {border: 3px solid #f1f1f1;}
input[type=text], input[type=password] {
  width: 530px;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
  border-radius : 10px;
}
button {
  background-color: blue;
  width : 10px;
  padding-top : 15px;
  padding-bottom : 15px;
  color: white;
  font-weight : bold;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-top: 20px;
}

button:hover{
  opacity: 0.7;
}
.split .centered a{
   color :black;
}

.ss{
  height: 200px;
  width : 200px;
  border-radius:50%;
  margin-bottom:20px;
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
        <form action="login_signup_dr.php" method="post" enctype="multipart/form-data">

        <div class="left">
            <div class="centered">
              <img class = "ss"src="360_F_338122884_PILSXdgGhZBefVzrHnei5B2zOZSgcPir.webp" alt="DOCTOR" height = 200px width = 200px>
              <h1>DOCTOR LOGIN</h1>
              <p>The doctors are requested to login from here.</p>
              <div class = "login">
              <label for="username"><b>Username</b></label><br>
                <input type="text" placeholder="Enter Username" name="username" required>
                <br>
                <label for="password"><b>Password</b></label><br>
                <input type="password" placeholder="Enter Password" name="password" required>
                <br>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <a href = "http://localhost/js/dr_register.php">Didn't sign up? Register now</a>
                
              </div>
            </div>
          </div>
      </form1>
      
    </body>
    
        
        </div>
    </section>
</html>


