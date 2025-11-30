<?php
class Horquillahoraria extends CI_Controller
{
	public $page_title;
	public $page_current_setting;
	public $current_horquilla_horaria_lista;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");
        $this->page_title = "Gestión de Horquillas Horarias";


		/* Si no esta logueado lo redirigmos al formulario de login. */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

		$this->load->model("horquillahoraria_modelo");
		$this->page_current_setting = "class='current'";
        $this->current_horquilla_horaria = "class='current'";
        $this->layout->setTitle("Gestión de Horquillas Horarias");
	}

	public function index($sw='')
	{
		//page current
		$this->current_horquilla_horaria_lista = "class='current'";

		$data = array(
			"hor_id"		=> 0,
			"hor_name"		=> '',
			"hor_laborable"	=> '',
			"hor_laborable_nocturno"=> '',
			"hor_festivo"	=> '',
			"hor_festivo_nocturno"	=> '',
			"hor_state"		=> 1,
			"horquillas" => $this->horquillahoraria_modelo->getLista($sw),
			"action"	=> "insertar",

			"titulo_form"	=> "Insertar"
		);

		$this->layout->view("horquilla_horaria_form_view", $data);
	}

	public function insertar()
	{
		//si no tiene permisos es redirigido al escritorio
		//if(!verificarPermiso("cen_nueva")) redirect (base_url().'backend/');

		//page current
		$this->current_centro_insertar = "class='current'";

		if($this->input->post("submit"))
		{
			$this->horquillahoraria_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/horquillahoraria/index/");
			
		}

		$this->layout->view("horquilla_horaria_form_view", $data);
	}

	public function editar($id='')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cen_editar")) redirect (base_url().'backend/');

		$this->current_centro_insertar = "class='current'";

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->horquillahoraria_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/horquillahoraria/index/1");
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->horquillahoraria_modelo->getId($id);

		if($consulta == true)
		{
			$data = array(
				"action"		=> "editar",
				"hor_id" 		=> $consulta->hor_id,
				"hor_name"		=> $consulta->hor_name,
				"hor_laborable"	=> $consulta->hor_laborable,
				"hor_laborable_nocturno"=> $consulta->hor_laborable_nocturno,
				"hor_festivo"	=> $consulta->hor_festivo,
				"hor_festivo_nocturno"	=> $consulta->hor_festivo_nocturno,
				"hor_state"		=> $consulta->hor_state,
				
				"horquillas" => $this->horquillahoraria_modelo->getLista(1),
                "titulo_form"	=> "Editar"
			);

			$this->layout->view("horquilla_horaria_form_view", $data);
		}
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("hor_eliminar")) redirect (base_url().'backend/');

		if($w == 'DEL')
			$this->horquillahoraria_modelo->delete_fisica($id);
		else
			$this->horquillahoraria_modelo->delete($id);
		

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		redirect(base_url()."backend/horquillahoraria/index/1");
	}
}
