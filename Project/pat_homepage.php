<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if not logged in
    header("Location: login_signup_pat.php");
    exit();
}

// Check if the "Download as PDF" button is clicked
if (isset($_POST['download_pdf'])) {
    // Include the TCPDF library
    require_once('tcpdf-main/tcpdf.php');

    // Create a new PDF document
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, 10);

    // Initialize database connection
    $conn = mysqli_connect("localhost", "root", "", "signupform" , 3307);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch patient details
    $patientId = $_SESSION['id'];
    $fetchDetailsSql = "SELECT id, username, child_name, child_age FROM `registrationp` WHERE id = $patientId";
    $detailsResult = mysqli_query($conn, $fetchDetailsSql);

    // Fetch vaccine records
    $fetchRecordsSql = "SELECT vaccine_name, dose, Vaccination_date FROM `vaccine_records` WHERE patient_id = $patientId";
    $recordsResult = mysqli_query($conn, $fetchRecordsSql);

    // Set headers for PDF output
    $pdf->SetHeaderData('', 0, 'Patient Vaccination Details', '');
    $pdf->AddPage();

    // Add patient details to the PDF
    while ($row = $detailsResult->fetch_assoc()) {
        $pdf->Write(10, "Patient ID: {$row['id']}");
        $pdf->Ln();
        $pdf->Write(10, "Username: {$row['username']}");
        $pdf->Ln();
        $pdf->Write(10, "Child Name: {$row['child_name']}");
        $pdf->Ln();
        $pdf->Write(10, "Child Age: {$row['child_age']}");
        $pdf->Ln();
    }

    // Add a separator
    $pdf->Write(10, '-------------------------');
    $pdf->Ln();

    // Add vaccine records to the PDF
    while ($row = $recordsResult->fetch_assoc()) {
        $pdf->Write(10, "Vaccine Name: {$row['vaccine_name']}");
        $pdf->Ln();
        $pdf->Write(10, "Dose: {$row['dose']}");
        $pdf->Ln();
        $pdf->Write(10, "Vaccination Date: {$row['Vaccination_date']}");
        $pdf->Ln();
        $pdf->Ln();
    }

    // Output PDF to the browser
    $pdf->Output('patient_vaccination_records.pdf', 'D');
    exit(); // Terminate the script after generating and sending the PDF
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "signupform" , 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Vaccination Details</title>

    <!-- Add your CSS styles here -->
    <style>
       body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5; /* Light Gray */
    background-image: url('pngtree-health-medical-hospital-medicine-blue-banner-advertisement-image_177364.jpg'); /* Replace with your image URL */
    background-size: cover;
    background-position: center;
    /* margin: 0; Remove default body margin */
    padding: 0; /* Remove default body padding */
    height: 100vh; /* Set the body height to the full viewport height */
    overflow: hidden; /* Hide overflow to prevent scrolling */
}

.container {
    max-width: 800px;
   
    margin: auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent White */
    border: 2px solid #02874f; /* Dark Green */
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}


table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 2px solid #02874f; /* Dark Green */
    padding: 10px;
    text-align: left;
}

th {
    background-color: #02874f; /* Dark Green */
    color: white;
}

.download-btn {
    margin-top: 20px;
    padding: 10px;
    background-color: #ff9933; /* Saffron */
    color: #02874f; /* Dark Green */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.download-btn:hover {
    background-color: #e68a00; /* Darker Saffron on hover */
}

a{
    text-decoration: none;
    font-size: 25px;
}

    </style>
</head>

<body>

    <div class="container">

        <h2>Patient Details</h2>

        <!-- Display patient details from registrationp table -->
        <table>
            <tr>
                <th>Patient ID</th>
                <th>Username</th>
                <th>Child Name</th>
                <th>Child Age</th>
            </tr>
            <!-- PHP code to fetch and display details here -->
            <?php
            $patientId = $_SESSION['id'];
            $fetchDetailsSql = "SELECT id, username, child_name, child_age FROM `registrationp` WHERE id = $patientId";
            $detailsResult = mysqli_query($conn, $fetchDetailsSql);

            if ($detailsResult !== false && $detailsResult->num_rows > 0) {
                while ($row = $detailsResult->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['child_name']}</td>
                            <td>{$row['child_age']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No details found</td></tr>";
            }
            ?>
        </table>

        <!-- Display vaccine records for the patient -->
<h2>Vaccine Records</h2>
<table>
    <tr>
        <th>Vaccine Name</th>
        <th>Dose</th>
        <th>Vaccination Date</th>
    </tr>
    <!-- PHP code to fetch and display vaccine records here -->
    <?php
    $fetchRecordsSql = "SELECT vaccine_name, dose, Vaccination_date FROM `vaccine_records` WHERE patient_id = $patientId";
    $recordsResult = mysqli_query($conn, $fetchRecordsSql);

    if ($recordsResult !== false) {
        if ($recordsResult->num_rows > 0) {
            while ($row = $recordsResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['vaccine_name']}</td>
                        <td>{$row['dose']}</td>
                        <td>{$row['Vaccination_date']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No vaccine records found</td></tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Error fetching vaccine records: " . mysqli_error($conn) . "</td></tr>";
    }

    // Close the database connection
    $conn->close();
    ?>
</table>

        <!-- Download button -->
        <form method="post" action="">
            <button class="download-btn" type="submit" name="download_pdf">Download as PDF</button>
<br>
<br>
<br>
            <a href = "booking.php" target="blank" >Book Your Next Vaccine Here!!</a>
        </form>

    </div>

</body>

</html>
