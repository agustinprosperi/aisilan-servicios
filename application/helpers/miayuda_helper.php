<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function formato_fecha($date, $type_month="completo"){
    if($type_month == "completo")
        return mes_completo(date('m', strtotime($date)))." ".date('d, Y', strtotime($date));
    else
        return mes(date('m', strtotime($date)))." ".date('d, Y', strtotime($date));
}
function horaMinuto($fecha){
    return date("H:i", strtotime($fecha));
}

function helperGetEmpresa($modelo_name, $function_name, $ue_id_actual)
{
    $ci = &get_instance();
    $ci->load->model($modelo_name);
    return $ci->$modelo_name->$function_name($ue_id_actual);
}

function helperGetGestionActual()
{
    $ci = &get_instance();
    $ci->load->model("gestion_modelo");
    return $ci->gestion_modelo->getGestionActual();
}

function helperGetNotificacionesMenu($limit='')
{
    $ci = &get_instance();
    $ci->load->model("notificacion_modelo");
    return $ci->notificacion_modelo->lista_notificaciones_menu($limit);
}

function uri_current($controller_current, $sw, $my_model, $method="index", $state='', $eve_tipo="Simple", $eve_id_padre="", $usu_tipo_actual='')
{
    $all = ""; $active = ""; $inactive = ""; $close = "";

    switch ($sw) {
        case 'all':
            $all = "uri-current";
            break;
        case '0':
            $inactive = "uri-current";
            break;
        case '1':
            $active = "uri-current";
            break;
        case '2':
            $close = "uri-current";
            break;
    }

    $text  = "<a href='".base_url() . "backend/$controller_current/$method/all/".$eve_tipo."/".$eve_id_padre."' class='$all all-items'>Todos(".count($my_model->getLista('all', $eve_tipo))."),</a>&nbsp;";
    $text .= "<a href='".base_url() . "backend/$controller_current/$method/1/".$eve_tipo."/".$eve_id_padre."' class='$active active-items'>Activos(".count($my_model->getLista('1', $eve_tipo)).")</a>,&nbsp;";
    $text .= "<a href='".base_url() . "backend/$controller_current/$method/0/".$eve_tipo."/".$eve_id_padre."' class='$inactive inactive-items'>Inactivos(".count($my_model->getLista('0', $eve_tipo)).")</a>";
    if($state=='close') $text .= ",&nbsp;<a href='".base_url() . "backend/$controller_current/$method/2/".$eve_tipo."/".$eve_id_padre."' class='$close inactive-items ".(($usu_tipo_actual=="Coordinador")?"pointer-events-none":"")."'>Cerrados(".count($my_model->getLista('2', $eve_tipo)).")</a>";

    echo $text;
}

function uri_current_user($controller_current, $w, $my_model, $method="index", $tipo = '')
{
    $all = ""; $active = ""; $inactive = ""; $disable = "";

    switch ($w) {
        case '':
            $all = "uri-current";
            break;
        case '0':
            $inactive = "uri-current";
            break;
        case '1':
            $active = "uri-current";
            break;
        case '3':
            $disable = "uri-current";
            break;
    }
    $text  = "<a href='".base_url() . "backend/$controller_current/$method/' class='$all all-items'>Todos(".count($my_model->getLista(''))."), </a> ";
    $text .= "<a href='".base_url() . "backend/$controller_current/$method/1/$tipo/' class='$active active-items'>Activos(".count($my_model->getLista('1', $tipo))."),</a> ";
    $text .= "<a href='".base_url() . "backend/$controller_current/$method/0/$tipo/' class='$inactive inactive-items'>Inactivos(".count($my_model->getLista('0', $tipo)).")</a>";

    echo $text;
}

function cadena_aleatoria($numerodeletras = 10)
{
    $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
    //$numerodeletras=10; //numero de letras para generar el texto
    $cadena = ""; //variable para almacenar la cadena generada
    for($i=0;$i<$numerodeletras;$i++)
    {
        $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres
    entre el rango 0 a Numero de letras que tiene la cadena */
    }
    return $cadena;
}

