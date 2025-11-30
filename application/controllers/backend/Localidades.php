<?php
class Localidades extends CI_Controller
{
	public $page_title;
	public $page_current_setting;

	public $current_localidad_lista;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Gestión de localidades";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        //si no tiene permisos es redirigido al escritorio
		//if(!verificarPermiso("mat")) redirect (base_url().'backend/');

        $this->load->model("localidad_modelo");
        $this->load->model("provincia_modelo");
        $this->page_current_setting = "class='current'";
        $this->layout->setTitle($this->page_title);
	}

	public function index()
	{
		
		//page current
		$this->current_localidad_lista = "class='current'";

		$titulo_form = "Lista de Localidades";

		$data = array(
				"lista"  => $this->localidad_modelo->getLista(),
				"titulo_form"	=> $titulo_form
			);

		$this->layout->view("localidad_list_view", $data);
	}

	public function insertar()
	{
		//si no tiene permisos es redirigido al escritorio
		//if(!verificarPermiso("loc_nueva")) redirect (base_url().'backend/');

		$this->current_localidad_lista = "class='current'";

		if($this->input->post("submit"))
		{
			$this->localidad_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/localidades/index/1");
		}elseif($this->input->post("submit-nuevo")){
			$this->localidad_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/localidades/insertar/");
		}

		$data = array(
					"action"	    => "insertar",
					"titulo_form"   =>"Ingrese nueva provincia",
					"loc_id"	    => "",
					"loc_name"	    => '',
					"prov_id"	    => '',
                    "provincias"    => $this->provincia_modelo->getLista(),
					
			);
		$this->layout->view("localidad_form_view", $data);
	}

	public function editar($id='')
	{
        $this->current_localidad_lista = "class='current'";
        
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("loc_editar")) redirect (base_url().'backend/');

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->localidad_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/localidades/index/1");
		}
		elseif($this->input->post("submit-nuevo"))
		{
			$this->localidad_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/localidades/insertar");
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->localidad_modelo->getId($id);

		if($consulta == true)
		{
			$titulo_form = "Editar información";
			$data = array(
				"action"		=> "editar",
				"loc_id" 		=> $consulta->loc_id,
				"loc_name"	    => $consulta->loc_name,
                "prov_id"	    => $consulta->prov_id,
                "provincias"    => $this->provincia_modelo->getLista(),
				
				"titulo_form"	=> $titulo_form
			);

			$this->layout->view("localidad_form_view", $data);
		}
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("loc_eliminar")) redirect (base_url().'backend/');

		if($w == 'DEL')
			$this->localidad_modelo->delete_fisica($id);
		else
			$this->localidad_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/localidades/index/");
	}
}
 ?>
