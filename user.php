<?PHP header("Content-Type: text/html; charset=utf-8");?>
<?php
if(isset($_GET['Exit'])) {
    header('Location: /main.php'); 
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
<div>
<br><br>
<form  method="POST">
<div style="float:left; margin-left:2%">

            <input type="submit" style="border:2px solid;  width: 100%; height: 5%; color:#4169E1;" name="Filming" value="Filming"><br><br>
            <input type="submit" style="border:2px solid;  width: 100%; height: 5%; color:#4169E1;"name="Book" value="Book"><br><br>
            <input type="submit" style="border:2px solid;  width: 100%; height: 5%; color:#4169E1;"name="Collection" value="Collection"><br><br>
            </div>
            <div style="float:right; margin-right:2%">
            <p align="center">Добавление</p>
            <!--- Добавление --->
            <input style="border:2px solid;  width: 100%; height: 5%;" type="text" name="year" placeholder="Год" > <br><br>
            <input style="border:2px solid;width: 100%; height: 5%;" type="text" name="name" placeholder="Название"><br><br>
            <input style="border:2px solid;width: 100%; height: 5%;"  type="text" name="type" placeholder="Тип"> <br><br>
            <input style="border:2px solid;width: 100%; height: 5%" type="text" name="coll" placeholder="Сборник/Книга"><br><br>
            <select name="table[]" id="" align="center"; style="border:2px solid;  width: 100%; height: 5%">
                <option value="film">Экранизация</option>
                <option value="book">Книга</option>
                <option value="col">Сборник</option>
            </select>
            <br><br><input type="submit"style="border:2px solid;  width: 50%; height: 5%; color:#4169E1;" align="center"; name="Add" value="Добавить"> <br><br>
            <input style="border:2px solid;  width: 100%; height: 5%;" type="text" name="id" placeholder="id" >
            <br><br><input type="submit" style="border:2px solid;  width: 50%; height: 5%; color:#4169E1;" name="Update" value="Изменить">
            <br><br><input type="submit" style="border:2px solid;  width: 50%; height: 5%; color:#4169E1;" name="Delete" value="Удалить">
            <!--- Поиск --->
            <p align="center">Поиск</p>
            <p align="center">Сборник</p>
            <select name="ekr[]" id="" align="center"; style="border:2px solid;  width: 100%; height: 5%">
                <option value="poh">Не важно</option>
                <option value="yes">Есть</option>
                <option value="no">Нет</option>
            </select>
            <p align="center">Жанр книги</p>
            <select name="typ[]" id="" align="center"; style="border:2px solid;  width: 100%; height: 5%;">
                <option value="poh">Не важно</option>
                <option value="Повесть">Повесть</option>
                <option value="Роман">Роман</option>
                <option value="Рассказ">Рассказ</option>
            </select>
            <p align="center">Тип экранизации</p>
            <select name="typf[]" id="" align="center"; style="border:2px solid;  width: 100%; height: 5%;">
                <option value="poh">Не важно</option>
                <option value="Сериал">Сериал</option>
                <option value="Фильм">Фильм</option>
                <option value="Мини-сериал">Мини-сериал</option>
            </select><br><br>
            <input style="border:2px solid;width: 100%; height: 5%;"; type="text" name="years" placeholder="Год начала" value="1950"><br><br> 
            <input style="border:2px solid;width: 100%; height: 5%;"; type="text" name="yearpo" placeholder="Год конца" value="2021">
            <br><br><input type="submit"  style="border:2px solid;  width: 100%; height: 5%; color:#4169E1;" name="FindBook" value="Найти книгу">
            <br><br><input type="submit" style="border:2px solid;  width: 100%; height: 5%; color:#4169E1;" name="FindFilm" value="Найти фильм">
            <br><br><input type="submit" style="border:2px solid;  width: 100%; height: 5%; color:#4169E1;" name="FindCol" value="Найти сборник">
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
if(isset($_POST['Filming'])) {
    Films($con);
}
if(isset($_POST['Book'])) {
    Book($con);
}
if(isset($_POST['Collection'])) {
    Collection($con);
}
if(isset($_POST['Add'])) {
    Add($con,$l);
}
if(isset($_POST['Update'])) {
    Update($con,$l);
}
if(isset($_POST['Delete'])) {
    Delete($con,$l);
}
if(isset($_POST['FindBook'])) {
    FindBook($con,$l);
 }
if(isset($_POST['FindFilm'])) {
    FindFilm($con,$l);
 }
if(isset($_POST['FindCol'])) {
    FindCol($con,$l);
 }
if(isset($_POST['Users'])) {
   User($con);
}
//функция вывода таблицы Filming
function Films($con)
{
    $s="SELECT filming.id,filming.year,filming.name_film,filming.type,book.name_book FROM filming left join book on filming.id_book = book.id order by filming.year";
$sql1=mysql_query($s);
$result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
if($result)
{
    $rows=mysqli_num_rows($result); // количество полученных строк
    $col=mysqli_num_fields($result);//количество столбцов
}
echo '<table border="1"><tr><th>id</th><th>Год</th><th>Название</th><th>Тип</th><th>Книга</th></tr>';//создание таблицы
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
//функция вывода таблицы Book
function Book($con)
{
    $s="SELECT book.id,book.year,book.name_book,book.type,count(filming.name_film),collection.name_col FROM book left join filming on book.id = filming.id_book left join collection on book.id_col = collection.id group by book.name_book";
    $sql1=mysql_query($s);
    $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
    if($result)
    {
        $rows=mysqli_num_rows($result); // количество полученных строк
        $col=mysqli_num_fields($result);//количество столбцов
    }
    echo '<table border="1"><tr><th>id</th><th>Год</th><th>Название</th><th>Тип</th><th>Количество экранизаций</th><th>Сборник</th></tr>';//создание таблицы
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
//функция вывода таблицы Country
function Collection($con)
{
$s="SELECT collection.id,collection.year,collection.name_col, count(book.name_book) FROM collection left join book on collection.id = book.id_col group by collection.name_col order by collection.year";
$sql1=mysql_query($s);
$result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
if($result)
{
    $rows=mysqli_num_rows($result); // количество полученных строк
    $col=mysqli_num_fields($result);//количество столбцов
}
echo '<table border="1"><tr><th>id</th><th>Год</th><th>Название</th><th>Количество книг</th></tr>';//создание таблицы
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
//добавить запись в таблицу
function Add($con,$l)
{
    $year=htmlspecialchars($_POST['year']);
    $nam=htmlspecialchars($_POST['name']);
    $typ=htmlspecialchars($_POST['type']);
    $coll=htmlspecialchars($_POST['coll']);
    foreach($_POST['table'] as $Select)
    {
        $w=$Select;
        
    }
    if($w=='film'){$v='filming';$p='book';$k='book';}
    if($w=='book'){$v='book';$p='col';$k='collection';}
    if($w=='col'){$v='collection';}
    $s="INSERT INTO ".$v."(year,name_".$w.") VALUES ('".$year."','".$nam."')";
    
    $sql1=mysql_query($s);
    $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
    if($typ){$s="update ".$v." set type='".$typ."' where name_".$w."='".$nam."' and year = '".$year."'";
        $sql1=mysql_query($s); $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); if($coll){
            $s="select id from ".$k." where name_".$p." = '" . $coll . "'";
            $sql1=mysql_query($s); $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));
            $row = mysqli_fetch_row($result);
            if($row){
                $s="update ".$v." left join ".$k." on ".$v.".id_".$p." = ".$k.".id set ".$v.".id_".$p." = '". $row[0] . "' where ".$v.".name_".$w."='".$nam."' and ".$v.".year = '".$year."'";
                $sql1=mysql_query($s); $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));
                }
                
        }}
        if($w=='film'){Films($con);}
    if($w=='book'){Book($con);}
    if($w=='col'){Collection($con);}
}
//обновить запись в таблице
function Update($con,$l)
{
    $year=htmlspecialchars($_POST['year']);
    $nam=htmlspecialchars($_POST['name']);
    $typ=htmlspecialchars($_POST['type']);
    $coll=htmlspecialchars($_POST['coll']);
    $id=htmlspecialchars($_POST['id']);
    foreach($_POST['table'] as $Select)
    {
        $w=$Select;
        
    }
    if($w=='film'){$v='filming';$p='book';$k='book';}
    if($w=='book'){$v='book';$p='col';$k='collection';}
    if($w=='col'){$v='collection';}
    if($year){$s="update ".$v." set year='".$year."' where id = '".$id."'";
    
    $sql1=mysql_query($s);
    $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); }
    if($nam){$s="update ".$v." set name_".$w."='".$nam."' where id = '".$id."'";
    
        $sql1=mysql_query($s);
        $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); }
    if($typ){$s="update ".$v." set type='".$typ."' where id = '".$id."'";
        $sql1=mysql_query($s); $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));}
    if($coll){
            $s="select id from ".$k." where name_".$p." = '" . $coll . "'";
            $sql1=mysql_query($s); $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));
            $row = mysqli_fetch_row($result);
            if($row){
                $s="update ".$v." left join ".$k." on ".$v.".id_".$p." = ".$k.".id set ".$v.".id_".$p." = '". $row[0] . "' where ".$v.".id='".$id."'";
                $sql1=mysql_query($s); $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));
                }
                
        }
        if($w=='film'){Films($con);}
    if($w=='book'){Book($con);}
    if($w=='col'){Collection($con);}
}
//Удаление записи из таблицы
function Delete($con,$l)
{
    $id=htmlspecialchars($_POST['id']);
    foreach($_POST['table'] as $Select)
    {
        $w=$Select;
    }
    if($w=='film'){$v='filming';$p='book';$k='book';}
    if($w=='book'){$v='book';$p='col';$k='collection';}
    if($w=='col'){$v='collection';}
    $s="DELETE FROM " . $v . " WHERE id='".$id."'";
    $sql1=mysql_query($s);
    $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con)); 
    if($w=='film'){Films($con);}
    if($w=='book'){Book($con);}
    if($w=='col'){Collection($con);}
}
//поиск по записям книг
function FindBook($con,$l)
{
    $proverka=true;
    $nam=htmlspecialchars($_POST['name']);
    $id=htmlspecialchars($_POST['id']);
    $a=htmlspecialchars($_POST['years']);
    $b=htmlspecialchars($_POST['yearpo']);
    foreach($_POST['table'] as $Select)
    {
        $w=$Select;
    }
    foreach($_POST['ekr'] as $Select)
    {
        $ek=$Select;
    }
    foreach($_POST['typ'] as $Select)
    {
        $t=$Select;
    }
    if (preg_match("/[0-9.]/", $a))
    {
    } else {$proverka=false;}
    if (preg_match("/[0-9.]/", $b))
    {
    } else {$proverka=false;}
    if ($proverka==true)
    {
    if($w=='film'){$v='filming';$p='book';$k='book';}
    if($w=='book'){$v='book';$p='col';$k='collection';}
    if($w=='col'){$v='collection';}
    if ($t == 'poh' and $ek == 'poh'){
        $s = "SELECT book.id,book.year,book.name_book,book.type,count(filming.name_film),collection.name_col FROM book left join filming on book.id = filming.id_book left join collection on book.id_col = collection.id   where ((book.year >= $a) and (book.year <= $b) and (book.name_book like '%".$nam."%')) group by book.name_book";
    }
    elseif($t == 'poh' and $ek == 'yes'){
        $s = "SELECT book.id,book.year,book.name_book,book.type,count(filming.name_film),collection.name_col  FROM book inner join filming on book.id = filming.id_book left join collection on book.id_col = collection.id where ((book.year >= $a) and (book.year <= $b) and (book.name_book like '%".$nam."%'))  group by book.name_book";
    }
    elseif($t == 'poh' and $ek == 'no'){
        $s = "SELECT book.id,book.year,book.name_book,book.type,count(filming.name_film),collection.name_col FROM book left join filming on book.id = filming.id_book left join collection on book.id_col = collection.id where ((book.year >= $a) and (book.year <= $b) and (filming.id_book is null) and (book.name_book like '%".$nam."%'))  group by book.name_book";
    }
    elseif ($t != 'poh' and $ek == 'no'){
        $s = "SELECT book.id,book.year,book.name_book,book.type,count(filming.name_film),collection.name_col FROM book left join filming on book.id = filming.id_book left join collection on book.id_col = collection.id where ((book.year >= $a) and (book.year <= $b) and (filming.id_book is null) and (book.type = '".$t."') and (book.name_book like '%".$nam."%'))  group by book.name_book";
    } 
    elseif ($t != 'poh' and $ek == 'yes'){
        $s = "SELECT book.id,book.year,book.name_book,book.type,count(filming.name_film),collection.name_col FROM book inner join filming on book.id = filming.id_book left join collection on book.id_col = collection.id   where ((book.year >= $a) and (book.year <= $b)  and (book.type = '".$t."') and (book.name_book like '%".$nam."%'))  group by book.name_book";
    }
    elseif ($t != 'poh' and $ek == 'poh'){
        $s = "SELECT book.id,book.year,book.name_book,book.type,count(filming.name_film),collection.name_col FROM book left join filming on book.id = filming.id_book left join collection on book.id_col = collection.id where ((book.year >= $a) and (book.year <= $b)  and (book.type =  '".$t."') and (book.name_book like '%".$nam."%'))  group by book.name_book";
    }
        $sql1=mysql_query($s);
    $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));
    if($result)
    {
        $rows=mysqli_num_rows($result); // количество полученных строк
        $col=mysqli_num_fields($result);//количество столбцов
    }
    echo '<table border="1"><tr><th>id</th><th>Год</th><th>Название</th><th>Тип</th><th>Количество экранизаций</th><th>Сборник</th></tr>';//создание таблицы
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

    
}
//Поиск по экранизациям
function FindFilm($con,$l)
{
    $proverka=true;
    $nam=htmlspecialchars($_POST['name']);
    $id=htmlspecialchars($_POST['id']);
    $a=htmlspecialchars($_POST['years']);
    $b=htmlspecialchars($_POST['yearpo']);
    foreach($_POST['typf'] as $Select)
    {
        $t=$Select;
    }
    if (preg_match("/[0-9.]/", $a))
    {
    } else {$proverka=false;}
    if (preg_match("/[0-9.]/", $b))
    {
    } else {$proverka=false;}
    if ($proverka===true){
    if ($t == 'poh'){
        $s = "SELECT filming.id,filming.year,filming.name_film,filming.type,book.name_book FROM filming left join book on filming.id_book = book.id where (((filming.year >= $a) and (filming.year <= $b) and (filming.name_film like '%".$nam."%')) or (filming.id = '".$id."')) order by filming.year";
    }
    elseif($t != 'poh'){
        $s = "SELECT filming.id,filming.year,filming.name_film,filming.type,book.name_book FROM filming left join book on filming.id_book = book.id where (((filming.year >= $a) and (filming.year <= $b) and (filming.type = '".$t."') and (filming.name_film like '%".$nam."%')) or (filming.id = '".$id."')) order by filming.year";
    }
    
        $sql1=mysql_query($s);
    $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));
    if($result)
    {
        $rows=mysqli_num_rows($result); // количество полученных строк
        $col=mysqli_num_fields($result);//количество столбцов
    }
    echo '<table border="1"><tr><th>id</th><th>Год</th><th>Название</th><th>Тип</th><th>Книга</th></tr>';//создание таблицы
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
    
}

