<?php
class Index extends CI_Controller
{
	public $username;
	public $usu_nombre;

	public $page_title;
	public $page_current_index;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Escritorio";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        $this->page_current_index = "class='current'";
        $this->layout->setTitle("Escritorio");
	}

	public function index()
	{
		$data = array(
						"anio_actual"	=> date("Y")
			);
		$this->layout->view("index", $data);
	}
}
