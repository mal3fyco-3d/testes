<?php
//Este ficheiro serve para ver todos os pedidos quando estamos a utilizar o utilizador admin na pagina Orders


if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}

// Carregar e Instanciar Classe
require_once './objects/Product.php';
$order= new Order($pdo);

$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Pedidos | Listar Pedidos</h3>';

//echo "LISTAR";
$html .= '<table class="table table-striped">';
$html .= '<thead><tr><th>ID</th><th>Username</th><th>Total</th><th>Estado</th><th>Operações</th></tr></thead><tbody>';
// Obter Produtos e número de registos
$stmt = $order->readO();
$num = $stmt->rowCount();
if ($num > 0) {
    // Obter conteúdos
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $html .= '
            <tr>
                <td>' . $row['order_id'] . '</td>
                <td>' . $row['username'] . '</td>
                <td>' . $row['total'] . '€' . '</td>
                <td>' . $row['state'] . '</td>
                <td>
                    <a href="?m=' . $module . '&a=updateO&order_id=' . $row['order_id'] . '">edit</a> | 
                    <a href="?m=' . $module . '&a=deleteO&order_id=' . $row['order_id'] . '">del</a>
                </td>
            </tr>';
    }
} else {
    $html .= '<tr><td colspan="12">Sem registos</td></tr>';
}
$html .= '</tbody></table>';

echo $html;