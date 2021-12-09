<?php

function recoge($var, $m = "")
{
    if (!isset($_REQUEST[$var])) {
        $tmp = (is_array($m)) ? [] : "";
    } elseif (!is_array($_REQUEST[$var])) {
        $tmp = trim(htmlspecialchars($_REQUEST[$var], ENT_QUOTES, "UTF-8"));
    } else {
        $tmp = $_REQUEST[$var];
        array_walk_recursive($tmp, function (&$valor) {
            $valor = trim(htmlspecialchars($valor, ENT_QUOTES, "UTF-8"));
        });
    }
    return $tmp;
}

$AproORech = recoge("AproORech");
$us = recoge("Us");
$IdRol = recoge("Rol");
$carnet = recoge("carnet");
$Idart = recoge("Idart");
$conn = Conecta();
if ($IdRol == 3) {
    $stmt = $conn->query("UPDATE `pedidos` SET `Visto` = '0', `AprobadorJefe` = '$AproORech' where 	idSArt='$Idart'");
} else {
    print($carnet);
    $stmt = $conn->query("UPDATE `historial` SET `IdFinanciero`='$carnet' where IdSart ='$Idart'");
    if ($stmt) {
        $stmt = $conn->query("UPDATE `pedidos` SET  `AprobadorFinan` = '$AproORech' where idSArt='$Idart'");
    }
}
if ($stmt) {
    header("Status: 301 Moved Permanently");
    header("Location: SolicitudDePedidos.php?RegistroUs=$us&fallo=true");
    exit;
} else {
    print("No se almaceno la cita satisfactoriamente");
}
$conn->close();
function Conecta()
{
    $elServidor = "localhost";
    $elUsuario = "root";
    $elPassword = "";
    $laBD = "telecenter";
    $laconexion = new mysqli($elServidor, $elUsuario, $elPassword, $laBD);

    if ($laconexion->connect_error) {
        die("Error al Conectar con la BD: " . $laconexion->connect_error);
    }
    //echo "Conexion exitosa <br>";

    return $laconexion;
}
