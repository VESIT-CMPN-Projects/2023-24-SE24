<?php
// Assuming you have a connection to the database
$conn = mysqli_connect("localhost", "root", "", "signupform" , 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from the form
    $patientId = isset($_POST['patient_id']) ? $_POST['patient_id'] : null;
    $vaccineName = isset($_POST['vaccine_name']) ? $_POST['vaccine_name'] : null;
    $dose = isset($_POST['dose']) ? $_POST['dose'] : null;
    $vaccinationDate = isset($_POST['vaccination_date']) ? $_POST['vaccination_date'] : null;

    // Check if all required fields are provided
    if ($patientId !== null && $vaccineName !== null && $dose !== null && $vaccinationDate !== null) {
        // Check if the record already exists for the given patient and vaccine
        $checkRecordSql = "SELECT * FROM `vaccine_records` WHERE patient_id = $patientId AND vaccine_name = '$vaccineName'";
        $checkResult = mysqli_query($conn, $checkRecordSql);

        if ($checkResult->num_rows > 0) {
            // Update the existing vaccine record
            $updateSql = "UPDATE `vaccine_records` SET dose = '$dose', vaccination_date = '$vaccinationDate' WHERE patient_id = $patientId AND vaccine_name = '$vaccineName'";
            mysqli_query($conn, $updateSql);
        } else {
            // Insert a new vaccine record if it doesn't exist
            $insertSql = "INSERT INTO `vaccine_records` (patient_id, vaccine_name, dose, vaccination_date)
                          VALUES ($patientId, '$vaccineName', '$dose', '$vaccinationDate')";
            mysqli_query($conn, $insertSql);
        }

        // Redirect to doctor_home.php with the patient ID
        header("Location: update_vaccine.php?patient_id=$patientId");
        exit();
    } else {
        echo "Please provide all required fields";
    }
}

// Fetch and display all vaccine records for the patient
if (isset($_GET['patient_id'])) {
    $patientId = $_GET['patient_id'];
    $fetchRecordsSql = "SELECT * FROM `vaccine_records` WHERE patient_id = $patientId";
    $recordsResult = mysqli_query($conn, $fetchRecordsSql);

    if ($recordsResult !== false) {
        if ($recordsResult->num_rows > 0) {
            echo "<h3>Vaccine Records for Patient ID: $patientId</h3>";
            echo "<table border='1'>
                    <tr>
                        <th>Vaccine Name</th>
                        <th>Dose</th>
                        <th>Vaccination Date</th>
                    </tr>";

            while ($row = $recordsResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['vaccine_name']}</td>
                        <td>{$row['dose']}</td>
                        <td>{$row['vaccination_date']}</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No vaccine records found for Patient ID: $patientId";
        }
    } else {
        echo "Error fetching vaccine records: " . mysqli_error($conn);
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vaccine</title>
    <!-- Add your CSS styles or link to an external stylesheet here -->
    <style>
        /* Add your custom styles here */
        /* For example, you can style form elements or provide some layout */
        html {
    /* Add your custom styles for the html element here */
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f5f5f5;
    padding: 20px;
    background-color: #16a085;
    background-image: url('pngtree-health-medical-hospital-medicine-blue-banner-advertisement-image_177364.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    height: 100vh;
}

form {
    max-width: 500px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.1);
}

input {
    width: 500px;
    padding: 10px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

button {
    background-color: blue;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

a {
    text-decoration: none;
    color: black;
    font-weight: bold;
}

h2 {
    align-self: center;
    margin-bottom: 20px;
}

table {
    align-self: flex-start;
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    width: 400px;
    border: 10px solid var(black);
    padding: 5px;
    text-align: left;
    margin-bottom: 15px;
}

th {
    background-color: var(--green);
    color: white;
}


    </style>
</head>
<body>

    <h2>Update Vaccine Information</h2>
    <form action="update_vaccine.php" method="post">
        <label for="patient_id">Patient ID:</label>
        <input type="text" id="patient_id" name="patient_id" required>

        <label for="vaccine_name">Vaccine Name:</label>
        <input type="text" id="vaccine_name" name="vaccine_name" required>

        <label for="dose">Dose:</label>
        <input type="text" id="dose" name="dose" required>

        <label for="vaccination_date">Vaccination Date:</label>
        <input type="date" id="vaccination_date" name="vaccination_date" required>

        <button type="submit">Update</button>
    </form>

    <!-- Add a link to view all vaccine records -->
    <!-- <p>View all vaccine records for a patient: <a href="update_vaccine.php?patient_id=<?php echo $patientId; ?>">Click here</a></p> -->
    <p>Go Back to Doctor Homepage: <a href="http://localhost/js/dr_homepage.php">CLICK HERE</a></p>

</body>
</html>
