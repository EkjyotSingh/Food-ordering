<?php
include('top.php');
include('nav.php');
$error='';
$res['dish']='';
$res['category_id']='';
$res['dish_detail']='';
$res['image']='';
$image_req='required';
$cat_error='';
$attrs['attribute']='';
$attrs['price']='';
$attrs['status']='';
$attrs['id']='';
$image_error='';

if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $smtm=$con->prepare("select * from dish where id='$id'");
        $smtm->execute();
        $res=$smtm->fetch(PDO::FETCH_ASSOC);
        $image_req='';
        $smtm=$con->prepare("select * from dish_detail where dish_id='$id' order by price asc");
        $smtm->execute();
        $attr=$smtm->fetchAll(PDO::FETCH_ASSOC);
}
if(isset($_GET['dish_detail_id'])){
    $dish_detail_id=$_GET['dish_detail_id'];
    $smtm=$con->prepare("select dish_id from dish_detail where id='$dish_detail_id'");
    $smtm->execute();
    $dish_id=$smtm->fetch(PDO::FETCH_ASSOC);
    $smtm=$con->prepare("delete from dish_detail where id='$dish_detail_id'");
    $smtm->execute();
    redirect("dish_manage.php?id=".$dish_id['dish_id']);
}
if(isset($_POST['submit'])){

    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $dish=$_POST['dish'];
        $category_id=$_POST['category_id'];
        $dish_detail=$_POST['dish_detail'];
        $type=$_POST['type'];
        $rows=$con->query("select count(*) from dish where dish='$dish' and id!='$id'")->fetchColumn();
        if($rows>0){
            $error='Dish already existed';
        }elseif($category_id=='0'){
            $cat_error='Please select valid category';
        }elseif($type=='0'){
            $cat_error='Please select valid dish type';
        }
        else{
            if($_FILES['image']['name']!==''){
                if($_FILES['image']['type']=='image/jpeg' || $_FILES['image']['type']=='image/png'){
                unlink(constant('DISH_UPLOAD').$res['image']);
                $image=$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],constant("DISH_UPLOAD").$image);
                $smtm=$con->prepare("update  dish set dish='$dish',category_id='$category_id',image='$image',dish_detail='$dish_detail',type='$type' where id='$id'");
                $smtm->execute();
               
                foreach($_POST['attribute'] as $key=>$value){
                    $attribute=$value;
                    $price=$_POST['price'][$key];
                    $status=$_POST['status'][$key];
                    $added_on=date('Y-m-d,h:i:s');
                    if(isset($_POST['hidden'][$key])){
                        $r=$_POST['hidden'][$key];
                    $smtm=$con->prepare("update dish_detail set attribute='$attribute',price='$price',status='$status' where id='$r'");
                    $smtm->execute();
                    }else{
                        $smtm=$con->prepare("insert into dish_detail(dish_id,attribute,price,status,added_on) values('$id','$attribute','$price','$status','$added_on')");
                        $smtm->execute();
                    }
                }
                redirect(constant('FETCH_ADMIN_PATH').'dish');
                }else{
                $image_error="Please select png,jpeg type images only!";
            }
        }
            else{
            $smtm=$con->prepare("update dish set dish='$dish',category_id='$category_id',dish_detail='$dish_detail',type='$type' where id='$id'");
            $smtm->execute();
            foreach($_POST['attribute'] as $key=>$value){
                $attribute=$value;
                $price=$_POST['price'][$key];
                $status=$_POST['status'][$key];
                $added_on=date('Y-m-d,h:i:s');
                if(isset($_POST['hidden'][$key])){
                    $r=$_POST['hidden'][$key];
                    $smtm=$con->prepare("update dish_detail set attribute='$attribute',price='$price',status='$status' where id='$r'");
                    $smtm->execute();
                    }else{
                        $smtm=$con->prepare("insert into dish_detail(dish_id,attribute,price,status,added_on) values('$id','$attribute','$price','$status','$added_on')");
                        $smtm->execute();
                    }
            }
            redirect(constant('FETCH_ADMIN_PATH').'dish');
            
        }
    }
    }else{
        $dish=$_POST['dish'];
        $category_id=$_POST['category_id'];
        $dish_detail=$_POST['dish_detail'];
        $type=$_POST['type'];
        $added_on=date('Y-m-d,h:i:s');
        $rows=$con->query("select count(*) from dish where dish='$dish'")->fetchColumn();
        if($rows>0){
            $error=' Dish already existed';
        }elseif($category_id=='0'){
            $cat_error='Please select valid category';
        }elseif($type=='0'){
            $cat_error='Please select valid dish type';
        }
        else{
            if($_FILES['image']['type']=='image/jpeg' || $_FILES['image']['type']=='image/png'){
                $image=$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],constant("DISH_UPLOAD").$image);
                $smtm=$con->prepare("insert into dish(dish,category_id,dish_detail,image,added_on,status,type) values('$dish','$category_id','$dish_detail','$image','$added_on','1','$type')");
                $smtm->execute();
                $last_id=$con->lastInsertId();
                
                foreach($_POST['attribute'] as $key=>$value){
                    $attribute=$value;
                    $price=$_POST['price'][$key];
                    $status=$_POST['status'][$key];
                        $image_error="Please select valid status of dish attributes";
                        $smtm=$con->prepare("insert into dish_detail(dish_id,attribute,price,status,added_on) values('$last_id','$attribute','$price','$status','$added_on')");
                        $smtm->execute();
                }
                redirect(constant('FETCH_ADMIN_PATH').'dish');
            }else{
                $image_error="Please select png,jpeg type images only!";
            }

        }
    }
    
}
?>

