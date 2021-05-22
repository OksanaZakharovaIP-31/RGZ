<?PHP header("Content-Type: text/html; charset=utf-8");?>
<?php
if(isset($_POST['Back'])) {
    header('Location: /admin.php'); 
}
?>
<?php
session_start();
?>
<div style="border:2px solid;  width: 100%; height: 15%; color:#4169E1";> 
<p style="float:right; margin-right:2%">
<?php
echo "Пользователь:  ".$_SESSION['name'];
?>
</p>
<form  method="Get">
<br><br>
<input type="submit"style="border:2px solid;  width: 11%; height: 30%; color:#4169E1; margin-left:2%" name="Exit" value="Exit" ><br><br>
</form>
</div>
<br><br>
<form  method="POST">
<div style="float:left; margin-left:2%">

            <input type="submit" style="border:2px solid;  width: 100%; height: 5%; color:#4169E1;" name="Users" value="Users"><br><br>
            <input type="submit" style="border:2px solid;  width: 100%; height: 5%; color:#4169E1;" name="Back" value="Back"><br><br>
            </div>
            <div style="float:right; margin-right:2%">
            <p align="center">Добавление</p>
            <!--- Добавление --->
            <input style="border:2px solid;  width: 100%; height: 5%;" type="text" name="Login" placeholder="Login" > <br><br>
            <input style="border:2px solid;width: 100%; height: 5%;" type="password" name="Password" placeholder="Password"><br><br>
            <input style="border:2px solid;width: 100%; height: 5%;"  type="text" name="Name" placeholder="Name"> <br><br>
            <input style="border:2px solid;width: 100%; height: 5%" type="text" name="Mail" placeholder="Mail"><br><br>
            <select name="type[]" id="" align="center"; style="border:2px solid;  width: 100%; height: 5%">
                <option value="Admin">Admin</option>
                <option value="User">User</option>
                <option value="Guest">Guest</option>
            </select>
            <br><br><input type="submit"style="border:2px solid;  width: 50%; height: 5%; color:#4169E1;" align="center"; name="Add" value="Добавить"> <br><br>
            <input style="border:2px solid;  width: 100%; height: 5%;" type="text" name="id" placeholder="id" >
            <br><br><input type="submit" style="border:2px solid;  width: 50%; height: 5%; color:#4169E1;" name="Update" value="Изменить">
            <br><br><input type="submit" style="border:2px solid;  width: 50%; height: 5%; color:#4169E1;" name="Delete" value="Удалить">
            <!--- Поиск --->
            <p align="center">Поиск</p>
            <p align="center">Тип</p>
            <select name="typeUsser[]" id="" align="center"; style="border:2px solid;  width: 100%; height: 5%;">
                <option value="poh">Не важно</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
                <option value="Guest">Guest</option>
            </select><br><br>
            <input style="border:2px solid;width: 100%; height: 5%;"; type="text" name="Loginf" placeholder="Login"><br><br> 
            <input style="border:2px solid;width: 100%; height: 5%;"; type="text" name="Namef" placeholder="Name" >
            <br><br><input type="submit"  style="border:2px solid;  width: 100%; height: 5%; color:#4169E1;" name="FindUders" value="Найти пользователя">
            </div>
            </form>
    <br><br>
</div>
<html>
<div align="center">
    <?php
    //подключение к базе данных
    require 'Z:\home\localhost\www\connect.php';
//какая кнопка нажата
if(isset($_POST['Users'])) {
    Users($con);
}
if(isset($_POST['Add'])) {
    Add($con);
}
if(isset($_POST['Update'])) {
    Update($con);
}
if(isset($_POST['Delete'])) {
    Delete($con);
}
if(isset($_POST['FindUders'])) {
    FindUders($con);
}
function Users($con)
{
    $s="SELECT * FROM users";
    $sql1=mysql_query($s);
$result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
if($result)
{
    $rows=mysqli_num_rows($result); // количество полученных строк
    $col=mysqli_num_fields($result);//количество столбцов
}
echo '<table border="1"><tr><th>id</th><th>Login</th><th>Password</th><th>Mail</th><th>Name</th><th>Type</th></tr>';//создание таблицы
//вывод таблицы
for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);
        echo "<tr>";
            for ($j = 0 ; $j < $col ; ++$j) echo "<td>$row[$j]</td>";
        echo "</tr>";
    }
