<?php

include_once('lib/security.php');

$username = 'anonymous';
$user_id = '';
$isLogged = Security::is_logged(); 
if ($isLogged) {
    $user_id = Security::get_userid();
    $username = Security::get_username();
}

?>

<h1 >Hello <?php echo $username ?> <?php echo ($isLogged) ? 'with id '. $user_id : '' ; ?> </h1>