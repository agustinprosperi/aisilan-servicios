<?php
class Tarea_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * obtener en un array toda la lista de materias
	 */
	public function getLista($sw = '')
	{
		if($sw == "")
			$sw_where = "1";
		else
			$sw_where = "tar.tar_state = '$sw'";

		$query = $this->db->query("	SELECT * from wfc_tareas tar
									where $sw_where
									order by tar.tar_name");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
		$data = array(
				"tar_id" 		=> null,

				"tar_name"	=> $this->input->post("tar_name"),
				"tar_state"	=> $this->input->post("tar_state"),
				"tar_description"=> $this->input->post("tar_description"),
				"tar_sigla"=> $this->input->post("tar_sigla"),
		);
		$this->db->insert("wfc_tareas", $data);
		
		$tar_id = $this->db->insert_id();
		$categorias = $this->input->post("cat_ids");
		if(count($categorias)>0){
			foreach($categorias as $categoria)
				$this->db->insert("wfc_categoria_tarea", array("tar_id" => $tar_id, "cat_id" => $categoria));
		}
	}
	
	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$tar_id = $this->input->post("tar_id");
		$categorias = $this->input->post("cat_ids");
		if(count($categorias)>0){
			//primero eliminar las categorias pertenecientes a tar_id
			$this->db->query("DELETE FROM wfc_categoria_tarea WHERE tar_id='$tar_id'");
			foreach($categorias as $categoria)
				$this->db->insert("wfc_categoria_tarea", array("tar_id" => $tar_id, "cat_id" => $categoria));
		}

		$data = array(
				"tar_name"		=> $this->input->post("tar_name"),
				"tar_state"		=> $this->input->post("tar_state"),
				"tar_description"	=> $this->input->post("tar_description"),
				"tar_sigla"	=> $this->input->post("tar_sigla"),
			);

		$this->db->where("tar_id", $this->input->post("tar_id"));
		$this->db->update("wfc_tareas", $data);

	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_tareas", array("tar_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function delete($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("UPDATE wfc_tareas SET tar_state='0' WHERE tar_id IN(".$lista.")");
		}else
			return $this->db->query("UPDATE wfc_tareas SET tar_state='0' WHERE tar_id='$id'");
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_tareas WHERE tar_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM wfc_tareas WHERE tar_id='$id'");
		}
	}
	
	public function getAllTareas($lista)//new
	{
		$query = $this->db->query("SELECT * FROM wfc_tareas WHERE tar_id IN(".$lista.")");
		return $query->result();
	}

	/*
	public function saveTareaTrabajadorEnProyecto($pro_tra_lastid, $pro_id, $usu_id, $tar_id)
	{
		$data = array(
				"ptt_id" 		=> null,

				"pro_tra_id	"	=> $pro_tra_lastid,
				"pro_id"		=> $pro_id,
				"usu_id"		=> $usu_id,
				"tar_id"		=> $tar_id,
		);
		$this->db->insert("wfc_project_worker_task", $data);
	}
	*/
	/**
	 * Tareas del trabajador en un evento
	 */
	/*
	public function getListaTareasDelTrabajadorEnEvento($eve_tra_id)
	{
		$this->db->select("t.tar_name, t.tar_id");
		$this->db->from("wfc_event_worker_task as ewt");
		$this->db->join("wfc_tareas as t","t.tar_id = ewt.tar_id");
		$this->db->where("ewt.eve_tra_id", $eve_tra_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function eliminarTareasDelTrabajadorEnEvento($eve_tra_id)
	{
		return $this->db->query("DELETE FROM wfc_event_worker_task WHERE eve_tra_id='$eve_tra_id'");
	}*/














	public function getEventoTarea($eve_tar_id)//
	{
		$query = $this->db->get_where("wfc_event_task", array("eve_tar_id"=>$eve_tar_id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function insertarEditarTareaTrabajadorEnEvento(){ // new
		
		$eve_date = $this->input->post("eve_date");

		$eve_tar_horario_from = $this->input->post("eve_tar_horario_from");
		$eve_tar_horario_to   = $this->input->post("eve_tar_horario_to");

		if($eve_tar_horario_from < $eve_tar_horario_to){
			$eve_tar_horario_from = $eve_date.' '.$eve_tar_horario_from;
			$eve_tar_horario_to = $eve_date.' '.$eve_tar_horario_to;
		}elseif($eve_tar_horario_from > $eve_tar_horario_to){
			$eve_date_new = date("Y-m-d", strtotime($eve_date . ' +1 day'));
			
			$eve_tar_horario_from = $eve_date.' '.$eve_tar_horario_from;
			$eve_tar_horario_to = $eve_date_new.' '.$eve_tar_horario_to;
		}

		$eve_tar_task = implode(',', $this->input->post('eve_tar_task'));
		
		$data = array(
			"pro_id" 		=> $this->input->post('pro_id'),
			"eve_id" 		=> $this->input->post('eve_id'),
			"tra_id" 		=> $this->input->post('tra_id'),
			"cat_id"		=> $this->input->post('eve_tar_cat'),
			"eve_tar_ids"	=> $eve_tar_task,
			"eve_tar_type"	=> $this->input->post('eve_tar_type'),
			"eve_tar_horario_from"	=> $eve_tar_horario_from,
			"eve_tar_horario_to"	=> $eve_tar_horario_to,
			"eve_tar_nota"	=> $this->input->post('eve_tar_nota'),
		);
		if($this->input->post("eve_tar_id") == '')
			$this->db->insert("wfc_event_task", $data);
		else{
			$this->db->where("eve_tar_id", $this->input->post("eve_tar_id"));
			$this->db->update("wfc_event_task", $data);
		}
	}

	public function insertarEditarTareaRegistradaDeTrabajadorEnEvento(){ // new
		
		$eve_date = $this->input->post("eve_date");

		$eve_tar_horario_from = $this->input->post("eve_tar_horario_from");
		$eve_tar_horario_to   = $this->input->post("eve_tar_horario_to");

		if($eve_tar_horario_from < $eve_tar_horario_to){
			$eve_tar_horario_from = $eve_date.' '.$eve_tar_horario_from;
			$eve_tar_horario_to = $eve_date.' '.$eve_tar_horario_to;
		}elseif($eve_tar_horario_from > $eve_tar_horario_to){
			$eve_date_new = date("Y-m-d", strtotime($eve_date . ' +1 day'));
			
			$eve_tar_horario_from = $eve_date.' '.$eve_tar_horario_from;
			$eve_tar_horario_to = $eve_date_new.' '.$eve_tar_horario_to;
		}
		
		$data = array(
			"pro_id" 		=> $this->input->post('pro_id'),
			"eve_id" 		=> $this->input->post('eve_id'),
			"tra_id" 		=> $this->input->post('tra_id'),
			"eve_tar_ids"	=> $this->input->post('eve_tar_ids'),
			"eve_tar_type"	=> $this->input->post('eve_tar_type'),
			"eve_tar_horario_from"	=> $eve_tar_horario_from,
			"eve_tar_horario_to"	=> $eve_tar_horario_to,
			"eve_tar_nota"	=> $this->input->post('eve_tar_nota'),
		);
		if($this->input->post("eve_tar_id") == ''){
			$this->db->insert("wfc_event_task_worker", $data);
			return $this->db->insert_id();
		}else{
			$this->db->where("eve_tar_id", $this->input->post("eve_tar_id"));
			$this->db->update("wfc_event_task_worker", $data);
			return $this->input->post("eve_tar_id");
		}
	}	

	public function getEventoTareaRegistrada($eve_tar_id)//
	{
		$query = $this->db->get_where("wfc_event_task_worker", array("eve_tar_id"=>$eve_tar_id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function eliminarEventoTareaTrabajador($eve_tar_id)//new
	{
		return $this->db->query("DELETE FROM wfc_event_task_worker WHERE eve_tar_id='$eve_tar_id'");
	}

	public function validarTarea($eve_tar_id, $state)//new
	{
		$data = array(
			"eve_validar" => $state
		);

		$this->db->where("eve_tar_id", $eve_tar_id);
		return $this->db->update("wfc_event_task_worker", $data);
	}

	public function verificarQueTodasLasTareasFueronValidadas($eve_id, $tra_id, $type){
		$query_registradas = $this->db->query(" SELECT count(*) AS total
												FROM wfc_event_task_worker
												WHERE eve_id = '$eve_id' and tra_id = '$tra_id' and  eve_tar_type = '$type'
											");

		$query_validadas = $this->db->query("   SELECT count(*) AS total
												FROM wfc_event_task_worker
												WHERE eve_id = '$eve_id' and tra_id = '$tra_id'  and  eve_tar_type = '$type' and eve_validar = '1'
										");

		$query_invalidadas = $this->db->query("   SELECT count(*) AS total
												FROM wfc_event_task_worker
												WHERE eve_id = '$eve_id' and tra_id = '$tra_id'  and  eve_tar_type = '$type' and eve_validar = '2'
											");							

		return array("registradas" => $query_registradas->result(), "validadas" => $query_validadas->result(), "invalidadas" => $query_invalidadas->result());
		
	}
	public function getEventTaskByEveTarId($eve_tar_id)//new
	{
		$query = $this->db->get_where("wfc_event_task_worker", array("eve_tar_id"=>$eve_tar_id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
}
 ?>
