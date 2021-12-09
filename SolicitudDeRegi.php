<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Interfaz para insertar a los nuevos usuarios -->
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
    $us = recoge('RegistroUs');
    $Rol = recoge('Tip');
    $conn = Conecta();
    $stmt = $conn->query("SELECT * FROM `usuario` Where RegsitroUsuario='$us'");


    while ($row = $stmt->fetch_assoc()) {
        $Carnet = $row["IdRol"];
    }
    ?>
    <nav class="nav">
        <ul class="menu">
            <li><a>Historial de pedido</a></li>
            <li><a href=" Usuario.php?RegistroUs=<?php echo $us ?>">Perfil de usuario</a></li>
            <li><a href="index.html?RegistroUs=<?php echo $us ?>">Cerrar Sesion</a></li>
            <li><a>Ayuda</a></li>
        </ul>
    </nav>
    <div class="Principal" id="Segundo">
        <form method="$_POST" action="InsertRegis.php">
            <input name="RegistroUs" id="Nombre" type="hidden" value="<?php echo  $us; ?>">


            <h4 align="center">Registro para nuevos usuarios</h4>
            <br><br>
            <label align="left" for="Registrar usuario"><b>Registrar usuario:</b></label>
            <input require align="left" class="control Cont" name="us" id="Registrar usuario" type="text" placeholder="felix124">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="Nombre"><b>Nombre Apellido:</b></label>
            <input require class="control Cont" name="NomApe" id="NomApe" type="text" placeholder="felix">
            <br><br>

            <label for="password"><b>contraseña:</b></label>
            &nbsp;
            <input class="control" id="password" type="password" name="pass" placeholder="123felic" required>
            &nbsp;
            <br><br>
            <input type="checkbox" id="Eye" />
            <label for="Eye"><b>Mostrar contraseña:</b></label>
            &nbsp; &nbsp; &nbsp; &nbsp;
            <label for="Edad"><b>Edad:</b></label>
            &nbsp;<input require class="control Cont" name="edad" id="Edad" type="int" placeholder="20">
            <br><br>
            <br><br>

            <?php

            if ($Rol == 'Aprobador En Financiero') {

            ?> <label for="MinMax"><b>Minimo Maximo Precio:</b></label>
                <select name="MinMax" class="control">
                    <?php
                    $conn = Conecta();
                    $stmt = $conn->query("SELECT * FROM `roles` Where NombreRol='AdministradorFinanciero'");
                    while ($valores = mysqli_fetch_array($stmt)) {
                        $Espacio = "               ";
                        echo '<option value="' . $valores["TipoDeRol"] . '">' . $valores["min"] .  $Espacio . $valores["Máximo"] . '</option>';
                    }

                    ?>
                </select><?php
                        }
                        if ($Rol == 'Comprador') { ?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label for="Jefe"><b>Jefe Asignado:</b></label>
                <select name="Jefe" class="control">

                    <?php
                            $conn = Conecta();
                            $stmt = $conn->query("SELECT * FROM `usuario` Where IdRol='3'");
                            while ($valores = mysqli_fetch_array($stmt)) {

                                echo '<option value="' . $valores["carnet"] . '">' . $valores["carnet"] . '</option>';
                            }
                    ?>
                </select>
            <?php }   ?>
            <input name="Rol" id="Rol" type="hidden" value="<?php echo  $Rol; ?>">

            <br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label for="Correo electronico"><b>Correo electronico:</b></label>
            <input require class="control" name="correo" id="Correo electronico" type="text" placeholder="felix.tr@gmail.com">
            <br><br>

            &nbsp;&nbsp;&nbsp;&nbsp;
            <label for="Cedula"><b>Cedula:</b></label>
            &nbsp;<input require class="control Cont" name="Cedula" class="control" id="Cedula" type="int" placeholder="118170695">
            <br><br>
            <br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input class="button" type="submit" value="Registar ">

            <br><br>
        </form>
    </div>

    <br><br><br>
    <script src="Show.js"></script>
</body>

</html>