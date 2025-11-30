<?php
class Feriado_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * obtener en un array toda la lista de materias
	 */
	public function getLista($type='', $month='', $year='', $prov_id='', $loc_id='')
    {
        $type_where = !empty($type)?"fer_type = '$type'":"1";
        $month_where = !empty($month)?"fer_month = '$month'":"1";
        $year_where = !empty($year)?"fer_year = '$year'":"1";

        $prov_where = !empty($prov_id)?"prov_id = '$prov_id'":"1";
        $loc_where = !empty($loc_id)?"loc_id = '$loc_id'":"1";

		$query = $this->db->query("	SELECT * from wfc_feriados
                                    where $type_where and 
										  $month_where and 
										  $year_where and
										  $prov_where and
										  $loc_where
									order by fer_date ASC");
		return $query->result();
	}

	/**
	 * insertar un registro en la tabla materia
	 */
	public function insert()
	{
        $date = $this->input->post("fer_year")."-".$date = $this->input->post("fer_month")."-".$date = $this->input->post("fer_day");
		$data = array(
				"fer_id" 		=> null,

				"fer_name"	=> $this->input->post("fer_name"),
				"fer_year"	=> $this->input->post("fer_year"),
				"fer_month"	=> $this->input->post("fer_month"),
				"fer_day"	=> $this->input->post("fer_day"),
				"fer_date"	=> $date,
                "fer_type"	=> $this->input->post("fer_type"),

                "prov_id"	=> $this->input->post("prov_id"),
                "loc_id"	=> $this->input->post("loc_id"),
		);
		$this->db->insert("wfc_feriados", $data);
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$date = $this->input->post("fer_year")."-".$date = $this->input->post("fer_month")."-".$date = $this->input->post("fer_day");

		$data = array(
            "fer_name"	=> $this->input->post("fer_name"),
            "fer_year"	=> $this->input->post("fer_year"),
            "fer_month"	=> $this->input->post("fer_month"),
            "fer_day"	=> $this->input->post("fer_day"),
            "fer_date"	=> $date,
            "fer_type"	=> $this->input->post("fer_type"),

			"prov_id"	=> $this->input->post("prov_id"),
            "loc_id"	=> $this->input->post("loc_id"),
		);

		$this->db->where("fer_id", $this->input->post("fer_id"));
		$this->db->update("wfc_feriados", $data);

	}

	/**
	 * Obtener información un centro por su id
	*/
	public function getId($id)
	{
		$query = $this->db->get_where("wfc_feriados", array("fer_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_feriados WHERE fer_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM wfc_feriados WHERE fer_id='$id'");
		}
	}
	/**
	 * Dato prov_id, loc_id y Fecha, averiguar si es feriado local
	*/
	public function getFeriadoLocal($fecha, $prov_id=0, $loc_id=0)
	{
		$query = $this->db->get_where("wfc_feriados", array("prov_id"=>$prov_id, "loc_id"=>$loc_id, "fer_date"=>$fecha));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
	/**
	 * Dato Fecha, averiguar si es feriado nacional
	*/
	public function getFeriadoNacional($fecha, $prov_id=0, $loc_id=0)
	{
		$query = $this->db->get_where("wfc_feriados", array("prov_id"=>$prov_id, "loc_id"=>$loc_id, "fer_date"=>$fecha));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	/**
	 * Dato prov_id, loc_id y Fecha, averiguar si es feriado
	*/
	public function getFeriado_GetOnlyFecha($fecha, $prov_id, $loc_id)
	{
		$query = $this->db->query("SELECT fer_date FROM wfc_feriados where (fer_date='$fecha' OR fer_date = DATE_SUB('$fecha', INTERVAL 1 DAY) OR fer_date = DATE_ADD('$fecha', INTERVAL 1 DAY)) and ((prov_id='0' and loc_id='0') or (prov_id='$prov_id' and loc_id='$loc_id'))");
		//$query = $this->db->query("SELECT fer_date FROM wfc_feriados where (fer_date='$fecha' OR fer_date = DATE_ADD('$fecha', INTERVAL 1 DAY)) and ((prov_id='0' and loc_id='0') or (prov_id='$prov_id' and loc_id='$loc_id'))");

		$array_feriados = array();
		if($query->num_rows() > 0){
			$result = $query->result_array();
			$array_feriados = array_column($result, 'fer_date');
		}
		
		$array_feriados = array_merge($array_feriados, verificar_domingo($fecha));
					
		return $array_feriados;
	}

}
?>
