<?php 
include('top.php');
include('nav.php');
$stmt=$con->prepare("select dish.*,category.name from dish,category where category.id=dish.category_id");
$stmt->execute();
$dish_rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
if(isset($_GET['id']) && $_GET['id']>0){
    $id=$_GET['id'];
    if(isset($_GET['type'])){
        $type=$_GET['type'];
        
        if($type=='delete'){ 
            $smtm=$con->prepare("delete  from dish_detail where dish_id='$id' ");
            $smtm->execute();
            $smtm=$con->prepare("select image from dish where id='$id'");
            $smtm->execute();
            $res=$smtm->fetch(PDO::FETCH_ASSOC);
            unlink(constant('DISH_UPLOAD').$res['image']);  
            $smtm=$con->prepare("delete from dish where id='$id'");
            $smtm->execute();
        }
            if($type=='deactive' || $type=='active'){
                
                $status='1';
                if($type =='deactive'){
                    $smtm=$con->prepare("update dish set status='0' where id='$id'");
                    $smtm->execute();
                }else{
                    $smtm=$con->prepare("update dish set status='$status' where id='$id'");
                    $smtm->execute();
                }
            }
            redirect(constant('FETCH_ADMIN_PATH').'dish');
    }
}
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="">Dish</h2>
              <h5 class="my-3"><a href="<?php echo constant('FETCH_ADMIN_PATH') ?>dish_manage"> Add Dish</a></h5>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.no #</th>
                            <th>Dish</th>
                            <th>Category</th>
                            <th >Image</th>
                            <th>Status</th>
                            <th>Added on</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                           $i=1;
                           foreach($dish_rows as $dish){?>
                        <tr class="">
                            <td class=""  width=5%><?php echo $i++ ?></td>
                            <td class=""><?php echo $dish['dish']?></td>
                            <td class=""><?php echo $dish['name']."(".strtoupper($dish['type']).")"?></td>
                            <td class=""><img src="<?php echo constant('DISH_FETCH').$dish['image']?>"></td>
                            <td class=""><?php echo $dish['status']?></td>
                            <td class=""><?php echo $dish['added_on']?></td>
                            <td class=""><span class="table_row2">
                              <a class="btn btn-success"  href="dish_manage.php?id=<?php echo $dish['id']?>">Edit</a>
                              
                              <?php if($dish['status']=='1'){?>
                              <a class="btn btn-primary" href="?id=<?php echo $dish['id']?>&type=deactive">Active</a>
                              <?php }else{?>
                                <a class="btn btn-danger"href="?id=<?php echo $dish['id']?>&type=active">Deactive</a>
                                <?php }?>

                            
                              <a class="btn btn-info" href="?id=<?php echo $dish['id']?>&type=delete">Delete</a>
                              </span></td>
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
