<?php
// Start the session
session_start();

// Check if the doctor is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if not logged in
    header("Location: login_signup_dr.php");
    exit();
}

// Get the doctor ID from the session
$doctor_id = $_SESSION['id'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "signupform" , 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your meta tags, title, and other head elements here -->

    <style>
        :root {
            --green: #02874f; /* Dark Green */
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow: hidden;
            background-color: #f5f5f5; /* Light Gray */
            background-image: url('pngtree-health-medical-hospital-medicine-blue-banner-advertisement-image_177364.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 800px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent White */
            border: 2px solid var(--green);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 0%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 2px solid var(--green);
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: var(--green);
            color: white;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 style="text-align: center; color: var(--green);">Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <?php
        echo"<h2>Your Patients</h2>";
        // Fetch the last updated values for each patient
        $fetchRecordsSql = "SELECT r.id, r.username, r.child_name, r.child_age, r.doctor_id,
                            v.vaccine_name 
                            FROM registrationp r
                            LEFT JOIN (
                                SELECT id, vaccine_name, dose, Vaccination_date
                                FROM registrationp
                                ORDER BY Vaccination_date DESC
                                LIMIT 1
                            ) v ON r.id = v.id
                            WHERE r.doctor_id = $doctor_id";

        $recordsResult = mysqli_query($conn, $fetchRecordsSql);

        if ($recordsResult !== false) {
            if ($recordsResult->num_rows > 0) {
                // echo "<h2>Last Vaccination Records</h2>";
                echo "<table border='1' style='margin-top: 20px;padding : 0px;'>
                        <tr style='padding : 10px;'>
                            <th>Patient ID</th>
                            <th>Username</th>
                            <th>Child Name</th>
                            <th>Child Age</th>
                            <th>Doctor ID</th>
                            <th>Action</th>
                        </tr>";

                while ($row = $recordsResult->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['child_name']}</td>
                            <td>{$row['child_age']}</td>
                            <td>{$row['doctor_id']}</td>
                            <td><a href='update_vaccine.php?patient_id={$row["id"]}' style='background-color: blue; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px;'>Update</a></td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "No vaccine records found for Doctor ID: $doctor_id";
            }
        } else {
            echo "Error fetching vaccine records: " . mysqli_error($conn);
        }

        // Fetch the booking details for the doctor
        $fetchBookingsSql = "SELECT r.id, r.username, r.child_name, r.child_age, b.vaccine_name, b.dose 
                            FROM registrationp r
                            JOIN vaccine_bookings b ON r.id = b.patient_id
                            WHERE b.doctor_id = $doctor_id";

        $bookingsResult = mysqli_query($conn, $fetchBookingsSql);

        if ($bookingsResult !== false) {
            echo "<h2>Vaccine Bookings</h2>";
            echo "<table border='1' style='margin-top: 20px;padding : 0px;' >
                    <tr style='padding : 10px;'>
                        <th>Patient ID</th>
                        <th>Username</th>
                        <th>Child Name</th>
                        <th>Child Age</th>
                        <th>Vaccine</th>
                        <th>Dose</th>
                    </tr>";

            while ($row = $bookingsResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['child_name']}</td>
                        <td>{$row['child_age']}</td>
                        <td>{$row['vaccine_name']}</td>
                        <td>{$row['dose']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "Error fetching booking records: " . mysqli_error($conn);
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>

</body>

</html>
