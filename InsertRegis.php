<?php
//Insertamos los nuevos usuarios 
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

$us = recoge("RegistroUs ");
$NomApe   = recoge("NomApe");
$pass = recoge("pass");
$edad = recoge("edad");
$MinMax = recoge("MinMax");
$correo = recoge("correo");
$Cedula = recoge("Cedula");
$Jefe = recoge("Jefe");
$Tip = recoge("Rol");

$Regi = recoge("us");
$response = "";
$conn = Conecta();
if ($Tip == 'Comprador') {
    $IdRol = '1';
    $stmt1 = $conn->query("INSERT INTO `usuario` (`RegsitroUsuario`,`correo`,`pass`,`NombreApellidos`,`Edad`,`cedula`,`IdJefe`,`IdRol`,`EstadoUs`) VALUES ( '$Regi','$correo','$pass','$NomApe','$edad','$Cedula','$Jefe','$IdRol','1');");
} else {
    if ($Tip == 'Adminitrador De Sistemas') {
        $IdRol = '2';
    }
    if ($Tip == 'Aprobador En Jefe"') {
        $IdRol = '3';
    }
    if ($Tip == 'Aprobador En Financiero') {
        $IdRol = $MinMax;
    }
    print($Regi);
    $stmt1 = $conn->query("INSERT INTO `usuario` (`RegsitroUsuario`,`correo`,`pass`,`NombreApellidos`,`Edad`,`cedula`,`IdRol`,`EstadoUs`) VALUES ( '$Regi','$correo','$pass','$NomApe','$edad','$Cedula','$IdRol','1');");
}
if ($stmt1) {

    header("Status: 301 Moved Permanently");
    header("Location: Roles.php?RegistroUs=$us&fallo=true");
    exit;
} else {
    print "No se almaceno la cita satisfactoriamente";
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
