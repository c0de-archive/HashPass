<?php
/* HashPass() function takes $plaintext, $salt and $i (number of iterations) as inputs and outputs $hashpass - $salt and $i are optional
 * Copyright David Todd (C) 2012 
 * http://www.unps-gama.info
 * This work is licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License. 
 * To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 * If no $salt provided, generate large int and output $hashpass and $salt
 * If no $i (number of iterations) provided, go through once and return - not as secure as using iterations, but chances are low it will get cracked easily
 * If no $plaintext provided, die with error message saved to error variable
 */

function hashpass($plaintext, $salt, $i){
    if($plaintext == null) die("No password detected"); // Append error into common error string for parsing later
    $plaintext = hash("sha1", $plaintext); // First step - get plaintext sha1
    if($salt == null || $salt == ''){
        $salt =  mt_rand(10000, 20000); // Generate random number between 1000 and 20000
        $salt = hash("sha1", $salt); // Get sha1 hash of random number
        $salt = $salt.mt_rand(5000, 80000); // Append new random number between 5000 and 80000 to md5 salt
        $salt = hash("sha256", $salt); // Take a sha256 hash of new salt and done with salt generation
    }
    if($i ==null || $i == ''){
        $plaintext = hash("sha256", $plaintext.$salt); // Take first sha256 hash of $plaintext+$salt (64 bits)
        $plaintext = hash("sha1", $salt.$plaintext.$salt); // Take sha1 of salt+plaintext+salt (32 bits)
        $plaintext = hash("sha512", $salt.$plaintext.$salt.$salt.$plaintext.$salt); // Take sha512 of this (128bits)
        $hashpass = hash("sha256", $plaintext); // final hash is sha256 of the sha512 above (back down to 64bits)
        return $hashpass."/".$salt; // Give calling script the hashed password and salt, seperate strings with "/" to be exploded into array later
    }else{
        $il = '';
        while($il < $i){
            $plaintext = hash("sha256", $plaintext.$salt); // Take first sha256 hash of $plaintext+$salt (64 bits)
            $plaintext = hash("sha1", $salt.$plaintext.$salt); // Take sha1 of salt+plaintext+salt (32 bits)
            $plaintext = hash("sha512", $salt.$plaintext.$salt.$salt.$plaintext.$salt); // Take sha512 of this (128bits)
            $il++;
            //echo "Iteration: $il Password: $plaintext\r\n"; - This line is uncommented in the demo
        }
        $hashpass = hash("sha256", $plaintext); // final hash is sha256 of the sha512 above (back down to 64bits)
        return $hashpass."/".$salt; // Give calling script the hashed password and salt, seperate strings with "/" to be exploded into array later
    }
}
?>
