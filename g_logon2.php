<?php
// セッション開始
session_start();

// パラメータ受け取り
$user = htmlspecialchars($_POST['user'], ENT_QUOTES);
$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES);

// データベース初期化
require_once("db_init.php");

// ◎ 認証処理 ◎
$ps = $db->query("SELECT pas FROM table2 WHERE id='$user'");
if($ps->rowCount() > 0){
  // user と一致する id がある場合
  $r = $ps->fetch();
  if($r['pas'] === md5($pass)){
    // pass と パスワードが一致する場合
    
    // TODO: パスワードは salt を付けた処理にアップグレードしたい
    $_SESSION['us'] = $user;
    
    // BODY 内容の決定
    $body =<<<EOD
  <p>ようこそ愛鳥獣写真館 momoへ！</p>
  <p><a href='g.php'>ここをクリックして一覧表示にどうぞ</a></p>
EOD;
  }else{
    // パスワードが違う
    
    session_destroy();
    
    // BODY 内容の決定
    $body =<<<EOD
  <p>パスワードが違います</p>
  <p><a href='g_logon.html'>ログオン</a></p>
EOD;
  }
  
}else{
  // user が違う
  
  session_destroy();

  // BODY 内容の決定
  $body =<<<EOD
  <p>ユーザーが登録されていません</p>
  <p><a href='g_logon.html'>ログオン画面へ</a></p>
EOD;
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ようこそ愛鳥獣写真館 momoへ！</title>
</head>

<body>
{$body}
</body>
</html>