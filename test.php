<?php

require_once('email.php');
$msg="<p><strong>Nuevo Registro de Cliente en agustinghiggeri.com.ar</strong></p>
        <hr>
        <p><strong>Codigo generado: </strong>123</p>
        <p><strong>Nombre: </strong>asd</p>
        <p><strong>CUIT: </strong>asd</p>
        <p><strong>Telefono: </strong>dsa</p>
        <p><strong>Direccion: </strong>asd, asd, asd</p>
        <p><strong>Email: </strong>asd</p>";

echo 'mandando';
sendMail("Nuevo Cliente",$msg);
echo 'fin';

?>