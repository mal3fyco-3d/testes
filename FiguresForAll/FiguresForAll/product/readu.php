<?php
//Este ficheiro serve para ver todos os utilizadores quando estamos a utilizar o utilizador admin na pagina Users


if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}

// Carregar e Instanciar Classe
require_once './objects/Product.php';
$user = new User($pdo);

$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Utilizadores | Eliminar utilizadores</h3>';


//echo "LISTAR";
$html .= '<table class="table table-striped">';
$html .= '<thead><tr><th>Username</th><th>Email</th><th>ID</th><th>Operações</th><tr><thead>';

// Obter Produtos e número de registos
$stmt = $user->readu();
$num = $stmt->rowCount();
if ($num > 0) {
    // Obter conteúdos
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $html .= '
            <tr>
                <td>' . $row['username'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['id'] . '</td>
                <td>
                    <a href="?m=' . $module . '&a=Deleteu&id=' . $row['id'] . '">del</a>
                </td>
            </tr>';
    }
} else {
    $html .= '<tr><td colspan="12">Sem registos</td></tr>';
}


$html .= '</tbody></table>';

echo $html;