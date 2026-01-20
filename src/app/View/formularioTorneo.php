<?php
$titulo= "Formulario Torneo";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="contenedor">
    <h2><?=$titulo?></h2>
        <form action="/registroTorneo" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha">
            <label for="premio_total">Total Premios</label>
            <input type="number" id=premio_total name="premio_total">
            <button type="submit">Enviar</button>
        </form>
</div>

</body>
</html>
