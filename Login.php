<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Interfaz del login -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    <link rel="stylesheet" type="text/css" href="EstiloPagina1.css" media="screen" />
</head>

<body>
    <div align=center class="Principal">
        <form method="post" action="InsertHistotialLogin.php">
            <label for="RegistroUs"><b>Usuario:</b></label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input class="control" name="Us" type="text" id="RegistroUs" required><br />
            <br><br>
            &nbsp;&nbsp;
            <label for="password"><b>contraseña:</b></label>
            &nbsp;
            <input class="control" id="password" type="password" name="pass" placeholder="123felic" required>
            &nbsp;
            <br><br>
            <input type="checkbox" id="Eye" />
            <label for="Eye"><b>Mostrar contraseña:</b></label>

            <?php
            if (isset($_GET["fallo"]) && $_GET["fallo"] == 'true') {
            ?>
                <div style='color:red'>Usuario o contraseña invalido </div>
            <?php
            }
            if (isset($_GET["fallo"]) && $_GET["fallo"] == 'false') {
            ?>
                <div style='color:red'>El usuario al que desea ingresar no Existe o no esta activo </div>

            <?php
            }
            ?>
            <br><br>

            <input class="button" type="submit" name="btEnviar" value="Iniciar Seccion" id="btEnviar" />
            &nbsp;
            <input class="button" type="reset" name="btRestablecer" value="Cancelar" id="btRestablecer" style="width:112px;" />
        </form>
    </div>
    <script src="Show.js"></script>
</body>

</html>