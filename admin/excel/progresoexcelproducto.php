<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agustin Ghiggeri</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .vertical-align-center {
            min-height: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-align : center;
            -webkit-align-items : center;
            -moz-box-align : center;
            -ms-flex-align : center;
            align-items : center;
        }
    </style>
</head>


  <body class="text-center">
  <div class="container">
      <div class="col-md-12">
          <div class="vertical-align-center">
              <div class="jumbotron" style="min-width:100%">
                <h2>Carga de Productos</h2>
    <div class="progress">
<div class="progress-bar" id="progressor" role="progressbar" aria-valuenow="0"
aria-valuemin="0" aria-valuemax="100" style="width:0%">
70%
</div>
</div>
    <p id="results"></p>
  </div>
</div>
</div>
</div>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script>
var es;
es = new EventSource('processexcelproducto.php');
//a message is received
es.addEventListener('message', function(e) {
  var result = JSON.parse( e.data );

  addLog(result.message);

  if(e.lastEventId == 'CLOSE') {
      addLog('Finalizado!');
      es.close();
      $("#results").append('<br><a href="../productos.php" class="btn btn-success">Volver</a>');
      $('.progress-bar').css('width', 100+'%').attr('aria-valuenow', 100);
      $('.progress-bar').html('100%');
  }
  else {
    $('.progress-bar').css('width', result.progress+'%').attr('aria-valuenow', result.progress);
    $('.progress-bar').html(result.progress  + "%");

  }
});

es.addEventListener('error', function(e) {
  addLog('Error occurred');
  $("#results").append('<br><a href="../productos.php" class="btn btn-warning">Volver</a>');
  es.close();
});

function addLog(message) {
    var r = document.getElementById('results');
    r.innerHTML = message + '<br>';
    //r.scrollTop = r.scrollHeight;
}
  </script>
</body>

</html>
