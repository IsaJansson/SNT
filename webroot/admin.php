<?php
/* including the important configuration file */
include(__DIR__.'/config.php');

$db = new CDatabase($eros['database']);
$user = new CUser($db); 
$success = true;
 
if(isset($_POST['btnLogout'])){ 
    $user->Logout(); 
    header('Location: home.php');
} 

if(!$user->IsAuthenticated()){ 
    if(isset($_POST['acronym'], $_POST['password'])){ 
       $success = $user->Login($_POST['acronym'], $_POST['password']);
         header('Location: home.php');
    } 
} 
if(!$success) 
{ 
    $output = "Du lyckades ej logga in."; 

} 

$output = $user->AuthentificationOutput(); 
 

$eros['title'] = "Logga in";  

$eros['main'] = <<<EOD
<br />
<form method=post>
<fieldset>
<legend><b>Login</b></legend> 
  <p><label>Användare:<br/><input type='text' name='acronym' value=''/></label></p> 
  <p><label>Lösenord:<br/><input type='text' name='password' value=''/></label></p> 
  <p><input type='submit' name='btnLogin' value='Login'/></p> 
  <p><input type='submit' name='btnLogout' value='Logout'/></p> 
  <output><b>{$output}</b></output> 
</fieldset>
</form>

EOD;

include(EROS_THEME_PATH);