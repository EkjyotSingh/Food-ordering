<?php 
include('top.php');
include('nav.php');
$stmt=$con->prepare("select * from contact");
$stmt->execute();
$contact_rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
if(isset($_GET['id']) && $_GET['id']>0){
    $id=$_GET['id'];
    if(isset($_GET['type'])){
        $type=$_GET['type'];
        
        if($type=='delete'){  
            $smtm=$con->prepare("delete from contact where id='$id'");
            $smtm->execute();
            redirect(FETCH_ADMIN_PATH.'contact_us');
        }
         
    }
}
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="">Contact Us</h2>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.no #</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Added On</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                           $i=1;
                           foreach($contact_rows as $contact){?>
                        <tr class="">
                            <td class="pl-4"><?php echo $i++ ?></td>
                            <td class="pl-4"><?php echo $contact['name']?></td>
                            <td class="pl-4"><?php echo $contact['email']?></td>
                            <td class="pl-4"><?php echo $contact['subject']?></td>
                            <td class="pl-4"><?php echo $contact['message']?></td>
                            <?php $dat=strtotime($contact['added_on'])?>
                            <td class="pl-4"><?php echo date("Y-m-d",$dat)?></td>

                            <td class="pl-4">
                              <a class="btn btn-info" href="?id=<?php echo $contact['id']?>&type=delete">Delete</a>
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
