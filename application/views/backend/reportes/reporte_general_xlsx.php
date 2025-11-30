<?php

/**
 * Exportar reportes a Excel con OpenSpout
 */
if (PHP_SAPI == 'cli') {
	die('This example should only be run from a Web Browser');
}

// Limpiar buffers previos
while (ob_get_level()) {
	ob_end_clean();
}

// OpenSpout
require_once APPPATH . 'libraries/OpenSpout/vendor/autoload.php';

use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Options;
use OpenSpout\Writer\XLSX\Writer;

// Estilos
$border = new Border(
	new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
	new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
	new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
	new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
);

$defaultStyle = new Style();
$defaultStyle->setFontName('Arial');
$defaultStyle->setFontSize(10);
$defaultStyle->setShouldWrapText(false);
$defaultStyle->setCellAlignment(CellAlignment::LEFT);
$defaultStyle->setCellVerticalAlignment(CellVerticalAlignment::CENTER);
$defaultStyle->setBorder($border);

// Estilo encabezado
$headerStyle = new Style();
$headerStyle->setFontBold();
$headerStyle->setFontSize(11);
$headerStyle->setCellAlignment(CellAlignment::CENTER);
$headerStyle->setCellVerticalAlignment(CellVerticalAlignment::CENTER);
$headerStyle->setBackgroundColor('E9E9E9');
$headerStyle->setBorder($border);

// Estilo datos
$dataStyle = new Style();
$dataStyle->setCellAlignment(CellAlignment::LEFT);
$dataStyle->setBorder($border);

// Estilo datos centrados
$dataCenterStyle = new Style();
$dataCenterStyle->setCellAlignment(CellAlignment::CENTER);
$dataCenterStyle->setBorder($border);

// Estilo totales
$totalStyle = new Style();
$totalStyle->setFontBold();
$totalStyle->setBackgroundColor('CCCCCC');
$totalStyle->setCellAlignment(CellAlignment::CENTER);
$totalStyle->setBorder($border);

// Crear writer
$options = new Options();
$options->DEFAULT_ROW_STYLE = $defaultStyle;
$writer = new Writer($options);
$writer->openToBrowser($filename . '.xlsx');

$sheet = $writer->getCurrentSheet();
$sheet->setName('Reportes');

// Títulos informativos
$titulo_row = array('REPORTES');
$writer->addRow(Row::fromValues($titulo_row, $headerStyle));

// Filtros aplicados
if (!empty($date_range)) {
	$writer->addRow(Row::fromValues(array('Fecha:', $date_range), $dataStyle));
}
if (!empty($cli_id)) {
	$cliente = $this->cliente_modelo->getId($cli_id);
	$writer->addRow(Row::fromValues(array('Cliente:', $cliente->cli_name), $dataStyle));
}
if (!empty($cen_id)) {
	$centro = $this->centro_modelo->getId($cen_id);
	$writer->addRow(Row::fromValues(array('Centro:', $centro->cen_name), $dataStyle));
}
if (!empty($pro_id)) {
	$proyecto = $this->proyecto_modelo->getId($pro_id);
	$writer->addRow(Row::fromValues(array('Proyecto:', $proyecto->pro_name), $dataStyle));
}
if (!empty($eve_id)) {
	$evento = $this->evento_modelo->getId($eve_id);
	$writer->addRow(Row::fromValues(array('Evento:', $evento->eve_name), $dataStyle));
}
if (!empty($tar_id)) {
	$tarea = $this->tarea_modelo->getId($tar_id);
	$writer->addRow(Row::fromValues(array('Tarea:', $tarea->tar_name), $dataStyle));
}
if (!empty($tra_id)) {
	$trabajador = $this->usuario_modelo->getId($tra_id);
	$writer->addRow(Row::fromValues(array('Trabajador:', $trabajador->usu_ap . ' ' . $trabajador->usu_am . ' ' . $trabajador->usu_nombre), $dataStyle));
}

// Fila vacía
$writer->addRow(Row::fromValues(array(''), $dataStyle));

// Encabezados de tabla
$titulos = array(
	'Fecha',
	'Trabajador',
	'Cliente',
	'Centro',
	'Proyecto',
	'Eventos',
	'Imputación',
	'Tarea'
);
if (isset($_GET['key'])) {
	$titulos[] = 'EVE_TRA_ID';
	$titulos[] = 'HORA';
}
$titulos[] = 'Tipo de hora';
$titulos[] = 'Horas Intranet';
$titulos[] = 'Multiplicador';
$titulos[] = 'Horas Computadas';
$titulos[] = 'Minutos Computados';

$writer->addRow(Row::fromValues($titulos, $headerStyle));

