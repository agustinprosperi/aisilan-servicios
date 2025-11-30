<?php
class Horquillahoraria_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * obtener en un array toda la lista de materias
	 */
	public function getLista($sw)
    {
        if($sw == "")
			$sw_where = "1";
		else
			$sw_where = "hor_state = '$sw'";

        $query = $this->db->query("	SELECT * from wfc_horquilla_horaria
                                    where $sw_where
									order by hor_name ASC");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
        $data = array(
				"hor_id" 		=> null,
				"hor_name"	    => $this->input->post("hor_name"),
				"hor_laborable"	=> $this->input->post("hor_laborable"),
				"hor_laborable_nocturno"	=> $this->input->post("hor_laborable_nocturno"),
				"hor_festivo"	=> $this->input->post("hor_festivo"),
				"hor_festivo_nocturno"	=> $this->input->post("hor_festivo_nocturno"),
				"hor_state"	=> $this->input->post("hor_state"),
		);
		$this->db->insert("wfc_horquilla_horaria", $data);
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$data = array(
            "hor_name"	    => $this->input->post("hor_name"),
            "hor_laborable"	=> $this->input->post("hor_laborable"),
            "hor_laborable_nocturno"	=> $this->input->post("hor_laborable_nocturno"),
            "hor_festivo"	=> $this->input->post("hor_festivo"),
            "hor_festivo_nocturno"	=> $this->input->post("hor_festivo_nocturno"),
            "hor_state"	=> $this->input->post("hor_state"),
		);

		$this->db->where("hor_id", $this->input->post("hor_id"));
		$this->db->update("wfc_horquilla_horaria", $data);

	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_horquilla_horaria", array("hor_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

    public function delete($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("UPDATE wfc_horquilla_horaria SET hor_state='0' WHERE hor_id IN(".$lista.")");
		}else
			return $this->db->query("UPDATE wfc_horquilla_horaria SET hor_state='0' WHERE hor_id='$id'");
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_horquilla_horaria WHERE hor_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM wfc_horquilla_horaria WHERE hor_id='$id'");
		}
	}

}
 ?>
