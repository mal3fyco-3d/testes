<?php
//Este ficheiro serve para criar produtos quando estamos a utilizar o utilizador admin na pagina Products


if(count(get_included_files()) ==1){ exit("Direct access not permitted."); }

// Carregar e Instanciar Classe
require_once './objects/Product.php';
$product = new Product($pdo);

$debug .= "<b>Loading</b>: $module/$action.php";
$html .='<h3>Produtos | Criar Produto</h3>';
$submit = filter_input(INPUT_POST, 'submit');
if ($submit) {
    $debug .= "<br><b>INSERT INTO DB</b>";
    // Verificar dados do formulário
    $name = filter_input(INPUT_POST,'NOME', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST,'DESC', FILTER_SANITIZE_STRING);
    $price = (float) filter_input(INPUT_POST,'PRECO',
    FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $category_name = filter_input(INPUT_POST, 'CATEGORIA', FILTER_SANITIZE_STRING);
    $discount_id = filter_input(INPUT_POST, 'DISCOUNT',FILTER_SANITIZE_NUMBER_INT);
    $pictures = filter_input(INPUT_POST, 'PICTURES');
    

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
        $html .= '<div class="alert-danger">Tem que definir uma categoria.</div>';
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
        $debug .= '<p>Informação válida proceder ao registo.</p>';
        $product->name = $name;
        $product->price = $price;
        $product->description = $description;
        $product->category_name = $category_name;
        $product->discount_id = $discount_id;
        $product->created = date('Y-m-d H:i:s');
        $product->pictures = $pictures;

        // Criar produto
        if ($product->create()) {
            $html .= 'Produto criado';
        }else {
            $html .= 'Não foi possível criar Produto';
        }
    }
} else {
    $debug .= "<br><b>SHOW FORM</b>";
    $html .= '                
    <form method="POST" action="?m=' . $module . '&a='.$action.'">
        <input class="form-control" type="text" size="2" placeholder="ID" name="ID" disabled><br>
        <input class="form-control" type="text" placeholder="Nome" name="NOME"><br>
        <input class="form-control" type="text" placeholder="Descrição" name="DESC"><br>
        <input class="form-control" type="text" placeholder="Preço" name="PRECO"><br>
        <input class="form-control" type="text" placeholder="Categoria" name="CATEGORIA"><br>
        <label for="discount_id">Desconto:</label>
            <select id="discount_id" name="DISCOUNT">
              <option value="100">Preço Base</option>
              <option value="15">Desconto de 15 %</option>
              <option value="20">Desconto de 20 %</option>
              <option value="50">Desconto de 50 %</option>
              <option value="60">Desconto de 60 %</option>
            </select><br> 
        <input class="form-control" type="text" placeholder="Foto" name="PICTURES"><br>
        <input type="submit" class="btn btn-primary" name="submit" value="Adicionar">
        <input type="reset" class="btn btn-secondary" value="Limpar">
    </form>
';
}
$html .= '<hr><p><a class="btn btn-secondary" href="?m='.$module.'&a=read">Voltar</a></p>';

echo $html;