function generar_num_aleatorio($min=0, $max=100) {
    return rand($min, $max);
}

/**
 * ***************************************************************************************************
 * convertir un numero a letras
 * ***************************************************************************************************
 */
//------    CONVERTIR NUMEROS A LETRAS         ---------------
//------    Máxima cifra soportada: 18 dígitos con 2 decimales
//------    999,999,999,999,999,999.99
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE BILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE MILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE PESOS 99/100 M.N.
//------    Creada por:                        ---------------
//------             ULTIMINIO RAMOS GALÁN     ---------------
//------            uramos@gmail.com           ---------------
//------    10 de junio de 2009. México, D.F.  ---------------
//------    PHP Version 4.3.1 o mayores (aunque podría funcionar en versiones anteriores, tendrías que probar)
function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {

                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UNO";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= ""; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

// END FUNCTION
/**
 * ***************************************************************************************************
 * fin - convertir un numero a letras
 * ***************************************************************************************************
 */

function dia_semana($fecha)
{
    $dias=array("DO","LU","MA","MI" ,"JU","VI","SA");

    // supongamos que la variable se llama fecha y le asignamos una fecha
    // esto ya debe venir, aqui lo asigno para demostración

    //$fecha="1982-12-09" ; // mi cumpleaños, jeje


    // esto que viene no es muy común la mayoría usa explode, solo que
    // te genera un array y se hace más confuso, yo prefiero para mayor
    // entendimiento separar la fecha en subcadenas y asignarlas a variables
    // relacionadas en contenido, por ejemplo dia, mes
    $fecha_array = explode("-", $fecha);

    $dia = $fecha_array[0];
    $mes = $fecha_array[1];
    $anio = $fecha_array[2];

    // en la siguiente instrucción $pru toma el día de la semana, lunes, martes,
    // etc, dependiendo de la fecha
    return strtoupper($dias[intval((date("w",mktime(0,0,0,$mes,$dia,$anio))))]);
}

/**
 * Calculo de numero de dias entre fechas, excepto los domingos
 */
function numero_dias($desde, $hasta)
{
    $fecha1 = strtotime($desde);
    $fecha2 = strtotime($hasta);
    $i=0;
    for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('d-m-Y',$fecha1)))
        if((strcmp(date('D',$fecha1),'Sun')!=0) && (strcmp(date('D',$fecha1),'Sat')!=0))
        //if(strcmp(date('D',$fecha1),'Sun')!=0)
            $i++;

    return $i;
}

function mes($key=""){
    $array = array(
        "01" => "Ene",
        "02" => "Feb",
        "03" => "Mar",
        "04" => "Abr",
        "05" => "May",
        "06" => "Jun",
        "07" => "Jul",
        "08" => "Ago",
        "09" => "Sep",
        "10" => "Oct",
        "11" => "Nov",
        "12" => "Dic"
    );

    if($key != "")
        return $array[$key];
    else
        return $array;
}

function mes_completo($key=""){
    $array = array(
        "01" => "Enero",
        "02" => "Febrero",
        "03" => "Marzo",
        "04" => "Abril",
        "05" => "Mayo",
        "06" => "Junio",
        "07" => "Julio",
        "08" => "Agosto",
        "09" => "Septiembre",
        "10" => "Octubre",
        "11" => "Noviembre",
        "12" => "Diciembre"
    );

    if($key != "")
        return $array[$key];
    else
        return $array;
}


