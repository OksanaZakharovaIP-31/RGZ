<?PHP header("Content-Type: text/html; charset=utf-8");?>
<?php
$server = 'localhost'; // имя сервера
$username = 'root'; // имя пользователя 
$database = 'king';
$password = 'h.5r3rJYwia7BGk';
$con=mysqli_connect($server, $username,$password, $database) //функция открытия соединения с севером базы данных
or die (mysqli_error()); // если подключение не открылось, отобразить описание ошибки/// require 'Z:\home\localhost\www\connectid.php';
?>
<?php
if(isset($_POST['Get'])) {
    NEWUs($con);
}
function NEWUs($con)
{
    //Считывание данных
    $NewLogin=htmlspecialchars($_POST['login']);
    $NewPass=htmlspecialchars($_POST['password']);
    $NewName=htmlspecialchars($_POST['name']);
    $NewMail=htmlspecialchars($_POST['Email']);
    foreach($_POST['type'] as $Select)
    {
        $NewType=$Select;  
    }
    $NewCode=htmlspecialchars($_POST['code']);
    //Проверка на правильность введнных данных
    $proverka=true;
    if (preg_match("/[a-zA-Z0-9._-]/", $NewLogin)) {
        if(preg_match("/(?=.{8,})(?=.*[a-z])(?=.*[A-Z])/", $NewPass))
        {
            if(preg_match("/[а-яёА-ЯЁ]+/u", $NewName))
            {
                if(preg_match("/(0000)|(1234)|(1456)/", $NewCode))
                {
                   if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+.[a-zA-Z.]{2,5}$/", $NewMail))
                   {
                   } else {echo "Uncorrected EMail"; echo '<br>';$proverka=false;}
                } else {echo "Uncorrected Code"; echo '<br>';$proverka=false;}
            } else {echo "Uncorrected Name"; echo '<br>';$proverka=false;}
        } else {echo "Uncorrected Password"; echo '<br>';$proverka=false;}
    } else {echo "Uncorrected Login"; echo '<br>';$proverka=false;}
    if (($NewType == "Guest" && $NewCode =="0000") || ($NewType=="User" && $NewCode=="1234") ||($NewType=="Admin" && $NewCode=="1456") )
    {
    } else {echo "Uncorrected Code"; echo '<br>';$proverka=false;}
    //Собираем все эл. почты пользователей
    $query="SELECT * FROM users WHERE mail= '".$NewMail."' OR login= '".$NewLogin."'";
    $sql1=mysql_query($query);
    $result = mysqli_query($con,$query) or die("Ошибка " . mysqli_error($con)); 
    if($result)
    {
        $rows=mysqli_num_rows($result); // количество полученных строк
    }
    if($rows>0)
    {
        $proverka = false;
    }
    //проверка на соответствие вводимой почты с существующей (находящейся в таблице)
    if($proverka == false)
    {
        echo "There is already a user with this mail or login".'<br>';
    }
        if ($proverka == true)  
        {
            $query = "INSERT INTO `users` (login, password, mail, name,type) VALUES ('$NewLogin','$NewPass','$NewMail','$NewName','$NewType')";
            $result = mysqli_query($con,$query) or die("Ошибка " . mysqli_error($con));
            require 'Z:\home\localhost\www\connectid.php';
            $stmt=$con->prepare("SELECT * FROM users where (login = :login OR mail = :mail) and password = :password");
            $stmt->bindParam(':login', $NewLogin);
            $stmt->bindParam(':mail', $NewMail); 
            $stmt->bindParam(':password', $NewPass);
            $col=$stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_OBJ);
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
}
?>
<div style="font-size: 120%; font-family: Verdana, Arial, Helvetica, sans-serif; padding: 70px"; align="center";>
<p style="border:2px solid;">Registration in the database <br></p> 
</div>
<div>
<form method="POST"   align="center"; >
<input style="border:2px solid;  width: 11%; height: 5%"; type="text" name="login" placeholder="Login" > <br><br>
<input style="border:2px solid;width: 11%; height: 5%;"; type="password" name="password" placeholder="Password (8 sign)"><br><br>
<input style="border:2px solid;width: 11%; height: 5%;";  type="text" name="name" placeholder="Name"> <br><br>
<input style="border:2px solid;width: 11%; height: 5%;"; type="text" name="Email" placeholder="Email"><br>
<p style=" font-family: Verdana, Arial, Helvetica, sans-serif;">Enter your type</p>
<select name="type[]" id="" align="center"; style="border:2px solid;  width: 11%; height: 5%">
<option value="Admin">Admin</option>
<option value="User">User</option>
<option value="Guest">Guest</option>
</select> <br>
<p style=" font-family: Verdana, Arial, Helvetica, sans-serif;">Enter your code</p>
<input style="border:2px solid;width: 11%; height: 5%;"; type="text" name="code" placeholder="0000 for guest"><br> <br>
<input type="submit"style="border:2px solid;  width: 11%; height: 5%; color:#4169E1" name="Get" value="Register" ><br><br>
</form>
</div>
