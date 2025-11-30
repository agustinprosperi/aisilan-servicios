<?php
class Provincia_modelo extends CI_Model
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
		$query = $this->db->query("	SELECT * from wfc_provincias
									order by prov_name");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
		$data = array(
				"prov_id" 		=> null,
				"prov_name"	=> $this->input->post("prov_name"),
		);
		$this->db->insert("wfc_provincias", $data);
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$data = array(
				"prov_name"		=> $this->input->post("prov_name"),
			);

		$this->db->where("prov_id", $this->input->post("prov_id"));
		$this->db->update("wfc_provincias", $data);

	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_provincias", array("prov_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_provincias WHERE prov_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM wfc_provincias WHERE prov_id='$id'");
		}
	}

}
 ?>