echo "</table>";
}
function Add($con)
{
    $NewLogin=htmlspecialchars($_POST['Login']);
    $NewPass=htmlspecialchars($_POST['Password']);
    $NewName=htmlspecialchars($_POST['Name']);
    $NewMail=htmlspecialchars($_POST['Mail']);
    foreach($_POST['type'] as $Select)
    {
        $NewType=$Select;  
    }
    //Проверка на правильность введнных данных
    $proverka=true;
    if (preg_match("/[a-zA-Z0-9._-]/", $NewLogin)) {
        if(preg_match("/(?=.{8,})(?=.*[a-z])(?=.*[A-Z])/", $NewPass))
        {
            if(preg_match("/[а-яёА-ЯЁ]+/u", $NewName))
            {
                   if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+.[a-zA-Z.]{2,5}$/", $NewMail))
                   {
                   } else {echo "Uncorrected EMail"; echo '<br>';$proverka=false;}
            } else {echo "Uncorrected Name"; echo '<br>';$proverka=false;}
        } else {echo "Uncorrected Password"; echo '<br>';$proverka=false;}
    } else {echo "Uncorrected Login"; echo '<br>';$proverka=false;}
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
            Users($con);
        }
}
function Delete($con)
{
    $id=htmlspecialchars($_POST['id']);
    $s="DELETE FROM `users` WHERE id='".$id."'";
    $sql1=mysql_query($s);
    $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));
    Users($con);
}
function FindUders($con)
{
    $NewLogin=htmlspecialchars($_POST['Loginf']);
    $NewName=htmlspecialchars($_POST['Namef']);
    foreach($_POST['typeUsser'] as $Select)
    {
        $NewType=$Select;  
    }
    if ($NewType == 'poh') 
    {
        $s="SELECT * FROM users where (login like '%".$NewLogin."%') and (name like '%".$NewName."%')";
    } else 
    {
        $s="SELECT * FROM users where ((login like '%".$NewLogin."%') and (name like '%".$NewName."%') and (type = '$NewType'))";
    }
    
    $sql1=mysql_query($s);
$result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
if($result)
{
    $rows=mysqli_num_rows($result); // количество полученных строк
    $col=mysqli_num_fields($result);//количество столбцов
}
echo '<table border="1"><tr><th>id</th><th>Login</th><th>Password</th><th>Mail</th><th>Name</th><th>Type</th></tr>';//создание таблицы
//вывод таблицы
for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);
        echo "<tr>";
            for ($j = 0 ; $j < $col ; ++$j) echo "<td>$row[$j]</td>";
        echo "</tr>";
    }
echo "</table>";
}
function Update($con)
{
    $NewLogin=htmlspecialchars($_POST['Login']);
    $NewPass=htmlspecialchars($_POST['Password']);
    $NewName=htmlspecialchars($_POST['Name']);
    $NewMail=htmlspecialchars($_POST['Mail']);
    foreach($_POST['type'] as $Select)
    {
        $NewType=$Select;  
    }
    $id=htmlspecialchars($_POST['id']);
    if($NewLogin){$s="update `users` set login = '$NewLogin' where id='$id'";$sql1=mysql_query($s);
        $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
    }
    if($NewPass){$s="update `users` set password = '$NewPass' where id='$id'";$sql1=mysql_query($s);
            $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));
    }
    if($NewName){$s="update `users` set name = '$NewName' where id='$id'";$sql1=mysql_query($s);
        $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
    }
    if($NewMail){$s="update `users` set mail = '$NewMail' where id='$id'";$sql1=mysql_query($s);
        $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
    }
    if($NewType){$s="update `users` set type = '$NewType' where id='$id'";$sql1=mysql_query($s);
        $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
    }
    Users($con);


}
?>
    </div>
</html>