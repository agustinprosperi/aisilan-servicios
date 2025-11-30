<?php
class Categorias extends CI_Controller
{
	//public $username;
	//public $cat_name;

	public $page_title;
	public $page_current_categoria;

	public $current_categoria_lista;
	public $current_categoria_insertar;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Gestión de Categorias";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        //si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cat_lista")) redirect (base_url().'backend/');

        $this->load->model("categoria_modelo");
        $this->load->model("tarea_modelo");
        //$this->page_current_categoria = "class='current'";
		$this->page_current_setting = "class='current'";
        $this->layout->setTitle($this->page_title);
	}

	public function index($sw='')
	{
		
		//page current
		$this->current_categoria_lista = "class='current'";

		$titulo_form = "Lista de Categorias";

		$data = array(
				"lista"  => $this->categoria_modelo->getLista($sw),
				"titulo_form"	=> $titulo_form
			);

		$this->layout->view("categoria_list_view", $data);
	}

	public function insertar()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cat_nuevo")) redirect (base_url().'backend/');

		//page current
		//$this->current_categoria_insertar = "class='current'";
		$this->current_categoria_lista = "class='current'";

		if($this->input->post("submit"))
		{
			$this->categoria_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/categorias/index/1");
		}elseif($this->input->post("submit-nuevo")){
			$this->categoria_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/categorias/insertar/");
		}

		$data = array(
					"action"	=> "insertar",
					"titulo_form"=>"Ingrese nueva categoria",
					"cat_id"	=> "",
					"cat_name"	=> '',
					"cat_state"	=> '1',
					"cat_description"	=> '',
					"cat_sigla"	=> '',
			);
		$this->layout->view("categoria_form_view", $data);
	}

	public function editar($id='')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cat_editar")) redirect (base_url().'backend/');

		//$this->current_categoria_insertar = "class='current'";
		$this->current_categoria_lista = "class='current'";

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->categoria_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/categorias/index/1");
		}
		elseif($this->input->post("submit-nuevo"))
		{
			$this->categoria_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/categorias/insertar");
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->categoria_modelo->getId($id);

		if($consulta == true)
		{
			$titulo_form = "Editar información";
			$data = array(
				"action"		=> "editar",
				"cat_id" 		=> $consulta->cat_id,

				"cat_name"	=> $consulta->cat_name,
				"cat_state"=> $consulta->cat_state,
				"cat_description"=> $consulta->cat_description,
				
				"cat_sigla"=> $consulta->cat_sigla,
				
				"titulo_form"	=> $titulo_form
			);

			$this->layout->view("categoria_form_view", $data);
		}
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cat_eliminar")) redirect (base_url().'backend/');

		if($w == 'DEL')
			$this->categoria_modelo->delete_fisica($id);
		else
			$this->categoria_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/categorias/index/1");
	}


	public function ajax_cargar_tareas_por_cat_id()
	{
		$cat_id = $this->input->post("cat_id");
		$txt = "<option value=''></option>";
		$tareas = $this->categoria_modelo->getListaTareas($cat_id);
		foreach ($tareas as $item) {
			$txt .= "<option value='".$item->tar_id."'>".$item->tar_name."</option>";
		}
		echo $txt;
	}
}
 ?>
