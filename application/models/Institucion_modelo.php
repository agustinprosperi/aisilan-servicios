<?php
class Institucion_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getLista()
	{

		$query = $this->db->query("	SELECT *
									FROM institucion
									ORDER BY ue_nombre
								");
		return $query->result();
	}

	public function insert()
	{
		$data = array(
				"ue_nombre"		=> $this->input->post('ue_nombre'),
				"ue_telefono"	=> $this->input->post('ue_telefono'),
				"ue_email"		=> $this->input->post('ue_email'),
				"ue_residencia"	=> $this->input->post('ue_residencia'),
				"ue_direccion"	=> $this->input->post('ue_direccion'),
				"ue_director"	=> $this->input->post('ue_director'),
				"ue_estado"		=> $this->input->post('ue_estado')
			);

		$this->db->insert("institucion", $data);
		$last_id = $this->getLastId();

		
	}

	public function edit()
	{
		$data = array(
				"ue_nombre"			=> $this->input->post('ue_nombre'),
				"ue_telefono"		=> $this->input->post('ue_telefono'),
				"ue_email"			=> $this->input->post('ue_email'),
				"ue_residencia"		=> $this->input->post('ue_residencia'),
				"ue_direccion"		=> $this->input->post('ue_direccion'),
				"ue_director"		=> $this->input->post('ue_director'),
				"ue_estado"			=> $this->input->post('ue_estado')
			);

		$this->db->where("ue_id", $this->input->post('ue_id'));
		$this->db->update("institucion", $data);

		
	}

	public function getLastId()
	{
		$query = $this->db->query("SELECT MAX(ue_id) AS ue_id FROM institucion");
		$resultado = $query->row();
		return $resultado->ue_id;
	}

	public function getId($ue_id)
	{
		$query = $this->db->get_where("institucion", array("ue_id"=>$ue_id));
		return $query->row();
	}

	public function getNombre($ue_id){
		$query = $this->db->get_where("institucion", array("ue_id"=>$ue_id));
		$resultado = $query->row();
		return $resultado->ue_nombre;
	}

	public function getTelefono($ue_id){
		$query = $this->db->get_where("institucion", array("ue_id"=>$ue_id));
		$resultado = $query->row();
		return $resultado->ue_telefono;
	}

	public function getEmail($ue_id){
		$query = $this->db->get_where("institucion", array("ue_id"=>$ue_id));
		$resultado = $query->row();
		return $resultado->ue_email;
	}

	public function getResidencia($ue_id){
		$query = $this->db->get_where("institucion", array("ue_id"=>$ue_id));
		$resultado = $query->row();
		return $resultado->ue_residencia;
	}

	public function getDireccion($ue_id){
		$query = $this->db->get_where("institucion", array("ue_id"=>$ue_id));
		$resultado = $query->row();
		return $resultado->ue_direccion;
	}

	public function getDirector($ue_id){
		$query = $this->db->get_where("institucion", array("ue_id"=>$ue_id));
		$resultado = $query->row();
		return $resultado->ue_director;
	}

	public function getEstado($ue_id){
		$query = $this->db->get_where("institucion", array("ue_id"=>$ue_id));
		$resultado = $query->row();
		return $resultado->ue_estado;
	}

	public function getLogo($ue_id){
		$query = $this->db->get_where("institucion", array("ue_id"=>$ue_id));
		$resultado = $query->row();
		return $resultado->ue_logo;
	}

	/*public function desactivar_ue($ue_id)
	{
		$query = $this->db->query("UPDATE institucion set ue_estado='0' WHERE ue_estado='1' and ue_id<>'$ue_id' ");
		return $query;
	}*/
	public function cambiar($ue_id)
	{
		$data = array(
				"ue_estado"	=> 1
			);

		$this->db->where("ue_id", $ue_id);
		$this->db->update("institucion", $data);

		$this->session->set_userdata(array("ue_id_actual"=>$ue_id));
		$this->desactivar_ue($ue_id);
	}

	public function delete($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("UPDATE institucion SET ue_estado='0' WHERE ue_id IN(".$lista.")");
		}else
			return $this->db->query("UPDATE institucion SET ue_estado='0' WHERE ue_id='$id'");
	}

	public function delete_fisica($id)
	{
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM institucion WHERE ue_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM institucion WHERE ue_id='$id'");
		}
	}
	/**
	 * obtener unidad educativa con estado activo
	 */
	public function getIdEstadoActivo(){
		$query = $this->db->get_where("institucion", array("ue_estado"=>'1'));
		$resultado = $query->row();
		return $resultado->ue_id;
	}

	/**
	 * guardar logo
	 */
	public function setFoto($ue_id, $ruta_logo)
	{
		$data = array("ue_logo" => $ruta_logo);
		$this->db->where("ue_id", $ue_id);
		$this->db->update("institucion", $data);

	}

}
