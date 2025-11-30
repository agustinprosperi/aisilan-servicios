<?php
class Provincias extends CI_Controller
{
	public $page_title;
	public $page_current_setting;

	public $current_provincia_lista;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Gestión de provincias";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        //si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("prov_lista")) redirect (base_url().'backend/');

        $this->load->model("provincia_modelo");
		$this->load->model("localidad_modelo");
        $this->page_current_setting = "class='current'";
        $this->layout->setTitle($this->page_title);
	}

	public function index()
	{
		
		//page current
		$this->current_provincia_lista = "class='current'";

		$titulo_form = "Lista de Provincias";

		$data = array(
				"lista"  => $this->provincia_modelo->getLista(),
				"titulo_form"	=> $titulo_form
			);

		$this->layout->view("provincia_list_view", $data);
	}

	public function insertar()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("prov_nuevo")) redirect (base_url().'backend/');

		$this->current_provincia_lista = "class='current'";

		if($this->input->post("submit"))
		{
			$this->provincia_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/provincias/index/1");
		}elseif($this->input->post("submit-nuevo")){
			$this->provincia_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/provincias/insertar/");
		}

		$data = array(
					"action"	=> "insertar",
					"titulo_form"=>"Ingrese nueva provincia",
					"prov_id"	=> "",
					"prov_name"	=> '',

					//"centros" => $this->provincia_modelo->getLista(1)
			);
		$this->layout->view("provincia_form_view", $data);
	}

	public function editar($id='')
	{
        $this->current_provincia_lista = "class='current'";
        
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("prov_editar")) redirect (base_url().'backend/');

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->provincia_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/provincias/index/1");
		}
		elseif($this->input->post("submit-nuevo"))
		{
			$this->provincia_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/provincias/insertar");
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->provincia_modelo->getId($id);

		if($consulta == true)
		{
			$titulo_form = "Editar información";
			$data = array(
				"action"		=> "editar",
				"prov_id" 		=> $consulta->prov_id,
				"prov_name"	    => $consulta->prov_name,
				
				"titulo_form"	=> $titulo_form
			);

			$this->layout->view("provincia_form_view", $data);
		}
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("prov_eliminar")) redirect (base_url().'backend/');

		if($w == 'DEL')
			$this->provincia_modelo->delete_fisica($id);
		else
			$this->provincia_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/provincias/index/");
	}

	public function cargar_localidades(){
		$prov_id = $this->input->post("prov_id");

		$localidades = $this->localidad_modelo->getLocalidadesByProvId($prov_id);

		$resp = "<option value='0' selected>Sin especificar</option>";
		foreach ($localidades as $value) {
			$resp .= "<option value='".$value->loc_id."'>".$value->loc_name."</option>";
		}
		$resp .= '';

		echo $resp;
	}
}
 ?>
