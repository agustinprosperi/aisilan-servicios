<?php
class Cliente_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("centro_modelo");
	}

	/**
	 * obtener en un array toda la lista de materias
	 */
	public function getLista($sw = '')
	{
		if($sw == "")
			$sw_where = "1";
		else
			$sw_where = "cli.cli_state = '$sw'";

		$query = $this->db->query("	SELECT * from wfc_client cli
									where $sw_where
									order by cli.cli_name");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
		$data = array(
				"cli_id" 		=> null,

				"cli_name"	=> $this->input->post("cli_name"),
				"cli_cif"	=> $this->input->post("cli_cif"),
				"cli_contact"	=> $this->input->post("cli_contact"),
				"cli_phone"	=> $this->input->post("cli_phone"),
				"cli_mail"	=> $this->input->post("cli_mail"),
				"cli_description"	=> $this->input->post("cli_description"),
				"cli_state"	=> $this->input->post("cli_state"),
		);
		$cli_id = $this->db->insert("wfc_client", $data);

		foreach($this->input->post("centros") as $centro){
			$this->db->insert("wfc_client_center", array('cli_id' => $cli_id, 'cen_id' => $centro));
		}
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$data = array(
				"cli_name"	=> $this->input->post("cli_name"),
				"cli_cif"	=> $this->input->post("cli_cif"),
				"cli_contact"	=> $this->input->post("cli_contact"),
				"cli_phone"	=> $this->input->post("cli_phone"),
				"cli_mail"	=> $this->input->post("cli_mail"),
				"cli_description"	=> $this->input->post("cli_description"),
				"cli_state"	=> $this->input->post("cli_state"),
			);

		$this->db->where("cli_id", $this->input->post("cli_id"));
		$this->db->update("wfc_client", $data);

		$cli_id = $this->input->post('cli_id');
		$this->db->query("DELETE FROM wfc_client_center WHERE cli_id='$cli_id'");
		foreach($this->input->post("centros") as $centro){
			$this->db->insert("wfc_client_center", array('cli_id' => $cli_id, 'cen_id' => $centro));
		}
	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_client", array("cli_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function delete($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("UPDATE wfc_client SET cli_state='0' WHERE cli_id IN(".$lista.")");
		}else
			return $this->db->query("UPDATE wfc_client SET cli_state='0' WHERE cli_id='$id'");
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_client WHERE cli_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM wfc_client WHERE cli_id='$id'");
		}
	}
	public function getCentrosByCliId($cli_id){
		$query = $this->db->query("
				SELECT * 
				FROM wfc_client_center cc 
				INNER JOIN wfc_centers c 
					ON cc.cen_id = c.cen_id 
				WHERE cc.cli_id='$cli_id'
			");
		return $query->result();
	}
}
 ?>
