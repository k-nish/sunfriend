<?php 
if (isset($_POST)&&!empty($_POST)) {
    if (($_POST['id'] == '1973')&&($_POST['passw'])=='netue') {
      header('Location: edit.php');
    }
}
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
              <a class="navbar-brand" href="check.php"><span class="strong-title"><i class="fa fa-sun-o"></i> 管理者ログインページ</span></a>
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

    <form action="edit.php" method="post">
      <div class="form-group">
          <h5>ID</h5>
            <div class="input-group">
              <input type="text" name="id" class="form-control"
                       id="validate-text" placeholder="ID" required>

              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
            
      </div>
      <div class="form-group">
              <h5>Password</h5>
                  <div class="input-group" data-validate="length" data-length="3">
                  <input type="text" class="form-control" name="pass" id="validate-length" placeholder="当ててみろ!" required>
                  <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
      </div>
      <button type="submit" href="edit.php" class="btn btn-primary col-xs-12" disabled>ログイン</button>
    </form>

      </div>

      <div class="col-md-8 content-margin-top">

        <div class="timeline-centered">

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