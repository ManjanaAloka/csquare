<?php
error_reporting(0);
include '../controllers/conn.php';

$conn = connect();

// Set a default response
$response = ['success' => false, 'message' => 'Invalid action'];

// Get the requested action (e.g., 'get_customers', 'create_customer')
$action = $_REQUEST['action'] ?? null;


// --- Main Action Controller (Switch Statement) ---
switch ($action) {

    // --- READ: Get All Customers ---
    case 'get_customers':
        $sql = "SELECT c.*, d.district_name 
                FROM customer c 
                JOIN district d ON c.district_id = d.district_id
                ORDER BY c.first_name";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response = ['success' => true, 'data' => $data];
        break;

    // --- READ: Get All Districts (for the dropdown) ---
    case 'get_districts':
        $sql = "SELECT * FROM district ORDER BY district_name";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response = ['success' => true, 'data' => $data];
        break;

    // --- READ: Get a Single Customer (for editing) ---
    case 'get_customer':
        $id = $_GET['id'];
        $sql = "SELECT * FROM customer WHERE customer_id = $id";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        $response = ['success' => true, 'data' => $data];
        break;

    // --- CREATE / UPDATE ---
    case 'save_customer':
        // Get data from POST
        $title = $_POST['title'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $contact = $_POST['contact_number'];
        $district_id = $_POST['district_id'];
        $customer_id = $_POST['customer_id']; // This is the hidden ID

        // Check if it's an UPDATE or CREATE
        if (empty($customer_id)) {
            // --- CREATE ---
            $sql = "INSERT INTO customer (title, first_name, last_name, contact_number, district_id) 
                    VALUES ('$title', '$first_name', '$last_name', '$contact', $district_id)";
            $message = 'Customer created successfully';
        } else {
            // --- UPDATE ---
            $sql = "UPDATE customer SET 
                        title = '$title', 
                        first_name = '$first_name', 
                        last_name = '$last_name', 
                        contact_number = '$contact', 
                        district_id = $district_id 
                    WHERE customer_id = $customer_id";
            $message = 'Customer updated successfully';
        }

        if ($conn->query($sql) === TRUE) {
            $response = ['success' => true, 'message' => $message];
        } else {
            $response = ['success' => false, 'message' => 'Error: ' . $conn->error];
        }
        break;

    // --- DELETE ---
    case 'delete_customer':
        $id = $_POST['id'];
        $sql = "DELETE FROM customer WHERE customer_id = $id";
        if ($conn->query($sql) === TRUE) {
            $response = ['success' => true, 'message' => 'Customer deleted successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Error: ' . $conn->error];
        }
        break;
}

// --- Send Response ---

// Close the connection
$conn->close();
// Tell the browser this is JSON data
header('Content-Type: application/json');
// Output the response
echo json_encode($response);

?>