<?php

    // establish database connection
    $pdo = new PDO(
            'mysql:host=localhost; port=3306; dbname=file_upload',
        'root',
        ''
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // define errors
    $errors = [];

    // define field variables
    $filePath = '';
    $file = $_FILES['file'];
    $date = date('Y-m-d H:i:s');

    if (!is_dir('files')) {
        mkdir('files');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($file['tmp_name'])) {
            $errors[] = 'File cannot be empty';
        } else {
            $filePath = 'files/' .randomString(10). '/' .$file['name'];
            mkdir(dirname($filePath));
            move_uploaded_file($file['tmp_name'], $filePath);

            $statement = $pdo->prepare('INSERT INTO files (file, created_at) VALUES (:file, :date)');
            $statement->bindValue(':file', $filePath);
            $statement->bindValue(':date', $date);
            $statement->execute();
            header('Location: index.php');
        }
    }

    function randomString($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }

        return $str;
    }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css" >
    <title>Add File</title>
</head>
<body>
<h1>Upload File</h1>
<?php
    foreach($errors as $error) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
            <div>
                <?php echo $error?>
            </div>
        </div>
        <?php
    }
?>
<form action="" enctype="multipart/form-data" method="post">
    <div class="mb-3">
        <input type="file" name="file">

    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>
</html>