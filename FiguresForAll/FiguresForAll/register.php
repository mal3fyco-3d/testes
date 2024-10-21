<?php
define('DESC', 'Figures For All - Registo');
$html = '';

require_once './config.php';
require_once './core.php';

// Verificar se o formulário foi submetido
$register = filter_input(INPUT_POST, 'register');
if ($register) {
    $pdo = connectDB($db);

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password_hash_db = password_hash($password, PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $errors = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $html .= '<div class="alert-danger">O email não é válido.</div>';
        $errors = true;
    }
    if ($username == '') {
        $html .= '<div class="alert-danger">Tem que definir um username.</div>';
        $errors = true;
    }
    if (strlen($password) < 8) {
        $html .= '<div class="alert-danger">Palavra-passe tem menos de 8 caracteres.</div>';
        $errors = true;
    }

    $sql = "SELECT id FROM User WHERE email = :EMAIL LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $html .= '<div class="alert-danger">O email indicado já se encontra registado.</div>';
        $errors = true;
    }

    if (!$errors) {
        $html .= '<p>Informação válida proceder ao registo.</p>';
        $sql = "INSERT INTO User(username,email,password) VALUES(:USERNAME,:EMAIL,:PASSWORD)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":USERNAME", $username, PDO::PARAM_STR);
        $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $stmt->bindValue(":PASSWORD", $password_hash_db, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $html .= '<div class="container alert-success">Utilizador criado com sucesso! ';
        } else {
            $html .= '<div class="container alert-danger">Erro ao inserir na Base de Dados.</div>';
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
            <h3><?= DESC ?></h3>
            <div>
                <form action="?" method="POST">
                    <div class="form-group">
                        <label for="email"></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Endereço de Email">
                    </div>
                    <div class="form-group">
                        <label for="username"></label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Nome de utilizador">
                    </div>
                    <div class="form-group">
                        <label for="password"></label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Palavra-Passe">
                        <p>A password tem de ter mais de 8 caracteres</p>
                    </div>
                    <input type="submit" class="btn btn-primary" name="register" value="Registar"><br><br>
                    <a class="btn btn-secondary" href="login.php" >Login</a>
                </form>
                <hr>
            </div>
            <div><?= $html ?></div>
        </div>
        
    </body>
</html>