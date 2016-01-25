<?php

  //echo 'POST送信された！';
  //データベースに接続
  // ステップ1.db接続
  $dsn = 'mysql:dbname=sunfriend;host=localhost';
    
  // 接続するためのユーザー情報
  $user = 'root';
  $password = '';

  // DB接続オブジェクトを作成
  $dbh = new PDO($dsn,$user,$password);

  // 接続したDBオブジェクトで文字コードutf8を使うように指定
  $dbh->query('SET NAMES utf8');

  //GET送信が行われたら編集処理を実行
   //$action = $_GET['action'];
   //var_dump($action);
  
  //id,editname,editcommentの定義
  $years = '';
  $result = '';
  $message = '';

  //編集ボタンが押されたら編集処理を行う
   //if(isset($_GET['action'])&& ($_GET['action'] == 'edit')){
    //echo $_GET['action'];
    // 編集したいデータを取得するSQL文を作成
    //$sq = 'SELECT * FROM `posts` WHERE `id`= '.$_GET['id'];
    //var_dump($sq);
    //SQL文を実行
    //$stmt=$dbh->prepare($sq);
    //$stmt->execute();
    //$rec = $stmt->fetch(PDO::FETCH_ASSOC);
    //$editname = $rec['nickname'];
    //$editcomment = $rec['comment'];
    //$id = $rec['id'];
    //echo $editname;
    //echo $editcomment;
   //}
  //ゴミ箱ボタンが押されたら削除処理を行う
   //if(isset($_GET['action'])&& ($_GET['action'] == 'delete')){
    //echo $_GET['action'];
    // 編集したいデータを取得するSQL文を作成
    //$sq = 'SELECT * FROM `posts` WHERE `id`= '.$_GET['id'];
    //$sq="DELETE FROM `posts` WHERE `id`=".$_GET['id'];
    //var_dump($sq);
    //SQL文を実行
    //$stmt=$dbh->prepare($sq);
    //$stmt->execute();
    //echo $editname;
    //echo $editcomment;
   //}
  //POST送信が行われたら、下記の処理を実行
  //テストコメント
  if(isset($_POST) && !empty($_POST)){
    //if(isset($_POST['update'])){
      //var_dump($_POST['id']);
      //echo "ok";
      //編集後データ入力SQL文
      //$sql = "UPDATE `posts` SET `nickname`='".$_POST['nickname']."',`comment`='".$_POST['comment']."',`created`=now() WHERE `id`=".$_POST['id'];
      //$sql = "UPDATE `posts` SET `nickname`= '".$_POST['nickname']."',`comment`= '".$_POST['comment']."',`created`=now() WHERE `id`=".$_POST['id'];
      //SQL文実行
      //$stmt=$dbh->prepare($sql);
      //$stmt->execute();
    //}else{
    //SQL文作成(INSERT文)
    //$sql = "INSERT INTO `posts`(`result`, `years`, `date`,'message') ";
    //$sql .="VALUES ('".$_POST['result']."','".$_POST['years']."',now(),'".$_POST['message']."')";
    $sql = "INSERT INTO `games`(`result`, `years`, `date`) ";
    $sql .="VALUES ('".$_POST['result']."','".$_POST['years']."',now())";
    
    var_dump($sql);
    //INSERT文実行
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
  //}
  }
  //SQL文作成(SELECT文)
  $sql = 'SELECT * FROM `games` ORDER BY `date` DESC';
  
  //SQL文実行
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $posts = array();

  //var_dump($stmt);
  while(1){

    //実行結果として得られたデータを表示
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if($rec == false){
      break;
    }

    $posts[]=$rec;
    // echo $rec['id'];
    // echo $rec['nickname'];
    // echo $rec['comment'];
    // echo $rec['created'];


  }
    //データベースから切断
    $dbh=null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>SunFriend掲示版!結果ページ!</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline.css">
  <link rel="stylesheet" href="assets/css/main.css">

</head>
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-sun-o"></i>SunFriend!掲示版!結果ページ!</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
<!--                   <li class="hidden">
                      <a href="#page-top"></a>
                  </li>
                  <li class="page-scroll">
                      <a href="#portfolio">Portfolio</a>
                  </li>
                  <li class="page-scroll">
                      <a href="#about">About</a>
                  </li>
                  <li class="page-scroll">
                      <a href="#contact">Contact</a>
                  </li> -->
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav> 
  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">

    <form action="kekka.php" method="post">
      <div class="form-group">
            <h5>学年</h5>
            <div class="input-group">
              <input type="text" name="years" class="form-control"
                       id="validate-text" placeholder="学年" value='<?php echo $years; ?>' required>

              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
            
      </div>
      <div class="form-group">
            <h5>結果(4文字以上入力してね)</h5>
            <div class="input-group" data-validate="length" data-length="4">  
              <textarea type="text" class="form-control" name="result" id="validate-length" placeholder="結果 ex.ファイナルイン!" required></textarea>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
      </div>
      <!--<?php if($editname == ''){ ?>-->
      <h5>実況投稿!</h5>
      <button type="submit"  name='report' class="btn btn-primary col-xs-12" disabled>実況する!</button>
      <!--<h5>応援ボタン!</h5>
      <button type="submit"  name='cheer' class="btn btn-primary col-xs-12" disabled>応援する!</button>
      <!--<?php }else{ ?>
      <input type="hidden" name="id" value="<?php echo $id?>">
      <button type="submit" name="update" class="btn btn-primary col-xs-12" disabled>応援する!</button>
      <?php } ?>-->
    </form>

      </div>
      <!--<h3>実況なう!</h3>-->
      <div class="col-md-8 content-margin-top">
        <!--<h3>実況なう!</h3>-->
        <div class="timeline-centered">
        <?php
        foreach ($posts as $post) { ?>

        <article class="timeline-entry">

            <div class="timeline-entry-inner">
                <!--<a href="bbspr2.php?action=edit&id=<?php echo $post['id'];?>">-->
                <div class="timeline-icon bg-success">
                    <i class="entypo-feather"></i>
                    <i class="fa fa-play-circle"></i>
                </div>

                <div class="timeline-label">
                    <h2><a href="#"><?php echo $post['years'];?></a> 
                      <?php
                          //一旦日時型に変換
                          $date = strtotime($post['date']);

                          //書式を変換
                          $date = date('Y/m/d',$date);                          
                      ?>

                      <span><?php echo $date;?></span>
                    </h2>
                    <p><Font size="4"><strong><?php echo $post['result'];?><strong></br>
                      <!--<a href="bbspr2.php?action=delete&id=<?php echo $post['id'];?>"><i class="fa fa-trash-o"></i></a>-->
                    </p>
                    
            </div>

        </article>

        <?php
        }
        ?>
        <article class="timeline-entry begin">

            <div class="timeline-entry-inner">

                <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                    <i class="entypo-flight"></i> +
                </div>

            </div>

        </article>

      </div>

    </div>
  </div>





  
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>

</body>
</html>



