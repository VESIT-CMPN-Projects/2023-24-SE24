
<?php
$success = 0;
$user = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $child_name = mysqli_real_escape_string($con, $_POST['child_name']);
    $child_age = mysqli_real_escape_string($con, $_POST['child_age']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $doctor_id = mysqli_real_escape_string($con, $_POST['doctor_id']);

    // Validate and sanitize user inputs as needed

    $sql = "SELECT * FROM `registrationp` WHERE username ='$username'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $user = 1;
        } else {
            $sql = "INSERT INTO `registrationp`(username, password, child_name, child_age, contact, email, address, doctor_id) 
                    VALUES('$username', '$password', '$child_name', '$child_age', '$contact', '$email', '$address', '$doctor_id')";
            $result = mysqli_query($con, $sql);

            if ($result) {
                $success = 1;
                // Redirect to login_signup_pat webpage
                header("Location: login_signup_pat.php");
                exit(); // Make sure to exit after header redirection
            } else {
                die(mysqli_error($con));
            }
        }
    }
}

// Code for printing vaccination report
if ($success == 1) {
    // You can fetch and display vaccination details here
    $sql_vaccination = "SELECT * FROM `vaccination_records` WHERE child_name ='$child_name'";
    $result_vaccination = mysqli_query($con, $sql_vaccination);

    if ($result_vaccination) {
        while ($row_vaccination = mysqli_fetch_array($result_vaccination)) {
            // Display vaccination details as needed
            echo "<p>Vaccine Name: " . $row_vaccination['vaccine_name'] . "</p>";
            echo "<p>Vaccination Date: " . $row_vaccination['vaccination_date'] . "</p>";
            // Add more details as necessary
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html {
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

        body {
            margin: 0;
            padding: 0;
        }

        .header {
            padding: 1rem 8%;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: white;
        }

        .header .logo {
            display: flex;
            justify-content: start;
            font-size: 2.5rem;
            color: var(--black);
        }

        .header .logo i {
            color: var(--green);
        }

        .header .navbar a {
            font-size: 1.7rem;
            color: var(--light-color);
            color: grey;
            margin-left: 2rem;
            text-decoration: none;
        }

        .header .navbar a:hover {
            color: var(--green);
            color: #16a085;
        }

        .main {
            padding-top: 150px;
            padding-bottom: 50px;
            display: flex;
            font-size: 20px;
            flex-direction: column;
            align-items: center;
            text-align: left;
            color: white;
        }

        .textb {
            margin-top: 20px;
        }

        .textb label {
            display: block;
            color: black;
            margin-bottom: 5px;
            margin-left: 0px;
            
        }

        .textb input {
            border: none;
            padding: 10px;
            border-radius: 10px;
            width: 400px;
            margin: 10px 0;
        }

        .button input {
            background-color: blue;
            color: white;
            padding: 10px 30px;
            font-size: 20px;
            border: none;
            cursor: pointer;
            border-radius: 30px;
            transition: opacity 0.3s;
        }

        .button input:hover {
            opacity: 0.8;
        }

        .logo img {
            height: 70px;
            width: auto;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="index.html"><img src="Screenshot 2023-10-21 003337.png" alt="Logo"></a>
            
        </div>
        <nav class="navbar">
            <a href="index.html">HOME</a>
            <a href="Vaccine.html" target="_blank">VACCINES </a>
        </nav>
    </header>

    <form action="pat_register.php" method="post">
        <div class="main">
            <div class="textb">
            <label for = "one">Enter your name</label>
            <input id = "one" type= "text" name = "username" required placeholder = 
            "Enter your Username" class = "text">
            <label for = "two">Set your password</label>
            <input id = "two" type= "password" name = "password" required placeholder = 
            "Enter your password" class = "text">
            <label for = "three">Enter your child's name</label>
            <input id = "three" type="text" name = "child_name" required placeholder = 
            "Enter your Child's name" class = "text">
            <label for = "four">Enter your child's age</label>
            <input id = "four" type="text" name = "child_age" required placeholder = 
            "Enter your Child's age" class = "text">
            <label for = "five">Enter your contact no.</label>
            <input id = "five" type="text" name = "contact" required placeholder = 
            "Enter your Contact no." class = "text">
            <label for = "six">Enter your email</label>
            <input id = "six" type="text" name = "email" required placeholder = 
            "Enter your Email" class = "text">
            <label for = "seven">Enter your address</label>
            <input id = "seven" type= "input" name = "address" required placeholder = 
            "Enter your Address" class = "text">
            <label for = "eight">Enter Id of your doctor</label>
            <input id = "eight" type= "input" name = "doctor_id" required placeholder = 
            "Enter Id of doctor you are under" class = "text">
            
            <div class="button">
                <input type="submit" value="Submit">
            </div>
        </div>
    </form>

</body>

</html>
