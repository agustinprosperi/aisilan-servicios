<?php
class Proyecto_modelo extends CI_Model
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
			$sw_where = "pro.pro_state = '$sw'";

		if($this->session->userdata("usu_tipo_actual") == "Coordinador"){
			$coo_id = $this->session->userdata("usu_id_actual");
			$coo_id_where = "pro.coo_id = '$coo_id'";
		}else
			$coo_id_where = "1";

		$query = $this->db->query("	SELECT * from wfc_projects pro
									where $sw_where and $coo_id_where
									order by pro.pro_name");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
		$data = array(
				"pro_id" 		=> null,

				"pro_name"	=> $this->input->post("pro_name"),
				"pro_state"	=> $this->input->post("pro_state"),
				"pro_description"	=> $this->input->post("pro_description"),
				"pro_tipo_horario"	=> $this->input->post("pro_tipo_horario"),

				"cli_id"	=> $this->input->post("cli_id"),
				"coo_id"	=> $this->input->post("coo_id"),
		);
		$this->db->insert("wfc_projects", $data);
		return $this->db->insert_id();
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$data = array(
				"pro_name"	=> $this->input->post("pro_name"),
				"pro_state"	=> $this->input->post("pro_state"),
				"pro_description"	=> $this->input->post("pro_description"),
				"pro_tipo_horario"	=> $this->input->post("pro_tipo_horario"),
				
				"cli_id"	=> $this->input->post("cli_id"),
				"coo_id"	=> $this->input->post("coo_id"),
			);

		$this->db->where("pro_id", $this->input->post("pro_id"));
		$this->db->update("wfc_projects", $data);
	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_projects", array("pro_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function delete($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("UPDATE wfc_projects SET pro_state='0' WHERE pro_id IN(".$lista.")");
		}else
			return $this->db->query("UPDATE wfc_projects SET pro_state='0' WHERE pro_id='$id'");
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			foreach($this->input->post("seleccion") as $prod_id){
				$this->db->query("DELETE FROM wfc_project_worker WHERE pro_id='$prod_id'");
			}
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_projects WHERE pro_id IN(".$lista.")");
		}else{
			$this->db->query("DELETE FROM wfc_project_worker WHERE pro_id='$id'");
			return $this->db->query("DELETE FROM wfc_projects WHERE pro_id='$id'");
		}
	}

	public function activar()
	{
		$lista = implode(',',$this->input->post("seleccion"));
		return $this->db->query("UPDATE wfc_projects SET pro_state='1' WHERE pro_id IN(".$lista.")");
	}
	public function getListaTrabajadores($pro_id)
	{
		$query = $this->db->query("	SELECT pro.tra_id 
									FROM wfc_project_worker pro
									WHERE pro.pro_id='$pro_id'");

		$list_trabajadores_en_proyecto = $query->result_array();

		$array = array();
		foreach($list_trabajadores_en_proyecto as $item){
			$array[] = $item['tra_id'];
		}

		$lista = implode(',' , $array);

		if(count($array) > 0)
			$whereLista = "u.usu_id NOT IN ($lista)";
		else
			$whereLista = "1";
								
		$query = $this->db->query("	SELECT * 
									FROM usuario u
									WHERE u.usu_estado='1' 
										AND u.usu_tipo='Trabajador'
										AND $whereLista
									ORDER BY u.usu_ap ASC, u.usu_am ASC, u.usu_nombre ASC");
		return $query->result();
	}
	public function insertarTrabajadorEnProyecto($pro_id, $tra_id){
		$data = array(
			"pro_id" => $pro_id,
			"tra_id" => $tra_id,
		);
		$this->db->insert("wfc_project_worker", $data);
		return $this->db->insert_id();
	}

	public function getListaTrabajadoresDeProyecto($pro_id)
	{
		$query = $this->db->query("	SELECT * 
									FROM wfc_project_worker pro
									INNER JOIN usuario u
										ON u.usu_id = pro.tra_id
									WHERE pro.pro_id='$pro_id'
									ORDER BY u.usu_ap ASC, u.usu_am ASC, u.usu_nombre ASC");
		return $query->result();
	}

	public function eliminarTrabajador($pro_id, $tra_id)
	{
		return $this->db->query("DELETE FROM wfc_project_worker WHERE pro_id='$pro_id' and tra_id='$tra_id'");
	}
}
 ?>
