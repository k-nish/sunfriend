<?php
try{
  require('db.php');

  $id ='';
  if (isset($_GET)&&!empty($_GET)) {
    $id = $_GET['id'];
  }
  
  $error = array();
  if(isset($_POST) && !empty($_POST)){
      if($_POST['key']=='sun'){
          $sql = sprintf('INSERT INTO `results`(`id`, `result`, `years`, `date`, `gameid`) 
              VALUES (null,"%s","%s",now(),"%d")',
              mysqli_real_escape_string($db,$_POST['result']),
              mysqli_real_escape_string($db,$_POST['years']),
              mysqli_real_escape_string($db,$_POST['id']));
          $stmt = mysqli_query($db,$sql) or die(mysqli_error($db));
          $id=$_POST['id'];
          header('Location: kekka.php?id='.$id);
      }elseif($_POST['key']!='sun'){
          $error['key'] = 'wrong';
          $id=$_POST['id'];
      }
  }

  $sql = sprintf('SELECT * FROM `results` WHERE gameid = "%d" ORDER BY `id` DESC',
    mysqli_real_escape_string($db,$id));
  $stmt = mysqli_query($db,$sql) or die(mysqli_error($db));
  $posts = array();
  while(1){
      $rec = mysqli_fetch_assoc($stmt);
      if($rec == false){
          break;
      }
      $posts[]=$rec;
  }

  $sq = sprintf('SELECT * FROM `names` WHERE gameid ="%d"',
    mysqli_real_escape_string($db,$id));
  $stmt = mysqli_query($db,$sq) or die(mysqli_error($db));
  $rec = mysqli_fetch_assoc($stmt);
  $name = $rec['gamename'];

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
              <a class="navbar-brand" href="bbs.php"><span class="strong-title"><i class="fa fa-sun-o"></i>
                SunFriend!実況掲示板!<?php echo htmlspecialchars($name,ENT_QUOTES,'UTF-8'); ?></span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                  <li class="hidden">
                      <a href="#page-top"></a>
                  </li>
                  <li class="page-scroll">
                      <a href="bbs.php">実況掲示板TOPへ</a>
                  </li>
                  <li class="page-scroll">
                      <a href="check.php">編集用ページへ</a>
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

    <form action="kekka.php?id=<?php echo $id ?>" method="post">
      <div class="form-group">
            <h5>学年(何か書いてね)</h5>
            <div class="input-group">
              <?php if (isset($error['key'])&&($error['key']=='wrong')) { ?>
                <input type="text" name="years" class="form-control"
                       id="validate-text" placeholder="学年" value="<?php echo htmlspecialchars($_POST['years'],ENT_QUOTES,'UTF-8'); ?>" required>
              <?php }else{ ?>
              <input type="text" name="years" class="form-control"
                       id="validate-text" placeholder="学年" required>
              <?php } ?>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
            
      </div>
      <div class="form-group">
            <h5>結果(何か入力してね)</h5>
            <div class="input-group" data-validate="length" data-length="1">  
              <?php if (isset($error['key'])&&($error['key']=='wrong')) { ?>
              <input type="text" class="form-control" name="result" id="validate-length" 
                  placeholder="結果 ex.ファイナルイン!" value="<?php echo htmlspecialchars($_POST['result'],ENT_QUOTES,'UTF-8'); ?>" required>
              <?php }else{ ?>
              <input type="text" class="form-control" name="result" id="validate-length" placeholder="結果 ex.ファイナルイン!" required>
              <?php } ?>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
      </div>
      <div class="form-group">
            <h5>投稿キー</h5>
            <div class="input-group">
              <input type="text" name="key" class="form-control"
                       id="validate-text" placeholder="今回もヒントは。。。。ないぜ" required>

              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
            <?php if(isset($error['key'])&&$error['key']=='wrong'){ ?>
            <p class="error">*正しい投稿キーを入れてください。</p>
            <?php } ?>
      </div>
      <h5>実況投稿!</h5>
      <input type="hidden" name="id" value=<?php echo $id; ?>>
      <button type="submit"  name='report' class="btn btn-primary col-xs-12" disabled>実況する!</button>
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
<?php }catch(Excepton $e){
  echo "サーバーエラーが生じております。sunfriend2016@gamil.comまでご連絡ください。";
} ?>

