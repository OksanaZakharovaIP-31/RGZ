<?php
if(isset($_POST['Get'])) {
    header('Location: /enter.php'); 
}
if(isset($_POST['New'])) {
    header('Location: /newuser.php'); 
}
?>
<div style="font-size: 120%; font-family: Verdana, Arial, Helvetica, sans-serif; padding: 70px"; align="center">
<img src="king.jpg" width="300" height="300">
<p style="border:2px solid; backgroud">Nice to see you! <br></p> 
</div>
<div style="border:2px solid">
<form method="POST"   align="center"; >
<br><br>
<input type="submit"style="border:2px solid;  width: 11%; height: 5%; color:#4169E1" name="New" value="Registration" ><br><br>
<input type="submit"style="border:2px solid;  width: 11%; height: 5%; color:#4169E1" name="Get" value="Enter" ><br><br>
</form>
</div>