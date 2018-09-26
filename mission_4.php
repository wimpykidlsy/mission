<?php
 //sql接続
 $dsn = 'データベース名';
 $user_dsn = 'ユーザー名';
 $password_dsn = 'パスワード';
 //データベースへ接続
 try{
  $pdo = new PDO($dsn,$user_dsn,$password_dsn);
  $pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 }catch(PDOException $e){
  echo $sql."<br>".$e -> getMessage();
 }
 echo "<br>";
 //変数定義
 $data_name = $_POST['name'];
 $data_comment = $_POST['comment'];
 $data_password = $_POST['password'];
 $data_date = date('Y/m/d H:i:s');
 $data_number_delete = $_POST['deletenumber']; //削除対象番号
 $data_password_delete = $_POST['password_delete']; //削除パスワード
 $data_number_edit = $_POST['editnumber'];  //編集対象番号
 $data_password_edit = $_POST['password_edit'];  //編集パスワード
 $data_number_e = $_POST['number_e']; //入力フォームに代入する編集番号
 $number_e = "";  //入力フォームの編集対象番号欄に出力される
 //編集する
 if(!empty($data_number_edit) && ($data_password_edit)){ //編集の欄が空欄でない
  try{ //同じ番号のパスワードを取得する
   $select = $pdo -> query("select pwd from mission where number = $data_number_edit");
   $result_select = $select -> fetch();
   $password_select = $result_select['pwd'].PHP_EOL;
   echo "pwd = {$password_select}";
  }catch(PDOException $e){
   echo $sql."<br>".$e -> getMessage();
  }
  if($password_edit == $password_select){
   echo "パスワードが一致"."<br>";
   $number_e = $data_number_edit;
   echo "編集対象番号は{$number_e}";
  }
 }
 if(!empty($data_number_e)){
  try{
  $newdata = "update mission set name = '$data_name', comment = '$data_comment', day = '$data_date', pwd = '$data_password' where number = '$data_number_e'";
  $result_newdata = $pdo -> query($newdata);
  }catch(PDOException $e){
   echo $sql."<br>".$e -> getMessage();
  }
 //入力されたデータをデータベースへ挿入
 }else if(!empty($data_name) && ($data_comment) && ($data_password)){
   try{
   $select = 'select * from mission';
   $stmt = $pdo -> query($select);
   $stmt -> execute();
   $number = $stmt ->rowCount();
   $number ++;
   $import = $pdo -> prepare("INSERT INTO mission(number,name,comment,day,pwd)VALUES(:number,:name,:comment,:day,:pwd)");
   $import -> bindParam(':number',$number);
   $import -> bindParam(':name',$data_name);
   $import -> bindParam(':comment',$data_comment);
   $import -> bindParam(':day',$data_date);
   $import -> bindParam(':pwd',$data_password);
   $import -> execute();
  }catch(PDOException $e){
   echo $sql."<br>".$e -> getMessage();
  }
 }
 if(!empty($data_number_delete)){
  try{
   $delete = "delete from mission where number = $data_number_delete";
   $result_deletedata = $pdo -> query($delete);
  }catch(PDOException $e){
   echo $sql."<br>".$e -> getMessage();
  }
 }
  
?>
<html>
<body>
 <!-- 入力フォーム -->
 <form method="post" action="mission_4-1_rin.php">
 <input type="text" name="name" value="名前" size="30"><br>
 <input type="text" name="comment" value="コメント" size="30"><br>
 <input type="text" name="password" value="パスワード" size="30">
 <input type="text" name="number_e" value="<?php echo "$number_e"; ?>" size="30">
 <input type="submit" value="送信"><br>
 </form>

 <!-- 削除フォーム -->
 <form method="post" action="mission_4-1_rin.php">
 <input type="text" name="deletenumber" value="削除対象番号" size="30"><br>
 <input type="text" name="password_delete" value="パスワード" size="30">
 <input type="submit" value="削除"><br>
 </form>

 <!-- 編集番号指定フォーム -->
 <form method="post" action="mission_4-1_rin.php">
 <input type="text" name="editnumber" value="編集対象番号" size="30"><br>
 <input type="text" name="password_edit" value="パスワード" size="30">
 <input type="submit" value="編集"><br>
 </form>

</body>
<?php
 $select = 'SELECT * FROM mission';
 $results_data_content = $pdo -> query($select);
 foreach($results_data_content as $row_dc){
  echo $row_dc['number'].',';
  echo $row_dc['name'].',';
  echo $row_dc['comment'].',';
  echo $row_dc['day'].',';
  echo $row_dc['pwd'].'<br>';
 }
?>

</html>
