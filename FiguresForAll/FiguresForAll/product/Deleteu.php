<?php
//Este ficheiro serve para eliminar utilizadores quando estamos a utilizar o utilizador admin na pagina Users


if(count(get_included_files()) ==1){ exit("Direct access not permitted."); }

// Carregar e Instanciar Classe
require_once './objects/Product.php';
$user = new User($pdo);

$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Utilizadores | Eliminar Utilizadores</h3>';


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$submit = filter_input(INPUT_POST, 'submit');
$cancel = filter_input(INPUT_POST, 'cancel');
if ($cancel) {
    header('Location: index.php?m=' . $module . '&a=readu');
    exit();
}

if ($submit) {
    $id = filter_input(INPUT_POST,'ID', FILTER_SANITIZE_NUMBER_INT);
    $user->id = $id;
    // Eliminar produto
    if ($user->deleteU()) {
        $html .= 'Utilizador eliminado';        
    } else {
        $html .= 'Não foi possível eliminar Utilizador';
    }
} else {
    $debug .= "<br><b>SHOW FORM</b>";
    $user->id = $id;
    $user->readOneU();
    
    $html .= '                
    <div class="alert-danger">Deseja mesmo eliminar o usuario <b>' . $user->username .'</b>?</div>
    <form method="POST" action="?m=' . $module . '&a=' . $action . '">
        <input  class="form-control" type="hidden" readonly
                name="ID" value="'.$user->id . '"><br>
        <input type="submit" class="btn btn-primary" name="submit" value="Eliminar">
    </form>
';
}

$html .= '<hr><p><a class="btn btn-secondary" href="?m='.$module.'&a=readu">Voltar</a></p>';

echo $html;
