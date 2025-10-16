<?php
// Declaramos de nuevo los 10 alumnos para poder usarlos
$alumnos = ["Juan", "Sergio", "Ailyn", "Eduardo", "Ximena", "Alejandro", "Maximiliano", "Pedro", "Jesus", "Diana"];

// Variables para nuestras estadisticas
$suma = 0;//Este variable sirve para poder hacer la suma de las calificaciones
$validas = 0; // Este sirve para contará solo las notas validas y no los NP
$aprobados = 0;//Este srive para contar el numero de aprobados
$reprobados = 0;//Este srive para contar el numero de reprobados
$mejorcalf = 0; //Es para saber cual es la mejor calificacion, el cero es para que podamos revisar los numeros del 1-10 y no menores
$peorcalf = 10; //Este es para saber cual es la peor calificacion, el 10 es para que no se salga de los valores permitidos de 1-10
$mejoresAlumnos="";
$peoresAlumno="";

// Cadenas de texto para guardar las listas de alumnos
$alumnos_op = ""; //Una cadena de texto para poder guardar los nombre de los alumnos en oportunidad
$alumnos_np = ""; //Una cadena de texto para poder guardar los nombre de los alumnos en NP
$conteo_np = 0;//Este es para saber cuantos alumnos estan en NP

foreach ($alumnos as $alumno) {//Es un bucle toma una lista completa y esta nos ayuda a trabjar aulumno por alumno
    $calificacion = $_REQUEST["cbo" . $alumno]; // Este nos ayuda saber la nota ya que con el request recuperamos los datos introducidos

    if ($calificacion == "NP") {//Condicion para saber cuadno la nota es NP
        $conteo_np++;//Este es para incrementar el conteo si la nota es NP
        $alumnos_np .= $alumno . "<br>"; // Este nos sirve para que guardemos e nombre del alumno con NP en nuestra variable
    } else {//Por di no se cumple el IF
        
        $suma = $suma + $calificacion;//Este es para hacer la suma poder hacer nuestras operaciones aqui se suaman las calificaciones
		$validas = $validas + 1;//Comprobamos que la nota sea valida y si es valida incrementa en 1 esta variable

        if ($calificacion > $mejorcalf){
			$mejorcalf = $calificacion;//Verificamos las calificaciones para ver cual es la mejor
			$mejoresAlumnos = $alumno;//Aqui estamos diciendo que en nuestra variable mejoresAlumnos se van a guardar el nombre del alumno
		} elseif ($calificacion == $mejorcalf) {//Aqui importante usamos elseif para verificar una segunda condición en caso de que hubiera un empate de calificacion 
			$mejoresAlumnos .= ", " . $alumno;//Y aqui se agregan los nombres solo en caso de empate 
		}
				
        if ($calificacion < $peorcalf){
			$peorcalf = $calificacion;//Verificamos las calificaciones para ver cual es la peor
			$peoresAlumnos = $alumno;//Aqui estamos diciendo que en nuestra variable peoresAlumnos se van a guardar el nombre del alumno
			} elseif ($calificacion == $peorcalf) {//Aqui importante usamos elseif para verificar una segunda condición en caso de que hubiera un empate de calificacion,
				//si pusieramos el else normal nos agregaria cualquier alumno con una calificacion inferior, el elseif nos permite por lo menos preguntar si es igual la calficacion a la mejor
				$peoresAlumnos .= ", " . $alumno;//Y aqui se agregan los nombres solo en caso de empate 
			}
			
        if ($calificacion >= 6) {//Revisamos que la calificacion sea aprobatoria viendo que sea mayor o igual a 6
            $aprobados++;//si se cumple el numero de aprobados incrementa
            if ($calificacion <= 7) {//Revisamos los alumnos de oportunidad y su calificaion debe de ser de 7 o menor
                $alumnos_op .= $alumno . " ($calificacion)<br> "; //guardamos en nuestra variable el nombre del alumno y su calificacion
            }
        } else {//Por di no se cumple el IF
            $reprobados++;//Si no cumple con las dos condiciones anteriores incrementa el numero de Reprobados
        }
    }
}

//CALCULOS PARA NUETRAS ESTADISTICAS
$promedio = 0;//variable para nuestro promedio del grupo
$p_aprobados = 0;//variable para el promedio de aprobados
$p_reprobados = 0;//variable para el numero de Reprobados

	if ($validas > 0){ //condicion donde para comprobar calificaciones validas
		$promedio = $suma / $validas;//si se cumple la condicion vamos a sacar el promedio con la suma de nuestras calificaciones entre las calificaciones validas
		$total = $aprobados + $reprobados;//sacar el total de estudianetes sean aprobados o Reprobados
		$p_aprobados = ($aprobados / $total) * 100;//sacar el porcentaje de aprobados
		$p_reprobados = 100 - $p_aprobados;//sacar el porcentaje de Reprobados
	} else {//Por di no se cumple el IF
		$peorcalf = "N/A";// Este es por si no hay notas válidas, mostramos N/A en las variables
		$mejorcalf = "N/A";// Este es por si no hay notas válidas, mostramos N/A en las variables
}


// IMPRESIONES DE TODO LO QUE HICIMOS
echo "<h1>Resultados Generales</h1>";

echo "<h2>1. Aprovechamiento:</h2>";
echo "Promedio: " . $promedio . "<br>";

echo "<h2>2. Porcentaje de aprobados y reprobados:</h2>";
echo "Aprobados: " . $p_aprobados . "%<br>";
echo "Reprobados: " . $p_reprobados . "%<br>";

echo "<h2>3. Calificacion Máxima y Mínima:</h2>";
echo "Mejor Calificación: " . $mejorcalf . "<br>";
echo "Alumnos con mejor calificación: " . $mejoresAlumnos . "<br>"; 
echo "Peor Calificación: " . $peorcalf . "<br>";
echo "Alumnos con peor calificación: " . $peoresAlumnos . "<br>"; 

echo "<h2>Alumnos con NP:</h2>";
echo "Total de alumnos con NP: " . $conteo_np . "<br>";
echo $alumnos_np . "<br>";

echo "<h2>Alumnos en Área de Oportunidad:</h2>";
echo "Lista: " . $alumnos_op;
?>