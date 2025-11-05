<?php
error_reporting(0);
include '../controllers/conn.php';

$conn = connect();

// Set a default response
$response = ['success' => false, 'message' => 'Invalid action'];

// Get the requested action (e.g., 'get_customers', 'create_customer')
$action = $_REQUEST['action'] ?? null;

switch ($action) {
    // --- READ: Get All Items ---
    case 'get_items':
        $sql = "SELECT i.*, c.category_name, sc.sub_category_name
                FROM item i
                JOIN item_category c ON i.category_id = c.category_id
                JOIN item_sub_category sc ON i.sub_category_id = sc.sub_category_id
                ORDER BY i.item_name";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response = ['success' => true, 'data' => $data];
        break;

    // --- READ: Get Item Categories (for dropdown) ---
    case 'get_categories':
        $sql = "SELECT * FROM item_category ORDER BY category_name";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response = ['success' => true, 'data' => $data];
        break;

    // --- READ: Get Sub-Categories (for dropdown) ---
    case 'get_sub_categories':
        $cat_id = $_GET['category_id'];
        $sql = "SELECT * FROM item_sub_category WHERE category_id = $cat_id ORDER BY sub_category_name";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response = ['success' => true, 'data' => $data];
        break;

    // --- READ: Get a Single Item (for editing) ---
    case 'get_item':
        $id = $_GET['id'];
        $sql = "SELECT * FROM item WHERE item_id = $id";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        $response = ['success' => true, 'data' => $data];
        break;

    // --- CREATE / UPDATE Item ---
    case 'save_item':
        $item_id = $_POST['item_id'];
        $item_code = $_POST['item_code'];
        $item_name = $_POST['item_name'];
        $category_id = $_POST['category_id'];
        $sub_category_id = $_POST['sub_category_id'];
        $quantity = $_POST['quantity'];
        $unit_price = $_POST['unit_price'];

        if (empty($item_id)) {
            // Create
            $sql = "INSERT INTO item (item_code, item_name, category_id, sub_category_id, quantity, unit_price)
                    VALUES ('$item_code', '$item_name', $category_id, $sub_category_id, $quantity, $unit_price)";
            $message = 'Item created successfully';
        } else {
            // Update
            $sql = "UPDATE item SET
                        item_code = '$item_code',
                        item_name = '$item_name',
                        category_id = $category_id,
                        sub_category_id = $sub_category_id,
                        quantity = $quantity,
                        unit_price = $unit_price
                    WHERE item_id = $item_id";
            $message = 'Item updated successfully';
        }

        if ($conn->query($sql) === TRUE) {
            $response = ['success' => true, 'message' => $message];
        } else {
            $response = ['success' => false, 'message' => 'Error: ' . $conn->error];
        }
        break;

    // --- DELETE Item ---
    case 'delete_item':
        $id = $_POST['id'];
        $sql = "DELETE FROM item WHERE item_id = $id";
        if ($conn->query($sql) === TRUE) {
            $response = ['success' => true, 'message' => 'Item deleted successfully'];
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