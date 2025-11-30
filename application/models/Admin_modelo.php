<?php
class Admin_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function edit()
	{
		$data = array(
			"usu_username"	=> $this->input->post('usu_username'),
			
			"usu_celular"	=> $this->input->post('usu_celular'),
			"usu_telefono"	=> $this->input->post('usu_telefono'),
			"usu_dni"		=> $this->input->post('usu_dni'),
			//"usu_dni_ext"	=> $this->input->post("usu_dni_ext"),
			"usu_direccion"	=> $this->input->post('usu_direccion'),
			"usu_email"		=> $this->input->post('usu_email')
		);

		if($this->input->post("usu_password") != "") $data["usu_password"] = md5($this->input->post("usu_password"));
		if($this->input->post('usu_nombre') != "") $data["usu_nombre"] = $this->input->post('usu_nombre');
		if($this->input->post('usu_ap') != "") $data["usu_ap"] = $this->input->post('usu_ap');
		if($this->input->post('usu_am') != "") $data["usu_am"] = $this->input->post('usu_am');

		$this->db->where("usu_id", $this->session->userdata("usu_id_actual"));
		$this->db->update("usuario", $data);
	}

	public function getUsuario($usu_id)
	{
		$query = $this->db->get_where("usuario", array(
													"usu_id"=>$usu_id
												));
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}else
			return false;
	}
}
