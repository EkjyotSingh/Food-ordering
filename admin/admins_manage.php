<?php
include('top.php');
include('nav.php');
$error='';
$res['name']='';
$res['email']='';
$res['password']='';
$res['name']='';

if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $smtm=$con->prepare("select * from admin where id='$id'");
        $smtm->execute();
        $res=$smtm->fetch(PDO::FETCH_ASSOC);
}
if(isset($_POST['submit'])){

    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $rows=$con->query("select count(*) from admin where email='$email' and id!='$id'")->fetchColumn();
        if($rows>0){
            $error='Email already existed';
        }else{
            $smtm=$con->prepare("update  admin set name='$name',email='$email',password='$password' where id='$id'");
            $smtm->execute();
            redirect(constant('FETCH_ADMIN_PATH').'admins');
        }
    }else{
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $added_on=date('Y-m-d,h:i:s');
        $rows=$con->query("select count(*) from admin where email='$email'")->fetchColumn();
        if($rows>0){
            $error='Mobile number already existed';
        }else{
            $smtm=$con->prepare("insert into admin(name,email,password,added_on,status) values('$name','$email','$password','$added_on','1')");
            $smtm->execute();
            redirect(constant('FETCH_ADMIN_PATH').'admins');
        }
    }
    
}
?>

<div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
			<h1 class="card-title ml10">Manage Admin</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Name</label>
                      <input type="text" value="<?php echo $res['name']?>" name="name"class="form-control" id="exampleInputName1" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName2">Email</label>
                      <input type="email" value="<?php echo $res['email']?>" name="email"class="form-control" id="exampleInputName2" placeholder="Email" required>
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