<?php include('top.php');
include('nav.php');
$stmt=$con->prepare("select * from coupon_code");
$stmt->execute();
$coupon_code_rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
if(isset($_GET['id']) && $_GET['id']>0){
    $id=$_GET['id'];
    if(isset($_GET['type'])){
        $type=$_GET['type'];
        
        if($type=='delete'){    
            $smtm=$con->prepare("delete from coupon_code where id='$id'");
            $smtm->execute();
            }
            if($type=='deactive' || $type=='active'){
                
                $status='1';
                if($type =='deactive'){
                    $smtm=$con->prepare("update coupon_code set status='0' where id='$id'");
                    $smtm->execute();
                }else{
                    $smtm=$con->prepare("update coupon_code set status='$status' where id='$id'");
                    $smtm->execute();
                }
            }
            redirect(FETCH_ADMIN_PATH.'coupon_code');

    }

}?>
<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="">Coupon Code</h2>
              <h5 class="my-3"><a href="<?php echo constant('FETCH_ADMIN_PATH') ?>coupon_code_manage"> Add coupon Code</a></h5>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.no #</th>
                            <th>Code/Type</th>
                            <th>Value/Cart Min.value</th>
                            <th>Expired On</th>
                            <th>Status</th>
                            <th>Added On</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                           $i=1;
                           foreach($coupon_code_rows as $coupon_code){
                            if($coupon_code['expired_on']=='0000-00-00'){
                                $coupon_code['expired_on']='NA';
                            }?>
                        <tr class="">
                            <td class=""  width=5%><?php echo $i++ ?></td>
                            <td class=""><span class="table_row"><?php echo $coupon_code['coupon_code']?></br><?php echo $coupon_code['coupon_type']?></span></td>
                            <td class=""><span class="table_row"><?php echo $coupon_code['coupon_value']?></br><?php echo $coupon_code['cart_min_value']?></span></td>
                            <td class=""><?php echo $coupon_code['expired_on']?></td>
                            <td class=""><?php echo $coupon_code['status']?></td>
                            <td class=""><?php echo $coupon_code['added_on']?></td>

                            <td class=""><span class="table_row2">
                              <a class="btn btn-success"  href="coupon_code_manage.php?id=<?php echo $coupon_code['id']?>">Edit</a>
                              
                              <?php if($coupon_code['status']=='1'){?>
                              <a class="btn btn-primary" href="?id=<?php echo $coupon_code['id']?>&type=deactive">Active</a>
                              <?php }else{?>
                                <a class="btn btn-danger"href="?id=<?php echo $coupon_code['id']?>&type=active">Deactive</a>
                                <?php }?>

                            
                              <a class="btn btn-info" href="?id=<?php echo $coupon_code['id']?>&type=delete">Delete</a>
                              </span></td>
                        </tr>
                          <?php }?>
                      </tbody>
                    </table>
                  </div>
				</div>
              </div>
            </div>
          </div>
        
        </div><?php include('bottom.php');?>
