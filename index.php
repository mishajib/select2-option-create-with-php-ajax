<?php

//index.php

include('database_connection.php');

$query = "
  SELECT * FROM options 
ORDER BY option_value ASC
";

$result = $connect->query($query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dynamically Add New Option in Select2 using Ajax in PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>

    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
          rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>
<body>
<div class="container">
    <br/>
    <br/>
    <h1 align="center">Dynamically Add New Option Tag in Select2 using Ajax in PHP</h1>
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <select name="category" id="category" class="form-control form-control-lg select2">
                <option value="">Select</option>
                <?php
                foreach ($result as $row) {
                    echo '<option value="' . $row['id'] . '">' . $row['option_value'] . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
</div>
</body>
</html>

<script>

    $(document).ready(function () {

        $('.select2').select2({
            placeholder : 'Select Category',
            theme       : 'bootstrap4',
            tags        : true,
            ajax        : {
                url            : "load_options.php",
                type           : "post",
                dataType       : 'json',
                delay          : 250,
                data           : function (params) {
                    return {
                        searchTerm : params.term // search term
                    };
                },
                processResults : function (response) {
                    return {
                        results : response
                    };
                },
                cache          : true
            },
        }).on('select2:close', function () {
            var element = $(this);
            var new_option = $.trim(element.val());

            if (new_option != '') {
                $.ajax({
                    url     : "add.php",
                    method  : "POST",
                    data    : {option_value : new_option},
                    success : function (data) {
                        let response = JSON.parse(data);
                        console.log(response);
                        if (response.success === true) {
                            element.append('<option value="' + response.data.id + '">' + response.data.option_value + '</option>').val(response.data.id);
                        }
                    }
                })
            }

        });

    });

</script>
