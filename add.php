<?php

//add.php

include('database_connection.php');


if (isset($_POST["option_value"])) {
    $option_value = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $_POST["option_value"]);

    $data = array(
        ':option_value' => $option_value
    );

    $query = "
	SELECT * FROM options 
	WHERE option_value = :option_value
	";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    if ($statement->rowCount() == 0) {
        $query = "
		INSERT INTO options 
		(option_value) 
		VALUES (:option_value)
		";

        $statement = $connect->prepare($query);

        $statement->execute($data);

        echo json_encode([
            'success' => true,
            'message' => 'Option created successfully.',
            'data'    => [
                'id'           => $connect->lastInsertId(),
                'option_value' => $option_value,
            ],
        ]);
    }
}
