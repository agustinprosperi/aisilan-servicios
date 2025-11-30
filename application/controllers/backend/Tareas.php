<?php
class Tareas extends CI_Controller
{
	//public $username;
	//public $tar_name;

	public $page_title;
	public $page_current_tarea;

	public $current_tarea_lista;
	public $current_tarea_insertar;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Gestión de tareas";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        //si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("tar_lista")) redirect (base_url().'backend/');

        $this->load->model("evento_modelo");
        $this->load->model("tarea_modelo");
        $this->load->model("categoria_modelo");
        $this->load->model("notificacion_modelo");
        //$this->page_current_tarea = "class='current'";
		$this->page_current_setting = "class='current'";
        $this->layout->setTitle($this->page_title);
	}

	public function index($sw='')
	{
		
		//page current
		$this->current_tarea_lista = "class='current'";

		$titulo_form = "Lista de Tareas";

		$data = array(
				"lista"  => $this->tarea_modelo->getLista($sw),
				"titulo_form"	=> $titulo_form
			);

		$this->layout->view("tarea_list_view", $data);
	}

	public function insertar()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("tar_nuevo")) redirect (base_url().'backend/');

		//page current
		//$this->current_tarea_insertar = "class='current'";
		$this->current_tarea_lista = "class='current'";

		if($this->input->post("submit"))
		{
			$this->tarea_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/tareas/index/1");
		}elseif($this->input->post("submit-nuevo")){
			$this->tarea_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/tareas/insertar/");
		}

		$data = array(
					"action"	=> "insertar",
					"titulo_form"=>"Ingrese nueva tarea",
					"tar_id"	=> "",
					"tar_name"	=> '',
					"tar_state"	=> '1',
					"tar_sigla" => '',

					"categorias_lista" => $this->categoria_modelo->getLista(1),
					"categorias_selected" => [],

					//"centros" => $this->tarea_modelo->getLista(1)
			);
		$this->layout->view("tarea_form_view", $data);
	}

	public function editar($id='')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("tar_editar")) redirect (base_url().'backend/');

		//$this->current_tarea_insertar = "class='current'";
		$this->current_tarea_lista = "class='current'";

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->tarea_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/tareas/index/1");
		}
		elseif($this->input->post("submit-nuevo"))
		{
			$this->tarea_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/tareas/insertar");
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->tarea_modelo->getId($id);

		if($consulta == true)
		{

			$titulo_form = "Editar información";
			$data = array(
				"action"		=> "editar",
				"tar_id" 		=> $consulta->tar_id,

				"tar_name"	=> $consulta->tar_name,
				"tar_state"=> $consulta->tar_state,
				"tar_description"=> $consulta->tar_description,
				"tar_sigla"=> $consulta->tar_sigla,

				"categorias_lista" => $this->categoria_modelo->getLista(1),
				"categorias_selected" => $this->categoria_modelo->getListaCategorias($consulta->tar_id),
				//"centros" => $this->tarea_modelo->getLista(1),
				"titulo_form"	=> $titulo_form
			);

			$this->layout->view("tarea_form_view", $data);
		}
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("tar_eliminar")) redirect (base_url().'backend/');

		if($w == 'DEL')
			$this->tarea_modelo->delete_fisica($id);
		else
			$this->tarea_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/tareas/index/1");
	}

	
	
	public function ajax_validar_tarea(){
		$eve_tar_id = $this->input->post('eve_tar_id');
		$state_ck = $this->input->post('state_ck');

		//Notificación de sistema: Avisar que se modifico la tarea
		if($state_ck == "true") {
			$state = 1;
			$not_message = "El coordinador validó la tarea";
			$not_type = '0';//informativo
		}else{ 
			$state = 0;
			$not_message = "El coordinador no validó la tarea";
			$not_type = '1';//advertencia
		}

		$this->tarea_modelo->validarTarea($eve_tar_id, $state);

		//obtener info de event_task
		$event_task = $this->tarea_modelo->getEventTaskByEveTarId($eve_tar_id);

		$evento = $this->evento_modelo->getId($event_task->eve_id);

		$this->notificacion_modelo->crear_notificacion_trabajador($not_message, $not_type, $event_task->eve_id, $eve_tar_id, $event_task->tra_id, $evento->coo_id);
	}
	
}
 ?>