function check_in_range()
{
    $CI = & get_instance();  //get instance, access the CI superobject
    $gestion_actual = $CI->session->userdata('gestion_actual');

    $CI = &get_instance();
    $CI->load->model("fechas_modelo");
    $fecha_db = $CI->fechas_modelo->getId($gestion_actual);

    $fecha_inicio = strtotime($fecha_db['fec_desde']." ".$fecha_db['hor_desde'].":00");
    $fecha_fin = strtotime($fecha_db['fec_hasta']." ".$fecha_db['hor_hasta'].":00");
    $fecha = strtotime(date("Y-m-d H:i:s"));

    if(($fecha_inicio <= $fecha) && ($fecha <= $fecha_fin))
    {
        return true;

    } else {
        return false;
    }
}

function randomPassword($num = 5) {
    $alphabet = 'abcdefghijkmnpqrstuvwyzABCDEFGHKLMNPQRSTUVWYZ23456789';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $num; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

/**
 * retornar estado de permiso, 0, 1
 */
function permiso($modulo, $rol)
{
    $ci = &get_instance();
    $ci->load->model("usuario_modelo");
    $permiso = $ci->usuario_modelo->getPermiso($modulo, $rol);

    if($permiso == "1")
        $estado = "checked";
    elseif($permiso == "0")
        $estado = "";

    return $estado;
}

function verificarPermiso($modulo)
{

    $ci = &get_instance();
    $ci->load->model("usuario_modelo");
    $rol_actual = $ci->session->userdata('usu_tipo_actual');

    if($rol_actual == "Super_admin")
        return 1;
    else
        return $ci->usuario_modelo->getPermiso($modulo, $rol_actual);
}

function hora($key=''){
    $array = array(
        "00:00" => "00:00",
        "01:00" => "01:00",
        "02:00" => "02:00",
        "03:00" => "03:00",
        "04:00" => "04:00",
        "05:00" => "05:00",
        "06:00" => "06:00",
        "07:00" => "07:00",
        "08:00" => "08:00",
        "09:00" => "09:00",
        "10:00" => "10:00",
        "11:00" => "11:00",
        "12:00" => "12:00",
        "13:00" => "13:00",
        "14:00" => "14:00",
        "15:00" => "15:00",
        "16:00" => "16:00",
        "17:00" => "17:00",
        "18:00" => "18:00",
        "19:00" => "19:00",
        "20:00" => "20:00",
        "21:00" => "21:00",
        "22:00" => "22:00",
        "23:00" => "23:00"
    );

    if($key != "")
        return $array[$key];
    else
        return $array;
}
/*
function calcularHorasDiaNocheRango($horaInicio, $horaFin, $horaAmanecer = "06:00:00", $horaAtardecer = "22:00:00") {
    $horaFin = restarHora($horaFin, '00:01:00');

    $horasDia = "00:00:00";
    $horasNoche = "00:00:00";
    $horasMadrugada = "00:00:00";

    $horaFinInit = $horaFin;

    $horaInicio = date("H:i:s", strtotime($horaInicio));
    $horaFin = date("H:i:s", strtotime($horaFin));

    if(strtotime($horaInicio) > strtotime($horaFin))
        $horaFin = "23:59:00";

    $i = $horaInicio; 
    // Asumimos que el día tiene 24 horas
    $sw = true;
    while (strtotime($i) <= strtotime($horaFin)) 
    {
        // Si la hora actual está entre el amanecer y el atardecer, es día
        if (strtotime($i) >= strtotime($horaAmanecer) && strtotime($i) < strtotime($horaAtardecer)) {
            $horasDia = sumarHora($horasDia, '00:01:00');
        } else {
            $horasNoche = sumarHora($horasNoche, '00:01:00');
        }
        if(!$sw and strtotime($i) < strtotime($horaAmanecer)) $horasMadrugada = sumarHora($horasMadrugada, '00:01:00');

        if(strtotime($i) == strtotime('23:59:00') and $sw){
            $horaFin = $horaFinInit;
            $i = '00:00:00';
            $sw = false;
        }else
            $i = sumarHora($i, '00:01:00');
    }           

    return array(
        "hora_dia" => $horasDia, 
        "hora_noche" => $horasNoche,
        "hora_madrugada" => $horasMadrugada,
    );
}

function sumarHora($hora1, $hora2)
{
    list($h, $m, $s) = explode(':', $hora2); //Separo los elementos de la segunda hora
    $a = new DateTime($hora1); //Creo un DateTime
    $b = new DateInterval(sprintf('PT%sH%sM%sS', $h, $m, $s)); //Creo un DateInterval
    $a->add($b); //SUMO las horas
    return $a->format('H:i:s'); //Retorno la Suma
}

function restarHora($hora1, $hora2)
{
    list($h, $m, $s) = explode(':', $hora2); //Separo los elementos de la segunda hora
    $a = new DateTime($hora1); //Creo un DateTime
    $b = new DateInterval(sprintf('PT%sH%sM%sS', $h, $m, $s)); //Creo un DateInterval
    $a->sub($b); //RESTO las horas
    return $a->format('H:i:s'); //Retorno la Resta
}*/

function hoursToMinutes($hours) 
{ 
    $minutes = 0; 
    if (strpos($hours, ':') !== false) 
    { 
        // Split hours and minutes. 
        list($hours, $minutes, $seconds) = explode(':', $hours); 
    } 
    return $hours * 60 + $minutes; 
}




















function calcularHorasEntreFechas($fechaInicio, $fechaFin) {
    $date1 = strtotime($fechaInicio);
    $date2 = strtotime($fechaFin);
    return ($date2 - $date1)/3600;
}

function rangoDia($fechaHora) {
    $fecha = date("Y-m-d", strtotime($fechaHora));
    $fechaInicio = $fecha . " 06:00:00";
    $fechaFin = $fecha . " 22:00:00";
    // Convertir las fechas a marcas de tiempo UNIX
    $fechaHoraUnix = strtotime($fechaHora);
    $fechaInicioUnix = strtotime($fechaInicio);
    $fechaFinUnix = strtotime($fechaFin);

    // Verificar si la fecha y hora está dentro del rango
    if ($fechaHoraUnix >= $fechaInicioUnix && $fechaHoraUnix <= $fechaFinUnix) {
        return true;
    } else {
        return false;
    }
}
function rangoNoche($fechaHora) {
    $fechaHoraUnix = strtotime($fechaHora);

    // Obtener la fecha en formato Y-m-d
    $fecha = date("Y-m-d", $fechaHoraUnix);

    // Calcular el inicio y el fin del rango de tiempo en formato UNIX
    $inicioNocheUnix = strtotime($fecha . " 22:00:00");
    $finNocheUnix = strtotime($fecha . " 06:00:00 +1 day");

    // Si la hora actual es antes de las 06:00, ajustar el inicio de la noche al día anterior
    if ($fechaHoraUnix < strtotime($fecha . " 06:00:00")) {
        $inicioNocheUnix = strtotime($fecha . " 22:00:00 -1 day");
        $finNocheUnix = strtotime($fecha . " 06:00:00");
    }

    // Verificar si la fecha y hora está dentro del rango
    if ($fechaHoraUnix >= $inicioNocheUnix && $fechaHoraUnix <= $finNocheUnix) {
        return true;
    } else {
        return false;
    }
}
function rangoEntreNoche($fechaHora) {
    $fecha = date("Y-m-d", strtotime($fechaHora));
    $fecha_dia_siguiente = date("Y-m-d", strtotime($fechaHora.'+1 day'));
    $fechaInicio = $fecha . " 22:00:00";
    $fechaFin = $fecha_dia_siguiente . "00:00:00";
    // Convertir las fechas a marcas de tiempo UNIX
    $fechaHoraUnix = strtotime($fechaHora);
    $fechaInicioUnix = strtotime($fechaInicio);
    $fechaFinUnix = strtotime($fechaFin);

    // Verificar si la fecha y hora está dentro del rango
    if ($fechaHoraUnix >= $fechaInicioUnix && $fechaHoraUnix <= $fechaFinUnix) {
        return true;
    } else {
        return false;
    }
}
function rangoMadrugada($fechaHora) {
    $fecha = date("Y-m-d", strtotime($fechaHora));
    $fechaInicio = $fecha . " 00:00:00";
    $fechaFin = $fecha . "06:00:00";
    // Convertir las fechas a marcas de tiempo UNIX
    $fechaHoraUnix = strtotime($fechaHora);
    $fechaInicioUnix = strtotime($fechaInicio);
    $fechaFinUnix = strtotime($fechaFin);

    // Verificar si la fecha y hora está dentro del rango
    if ($fechaHoraUnix >= $fechaInicioUnix && $fechaHoraUnix <= $fechaFinUnix) {
        return true;
    } else {
        return false;
    }
}
function remove_word_repeat($text){
    return implode(' ', array_unique(explode(' ', $text)));
}

function turno($text){
    if($text == 'morning') return "Mañana";
    elseif($text == 'afternoon') return "Tarde";
    elseif($text == 'night') return "Noche";
    elseif($text == 'continue') return "Continuo";
    else return "ERROR";
}
function getTareaByNombres($tareas_ids){
    $tareas_text = array();
    $array_tareas = explode(',', $tareas_ids);
    $ci = &get_instance();
    $ci->load->model('tarea_modelo');
    
    foreach($array_tareas as $tar_id){
        $obj = $ci->tarea_modelo->getId($tar_id);
        $tareas_text[] = $obj->tar_name; 
    }
    return implode(', ', $tareas_text);

}
function calcularHorasYMinutos($fecha_inicio, $fecha_fin) {
    // Convertir las fechas a objetos DateTime
    $inicio = new DateTime($fecha_inicio);
    $fin = new DateTime($fecha_fin);

    // Calcular la diferencia entre las fechas
    $diferencia = $inicio->diff($fin);

    // Obtener las horas y minutos de la diferencia
    $horas = $diferencia->h;
    $minutos = $diferencia->i;

    // Devolver las horas y minutos como un array
    return array('horas' => $horas, 'minutos' => $minutos);
}
function notificacion_tipo_menu($not_type){
    if($not_type == "2") return '<i class="fa fa-times-circle color-red font-size-16"></i>';
    if($not_type == "1") return '<i class="fa fa-warning color-orange font-size-16"></i>';
    if($not_type == "0") return '<i class="fa fa-info-circle color-blue font-size-16"></i>';
}
function notificacion_tipo($not_type){
    if($not_type == "2") return '<span class="label label-danger"><i class="fa fa-times-circle color-white"></i> Error de tarea</span>';
    if($not_type == "1") return '<span class="label label-warning"><i class="fa fa-warning color-white"></i> Advertencia</span>';
    if($not_type == "0") return '<span class="label label-info"><i class="fa fa-info-circle color-white"></i> Informativo</span>';
}
function tarea_observaciones($eve_validar){
    if($eve_validar == 0) return " Registrada ";
    if($eve_validar == 1) return "<span class='label label-success'>Validada</span>";
    if($eve_validar == 2) return "<span class='label label-danger bold'>Invalidada</span>";
}

function modal_lista_mensajes_trabajador($item, $notificaciones){
    ?>
    <!-- Modal -->
    <div class="modal fade" id="notaTrabajadorModal-<?php echo $item->eve_tar_id ?>" role="dialog" aria-labelledby="notaTrabajadorModal-<?php echo $item->eve_tar_id ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-600" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trabajadorModalLabel">Mensajes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mensaje</th>
                                <th>Tipo</th>
                                <th width="150">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($notificaciones as $sms): ?>
                            <tr>
                                <td><?php echo $sms->not_message ?></td>
                                <td><?php echo notificacion_tipo($sms->not_type) ?></td>
                                <td><?php echo formato_fecha($sms->created_at); echo " ".date("H:i", strtotime($sms->created_at)) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal -->
    <?php
}

function modal_notas_para_trabajador($tar, $eve_id, $notificaciones){
    ?>
    <div class="modal fade" id="notaParaTrabajadorModal-<?php echo $tar->eve_tar_id ?>" role="dialog" aria-labelledby="notaParaTrabajadorModal-<?php echo $tar->eve_tar_id ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-600" role="document">
            <form id="form-sms-<?php echo $tar->eve_tar_id ?>" method="post" class="modal-content validate2">
                <div class="modal-header">
                    <h5 class="modal-title" id="trabajadorModalLabel">Enviar mensaje al trabajador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="respuesta-mensaje-<?php echo $tar->eve_tar_id ?>"></div>
                    <div class="form-group">
                        <label for="not_message" class="control-label">Ingrese el mensaje <span class="required">*</span></label>
                        <textarea name="not_message" id="not_message" rows="5" class="form-control required"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Tipo de mensaje</label>
                        <div class="">
                            <label class="radio-inline"><input type="radio" value="2" name="not_type" class="uniform" checked> Error de tarea</label>
                            <label class="radio-inline"><input type="radio" value="1" name="not_type" class="uniform"> Advertencia</label>
                            <label class="radio-inline"><input type="radio" value="0" name="not_type" class="uniform" checked> Informativo</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>

                    <input type="hidden" name="eve_id" value="<?php echo $eve_id ?>">
                    <input type="hidden" name="tra_id" value="<?php echo $tar->tra_id ?>">
                    <input type="hidden" name="eve_tar_id" value="<?php echo $tar->eve_tar_id ?>">
                
                    <div class="mt20 bg-white">
                        <?php 
                        if(count($notificaciones) > 0):
                        ?>
                        <table class="table text-left mt20">
                            <thead>
                                <tr>
                                    <th>Mensaje</th>
                                    <th>Tipo</th>
                                    <th width="150">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($notificaciones as $sms): ?>
                                <tr>
                                    <td><?php echo $sms->not_message ?></td>
                                    <td><?php echo notificacion_tipo($sms->not_type) ?></td>
                                    <td><?php echo formato_fecha($sms->created_at); echo " ".date("H:i", strtotime($sms->created_at)) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#form-sms-'+<?php echo $tar->eve_tar_id ?>).submit(function(e) {
                // Evitar el comportamiento predeterminado del formulario
                e.preventDefault();
                
                // Obtener los datos del formulario
                var formData = $(this).serialize();
                
                // Enviar los datos mediante AJAX
                $.ajax({
                    type: 'POST', // Método de envío
                    url: '<?php echo base_url() ?>backend/eventos/crear_notificacion_trabajador', // URL del script de procesamiento
                    data: formData, // Datos a enviar
                success: function(response) {
                    // Manejar la respuesta del servidor
                    $('#respuesta-mensaje-<?php echo $tar->eve_tar_id; ?>').html(response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    console.error(xhr.responseText);
                }
                });
            });
        });
    </script>
    <?php
}

