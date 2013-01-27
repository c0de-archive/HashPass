HashPass
========

HashPass is my password hashing function to be used in my main site to handle login passwords. 
It is heavily commented, perhaps too commented but it explains everything.

Included files are: HashPass.php, test.php, and Readme.md

Currently this is only php, but it could easily be ported to different languages as long as they support: 
random number generation, Sha1-Sha512, seperating strings into arrays, and loops. 

Use would be something like: $newpass = hashpass($oldpass, $i, $salt); Where $oldpass is the only required option.
$i and $salt are number of iterations to go through the loop and the random seed to create the same hash, respectivly.

If $i is not specified, it will simply hash everything once. While secure in this state, 
it still has less entropy than using the loop two or more times. 

If $salt is not specified, it will generate a new one based on two large random numbers and store the sha256 result.
If you have a better salt generation method, feel free to bypass by including $salt which will not use the built in generator.

The function returns one value 129 bytes long. This is the combined final hash of the password and the salt.
It's seperated by a '/', so in php to seperate it would be like:

$newpass = explode('/', $newpass);

$newsalt = $newpass[1]; // The salt is always the second part of the array

$newpass = $newpass[0]; // The password is always the first part of the array

I have a live demo of the use of HashPass located at http://p.unps.us/pass Arguments are fed through the url using GET.
For example if I wanted to hash "worldsbestestpassword123", I would do http://p.unps.us/pass/?pass=worldsbestestpassword123
Continuing on from above, lets specify a number of iterations (hard limit of 50 on this demo): http://p.unps.us/pass/?pass=worldsbestestpassword123&i=4
One more argument is accepted, and that is salt. Previously generated salts ar 64 characters long, but anything will work there. 

------------------------------------
$myhashpass = hashpass('password', 10); will do lines 29-34, 10 times.

$myhashpass = hashpass('password', '', 'random info at any length can go here - needed for matching hashes'); will simply do lines 22-26.

$myhashpass = hashpass('password'); will do lines 14-26.

$myhashpass = hashpass(); will return "No password detected" error.

$myhashpass = hashpass(''); This is legal and will not return above error.

$myhashpass = hashpass(""); This is also legal and will not return above error.

$myhashpass = hashpass('password', -1); Negative numbers are ignored and treated as if no iterations are specified.
------------------

HashPass by David Todd is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
Please attribute to my domain: http://www.unps-gama.info and let me know of any improvements I can make!
