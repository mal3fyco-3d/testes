<?php
//Numero de produtos mostrados na pagina
$num_products_on_each_page = 4;

$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;

$stmt = $pdo->prepare('SELECT * FROM Products ORDER BY created DESC LIMIT ?,?');
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Selecionar o numero total de produtos
$total_products = $pdo->query('SELECT * FROM Products')->rowCount();
?>

<div class="products content-wrapper">
    <h1>Figures for All</h1>
    <p>Total de <?=$total_products?> figuras</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>

        <a href="?m=product&a=productdet&id=<?=$product['id']?>" class="product">

            <img src="imgs/<?=$product['pictures']?>" width="200" height="200" alt="<?=$product['name']?>">
            <span class="name"><?=$product['name']?></span>
            <span class="price">
            <?=(100 - $product['discount_id']) * $product['price'] * 0.01?>&euro;
            </span>
            <span class="pricelined">
            <?php
            if ($product['price'] != ((100 - $product['discount_id']) * $product['price'] * 0.01))
            echo $product['price'],'€'?>
            </span>    
        </a>
        <?php endforeach; ?>
    </div>
     <div class="buttons">
        <?php if ($current_page > 1): ?>
        <a href="?m=product&a=products&p=<?=$current_page-1?>">Anterior</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
        <a href="?m=product&a=products&p=<?=$current_page+1?>">Proximo</a>
        <?php endif; ?>
     </div>
    </div>
</div>