// Contar filas antes de los datos (para calcular referencias de fórmulas)
$fila_inicio_datos = 1; // Fila del título
if (!empty($date_range)) $fila_inicio_datos++;
if (!empty($cli_id)) $fila_inicio_datos++;
if (!empty($cen_id)) $fila_inicio_datos++;
if (!empty($pro_id)) $fila_inicio_datos++;
if (!empty($eve_id)) $fila_inicio_datos++;
if (!empty($tar_id)) $fila_inicio_datos++;
if (!empty($tra_id)) $fila_inicio_datos++;
$fila_inicio_datos++; // Fila vacía
$fila_inicio_datos++; // Fila de encabezados
$fila_inicio_datos++; // primera fila de datos
// $fila_inicio_datos ahora es la primera fila de datos

// Función para convertir número de columna a letra de Excel (1=A, 2=B, etc.)
$columnaALetra = function ($numero) {
	$letra = '';
	while ($numero > 0) {
		$modulo = ($numero - 1) % 26;
		$letra = chr(65 + $modulo) . $letra;
		$numero = intval(($numero - $modulo) / 26);
	}
	return $letra;
};

// Calcular índices de columnas
// Columnas: Fecha(1), Trabajador(2), Cliente(3), Centro(4), Proyecto(5), Eventos(6), Imputación(7), Tarea(8)
$col_base = 8; // Tarea es columna 8 (H)
if (isset($_GET['key'])) {
	// Con key: +2 columnas (EVE_TRA_ID=9, HORA=10)
	$col_tipo_hora = 11; // Tipo de hora
	$col_horas_intranet = 12; // Horas Intranet
	$col_multiplicador = 13; // Multiplicador
	$col_horas_computadas = 14; // Horas Computadas
	$col_minutos_computados = 15; // Minutos Computados
} else {
	// Sin key: Tipo de hora(9), Horas Intranet(10), Multiplicador(11), Horas Computadas(12), Minutos Computados(13)
	$col_tipo_hora = 9;
	$col_horas_intranet = 10;
	$col_multiplicador = 11;
	$col_horas_computadas = 12;
	$col_minutos_computados = 13;
}

$fila_actual = $fila_inicio_datos;

