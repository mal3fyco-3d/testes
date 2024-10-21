<?php
//Este ficheiro serve para eliminar pedidos quando estamos a utilizar o utilizador admin na pagina Orders


if(count(get_included_files()) ==1){ exit("Direct access not permitted."); }

// Carregar e Instanciar Classe
require_once './objects/Product.php';
$order = new Order($pdo);

$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Pedidos | Eliminar Pedido</h3>';


$order_id = filter_input(INPUT_GET, 'order_id', FILTER_SANITIZE_NUMBER_INT);
$submit = filter_input(INPUT_POST, 'submit');
$cancel = filter_input(INPUT_POST, 'cancel');
if ($cancel) {
    header('Location: index.php?m=' . $module . '&a=readO');
    exit();
}

if ($submit) {
    $order_id = filter_input(INPUT_POST,'ID', FILTER_SANITIZE_NUMBER_INT);
    $order->order_id = $order_id;
    // Eliminar produto
    if ($order->deleteO()) {
        $html .= 'Pedido eliminado';        
    } else {
        $html .= 'Não foi possível eliminar Pedido';
    }
} else {
    $debug .= "<br><b>SHOW FORM</b>";
    $order->order_id = $order_id;
    $order->readOneO();
    
    $html .= '                
    <div class="alert-danger">Deseja mesmo eliminar a Order <b>' . $order->order_id .'</b>?</div>
    <form method="POST" action="?m=' . $module . '&a=' . $action . '">
        <input  class="form-control" type="hidden" readonly
                name="ID" value="'.$order->order_id . '"><br>
        <input type="submit" class="btn btn-primary" name="submit" value="Eliminar">
    </form>
';
}

$html .= '<hr><p><a class="btn btn-secondary" href="?m='.$module.'&a=readO">Voltar</a></p>';

echo $html;
