<?php
class Evento_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * obtener en un array toda la lista de materias
	 */
	public function getLista($sw = '', $eve_tipo='Simple')
	{
		if($eve_tipo == 'Simple'){
			$eve_tipo_where = "eve_tipo='Simple'";
		}else{
			$eve_tipo_where = "eve_tipo='Multiple'";
		}

		if($sw == "all")
			$sw_where = "1";
		else
			$sw_where = "eve.eve_state = '$sw'";

		if($this->session->userdata("usu_tipo_actual") == "Coordinador"){
			$coo_id = $this->session->userdata("usu_id_actual");
			$coo_id_where = "eve.coo_id = '$coo_id'";
		}else
			$coo_id_where = "1";

		if($this->uri->segment(6) == null && $this->uri->segment(5) == "Simple"){
			$eve_tipo_where = "eve_tipo='Simple'";
			$eve_id_padre_where = "eve.eve_id_padre = 0";
		}elseif($this->uri->segment(6) == null)
			$eve_id_padre_where = "1";
		else{
			$eve_id_padre_where = "eve.eve_id_padre = ".$this->uri->segment(6);
			$eve_tipo_where = "eve_tipo='Simple'";
		}

		if($this->input->post('date_range_filter') != null){
			$eve_date_filter = explode(" - ", $this->input->post('date_range_filter'));
			$eve_fecha_init = trim(is_array($eve_date_filter) && isset($eve_date_filter[0]) ? $eve_date_filter[0] : '');
			$eve_fecha_fin = trim(is_array($eve_date_filter) && isset($eve_date_filter[1]) ? $eve_date_filter[1] : '');

			$where_date_range = "eve.eve_date BETWEEN '".$eve_fecha_init."' AND '".$eve_fecha_fin."'";
		}else
			$where_date_range = "1";

		$query = $this->db->query("	SELECT * from wfc_events eve
									WHERE $sw_where 
										AND $coo_id_where 
										AND $eve_tipo_where
										AND $eve_id_padre_where
										AND $where_date_range

									ORDER BY eve.eve_date DESC");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
		$eve_date = $this->input->post("eve_date");
		
		$data = array(
			"eve_id" 		=> null,

			"eve_name"	=> $this->input->post("eve_name"),
			"eve_state"	=> $this->input->post("eve_state"),
			"eve_description"	=> $this->input->post("eve_description"),

			"eve_date"	=> $eve_date,
			"eve_tipo_horario"	=> $this->input->post("eve_tipo_horario"),
			"eve_tipo"	=> $this->input->post("eve_tipo"),
			"eve_imputacion"	=> $this->input->post("eve_imputacion"),

			"eve_state"	=> $this->input->post("eve_state"),

			"pro_id"	=> $this->input->post("pro_id"),
			"cli_id"	=> $this->input->post("cli_id"),
			"coo_id"	=> $this->input->post("coo_id"),

			"eve_id_padre"	=> $this->input->post("eve_id_padre"),
		);
		

		$this->db->insert("wfc_events", $data);
		return $this->db->insert_id();
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$eve_date = $this->input->post("eve_date");

		$data = array(
			"eve_name"	=> $this->input->post("eve_name"),
			"eve_state"	=> $this->input->post("eve_state"),
			"eve_description"	=> $this->input->post("eve_description"),

			"eve_date"	=> $eve_date,
			"eve_tipo_horario"	=> $this->input->post("eve_tipo_horario"),
			"eve_tipo"	=> $this->input->post("eve_tipo"),
			"eve_imputacion"	=> $this->input->post("eve_imputacion"),

			"eve_state"	=> $this->input->post("eve_state"),

			"pro_id"	=> $this->input->post("pro_id"),
			"cli_id"	=> $this->input->post("cli_id"),
			"coo_id"	=> $this->input->post("coo_id"),

			"eve_id_padre"	=> $this->input->post("eve_id_padre"),
		);

		$this->db->where("eve_id", $this->input->post("eve_id"));
		$this->db->update("wfc_events", $data);
	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_events", array("eve_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	// Desactivar evento
	public function delete($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("UPDATE wfc_events SET eve_state='0' WHERE eve_id IN(".$lista.")");
		}else
			return $this->db->query("UPDATE wfc_events SET eve_state='0' WHERE eve_id='$id'");
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			foreach($this->input->post("seleccion") as $eve_id){
				$this->db->query("DELETE FROM wfc_event_task WHERE eve_id='$eve_id'");
				$this->db->query("DELETE FROM wfc_event_task_worker WHERE eve_id='$eve_id'");
			}
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_events WHERE eve_id IN(".$lista.")");
		}else{
			$this->db->query("DELETE FROM wfc_event_task WHERE eve_id='$id'");
			$this->db->query("DELETE FROM wfc_event_task_worker WHERE eve_id='$id'");
			return $this->db->query("DELETE FROM wfc_events WHERE eve_id='$id'");
		}
	}

	public function delete_fisica_multiple($eve_id_padre)
	{
		if(empty($eve_id_padre)){
			//recoremos la lista de seleccion
			foreach($this->input->post("seleccion") as $eve_id_padre){
				//seleccionamos subeventos del evento padre
				$query = $this->db->query("	SELECT eve_id 
											FROM wfc_events
											WHERE eve_id_padre = '$eve_id_padre'");

				$result = $query->result();

				//recorremos cada uno de los eventos que estan en $result
				foreach($result as $evento){
					//antes de eliminar los eventos obtenemos su eve_id
					$eve_id = $evento->eve_id;

					//eliminamos tareas del evento
					$this->db->query("DELETE FROM wfc_event_task WHERE eve_id='$eve_id'");
					$this->db->query("DELETE FROM wfc_event_task_worker WHERE eve_id='$eve_id'");

					//eliminamos el subevento
					$this->db->query("DELETE FROM wfc_events WHERE eve_id='$eve_id'");
				}
			}

			//seleccionamos a todos los eventos padre de la selección
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_events WHERE eve_id IN(".$lista.")");
		}else{
			//seleccionamos subeventos del evento padre
			$query = $this->db->query("	SELECT eve_id 
										FROM wfc_events
										WHERE eve_id_padre = '$eve_id_padre'");
			
			$result = $query->result();

			//recorremos cada uno de los eventos que estan en $result
			foreach($result as $evento){
				//antes de eliminar los eventos obtenemos su eve_id
				$eve_id = $evento->eve_id;

				//eliminamos tareas del evento
				$this->db->query("DELETE FROM wfc_event_task WHERE eve_id='$eve_id'");
				$this->db->query("DELETE FROM wfc_event_task_worker WHERE eve_id='$eve_id'");

				//eliminamos el subevento
				$this->db->query("DELETE FROM wfc_events WHERE eve_id='$eve_id'");
			}
			//despues de eliminar sub eventos y sus tareas eliminamos ahora el evento padre
			return $this->db->query("DELETE FROM wfc_events WHERE eve_id='$eve_id_padre'");
		}
	}

	public function activar()
	{
		$lista = implode(',',$this->input->post("seleccion"));
		return $this->db->query("UPDATE wfc_events SET eve_state='1' WHERE eve_id IN(".$lista.")");
	}
	public function cerrar()
	{
		$lista = implode(',',$this->input->post("seleccion"));
		return $this->db->query("UPDATE wfc_events SET eve_state='2' WHERE eve_id IN(".$lista.")");
	}

	public function getListaTrabajadores($pro_id, $eve_id, $tra_state=1)//new
	{
		$query = $this->db->query("	SELECT * 
									FROM wfc_project_worker pw
									INNER JOIN usuario u ON u.usu_id = pw.tra_id
									WHERE pw.pro_id='$pro_id' and u.usu_estado='$tra_state'
									ORDER BY u.usu_ap ASC, u.usu_am ASC, u.usu_nombre ASC");
		return $query->result();
	}

	/**
	 * Proceso para cambiar las fechas a las siguientes tablas: wfc_event_task y wfc_event_task_worker
	 */
	public function cambiarFechaTareas($eve_date_new, $eve_id)
	{
		$query_1 = $this->db->query("SELECT * FROM wfc_event_task WHERE eve_id='$eve_id'");
		$result_1 = $query_1->result();

		foreach($result_1 as $item){
			$eve_tar_id = $item->eve_tar_id;
			$fecha_from = $item->eve_tar_horario_from;
			$fecha_to = $item->eve_tar_horario_to;

			//cambiar fecha
			$nuevas_fechas = cambiar_fecha($eve_date_new, $fecha_from, $fecha_to);

			//actualizar nueva fecha en la tabla
			$data = array(
				'eve_tar_horario_from' => $nuevas_fechas['horario_from'],
				'eve_tar_horario_to' => $nuevas_fechas['horario_to'],
			);
			$this->db->where("eve_tar_id", $eve_tar_id);
			$this->db->update("wfc_event_task", $data);
		}

		$query_2 = $this->db->query("SELECT * FROM wfc_event_task_worker WHERE eve_id='$eve_id'");
		$result_2 = $query_2->result();

		foreach($result_2 as $item){
			$eve_tar_id = $item->eve_tar_id;
			$fecha_from = $item->eve_tar_horario_from;
			$fecha_to = $item->eve_tar_horario_to;

			//cambiar fecha
			$nuevas_fechas = cambiar_fecha($eve_date_new, $fecha_from, $fecha_to);

			//actualizar nueva fecha en la tabla
			$data = array(
				'eve_tar_horario_from' => $nuevas_fechas['horario_from'],
				'eve_tar_horario_to' => $nuevas_fechas['horario_to'],
			);
			$this->db->where("eve_tar_id", $eve_tar_id);
			$this->db->update("wfc_event_task_worker", $data);
		}
	}

	public function insertarTrabajadorEnEvento($eve_tar_type, $eve_tra_cat, $eve_tra_task, $eve_tra_horario_from, $eve_tra_horario_to){ // yes
		$task = implode(',', $eve_tra_task);
		$eve_date = $this->input->post("eve_date");

		if($eve_tra_horario_from < $eve_tra_horario_to){
			$eve_tra_horario_from = $eve_date.' '.$eve_tra_horario_from;
			$eve_tra_horario_to = $eve_date.' '.$eve_tra_horario_to;
		}elseif($eve_tra_horario_from > $eve_tra_horario_to){
			$eve_date_new = date("Y-m-d", strtotime($eve_date . ' +1 day'));
			
			$eve_tra_horario_from = $eve_date.' '.$eve_tra_horario_from;
			$eve_tra_horario_to = $eve_date_new.' '.$eve_tra_horario_to;
		}
		
		$data = array(
			"pro_id" 		=> $this->input->post('pro_id'),
			"eve_id" 		=> $this->input->post('eve_id'),
			"tra_id" 		=> $this->input->post('tra_id'),
			"cat_id" 		=> $eve_tra_cat,
			"eve_tar_ids"	=> $task,
			"eve_tar_type"	=> $eve_tar_type,
			"eve_tar_horario_from"	=> $eve_tra_horario_from,
			"eve_tar_horario_to"	=> $eve_tra_horario_to,
		);
		$this->db->insert("wfc_event_task", $data);
		return $this->db->insert_id();
	}
	
	/**
	 * LISTA DE TRABAJADORES POR EVE_ID y PRO_ID
	 */
	public function getListaTrabajadoresDeEvento($pro_id, $eve_id) // new
	{
		$query = $this->db->query("	SELECT * 
									FROM wfc_event_task eve
									INNER JOIN usuario u ON u.usu_id = eve.tra_id
									INNER JOIN wfc_categorias c ON c.cat_id = eve.cat_id
									WHERE eve.eve_id='$eve_id' and eve.pro_id='$pro_id'
									GROUP BY eve.tra_id
									ORDER BY u.usu_ap ASC, u.usu_am ASC, u.usu_nombre ASC");
		return $query->result();
	}
	/**
	 * LISTA DE TRABAJADORES POR EVE_ID
	 */
	public function getListaTrabajadoresDeEventoByEveId($eve_id)//new
	{
		$query = $this->db->query("	SELECT * 
									FROM wfc_event_task eve
									WHERE eve.eve_id='$eve_id'
								");
		return $query->result();
	}
	/**
	 * LISTA DE TAREAS ASIGNADAS POR EVE_ID y TRA_ID
	 */
	public function getListaTareasByEveIdTraId($eve_id, $tra_id, $eve_tar_type)//new
	{
		$query = $this->db->query("	SELECT * 
									FROM wfc_event_task eve
									INNER JOIN usuario u ON u.usu_id = eve.tra_id
									INNER JOIN wfc_categorias c ON c.cat_id = eve.cat_id
									WHERE eve.eve_id='$eve_id' and eve.tra_id='$tra_id' and eve_tar_type='$eve_tar_type'
									ORDER BY eve_tar_type ASC");
		return $query->result();
	}
	/**
	 * LISTA DE TAREAS REGISTRADAS POR EVE_ID y TRA_ID
	 */
	public function getListaTareasRegistradasByEveIdTraId($eve_id, $tra_id, $eve_tar_type)//new
	{
		$query = $this->db->query("	SELECT * 
									FROM wfc_event_task_worker eve
									INNER JOIN usuario u ON u.usu_id = eve.tra_id
									INNER JOIN wfc_tareas t ON t.tar_id = eve.eve_tar_ids
									WHERE eve.eve_id='$eve_id' and eve.tra_id='$tra_id' and eve_tar_type='$eve_tar_type'
									ORDER BY eve_tar_horario_from ASC");
		return $query->result();
	}

	/**
	 * LISTA DE TAREAS REGISTRADAS Y VALIDADAS POR EVE_ID y TRA_ID
	 */
	public function getListaTareasRegistradaValidadaByEveIdTraId($eve_id, $tra_id, $eve_tar_type)//new
	{
		$query = $this->db->query("	SELECT * 
									FROM wfc_event_task_worker eve
									INNER JOIN usuario u ON u.usu_id = eve.tra_id
									INNER JOIN wfc_tareas t ON t.tar_id = eve.eve_tar_ids
									WHERE eve.eve_id='$eve_id' and eve.tra_id='$tra_id' and eve_tar_type='$eve_tar_type' and eve.eve_validar = 1
									ORDER BY eve_tar_horario_from ASC");
		return $query->result();
	}
	/**
	 * TAREAS REGISTRADAS - VALIDADAS EN UN EVENTO 
	 */
	public function getTareasRegistradasValidadas($eve_id, $eve_validar='')//new
	{
		if($eve_validar == '') 
			$eve_validar_where = 1;
		else
			$eve_validar_where = 'eve_validar = ' . $eve_validar;

		$query = $this->db->query("	SELECT * 
									FROM wfc_event_task_worker eve
									WHERE eve.eve_id='$eve_id' and $eve_validar_where");
		return $query->result();
	}
	/**
	 * EVENTO MULTIPLE - TAREAS REGISTRADAS - VALIDADAS EN UN EVENTO 
	 */
	public function getTareasRegistradasValidadas_EventoMultiple($eve_id_padre, $eve_validar='')//new
	{
		if($eve_validar == '') 
			$eve_validar_where = 1;
		else
			$eve_validar_where = 'eve_tw.eve_validar = ' . $eve_validar;

		$query = $this->db->query("	SELECT * 
									FROM wfc_event_task_worker eve_tw
									INNER JOIN wfc_events eve ON eve.eve_id=eve_tw.eve_id
									WHERE eve.eve_id_padre='$eve_id_padre' and $eve_validar_where");
		return $query->result();
	}


	public function eliminarTareaTrabajador($eve_tar_id)
	{
		return $this->db->query("DELETE FROM wfc_event_task WHERE eve_tar_id='$eve_tar_id'");
	}

	public function eliminarTrabajador($eve_id, $tra_id)
	{
		return $this->db->query("DELETE FROM wfc_event_task WHERE eve_id='$eve_id' and tra_id='$tra_id'");
	}


	public function getMiLista($tra_id)
	{
		if($this->input->post('date_range_filter') != null){
			$eve_date_filter = explode(" - ", $this->input->post('date_range_filter'));
			$eve_fecha_init = trim(is_array($eve_date_filter) && isset($eve_date_filter[0]) ? $eve_date_filter[0] : '');
			$eve_fecha_fin = trim(is_array($eve_date_filter) && isset($eve_date_filter[1]) ? $eve_date_filter[1] : '');

			$where_date_range = "e.eve_date BETWEEN '".$eve_fecha_init."' AND '".$eve_fecha_fin."'";
		}else
			$where_date_range = "1";

		$query = $this->db->query("	SELECT * from wfc_event_task ew
									INNER JOIN wfc_events e ON e.eve_id = ew.eve_id
									WHERE ew.tra_id = '$tra_id' AND e.eve_state='1' AND $where_date_range
									GROUP BY e.eve_id
									ORDER BY e.eve_date DESC
									");
		return $query->result();
	}

	/**
	 * Obtener información de un trabajador en un evento, sus horas de: mañana, tarde y noche
	*/
	public function getInfoEventoTrabajador($eve_tar_id)//new
	{
		$query = $this->db->get_where("wfc_event_task_worker", array("eve_tar_id"=>$eve_tar_id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
	
	/**
	 * Verificar hora solapada
	 */
	
	public function verificar_hora_solapada()//new
	{
		$eve_tar_id	 = $this->input->post("eve_tar_id");
		$eve_id	 = $this->input->post("eve_id");
		$tra_id	 = $this->input->post("tra_id");
		$eve_date = $this->input->post("eve_date");

		$eve_tar_horario_from = $this->input->post("eve_tar_horario_from");
		$eve_tar_horario_to   = $this->input->post("eve_tar_horario_to");

		$eve_tar_horario_from = strtotime($eve_tar_horario_from);
		$eve_tar_horario_to = strtotime($eve_tar_horario_to);

		$eve_fecha_from = $eve_date;

		if($eve_tar_horario_from > $eve_tar_horario_to)
			$eve_fecha_to = date("Y-m-d", strtotime($eve_date."+1 day"));
		else
			$eve_fecha_to = $eve_fecha_from;

		$fecha_inicio = $eve_fecha_from ." ". $this->input->post("eve_tar_horario_from");
		$fecha_fin 	  = $eve_fecha_to ." ". $this->input->post("eve_tar_horario_to");



		if($this->input->post('eve_tar_id') != '' or $this->input->post('eve_tar_id') != NULL)
			$eve_tar_id = "eve_tar_id != '$eve_tar_id'";
		else 
			$eve_tar_id = '1';

		$query = $this->db->query("	SELECT * 
									FROM wfc_event_task_worker
									WHERE ((eve_tar_horario_from < '$fecha_inicio' AND '$fecha_inicio' < eve_tar_horario_to) OR (eve_tar_horario_from < '$fecha_fin' AND '$fecha_fin' < eve_tar_horario_to))
									  
									  AND eve_id = '$eve_id'
									  AND tra_id = '$tra_id'
									  AND $eve_tar_id
								");
		//echo $query->num_rows(); exit;
		if($query->num_rows() > 0)
			return $query->row(); //existe fecha y hora solapada
		else
			return false; //NO existe fecha y hora solapada
	}
	
	/**
	 * CLONAR EVENTO 
	 */
	
	public function clonar_event($evento, $date = '', $eve_id_padre='')//new
	{
		$data = array(
				"eve_id" 		=> null,
				"eve_name"	=> $this->input->post('eve_name'),
				"eve_description"	=> $evento->eve_description,
				"eve_date"	=> $date != ''?$date:$evento->eve_date,
				"eve_tipo_horario"	=> $evento->eve_tipo_horario,
				"eve_state"	=> $evento->eve_state,
				"pro_id"	=> $evento->pro_id,
				"cli_id"	=> $evento->cli_id,
				"coo_id"	=> $evento->coo_id,

				"eve_tipo"	=> $evento->eve_tipo,
				"eve_id_padre"	=> $eve_id_padre != ''?$eve_id_padre:$evento->eve_id_padre,
		);
		$this->db->insert("wfc_events", $data);
		return $this->db->insert_id();
	}
	
	public function clonar_event_task($worker, $eve_id_new, $date_new){//new

		$nuevas_fechas = cambiar_fecha($date_new, $worker->eve_tar_horario_from, $worker->eve_tar_horario_to);

		$data = array(
			"pro_id" => $worker->pro_id,
			"eve_id" => $eve_id_new,
			"tra_id" => $worker->tra_id,
			"cat_id" => $worker->cat_id,
			"eve_tar_ids" => $worker->eve_tar_ids,
			"eve_tar_type" => $worker->eve_tar_type,

			"eve_tar_horario_from" => $nuevas_fechas['horario_from'],
			"eve_tar_horario_to" 	=> $nuevas_fechas['horario_to'],
			"eve_tar_nota" => $worker->eve_tar_nota,
		);
		return $this->db->insert("wfc_event_task", $data);
	}
	
	public function deleteEventWorkerByEveÍdProId($eve_id, $pro_id)
	{
		$this->db->query("DELETE FROM wfc_event_task WHERE eve_id='$eve_id' and pro_id='$pro_id'");
	}

	public function eliminarTodosTrabajadoresEventoByEveIdTraId($eve_id, $tra_id){// yes
		return $this->db->query("DELETE FROM wfc_event_task WHERE eve_id='$eve_id' and tra_id='$tra_id'");
	}

	/**
	 * obtener en un array toda la lista de subeventos
	 */
	public function getListaSubEventos($eve_id_padre)
	{
		$query = $this->db->query("	SELECT * from wfc_events eve
									WHERE eve.eve_id_padre = '$eve_id_padre'

									ORDER BY eve.eve_date DESC");
		return $query->result();
	}
}
 ?>
