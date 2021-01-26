<?php
include('top.php');
include('nav.php');
$error='';
$type_error='';
$res['coupon_code']='';
$res['coupon_type']='';
$res['coupon_value']='';
$res['cart_min_value']='';
$res['expired_on']='';
$selected='';


if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $smtm=$con->prepare("select * from coupon_code where id='$id'");
        $smtm->execute();
        $res=$smtm->fetch(PDO::FETCH_ASSOC);
}
if(isset($_POST['submit'])){

    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $coupon_code=$_POST['coupon_code'];
        $coupon_type=$_POST['coupon_type'];
        $coupon_value=$_POST['coupon_value'];
        $cart_min_value=$_POST['cart_min_value'];
        $expired_on=$_POST['expired_on'];
        $rows=$con->query("select count(*) from coupon_code where coupon_code='$coupon_code' and id!='$id'")->fetchColumn();
        if($rows>0){
            $error='Coupon code already existed';
        }elseif($coupon_type=='0'){
            $type_error='Please select valid coupon type';
        }else{
            $smtm=$con->prepare("update  coupon_code set coupon_code='$coupon_code',coupon_type='$coupon_type',coupon_value='$coupon_value',cart_min_value='$cart_min_value',expired_on='$expired_on' where id='$id'");
            $smtm->execute();
            redirect(constant('FETCH_ADMIN_PATH').'coupon_code');
        }
    }else{
        $coupon_code=$_POST['coupon_code'];
        $coupon_type=$_POST['coupon_type'];
        $coupon_value=$_POST['coupon_value'];
        $cart_min_value=$_POST['cart_min_value'];
        $expired_on=$_POST['expired_on'];
        $added_on=date('Y-m-d,h:i:s');
        $rows=$con->query("select count(*) from coupon_code where coupon_code='$coupon_code'")->fetchColumn();
        if($rows>0){
            $error='Coupon code already existed';
        }elseif($coupon_type=='0'){
            $type_error='Please select valid coupon type';
        }
        else{
            $smtm=$con->prepare("insert into coupon_code(coupon_code,coupon_type,coupon_value,cart_min_value,expired_on,status,added_on) values('$coupon_code','$coupon_type','$coupon_value','$cart_min_value','$expired_on','1','$added_on')");
            $smtm->execute();
            redirect(constant('FETCH_ADMIN_PATH').'coupon_code');
        }
    }
    
}
?>

<div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
			<h1 class="card-title ml10">Manage Coupon Code</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Coupon Code</label>
                      <input type="text" value="<?php echo $res['coupon_code']?>" name="coupon_code"class="form-control" id="exampleInputName1" placeholder="Coupon Code" required>
                    </div>
                    <div class="my-2  text-danger"><?php echo $error;?></div>
                    <div class="form-group">
                        <label for="exampleInputName2">Coupon Type</label>
                        <select name="coupon_type" class="custom-select" required>
                        <option value="0">Select Type</option>
                        <?php 
                        $arr=array('P'=>'Percentage Price','F'=>'Fixed Price');
                        foreach( $arr as $key=>$value){
                            $selected='';
                            if($res['coupon_type']==$key){
                                $selected='selected';
                            }?>
                            <option value="<?php echo $key?>" <?php echo $selected?>><?php echo $value?></option>
                        <?php }?>
                        </select>
                    </div>
                    <div class="my-2  text-danger"><?php echo $type_error;?></div>
                    <div class="form-group">
                      <label for="exampleInputName3">Coupon Value</label>
                      <input type="text" value="<?php echo $res['coupon_value']?>" name="coupon_value"class="form-control" id="exampleInputName3" placeholder="Coupon Value" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName3">Cart Minimum Value</label>
                      <input type="text" value="<?php echo $res['cart_min_value']?>" name="cart_min_value"class="form-control" id="exampleInputName3" placeholder="Cart Minimum Value" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName3">Expired On</label>
                      <input type="date" value="<?php echo $res['expired_on']?>" name="expired_on"class="form-control" id="exampleInputName3" placeholder="Expired On">
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