<?php

class Usuario extends CI_Controller
{
	public $username;
	public $usu_nombre;


	public $page_title;
	public $page_current_usu;

	public $current_usuario_lista;
	public $current_usuario_insertar;

	public $page_current_setting;
	public $current_permisos;
	private $user_tipo;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("usuario_modelo");
		$this->load->model("institucion_modelo");

		$this->page_title = "Gestión de Usuarios";

		$usu_tipo = $this->session->userdata("usu_tipo_actual");

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
       	if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        $this->layout->setLayout("backend/template_backend");

        $this->page_current_usu = "class='current'";
        $this->layout->setTitle($this->page_title);
	}

	public function index($sw='', $usu_tipo = '')
	{
		//si no tiene permisos es redirigido al escritorio
		switch($usu_tipo){
			case "Administrador" :
				if(!verificarPermiso("usu_adm_lista")) redirect (base_url().'backend/');
			break;
			case "Coordinador" :
				if(!verificarPermiso("usu_coo_lista")) redirect (base_url().'backend/');
			break;
			case "Trabajador" :
				if(!verificarPermiso("usu_tra_lista")) redirect (base_url().'backend/');
			break;
		}

		//page current
		if($usu_tipo == "Administrador") $this->current_usuario_administrador = "class='current'";
		if($usu_tipo == "Coordinador") $this->current_usuario_coordinador = "class='current'";
		if($usu_tipo == "Trabajador") $this->current_usuario_trabajador = "class='current'";

		$this->page_title = "Gestión de ".$usu_tipo."es";

		$data = array(
				"lista"  => $this->usuario_modelo->getLista($sw, $usu_tipo),
				"usu_tipo"		=> $usu_tipo,
			);

		$this->layout->view("usuario_list_view", $data);
	}

	public function insertar($usu_tipo)
	{
		$this->page_title = "Gestión de ".$usu_tipo."es";

		//si no tiene permisos es redirigido al escritorio
		switch($usu_tipo){
			case "Administrador" :
				if(!verificarPermiso("usu_adm_nuevo")) redirect (base_url().'backend/');
			break;
			case "Coordinador" :
				if(!verificarPermiso("usu_coo_nuevo")) redirect (base_url().'backend/');
			break;
			case "Trabajador" :
				if(!verificarPermiso("usu_tra_nuevo")) redirect (base_url().'backend/');
			break;
		}

		//page current
		$this->current_usuario_insertar = "class='current'";
		//page current
		if($usu_tipo == "Administrador") $this->current_usuario_administrador = "class='current'";
		if($usu_tipo == "Coordinador") $this->current_usuario_coordinador = "class='current'";
		if($usu_tipo == "Trabajador") $this->current_usuario_trabajador = "class='current'";

		if($this->input->post("submit"))
		{
			/**
			 * inserta en la tabla un nuevo registro
			 */
			$this->usuario_modelo->insert();
			$usu_id_last = $this->usuario_modelo->getLastId();
			/**
			 * insertar foto
			 */
			if($this->cargar_imagen() == false)
				$ruta_foto = "public/backend/img/silueta.jpg";
			else
				$ruta_foto = $this->cargar_imagen();

			$this->usuario_modelo->setFoto($usu_id_last, $ruta_foto);

			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/usuario/index/1/".$this->input->post('usu_tipo'));
		}
		elseif($this->input->post("submit-nuevo"))
		{
			$this->usuario_modelo->insert();
			$usu_id_last = $this->usuario_modelo->getLastId();


			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/usuario/insertar/".$this->input->post('usu_tipo'));
		}else{
			/**
			 * carga el form para un nuevo registro
			 */

			$titulo_form = "Ingrese nueva información";
			$data = array(
							"action" 	=> "insertar",
							"usu_id"	=> "",
							"usu_sexo"	=> "m",
							"usu_estado"=> "1",
							"usu_fecha_nac"=> "",
							"usu_fecha_alta"=> "",
							'usu_tipo' => $usu_tipo,
							"usu_foto"	=> "",
							"usu_foto_2"=> "",
							"usu_username" => '',
							"usu_password" => '',
							"titulo_form" => $titulo_form,
				);
			$this->layout->view("usuario_form_view", $data);
		}
	}

	public function editar($id='', $usu_tipo='')
	{
		$this->page_title = "Gestión de ".$usu_tipo."es";
		
		//si no tiene permisos es redirigido al escritorio
		switch($usu_tipo){
			case "Administrador":
				if(!verificarPermiso("usu_adm_editar")) redirect (base_url().'backend/');
			break;
			case "Coordinador":
				if(!verificarPermiso("usu_coo_editar")) redirect (base_url().'backend/');
			break;
			case "Trabajador":
				if(!verificarPermiso("usu_tra_editar")) redirect (base_url().'backend/');
			break;
		}

		//page current
		$this->current_usuario_insertar = "class='current'";
		//page current
		if($usu_tipo == "Administrador") $this->current_usuario_administrador = "class='current'";
		if($usu_tipo == "Coordinador") $this->current_usuario_coordinador = "class='current'";
		if($usu_tipo == "Trabajador") $this->current_usuario_trabajador = "class='current'";

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->usuario_modelo->edit();

			if($this->cargar_imagen() == false){
				if($this->input->post("usu_foto_2") != "")
					$ruta_foto = $this->input->post("usu_foto_2");
				else
					$ruta_foto = "public/backend/img/silueta.jpg";
			}else
				$ruta_foto = $this->cargar_imagen();

			$this->usuario_modelo->setFoto($this->input->post("usu_id"), $ruta_foto);

			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/usuario/index/1/".$this->input->post('usu_tipo'));
		}
		elseif($this->input->post("submit-nuevo"))
		{
			$this->usuario_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/usuario/insertar/".$this->input->post('usu_tipo'));
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->usuario_modelo->getId($id);

		if($consulta == true)
		{
			$titulo_form = "Editar información";
			$data = array(
				"action"		=> "editar",
				"usu_id" 		=> $consulta->usu_id,

				"usu_nombre"	=> $consulta->usu_nombre,
				"usu_ap"		=> $consulta->usu_ap,
				"usu_am"		=> $consulta->usu_am,

				"usu_email"		=> $consulta->usu_email,
				"usu_fecha_nac"	=> date("Y-m-d", strtotime($consulta->usu_fecha_nac)),
				"usu_fecha_alta"=> date("Y-m-d", strtotime($consulta->usu_fecha_registro)),
				
				"usu_estado"	=> $consulta->usu_estado,

				"usu_telefono"	=> $consulta->usu_telefono,
				"usu_celular"	=> $consulta->usu_celular,
				"usu_observacion"	=> $consulta->usu_observacion,
				"usu_sexo"		=> $consulta->usu_sexo,
				"usu_foto"		=> $consulta->usu_foto,
				"usu_foto_2"	=> $consulta->usu_foto,
				"usu_tipo"		=> $consulta->usu_tipo,

				"usu_dni"		=> $consulta->usu_dni,

				"usu_username"	=> $consulta->usu_username,
				"usu_password"	=> $consulta->usu_password,

				"titulo_form"	=> $titulo_form
			);

			$this->layout->view("usuario_form_view", $data);
		}
	}

	public function eliminar($w = 'null', $id = 'null', $usu_tipo='')
	{
		//si no tiene permisos es redirigido al escritorio
		switch($usu_tipo){
			case "Administrador":
				if(!verificarPermiso("usu_adm_eliminar")) redirect (base_url().'backend/');
			break;
			case "Coordinador":
				if(!verificarPermiso("usu_coo_eliminar")) redirect (base_url().'backend/');
			break;
			case "Trabajador":
				if(!verificarPermiso("usu_tra_eliminar")) redirect (base_url().'backend/');
			break;
		}

		//$this->usuario_modelo->delete($id);
		if($w == 'DEL')
			$this->usuario_modelo->delete_fisica($id);
		else
			$this->usuario_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/usuario/index/1/".$usu_tipo);
	}

	/**
	 * verificar si existe el usuario
	 */
	public function verificarExistenciaUsername()
	{
		$username = $this->input->post("valor");
		$usu_id = $this->input->post("usu_id");

		if($this->usuario_modelo->verificarExisteUsername($username, $usu_id) == true)
			echo "<script>
			$('#username_error').show();
			$('#username').val('');
			</script>";
		else
			echo "<script>$('#username_error').hide();</script>";
	}
	public function verificarExistenciaEmail()
	{
		$email = $this->input->post("valor");

		if($this->usuario_modelo->verificarExisteEmail($email) == true)
			echo "<script>
			$('#email_error').show();
			$('#usu_email').val('');
			</script>";
		else
			echo "<script>$('#email_error').hide();</script>";
	}

	public function cargar_imagen(){
		$mi_imagen = 'usu_foto';
		//$mi_imagen = $this->input->post("usu_foto");
	    $config['upload_path'] = "./public/backend/img/uploads/";
	    $config['file_name'] = cadena_aleatoria();
	    //$config['file_name'] = "photo0014444";
	    $config['allowed_types'] = "gif|jpg|jpeg|png";
	    $config['max_size'] = "50000";
	    $config['max_width'] = "500";
	    $config['max_height'] = "500";

		$this->load->library('upload', $config);

	    if (!$this->upload->do_upload($mi_imagen)) {
	        //*** ocurrio un error
	        $data['uploadError'] = $this->upload->display_errors();
	        return false;
	    }

	    $photo = $this->upload->data();
	    return "public/backend/img/uploads/".$photo["file_name"];
	}

	public function permisos()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("config_permiso")) redirect (base_url().'backend/');

		$this->page_current_usu = "";
		$this->page_current_setting = "class='current'";
		$this->current_permisos = "class='current'";

		$this->page_title = "Gestión de Permisos";
		$this->layout->setTitle($this->page_title);

		$data = array(
			"titulo_form"	=> "Permisos"
		);

		$this->layout->view("permisos_view", $data);
	}
	/**
	 * Cabiar permiso ajax
	 */
	public function cambiar_permiso()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("config_permiso")) redirect (base_url().'backend/');

		$modulo = $this->input->post("modulo");
		$rol = $this->input->post("rol");
		$estado = $this->input->post("estado");

		$this->usuario_modelo->setPermiso($modulo, $rol, $estado);
	}
}
