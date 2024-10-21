<?php
// produtos mais recentes
$pdo = connectDB($db);
$stmt = $pdo->prepare('SELECT * FROM Products ORDER BY modified DESC LIMIT 4');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row" style="text-align: center;">
<img src="imgs/featured-image.jpg" width=100%>
</div>

<div class="featured">
 <h2 style>Figuras mais recentes</h2> 
</div>
<br>
<div class="recentlyadded content-wrapper">
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>   
        <a class="product <?=$module== 'home' ? 'active' : ''?>" href="?m=product&a=productdet&id=<?=$product['id']?>" class="product">
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
        


    