<?php
include('top.php');
include('nav.php');
$error='';
$res['name']='';
if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $smtm=$con->prepare("select * from category where id='$id'");
        $smtm->execute();
        $res=$smtm->fetch(PDO::FETCH_ASSOC);
}
if(isset($_POST['submit'])){

    if(isset($_GET['id']) && $_GET['id']>0){
        $id=$_GET['id'];
        $name=$_POST['name'];
        $rows=$con->query("select count(*) from category where name='$name' and id!='$id'")->fetchColumn();
        if($rows>0){
            $error='Category already existed';
        }else{
            $smtm=$con->prepare("update  category set name='$name' where id='$id'");
            $smtm->execute();
            redirect(constant('FETCH_ADMIN_PATH').'category');
            
        }
    }else{
        $name=$_POST['name'];
        $added_on=date('Y-m-d,h:i:s');
        $rows=$con->query("select count(*) from category where name='$name'")->fetchColumn();
        if($rows>0){
            $error='Category already existed';
        }else{
            $smtm=$con->prepare("insert into category(name,status,added_on) values('$name','1','$added_on')");
            $smtm->execute();
            redirect(constant('FETCH_ADMIN_PATH').'category');
        }
    }
    
}
?>

<div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
			<h1 class="card-title ml10">Manage Category</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Name</label>
                      <input type="text" value="<?php echo $res['name']?>" name="name"class="form-control" id="exampleInputName1" placeholder="Name" required>
                    </div>
                    <div class="my-2  text-danger"><?php echo $error;?></div>
                    <button  name="submit" class="btn btn-primary mr-2">Submit</button>
                  </form>
                </div>
              </div>
            </div>
            
		 </div>
        
		</div>

<?php include('bottom.php');
?>