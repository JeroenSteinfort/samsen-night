<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 22/12/2016
 * Time: 09:43
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src='https://www.google.com/recaptcha/api.js?hl=nl'></script>

</head>


<body>
<?php
if(isset($_POST['g-recaptcha-response'])&&$_POST['g-recaptcha-response']){

$secret = "6Ld2cQ8UAAAAAFiJ3Nr7cJMb0bpDbkX4F8K-EtJH";
$ip = $_SERVER['REMOTE_ADDR'];
$captcha = $_POST['g-recaptcha-response'];
$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip$ip");
$arr = json_decode($rsp,TRUE);
if($arr['success']){
echo "ongewensten met een afrikaanse emigratie achtergrond";

}
}
?>
<form action="" method="POST">

    <label for="name">Name:</label>
    <input name="name" required><br />

    <label for="email">Email:</label>
    <input name="email" type="email" required><br />

    <div class="g-recaptcha" data-sitekey="6Ld2cQ8UAAAAAP1Tg9tRgFhkU14XDHW77r0Hzx9H"></div>

    <input type="Submit" value="Submit" />

</form>
<!--js-->
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>
