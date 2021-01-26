<?php 
include('top.php');
include('nav.php');
$full_order_id=$_GET['id'];

if(isset($_GET['id']) && $_GET['id']!=''){
    $order_detail=order_detail($full_order_id,'admin');
    //prx($order_detail);
    $smtm=$con->prepare("select * from delivery_boy where status='1'");
    $smtm->execute();

    $delivery_boy=$smtm->fetchAll(PDO::FETCH_ASSOC);
    $delivery_boy_id=$order_detail[0]['delivery_boy_id'];
    $smtm=$con->prepare("select * from order_status");
    $smtm->execute();

    $order_status=$smtm->fetchAll(PDO::FETCH_ASSOC);
    //prx($order_detail);
}else{
    redirect(constant('FETCH_ADMIN_PATH').'index');
}
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
                <a href="<?php echo constant('FETCH_ADMIN_PATH')?>"
                class="btn btn-sm btn-back" style="background:#5e2572;color:#fff;">
                <svg class="icon icon-arrow-left2"><use xlink:href="assets/images/sprite.svg#icon-arrow-left2"></use></svg>   
                <span style="font-size:0.975rem;">Back</span>
            </a>
              <h2 class="mb-5">Order Details</h2>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive mb-5">
                    <table id="" class="table">
                      <thead>
                        <tr>
                            <th>Dish</th>
                            <th>Dish Type</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $dishtotalprice=0;
                            foreach($order_detail as $dish){
                            $unitprice=$dish['price']*$dish['quantity'];
                            $dishtotalprice=$dishtotalprice+$unitprice;
                            ?>
                        <tr>
                            <td class=""><?php echo $dish['dish']?></td>
                            <td ><?php echo $dish['attribute']?></td>
                            <td class=""><?php echo $dish['price']?></td>
                            <td class=""><?php echo $dish['quantity']?></td>
                            <td class=""><?php echo $unitprice?></td>
                        </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  
                  <div class="form-group box" >
                                <div class="row">
                                    <div class="col-auto mr-xl-5 ">
                                        <h2 class=" d-inline-block " >Order Status</h2><h4 class="d-inline-block  mb-md-4 mb-sm-4" style="margin-bottom:25px;">(<?php echo ucfirst($order_detail[0]['order_status'])?>)</h4>
                                        <div class="form-group">
                                            <select  class=" form-control order_status custom-select" style="max-width:300px;" onchange="update_order_status()">
                                            <option value=''>Select Order Status</option>
                                                <?php 
                                                foreach($order_status as $status){
                                                    $selected='';
                                                    if($status['status']==$order_detail[0]['order_status']){
                                                        $selected='selected';
                                                    }
                                                    ?>
                                                <option <?php echo $selected?> value="<?php echo $status['status']?>"><?php echo $status['status']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <span class="order_status_message text-danger"></span>
                                    </div>
                                    <div class="col-auto">
                                        <?php 
                                        if($delivery_boy_id==0){?>
                                            <h2 class="  d-inline-block ">Delivery Boy</h2><h4 class="d-inline-block  mb-md-4 mb-sm-4" style="margin-bottom:25px;">(Not Assigned)</h4>
                                        <?php }else{
                                                $delivery=delivery_boy_detail($delivery_boy_id);?>
                                                <h2 class="d-inline-block ">Delivery Boy</h2><h4 class="d-inline-block  mb-md-4 mb-sm-4" style="margin-bottom:25px;">(<?php echo $delivery['name'].'-'. $delivery['mobile'] ?>)</h4>
                                        <?php }?>

                                        <div class="form-group">
                                            <select  class="delivery_boy form-control custom-select" style="max-width:300px;" onchange="update_delivery_boy()">
                                            <option value=0>No delivery Boy</option>
                                                <?php 
                                                foreach($delivery_boy as $boy){
                                                    $selected='';
                                                    if($boy['id']==$delivery_boy_id){
                                                        $selected='selected';
                                                    }
                                                    ?>
                                                <option <?php echo $selected?> value="<?php echo $boy['id']?>"><?php echo $boy['name']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end mt-5">
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-sm btn-download" style="background:#5e2572;color:#fff;">
                                            <svg class="icon icon-folder-download"><use xlink:href="assets/images/sprite.svg#icon-folder-download"></use></svg>   
                                            <span style="font-size:0.975rem;">PDF</span>
                                        </a>
                                    </div>
                                </div>
                        </div>

                  </form>

				</div>
              </div>
            </div>
          </div>
        
        </div>
        <script>
            function update_order_status(){
                $('.order_status_message').html('');
                let order_status=$('.order_status').val();
                if(order_status!=''){
                    let order_id="<?php echo $full_order_id?>";
                window.location.href=`<?php echo constant('FETCH_ADMIN_PATH')?>order_delivery?order_status=${order_status}&order_id=${order_id}`;
            
                }else{
                    $('.order_status_message').html('Please select valid status');
                }
            }

            function update_delivery_boy(){
                let delivery_boy_id=$('.delivery_boy').val();
                let order_id="<?php echo $full_order_id?>";
                window.location.href=`<?php echo constant('FETCH_ADMIN_PATH')?>order_delivery?delivery_boy_id=${delivery_boy_id}&order_id=${order_id}`;
            }
        </script>
        <?php include('bottom.php'); ?>
