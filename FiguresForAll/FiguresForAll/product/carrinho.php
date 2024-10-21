<?php
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    $stmt = $pdo->prepare('SELECT * FROM Products WHERE id = ?');
    $stmt->execute([$_POST['product_id']]);
    
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product && $quantity > 0) {
        
        if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
            if (array_key_exists($product_id, $_SESSION['carrinho'])) {
                
                $_SESSION['carrinho'][$product_id] += $quantity;
            } else {
                
                $_SESSION['carrinho'][$product_id] = $quantity;
            }
        } else {
           
            $_SESSION['carrinho'] = array($product_id => $quantity);
        }
    }
    
    header('location: ?m=product&a=carrinho');
    exit;
}

//retirar produtos do carrinho
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['carrinho']) && isset($_SESSION['carrinho'][$_GET['remove']])) {
   
    unset($_SESSION['carrinho'][$_GET['remove']]);
}

//atualizar a quantidade
if (isset($_POST['update']) && isset($_SESSION['carrinho'])) {

    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
           
            if (is_numeric($id) && isset($_SESSION['carrinho'][$id]) && $quantity > 0) {
                
                $_SESSION['carrinho'][$id] = $quantity;
            }
        }
    }
 
    header('location: ?m=product&a=carrinho');
    exit;
}


if (isset($_POST['placeorder']) && isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {

    header('location: ?m=product&a=placeorder');
    exit;
}

$products_in_cart = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : array();
$products = array();
$subtotal = 0.00;

if ($products_in_cart) {
    
    $arraysmt = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM Products WHERE id IN (' . $arraysmt . ')');
    $stmt->execute(array_keys($products_in_cart));
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $product) {
        $subtotal += (float)(100 - $product['discount_id']) * $product['price'] * 0.01 * (int)$products_in_cart[$product['id']];
    }
    $_SESSION['subtotal'] = $subtotal;
}
?>



<div class="cart content-wrapper">
    <h1>Carrinho</h1>
    <form action="?m=product&a=carrinho" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Produto</td>
                    <td>Preço</td>
                    <td>Quantidade</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Sem produtos no carrinho</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="?m=product&a=productdet&id=<?=$product['id']?>">
                            <img src="imgs/<?=$product['pictures']?>" width="50" height="50" alt="<?=$product['name']?>">
                        </a>
                    </td>
                    <td>
                        <a><?=$product['name']?></a>
                        <br>
                        <a href="?m=product&a=carrinho&remove=<?=$product['id']?>" class="remove">Remover</a>
                    </td>
                    <td class="price"><?=(100 - $product['discount_id']) * $product['price'] * 0.01?>&euro;</td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" min="1" placeholder="Quantity" required>
                    </td>
                    <td class="price"><?=(100 - $product['discount_id']) * $product['price'] * 0.01 * $products_in_cart[$product['id']] ?>&euro;</td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price"><?=$subtotal?>&euro;</span>
        </div>
        <div class="buttons">
            <input type="submit" value="Atualizar" name="update">
            <input type="submit" value="Encomendar" name="placeorder">
        </div>
    </form>
</div>

