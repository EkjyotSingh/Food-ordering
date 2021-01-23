<?php 
include('top.php');
include('nav.php');
$cat_error='';
$stmt=$con->prepare("select * from category");
$stmt->execute();
$category_rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
if(isset($_GET['id']) && $_GET['id']>0){
    $id=$_GET['id'];
    if(isset($_GET['type'])){
        $type=$_GET['type'];
        
        if($type=='delete'){
            $rows=$con->query("select count(*) from dish where category_id='$id'")->fetchColumn();
            if($rows<=0){  
            $smtm=$con->prepare("delete from category where id='$id'");
            $smtm->execute();
            redirect('category.php');
            }else{
                $cat_error='Category connected to dish,cannot be deleted';
            }
        }
         if($type=='deactive' || $type=='active'){        
            $status='1';
            if($type =='deactive'){
                $smtm=$con->prepare("update category set status='0' where id='$id'");
                $smtm->execute();
            }else{
                $smtm=$con->prepare("update category set status='$status' where id='$id'");
                $smtm->execute();
            }
            redirect(FETCH_ADMIN_PATH.'category');

        }
    }
}
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="">Category</h2>
              <h5 class="my-3"><a href="<?php echo constant('FETCH_ADMIN_PATH') ?>category_manage"> Add Category</a></h5>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.no #</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Added On</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                           $i=1;
                           foreach($category_rows as $category){?>
                        <tr class="">
                            <td class="pl-4"><?php echo $i++ ?></td>
                            <td class="pl-4"><?php echo $category['name']?></td>
                            <td class="pl-4"><?php echo $category['status']?></td>
                            <td class="pl-4"><?php echo $category['added_on']?></td>
                            <td class="pl-4"><span class="table_row2">
                              <a class="btn btn-success"  href="category_manage.php?id=<?php echo $category['id']?>">Edit</a>
                              
                              <?php if($category['status']=='1'){?>
                              <a class="btn btn-primary" href="?id=<?php echo $category['id']?>&type=deactive">Active</a>
                              <?php }else{?>
                                <a class="btn btn-danger"href="?id=<?php echo $category['id']?>&type=active">Deactive</a>
                                <?php }?>

                            
                              <a class="btn btn-info" href="?id=<?php echo $category['id']?>&type=delete">Delete</a>
                              </p></td>
                        </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                    <div class="my-2 text-danger"><?php echo $cat_error?></div>
                  </div>
				</div>
              </div>
            </div>
          </div>
        
        </div>
        <?php include('bottom.php'); ?>
