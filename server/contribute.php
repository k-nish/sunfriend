<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<title>bbs</title>
</head>
<body class="text-center">
<?php
require_once("functions.php");
if(!empty($_POST["sentence"])){
	if(isset($_POST["sentence"])){
		if(!@$_SESSION["time"])$_SESSION["time"] = 1;
		$keyCheck=keyCheck($_POST["key"]);
		if($_SESSION['time'] < time() && $keyCheck){
			$name=convString($_POST["name"]);
			$sentence=convString($_POST["sentence"]);
			$key=$_POST["key"];
			date_default_timezone_set('Asia/Tokyo');
			$body="\n".date('Y/m/d A h:i:s')."\n".$name."\n".$sentence."\n".$key."\n";
			$fp=@fopen("./data.txt","a"); 
			flock($fp,LOCK_EX);
			fputs($fp,$body);
			fclose($fp);
			$time=time()+30;
			$_SESSION["time"] = $time;
			?>
			<br>
			<h3>投稿しました。</h3>
			<br>
			<br>
			<input type="button" class="btn btn-primary text-center" value="HOME" onClick="location.href='../bbs/'">
			<?php
		}
		else {
			if($_SESSION['time'] > time()){
				?>
				<br>
				<h3>連続投稿はできません。</h3>
				<?php
			}
			if(!$keyCheck){
				?>
				<br>
				<h3>パスワードが間違っています。</h3>
				<?php
			}
			?>
			<br>
			<br>
			<input type="button" class="btn btn-primary text-center" value="戻る" onClick="history.go(-1)">
			<?php
		}
	}
}
else{
	?>
	<div class="h3 text-center">
		<br>
		<br>
		<h3>内容が入力されていません。</h3>
		<br>
		<input type="button" class="btn btn-primary text-center" value="戻る" onClick="history.go(-1)">
	</div>
	<?php
}
?>
</body>
<?php 
copyright();
?>
</html>