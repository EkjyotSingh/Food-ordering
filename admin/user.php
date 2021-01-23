<?php 
include('top.php');
include('nav.php');
$stmt=$con->prepare("select * from user");
$stmt->execute();
$user_rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
if(isset($_GET['id']) && $_GET['id']>0){
    $id=$_GET['id'];
    if(isset($_GET['type'])){
        $type=$_GET['type'];
            if($type=='deactive' || $type=='active'){
                
                $status='1';
                if($type =='deactive'){
                    $smtm=$con->prepare("update user set status='0' where id='$id'");
                    $smtm->execute();
                }else{
                    $smtm=$con->prepare("update user set status='$status' where id='$id'");
                    $smtm->execute();
                }
            }
            redirect(FETCH_ADMIN_PATH.'user');
    }
}
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="">User</h2>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">S.no #</th>
                            <th width="20%">Name/Email/Mobile</th>
                            <th width="10%">Password </th>
                            <th width="5%" >Status</th>
                            <th width="5%" >Email Verification</th>
                            <th width="10%">Added on</th>
                            <th width="15%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                           $i=1;
                           foreach($user_rows as $user){?>
                        <tr class="">
                            <td class=""><?php echo $i++ ?></td>
                            <td class=""><span class="table_row"><?php echo $user['name']?></br><?php echo $user['email']?></br>
                            <?php echo $user['mobile']?></span></td>
                            <td class=""><?php echo $user['password']?></td>
                            <td class=""><?php echo $user['status']?></td>
                            <td class=""><?php echo $user['verified']?></td>
                            <td class=""><?php echo $user['added_on']?></td>
                            <td class="">                              
                              <?php if($user['status']=='1'){?>
                              <a class="btn btn-primary" href="?id=<?php echo $user['id']?>&type=deactive">Active</a>
                              <?php }else{?>
                                <a class="btn btn-danger"href="?id=<?php echo $user['id']?>&type=active">Deactive</a>
                                <?php }?>
                            </td>
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
