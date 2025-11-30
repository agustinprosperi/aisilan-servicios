<?php
class Feriados extends CI_Controller
{
	public $username;
	public $usu_nombre;

	public $page_title;
	public $page_current_setting;
	public $current_feriado_lista;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("fer_lista")) redirect (base_url().'backend/');

		if(isset($_GET['fer_type']) and $_GET['fer_type'] == "Nacional")
			$this->page_title = "Gestión de Feriados Nacionales";
		elseif(isset($_GET['fer_type']) and $_GET['fer_type'] == "Local")
			$this->page_title = "Gestión de Feriados Locales";


		/* Si no esta logueado lo redirigmos al formulario de login. */

        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

		$this->load->model("feriado_modelo");
		$this->load->model("localidad_modelo");
		$this->load->model("provincia_modelo");
        $this->page_current_setting = "class='current'";
        $this->current_feriados = "class='current'";
        $this->layout->setTitle("Gestión de Feriados");
	}

	public function index()
	{
		//page current
		$this->current_feriado_lista = "class='current'";

		$type = isset($_GET['fer_type'])?$_GET['fer_type']:"";
		$month = isset($_GET['fer_month'])?$_GET['fer_month']:"";
		$year = isset($_GET['fer_year'])?$_GET['fer_year']:"";

		$prov_id = isset($_GET['prov_id'])?$_GET['prov_id']:"";
		$loc_id = isset($_GET['loc_id'])?$_GET['loc_id']:"";

		$data = array(
			"feriados"  => $this->feriado_modelo->getLista($type, $month, $year, $prov_id, $loc_id),
			"action"	=> "insertar",
			"fer_id"	=> '',
			"fer_year"	=> date("Y"),
			"fer_month"	=> '',
			"fer_day"	=> '',
			"fer_name"	=> '',

			"fer_type"	=> isset($_GET['fer_type'])?$_GET['fer_type']:"",
			"prov_id"	=> isset($_GET['prov_id'])?$_GET['prov_id']:"",
			"loc_id"	=> isset($_GET['loc_id'])?$_GET['loc_id']:"",

			"titulo_form"	=> "Insertar feriado"
		);

		$this->layout->view("feriados_form_view", $data);
	}

	public function insertar()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("fer_nuevo")) redirect (base_url().'backend/');

		//page current
		$this->current_centro_insertar = "class='current'";

		if($this->input->post("submit"))
		{
			$this->feriado_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			$fer_type = $this->input->post("fer_type");
			if($fer_type == "Nacional")
				redirect(base_url()."backend/feriados/index/?fer_type=".$fer_type);
			if($fer_type == "Local"){
				$prov_id = $this->input->post("prov_id");
				$loc_id = $this->input->post("loc_id");
				redirect(base_url()."backend/feriados/index/?fer_type=".$fer_type."&prov_id=".$prov_id."&loc_id=".$loc_id);
			}
		}

		$data = array(
			"action"		=> "editar",
			"titulo_form"	=> "Insertar feriado",
		);

		$this->layout->view("feriados_form_view", $data);
	}

	public function editar($id='')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("fer_editar")) redirect (base_url().'backend/');

		$this->current_centro_insertar = "class='current'";

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->feriado_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			$fer_type = $this->input->post("fer_type");
			if($fer_type == "Nacional")
				redirect(base_url()."backend/feriados/index/?fer_type=".$fer_type);
			if($fer_type == "Local"){
				$prov_id = $this->input->post("prov_id");
				$loc_id = $this->input->post("loc_id");
				redirect(base_url()."backend/feriados/index/?fer_type=".$fer_type."&prov_id=".$prov_id."&loc_id=".$loc_id);
			}
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->feriado_modelo->getId($id);

		if($consulta == true)
		{
			$type = isset($_GET['fer_type'])?$_GET['fer_type']:"";
			$month = isset($_GET['fer_month'])?$_GET['fer_month']:"";
			$year = isset($_GET['fer_year'])?$_GET['fer_year']:"";

			$prov_id = isset($_GET['prov_id'])?$_GET['prov_id']:"";
			$loc_id = isset($_GET['loc_id'])?$_GET['loc_id']:"";

			$data = array(
				"action"		=> "editar",
				"fer_id" 		=> $consulta->fer_id,
				"fer_name"	=> $consulta->fer_name,
				"fer_year"=> $consulta->fer_year,
				"fer_month"=> $consulta->fer_month,
				"fer_day"=> $consulta->fer_day,
				"feriados" => $this->feriado_modelo->getLista($type, $month, $year, $prov_id, $loc_id),

				//"fer_type" => $_GET['fer_type'],

				"titulo_form"	=> "Editar feriado"
			);

			$this->layout->view("feriados_form_view", $data);
		}
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("fer_eliminar")) redirect (base_url().'backend/');

		$this->feriado_modelo->delete_fisica($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		if($_GET['fer_type'] == "Nacional")
			$resultado = redirect(base_url()."backend/feriados/index/?fer_type=".$_GET['fer_type']);
		else
			$resultado = redirect(base_url()."backend/feriados/index/?fer_type=".$_GET['fer_type']."&prov_id=".$_GET["prov_id"]."&loc_id=".$_GET["loc_id"]);
	}
}
 ?>
