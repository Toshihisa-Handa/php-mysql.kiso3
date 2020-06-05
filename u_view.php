<?php
//select2.phpをコピペでスタート


//1.GETでidを取得
$id =$_GET['id'];
// echo $id;
// exit;


//2. DB接続します(ここコピペでOK。select2.phpの時と記載同じ)
try {
  //localhostの時はこれ。さくらの場合さくらのデータベースをいれる
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {//$eにエラー内容が入っている。
  exit('DBConnectError:'.$e->getMessage());//ここのDBConnectErrorはエラー時の文字表示の為、ここはなんでも良い。この項目２は基本idとpass以外コピペで覚えればOK
}


//3．データ登録SQL作成(今回はselect2.phpの一覧表示から1行だけ取り出す記述をする)
//prepare("")の中にはmysqlのSQLで入力したINSERT文を入れて修正すれば良いイメージ
$sql = "SELECT * FROM gs_user_table WHERE id=:id";//この1行select2.phpから修正
$stmt = $pdo->prepare($sql);//select2.phpで元々あった()内の記述を修正し、変数sqlへ格納したものを（）内に記述
$stmt->bindValue('id', $id, PDO::PARAM_INT);//ここの記述はselect.phpにない部分！
$status = $stmt->execute();


//4．データ登録処理後（elseより手前はselect2.phpと同じ）
$view='';
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);//エラーが起きたらエラーの2番目の配列から取ります。ここは考えず、これを使えばOK
                             // SQLEErrorの部分はエラー時出てくる文なのでなんでもOK
}else{//ここより下は修正している↓
 //1データのみ抽出の為,select2.phpであったwhile文を削除。ここで$rowを定義
$row = $stmt->fetch();
}

//以下のhtmlタグ内の記述は見た目のレイアウトを合わせると良いため、基本index2.phpをコピペする。
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー管理</title>
</head>
<body>
  
<h1>ユーザー管理</h1>
<p><a href="select.php">一覧画面へ</a></p>

<form method='post' action="update.php">
 ユーザー名：<input type="text" name='uname' value='<?=$row["uname"]?>'>
 ユーザーID：<input type="text" name='uid' value='<?=$row["uid"]?>'>
 Password：<input type="text" name='pass' value='<?=$row["pass"]?>'>
 登録状況（入会中 or 退会）<input type="text" name='flg' value='<?=$row["flg"]?>'>
 <input type="hidden" name='id' value="<?=$row["id"]?>">
 <input type="submit" value='送信'>



</form>
</body>
</html>


