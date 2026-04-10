<?php

include 'includes/book-utilities.inc.php';

// Retrieve customers from the data directory
$customers = readCustomers('data/customers.txt');

// Determine if a specific customer was selected via query string
$selectedCustomerId = null;
$orders = array();

if (isset($_GET['id']) && array_key_exists($_GET['id'], $customers)) {
    $selectedCustomerId = $_GET['id'];
    // Retrieve orders for the selected customer
    $orders = readOrders($selectedCustomerId, 'data/orders.txt');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>DC325182 Che Chi Hin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
    <link rel="stylesheet" href="css/material.min.css">
    

    <link rel="stylesheet" href="css/demo-style.css">
    <link rel="stylesheet" href="css/styles.css">
    
    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://code.getmdl.io/1.1.3/material.min.js"></script>
    <script src="js/jquery.sparkline.2.1.2.js"></script>
</head>

<body>
    
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
            
    <?php include 'includes/header.inc.php'; ?>
    <?php include 'includes/left-nav.inc.php'; ?>
    
    <main class="mdl-layout__content mdl-color--grey-50">
        <section class="page-content">

            <div class="mdl-grid">

              <div class="mdl-cell mdl-cell--7-col card-lesson mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title mdl-color--orange">
                  <h2 class="mdl-card__title-text">Customers</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <table class="mdl-data-table mdl-shadow--2dp">
                      <thead>
                        <tr>
                          <th class="mdl-data-table__cell--non-numeric">Name</th>
                          <th class="mdl-data-table__cell--non-numeric">University</th>
                          <th class="mdl-data-table__cell--non-numeric">City</th>
                          <th>Sales</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($customers as $id => $customer): ?>
                              <tr>
                                  <td class="mdl-data-table__cell--non-numeric">
                                      <a href="?id=<?php echo htmlspecialchars($id); ?>">
                                          <?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']); ?>
                                      </a>
                                  </td>
                                  <td class="mdl-data-table__cell--non-numeric"><?php echo htmlspecialchars($customer['university']); ?></td>
                                  <td class="mdl-data-table__cell--non-numeric"><?php echo htmlspecialchars($customer['city']); ?></td>
                                  <td>
                                      <span class="sparkline"><?php echo htmlspecialchars($customer['sales']); ?></span>
                                  </td>
                              </tr>
                          <?php endforeach; ?>                                            
                      </tbody>
                    </table>
                </div>
              </div> 
              
              <div class="mdl-grid mdl-cell--5-col">
       
                  <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Customer Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <?php if ($selectedCustomerId): ?>
                            <h4><?php echo htmlspecialchars($customers[$selectedCustomerId]['firstName'] . ' ' . $customers[$selectedCustomerId]['lastName']); ?></h4>
                            <p>
                                <strong>Email:</strong> <?php echo htmlspecialchars($customers[$selectedCustomerId]['email']); ?><br>
                                <strong>University:</strong> <?php echo htmlspecialchars($customers[$selectedCustomerId]['university']); ?><br>
                                <strong>Address:</strong> <?php echo htmlspecialchars($customers[$selectedCustomerId]['address']); ?><br>
                                <strong>City/State/Zip:</strong> <?php echo htmlspecialchars($customers[$selectedCustomerId]['city'] . ', ' . $customers[$selectedCustomerId]['state'] . ' ' . $customers[$selectedCustomerId]['zip']); ?><br>
                                <strong>Phone:</strong> <?php echo htmlspecialchars($customers[$selectedCustomerId]['phone']); ?>
                            </p>
                        <?php else: ?>
                            <h4>Select a customer</h4>
                            <p>Click on a customer name in the table to view their details.</p>
                        <?php endif; ?>
                    </div>    
                  </div>   

                  <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Order Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">        
                        <?php if ($selectedCustomerId): ?>
                            <?php if (count($orders) > 0): ?>
                                <table class="mdl-data-table mdl-shadow--2dp">
                                  <thead>
                                    <tr>
                                      <th class="mdl-data-table__cell--non-numeric">Cover</th>
                                      <th class="mdl-data-table__cell--non-numeric">ISBN</th>
                                      <th class="mdl-data-table__cell--non-numeric">Title</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <img src="images/tinysquare/<?php echo htmlspecialchars($order['isbn']); ?>.jpg" 
                                                     alt="Book Cover" 
                                                     style="width: 50px;">
                                            </td>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <?php echo htmlspecialchars($order['isbn']); ?>
                                            </td>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <?php echo htmlspecialchars($order['title']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>
                            <?php else: ?>
                                <h5>Empty Order</h5>
                                <p>There are no orders for this customer.</p>
                            <?php endif; ?>
                        <?php else: ?>
                            <p>Select a customer to view their orders.</p>
                        <?php endif; ?>
                    </div>    
                  </div>              

               </div>   
            
            </div>  

        </section>
        
        <footer style="text-align: center; padding: 20px; background-color: #e0e0e0; margin-top: 20px;">
            CISC3003 Web Programming: DC325182 Che Chi Hin 2026
        </footer>
        
    </main>    
</div>  

<script>
    $(document).ready(function() {
        $('.sparkline').sparkline('html', {
            type: 'bar',
            barColor: '#ff9800', 
            height: '24px',
            barWidth: 6
        });
    });
</script>
          
</body>
</html>