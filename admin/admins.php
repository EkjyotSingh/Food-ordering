<?php 
include('top.php');
include('nav.php');
$stmt=$con->prepare("select * from admin");
$stmt->execute();
$admin_rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
if(isset($_GET['id']) && $_GET['id']>0){
    $id=$_GET['id'];
    if(isset($_GET['type'])){
        $type=$_GET['type'];
        
        if($type=='delete'){    
            $smtm=$con->prepare("delete from admin where id='$id'");
            $smtm->execute();
            }
            if($type=='deactive' || $type=='active'){
                
                $status='1';
                if($type =='deactive'){
                    $smtm=$con->prepare("update admin set status='0' where id='$id'");
                    $smtm->execute();
                }else{
                    $smtm=$con->prepare("update admin set status='$status' where id='$id'");
                    $smtm->execute();
                }
            }
            redirect(constant('FETCH_ADMIN_PATH').'admins');
    }
}
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="">Admin</h2>
              <h5 class="my-3"><a href="<?php echo constant('FETCH_ADMIN_PATH')?>admins_manage"> Add Admin</a></h5>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.no #</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password </th>
                            <th >Status</th>
                            <th>Added on</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                           $i=1;
                           foreach($admin_rows as $admin){?>
                        <tr class="">
                            <td class=""  width=5%><?php echo $i++ ?></td>
                            <td class=""><?php echo $admin['name']?></td>
                            <td class=""><?php echo $admin['email']?></td>
                            <td class=""><?php echo $admin['password']?></td>
                            <td class=""><?php echo $admin['status']?></td>
                            <td class=""><?php echo $admin['added_on']?></td>
                            <td class=""><span class="table_row2">
                              <a class="btn btn-success"  href="admins_manage.php?id=<?php echo $admin['id']?>">Edit</a>
                              
                              <?php if($admin['status']=='1'){?>
                              <a class="btn btn-primary" href="?id=<?php echo $admin['id']?>&type=deactive">Active</a>
                              <?php }else{?>
                                <a class="btn btn-danger"href="?id=<?php echo $admin['id']?>&type=active">Deactive</a>
                                <?php }?>

                            
                              <a class="btn btn-info" href="?id=<?php echo $admin['id']?>&type=delete">Delete</a>
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
