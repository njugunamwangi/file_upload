<?php

    // establish database connection
    $pdo = new PDO(
            'mysql:host=localhost; port=3306; dbname=file_upload',
        'root',
        ''
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $pdo->prepare('SELECT * FROM files ORDER BY created_at DESC');
    $statement->execute();
    $files = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">

    <title>File Upload</title>
</head>
<body>
<h1>Upload File</h1>
<p>
    <a href="create.php">
        <button type="button" class="btn btn-success">Add File</button>
    </a>
</p>
<?php
    if (empty($files)) {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Holy molly!</strong> No files found,Try creating some
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    } else {
        ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($files as $i => $file) {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $i + 1?>
                        </th>
                        <td>
                            <img src="<?php echo $file['file']?>" class="thumbnail">
                        </td>
                        <td><?php echo $file['created_at'] ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-primary">Edit</button>
                            <button type="button" class="btn btn-outline-danger">Delete</button>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
        <?php
    }
?>

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