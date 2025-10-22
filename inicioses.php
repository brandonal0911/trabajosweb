<?php
session_start();// Este es para el inicio de sesión

// Definimos en variables de texto las credenciales correctas
$usuario_correcto = "alumno";
$contrasena_correcta = "1234";

// Aqui vamos hacer una condicion para ver si viene del formulario de login, o bueno revisar el formulario del primer codigo
if(isset($_POST["usuario"]) && isset($_POST["contrasena"])){
	
	// Se guardan las credenciales que metio el usuario trayendolas con un metodo post
	$usuario = $_POST["usuario"];
	$contrasena = $_POST["contrasena"];
	
	// Aqui vamos a verifica si las credenciales son correctas
	if($usuario == $usuario_correcto && $contrasena == $contrasena_correcta){
		
		// Guarda el tiempo actual, osea para después poder calcular cuánto tiempo ha pasado desde que inició sesión
		// Es para saber exactamente cuántos segundos han pasado desde que inició sesión
		$tiempo_actual = time();
		
		// Guarda el usuario y tiempo en la sesión
		$_SESSION["usuario"] = $usuario;
		$_SESSION["tiempo_inicio"] = $tiempo_actual;
		
		// Aqii es por si marcó recuérdame, guarda cookies por 120 segundos
		if(isset($_POST["recuerdame"])){//condicion por si marco la casilla
			setcookie("usuario", $usuario, time() + 120);//Para crear una cookie al usuario y el tiempo es 120 seg
			setcookie("tiempo_inicio", $tiempo_actual, time() + 120);//Para crear una cookie al tiempo en el que nos conectamos y el tiempo es 120 seg
			setcookie("recuerdame", "si", time() + 120);//Para crear una cookie a la casilla de recuerdame y el tiempo es 120 seg
		}
		
	}else{
		// Si las credenciales son incorrectas, redirige a la página de error
		header("Location: errorses.php");//Recuerda que los header es para redirigir a otro documento 
		exit(); //Exit nos sirve para detener el código 
	}
}

// Toda esta condicion es para verificar si marcó recuérdame
if(isset($_COOKIE["recuerdame"])){//Si marco recuerdame entonces se hara lo q sigue
	
	if(isset($_COOKIE["usuario"]) && isset($_COOKIE["tiempo_inicio"])){// Verifica si hay cookies guardadas
		
		$tiempo_transcurrido = time() - $_COOKIE["tiempo_inicio"];// Calcula cuánto tiempo ha pasado
		//Aqui se restara el tiempo transcurrido menos el tiempo de la cookie del tiempo de inicio, osea
		//Cuanto tiempo llevamos menos los 120 segundos que tenemos disponibles
		
		if($tiempo_transcurrido <= 120){// Aqui es una condicion para saber si aún no han pasado 120 segundos
			
			// Si no han pasado los 120 segundos restauramos la sesión desde las cookies
			$_SESSION["usuario"] = $_COOKIE["usuario"];
			$_SESSION["tiempo_inicio"] = $_COOKIE["tiempo_inicio"];
			
		}else{
			// Si ya pasaron 120 segundos, se borran todas las cookies y redirige al login
			setcookie("usuario", "", time() +1);
			setcookie("tiempo_inicio", "", time() +1);
			setcookie("recuerdame", "", time() +1);
			//se pone las comillas solas porque no estamos guardando un valor, y el +1 porque asi la cookie se destruye casi al instante
			session_destroy();
			//El session_destroy se utiliza para destruir la sesion bueno para cerrarla
			header("Location: login.php");
			exit();
		}
	}
	
}

if(isset($_SESSION["usuario"])){
    // No hace nada si existe
}else{
    // Redirige si NO existe
    header("Location: login.php");
    exit();
}

// Aqui vamos a verificar si la sesión ya expiró (120 segundos)
if(isset($_SESSION["usuario"])){
	
	// Aqui calculamos cuánto tiempo ha pasado desde que inició sesión
	// Ejemplo: si time() es 1000 y $_COOKIE["tiempo_inicio"] es 980, entonces llevamos 20 segundos
	//Mas especificado imaginemos que el time es la hora de inicio de sesion, osea iniciamos sesion a las 10, leugo mas tarde preguntas
	//que hora es con el time() y te dice que las 10 con 20, entonces se resta las 10 con 20 menos diez y el tiempo que llevas 
	//en sesion iniciada es 20 segundos
	$tiempo_transcurrido = time() - $_SESSION["tiempo_inicio"];
	
	// Si pasaron más de 120 segundos
	if($tiempo_transcurrido > 120){
		// Destruye todo y redirige al login, esto ya lo explicamos arriba
		session_destroy();
		setcookie("usuario", "", time() +1);
		setcookie("tiempo_inicio", "", time() +1);
		setcookie("recuerdame", "", time() +1);
		header("Location: login.php");
		exit();
	}
	
}else{//Pero si no hay sesion
	// Redirige al login, Y CIERRA LA SESION
	header("Location: login.php");
	exit();
}

// Aqui es lo mas sencillo si presionó el botón Cerrar Sesión
if(isset($_POST["cerrar"])){
	// Destruye la sesión y borra todas las cookies
	session_destroy();
	setcookie("usuario", "", time() +1);
	setcookie("tiempo_inicio", "", time() +1);
	setcookie("recuerdame", "", time() +1);
	// Redirige al login
	header("Location: login.php");
	exit();
}
?>

<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
	<!-- Muestra el nombre del usuario que inició sesión -->
	<h1>Bienvenido <?php echo $_SESSION["usuario"];?></h1>
	<p>Has iniciado sesión correctamente</p>
	<br>
	<form method="POST" action="">
		<input name="cerrar" value="Cerrar Sesión" type="submit">
	</form>
</body>
</html>