function FindCol($con,$l)
{
    $proverka=true;
    $nam=htmlspecialchars($_POST['name']);
    $id=htmlspecialchars($_POST['id']);
    $a=htmlspecialchars($_POST['years']);
    $b=htmlspecialchars($_POST['yearpo']);
    if (preg_match("/[0-9.]/", $a))
    {
    } else {$proverka=false;}
    if (preg_match("/[0-9.]/", $b))
    {
    } else {$proverka=false;}
    if ($proverka===true){
    

        $s = "SELECT collection.id,collection.year,collection.name_col, count(book.name_book) FROM collection left join book on collection.id = book.id_col where ((collection.year >= $a) and (collection.year <= $b) and (collection.name_col like '%".$nam."%')) or collection.id = '".$id."' group by collection.name_col order by collection.year";

    
        $sql1=mysql_query($s);
    $result = mysqli_query($con,$s) or die("Ошибка " . mysqli_error($con));
    if($result)
    {
        $rows=mysqli_num_rows($result); // количество полученных строк
        $col=mysqli_num_fields($result);//количество столбцов
    }
    echo '<table border="1"><tr><th>id</th><th>Год</th><th>Название</th><th>Количество книг в сборнике</th></tr>';//создание таблицы
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

    
}
//открытие таблицы User
function User($con)
{
    $s1="SELECT * FROM `user`";
    $sql1=mysql_query($s1);
    $result = mysqli_query($con,$s1) or die("Ошибка " . mysqli_error($con)); 
    if($result)
    {
        $rows=mysqli_num_rows($result); // количество полученных строк
        $col=mysqli_num_fields($result);//количество столбцов
    }
    echo '<table border="1"><tr><th>Id</th><th>name</th><th>part</th><th>uhr</th><th>people</th></tr>';//создание таблицы
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
?>
    </div>
</html>
