<?php
include('top.php');
include('nav.php');
$image_error='';
$image_req='required';
$res['heading']='';
$res['sub_heading']='';
$res['link']='';
$res['link_text']='';
$res['orderby']='';
if(isset($_GET['id']) && $_GET['id']>0){
    $image_req='';
    $id=$_GET['id'];
    $smtm=$con->prepare("select * from banner where id='$id'");
    $smtm->execute();
    $res=$smtm->fetch(PDO::FETCH_ASSOC);
}
if(isset($_POST['submit'])){
    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $heading=$_POST['heading'];
        $sub_heading=$_POST['sub_heading'];
        $link=$_POST['link'];
        $link_text=$_POST['link_text'];
        $orderby=$_POST['orderby'];
        if(isset($_FILES['image']['name']) && $_FILES['image']['name']==''){
            $smtm=$con->prepare("update  banner set heading='$heading',sub_heading='$sub_heading',link='$link',link_text='$link_text',orderby='$orderby' where id='$id'");
            $smtm->execute();
        }else{
            if($_FILES['image']['type']=='image/jpeg' || $_FILES['image']['type']=='image/png' || $_FILES['image']['type']=='image/jpg'){
                unlink(constant('BANNER_UPLOAD').$res['image']);
                $image=$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],constant('BANNER_UPLOAD').$image);
                $smtm=$con->prepare("update  banner set heading='$heading',sub_heading='$sub_heading',image='$image',link='$link',link_text='$link_text',orderby='$orderby' where id='$id'");
                $smtm->execute();
                }else{
                    $image_error='Please select jpeg,png,jpg type image!';
                }
            }
            redirect(constant('FETCH_ADMIN_PATH').'banner');
        }else{
            $heading=$_POST['heading'];
            $sub_heading=$_POST['sub_heading'];
            $link=$_POST['link'];
            $link_text=$_POST['link_text'];
            $orderby=$_POST['orderby'];
            $image=$_FILES['image']['name'];
            if($_FILES['image']['type']=='image/jpeg' || $_FILES['image']['type']=='image/png' || $_FILES['image']['type']=='image/jpg'){
                move_uploaded_file($_FILES['image']['tmp_name'],constant('BANNER_UPLOAD').$image);
                $smtm=$con->prepare("insert into banner(heading,sub_heading,link,link_text,image,orderby,status) values('$heading','$sub_heading','$link','$link_text','$image','$orderby','1')");
                $smtm->execute();
                redirect(constant('FETCH_ADMIN_PATH').'banner');
                }else{
                    $image_error='Please select jpeg,png,jpg type image!';
                }
    }
    
}
?>

<div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
			<h1 class="card-title ml10">Manage Banner</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="exampleInputName1">Heading</label>
                      <input type="text" value="<?php echo $res['heading']?>" name="heading"class="form-control" id="exampleInputName1" placeholder="Heading" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName2">Sub Heading</label>
                      <input type="text" value="<?php echo $res['sub_heading']?>" name="sub_heading"class="form-control" id="exampleInputName2" placeholder="Sub Heading" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName3">Image</label>
                      <input type="file" name="image"class="form-control" id="exampleInputName3" placeholder="Image" <?php echo $image_req?>>
                    <div class="my-2 text-danger"><?php echo $image_error?></div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName4">Link</label>
                      <input type="text" value="<?php echo $res['link']?>" name="link"class="form-control" id="exampleInputName4" placeholder="Link" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName5">Link Text</label>
                      <input type="text" value="<?php echo $res['link_text']?>" name="link_text"class="form-control" id="exampleInputName5" placeholder="Link Text" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName6">Order By</label>
                      <input type="text" value="<?php echo $res['orderby']?>" name="orderby"class="form-control" id="exampleInputName6" placeholder="Order By" required>
                    </div>
                    <button  name="submit" class="btn btn-primary mr-2">Submit</button>
                  </form>
                </div>
              </div>
            </div>
            
		 </div>
        
		</div>

<?php include('bottom.php');
?>