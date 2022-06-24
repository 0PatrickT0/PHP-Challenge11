<?php
require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);
?>
<html>

<head>
    <title>Page1</title>
    <meta charset="UTF-8">
    <style>
        form {
            margin: 0 auto;
            width: 400px;
            padding: 1em;
            border: 1px solid #CCC;
            border-radius: 1em;
        }

        form div+div {
            margin-top: 1em;
        }

        label {
            display: inline-block;
            width: 90px;
            text-align: right;
        }

        .button {
            padding-left: 90px;
        }

        button {
            margin-left: .5em;
        }
    </style>
</head>

<body>

    <?php
    $query = 'SELECT * FROM friend';
    $statement = $pdo->query($query);
    $friends = $statement->fetchAll();

    foreach ($friends as [$friendsId, $friendsFirstname, $friendsLastname]) {
        echo "$friendsFirstname ";
        echo "$friendsLastname <br>";
    }
    ?>
    <form action="" method="post">
        <div>
            <label for="firstname">Nom :</label>
            <input type="text" id="firstname" name="user_firstname" required>
        </div>
        <div>
            <label for="lastname">Prenom :</label>
            <input type="text" id="lastname" name="user_lastname" required>
        </div>
        <div class="button">
            <button type="submit" name="submit">Ajouter à la liste</button>
        </div>
    </form>
    <?php
    if (isset($_POST['submit'])) {
        /*$firstname = $_POST['user_firstname'];*/
        /*$lastname = $_POST['user_lastname'];*/
        /*$query = "INSERT INTO friend (firstname, lastname) VALUES ('$firstname', '$lastname')";*/
        /*$statement = $pdo->exec($query);*/
        $firstname = trim($_POST['user_firstname']);
        $lastname = trim($_POST['user_lastname']);

        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

        $statement->execute();

        $friends = $statement->fetchAll();
    }
    ?>
</body>

</html>