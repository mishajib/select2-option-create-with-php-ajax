<?php
include('database_connection.php');

// Number of records fetch
$numberofrecords = 10;

if (!isset($_POST['searchTerm'])) {

    // Fetch records
    $stmt = $connect->prepare("SELECT * FROM options ORDER BY option_value");
//    $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
    $stmt->execute();
    $usersList = $stmt->fetchAll();

} else {

    $search = $_POST['searchTerm'];// Search text

    // Fetch records
    $stmt = $connect->prepare("SELECT * FROM options WHERE option_value like :option_value ORDER BY option_value");
    $stmt->bindValue(':option_value', '%' . $search . '%', PDO::PARAM_STR);
//    $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
    $stmt->execute();
    $usersList = $stmt->fetchAll();

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
exit();