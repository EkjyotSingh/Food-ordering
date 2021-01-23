<?php 
include('top.php');
include('nav.php');
$stmt=$con->prepare("select * from delivery_boy");
$stmt->execute();
$delivery_boy_rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
if(isset($_GET['id']) && $_GET['id']>0){
    $id=$_GET['id'];
    if(isset($_GET['type'])){
        $type=$_GET['type'];
        
        if($type=='delete'){    
            $smtm=$con->prepare("delete from delivery_boy where id='$id'");
            $smtm->execute();
            }
            if($type=='deactive' || $type=='active'){
                
                $status='1';
                if($type =='deactive'){
                    $smtm=$con->prepare("update delivery_boy set status='0' where id='$id'");
                    $smtm->execute();
                }else{
                    $smtm=$con->prepare("update delivery_boy set status='$status' where id='$id'");
                    $smtm->execute();
                }
            }
            redirect(FETCH_ADMIN_PATH.'delivery_boy');
    }
}
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="">Delivery Boy</h2>
              <h5 class="my-3"><a href="<?php echo constant('FETCH_ADMIN_PATH') ?>delivery_boy_manage"> Add delivery Boy</a></h5>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.no #</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Password </th>
                            <th >Status</th>
                            <th>Added on</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                           $i=1;
                           foreach($delivery_boy_rows as $delivery_boy){?>
                        <tr class="">
                            <td class=""  width=5%><?php echo $i++ ?></td>
                            <td class=""><?php echo $delivery_boy['name']?></td>
                            <td class=""><?php echo $delivery_boy['mobile']?></td>
                            <td class=""><?php echo $delivery_boy['password']?></td>
\                            <td class=""><?php echo $delivery_boy['status']?></td>
                            <td class=""><?php echo $delivery_boy['added_on']?></td>
                            <td class=""><span class="table_row2">
                              <a class="btn btn-success"  href="delivery_boy_manage.php?id=<?php echo $delivery_boy['id']?>">Edit</a>
                              
                              <?php if($delivery_boy['status']=='1'){?>
                              <a class="btn btn-primary" href="?id=<?php echo $delivery_boy['id']?>&type=deactive">Active</a>
                              <?php }else{?>
                                <a class="btn btn-danger"href="?id=<?php echo $delivery_boy['id']?>&type=active">Deactive</a>
                                <?php }?>

                            
                              <a class="btn btn-info" href="?id=<?php echo $delivery_boy['id']?>&type=delete">Delete</a>
                              </p></td>
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
        <?php include('bottom.php'); ?>
