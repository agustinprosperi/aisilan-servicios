<?php
class Categoria_modelo extends CI_Model
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
			$sw_where = "cat.cat_state = '$sw'";

		$query = $this->db->query("	SELECT * from wfc_categorias cat
									where $sw_where
									order by cat.cat_name");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
		$data = array(
				"cat_id" 		=> null,

				"cat_name"	=> $this->input->post("cat_name"),
				"cat_state"	=> $this->input->post("cat_state"),
				"cat_description"	=> $this->input->post("cat_description"),
				"cat_sigla"	=> $this->input->post("cat_sigla"),
		);
		$this->db->insert("wfc_categorias", $data);
/*
		$cat_id = $this->db->insert_id();
		$tareas = $this->input->post("tar_ids");
		if(count($tareas)>0){
			foreach($tareas as $tarea)
				$this->db->insert("wfc_categoria_tarea", array("cat_id" => $cat_id, "tar_id" => $tarea));
		}*/
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$cat_id = $this->input->post("cat_id");
		/*$tareas = $this->input->post("tar_ids");
		if(count($tareas)>0){
			//primero eliminar las tareas pertenecientes a cat_id
			$this->db->query("DELETE FROM wfc_categoria_tarea WHERE cat_id='$cat_id'");
			foreach($tareas as $tarea)
				$this->db->insert("wfc_categoria_tarea", array("cat_id" => $cat_id, "tar_id" => $tarea));
		}*/
		
		$data = array(
				"cat_name"	=> $this->input->post("cat_name"),
				"cat_state"	=> $this->input->post("cat_state"),
				"cat_description"	=> $this->input->post("cat_description"),
				"cat_sigla"	=> $this->input->post("cat_sigla"),
			);

		$this->db->where("cat_id", $cat_id);
		$this->db->update("wfc_categorias", $data);

	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_categorias", array("cat_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function delete($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("UPDATE wfc_categorias SET cat_state='0' WHERE cat_id IN(".$lista.")");
		}else
			return $this->db->query("UPDATE wfc_categorias SET cat_state='0' WHERE cat_id='$id'");
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_categorias WHERE cat_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM wfc_categorias WHERE cat_id='$id'");
		}
	}


	public function getListaTareas($cat_id)
	{
		$query = $this->db->query("	SELECT * from wfc_categoria_tarea ct
									INNER JOIN wfc_tareas t ON t.tar_id = ct.tar_id
									where ct.cat_id = '$cat_id'");
		return $query->result();
	}
	
	public function getListaCategorias($tar_id)
	{
		$query = $this->db->query("	SELECT * from wfc_categoria_tarea ct
									INNER JOIN wfc_categorias c ON c.cat_id = ct.cat_id
									where ct.tar_id = '$tar_id'");
		return $query->result();
	}
	/**
	 * sirve para extraer todas las categorias que vienen de un evento de un trabajador
	 */
	public function getListaByEveIdTraId($eve_id, $tra_id) // NEW
	{
		$query = $this->db->query("	SELECT * from wfc_event_task et
									INNER JOIN wfc_categorias cat ON et.cat_id = cat.cat_id
									WHERE et.eve_id = '$eve_id' and et.tra_id = '$tra_id'
								");
								
		//echo "<pre>"; print_r($query->result()); echo "</pre>"; exit;
		return $query->result();
	}
}
 ?>