function modal_notas_del_trabajdor($tar){
    if($tar->eve_tar_nota): ?> 
    <!-- Modal -->
    <span data-toggle="modal" data-target="#notaTrabajadorModal-<?php echo $tar->eve_tar_id ?>"><i class="fa fa-commenting icon-comment cursor" aria-hidden="true"></i></span>
    <div class="modal fade" id="notaTrabajadorModal-<?php echo $tar->eve_tar_id ?>" role="dialog" aria-labelledby="notaTrabajadorModal-<?php echo $tar->eve_tar_id ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-500" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trabajadorModalLabel">Notas del trabajador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $tar->eve_tar_nota ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal -->
    <?php
    endif;
}


function modal_notas_de_tarea($tar){
   
    if($tar->eve_tar_nota): ?>
                                                                            
    <span data-toggle="modal" data-target="#notaCoordinadorModal-<?php echo $tar->eve_tar_id ?>"><i class="fa fa-commenting-o icon-comment cursor" aria-hidden="true"></i></span>
    <!-- Modal -->
    <div class="modal fade" id="notaCoordinadorModal-<?php echo $tar->eve_tar_id ?>" role="dialog" aria-labelledby="notaCoordinadorModal-<?php echo $tar->eve_tar_id ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-500" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trabajadorModalLabel">Notas de la tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $tar->eve_tar_nota ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal -->
    <?php endif;
}

