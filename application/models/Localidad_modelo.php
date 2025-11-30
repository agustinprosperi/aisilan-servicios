<?php
class Localidad_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * obtener en un array toda la lista de materias
	 */
	public function getLista()
	{
		$query = $this->db->query("	SELECT * from wfc_localidades
									order by loc_name");
		return $query->result();
	}
	/**
	 * obtener en un array toda la lista de materias
	 */
	public function getLocalidadesByProvId($prov_id)
	{
		$query = $this->db->query("	SELECT * from wfc_localidades
									WHERE prov_id='$prov_id'
									order by loc_name");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
		$data = array(
				"loc_id" 	=> null,
				"loc_name"	=> $this->input->post("loc_name"),
				"prov_id"	=> $this->input->post("prov_id"),
		);
		$this->db->insert("wfc_localidades", $data);
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$data = array(
				"loc_name"	=> $this->input->post("loc_name"),
                "prov_id"	=> $this->input->post("prov_id"),
			);

		$this->db->where("loc_id", $this->input->post("loc_id"));
		$this->db->update("wfc_localidades", $data);

	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_localidades", array("loc_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_localidades WHERE loc_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM wfc_localidades WHERE loc_id='$id'");
		}
	}

}
 ?>
