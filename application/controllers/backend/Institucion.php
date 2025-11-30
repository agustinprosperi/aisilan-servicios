<?php
class Institucion extends CI_Controller
{
	public $username;
	public $usu_nombre;

	public $page_title;
	public $page_current_setting;
	public $page_current_ue;

    public $current_institucion;
	public $current_fechas;
	public $current_importaciones;
	public $current_import_export;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Institución";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        $this->page_current_config = "class='current'";
        $this->load->model("institucion_modelo");
        $this->load->model("usuario_modelo");
        $this->layout->setTitle("Institución");
	}

	public function index()
	{
		$data = array(
					"titulo_form"	=> "",
					"institucion"		=> $this->institucion_modelo->getLista()
			);
		$this->layout->view("institucion_list_view", $data);
	}

	public function insertar()
	{
		if($this->input->post("submit")){
			$this->institucion_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue creado satisfactoriamente.", true);
			redirect(base_url()."backend/institucion/");
		}

		/**
		 * insertar logo
		 */
		if($this->cargar_imagen() == false)
			$ruta_logo = "public/backend/img/logo-general.jpg";
		else
			$ruta_logo = $this->cargar_imagen();

		$ue_id_last = $this->institucion_modelo->getLastId();
		$this->institucion_modelo->setFoto($ue_id_last, $ruta_logo);

		$this->page_current_ue = "class='current'";
		$data = array(
					"action" 		=> "insertar",
					"titulo_form"	=> "Ingrese información",
					"ue_estado"		=> 1,
					"ue_logo"	=> "",
					"ue_logo_2"=> "",
			);
		$this->layout->view("institucion_form_view", $data);
	}

	public function editar($ue_id='')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("config_institucion")) redirect (base_url().'backend/');

		$this->page_current_setting = "class='current'";
		$this->current_institucion = "class='current'";
		if($this->input->post("submit")){
			$this->institucion_modelo->edit();

			/**
			 * insertar logo
			 */


			if($this->cargar_imagen() == false){
				if($this->input->post("ue_logo_2") != "")
					$ruta_logo = $this->input->post("ue_logo_2");
				else
					$ruta_logo = "public/backend/img/logo-general.jpg";
			}else
				$ruta_logo = $this->cargar_imagen();

			$this->institucion_modelo->setFoto($this->input->post('ue_id'), $ruta_logo);

			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue actualizado satisfactoriamente.", true);
			redirect(base_url()."backend/institucion/editar/".$this->input->post('ue_id'));
		}

		$this->page_current_ue = "class='current'";
		$institucion = $this->institucion_modelo->getId($ue_id);
		$data = array(
					"action" 		=> "editar",
					"ue_id"			=> $ue_id,
					"ue_nombre"		=> $institucion->ue_nombre,
					"ue_residencia"	=> $institucion->ue_residencia,
					"ue_telefono"	=> $institucion->ue_telefono,
					"ue_email"		=> $institucion->ue_email,
					"ue_direccion"	=> $institucion->ue_direccion,
					"ue_director"	=> $institucion->ue_director,
					"ue_estado"		=> $institucion->ue_estado,
					"ue_logo"		=> $institucion->ue_logo,
					"ue_logo_2"		=> $institucion->ue_logo,
					"titulo_form"	=> "Editar información",
			);
		$this->layout->view("institucion_form_view", $data);
	}

	public function eliminar($w = '', $id = null)
	{
		if($w == 'DEL')
			$this->institucion_modelo->delete_fisica($id);
		else
			$this->institucion_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/institucion/index/");
	}

	public function cargar_imagen(){
		$mi_imagen = 'ue_logo';
		//$mi_imagen = $this->input->post("usu_foto");
	    $config['upload_path'] = "./public/backend/img/uploads/";
	    $config['file_name'] = cadena_aleatoria();
	    //$config['file_name'] = "photo0014444";
	    $config['allowed_types'] = "gif|jpg|jpeg|png";
	    $config['max_size'] = "50000";
	    $config['max_width'] = "1000";
	    $config['max_height'] = "1000";

		$this->load->library('upload', $config);

	    if (!$this->upload->do_upload($mi_imagen)) {
	        //*** ocurrio un error
			$data['uploadError'] = $this->upload->display_errors();

	        return false;
	    }

	    $photo = $this->upload->data();
	    return "public/backend/img/uploads/".$photo["file_name"];
	}

}
 ?>
