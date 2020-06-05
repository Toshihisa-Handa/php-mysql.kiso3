<?php
//select2.phpを更新機能追加の為修正する前の段階のファイル（もうこれは使わない）



//1. DB接続します
try {
  //localhostの時はこれ。さくらの場合さくらのデータベースをいれる
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {//$eにエラー内容が入っている。
  exit('DBConnectError:'.$e->getMessage());//ここのDBConnectErrorはエラー時の文字表示の為、ここはなんでも良い。この項目２は基本idとpass以外コピペで覚えればOK
}


//2．データ登録SQL作成
//prepare("")の中にはmysqlのSQLで入力したINSERT文を入れて修正すれば良いイメージ
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();


//3．データ登録処理後（基本コピペ使用でOK)
$view='';
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);//エラーが起きたらエラーの2番目の配列から取ります。ここは考えず、これを使えばOK
                             // SQLEErrorの部分はエラー時出てくる文なのでなんでもOK
}else{
 //selectデータの数だけ自動でループしてくれる
 while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
  //  $view.='<p>'.$r['id'].$r['uname'].$r['uid'].$r['pass'].$r['flg'].$r['indate'].'</p>';
 
  $view.='<p>';
  // $view .='<a href="u_view.php? id='.$r["id"].'">';
  $view.=$r['indate'].":".$r['uname'];
  // $view.='</a>';
  //ここから更新
  $view.='  ';
  $view .='<a href="u_view.php? id='.$r["id"].'">';
  $view.='[更新]';
  $view.='</a>';
  //ここから下削除
  $view.='  ';
  $view .='<a href="delete.php? id='.$r["id"].'">';
  $view.='[削除]';
  $view.='</a>';
  $view.='</p>';



 }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>データ登録</h1>
  <a href="index.php">登録へ戻る</a>
 <p><?=$view?></p>
</body>
</html>