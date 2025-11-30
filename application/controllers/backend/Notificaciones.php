<?php
class Notificaciones extends CI_Controller
{
	//public $username;
	//public $cli_name;

	public $page_title;
	public $page_current_notificaciones;

	public $current_notificaciones_lista;
	public $current_notificaciones_insertar;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Notificaciones";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

       
        $this->page_current_notificaciones = "class='current'";

		$this->load->model("notificacion_modelo");
        $this->layout->setTitle($this->page_title);
	}

	public function index($sw='')
	{
        //page current
		$this->current_notificaciones_lista = "class='current'";
		$data = array(
			"notificaciones_hoy" => $this->notificacion_modelo->lista_notificaciones('hoy'),// todas de hoy
			"notificaciones_ayer" => $this->notificacion_modelo->lista_notificaciones('ayer'), //todas de ayer
			"notificaciones_ni_hoy_ayer" => $this->notificacion_modelo->lista_notificaciones('ni_hoy_ayer'), //todas menos hoy ni ayer
		);
		$this->layout->view("notificaciones_list_view", $data);
	}
	public function eliminar_notificacion_ajax() // yess
	{
		$not_id = $this->input->post("not_id");
		$this->notificacion_modelo->actualizar_estado($not_id);
	}
	/*
	public function insertar()
	{
		
	}

	public function editar($id='')
	{
		
	}

	public function eliminar($w = '', $id = null)
	{
		
	}
	*/
	
}
 ?>
