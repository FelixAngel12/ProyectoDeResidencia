<?php
//Actualizamos los datos personales
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
$RegistroUs=recoge("RegistroUs");
$us = recoge("us");
$NomApe   = recoge("NomApe");
$pass = recoge("pass");
$edad = recoge("edad");
$correo = recoge("correo");
$Cedula = recoge("Cedula");
$conn = Conecta();
$stmt = $conn->query("UPDATE `usuario` SET `RegsitroUsuario` = '$us', `correo` = '$correo', `pass` = '$pass',`NombreApellidos`='$NomApe',`Edad`='$edad',`cedula`='$Cedula' WHERE RegsitroUsuario='$us'");
$conn->close();
if($stmt){
header("Status: 301 Moved Permanently");
header("Location: UsuariosRegistrados.php?RegsitroUsuario=$RegistroUs&Us=$us&fallo=true");
exit;
}


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
