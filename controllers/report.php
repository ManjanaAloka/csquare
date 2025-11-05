<?php

error_reporting(0);
include '../controllers/conn.php';

$conn = connect();

// Set a default response
$response = ['success' => false, 'message' => 'Invalid action'];

// Get the requested action (e.g., 'get_customers', 'create_customer')
$action = $_REQUEST['action'] ?? null;
switch ($action) {
    // --- REPORT A: Invoice Report ---
    case 'report_invoice':
        $start_date = $_GET['start_date'] . " 00:00:00";
        $end_date = $_GET['end_date'] . " 23:59:59";

        $sql = "SELECT 
                    i.invoice_number, 
                    i.invoice_date, 
                    CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
                    d.district_name,
                    i.total_amount,
                    (SELECT COUNT(*) FROM invoice_item WHERE invoice_id = i.invoice_id) AS item_count
                FROM invoice i
                JOIN customer c ON i.customer_id = c.customer_id
                JOIN district d ON c.district_id = d.district_id
                WHERE i.invoice_date BETWEEN '$start_date' AND '$end_date'
                ORDER BY i.invoice_date DESC";

        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response = ['success' => true, 'data' => $data];
        break;

    // --- REPORT B: Invoice Item Report ---
    case 'report_invoice_item':
        $start_date = $_GET['start_date'] . " 00:00:00";
        $end_date = $_GET['end_date'] . " 23:59:59";

        $sql = "SELECT
                    i.invoice_number,
                    i.invoice_date,
                    CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
                    it.item_name,
                    it.item_code,
                    ic.category_name,
                    ii.unit_price AS item_unit_price
                FROM invoice_item ii
                JOIN invoice i ON ii.invoice_id = i.invoice_id
                JOIN customer c ON i.customer_id = c.customer_id
                JOIN item it ON ii.item_id = it.item_id
                JOIN item_category ic ON it.category_id = ic.category_id
                WHERE i.invoice_date BETWEEN '$start_date' AND '$end_date'
                ORDER BY i.invoice_date DESC, it.item_name";

        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response = ['success' => true, 'data' => $data];
        break;

    // --- REPORT C: Item Report (Stock) ---
    case 'report_item':
        $sql = "SELECT
                    i.item_name,
                    ic.category_name,
                    isc.sub_category_name,
                    i.quantity
                FROM item i
                JOIN item_category ic ON i.category_id = ic.category_id
                JOIN item_sub_category isc ON i.sub_category_id = isc.sub_category_id
                WHERE i.quantity > 0
                ORDER BY i.item_name";

        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $response = ['success' => true, 'data' => $data];
        break;
}
// --- Send Response ---

// Close the connection
$conn->close();
// Tell the browser this is JSON data
header('Content-Type: application/json');
// Output the response
echo json_encode($response);
