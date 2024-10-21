<?php
//Este ficheiro serve para atualizar encomendas quando estamos a utilizar o utilizador admin na pagina Orders


if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}

// Carregar e Instanciar Classe
require_once './objects/Product.php';
$order = new Order($pdo);

$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Pedidos | Editar Pedidos</h3>';

$order_id = filter_input(INPUT_GET, 'order_id', FILTER_SANITIZE_NUMBER_INT);
$submit = filter_input(INPUT_POST, 'submit');
$cancel = filter_input(INPUT_POST, 'cancel');
if ($cancel) {
    header('Location: index.php?m=' . $module . '&a=readO');
    exit();
}

if ($submit) {
    $debug .= "<br><b>UPDATE DB</b>";
    // Verificar dados do formulário
    $order_id = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_NUMBER_INT);
    $username = filter_input(INPUT_POST, 'USERNAME', FILTER_SANITIZE_STRING);
    $total = filter_input(INPUT_POST, 'TOTAL', FILTER_SANITIZE_NUMBER_FLOAT);
    $state = filter_input(INPUT_POST, 'STATE', FILTER_SANITIZE_STRING);


    $errors = false;
    if ($username == '') {
        $html .= '<div class="alert-danger">Tem que definir um username.</div>';
        $errors = true;
    }
    if ($total == '') {
        $html .= '<div class="alert-danger">Tem que definir um total.</div>';
        $errors = true;
    }
    if ($state == '') {
        $html .= '<div class="alert-danger">Tem que definir um state.</div>';
        $errors = true;
    }
  
    if (!$errors) {
        $debug .= '<p>Informação válida proceder à atualização.</p>';
        $order->order_id = $order_id;
        $order->username = $username;
        $order->total = $total;
        $order->state = $state;
        // Atualizar produto
        if ($order->updateO()) {
            $html .= 'Pedido atualizado';
        } else {
            $html .= 'Não foi possível atualizar Pedido';
        }
    }
} else {
    $debug .= " <b>SHOW FORM</b>";
    $order->order_id = $order_id;
    $order->readOneO();
    $html .= '                
    <form method="POST" action="?m=' . $module . '&a=' . $action . '">
        <input  class="form-control" type="text" size="2" placeholder="ID" readonly 
            name="ID" value="'.$order->order_id.'"><br>
        <input  class="form-control" type="text" placeholder="Username" readonly
            name="USERNAME" value="'.$order->username.'"><br>
        <input  class="form-control" type="text" placeholder="Total" readonly
            name="TOTAL" value="'.$order->total.'"><br>
            <label for="state">Estado:</label>
            <select id="STATE" name="STATE">
              <option value="Start">Processando</option>
              <option value="Sent">A entregar</option>
              <option value="Finished">Entregue</option>
            </select><br> 
        <input type="submit" class="btn btn-primary" name="submit" value="Atualizar">
        
    </form>
';
}


$html .= '<hr><p><a class="btn btn-secondary" href="?m='.$module.'&a=readO">Voltar</a></p>';
echo $html;
