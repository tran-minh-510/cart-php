<?php
session_start();
require_once './container/list-product.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arrKeyBtn = array_keys($_POST['btn']);
    $btnClick = reset($arrKeyBtn);
    if (empty($_SESSION['cart'])) {
        $product = [
            'id' => $listProduct[$btnClick]['id'],
            'name' => $listProduct[$btnClick]['name'],
            'amount' => $_POST['amount'][$btnClick],
            'price' => $listProduct[$btnClick]['price'],
        ];
        $_SESSION['cart'][] = $product;
    } else {
        $arrID = array_map(fn ($product) => $product['id'], $_SESSION['cart']);
        if (in_array($listProduct[$btnClick]['id'], $arrID)) {
            foreach ($arrID as $key => $id) {
                if ($id === $listProduct[$btnClick]['id']) {
                    $_SESSION['cart'][$key]['amount'] += $_POST['amount'][$btnClick];
                    break;
                }
            }
        } else {
            $product = [
                'id' => $listProduct[$btnClick]['id'],
                'name' => $listProduct[$btnClick]['name'],
                'amount' => $_POST['amount'][$btnClick],
                'price' => $listProduct[$btnClick]['price'],
            ];
            $_SESSION['cart'][] = $product;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="container">
        <div class="cart-wrapper">
            <form action="" method="post">
                <table id="customers">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Mua hàng</th>
                    </tr>
                    <?php
                    $stt = 0;
                    foreach ($listProduct as $key => $product) :
                    ?>
                        <tr>
                            <td><?php echo ++$stt ?></td>
                            <td><?php echo $product['name'] ?></td>
                            <td><?php echo number_format($product['price']) . " vnđ" ?></td>
                            <td><input type="number" name="amount[]" min="1" value="1" /></td>
                            <td><button type="submit" name="btn[<?php echo $key ?>]" class="btn btn-primary">Thêm vào giỏ hàng</button></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </table>
            </form>
            <div class="go-to-cart mt-2">
                <a class="btn btn-primary" href="./cart-product/cart.php" role="button">Đi tới giỏ hàng</a>
            </div>
        </div>
    </div>
</body>

</html>