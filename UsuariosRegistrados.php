<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Nos permite modificar los datos del usuario -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Registro</title>
    <link rel="stylesheet" type="text/css" href="EstiloPagina1.css" media="screen" />
</head>

<body>
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
    $us = recoge('RegsitroUsuario'); //Usuario que queremos modificar
    $Us = recoge('Us'); //Usuario actual
    $conn = Conecta();
    $stmt = $conn->query("SELECT * FROM `usuario` WHERE RegsitroUsuario='$Us'");
    while ($row = $stmt->fetch_assoc()) {
        $IdRol = $row["IdRol"];
    }
    ?>
    <nav class="nav">
        <ul class="menu">
            <?php
            if ($IdRol == '1') { ?>
                <li>
                    <a href="SolicitudDeArt.php?RegistroUs=<?php echo $Us ?>">Solicitud de articulo</a>
                </li><?php }
                    if ($IdRol == '2') { ?>
                <li>
                    <a href="Roles.php?RegistroUs=<?php echo $Us ?>">Solicitud de registro</a>
                </li><?php }
                    if ($IdRol > '2' & $IdRol < '7') { ?>
                <li><a href="SolicitudDePedidos.php?RegistroUs=<?php echo $Us ?>">Solicitud de pedidos</a></li>
            <?php } if ($IdRol == 2) { ?>
                <li><a href="UsuariosDis.php?RegistroUs=<?php echo $Us ?>">Historial de registro</a></li>
            <?php } else { ?>
                <li><a href="Pedidos.php?RegistroUs=<?php echo $Us ?>">Historial de pedido</a></li>
            <?php } ?>
            <li><a href=" Usuario.php?RegistroUs=<?php echo $Us ?>">Perfil de usuario</a></li>
            <li><a href=" index.html?RegistroUs=<?php echo $Us ?>">Cerrar Sesion</a>
            </li>
            <li><a>Ayuda</a></li>
        </ul>
    </nav>
    <?php $conn = Conecta();
    $stmt = $conn->query("SELECT * FROM `usuario` Where RegsitroUsuario='$us'");

    while ($row = $stmt->fetch_assoc()) {
    ?>
        <div class="Principal" id="Segundo">
            <?php
            if (isset($_GET["fallo"]) && $_GET["fallo"] == 'true') {
            ?>
                <div style='color:red'>Usuario Modificado con exito </div>
            <?php
            } ?>
            <form method="$_POST" action="UpdateUsuarios.php">
                <input name="RegistroUs" id="Nombre" type="hidden" value="<?php echo  $Us; ?>">


                <h4 align="center">Registro para nuevos usuarios</h4>
                <br><br>
                <label align="left" for="Registrar usuario"><b>Registrar usuario:</b></label>
                <input require align="left" class="control Cont" name="us" id="Registrar usuario" type="text" value="<?php echo  $row["RegsitroUsuario"]; ?>">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="Nombre"><b>Nombre Apellido:</b></label>
                <input require class="control Cont" name="NomApe" id="NomApe" type="text" value="<?php echo  $row["NombreApellidos"]; ?>">
                <br><br>

                <label for="password"><b>contraseña:</b></label>
                &nbsp;
                <input class="control" id="password" type="password" name="pass" value="<?php echo  $row["pass"]; ?>" required>
                &nbsp;
                <br><br>
                <input type="checkbox" id="Eye" />
                <label for="Eye"><b>Mostrar contraseña:</b></label>
                &nbsp; &nbsp; &nbsp; &nbsp;<label for="Edad"><b>Edad:</b></label>
                &nbsp;<input require class="control Cont" name="edad" id="Edad" type="int" value="<?php echo  $row["Edad"]; ?>">
                <br><br>
                <br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label for="Correo electronico"><b>Correo electronico:</b></label>
                <input require class="control" name="correo" id="Correo electronico" type="text" value="<?php echo  $row["correo"]; ?>">
                <br><br>

                &nbsp;&nbsp;&nbsp;&nbsp;
                <label for="Cedula"><b>Cedula:</b></label>
                &nbsp;<input require class="control Cont" name="Cedula" class="control" id="Cedula" type="int" value="<?php echo  $row["cedula"]; ?>">
                <br><br>
                <br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input class="button" type="submit" value="Modificar ">

                <br><br>
            </form>
        </div>
    <?php } ?>

    <br><br><br>
    <script src="Show.js"></script>
</body>

</html>