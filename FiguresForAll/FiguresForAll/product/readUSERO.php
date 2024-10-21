<?php
//Este ficheiro serve para ver as encomendas do utilizador, qualquer utilizador pode aceder a esta pagina para ver as suas encomendas.
//Para entrar nesta pagina é necessario fazer log in, e caso o utilizador não o tenha feito é redireçionado para a pagina login.php


if (!isset($_SESSION['uid'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
// Carregar e Instanciar Classe
require_once './objects/Product.php';
$usuarioO = $_SESSION['username'];
$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Pedidos | As minhas encomendas</h3>';
$html .= '<table class="table table-striped">';
$html .= '<thead><tr><th>ID</th><th>Username</th><th>Total</th><th>Estado</th></tr></thead><tbody>';
$stmt = $pdo->prepare("SELECT * FROM Orders WHERE  username = '$usuarioO'");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="recentlyadded content-wrapper">
    <div class="Orders">
         <?php
         foreach ($orders as $orders): 
         ?>
         <?php
         $html.='
         <tr>
         <td>' . $orders['order_id'] . '</td>
         <td>' . $orders['username'] . '</td>
         <td>' . $orders['total'] . '€' . '</td>
         <td>' . $orders['state'] . '</td>
         <td>
         </td>
     </tr>';
        ?>
        <?php endforeach; ?>
    </div>   
</div>
<?
$html .= '</tbody></table>';
echo $html;