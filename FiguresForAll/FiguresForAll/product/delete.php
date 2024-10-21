<?php
//Este ficheiro serve para criar produtos quando estamos a utilizar o utilizador admin na pagina Products e clicamos no botal del


if(count(get_included_files()) ==1){ exit("Direct access not permitted."); }

// Carregar e Instanciar Classe
require_once './objects/Product.php';
$product = new Product($pdo);

$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Produtos | Eliminar Produto</h3>';


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$submit = filter_input(INPUT_POST, 'submit');
$cancel = filter_input(INPUT_POST, 'cancel');
if ($cancel) {
    header('Location: index.php?m=' . $module . '&a=read');
    exit();
}

if ($submit) {
    $id = filter_input(INPUT_POST,'ID', FILTER_SANITIZE_NUMBER_INT);
    $product->id = $id;
    // Eliminar produto
    if ($product->delete()) {
        $html .= 'Produto eliminado';        
    } else {
        $html .= 'Não foi possível eliminar Produto';
    }
} else {
    $debug .= "<br><b>SHOW FORM</b>";
    $product->id = $id;
    $product->readOne();
    
    $html .= '                
    <div class="alert-danger">Deseja mesmo eliminar o produto <b>' . $product->name .'</b>?</div>
    <form method="POST" action="?m=' . $module . '&a=' . $action . '">
        <input  class="form-control" type="hidden" readonly
                name="ID" value="'.$product->id . '"><br>
        <input type="submit" class="btn btn-primary" name="submit" value="Eliminar">
    </form>
';
}

$html .= '<hr><p><a class="btn btn-secondary" href="?m='.$module.'&a=read">Voltar</a></p>';

echo $html;
