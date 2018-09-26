 <?php
   //変数の定義
  $name = "名前";
  $comment = "コメント";
  $password = "パスワード";
  $datafile = 'mission_2-5-1_rin.txt';
  $fpa = fopen($datafile,'a');
  $file = file($datafile);
  $numberfile = 'mission_2-5-1_number_rin.txt';
  $fpnw_d = fopen($numberfile,'w');
  $numberfile_e = 'mission_2-5-1_number_e_rin.txt';
  $fpnw_e = fopen($numberfile_e,'w');
  $numberfile_n = 'mission_2-5-1_number_n_rin.txt';
  $fpnw_n = fopen($numberfile_n,'w');
  $date = date('Y/m/d/ H:i:s');
  $data_name = $_POST['name'];
  $data_comment = $_POST['comment'];
  $data_password = $_POST['password'];
  $data_password_d = $_POST['password_d'];
  $data_password_e = $_POST['password_e'];
  $editpassword = $_POST['passwordedit'];
  $data_number_d = $_POST['number_delete'];
  $data_number_e = $_POST['number_edit'];
  $data_number_n = $_POST['number_e'];

   //編集番号をファイルへ書き込む
  if(!empty($data_number_e)){
   $data_e = $data_number_e."<>".$data_password_e."<>";
   fwrite($fpnw_e,$data_e);
   fclose($fpnw_e);
  }
   //編集番号指定の行の名前とコメントを変数に代入
  if(!empty($data_number_e)){
   $contents = file('mission_2-5-1_rin.txt');  //ファイルを配列として
   $edits = file('mission_2-5-1_number_e_rin.txt');  //指定番号
   $edit = explode("<>",$edits[0]);
   $editnumber = $edit[0];
   $outnumber = $edit[0] - 1;
   $passworde = $edit[1];
   for($a = 0;$a < count($file);$a++){
    $newline = explode("<>",$file[$a]);
    $newpwd = $newline[4];
    $nmb = $newline[0];
    if(($editnumber == $nmb)&&($passworde == $newpwd)){  //二つの指定番号とパスワードが一致するとき
     $name = $newline[1];
     $comment = $newline[2];
     $password = $newline[4];
    }else if($editnumber == $nmb){
     echo "パスワードが違います。";
    }
   }
  }
   //内容を削除
  if(!empty($data_number_d) && ($data_password_d)){
   $data_d = $data_number_d."<>".$data_password_d."<>";
   fwrite($fpnw_d,$data_d);
   fclose($fpnw_d);
  }
  if(!empty($data_number_d) && ($data_password_d)){
   $contents = file('mission_2-5-1_rin.txt');  //入力ファイルを配列に代入
   $deletes = file('mission_2-5-1_number_rin.txt'); //削除ファイルを配列に代入
   $number = $data_number_d - 1;
   $delete = explode("<>",$deletes[0]); //削除の一行目の<>による配列
   $fpr = fopen('mission_2-5-1_rin.txt','r+');
   ftruncate($fpr,0);  //ファイルを空にする
   fseek($fpr,0);
   for($a = 0;$a < count($contents);$a++){
    $content = explode("<>",$contents[$a]); //入力ファイルの各行の<>による配列
    $pwd = $content[4];
    $pwd_d = $delete[1];
    if(($data_number_d == $content[0])&&($pwd == $pwd_d)){
     echo "削除番号は{$data_number_d}。";
     echo "入力番号は{$content[0]}。";
     echo "対象番号一致<br>";
     echo "入力パスワードは{$pwd}。";
     echo "削除パスワードは{$pwd_d}。";
     echo "パスワード一致。この行を削除しました。<br>";
    }else if($data_number_d == $content[0]){
     echo "パスワード違います。<br>";
     $b = $contents[$a];
     fwrite($fpr,$b);
    }else{ //指定番号以外のところをファイルへ書き込み
     $b = $contents[$a];
     fwrite($fpr,$b);
    }
   }
   fclose($fpr);
  }

  //内容を編集
 if(!empty($data_number_n)){
  $editdata = $data_number_n."<>".$editpassword."<>";
  fwrite($fpnw_n,$editdata);
  fclose($fpnw_n);
 }
 if(!empty($data_number_n) && ($data_name) && ($data_comment)){
  $dataname = $_POST['name'];
  $datacomment = $_POST['comment'];
  $datapassword = $_POST['password'];
  $date = date('Y/m/d/ H:i:s');
  $ns = file('mission_2-5-1_number_n_rin.txt');  //入力フォーム編集用ファイル
  $n = explode("<>",$ns[0]);
  $pwd_e = $n[1];
  $file = file('mission_2-5-1_rin.txt');
  $fpr = fopen('mission_2-5-1_rin.txt','r+');
  ftruncate($fpr,0);  //ファイルを空にする
  fseek($fpr,0);
  for($a = 0;$a < count($file);$a++){
   $newline = explode("<>",$file[$a]);
   $newpwd = $newline[4];
   $nmb = $newline[0];
   if(($nmb == $n[0])&&($pwd_e == $newpwd)){  //二つの指定番号とパスワードが一致するとき
    $number = $a + 1;
    $c = $number."<>".$dataname."<>".$datacomment."<>".$date."<>".$datapassword."<>"."\n";
    fwrite($fpr,$c);
   }else{ //指定番号以外のところをファイルへ書き込み
    $b = $file[$a];
    fwrite($fpr,$b);
   }
  }
  fclose($fpr);
 }else{
   //ファイルへ書きこみ
  if(!empty($data_name) && ($data_comment)){
   $num = count($file);
   $num ++;
   $arg = $num."<>".$data_name."<>".$data_comment."<>".$date."<>".$data_password."<>"."\n";
   fwrite($fpa,$arg);
   fclose($fpa);
  }
 }
 ?>
<!DOCTYPE html>
<html>
<body>
<!--入力フォーム-->
 <form method="post" action="mission_2-5-1_rin.php">
 <input type="text" name="name" value="<?php echo "$name"; ?>"  size="30"><br>
 <input type="text" name="comment" value="<?php echo "$comment"; ?>" size="30" ><br>
 <input type="text" name="password" value="<?php echo "$password"; ?>" size="30">
 <input type="hidden" name="number_e" value="<?php echo "$editnumber"; ?>" size="30">
 <input type="hidden" name="passwordedit" value="<?php echo "$passworde"; ?>" size="30">
 <input type="submit" value="送信"><br><br>
 </form>
<!--削除フォーム-->
 <form method="post" action="mission_2-5-1_rin.php">
 <input type="text" name="number_delete" value="削除対象番号" size="30"><br>
 <input type="text" name="password_d" value="パスワード" size="30">
 <input type="submit" value="削除"><br><br>
 </form>
<!--編集番号指定フォーム-->
 <form method="post" action="mission_2-5-1_rin.php">
 <input type="text" name="number_edit" value="編集対象番号" size="30"><br>
 <input type="text" name="password_e" value="パスワード" size="30">
 <input type="submit" value="編集"><br>
 </form>

<?php
  $contents = file('mission_2-5-1_rin.txt');
  foreach($contents as $value){    //ファイル($file)を一行ずつ($value)配列として認識
   $line = explode("<>",$value);   //一行($value)を<>で区切る($line)
   $count = count($line) - 1;
   for($i = 0;$i < $count;$i++){
    echo $line[$i]." ";
   }
   echo "<br />\n";
  }
?>
</body>


</html>