foreach ($reporte_tareas as $item):
	$feriados = $this->feriado_modelo->getFeriado_GetOnlyFecha($item->eve_date, $item->prov_id, $item->loc_id);

	// Obtener datos relacionados
	$tarea = $this->tarea_modelo->getId($item->eve_tar_ids);
	$horquilla = $this->horquillahoraria_modelo->getId($item->hor_id);

	// Inicializar variables de cálculo
	$resu = array(
		'hora_dia' => 0,
		'hora_noche' => 0,
		'hora_madrugada' => 0,
		'horquilla_dia' => '',
		'horquilla_noche' => '',
		'horquilla_madrugada' => '',
		'tipo_hora_dia' => '',
		'tipo_hora_noche' => '',
		'tipo_hora_madrugada' => ''
	);

	$resu_morning = array(
		'hora_madrugada' => 0,
		'hora_dia' => 0,
		'hora_noche' => 0,
		'tipo_hora_madrugada' => '',
		'tipo_hora_dia' => '',
		'tipo_hora_noche' => '',
		'horquilla_madrugada' => '',
		'horquilla_dia' => '',
		'horquilla_noche' => ''
	);

	$resu_afternoon = array(
		'hora_madrugada' => 0,
		'hora_dia' => 0,
		'hora_noche' => 0,
		'tipo_hora_madrugada' => '',
		'tipo_hora_dia' => '',
		'tipo_hora_noche' => '',
		'horquilla_madrugada' => '',
		'horquilla_dia' => '',
		'horquilla_noche' => ''
	);

	$resu_night = array(
		'hora_madrugada' => 0,
		'hora_dia' => 0,
		'hora_noche' => 0,
		'tipo_hora_madrugada' => '',
		'tipo_hora_dia' => '',
		'tipo_hora_noche' => '',
		'horquilla_madrugada' => '',
		'horquilla_dia' => '',
		'horquilla_noche' => ''
	);

	// Calcular horas según tipo de horario
	if ($item->eve_tipo_horario == "Continuo" and $item->eve_validar == 1) {
		$resu = calculoX(
			$item->eve_tar_horario_from,
			$item->eve_tar_horario_to,
			$horquilla,
			$feriados
		);
	} elseif ($item->eve_tipo_horario == "Partido") {
		if ($item->eve_tar_type == 'morning') {
			$resu_morning = calculoX(
				$item->eve_tar_horario_from,
				$item->eve_tar_horario_to,
				$horquilla,
				$feriados
			);
		}
		if ($item->eve_tar_type == 'afternoon') {
			$resu_afternoon = calculoX(
				$item->eve_tar_horario_from,
				$item->eve_tar_horario_to,
				$horquilla,
				$feriados
			);
		}
		if ($item->eve_tar_type == 'night') {
			$resu_night = calculoX(
				$item->eve_tar_horario_from,
				$item->eve_tar_horario_to,
				$horquilla,
				$feriados
			);
		}

		// Consolidar resultados de horario partido
		$dia = array();
		$noche = array();

		$dia['hora'] = $resu_morning['hora_dia'] + $resu_afternoon['hora_dia'] + $resu_night['hora_dia'];
		$noche['hora'] = $resu_morning['hora_noche'] + $resu_afternoon['hora_noche'] + $resu_night['hora_noche'];

		$dia['tipo_hora'] = $resu_morning['tipo_hora_dia'] . ' ' . $resu_afternoon['tipo_hora_dia'] . ' ' . $resu_night['tipo_hora_dia'];
		$noche['tipo_hora'] = $resu_morning['tipo_hora_noche'] . ' ' . $resu_afternoon['tipo_hora_noche'] . ' ' . $resu_night['tipo_hora_noche'];

		$dia['horquilla'] = $resu_morning['horquilla_dia'] . ' ' . $resu_afternoon['horquilla_dia'] . ' ' . $resu_night['horquilla_dia'];
		$noche['horquilla'] = $resu_morning['horquilla_noche'] . ' ' . $resu_afternoon['horquilla_noche'] . ' ' . $resu_night['horquilla_noche'];
	}

	// Preparar datos base (columnas que no tienen múltiples valores)
	$fecha_formateada = DateTime::createFromFormat('Y-m-d', $item->eve_date)->format('d/m/Y');
	$datos_base = array(
		$fecha_formateada,
		$item->usu_ap . ' ' . $item->usu_am . ' ' . $item->usu_nombre,
		$item->cli_name,
		$item->cen_name,
		$item->pro_name,
		$item->eve_name,
		$item->eve_imputacion,
		$tarea->tar_name
	);

	// Campos adicionales si existe key (NO se dividen en múltiples filas)
	$eve_tra_id_valor = '';
	$hora_text = '';
	if (isset($_GET['key'])) {
		$eve_tra_id_valor = $item->eve_tar_id;

		// HORA - NO se divide, se mantiene como texto con "\n"
		if ($item->eve_tipo_horario == "Continuo" and $item->eve_validar == 1) {
			$hora_text = $item->eve_tar_horario_from . "\n" . $item->eve_tar_horario_to;
		} elseif ($item->eve_tipo_horario == "Partido") {
			if ($item->eve_tar_type == 'morning') {
				$hora_text = "Mañana:\n" . $item->eve_tar_horario_from . "\n" . $item->eve_tar_horario_to;
			} elseif ($item->eve_tar_type == 'afternoon') {
				$hora_text = "Tarde:\n" . $item->eve_tar_horario_from . "\n" . $item->eve_tar_horario_to;
			} elseif ($item->eve_tar_type == 'night') {
				$hora_text = "Noche:\n" . $item->eve_tar_horario_from . "\n" . $item->eve_tar_horario_to;
			}
		}
	}

	// TIPO DE HORA - SÍ se divide en múltiples filas
	$tipo_hora_text = '';
	if ($item->eve_tipo_horario == "Continuo" and $item->eve_validar == 1) {
		$tipos = array();
		if ($resu['tipo_hora_madrugada']) $tipos[] = $resu['tipo_hora_madrugada'];
		if ($resu['tipo_hora_dia']) $tipos[] = $resu['tipo_hora_dia'];
		if ($resu['tipo_hora_noche']) $tipos[] = $resu['tipo_hora_noche'];
		$tipo_hora_text = implode("\n", $tipos);
	} elseif ($item->eve_tipo_horario == "Partido") {
		$tipos = array();
		if ($dia['tipo_hora']) $tipos[] = remove_word_repeat($dia['tipo_hora']);
		if ($noche['tipo_hora']) $tipos[] = remove_word_repeat($noche['tipo_hora']);
		$tipo_hora_text = implode("\n", $tipos);
	}
	$tipo_hora_valores = !empty($tipo_hora_text) ? explode("\n", trim($tipo_hora_text)) : array('');

	// MULTIPLICADOR - SÍ se divide en múltiples filas
	$multiplicador_text = '';
	if ($item->eve_tipo_horario == "Continuo") {
		$multis = array();
		if ($resu['horquilla_dia']) $multis[] = $resu['horquilla_dia'];
		if ($resu['horquilla_noche']) $multis[] = $resu['horquilla_noche'];
		$multiplicador_text = implode("\n", $multis);
	} elseif ($item->eve_tipo_horario == "Partido") {
		$multis = array();
		if ($dia['horquilla']) $multis[] = remove_word_repeat($dia['horquilla']);
		if ($noche['horquilla']) $multis[] = remove_word_repeat($noche['horquilla']);
		$multiplicador_text = implode("\n", $multis);
	}
	$multiplicador_valores = !empty($multiplicador_text) ? explode("\n", trim($multiplicador_text)) : array('');

	// HORAS INTRANET - SÍ se divide en múltiples filas
	$x2 = $x3 = 0;
	$horas_intranet_valores = array();
	if ($item->eve_tipo_horario == "Continuo") {
		if ($resu['hora_dia']) {
			$x2 = (float)numeroFormateado($resu['hora_dia']);
			$horas_intranet_valores[] = $x2;
		}
		if ($resu['hora_noche']) {
			$x3 = (float)numeroFormateado($resu['hora_noche']);
			$horas_intranet_valores[] = $x3;
		}
	} elseif ($item->eve_tipo_horario == "Partido") {
		if ($dia['hora']) {
			$x2 = (float)numeroFormateado($dia['hora']);
			$horas_intranet_valores[] = $x2;
		}
		if ($noche['hora']) {
			$x3 = (float)numeroFormateado($noche['hora']);
			$horas_intranet_valores[] = $x3;
		}
	}
	// Si no hay valores, agregar un 0 para mantener al menos una fila
	if (empty($horas_intranet_valores)) {
		$horas_intranet_valores = array(0);
	}

	// HORAS COMPUTADAS - SÍ se divide en múltiples filas
	$suma_horas_madrugada = 0;
	$suma_horas_dia = 0;
	$suma_horas_noche = 0;
	$horas_computadas_valores = array();

	if ($item->eve_tipo_horario == "Continuo") {
		if ($resu['horquilla_dia']) {
			$suma_horas_dia = (float)numeroFormateado($resu['horquilla_dia'] * $resu['hora_dia']);
			$horas_computadas_valores[] = $suma_horas_dia;
		}
		if ($resu['horquilla_noche']) {
			$suma_horas_noche = (float)numeroFormateado($resu['horquilla_noche'] * $resu['hora_noche']);
			$horas_computadas_valores[] = $suma_horas_noche;
		}
	} elseif ($item->eve_tipo_horario == "Partido") {
		if ($dia['hora']) {
			$suma_horas_dia = (float)numeroFormateado((float)remove_word_repeat($dia['horquilla']) * $dia['hora']);
			$horas_computadas_valores[] = $suma_horas_dia;
		}
		if ($noche['hora']) {
			$suma_horas_noche = (float)numeroFormateado((float)remove_word_repeat($noche['horquilla']) * $noche['hora']);
			$horas_computadas_valores[] = $suma_horas_noche;
		}
	}
	// Si no hay valores, agregar un 0 para mantener al menos una fila
	if (empty($horas_computadas_valores)) {
		$horas_computadas_valores = array(0);
	}
	$suma_horas = (float)($suma_horas_madrugada + $suma_horas_dia + $suma_horas_noche);

	// MINUTOS COMPUTADOS - suma total de todas las horas computadas (se fusionará)
	$minutos_computados_total = 0;
	foreach ($horas_computadas_valores as $horas_comp) {
		$minutos_computados_total += (float)($horas_comp * 60);
	}

	// Determinar cuántas filas necesitamos (Tipo de hora, Horas Intranet, Multiplicador y Horas Computadas generan filas múltiples)
	$num_filas = max(1, count($tipo_hora_valores), count($horas_intranet_valores), count($multiplicador_valores), count($horas_computadas_valores));

	// Crear las filas
	$fila_inicio_item = $fila_actual;
	for ($i = 0; $i < $num_filas; $i++) {
		$fila = array();

		// Agregar datos base (se fusionarán después)
		foreach ($datos_base as $valor) {
			$fila[] = $valor;
		}

		// Campos condicionales (NO se fusionan, pero tampoco se dividen)
		if (isset($_GET['key'])) {
			$fila[] = $eve_tra_id_valor; // EVE_TRA_ID - mismo valor en todas las filas, NO se fusiona
			$fila[] = $hora_text; // HORA - mismo valor en todas las filas (con "\n"), NO se fusiona
		}

		// TIPO DE HORA - diferente por fila
		$fila[] = isset($tipo_hora_valores[$i]) ? $tipo_hora_valores[$i] : '';

		// HORAS INTRANET - diferente por fila
		$fila[] = isset($horas_intranet_valores[$i]) ? $horas_intranet_valores[$i] : 0;

		// MULTIPLICADOR - diferente por fila
		$fila[] = isset($multiplicador_valores[$i]) ? (float)$multiplicador_valores[$i] : '';

		// HORAS COMPUTADAS - diferente por fila
		$horas_computadas_fila = isset($horas_computadas_valores[$i]) ? $horas_computadas_valores[$i] : 0;
		$fila[] = $horas_computadas_fila;

		// MINUTOS COMPUTADOS - suma total (se fusionará, solo en primera fila)
		$fila[] = ($i === 0) ? (float)$minutos_computados_total : '';

		$writer->addRow(Row::fromValues($fila, $dataStyle));
		$fila_actual++;
	}

	// Fusionar celdas verticalmente para las columnas que no tienen múltiples valores
	// OpenSpout usa índices 1-based para filas, 0-based para columnas
	$fila_fin_item = $fila_actual - 1;
	if ($num_filas > 1) {
		// Fusionar columnas base (0-7): Fecha, Trabajador, Cliente, Centro, Proyecto, Eventos, Imputación, Tarea
		for ($col = 0; $col < 8; $col++) {
			$options->mergeCells($col, $fila_inicio_item, $col, $fila_fin_item);
		}

		// NO fusionar EVE_TRA_ID ni HORA si existe key (columnas 8 y 9)
		// (se mantienen iguales en todas las filas pero no se fusionan)

		// NO fusionar Horas Intranet (tiene múltiples valores por fila)
		// Sin key: columna 9 (0-7: datos base, 8: Tipo de hora, 9: Horas Intranet)
		// Con key: columna 11 (0-7: datos base, 8: EVE_TRA_ID, 9: HORA, 10: Tipo de hora, 11: Horas Intranet)

		// NO fusionar Horas Computadas (tiene múltiples valores por fila)
		// Sin key: columna 11 (9: Horas Intranet, 10: Multiplicador, 11: Horas Computadas)
		// Con key: columna 13 (11: Horas Intranet, 12: Multiplicador, 13: Horas Computadas)

		// Fusionar Minutos Computados (suma total de todas las filas)
		// Sin key: columna 12 (después de Horas Computadas=11)
		// Con key: columna 14 (después de Horas Computadas=13)
		$col_minutos_merge = isset($_GET['key']) ? 14 : 12;
		$options->mergeCells($col_minutos_merge, $fila_inicio_item, $col_minutos_merge, $fila_fin_item);
	}

