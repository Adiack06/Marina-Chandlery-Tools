<?php
require_once 'sql.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $title = $_POST['title'];
    $chartercompany = $_POST['chartercompany'];
    $boatName = $_POST['boatName'];
    $type = $_POST['type'];
    $make = $_POST['make'];
    $lengthFt = $_POST['lengthFt'];
    $lengthMtrs = $_POST['lengthMtrs'];
    $notes = $_POST['notes'];
    $homePort = $_POST['homePort'];
    $homeCountry = $_POST['homeCountry'];
    $mailingList = isset($_POST['mailingList']) ? 1 : 0;

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO `boat info` (Title, `charter company`, `Boat Name`, Type, Make, `Length (ft)`, `Length (mtrs)`, Notes, `Home Port`, `Home Country`, `Mailing List`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo "Error during statement preparation: " . $conn->error;
    }

    // Bind the parameters to the statement
    $stmt->bind_param("sssssddsssi", $title, $chartercompany, $boatName, $type, $make, $lengthFt, $lengthMtrs, $notes, $homePort, $homeCountry, $mailingList);

    // Execute the statement
    if ($stmt->execute()) {
		echo 
        $boatId = $stmt->insert_id; // Get the auto-incremented boat ID

        echo "Boat registration successful! Boat ID: " . $boatId;

        // Create a new entry in the 'dates' table
        $firstName = $_POST['firstName'];
        $customerSurname = $_POST['customerSurname'];
        $email = $_POST['email'];
        $notes = "Name: " . $firstName . " " . $customerSurname . ", Email: " . $email;

        $datesStmt = $conn->prepare("INSERT INTO `dates` (Note, ID) VALUES (?, ?)");

        $datesStmt->bind_param("si", $notes, $boatId);
        if ($datesStmt->execute()) {
            echo "Dates entry created successfully!";
        } else {
            echo "Error creating Dates entry: " . $datesStmt->error;
        }
        $datesStmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
