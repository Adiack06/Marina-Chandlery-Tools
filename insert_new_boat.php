<?php
require_once 'sql.php';

echo '<pre>';
	print_r($_POST);
echo '</pre>';
		
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $title = $_POST['title'];
    $firstName = $_POST['firstName'];
	$customerSurname = $_POST['customerSurname'];
    $address = $_POST['address'];
    $postcode = $_POST['postcode'];
	$email = $_POST['email'];
    $homePhone = $_POST['homePhone'];
    $mobilePhone = $_POST['mobilePhone'];
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
	$stmt = $conn->prepare("INSERT INTO `boat info` (Title, `Customer Surname`, `First name`, Address, Postcode, `Home Phone Number`, `Mobile Phone Number`, `Boat Name`, Type, Make, `Length (ft)`, `Length (mtrs)`, Notes, Email, `Home Port`, `Home Country`, `Mailing List`)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");

	if (!$stmt) {
		echo "Error during statement preparation: " . $conn->error;
	}

	// Bind the parameters to the statement
	$stmt->bind_param("ssssssssssddssssi", $title, $customerSurname, $firstName, $address, $postcode, $homePhone, $mobilePhone, $boatName, $type, $make, $lengthFt, $lengthMtrs, $notes, $email, $homePort, $homeCountry, $mailingList);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Boat registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
#header("Location: form.php");
?>