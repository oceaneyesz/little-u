<?php
data_default_timezone_set('PRC');
$conn_hostname = 'localhost';
$conn_database = 'data list';
$conn_username = 'root';
$conn_password = 'root';
try{
  $pdo = new PDO('mysql:host='.$conn_hostname.';dbname='.$conn_database,$conn_username, $conn_password);
  $pdo->exec('SET NAMES UTF8');
}
catch(Exception $e){
  echo '<h1>Error of database-link!</h1>';
  return;
}
if(isset($_POST['action'])){
  if($_post['action']==='detail2'){
    if($_POST['user_name']!="'user_name'"&&$_POST['user_password']!="'user_password'")
    {
      $judge=1;}
      $sql="SELECT * FROM list_user WHERE `user_name`='".$_POST['user_name']."'";
    else{
      echo '用户名或密码不正确';
      return；;
    }