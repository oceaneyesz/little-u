<?php
ini_set('date.timezone','Asia/Shanghai');
$conn_hostname = 'localhost';
$conn_database = 'data_list';
$conn_username = 'root';
$conn_password = '';
try{
  $pdo = new PDO('mysql:host='.$conn_hostname.';dbname='.$conn_database,$conn_username, $conn_password);
  $pdo->exec('SET NAMES UTF8');
}
catch(Exception $e){
  echo '<h1>Error of database-link!</h1>';
  echo $e;
  return;
}
if(isset($_POST['action'])){

  if($_POST['action']==='detail'){
      
    if($_POST['user_name']!=""&&$_POST['user_password']!="")
    {
      $user_name=$_POST['user_name'];
      $user_password=$_POST['user_password'];
      $sql="SELECT * FROM list_user WHERE `user_name`='".$_POST['user_name']."'";
    }
    $res=$pdo->query($sql);
    $rowCount=$res->rowCount();
    if ($rowCount==0){
      $sql=$pdo->prepare('INSERT INTO list_user(`user_name`,`user_password`) VALUES(:user_name ,:user_password);');
      $sql->bindValue(':user_name',$_POST['user_name']);
      $sql->bindValue(':user_password',$_POST['user_password']);
      $execute_res=$sql->execute();
      if ($execute_res==true){
        $judge=1;
        $_SESSION['user_name']=$user_name;
        $sql=$pdo->prepare('SELECT * FROM list_user WHERE `user_name`=BINARY :user_name');
        $sql->bindValue(':user_name',$user_name);
        $sql->execute();
        $info=$sql->fetch(PDO::FETCH_ASSOC);
                  if($info === false) {
                          echo '<h1>404</h1>';
                          return;
                      }
                      else {
                          $_SESSION['user_id']=$info['id'];
                      }
                  }
              else{
                      $judge=3;
                  }
          }
          else{
              $judge=2;
          }
      }
      else $judge=-1;
  }

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script type="text/javascript" src="./detail.php"></script>
    <link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
        <title>备忘录</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script>
            var judge=0;//var 定义变量
            judge=<?php echo $judge?>;
            if (judge==1){
                alert("恭喜，注册成功！");
                judge=0;
                window.location.href="page1.html?id=<?php echo $info['id']; ?>"; 
            }
            if(judge==2){
                alert("该用户名已经被注册！");
                judge=0;
            }
            if(judge==3){
                alert("抱歉，注册失败");
                judge=0;
            }
            if(judge==-1){
                alert("内容不能为空！");
                judge=0;
            }
            var flag=0;
            function tip(x,y){
                if(document.getElementById(x).value==""){
                    document.querySelector(y).innerHTML="内容不能为空";
                }
                else {
                    document.querySelector(y).innerHTML="";
                }
               
                }
            
            function check(){
                if(flag==0||document.getElementById("user_name").value==""||document.getElementById("user_password").value==""){
                    alert("您的输入不合法，请检查无误再注册。");
                    return false;
                }
                else return true;
            }
        </script>
        </head>
        <style type="text/css">

    form.posi1
    {
    position:absolute;
    left:515px;
    top:290px;
    }
</style>
<style type="text/css">
  body {background-image:url("timgHHH6YA3L.jpg"); 
        background-size:1230px  600px;}
      </style>
<body>
      <form action="detail.php" method="post" class="posi1">
          <p><input type="text" placeholder="用户名" name="user_name"></p>
          <p><input type="password" placeholder="密码" name="user_password"></p>
          <button type="submit" class="btn btn-warning" style="font-size:150%;font-family:Microsoft YaHei;width:180px;height:40px;" name="action" value="detail" >registe!</button>
      </form>
   



  </body>
</html>