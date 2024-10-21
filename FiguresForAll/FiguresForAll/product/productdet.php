<?php

if (isset($_GET['id'])) {
    
    $stmt = $pdo->prepare('SELECT * FROM Products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        
        exit('Produto não existe!');
    }
} else {
    
    exit('Produto não existe!');
}

$pdo=NULL;
?>

<div class="product content-wrapper">
    <img src="imgs/<?=$product['pictures']?>" width="500" height="500" alt="<?=$product['name']?>">
    <div>
        <h1 class="name"><?=$product['name']?></h1>
        <span class="price">
            <?=(100 - $product['discount_id']) * $product['price'] * 0.01?>&euro;
            </span>
        <form action="?m=product&a=carrinho" method="POST">
            <input type="number" name="quantity" value="1" min="1" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['id']?>">
            <input type="submit" value="Adicionar ao carrinho">
        </form>
        <div class="description">
            <?=$product['description']?>
        </div>
    </div>
</div>

