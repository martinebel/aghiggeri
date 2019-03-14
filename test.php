<?php
session_start();

   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < 10; $i++) {
       $randomString .= $characters[rand(0, $charactersLength - 1)];
   }
   $_SESSION['uid']= $randomString;
   $_SESSION['tipousuario']="1";
  //header('Location: index.php');exit();
  echo '<script>window.location.href="index.php";</script>';exit();
/*if (!isset($_SESSION['uid']))
 {
$_SESSION['uid']=generateSession();$_SESSION['tipousuario']="1";

}*/
?>
