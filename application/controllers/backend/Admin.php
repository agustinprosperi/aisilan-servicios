<?php

class Admin extends CI_Controller
{
	public $username;
	public $usu_nombre;

	public $page_title;
	public $page_current_usu;
	public $current_admin;
	public $current_admin_lista;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin_modelo");
		$this->load->model("usuario_modelo");
		$this->load->model("institucion_modelo");

		$this->page_title = "Gestión de usuarios";
		$this->layout->setTitle($this->page_title);
		
		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
		if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        $this->layout->setLayout("backend/template_backend");
        $this->page_current_perfil = "class='current'";
		//$this->current_usuario_administrador = "class='current'";
	}

	public function index()
	{
		//page current
		$this->page_current_perfil = "class='current'";
		//si se selecciono el boton submit
		if($this->input->post("submit"))
		{
			$this->admin_modelo->edit();
			$this->message->set("success","<strong>Perfil actualizado!</strong> Su perfil fue modificado satisfactoriamente.", true);
			$variables = array(
                'username'  => $this->input->post("usu_username"),
                'usu_nombre'=> $this->input->post("usu_nombre"),
                'usu_ap'=> $this->input->post("usu_ap"),
                'usu_am'=> $this->input->post("usu_am")
            );
            $this->session->set_userdata($variables);
			redirect(base_url()."backend/admin/");
		}

		//Si encuentra al administrador que poble el formulario
		$consulta = $this->admin_modelo->getUsuario($this->session->userdata("usu_id_actual"));

		$this->page_title = "Actualizar mi perfil";

		$titulo_form = "Editar información del super administrador";

		$data = array(
				"usu_id" 		=> $consulta['usu_id'],
				"usu_nombre" 	=> $consulta['usu_nombre'],
				"usu_ap" 		=> $consulta['usu_ap'],
				"usu_am" 		=> $consulta['usu_am'],
				"usu_email"		=> $consulta['usu_email'],
				"usu_username"	=> $consulta['usu_username'],
				"usu_telefono"	=> $consulta['usu_telefono'],
				"usu_celular"	=> $consulta['usu_celular'],
				"usu_dni"		=> $consulta['usu_dni'],
				
				"usu_observacion"	=> $consulta['usu_observacion'],
				"usu_estado"	=> $consulta['usu_estado'],

				"button_text"	=> "Actualizar información",

				"action"		=> "index"
			);

		$this->layout->view("admin_form_view", $data);
	}
}