endforeach;

// Calcular referencias para las fórmulas
$fila_fin_datos = $fila_actual - 1;

// Crear fórmulas SUM solo si hay datos
if ($fila_fin_datos >= $fila_inicio_datos) {
	$letra_horas_intranet = $columnaALetra($col_horas_intranet);
	$letra_horas_computadas = $columnaALetra($col_horas_computadas);
	$letra_minutos_computados = $columnaALetra($col_minutos_computados);

	$formula_horas_intranet = '=SUBTOTAL(109,' . $letra_horas_intranet . $fila_inicio_datos . ':' . $letra_horas_intranet . $fila_fin_datos . ')';
	$formula_horas_computadas = '=SUBTOTAL(109,' . $letra_horas_computadas . $fila_inicio_datos . ':' . $letra_horas_computadas . $fila_fin_datos . ')';
	$formula_minutos_computados = '=SUBTOTAL(109,' . $letra_minutos_computados . $fila_inicio_datos . ':' . $letra_minutos_computados . $fila_fin_datos . ')';
} else {
	// Si no hay datos, usar fórmulas que devuelven 0
	$formula_horas_intranet = '=0';
	$formula_horas_computadas = '=0';
	$formula_minutos_computados = '=0';
}

// Fila de totales
$totales = array(
	'',
	'',
	'',
	'',
	'',
	'',
	'',
	''
);
if (isset($_GET['key'])) {
	$totales[] = '';
	$totales[] = '';
}
$totales[] = 'SUMATORIA =>';
$totales[] = $formula_horas_intranet; // Fórmula en lugar de valor
$totales[] = '';
$totales[] = $formula_horas_computadas; // Fórmula en lugar de valor
$totales[] = $formula_minutos_computados; // Fórmula en lugar de valor

// Fila vacía
$writer->addRow(Row::fromValues(array(''), $dataStyle));

$writer->addRow(Row::fromValues($totales, $totalStyle));

// Cerrar y enviar
$writer->close();
exit;

