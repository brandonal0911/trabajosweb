<?php
//Este codigo es para verificar si ya tienes sesión activa antes de mostrarte el formulario
// El session_start inicia la sesión para poder usar variables de sesión
session_start();

// Aqui es lo importante ya que SOLO VAMOS A verificar cookies si marcó recuérdame
if(isset($_COOKIE["recuerdame"])){ // Aqui se hace una condicion y pregunta si existe la cookie de recuerdame
	
	// Verifica si existen las cookies de usuario y tiempo
	if(isset($_COOKIE["usuario"]) && isset($_COOKIE["tiempo_inicio"])){
		
		// Aqui vamos a calcular cuánto tiempo ha pasado desde que inició sesión
		$tiempo_transcurrido = time() - $_COOKIE["tiempo_inicio"];
		
		// Si aún no han pasado 120 segundos (2 minutos)
		if($tiempo_transcurrido <= 120){
			
			// Restaura la sesión con los datos de las cookies
			$_SESSION["usuario"] = $_COOKIE["usuario"];
			$_SESSION["tiempo_inicio"] = $_COOKIE["tiempo_inicio"];
			
			// Redirige a la página de bienvenida
			header("Location: inicioses.php");
			exit(); // Detiene el código aquí
			
			//Para mas explicacion, esta parte del codigo solo verifica si hay cookies de inicio de sesion y si puso la casilla de recuerdame
			//asi si puso la casilla de recuerdame lo que va a suceder es que la sesion se quede iniciada aunque cierres navegador o la ventana
			
		}else{
			// Si ya pasaron 120 segundos, borra todas las cookies
			setcookie("usuario", "", time() +1); // Borra cookie de usuario
			setcookie("tiempo_inicio", "", time() +1); // Borra cookie de tiempo
			setcookie("recuerdame", "", time() +1); // Borra cookie de recuérdame
		}
	}
}

// Si NO marcó la casilla de recuerdame se limpia la sesión osea se borran todas las cookies y si cirras el navegador o la ventana
//la sesion se cierra porque no seleccionaste la casilla recuerdame
if(!isset($_COOKIE["recuerdame"]) && isset($_SESSION["usuario"])){
	session_destroy(); // Destruye la sesión existente
	session_start(); // Inicia una nueva sesión limpia
}
?>

<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
	<h1>Inicia sesion</h1>
	<form method="POST" action="inicioses.php">
		<label>Usuario</label>
		<input name="usuario" type="text">
		<br><br>		
		<label>Contraseña</label>	
		<input name="contrasena" type="text">
		<br><br>
		<label>Recuerdame </label>
		<input name="recuerdame" type="checkbox">
		<input value="Ingresar" type="submit">
	</form>
</body>
</html>