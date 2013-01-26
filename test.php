<?php

// Live demo located at: http://p.unps.us/pass

$start = microtime(true);
echo "Demo of HashPass.php output is in verbose mode<br>\r\n";
echo "Required: password and number of iterations, example below: <br>\r\n";
echo "http://p.unps.us/pass/?pass=[somepassword]&i=[somenumber](optional)&salt=[anything can go here, use previous salt and previous pass to generate same hash - will always generate same hash with same pass and same salt]<br>\r\n";
$password = $_GET["pass"];
if (!isset($password)) die("Please enter a password");
$i = $_GET["i"];
if (!isset($i)) die("Please give me some iterations");
if (!is_numeric($i)) die("You might not be aware of this, but usually iterations are numbers.");
if ($i >= 51) die("Why are you trying to go so high? Your password is way more than secure after even one iteration<br> There's a limit of 50 iterations.");
if (empty($_GET['salt'])){
  $salt = '';
}else{
  $salt = $_GET['salt'];
}
echo "Your pass is: ".$password." and your iterations are: ".$i."\r\n<br>";
echo "sha1: ".hash("sha1", $password)."\r\n<br>";
echo "sha256: ".hash("sha256", $password)."\r\n<br>";
$hashpass = hashpass($password, $salt, $i);
echo "custom HashPass: ".$hashpass."\r\n<br>";
$newpass = explode("/", $hashpass);
echo "Your hash is: ".$newpass[0]." <br>Your salt is: ".$newpass[1]."<br>\r\n";
$total = microtime(true) - $start;
echo "execution time: ".$total." seconds";
?>
