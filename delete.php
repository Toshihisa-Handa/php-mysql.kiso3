<?php 
include('funcs.php')


?>


<?php
//記述のベースはupdate.phpをコピペで作成


//1. POSTデータ取得
$id = $_GET['id'];


//2. DB接続します(insert.phpをまるコピのままでOK)
try {
  //localhostの時はこれ。さくらの場合さくらのデータベースをいれる
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {//$eにエラー内容が入っている。
  exit('DBConnectError:'.$e->getMessage());//ここのDBConnectErrorはエラー時の文字表示の為、ここはなんでも良い。この項目２は基本idとpass以外コピペで覚えればOK
}


//３．データ登録SQL作成
//3-1: sql作る処理(追記部分)
//基本の書き方：DELETE FROM テーブル名;
$sql = 'DELETE FROM gs_user_table WHERE id=:id';
//prepare("")の中にはmysqlのSQLで入力したINSERT文を入れて修正すれば良いイメージ

//3-2: sql文をstmtに渡す処理
$stmt = $pdo->prepare($sql);

//3-3: 関連付けをして、nameやemailを3-1の同じ文字に紐付ける
$stmt->bindValue(':id', h($id), PDO::PARAM_INT); //ここの：idは3-1の:idと同じ

//3-4: 最後に実行する
$status = $stmt->execute();//このexecuteで上で処理した内容を実行している



//４．データ登録処理後（基本コピペ使用でOK)
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);//エラーが起きたらエラーの2番目の配列から取ります。ここは考えず、これを使えばOK
                             // SQLEErrorの部分はエラー時出てくる文なのでなんでもOK
}else{//この項目以下の遷移先のみ変更↓
  //５．select2.phpへリダイレクト(エラーがなければindex.phpt)
  header('Location: select.php');//Location:の後ろの半角スペースは必ず入れる。
  exit;
//このdelete.phpが表示されるのはエラーの時のみ。更新が順調に完了した場合select2.phpへ移動する
}
?>
