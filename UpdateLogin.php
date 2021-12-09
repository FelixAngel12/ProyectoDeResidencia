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
$us = recoge("Usuario");
$NombreApellidos = recoge("NombreApellidos");
$Edad   = recoge("Edad");
$correo = recoge("correo");


$conn = Conecta();
// prepare and bind
$stmt = $conn->query("UPDATE `usuario` SET `correo` = '$correo', `NombreApellidos` = '$NombreApellidos', `Edad` = '$Edad' WHERE RegsitroUsuario='$us'");
$conn->close();
header("Status: 301 Moved Permanently");
header("Location: Usuario.php?RegistroUs=$us&fallo=true");
exit;



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
