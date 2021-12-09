<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Nos muestra todos los usuarios y nos permite modificarlos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Examen</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/fotograma.css">
    <link rel="stylesheet" type="text/css" href="EstiloPagina1.css" media="screen" />
    <style>
        .table {
            border-color: blueviolet;
        }

        #Tercero {
            width: 1000px;
            /*Ancho del area de elemento*/
        }
    </style>
</head>

<body>
    <?php
    $us = $_GET['RegistroUs']; 
    $conn = Conecta();
    $stmt = $conn->query("SELECT * FROM `usuario` WHERE RegsitroUsuario='$us'");
    while ($row = $stmt->fetch_assoc()) {
        $IdRol = $row["IdRol"];
    }
    ?>
    <nav class="nav">
        <ul class="menu">
            <?php
            if ($IdRol == '1') { ?>
                <li>
                    <a href="SolicitudDeArt.php?RegistroUs=<?php echo $us ?>">Solicitud de articulo</a>
                </li><?php }
                    if ($IdRol == '2') { ?>
                <li>
                    <a href="Roles.php?RegistroUs=<?php echo $us ?>">Solicitud de registro</a>
                </li><?php }
                    if ($IdRol > '2' & $IdRol < '7') { ?>
                <li><a href="SolicitudDePedidos.php?RegistroUs=<?php echo $us ?>">Solicitud de pedidos</a></li>
            <?php } ?>
            <li><a href=" Usuario.php?RegistroUs=<?php echo $us ?>">Perfil de usuario</a></li>

            <li><a href=" index.html?RegistroUs=<?php echo $us ?>">Cerrar Sesion</a>
            </li>
            <li><a>Ayuda</a></li>
        </ul>
    </nav>
    <div class="main">
        <?php
        //Pagina que muestra los datos de base de datos
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
        echo "<div align=center class='Principal' id=Tercero>";
        echo "<h3>Usuarios Registrados </h3>";
        echo "<br>";


        echo "<table class='table' border='5'  >";
        echo "<tr>";
        echo " <th> carnet   </th>";
        echo " <th> Usuario </th>";
        echo " <th> correo  </th>";
        echo " <th> NombreApellidos </th>";
        echo " <th> Edad </th>";
        echo " <th> cedula  </th>";
        echo " <th> IdJefe	 </th>";
        echo " <th> FechaCreacion </th>";
        echo " <th> IdRol  </th>";
        echo " <th> EstadoUs  </th>";
        echo "</tr>";
        $conn = Conecta();
        $stmt = $conn->query("SELECT * FROM `usuario` where IdRol !='2'");
        while ($row = $stmt->fetch_assoc()) {
            imprimirTabla($row, $us);
        }

        function imprimirTabla($row, $us)
        {
            $val=$row["EstadoUs"] ;
            if($val==1){
                $Estado="Activo";
            }else{
                $Estado="Suspendido";
            }
            $Usuario = $row["RegsitroUsuario"];
            echo "<tr>";
            echo "<td>" . $row["carnet"] .      "</td> ";
            echo "<td>" . $row["RegsitroUsuario"] .      "</td> ";
            echo "<td>" . $row["correo"] .      "</td> ";
            echo "<td>" . $row["NombreApellidos"] .      "</td> ";
            echo "<td>" . $row["Edad"] .      "</td> ";
            echo "<td>" . $row["cedula"] .      "</td> ";
            echo "<td>" . $row["IdJefe"] .      "</td> ";
            echo "<td>" . $row["FechaCreacion"] .      "</td> ";
            echo "<td>" . $row["IdRol"] .      "</td> ";
            echo "<td>" . $Estado.      "</td> ";
            echo "<td>" . "<a href='UsuariosRegistrados.php?RegsitroUsuario=$Usuario&Us=$us" .
                "'>Modificar</a>" .   "</td>";
            echo "</tr>";
        }
        //End imprimeTabla  -----------------------------------------------------------
        echo "</table>";
        echo "</div>";
        ?>
    </div>
    </div>

</body>

</html>