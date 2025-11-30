<?php
class Centro_modelo extends CI_Model
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
			$sw_where = "c.cen_state = '$sw'";

		$query = $this->db->query("	SELECT * from wfc_centers c
									where $sw_where
									order by c.cen_name");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
		$data = array(
				"cen_id" 		=> null,

				"cen_name"	=> $this->input->post("cen_name"),
				"cen_state"	=> $this->input->post("cen_state"),
				"cen_description"=> $this->input->post("cen_description"),

				"prov_id"	=> $this->input->post("prov_id"),
				"loc_id"	=> $this->input->post("loc_id"),
				"hor_id"	=> $this->input->post("hor_id"),
		);
		$this->db->insert("wfc_centers", $data);
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$data = array(
				"cen_name"		=> $this->input->post("cen_name"),
				"cen_state"		=> $this->input->post("cen_state"),
				"cen_description"	=> $this->input->post("cen_description"),

				"prov_id"	=> $this->input->post("prov_id"),
				"loc_id"	=> $this->input->post("loc_id"),
				"hor_id"	=> $this->input->post("hor_id"),
			);

		$this->db->where("cen_id", $this->input->post("cen_id"));
		$this->db->update("wfc_centers", $data);

	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_centers", array("cen_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function delete($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("UPDATE wfc_centers SET cen_state='0' WHERE cen_id IN(".$lista.")");
		}else
			return $this->db->query("UPDATE wfc_centers SET cen_state='0' WHERE cen_id='$id'");
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_centers WHERE cen_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM wfc_centers WHERE cen_id='$id'");
		}
	}

}
 ?>
