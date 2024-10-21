<?php
//Este ficheiro serve para atualizar produtos quando estamos a utilizar o utilizador admin na pagina Products


if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}

// Carregar e Instanciar Classe
require_once './objects/Product.php';
$product = new Product($pdo);

$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Produtos | Editar Produto</h3>';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$submit = filter_input(INPUT_POST, 'submit');
$cancel = filter_input(INPUT_POST, 'cancel');
if ($cancel) {
    header('Location: index.php?m=' . $module . '&a=read');
    exit();
}

if ($submit) {
    $debug .= "<br><b>UPDATE DB</b>";
    // Verificar dados do formulário
    $id = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'NOME', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'DESC', FILTER_SANITIZE_STRING);
    $price = (float) filter_input(INPUT_POST, 'PRECO',
                    FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $category_name = filter_input(INPUT_POST, 'CATEGORIA', FILTER_SANITIZE_STRING);
    $discount_id = filter_input(INPUT_POST, 'DISCOUNT', FILTER_SANITIZE_NUMBER_INT);
    $created = filter_input(INPUT_POST, 'CREATED', FILTER_SANITIZE_STRING);
    $pictures = filter_input(INPUT_POST, 'PICTURES', FILTER_SANITIZE_STRING);

    $errors = false;
    if ($name == '') {
        $html .= '<div class="alert-danger">Tem que definir um nome.</div>';
        $errors = true;
    }
    if ($description == '') {
        $html .= '<div class="alert-danger">Tem que definir uma descrição.</div>';
        $errors = true;
    }
    if ($price == '') {
        $html .= '<div class="alert-danger">Tem que definir um preço.</div>';
        $errors = true;
    }
    if ($category_name == '') {
        $html .= '<div class="alert-danger">Tem que definir um nome de categoria.</div>';
        $errors = true;
    }
    if ($discount_id == '') {
        $html .= '<div class="alert-danger">Tem que definir um desconto.</div>';
        $errors = true;
    }
    if ($pictures == '') {
        $html .= '<div class="alert-danger">Tem que definir uma foto.</div>';
        $errors = true;
    }
    if (!$errors) {
        $debug .= '<p>Informação válida proceder à atualização.</p>';
        $product->id = $id;
        $product->name = $name;
        $product->price = $price;
        $product->description = $description;
        $product->category_name = $category_name;
        $product->discount_id = $discount_id;
        $product->created = $created;
        $product->modified = date('Y-m-d H:i:s');
        $product->pictures = $pictures;
        // Atualizar produto
        if ($product->update()) {
            $html .= 'Produto atualizado';
        } else {
            $html .= 'Não foi possível atualizar Produto';
        }
    }
} else {
    $debug .= " <b>SHOW FORM</b>";
    $product->id = $id;
    $product->readOne();
    $html .= '                
    <form method="POST" action="?m=' . $module . '&a=' . $action . '">
        <input  class="form-control" type="text" size="2" placeholder="ID" readonly 
            name="ID" value="'.$product->id.'"><br>
        <input  class="form-control" type="text" placeholder="Nome"
            name="NOME" value="'.$product->name.'"><br>
        <input  class="form-control" type="text" placeholder="Descrição" 
            name="DESC" value="'.$product->description.'"><br>
        <input  class="form-control" type="text" placeholder="Preço" 
            name="PRECO" value="'.$product->price.'"><br>
        <input  class="form-control" type="text" placeholder="Categoria" 
            name="CATEGORIA" value="'.$product->category_name.'"><br>           
            <label for="discount_id">Desconto:</label>
            <select id="discount_id" name="DISCOUNT">
              <option value="100">Preço Base</option>
              <option value="15">Desconto de 15 %</option>
              <option value="20">Desconto de 20 %</option>
              <option value="50">Desconto de 50 %</option>
              <option value="60">Desconto de 60 %</option>
            </select><br> 
        <input  class="form-control" type="text" placeholder="Data de Criação" readonly 
            name="CREATED" value="'.$product->created.'"><br>
            <input  class="form-control" type="text" placeholder="Foto" 
            name="PICTURES" value="'.$product->pictures.'"><br>
        <input type="submit" class="btn btn-primary" name="submit" value="Atualizar">
        
    </form>
';
}


$html .= '<hr><p><a class="btn btn-secondary" href="?m='.$module.'&a=read">Voltar</a></p>';
echo $html;