<div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
			<h1 class="card-title ml10">Manage Dish</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="exampleInputName1">Dish</label>
                      <input type="text" value="<?php echo $res['dish']?>" name="dish"class="form-control" id="exampleInputName1" placeholder="Dish" required>
                    </div>
                    <div class="my-2  text-danger"><?php echo $error;?></div>
                    <div class="form-group">
                      <label for="exampleInputName2">Category</label>
                      <select required class="form-control" name="category_id">
                        <option value="0">Select Category</option>
                        <?php $smtm=$con->prepare("select * from category");
                        
                        $smtm->execute();
                        $cat=$smtm->fetchAll(PDO::FETCH_ASSOC);
                        foreach($cat as $cats){ 
                            $selected='';
                            if($cats['id']==$res['category_id']){
                                $selected='selected';?>
                            <?php }?>
                            <option value="<?php echo $cats['id']?>" <?php echo $selected?>><?php echo $cats['name']?></option>
                        <?php }?>
                        </select>
                    </div>
                    <div class="my-2  text-danger"><?php echo $cat_error;?></div>
                    <div class="form-group">
                      <label for="exampleInputName3">Dish Detail</label>
                      <textarea  value="<?php echo $res['dish_detail']?>" name="dish_detail"class="form-control" id="exampleInputName3" placeholder="Dish Detail" required><?php echo $res['dish_detail']?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName4">Image</label>
                      <input type="file" name="image"class="form-control" id="exampleInputName4"<?php echo $image_req?>>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select required class="form-control" name="type">
                            <option value="0">Select Type</option>
                            <?php
                            $dish_type=array('veg','non-veg');
                            foreach($dish_type as $types){
                            $selected='';
                            if($types==$res['type']){
                                $selected='selected';
                            }?>
                            <option value="<?php echo $types?>" <?php echo $selected?>><?php echo $types?></option>
                            <?php }?>
                        </select>
                    </div>
                    
                    <div class="form-group box" >
                        <label >Dish Attributes</label>
                        <?php if(isset($_GET['id']) && $_GET['id']>0){
                            $i=1;
                            foreach($attr as $attrs){?>
                                <input type="hidden" name="hidden[]"class="form-control" required placeholder="Attribute" value="<?php echo $attrs['id'] ?>">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-3 col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="attribute[]"class="form-control" required placeholder="Attribute" value="<?php echo $attrs['attribute'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="price[]"class="form-control" id="" required placeholder="Price" value="<?php echo $attrs['price'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <select  name="status[]"class="form-control" required>
                                            <option value=''>Status</option>
                                                <?php 
                                                if($attrs['status']=='1'){?>
                                                <option selected value='1'>Active</option>
                                                <option value='0'>Deactive</option>
                                                <?php 
                                                }elseif($attrs['status']=='0'){?>
                                                    <option value='1'>Active</option>
                                                    <option selected value='0'>Deactive</option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php 
                                    if($i!=1){?>
                                    <div class="col-2 col-md-1 ml-xl-2  ml-lg-2  ml-md-n3 mb-5">
                                        <a href="?dish_detail_id=<?php echo $attrs['id']?>" class="btn btn-info">Remove</a>
                                    </div>
                                    <?php }?>
                                </div>
                         
                                <?php $i++; }}else{?>
                                    <div class="row box1">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" name="attribute[]"class="form-control" required placeholder="Attribute">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" name="price[]"class="form-control" id="" required placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select  name="status[]"class="form-control" required>
                                                <option value="">Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                        </div>
                    <div class="row justify-content-start">
                        <div class=" col-auto mb-3"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                        <div class=" col-auto "><button  name="button" type="button" class="btn btn-info " onclick="add_more()">Add More</button></div>
                    </div>
                  </form>
                  <div class="text-danger my-2 "><?php echo $image_error?></div>
                </div>
              </div>
            </div>
            
		 </div>
        
        </div>
        <?php $i=1;?>
        <input type="hidden" class="add" value="<?php echo $i?>">

        
<script>
function add_more(){
    let i=$(".add").val();
    i++;
    $(".add").val(i);
    let html=`<div class="row box${i}"><div class="col-xl-4 col-lg-3 col-md-4"><div class="form-group">`+
    `<input type="text" name="attribute[]"class="form-control" required placeholder="Attribute"></div></div>`+
    `<div class="col-xl-3 col-lg-3 col-md-3"><div class="form-group"><input type="text" name="price[]"class="form-control" id="" required placeholder="Price">`+
    `</div></div><div class="col-xl-3 col-lg-3 col-md-3"><div class="form-group"><select  name="status[]"class="form-control" required><option value="">Status</option>`+
    `<option value="1">Active</option><option value="0">Deactive</option></select>`+
    `</div></div><div class="col-2 col-md-1 ml-xl-2  ml-lg-2  ml-md-n3 mb-5"><button  name="button" type="button" class="btn btn-info" onclick="remove(${i})">Remove</button></div></div>`
    $(".box").append(html);
}
function remove(i){
    $('.box'+i).remove();

    }

</script>
<?php 

include('bottom.php');
?>