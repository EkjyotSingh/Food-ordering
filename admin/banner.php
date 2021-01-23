<?php 
include('top.php');
include('nav.php');
$stmt=$con->prepare("select * from banner order by orderby asc");
$stmt->execute();
$banner_rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
if(isset($_GET['id']) && $_GET['id']>0){
    $id=$_GET['id'];
    if(isset($_GET['type'])){
        $type=$_GET['type'];
        
        if($type=='delete'){
            $smtm=$con->prepare("select image from banner where id='$id'");
            $smtm->execute();
            $row_image=$smtm->fetch(PDO::FETCH_ASSOC);
            unlink(constant('BANNER_UPLOAD').$row_image['image']);
            $smtm=$con->prepare("delete from banner where id='$id'");
            $smtm->execute();
            redirect(FETCH_ADMIN_PATH.'banner');
        }
         if($type=='deactive' || $type=='active'){        
            $status='1';
            if($type =='deactive'){
                $smtm=$con->prepare("update banner set status='0' where id='$id'");
                $smtm->execute();
            }else{
                $smtm=$con->prepare("update banner set status='$status' where id='$id'");
                $smtm->execute();
            }
            redirect(FETCH_ADMIN_PATH.'banner');

        }
    }
}
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="">Banner</h2>
              <h5 class="my-3"><a href="<?php echo constant('FETCH_ADMIN_PATH')?>banner_manage"> Add Banner</a></h5>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.no #</th>
                            <th>Heading/Sub Heading</th>
                            <th>Image</th>
                            <th>Link/Link Text</th>
                            <th>Status</th>
                            <th>Order By</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                           $i=1;
                           foreach($banner_rows as $banner){?>
                        <tr class="">
                            <td class="pl-4"><?php echo $i++ ?></td>
                            <td class="pl-4"><span class="table_row"><?php echo $banner['heading']?></br><?php echo $banner['sub_heading']?></span></td>
                            <td class="pl-4"><img src="<?php echo constant('BANNER_FETCH').$banner['image']?>"></td>
                            <td class="pl-4"><span class="table_row"><?php echo $banner['link']?></br><?php echo $banner['link_text']?></span></td>
                            <td class="pl-4"><?php echo $banner['status']?></td>
                            <td class="pl-4"><?php echo $banner['orderby']?></td>

                            <td class="pl-4"><span class="table_row2">
                              <a class="btn btn-success"  href="banner_manage.php?id=<?php echo $banner['id']?>">Edit</a>
                              
                              <?php if($banner['status']=='1'){?>
                              <a class="btn btn-primary" href="?id=<?php echo $banner['id']?>&type=deactive">Active</a>
                              <?php }else{?>
                                <a class="btn btn-danger"href="?id=<?php echo $banner['id']?>&type=active">Deactive</a>
                                <?php }?>

                            
                              <a class="btn btn-info" href="?id=<?php echo $banner['id']?>&type=delete">Delete</a>
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
