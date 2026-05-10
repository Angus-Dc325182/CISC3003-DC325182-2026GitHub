<?php
include 'data.inc.php';      // 老師提供的數據
include 'functions.inc.php'; // 你寫的 Row 函數
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CISC3003 Practice 09</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- MDL 核心資源 (必需，否則冇 Card 同 Drawer 效果) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue_grey-orange.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    
    <!-- 你原本的 CSS (路徑: css/styles-sol.css) -->
    <link rel="stylesheet" href="css/styles-sol.css"> 
</head>
<body>

<!-- MDL 佈局容器：必需有 mdl-js-layout 同 fixed-drawer -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    
    <!-- 引入 Header -->
    <?php include 'header.inc.php'; ?>

    <!-- 側邊欄 (Drawer) -->
    <div class="mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <?php include 'left.inc.php'; ?>
    </div>

    <!-- 主要內容區 -->
    <main class="mdl-layout__content mdl-color--grey-100">
        <div class="page-content" style="padding: 20px;">
            
            <!-- 標題 -->
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">
                    <h4 style="margin:0; font-weight:300;">Order Summaries</h4>
                    <p style="color:#757575;">Examine your customer orders</p>
                </div>
            </div>

            <!-- 排版 Grid -->
            <div class="mdl-grid">
                
                <!-- 左欄：My Orders (使用循環) -->
                <div class="mdl-cell mdl-cell--3-col">
                    <div class="mdl-card mdl-shadow--2dp" style="width:100%;">
                        <div class="mdl-card__title mdl-color--purple mdl-color-text--white">
                            <h2 class="mdl-card__title-text">My Orders</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <ul class="mdl-list" style="padding:0;">
                                <?php 
                                // 要求：使用循環輸出清單
                                for($i=500; $i<=540; $i+=10) {
                                    echo "<li class='mdl-list__item' style='padding:0;'>";
                                    echo "<a class='mdl-list__item-primary-content' href='#' style='color:#ff6e40; text-decoration:none;'>Order #$i</a>";
                                    echo "</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 右欄：訂單表格 -->
                <div class="mdl-cell mdl-cell--9-col">
                    <div class="mdl-card mdl-shadow--2dp" style="width:100%;">
                        <div class="mdl-card__title mdl-color--orange mdl-color-text--white">
                            <h2 class="mdl-card__title-text">Selected Order: #520</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <div style="text-align:right; margin-bottom:10px;">
                                Customer: <strong>Mount Royal University</strong>
                            </div>
                            
                            <table class="mdl-data-table mdl-js-data-table" style="width:100%; border:none;">
                                <thead>
                                    <tr>
                                        <th>Cover</th>
                                        <th class="mdl-data-table__cell--non-numeric">Title</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subtotal = 0;
                                    // 要求：使用 outputOrderRow 函數
                                    $subtotal += outputOrderRow($file1, $product1, $quantity1, $price1);
                                    $subtotal += outputOrderRow($file2, $product2, $quantity2, $price2);
                                    $subtotal += outputOrderRow($file3, $product3, $quantity3, $price3);
                                    $subtotal += outputOrderRow($file4, $product4, $quantity4, $price4);
                                    
                                    // 運費邏輯計算
                                    $shipping = ($subtotal > 10000) ? 100 : 200;
                                    $grandTotal = $subtotal + $shipping;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr class="totals">
                                        <td colspan="4" style="text-align:right;">Subtotal</td>
                                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                                    </tr>
                                    <tr class="totals">
                                        <td colspan="4" style="text-align:right;">Shipping</td>
                                        <td>$<?php echo number_format($shipping, 2); ?></td>
                                    </tr>
                                    <tr class="grandtotals">
                                        <td colspan="4" style="text-align:right;">Grand Total</td>
                                        <td>$<?php echo number_format($grandTotal, 2); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div> <!-- End Cell 9 -->
            </div> <!-- End Grid -->
        </div>
    </main>
</div>

<!-- 必需：MDL JavaScript (處理 Drawer 同互動效果) -->
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

</body>
</html>