// Devuelve un numero solo con dos digitos, ej: 12.666666 =  12.67 y si tenemos 2.00 = 2
function numeroFormateado($numero){
    $formateado = number_format($numero, 2, '.', '');
    return rtrim(rtrim($formateado, '0'), '.');
}

/**
 * Functión para cambiar la nueva fecha a otras 2 fechas to y from
 */
function cambiar_fecha($nueva_fecha, $horario_from, $horario_to){

    // Convertir las fechas originales a objetos DateTime para facilitar la manipulación
    $from_date = new DateTime($horario_from);
    $to_date = new DateTime($horario_to);

    // Extraer las horas y minutos de las fechas originales
    $hora_from = $from_date->format('H:i');
    $hora_to = $to_date->format('H:i');

    // Crear la nueva fecha para horario_from
    $nuevo_horario_from = $nueva_fecha . ' ' . $hora_from;

    // Crear la nueva fecha para horario_to
    $nuevo_horario_to_date = new DateTime($nueva_fecha);
    if ($from_date->format('Y-m-d') < $to_date->format('Y-m-d')) {
        // Si el horario_to es antes que horario_from, añadir un día a la nueva fecha de horario_to
        $nuevo_horario_to_date->modify('+1 day');
    }
    $nuevo_horario_to = $nuevo_horario_to_date->format('Y-m-d') . ' ' . $hora_to;

    // retornar los nuevos valores
    return array(
        "horario_from" => $nuevo_horario_from,
        "horario_to" => $nuevo_horario_to,
    );
}

