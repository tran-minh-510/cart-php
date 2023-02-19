<?php
session_start();
if (isset($_SESSION['key-product-fix'])) {
    unset($_SESSION['key-product-fix']);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete-all'])) {
        unset($_SESSION['cart']);
    }
    if (isset($_POST['delete-product'])) {
        $arrKeyBtnDelete = array_keys($_POST['delete-product']);
        $keyBtnDelete = reset($arrKeyBtnDelete);
        unset($_SESSION['cart'][$keyBtnDelete]);
    }
    if (isset($_POST['fix-product'])) {
        $arrKeyBtnFix = array_keys($_POST['fix-product']);
        $keyBtnFix = reset($arrKeyBtnFix);
        $_SESSION['key-product-fix'] = $keyBtnFix;
    }
    if (isset($_POST['update-product'])) {
        $arrKeyBtnUpdate = array_keys($_POST['update-product']);
        $keyBtnUpdate = reset($arrKeyBtnUpdate);
        $_SESSION['cart'][$keyBtnUpdate]['amount'] = $_POST['product-update'];
        unset($_SESSION['key-product-fix']);
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
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="container">
        <div class="cart-wrapper">
            <form action="" method="post">
                <table id="customers">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá/sp</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Lựa chọn</th>
                    </tr>
                    <?php
                    if (!empty($_SESSION['cart'])) :
                        $stt = 0;
                        $sum = 0;
                        foreach ($_SESSION['cart'] as $key => $product) :
                            $sum += ($product['price'] * $product['amount']);
                    ?>
                            <tr>
                                <td><?php echo ++$stt ?></td>
                                <td><?php echo $product['name'] ?></td>
                                <td><?php echo number_format($product['price']) . " vnđ" ?></td>
                                <td>
                                    <?php if (isset($_SESSION['key-product-fix']) && $_SESSION['key-product-fix'] === $key) : ?>
                                        <input type="number" name="product-update" value="<?php echo $product['amount'] ?>" />
                                    <?php else : echo $product['amount'];
                                    endif; ?>

                                </td>
                                <td><?php echo number_format($product['price'] * $product['amount']) . " vnđ" ?></td>
                                <td>

                                    <?php if (isset($_SESSION['key-product-fix']) && $_SESSION['key-product-fix'] === $key) {
                                        echo "<button type='submit' class='btn btn-primary' name=update-product[" . $key . "]>Cập nhật</button>";
                                    } else {
                                        echo "<button type='submit' class='btn btn-primary' name=fix-product[" . $key . "]>Sửa</button>";
                                    } ?>
                                    <button type="submit" class="btn btn-danger" name="delete-product[<?php echo $key ?>]">Xóa</button>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                        <tr>
                            <th colspan="4">Tổng</th>
                            <th colspan="2"><?php echo number_format($sum) . " vnđ" ?></th>
                        </tr>
                    <?php
                    endif;
                    ?>
                </table>
                <?php
                if (empty($_SESSION['cart'])) :
                ?>
                    <div class="alert alert-danger" role="alert">
                        Giỏ hàng trống! Vui lòng <a href="../index.php">bấm vào đây</a> để quay lại mua hàng ^^
                    </div>
                <?php
                endif;
                ?>
                <div class="cart-options mt-2">
                    <a href="../index.php" class="btn btn-primary" name="delete-cart" name="">Quay về trang chủ</a>
                    <button type="submit" class="btn btn-danger" name="delete-all">Xóa toàn bộ giỏ hàng</button>
                </div>
            </form>
        </div>
</body>

</html>