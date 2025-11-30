<?php
class Clientes extends CI_Controller
{
	//public $username;
	//public $cli_name;

	public $page_title;
	public $page_current_cliente;

	public $current_cliente_lista;
	public $current_cliente_insertar;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Clientes";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        //si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cli")) redirect (base_url().'backend/');

        $this->load->model("cliente_modelo");
        $this->load->model("centro_modelo");
        $this->page_current_cliente = "class='current'";
        $this->layout->setTitle($this->page_title);
	}

	public function index($sw='')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cli_lista")) redirect (base_url().'backend/');

		//page current
		$this->current_cliente_lista = "class='current'";

		$this->page_title = "Clientes";

		$data = array(
				"lista"  => $this->cliente_modelo->getLista($sw),
			);

		$this->layout->view("cliente_list_view", $data);
	}

	public function insertar()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cli_nuevo")) redirect (base_url().'backend/');
		
		$this->page_title = "Nuevo Cliente";

		//page current
		$this->current_cliente_insertar = "class='current'";

		if($this->input->post("submit"))
		{
			$this->cliente_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/clientes/index/1");
		}elseif($this->input->post("submit-nuevo")){
			$this->cliente_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/clientes/insertar/");
		}

		$data = array(
					"action"	=> "insertar",
					//"titulo_form"=>"Ingrese nuevo cliente",
					"cli_id"	=> "",
					"cli_name"	=> '',
					"cli_cif"	=> '1',
					"cli_contact"	=> '',
					"cli_phone"	=> '',
					"cli_mail"	=> '',
					"cli_description"	=> '',
					"cli_state"	=> '1',
					"centros" => array(),
					"centros_lista" => $this->centro_modelo->getLista(),
				);
		$this->layout->view("cliente_form_view", $data);
	}

	public function editar($id='')
	{
		$this->page_title = "Editar Cliente";
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cli_editar")) redirect (base_url().'backend/');

		$this->current_cliente_insertar = "class='current'";

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->cliente_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/clientes/index/1");
		}
		elseif($this->input->post("submit-nuevo"))
		{
			$this->cliente_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/clientes/insertar");
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->cliente_modelo->getId($id);

		if($consulta == true)
		{
			//$titulo_form = "Editar información";
			$data = array(
				"action"		=> "editar",
				"cli_id" 		=> $consulta->cli_id,

				"cli_name"	=> $consulta->cli_name,
				"cli_cif"=> $consulta->cli_cif,
				"cli_contact"=> $consulta->cli_contact,
				"cli_phone"=> $consulta->cli_phone,
				"cli_mail"=> $consulta->cli_mail,
				"cli_description"=> $consulta->cli_description,
				"cli_state"=> $consulta->cli_state,
				"centros_lista" => $this->centro_modelo->getLista(),
				"centros" => $this->cliente_modelo->getCentrosByCliId($consulta->cli_id)
			);

			$this->layout->view("cliente_form_view", $data);
		}
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("cli_eliminar")) redirect (base_url().'backend/');

		if($w == 'DEL')
			$this->cliente_modelo->delete_fisica($id);
		else
			$this->cliente_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/clientes/index/1");
	}
}
 ?>
