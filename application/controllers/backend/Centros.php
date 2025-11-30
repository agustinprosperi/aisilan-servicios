<?php
class Centros extends CI_Controller
{
	//public $username;
	//public $cen_name;

	public $page_title;
	public $page_current_centro;

	public $current_centro_lista;
	public $current_centro_insertar;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Gestión de Centros de Trabajo";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        //si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cen")) redirect (base_url().'backend/');

        $this->load->model("centro_modelo");
		$this->load->model("provincia_modelo");
		$this->load->model("localidad_modelo");
		$this->load->model("horquillahoraria_modelo");
        $this->page_current_centro = "class='current'";
        $this->layout->setTitle($this->page_title);
	}

	public function index($sw='')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cen_lista")) redirect (base_url().'backend/');

		//page current
		$this->current_centro_lista = "class='current'";

		$titulo_form = "Lista de Centros de Trabajo";

		$data = array(
				"lista"  => $this->centro_modelo->getLista($sw),
				"titulo_form"	=> $titulo_form
			);

		$this->layout->view("centro_list_view", $data);
	}

	public function insertar()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cen_nuevo")) redirect (base_url().'backend/');

		//page current
		$this->current_centro_insertar = "class='current'";

		if($this->input->post("submit"))
		{
			$this->centro_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/centros/index/1");
		}elseif($this->input->post("submit-nuevo")){
			$this->centro_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/centros/insertar/");
		}

		$data = array(
					"action"	=> "insertar",
					"titulo_form"=>"Ingrese nuevo centro de trabajo",
					"cen_id"	=> "",
					"cen_name"	=> '',
					"cen_state"	=> '1',

					"centros" => $this->centro_modelo->getLista(1),
					"provincias" => $this->provincia_modelo->getLista(),
					"horquillas"    => $this->horquillahoraria_modelo->getLista(1),
			);
		$this->layout->view("centro_form_view", $data);
	}

	public function editar($id='')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cen_editar")) redirect (base_url().'backend/');

		$this->current_centro_insertar = "class='current'";

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->centro_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/centros/index/1");
		}
		elseif($this->input->post("submit-nuevo"))
		{
			$this->centro_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/centros/insertar");
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->centro_modelo->getId($id);

		if($consulta == true)
		{
			$titulo_form = "Editar información";
			$data = array(
				"action"		=> "editar",
				"cen_id" 		=> $consulta->cen_id,

				"cen_name"	=> $consulta->cen_name,
				"cen_state"=> $consulta->cen_state,
				"cen_description"=> $consulta->cen_description,
				"prov_id"=> $consulta->prov_id,
				"loc_id"=> $consulta->loc_id,
				"hor_id"=> $consulta->hor_id,
				"centros" => $this->centro_modelo->getLista(1),
				"titulo_form"	=> $titulo_form,

				"provincias" => $this->provincia_modelo->getLista(),
				"localidades" => $this->localidad_modelo->getLocalidadesByProvId($consulta->prov_id),
				"horquillas"    => $this->horquillahoraria_modelo->getLista(1),
			);

			$this->layout->view("centro_form_view", $data);
		}
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cen_eliminar")) redirect (base_url().'backend/');

		if($w == 'DEL')
			$this->centro_modelo->delete_fisica($id);
		else
			$this->centro_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/centros/index/1");
	}
}
 ?>
