<?php

    // establish database connection
    $pdo = new PDO(
        'mysql:host=localhost; port=3306; dbname=file_upload',
        'root',
        ''
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_POST['id'] ?? null;

    if (!$id) {
        header('Location: index.php');
    } else {
        $statement = $pdo->prepare('DELETE FROM files where id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();

        header('Location: index.php');
    }