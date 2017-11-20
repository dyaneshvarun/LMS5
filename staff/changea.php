<?php
   require_once("../arc/dbconnect.php");
    
$id= $_POST['id'];
$old=$_POST['oldpass'];
$new=$_POST['newpass'];
$cnew=$_POST['cnewpass'];
$mold=md5($old);
$mnew=md5($new);
if(!(($id == "")&&($old == "")&& ($new == "")&& ($cnew =="")))
{
    if(!($new==$cnew))
    {       echo "PASSWORD DOESNOT MATCH";
           require_once("changepass.php");
    }
    else
        {
            //CHANGED CODE
             $sessql=mysqli_query($conn,"SELECT PASSWORD FROM STAFF WHERE STAFF_ID='$id'");
             $sessrow=mysqli_fetch_array($sessql,MYSQLI_ASSOC);
             $dboldpass=$sessrow['PASSWORD'];
             
             if(!($dboldpass==$mold))
                    {
                    echo "Your oldpass doesnot match with the Database";
                    require_once("changepass.php");
                    }
             else
                    {
                        $ins=mysqli_query($conn,"UPDATE STAFF SET PASSWORD='$mnew' WHERE STAFF_ID='$id'");
                        if($ins)
                        {
                            header("Location:index.php");
                        }
                        else
                        {
                            echo "INSERT NOT DONE";
                        }
                    }

    //CHANGED CODE ENDS  
        }

}
else
echo "FILL ALL OF YOUR DETAILS";



?>

