<?php
   require 'Z:\home\localhost\www\connectid.php';
?>
<?php
$proverka=true;    
$NewLogin=htmlspecialchars($_POST['login']);
$NewMail=htmlspecialchars($_POST['login']);
$NewPass=htmlspecialchars($_POST['password']);
if(isset($_POST['Get'])) {
    DATA($con,$NewLogin,$NewPass,$NewMail,$proverka);
}
function DATA($con, $NewLogin,$NewPass,$NewMail,$proverka)
{
    if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+.[a-zA-Z.]{2,5}$/", $NewMail) || !preg_match("/[a-zA-Z0-9._-]/", $NewLogin))
    {
        
    } else {$proverka = false;
        echo"incorrect login or mail".'</br>';}
    
    if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z]).{8}$/", $NewPass))
    {
        echo "Incorrect Password".'</br>';
        $proverka = false;
    }
    if($proverka === true)
    {
        $stmt=$con->prepare("SELECT * FROM users where (login = :login OR mail = :mail) and password = :password");
        $stmt->bindParam(':login', $NewLogin);
        $stmt->bindParam(':mail', $NewMail); 
        $stmt->bindParam(':password', $NewPass);
        $col=$stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_OBJ);
        if(!$result)
        {   
            echo "No such user exists";
        
        } else {
            session_start();
            $_SESSION['login']=$result->login;
            $_SESSION['name']=$result->name;
            $_SESSION['role']=$result->type;
            if($result->type == 'Admin')
            {
                header('Location: /admin.php'); 
            }
            if($result->type == 'User')
            {
                header('Location: /user.php'); 
            }
            if($result->type == 'Guest')
            {
                header('Location: /guest.php'); 
            }
        }
        $stmt->closeCursor();
    }
}
?>
<div style="font-size: 120%; font-family: Verdana, Arial, Helvetica, sans-serif; padding: 70px"; align="center";>
<p style="border:2px solid;">Entrance in the database <br></p> 
</div>
<div>
<form method="POST"   align="center"; >
<input style="border:2px solid;  width: 11%; height: 5%"; type="text" name="login" placeholder="Login" > <br><br>
<input style="border:2px solid;width: 11%; height: 5%;"; type="password" name="password" placeholder="Password (8 sign)"><br><br>
<input type="submit"style="border:2px solid;  width: 11%; height: 5%; color:#4169E1" name="Get" value="Enter" ><br><br>
</form>
</div>