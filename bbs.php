<?php
try{
 require('db.php');

 $id = '';
 $name = '';
 $day = '';
 $key = '';
 $error = array();

 function h($value){
    return htmlspecialchars($value,ENT_QUOTES,'UTF-8');
}

 //編集するための編集元の情報を表示
 if(isset($_GET['action'])&& ($_GET['action']=='edit')) {
     $sql = sprintf('SELECT * FROM `names` WHERE gameid=%d',
          mysqli_real_escape_string($db,$_GET['id']));
     $stmt = mysqli_query($db,$sql) or die(mysqli_error($db));
     $rec = mysqli_fetch_assoc($stmt);
     $id = $rec['gameid'];
     $name = $rec['gamename'];
     $day = $rec['gameday'];
 }

 //投稿をinsert or 編集を記録
 if(isset($_POST)&&!empty($_POST)){
     if(isset($_POST['key']) && !empty($_POST['key'])){
         if ($_POST['key']=='sun') {
             if(isset($_POST['update'])){
                 $gname = mb_convert_kana($_POST['gamename'],'sa','UTF-8');
                 $sql = sprintf('UPDATE `names` SET `gamename`="%s",gameday=now() WHERE `gameid`="%d"',
                     mysqli_real_escape_string($db,$gname),
                     mysqli_real_escape_string($db,$_POST['id']));
                 $stmt = mysqli_query($db,$sql) or die(mysqli_error($db));
            }elseif(isset($_POST['gamename'])) {
                 //試合名の登録
                 $gname = mb_convert_kana($_POST['gamename'],'sa','UTF-8');
                 $sql = sprintf('INSERT INTO `names`(`gameid`, `gamename`, `gameday`) VALUES (null,"%s",now())',
                     mysqli_real_escape_string($db,$gname));
                 $stmt = mysqli_query($db,$sql) or die(mysqli_error($db));
                 //gameidの取得
                 $sq = 'SELECT `gameid` FROM `names` WHERE 1 ORDER BY `gameday` DESC';
                 $stm = mysqli_query($db,$sq) or die(mysqli_error($db));
                 $newid = mysqli_fetch_assoc($stm);
                 //最初の投稿を登録
                 $sqls = sprintf('INSERT INTO `results`SET `result`="%sの実況開始します!", `years`="sunfriend", `date`=now(), `gameid`=%d',
                         mysqli_real_escape_string($db,$gname),
                         mysqli_real_escape_string($db,$newid));
                 $stmtt = mysqli_query($db,$sqls) or die(mysqli_error($db));
                 header('Location: bbs.php');
            }
         }elseif($_POST['key']!='sun'){
             $error['key'] = 'wrong';
         }
      }
  }

  //試合名を取得
  $sun = array();
  $sql = 'SELECT * FROM `names` WHERE 1 ORDER BY `gameid` DESC';
  $stmt = mysqli_query($db,$sql) or die(mysqli_error($db));
    while (1) {
      $rec = mysqli_fetch_assoc($stmt);
      if ($rec == false) {
          break;
      }
       $sun[] = $rec;
    }

  //最新投稿を取得
  $re = array();
  $sq = 'SELECT `g1`.`result`,`g1`.`date`,`g1`.`gameid` FROM `results` as `g1` 
         WHERE `g1`.`date`=(SELECT MAX(`g2`.`date`) FROM `results` as `g2` WHERE `g2`.`gameid` = `g1`.`gameid`) ORDER BY `gameid` DESC';
  $stmt = mysqli_query($db,$sq) or die(mysqli_error($db));
  while (1) {
    $req = mysqli_fetch_assoc($stmt);
    if ($req == false) {
        break;
    }
    $re[] =$req;
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
  <link rel="shotcut icon"  href="assets/favicon.ico">

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
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-sun-o"></i> Sun Friend!実況掲示板!</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                  <li class="page-scroll">
                      <a href="bbs.php">実況掲示板TOPへ</a>
                  </li>
                  <li class="page-scroll">
                      <a href="check.php">編集用ページ</a>
                  </li>
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
              <?php if (isset($error['key'])&&$error['key']=='wrong'){ ?>
                <input type="text" name="gamename" class="form-control"
                       id="validate-text" placeholder="試合名 ex.団体戦vs東大トマトMD1" value="<?php echo h($_POST['gamename']); ?>" required>
              <?php }else{ ?>
                <input type="text" name="gamename" class="form-control"
                       id="validate-text" placeholder="試合名 ex.団体戦vs東大トマトMD1" value="<?php echo h($name); ?>" required>
              <?php } ?>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>

      </div>
      <div class="form-group">
              <h5>投稿キー</h5>
                  <div class="input-group" data-validate="length" data-length="3">
                  <input type="text" class="form-control" name="key" id="validate-length" placeholder="投稿キー  ヒントは...." required>
                  <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
                  <?php if(isset($error['key'])&&$error['key']=='wrong'){ ?>
                  <p class="error">*正しい投稿キーを入れてください。</p>
                  <?php } ?>
      </div>
      <?php if($name==''){ ?>
      <button type="submit"  class="btn btn-danger col-xs-12" disabled>投稿する</button>
      <?php }elseif($name != ''){?>
      <input type='hidden' name='id' value='<?php echo "$id";?>'>
      <button type="submit"  name='update' class="btn btn-danger col-xs-12" disabled>書き直す</button>
      <?php } ?>
      <br>
      <br>
      <p><a href="bbs.php?page=<?php echo "a"; ?>" class="btn btn-default">以前の投稿へ</a>
      <a href="bbs.php?page=<?php echo "b"; ?>" class="btn btn-default">最新の投稿へ</a></p>
      <!-- <ul class="paging">
      <button type="submit" name="page" class="btn btn-primary col-xs-4" disabled>
      <li><a href="bbs.php?page=<?php echo "a"; ?>" class="btn btn-default">以前の投稿へ</a></li>
      </ul> -->
    </form>


      </div>

      <div class="col-md-8 content-margin-top">
      <p><strong>青のボタンを押すと各試合の実況が見れます!<strong></p>
        <div class="timeline-centered">

        <?php foreach($sun as $post) { ?>
        <article class="timeline-entry">
            <div class="timeline-entry-inner">
                <a href="kekka.php?id=<?php echo $post['gameid']; ?>">
                <div class="timeline-icon bg-info">
                    <i class="entypo-feather"></i>
                    <i class="fa fa-play-circle"></i>
                </div>

                <div class="timeline-label">
                    <h2><a href="kekka.php?id=<?php echo h($post['gameid']); ?>"><?php echo h($post['gamename']); ?></a>
                      <?php
                          //一旦日時型に変換
                          $gameday = strtotime($post['gameday']);
                          //書式を変換
                          $gameday = date('Y/m/d',$gameday);
                      ?>
                      <span><?php echo h($gameday);?></span>
                      <a href="bbs.php?action=edit&id=<?php echo h($post['gameid']);?>"><i class="fa fa-pencil-square-o"></i>
                      <?php foreach ($re as $po ) {
                        if ($po['gameid'] == $post['gameid']) { ?>
                      <p><a href="kekka.php?id=<?php echo h($post['gameid']); ?>">最新投稿:<Font size="3"><strong><?php echo h($po['result']); ?><strong></p>
                      <?php } }?>
                    </h2>
                    <!--<a href="bbs.php?action=edit&id=<?php //echo $post['id'];?>"><i class="fa fa-pencil-square-o"></i>-->
                    <!--<p><?php //echo $post['comment'];?></br>
                      <a href="bbspr2.php?action=delete&id=<?php //echo $post['id'];?>"><i class="fa fa-trash-o"></i></a>
                    </p>-->
            </div>

        </article>
        <?php }  ?>
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