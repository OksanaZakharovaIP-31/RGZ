<?php
$server = 'localhost'; // имя сервера
$username = 'root'; // имя пользователя 
$database = 'king';
$password = 'h.5r3rJYwia7BGk';
$con=mysqli_connect($server, $username,$password, $database) //функция открытия соединения с севером базы данных
or die (mysqli_error()); // если подключение не открылось, отобразить описание ошибки
?>