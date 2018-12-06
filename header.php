<?php require 'db.php';

echo '<p style="display:none">'.date('Y-m-d_H:i:s').'</p>';
session_start();

include_once 'functions.php';
$funciones = new Funciones();

 function generateSession()
 {
	  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
 }


 if( !isset($_SESSION['uid']) ){$_SESSION['uid']=generateSession();$_SESSION['tipousuario']="1";}

 /*echo "uid:". $_SESSION['uid']."\n";
echo "id:" .session_id();*/

     if(isset($_POST['action']))
  {
	  if($_POST['action']=="refreshCart"){
      $stmt=$dbh->prepare("select * from temp_pedidos_header where clave='".$_SESSION['uid']."'");
   $stmt->execute();
   $result2 = $stmt->fetchAll();
    foreach($result2 as $row2)
    {
      $idpedido=$row2["idpedido"];
    }

	  //actualizar cantidad en el carrito
	  $items=$_POST['codigo'];
	$codigoarray=array();
	foreach($items as $aux)
	{
		array_push($codigoarray,$aux);
	}

	//prodescripcion
	$cant=$_POST['cant'];
	$cantarray=array();
	foreach($cant as $aux)
	{
		array_push($cantarray,$aux);
	}

	$i=0;
	foreach($codigoarray as $key)
{
	$stmt = $dbh->prepare("update temp_pedidos set cant=".$cantarray[$i]." where itemno=".$key." and id='".$idpedido."'");
        $stmt->execute();
	$i++;
}
$stmt=$dbh->prepare("update temp_pedidos_header set total='".$funciones->getTotalTempPedido($_SESSION['uid'],$_SESSION['tipousuario'])."' where idpedido=".$idpedido);
    $stmt->execute();

  }
  }

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Agustin Ghiggeri Distribuidor de Autopiezas - Av. 25 de Mayo 1164, Rcia Chaco - Llámanos ahora: 0362 - 4433100 - Whatsapp: 0362-155240760 -  Email: ventas@agustinghiggeri.com.ar">
    <meta name="author" content="Agustin Ghiggeri">
	<meta property="og:type" content="website" />