/*
function calcularHoras($start, $end) {
    // Convertir las fechas de cadena a objetos DateTime
    $fechaInicio = new DateTime($start);
    $fechaFin = new DateTime($end);

    // Calcular la diferencia en horas entre las fechas
    $diferencia = $fechaInicio->diff($fechaFin);

    // Calcular el total de horas usando días, horas y minutos
    $horas = $diferencia->days * 24 + $diferencia->h + $diferencia->i / 60;

    // Redondear las horas a dos decimales
    $horas = round($horas, 2);

    return $horas;
}
*/




function calculoX_old($start, $end, $horquilla, $holidays = []) {
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

    $horquilla_dia = NULL;
    $horquilla_noche = NULL;

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
                $typeDay = "Festivo día";
                $horquilla_dia = $horquilla->hor_festivo; 
            } elseif ($isWeekendHoliday) {
                $typeDay = "Festivo día";
                $horquilla_dia = $horquilla->hor_festivo; 
            } else {
                $typeDay = "Laborable día";
                $horquilla_dia = $horquilla->hor_laborable;
            }
        } else {
            $nightHours += $hours;
            if (($isHoliday && $currentHour < 22) || ($isPrevHoliday && $currentHour < 6) || ($currentHour >= 22 && $isNextHoliday)) {
                $typeNight = "Festivo noche";
                $horquilla_noche = $horquilla->hor_festivo_nocturno;
            } elseif ($isWeekendHoliday && $currentHour < 22) {
                $typeNight = "Festivo noche";
                $horquilla_noche = $horquilla->hor_festivo_nocturno;
            } else {
                $typeNight = "Laborable noche";
                $horquilla_noche = $horquilla->hor_laborable_nocturno;
            }
        }

        // Avanzar al siguiente segmento
        $startTimestamp = $nextHourTimestamp;
    }

    return [
        'hora_dia'          => $dayHours > 0 ? $dayHours : null,
        'tipo_hora_dia'     => $dayHours > 0 ? $typeDay : null,
        'hora_noche'        => $nightHours > 0 ? $nightHours : null,
        'tipo_hora_noche'   => $nightHours > 0 ? $typeNight : null,
        'horquilla_dia'     => $horquilla_dia,
        'horquilla_noche'   => $horquilla_noche,
    ];
}

