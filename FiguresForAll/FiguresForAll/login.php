<?php
session_start();
if (isset($_SESSION['uid'])) {
    header('Location: index.php');
    exit();
}
define('DESC', 'Aplicação Web - Login');
$html = '';

require_once './config.php';
require_once './core.php';

$login = filter_input(INPUT_POST, 'login');
if ($login) {
    $pdo = connectDB($db);

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password_hash_db = password_hash($password, PASSWORD_DEFAULT);

    $errors = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $html .= '<div class="container alert-danger">O email não é válido.</div>';
        $errors = true;
    }

    if (!$errors) {
        $sql = "SELECT * FROM `User` WHERE `email` = :EMAIL LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() != 1) {
            $html .= '<div class="container alert-danger">O email indicado não se encontra registado.</div>';
            $errors = true;
        } else {
            $row = $stmt->fetch();
        }
    }

    if (!$errors) {
        if (!password_verify($password, $row['password'])) {
            $html .= '<div class="container alert-danger">Palavra-passe incorreta.</div>';
            sleep(random_int(1, 3));
        } else {
            $_SESSION['uid'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            $html .= '<div class="container alert-success">Login com sucesso! <br> <b>' . $_SESSION['username'] . '</b></div>';
            $html .= '<div class="container alert-success"><a href="index.php" class="btn btn-primary">Continuar</a></div>';
            header('Location: index.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= DESC . ' | ' . AUTHOR ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3><?= DESC ?></h3>
                    <form action="?" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Endereço de Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Palavra-Passe">
                        </div>
                        <input type="submit" class="btn btn-primary" name="login" value="Login">
                    </form>
                    <hr>
                    <a class="btn btn-secondary" href="register.php">Registar novo utilizador</a>                
                </div>
            </div>
            <div class="container"><?= $html ?></div>
        </div>
    </body>
</html>