<?php
session_start();

define('DESC', 'Aplicação Web');
$html = '';
$debug = '';
require_once './config.php';
require_once './core.php';
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : 'Login';
// Carregar módulo ativo
$module = filter_input(INPUT_GET, 'm' , FILTER_SANITIZE_STRING);

// Carregar ação
$action = filter_input(INPUT_GET, 'a' , FILTER_SANITIZE_STRING);

// Testar se existe ficheiro a carregar. caso contrário carregar HOME
if (!file_exists("./$module/$action.php")){
    $module = 'home';
    
}else{
    // Ligar à base de dados
    $pdo = connectDB($db);
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= DESC . ' | ' . AUTHOR ?></title>

        <meta name="description" content="<?= DESC ?>">
        <meta name="author" content="<?= AUTHOR ?>">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

    </head>
    <body>
        <link href="css/style.css" rel="stylesheet">
        <div class="container container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link <?=$module== 'home' ? 'active' : ''?>" href="?m=product&a=RecentFigures">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" <?=$module== 'product' ? 'active' : ''?> href="?m=product&a=products">Todos os produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" <?=$module== 'product' ? 'active' : ''?> href="?m=product&a=discount">Produtos com desconto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" <?=$module== 'product' ? 'active' : ''?> href="?m=product&a=readUSERO">As minhas encomendas</a>
                        </li>
                        <?= is_admin() ? '
                        <li class="nav-item">
                            <a class="nav-link '.($module=='user' ? 'active' : '') .
                             '" href="?m=product&a=read">Products</a>
                        </li>' : ''
                        ?>
                        <?= is_admin() ? '
                        <li class="nav-item">
                            <a class="nav-link '.($module=='user' ? 'active' : '') .
                             '" href="?m=product&a=readu">Users</a>
                        </li>' : ''
                        ?>
                        <?= is_admin() ? '
                        <li class="nav-item">
                            <a class="nav-link '.($module=='user' ? 'active' : '') .
                             '" href="?m=product&a=readO">Orders</a>
                        </li>' : ''
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" <?=$module== 'product' ? 'active' : ''?> href="?m=product&a=carrinho">Carrinho</a>
                        </li>
                        <li class="nav-item dropdown ml-md-auto">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                                <img src="avatar.png" width="30" alt="avatar"> <?echo $usuario?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="login.php">Iniciar Sessão</a>
                                <a class="dropdown-item" href="logout.php">Terminar Sessão</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <header><h2>Figures For all</h2></header>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    // Requerer módulo e ação
                    if($module!='home'){
                        require_once"./$module/$action.php";
                    }else{
                        require_once"./product/RecentFigures.php";
                    }
                    ?>
                </div>

                <script src="js/jquery.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/scripts.js"></script>
    </body>
</html>