<meta property="og:image" content="http://www.agustinghiggeri.com/logo.png" />
<meta property="og:title" content="Agustin Ghiggeri" />
<meta property="og:description" content="Agustin Ghiggeri Distribuidor de Autopiezas - Av. 25 de Mayo 1164, Rcia Chaco - Llámanos ahora: 0362 - 4433100 - Whatsapp: 0362-155240760 -  Email: ventas@agustinghiggeri.com.ar" />
<meta property="og:site_name" content="Agustin Ghiggeri" />
	<link rel="shortcut icon" type="image/png" href="./favicon.png"/>

    <title>Agustin Ghiggeri</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css?version=0311" rel="stylesheet">

    <!-- Custom CSS -->

	 <link href="css/topBar.css?version=0612" rel="stylesheet">
	  <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
	  <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
	  <link rel="stylesheet" type="text/css" href="css/sidemenu.css">
	  <link href="css/jquery-ui.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!--=========-TOP_BAR============-->
  <nav class="topBar">
    <div class="container">
      <ul class="list-inline pull-left hidden-sm hidden-xs">
        <li><span class="text-primary"><i class="fa fa-phone" aria-hidden="true"></i> Atención al Cliente </span>0362 – 4433100 - 4451555</li>
      </ul>
      <ul class="topBarNav pull-right">

        <li class="dropdown">
		<?php
		//contar items del carrito
		$stmt = $dbh->prepare("select productos.*,temp_pedidos.itemno,temp_pedidos.cant from temp_pedidos_header inner join temp_pedidos on temp_pedidos.id=temp_pedidos_header.idpedido inner join productos on productos.id=temp_pedidos.idproducto where temp_pedidos_header.clave='".$_SESSION['uid']."'");
        $stmt->execute();
		$result = $stmt->fetchAll();
		$totalitems=$stmt->rowCount();
		?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false"> <i class="fa fa-shopping-basket mr-5"></i> <span class="hidden-xs">
                                Carrito<sup id="totalitems" class="text-primary">(<?php echo $totalitems;?>)</sup>
                                <i class="fa fa-angle-down ml-5"></i>
                            </span> </a>
          <ul class="dropdown-menu cart w-250" role="menu">
            <li>
              <div class="cart-items">
                <ol class="items">
                 <?php
				 //traer detalle del carrito
				 if($totalitems==0){echo '<li> <div class="product-details"><p class="product-name">No hay productos!</p></div></li>';}
		foreach($result as $row)
		{
			echo '<li  id="cart'.$row['itemno'].'">
                    <a href="#" class="product-image">';
                    if(!empty($row["imagen"]))
      {
        $path_parts = pathinfo('./img/p/'.$row['imagen']);
        $file=$path_parts['filename'];
        //probar si existe con extension mayuscula
        $ext = strtoupper($path_parts['extension']);
        if(file_exists('./img/p/'.$file.".".$ext))
        {
          echo '<img src="./img/p/'.$file.".".$ext.'" onerror="this.src=\'default.jpeg\';"  class="img-responsive" />';
        }
        elseif(file_exists('./img/p/'.$file.".".strtolower($ext)))
        {
          echo '<img src="./img/p/'.$file.".".strtolower($ext).'" onerror="this.src=\'default.jpeg\';" class="img-responsive" />';
        }
        else
      {
        echo '<img src="default.jpeg"  class="img-responsive" />';
      }
      }
      else
      {
        echo '<img src="default.jpeg"  class="img-responsive" />';
      }

                     echo '</a>
                    <div class="product-details">
                      <div class="close-icon"> <a href="#" onclick="removeCart('.$row['itemno'].');"><i class="fa fa-close"></i></a> </div>
                      <p class="product-name"> <a href="detalle.php?id='.$row['id'].'">'.$row['cant'].' x '.$row['nombre'].'</a> </p>  <span class="price text-primary">$'.number_format($funciones->getPrecioCant($row['id'],$_SESSION['tipousuario'],$row['cant'])*$row['cant'],2).'</span> </div>

                  </li>';
		}
				 ?>


                </ol>
              </div>
            </li>
            <li>
              <div class="cart-footer"> <a href="cart.php" ><i class="fa fa-cart-plus mr-5"></i>Ver Carrito</a>  </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav><!--=========-TOP_BAR============-->

 <!--=========MIDDEL-TOP_BAR============-->

    <div class="middleBar">
    <div class="container">
  <div class="row display-table">
    <div class="col-sm-3 vertical-align text-left hidden-xs">
      <a href="index.php"> <img style="height: 74px;
    margin-top: -15px;
    margin-left: -28px;
    width: 293px;" src="img/logo.png" alt=""></a>
    </div>
    <!-- end col -->
    <div class="col-sm-9 vertical-align text-center">
      <form method="GET" action="search.php">
        <div class="row grid-space-1">
          <div class="col-sm-9 col-xs-7">
            <input type="text" name="keyword" id="keyword" class="form-control input-lg" placeholder="Buscar" required style="height: 35px;
    margin-top: 6px;" <?php if (isset($_REQUEST['keyword'])){echo 'value="'.$_REQUEST['keyword'].'"';}?>>
         </div>

          <!-- end col -->
          <div class="col-sm-2  col-xs-5">
            <input type="submit" class="btn btn-default btn-block btn-lg" style="background-color: #35404f;
    border: 1px solid #35404f;height: 36px;
    margin-top: 5px;padding-top: 5px;" value="Buscar">
         </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </form>
    </div>
    <!-- end col -->

  </div>
  <!-- end  row -->
</div>
</div>


