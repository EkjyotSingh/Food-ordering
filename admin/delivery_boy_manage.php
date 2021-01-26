<?php
include('top.php');
include('nav.php');
$error='';
$res['name']='';
$res['mobile']='';
$res['password']='';
$res['name']='';

if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $smtm=$con->prepare("select * from delivery_boy where id='$id'");
        $smtm->execute();
        $res=$smtm->fetch(PDO::FETCH_ASSOC);
}
if(isset($_POST['submit'])){

    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $name=$_POST['name'];
        $mobile=$_POST['mobile'];
        $password=$_POST['password'];
        $rows=$con->query("select count(*) from delivery_boy where mobile='$mobile' and id!='$id'")->fetchColumn();
        if($rows>0){
            $error='Mobile number already existed';
        }else{
            $smtm=$con->prepare("update  delivery_boy set name='$name',mobile='$mobile',password='$password' where id='$id'");
            $smtm->execute();
            redirect(constant('FETCH_ADMIN_PATH').'delivery_boy');
        }
    }else{
        $name=$_POST['name'];
        $mobile=$_POST['mobile'];
        $password=$_POST['password'];
        $added_on=date('Y-m-d,h:i:s');
        $rows=$con->query("select count(*) from delivery_boy where mobile='$mobile'")->fetchColumn();
        if($rows>0){
            $error='Mobile number already existed';
        }else{
            $smtm=$con->prepare("insert into delivery_boy(name,mobile,password,added_on,status) values('$name','$mobile','$password','$added_on','1')");
            $smtm->execute();
            redirect(constant('FETCH_ADMIN_PATH').'delivery_boy');
        }
    }
    
}
?>

<div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
			<h1 class="card-title ml10">Manage Delivery Boy</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Name</label>
                      <input type="text" value="<?php echo $res['name']?>" name="name"class="form-control" id="exampleInputName1" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName2">Mobile</label>
                      <input type="mobile" value="<?php echo $res['mobile']?>" name="mobile"class="form-control" id="exampleInputName2" placeholder="Mobile" required>
                    </div>
                    <div class="my-2  text-danger"><?php echo $error;?></div>
                    <div class="form-group">
                      <label for="exampleInputName3">Password</label>
                      <input type="password" value="<?php echo $res['password']?>" name="password"class="form-control" id="exampleInputName3" placeholder="Password" required>
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