<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー管理</title>
</head>
<body>
  
<h1>ユーザー管理</h1>
<p><a href="select.php">一覧画面へ</a></p>

<form method='post' action="insert.php">
 ユーザー名：<input type="text" name='uname'>
 ユーザーID：<input type="text" name='uid'>
 Password：<input type="text" name='pass'>
 登録状況（入会中 or 退会）<input type="text" name='flg'>
 <input type="submit" value='送信'>



</form>
</body>
</html>