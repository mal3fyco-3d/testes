<?php
//Este ficheiro serve para mostrar todos os produtos quando estamos a utilizar o utilizador admin Products


if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}

// Carregar e Instanciar Classe
require_once './objects/Product.php';
$product = new Product($pdo);

$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Produtos | Listar Produtos</h3>';

$html .= '<div><a href="?m=' . $module . '&a=create" class="btn btn-primary">Novo</a></div>';

//echo "LISTAR";
$html .= '<table class="table table-striped">';
$html .= '<thead><tr><th>ID</th><th>Nome</th><th>Descrição</th>'
      . '<th>Preço</th><th>Desconto</th><th>Categoria</th><th>Criado</th><th>Modificado</th><th>Figuras</th><th>Operações</th></tr></thead><tbody>';
// Obter Produtos e número de registos
$stmt = $product->read();
$num = $stmt->rowCount();
if ($num > 0) {
    // Obter conteúdos
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $html .= '
            <tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['description'] . '</td>
                <td>' . $row['price'] . '</td>
                <td>' . $row['discount_id'] . '</td>
                <td>' . $row['category_name'] . '</td>
                <td>' . $row['created'] . '</td>
                <td>' . $row['modified'] . '</td>
                <td>' . $row['pictures'] . '</td>
                <td>
                    <a href="?m=' . $module . '&a=update&id=' . $row['id'] . '">edit</a> | 
                    <a href="?m=' . $module . '&a=delete&id=' . $row['id'] . '">del</a>
                </td>
            </tr>';
    }
} else {
    $html .= '<tr><td colspan="12">Sem registos</td></tr>';
}
$html .= '</tbody></table>';

echo $html;
