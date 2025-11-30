<?php
class Reportes extends CI_Controller
{
	public $page_title;
	public $page_current_reporte;
	public $current_reporte_general;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        //si no tiene permisos es redirigido al escritorio
		//if(!verificarPermiso("prov_lista")) redirect (base_url().'backend/');

        //$this->load->model("provincia_modelo");
		$this->page_title = "Gestión de Reportes";
        $this->page_current_reporte = "class='current'";
        $this->layout->setTitle($this->page_title);

		$this->load->model('reporte_modelo');
		$this->load->model('tarea_modelo');
		$this->load->model('horquillahoraria_modelo');
		$this->load->model('usuario_modelo');
		$this->load->model('cliente_modelo');
		$this->load->model('centro_modelo');
		$this->load->model('proyecto_modelo');
		$this->load->model('evento_modelo');
		$this->load->model('tarea_modelo');
		$this->load->model('feriado_modelo');
	}

	public function index()
	{
		
		//page current
		$this->current_reporte_general = "class='current'";

		$date_range = $this->input->get('date_range');
		$tra_id = $this->input->get('tra_id');
		$cli_id = $this->input->get('cli_id');
		$cen_id = $this->input->get('cen_id');
		$pro_id = $this->input->get('pro_id');
		$eve_id = $this->input->get('eve_id');
		$eve_state = $this->input->get('eve_state'); 
		$tar_id = $this->input->get('tar_id');
		$eve_imputacion = $this->input->get('eve_imputacion');
		
		$this->page_title = "Reportes <a class='icon-export' title='Exportar a excel' href='".base_url()."backend/reportes/export_xls/?date_range=$date_range&cli_id=$cli_id&cen_id=$cen_id&tra_id=$tra_id&pro_id=$pro_id&eve_id=$eve_id&eve_state=$eve_state&tar_id=$tar_id&eve_imputacion=$eve_imputacion'><svg xmlns='http://www.w3.org/2000/svg'  viewBox='0 0 48 48' width='48px' height='48px'><path fill='#4CAF50' d='M41,10H25v28h16c0.553,0,1-0.447,1-1V11C42,10.447,41.553,10,41,10z'/><path fill='#FFF' d='M32 15H39V18H32zM32 25H39V28H32zM32 30H39V33H32zM32 20H39V23H32zM25 15H30V18H25zM25 25H30V28H25zM25 30H30V33H25zM25 20H30V23H25z'/><path fill='#2E7D32' d='M27 42L6 38 6 10 27 6z'/><path fill='#FFF' d='M19.129,31l-2.411-4.561c-0.092-0.171-0.186-0.483-0.284-0.938h-0.037c-0.046,0.215-0.154,0.541-0.324,0.979L13.652,31H9.895l4.462-7.001L10.274,17h3.837l2.001,4.196c0.156,0.331,0.296,0.725,0.42,1.179h0.04c0.078-0.271,0.224-0.68,0.439-1.22L19.237,17h3.515l-4.199,6.939l4.316,7.059h-3.74V31z'/></svg></a>";

		$date_range_initial = date("Y-m-d", strtotime('-6 days')) . " - " . date("Y-m-d");

		if($eve_state=='none' or !isset($eve_state)) $eve_state='all';
		
		$data = array(
					'date_range'=> $date_range?$date_range:$date_range_initial,
					'tra_id' 	=> $tra_id?$tra_id:"",
					'cli_id' 	=> $cli_id?$cli_id:"",
					'cen_id' 	=> $cen_id?$cen_id:"",
					'pro_id' 	=> $pro_id?$pro_id:"",
					'eve_id' 	=> $eve_id?$eve_id:"",
					'tar_id' 	=> $tar_id?$tar_id:"",
					'eve_imputacion'=> $eve_imputacion?$eve_imputacion:"",

					'reporte_tareas' => $this->reporte_modelo->getReporteTareas(),
					
					'trabajadores' => $this->usuario_modelo->getLista('', 'Trabajador'),
					'clientes' => $this->cliente_modelo->getLista(),
					'centros' => $this->centro_modelo->getLista(),
					'proyectos' => $this->proyecto_modelo->getLista(),
					'eventos' => $this->evento_modelo->getLista($eve_state),
					'tareas' => $this->tarea_modelo->getLista(1),
				);		

		$this->layout->view("reporte_general_view", $data);
	}

	public function export_xls(){

		$date_range = $this->input->get('date_range');
		$tra_id = $this->input->get('tra_id');
		$cli_id = $this->input->get('cli_id');
		$cen_id = $this->input->get('cen_id');
		$pro_id = $this->input->get('pro_id');
		$eve_id = $this->input->get('eve_id');
		$eve_state = $this->input->get('eve_state'); if($eve_state='none') $eve_state='';
		$tar_id = $this->input->get('tar_id');

		$date_range_initial = date("Y-m-d", strtotime('-6 days')) . " - " . date("Y-m-d");
		$data = array(
					'filename' => 'export'.date('Y-m-d-H-i-s'),

					'date_range'=> $date_range?$date_range:$date_range_initial,
					'tra_id' 	=> $tra_id?$tra_id:"",
					'cli_id' 	=> $cli_id?$cli_id:"",
					'cen_id' 	=> $cen_id?$cen_id:"",
					'pro_id' 	=> $pro_id?$pro_id:"",
					'eve_id' 	=> $eve_id?$eve_id:"",
					'tar_id' 	=> $tar_id?$tar_id:"",

					'reporte_tareas' => $this->reporte_modelo->getReporteTareas(),
					
					'trabajadores' => $this->usuario_modelo->getLista(1, 'Trabajador'),
					'clientes' => $this->cliente_modelo->getLista(1),
					'centros' => $this->centro_modelo->getLista(1),
					'proyectos' => $this->proyecto_modelo->getLista(1),
					'eventos' => $this->evento_modelo->getLista($eve_state),
					'tareas' => $this->tarea_modelo->getLista(1),
				);	

		$this->layout->view("reporte_general_xlsx", $data);
	}

	public function test()
	{
		function calculateWorkHours($start, $end, $holidays = []) {
			$dayStart = 6;  // 06:00
			$dayEnd = 22;   // 22:00
		
			// Convertir las fechas a timestamps
			$startTimestamp = strtotime($start);
			$endTimestamp = strtotime($end);
		
			// Si la fecha de fin es menor que la de inicio, intercambiarlas
			if ($endTimestamp < $startTimestamp) {
				list($startTimestamp, $endTimestamp) = [$endTimestamp, $startTimestamp];
			}
		
			$dayHours = 0;
			$nightHours = 0;
			$typeDay = null;
			$typeNight = null;
		
			// Mientras la fecha de inicio sea menor que la fecha de fin
			while ($startTimestamp < $endTimestamp) {
				$currentHour = (int)date('H', $startTimestamp);
				$currentMinutes = (int)date('i', $startTimestamp);
				$currentDayOfWeek = (int)date('w', $startTimestamp);
				$currentDate = date('Y-m-d', $startTimestamp);
				$nextDate = date('Y-m-d', strtotime('+1 day', $startTimestamp));
				$prevDate = date('Y-m-d', strtotime('-1 day', $startTimestamp));
		
				// Determinar la hora de fin del siguiente segmento
				$nextHourTimestamp = $startTimestamp + 3600 - ($currentMinutes * 60); // Sumar hasta la siguiente hora
				if ($nextHourTimestamp > $endTimestamp) {
					$nextHourTimestamp = $endTimestamp;
				}
		
				$hours = ($nextHourTimestamp - $startTimestamp) / 3600;
		
				// Determinar si es horario festivo o laborable
				$isHoliday = in_array($currentDate, $holidays);
				$isNextHoliday = in_array($nextDate, $holidays);
				$isPrevHoliday = in_array($prevDate, $holidays);
		
				$isWeekendHoliday = ($currentDayOfWeek == 0 || 
					($currentDayOfWeek == 6 && $currentHour >= 22) || 
					($currentDayOfWeek == 0 && $currentHour < 22));
		
				// Verificación adicional para la noche laboral del domingo
				if ($currentDayOfWeek == 0 && $currentHour >= 22) {
					$isWeekendHoliday = false;
				}
		
				// Determinar si estamos en el periodo diurno o nocturno
				if ($currentHour >= $dayStart && $currentHour < $dayEnd) {
					$dayHours += $hours;
					if ($isHoliday) {
						$typeDay = "festivo día";
					} elseif ($isWeekendHoliday) {
						$typeDay = "festivo día";
					} else {
						$typeDay = "laborable día";
					}
				} else {
					$nightHours += $hours;
					if (($isHoliday && $currentHour < 22) || ($isPrevHoliday && $currentHour < 6) || ($currentHour >= 22 && $isNextHoliday) || ($currentDayOfWeek == 6 && $currentHour >= 22) || ($currentDayOfWeek == 0 && $currentHour < 6)) {
						$typeNight = "festivo noche";
					} elseif ($isWeekendHoliday && $currentHour < 22) {
						$typeNight = "festivo noche";
					} else {
						$typeNight = "laborable noche";
					}
				}
		
				// Avanzar al siguiente segmento
				$startTimestamp = $nextHourTimestamp;
			}
		
			return [
				'hora_dia' => $dayHours > 0 ? $dayHours : null,
				'tipo_hora_dia' => $dayHours > 0 ? $typeDay : null,
				'hora_noche' => $nightHours > 0 ? $nightHours : null,
				'tipo_hora_noche' => $nightHours > 0 ? $typeNight : null,
			];
		}
		
		// Lista de días festivos
		$holidays = [
			'2024-01-01', // Año Nuevo
			'2024-06-19', // Año Nuevo
			'2024-12-25', // Navidad
			'2024-12-26', // Boxing Day (ejemplo de feriado consecutivo)
			// Añadir más días festivos según sea necesario
		];
		
		// Ejemplos de uso:
		/*
		$examples = [
			['2024-06-19 22:00', '2024-06-20 05:00'],
			['2024-06-20 03:00', '2024-06-20 12:00'],
			['2024-06-20 08:00', '2024-06-20 14:00'],
			['2024-06-20 18:00', '2024-06-21 02:00'],
			['2024-06-22 19:00', '2024-06-23 02:00'],
			['2024-06-22 23:00', '2024-06-23 02:00'],
			['2024-06-23 03:00', '2024-06-23 11:00'],
			['2024-06-23 08:00', '2024-06-23 11:00'],
			['2024-06-23 18:00', '2024-06-23 23:00'],
			['2024-06-23 18:00', '2024-06-24 03:00'],
			['2024-12-20 18:30', '2024-12-21 02:30'],
			['2024-12-25 18:30', '2024-12-25 23:15'],
			['2024-12-25 18:30', '2024-12-26 02:30'], // Ejemplo de festivo consecutivo
			['2024-12-26 18:00', '2024-12-27 04:00'], // Transición de festivo a laborable
			['2024-06-16 21:00', '2024-06-16 23:15'], // Caso específico solicitado
			['2024-06-22 19:30', '2024-06-22 22:30'], // Ejemplo específico solicitado
		];*/

		$examples = [
			['2024-06-19 22:30:00', '2024-06-20 01:00:00'],
			['2024-06-20 20:00:00', '2024-06-20 23:00:00'],

			['2024-06-23 21:30:00', '2024-06-24 02:00:00'],
			['2024-06-22 19:30:00', '2024-06-22 22:30:00'],
			['2024-06-22 22:30:00', '2024-06-23 01:00:00'],
			['2024-06-22 15:30:00', '2024-06-22 21:30:00'],
		];
		
		foreach ($examples as $example) {
			$result = calculateWorkHours($example[0], $example[1], $holidays);
			echo "De " . $example[0] . " a " . $example[1] . ":<br>";
			foreach($result as $a){
				if($a != null) echo $a." - ";
			}
			echo "<br><br>";
		}
	}