function calculoX($start, $end, $horquilla, $holidays = []) {
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
    $horquilla_dia = NULL;
    $horquilla_noche = NULL;

    // Mientras la fecha de inicio sea menor que la fecha de fin
    while ($startTimestamp < $endTimestamp) {
        $currentDate = date("Y-m-d H:i:s", $startTimestamp); //echo "<br>";
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

        //echo "rangeNoche: ".rangoNoche($currentDate); echo "<br>";
        //echo "startHoliday: ".$startHoliday; echo "<br>";
        //echo "nextHoliday: ".$nextHoliday; echo "<br>";

        // Determinar si estamos en el periodo diurno o nocturno
        if ($dayStart <= $currentHour && $currentHour < $dayEnd) 
        {
            if($startHoliday){
                $dayHours += $hours;
                $typeDay = "Festivo día";
                $horquilla_dia = $horquilla->hor_festivo;
            }else{
                $dayHours += $hours;
                $typeDay = "Laborable día";
                $horquilla_dia = $horquilla->hor_laborable;
            }
        } 
        else 
        {
            //echo $startHoliday;
            //averiguar si la hora es mayor a 22:00 y ademas si al dia siguiente es feriado
            if(rangoEntreNoche($currentDate) && !$nextHoliday){
                $nightHours += $hours;
                $typeNight = "Laborable noche";
                $horquilla_noche = $horquilla->hor_laborable_nocturno;
            }elseif(rangoEntreNoche($currentDate) && $nextHoliday){
                $nightHours += $hours;
                $typeNight = "Festivo noche";
                $horquilla_noche = $horquilla->hor_festivo_nocturno;
            }elseif(rangoMadrugada($currentDate) && $startHoliday){
                $nightHours += $hours;
                $typeNight = "Festivo noche";
                $horquilla_noche = $horquilla->hor_festivo_nocturno;
            }else{
                $nightHours += $hours;
                $typeNight = "Laborable noche";
                $horquilla_noche = $horquilla->hor_laborable_nocturno;
            }
            
        }

        // Avanzar al siguiente segmento
        $startTimestamp = $nextHourTimestamp;
        //echo $typeNight;echo "<br>";
        //echo "<hr>";
    }

    return [
        'hora_dia' => $dayHours > 0 ? $dayHours : null,
        'tipo_hora_dia' => $dayHours > 0 ? $typeDay : null,
        'hora_noche' => $nightHours > 0 ? $nightHours : null,
        'tipo_hora_noche' => $nightHours > 0 ? $typeNight : null,
        'horquilla_dia'     => $horquilla_dia,
        'horquilla_noche'   => $horquilla_noche,
    ];
}

function verificar_domingo($fechaInicio) {
    $resultados = [];

    // Convertir la fecha inicial a un timestamp usando strtotime
    $timestamp = strtotime($fechaInicio);

    // Verificar si la fecha inicial es domingo (0: domingo, 6: sábado)
    if (date('w', $timestamp) == 0) {
        // Si es domingo, añadir la fecha al array
        $resultados[] = date('Y-m-d', $timestamp);
    }

    // Avanzar al día siguiente usando strtotime
    $timestamp += 86400; // 86400 segundos = 1 día

    // Verificar si el día siguiente es domingo
    if (date('w', $timestamp) == 0) {
        // Si es domingo, añadir la fecha al array
        $resultados[] = date('Y-m-d', $timestamp);
    }

    return $resultados;
}