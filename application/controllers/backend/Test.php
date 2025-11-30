<?php

class Test extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        function esFeriado($fecha) {
            // Lista de días feriados específicos
            $feriados = [
                '2024-12-25', // Navidad
                // Agregar más días feriados según sea necesario
            ];
        
            $fechaSinHora = $fecha->format('Y-m-d');
        
            return in_array($fechaSinHora, $feriados);
        }
        
        function verificarFeriado_x($fecha) {
            // Convertir la fecha a un objeto DateTime
            $fechaObj = new DateTime($fecha);
        
            // Obtener el día de la semana (0 = domingo, 1 = lunes, ..., 6 = sábado)
            $diaSemana = (int) $fechaObj->format('w');
        
            // Si es domingo o es un día feriado específico, es considerado feriado
            if ($diaSemana === 0 || esFeriado($fechaObj)) {
                return true;
            }
        
            // Verificar si es sábado después de las 22:00 horas
            if ($diaSemana === 6 && (int) $fechaObj->format('H') >= 22) {
                return true;
            }
        
            return false;
        }
        
       
// Lista de días festivos
$holidays = [
    '2024-01-01', // Año Nuevo
    '2024-12-23', // Feriado
    '2024-12-25', // Navidad
    '2024-12-26', // Post Navidad
    // Añadir más días festivos según sea necesario
];
// Ejemplo de uso con fechas válidas en formato de cadena de texto


		$examples = [
            ['2024-12-19 22:45:00', '2024-12-20 05:00:00'],//1
            ['2024-12-20 06:15:00', '2024-12-20 09:45:00'],//2
            ['2024-12-20 08:30:00', '2024-12-20 14:00:00'],//3
            ['2024-12-20 18:30:00', '2024-12-21 02:30:00'],//4
            ['2024-12-22 19:15:00', '2024-12-23 02:00:00'],//5
            ['2024-12-22 22:45:00', '2024-12-23 02:45:00'],//6
            ['2024-12-24 03:30:00', '2024-12-24 11:00:00'],//7
            ['2024-12-24 06:00:00', '2024-12-24 08:00:00'],//8
            ['2024-12-24 18:00:00', '2024-12-24 23:00:00'],//9
            ['2024-12-24 18:30:00', '2024-12-25 03:30:00'],//10
            ['2024-12-25 18:30:00', '2024-12-25 23:15:00'],//11
            ['2024-12-26 18:00:00', '2024-12-27 04:15:00']//12
        ];
        $i = 1;
        
        foreach ($examples as $example) {
            $result = calculateWorkHours($example[0], $example[1], $holidays);
            echo "Ej: ".$i.") De " . $example[0] . " a " . $example[1] . ":<br>";
           
            echo"<pre>";
            print_r($result);
            echo"</pre>";
            echo "<hr>";
            $i++;
        }

	}
}