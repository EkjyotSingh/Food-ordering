<?php 
include('top.php');
include('nav.php');
$stmt=$con->prepare("select * from full_order order by id desc");
$stmt->execute();
$order_rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
//prx($order_rows);
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="">Orders</h2>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table table-hover">
                      <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Name/Email/Mobile</th>
                            <th>Address/City/Zipcode</th>
                            <th>Order Status </th>
                            <th>Delivery Boy Id</th>
                            <th>User Id</th>
                            <th >Payment Type</th>
                            <th>Payment Status</th>
                            <th>Final Price</th>
                            <th>Added on</th>
                            <th>Delivered at</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                           foreach($order_rows as $order){?>
                        <tr class="clickable-row text-center"  data-href="<?php echo constant('FETCH_ADMIN_PATH')?>order_detail?id=<?php echo $order['id'] ?>">
                            <td class=""><?php echo $order['id']?></td>
                            <td ><span class="table_row"><?php echo $order['full_name']?></br><?php echo $order['email']?></br>
                            <?php echo $order['mobile']?></span>
                            </td>
                            <td class=""><span class="table_row"><?php echo $order['address']?></br><?php echo $order['city']?></br>
                            <?php echo $order['zipcode']?></span></td>
                            <td class=""><?php echo $order['order_status']?></td>
                            <td class=""><?php echo $order['delivery_boy_id']?></td>
                            <td class=""><?php echo $order['user_id']?></td>
                            <td class=""><?php echo $order['payment_type']?></td>
                            <td class=""><?php echo ucfirst($order['payment_status'])?></td>
                            <td class=""><?php echo $order['final_price']?></td>
                            <td class=""><?php echo $order['added_on']?></td>
                            <td class=""><?php echo $order['delivered_at']?></td>
                        </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
				</div>
              </div>
            </div>
          </div>
        
        </div>
        <script>
            $('.clickable-row').on('click',function(){
                window.location.href=$(this).attr('data-href')
            })
        </script>
        <?php include('bottom.php'); ?>