public function test2(){
function calculateWorkHours($start, $end, $holidays) {
    $dayStart = 6;  // 06:00
    $dayEnd = 22;   // 22:00
    $nightStart = 22; // 22:00
    $nightEnd = 6;   // 06:00

    // Convertir las fechas a timestamps
    $startTimestamp = strtotime($start);
    $endTimestamp = strtotime($end);

    // Si la fecha de fin es menor que la de inicio, intercambiarlas
    /*if ($endTimestamp < $startTimestamp) {
        list($startTimestamp, $endTimestamp) = [$endTimestamp, $startTimestamp];
    }*/

    $dayHours = 0;
    $nightHours = 0;
    $typeDay = null;
    $typeNight = null;

    // Mientras la fecha de inicio sea menor que la fecha de fin
    while ($startTimestamp < $endTimestamp) {
    	echo $currentDate = date("Y-m-d H:i:s", $startTimestamp); echo "<br>";
        $currentHour = (int)date('H', $startTimestamp);
        $currentMinutes = (int)date('i', $startTimestamp);
        $currentDayOfWeek = (int)date('w', $startTimestamp);

        // Determinar la hora de fin del siguiente segmento
        $nextHourTimestamp = $startTimestamp + 3600 - ($currentMinutes * 60); // Sumar hasta la siguiente hora
        if ($nextHourTimestamp > $endTimestamp) {
            $nextHourTimestamp = $endTimestamp;
        }

        $hours = ($nextHourTimestamp - $startTimestamp) / 3600;

   		$nextDate = date('Y-m-d', strtotime('+1 day', $startTimestamp));
   		$nextTimestamp = strtotime($nextDate);

		$hours = ($nextHourTimestamp - $startTimestamp) / 3600;

		// Determinar si es horario festivo o laborable
		$startHoliday = in_array(date("Y-m-d", $startTimestamp), $holidays);
		$endHoliday = in_array(date("Y-m-d", $endTimestamp), $holidays);
		$nextHoliday = in_array(date("Y-m-d", $nextTimestamp), $holidays);

		echo "rangeNoche: ".rangoNoche($currentDate); echo "<br>";
		echo "startHoliday: ".$startHoliday; echo "<br>";
		echo "nextHoliday: ".$nextHoliday; echo "<br>";

        // Determinar si estamos en el periodo diurno o nocturno
        if ($dayStart <= $currentHour && $currentHour < $dayEnd) 
        {
        	if($startHoliday){
        		$dayHours += $hours;
        		$typeDay = "festivo día 1";
        	}else{
            	$dayHours += $hours;
            	$typeDay = "laborable día 1";
            }
        } 
        else 
        {
			//echo $startHoliday;
        	//averiguar si la hora es mayor a 22:00 y ademas si al dia siguiente es feriado
			if(rangoEntreNoche($currentDate) && !$nextHoliday){
            	$nightHours += $hours;
            	$typeNight = "laboral noche 2";
            }elseif(rangoEntreNoche($currentDate) && $nextHoliday){
        		$nightHours += $hours;
            	$typeNight = "festivo noche 2";
        	}elseif(rangoMadrugada($currentDate) && $startHoliday){
        		$nightHours += $hours;
            	$typeNight = "festivo noche 3";
        	}else{
            	$nightHours += $hours;
            	$typeNight = "laborable noche 3";
            }
            
        }

        // Avanzar al siguiente segmento
        $startTimestamp = $nextHourTimestamp;
		echo $typeNight;echo "<br>";
		echo "<hr>";
    }

    return [
        'hora_dia' => $dayHours > 0 ? $dayHours : null,
        'tipo_hora_dia' => $dayHours > 0 ? $typeDay : null,
        'hora_noche' => $nightHours > 0 ? $nightHours : null,
        'tipo_hora_noche' => $nightHours > 0 ? $typeNight : null,
    ];
}
//$holidays 7 [
$holidays = [
	'2024-06-17', // 
	'2024-06-18', // 
	'2024-06-19', // 
	'2024-12-25', // Navidad
	'2024-12-26', // Boxing Day (ejemplo de feriado consecutivo)
	// Añadir más días festivos según sea necesario
];
// Ejemplos de uso:
$examples = [
    //['2024-06-17 00:00:00', '2024-06-17 05:00:00'], //correcto
    //['2024-06-17 04:00:00', '2024-06-17 07:00:00'], //correcto
    //['2024-06-17 18:00:00', '2024-06-17 20:00:00'], //corecto
    //['2024-06-17 20:00:00', '2024-06-17 23:00:00'], //correcto
    ['2024-06-17 22:00:00', '2024-06-17 23:00:00'], //correcto
    //['2024-06-17 22:00:00', '2024-06-18 00:00:00'], //correcto
    //['2024-06-17 23:00:00', '2024-06-18 02:00:00'], //correcto
    //['2024-06-18 01:00:00', '2024-06-18 06:00:00'], //correcto
    //['2024-06-18 04:00:00', '2024-06-18 08:00:00'], //correcto
    //['2024-06-18 08:00:00', '2024-06-18 12:00:00'], //correcto
    //['2024-06-18 20:00:00', '2024-06-18 23:00:00'], //correcto
    //['2024-06-18 21:00:00', '2024-06-19 00:00:00'], //correcto
    //['2024-06-18 22:00:00', '2024-06-19 00:00:00'], //correcto
    //['2024-06-18 22:00:00', '2024-06-19 03:00:00'], //correcto
	
    //['2024-06-19 00:00:00', '2024-06-19 02:00:00'], //
];

foreach ($examples as $example) {
    $result = calculateWorkHours($example[0], $example[1], $holidays);
	echo "<br>";
    echo "De " . $example[0] . " a " . $example[1] . ":<br>";
    print_r($result);
    echo "<br>";
}


//echo "<hr><hr>";
//echo rangoNoche('2024-06-18 22:00:00');


}
}