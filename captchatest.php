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
foreach ($_POST as $key => $value) {
    echo '<p><strong>' . $key.':</strong> '.$value.'</p>';
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
