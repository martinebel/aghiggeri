  <?php
  include 'header.php';
  ?>
    <style>

body { 

  font-family: arial, sans-serif;
  line-height: 100%;
}

.steps{text-align:center;}

.steps  ul {
    margin: 0;
    padding: 0;
}
  .steps   li {
      font-size: 16px;
      position: relative;
      padding-right: 20px;
      display: inline-block;
      color: #999;
      line-height: 40px;
      padding-left: 60px; 
} 
      .steps li:last-child { padding-right: 0; }
      
      .normal:before {
        left: 0;
        top: 0;
        content: "";
        width: 40px;
        height:40px;
        font-weight: bold;
        margin-right: 15px;
        position: absolute;
        text-align: center;
        line-height: 38px;
        display: inline-block;
        border: 3px solid #e5e5e5;
         border-radius:100%;
        
      }
.is-active:before,.is-current:before {left: 0;
        top: 0;
        content: "";
        width: 40px;
        height:40px;
        font-weight: bold;
        margin-right: 15px;
        position: absolute;
        text-align: center;
        line-height: 38px;
        display: inline-block;
        border: 3px solid #e5e5e5;
         border-radius:100%; border-color: #69a53a; }
 .is-active  span:before { display: block; } 
      
      span:before {
          font-family: FontAwesome;
          font-style: normal;
          font-weight: normal;
          line-height: 1;
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;
          
          color: #fff;
          padding: 0;
         left: 0px;
    bottom: 0px;
    display: none;
    font-size: 30px;
    content: "\f00c";
    text-align: center;
    position: absolute;
    background: #69a53a;
    width: 40px;
    height: 40px;
    border: 3px solid #69a53a;
          
          border-radius:100%;
        }
</style>
    <div class="container" style=" padding-top: 20px;">
  <div class="steps">
  <ul>
    <li class="is-active"><span><a href="cart.php">Confirmar Pedido</a></span></li>
    <li class="is-current"><span>Datos del Cliente</span></li>
    <li class="normal"><span>Finalizado</span></li>
  </ul>
</div>
<hr>
<div class="row">
<?php
              $stmt = $dbh->prepare( "SELECT * from clientes where idcliente=".$_SESSION['clienteid']."");
 $stmt->execute();
    $result = $stmt->fetchAll(); 
      
foreach($result as $row)
    {
      $nombre=$row['razonsocial'];
      $cuit=$row['cuit'];
      $email=$row['email'];
      $direccion=$row['direccion'];
      $telefono=$row['telefono'];
    }
    echo '<div class="col-md-6 col-md-offset-3 col-xs-12">
<div class="panel panel-default">
  <div class="panel-body">
  <form method="POST" action="checkout-step4.php">
  <p><strong>'.$nombre.'</strong></p>
  <p>'.$direccion.'</p>
  <p>'.$telefono.'</p>
  <p>'.$email.'</p>
  <hr>
  <p>Si lo desea, puede agregar observaciones a su pedido</p>
  <p><input type="text" class="form-control" name="observaciones" placeholder="Observaciones"></p>
  <button type="submit" class="btn btn-success">Continuar <i class="fa fa-angle-right"></i></button>
  </form>
  </div>
  </div>
  </div>';
    
              ?>
</div>
      
          
        </div>
      
      <?php
  include 'footer.php';
  ?>