<nav class="navbar navbar-main navbar-default" role="navigation" style="opacity: 1;">
          <div class="container">
            <!-- Brand and toggle -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>

            <!-- Collect the nav links,  -->
            <div class="collapse navbar-collapse navbar-1" style="margin-top: 0px;">
              <ul class="nav navbar-nav">
                <li><a href="index.php">Inicio</a></li>

                   <li><?php
		 if( !isset($_SESSION['cid']) )
		 {
			 echo '<a href="register.php">Registrarse</a></li><li><a href="login.php">Iniciar Sesion</a>';
		 }
		 else
		 {
			 echo '<a href="myaccount.php">Mi Cuenta: '.$_SESSION['cname'].'</a></li><li><a href="descargas.php">Descargas</a></li><li><a href="abandonedcart.php">Pedidos En Espera ';
       if($funciones->getPedidosSinTerminar($_SESSION['cid'],$_SESSION['uid'])>0)
       {
        echo '<span class="badge">'.$funciones->getPedidosSinTerminar($_SESSION['cid'],$_SESSION['uid']).'</span>';
       }
       echo '</a>';
		 }
		?>

		</li>
    <?php
    //NOVEDADES
    $stmt = $dbh->prepare("SELECT marca  FROM productos WHERE `fechaalta` > timestampadd(day, -45, now()) group by marca");
        $stmt->execute();
    $result = $stmt->fetchAll();
    $totalitems=$stmt->rowCount();
    if($totalitems<6)
    {
      echo ' <li><a href="novedades.php">Novedades</a></li>';
    }
else
    {

      echo '<li class="dropdown megaDropMenu ">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false">Novedades <i class="fa fa-angle-down ml-5"></i></a>
                  <ul class="dropdown-menu row">
                    <li class="col-sm-3 col-xs-12">
                      <ul class="list-unstyled">
                        ';

    foreach($result as $row)

    {
      echo ' <li><a href="novedades.php?id='.$row['marca'].'">'.$row['marca'].'</a></li>';
    }

            echo '<li><a href="novedades.php?id=%">TODAS</a></li>
             </ul>
                    </li></ul>
          </li> ';
    }

    //OFERTAS
    $stmt = $dbh->prepare("SELECT productos.marca FROM ofertas inner join productos on productos.codigo=ofertas.idproducto where (fechadesde<='".date('Y-m-d')."' and fechahasta>='".date('Y-m-d')."') group by marca");
        $stmt->execute();
    $result = $stmt->fetchAll();
    $totalitems=$stmt->rowCount();
    if($totalitems<1)
    {
      echo ' <li><a href="ofertas.php">Ofertas</a></li>';
    }
else
    {

      echo '<li class="dropdown megaDropMenu ">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false">Ofertas <i class="fa fa-angle-down ml-5"></i></a>
                  <ul class="dropdown-menu row">
                    <li class="col-sm-3 col-xs-12">
                      <ul class="list-unstyled">
                        ';

    foreach($result as $row)

    {
      echo ' <li><a href="ofertas.php?id='.$row['marca'].'">'.$row['marca'].'</a></li>';
    }

            echo '<li><a href="ofertas.php?id=%">TODAS</a></li> </ul>
                    </li></ul>
          </li> ';
    }
            ?>



      <?php
      if( isset($_SESSION['cid']) )
     {
echo '<li><a href="logout.php">Cerrar Sesion</a></li>';
}
      ?>
		  <!--<li><a href="ofertas.php">Ofertas</a></li>
		  <li><a href="sucursales.php">Sucursales</a></li>-->
                <li class="dropdown megaDropMenu hidden-md hidden-lg hidden-sm">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false">Categorias <i class="fa fa-angle-down ml-5"></i></a>
                  <ul class="dropdown-menu row">



                    <?php
		 $stmt = $dbh->prepare("select * from categorias where padre=0");
        $stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			echo '  <li class="col-sm-3 col-xs-12">
                      <ul class="list-unstyled">
                        <li>'.$row['nombre'].'</li>';

							 $stmt = $dbh->prepare("select * from categorias where padre=".$row['id']);
        $stmt->execute();
		$result2 = $stmt->fetchAll();
		foreach($result2 as $row2)
		{
			echo ' <li><a href="category.php?id='.$row2['id'].'">'.$row2['nombre'].'</a></li>';
		}

						echo ' </ul>
                    </li>';
		}
					  ?>


                  </ul>
                </li>




              </ul>
            </div><!-- /.navbar-collapse -->
          </div>
        </nav>
