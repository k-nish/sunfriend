<?php 
try{
 $dsn = 'mysql:dbname=sunfriend;host=localhost';
     
 // 接続するためのユーザー情報
 $user = 'root';
 $password = '';
 
 // DB接続オブジェクトを作成
 $dbh = new PDO($dsn,$user,$password);
 
 // 接続したDBオブジェクトで文字コードutf8を使うように指定
 $dbh->query('SET NAMES utf8');

 $id = '';
 $name = '';
 $day = '';
 $key = '';
 
 if(isset($_GET['action'])&& ($_GET['action']=='edit')) {
     $sql = 'SELECT * FROM `names` WHERE gameid='.$_GET['id'];
     $stmt=$dbh->prepare($sql);
     $stmt->execute();
     $rec = $stmt->fetch(PDO::FETCH_ASSOC);
     $id = $rec['gameid'];
     $name = $rec['gamename'];
     $day = $rec['gameday']; 
 }

 if(isset($_POST)&&!empty($_POST)){
  if(isset($_POST['key']) && !empty($_POST['key'])){
     if ($_POST['key']=='sun') {
         if(isset($_POST['update'])){
             $sql = 'UPDATE `names` SET `gamename`="'.$_POST['gamename'].'",gameday=now() WHERE `gameid`='.$_POST['id'];
             $stmt = $dbh->prepare($sql);
             $stmt -> execute();
          }elseif(isset($_POST['gamename'])) {
             $sql = 'INSERT INTO `names`(`gameid`, `gamename`, `gameday`) VALUES (null,"'.$_POST['gamename'].'",now())';
             $stmt=$dbh->prepare($sql);
             $stmt->execute();
             header('Location: bbs.php');
          }
      }
    }
  }

  $sun = array();
  $sql = 'SELECT * FROM `names` WHERE 1 ORDER BY `gameid` DESC';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
    while (1) {
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($rec == false) {
          break;
      }
       $sun[] = $rec; 
    }

  $dbh = null;

  ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>サンフレンド実況掲示板!</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline.css">
  <link rel="stylesheet" href="assets/css/main.css">

</head>
<body>
  <!-- <nav class="navbar navbar-default navbar-fixed-top"> -->
      <!-- <div class="container"> -->
          <!-- Brand and toggle get grouped for better mobile display -->
          <!-- <div class="navbar-header page-scroll"> -->
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button> 
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-sun-o"></i> 実況掲示板管理人編集ページ</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                  <!-- <li class="hidden">
                      <a href="bbs.php">実況掲示板TOPへ</a>
                  </li> -->
                  <li class="page-scroll">
                      <a href="bbs.php">実況掲示板TOPへ</a>
                  </li>
                  <li class="page-scroll">
                      <a href="check.php">編集用ページ</a>
                  </li>
                  <!-- <li class="page-scroll">
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

    <form action="bbs.php" method="post">
      <div class="form-group">
          <h5>試合名</h5>
            <div class="input-group">
              <input type="text" name="gamename" class="form-control"
                       id="validate-text" placeholder="試合名 ex.団体戦vs東大トマトMD1" value="<?php echo $name;?>" required>

              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
            
      </div>
      <div class="form-group">
              <h5>投稿キー</h5>
                  <div class="input-group" data-validate="length" data-length="3">
                  <textarea type="text" class="form-control" name="key" id="validate-length" placeholder="投稿キー　　ヒントは...." required></textarea>
                  <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
      </div>
      <?php if($name==''){ ?>
      <button type="submit"  class="btn btn-primary col-xs-12" disabled>投稿する</button>
      <?php }elseif($name != ''){?>
      <input type='hidden' name='id' value='<?php echo "$id";?>'>
      <button type="submit"  name='update' class="btn btn-primary col-xs-12" disabled>書き直す</button>
      <?php } ?>
    </form>

      </div>

      <div class="col-md-8 content-margin-top">

        <div class="timeline-centered">

        <?php
        foreach($sun as $post) { ?>

        <article class="timeline-entry">

            <div class="timeline-entry-inner">
                <a href="kekka.php?id=<?php echo $post['gameid']; ?>">
                <div class="timeline-icon bg-info">
                    <i class="entypo-feather"></i>
                    <i class="fa fa-play-circle"></i>
                </div>

                <div class="timeline-label">
                    <h2><a href="#"><?php echo $post['gamename']; ?></a> 
                      <?php
                          //一旦日時型に変換
                          $gameday = strtotime($post['gameday']);

                          //書式を変換
                          $gameday = date('Y/m/d',$gameday);                          
                      ?>

                      <span><?php echo $gameday;?></span>
                      <a href="bbs.php?action=edit&id=<?php echo $post['gameid'];?>"><i class="fa fa-pencil-square-o"></i>
                    </h2>
                    <!--<p><?php echo $post['comment'];?></br>-->
                      <a href="bbs.php?action=delete&id=<?php echo $post['gameid'];?>"><i class="fa fa-trash-o"></i></a>
                    <!-- </p> -->
                    
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
<?php }catch(Excepton $e){
  echo "サーバーエラーが生じております。sunfriend2016@gamil.comまでご連絡ください。";
} ?>