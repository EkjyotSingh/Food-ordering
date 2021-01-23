<?php include('header.php');

    $name=$_POST['name'];
    $email=$_POST['email'];
    $subject=$_POST['subject'];
    $message=$_POST['message'];
    $added_on=date('Y-m-d h:i:s');
    $smtm=$con->prepare("insert into contact(name,email,subject,message,added_on) values('$name','$email','$subject','$message','$added_on')");
    $smtm->execute();
include('footer.php');
?>