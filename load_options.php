<?php
include('database_connection.php');

// Number of records fetch
$numberofrecords = 10;

if (!isset($_POST['searchTerm'])) {

    // Fetch records
    $stmt = "SELECT * FROM options ORDER BY option_value";
//    $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
    $usersList = $connect->query($stmt);

} else {

    $search = $_POST['searchTerm'];// Search text

    // Fetch records
    $stmt      = "SELECT * FROM options WHERE option_value like '%" . $search . "%' ORDER BY option_value";
    $usersList = $connect->query($stmt);

}

$response = array();

// Read Data
foreach ($usersList as $user) {
    $response[] = array(
        "id"   => $user['id'],
        "text" => $user['option_value']
    );
}

echo json_encode($response);