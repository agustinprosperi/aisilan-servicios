<?php
class Usuario_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * obtener en un array toda la lista de usuarios
	 */
	public function getLista($sw = '', $usu_tipo = '')
	{
		if($sw == "")
			$where_sw = "1";
		else
			$where_sw = "usu_estado = '$sw'";

		if($usu_tipo == "")
			$where_usu_tipo = "1";
		else
			$where_usu_tipo = "usu_tipo = '$usu_tipo'";

		/*$usu_id_actual = $this->session->userdata("usu_id_actual");

		if($usu_id_actual != "1")
			$where_usuario = "usu_id <> '$usu_id_actual'";
		else */
			$where_usuario = "1";

		$query = $this->db->query("	SELECT *
									FROM usuario
									WHERE 1
										and $where_usu_tipo
										and $where_sw
										and $where_usuario
									ORDER BY usu_ap, usu_am, usu_nombre");
		return $query->result();
	}

	public function getLastId()
	{
		$query = $this->db->query("SELECT MAX(usu_id) AS usu_id FROM usuario");
		$resultado = $query->row();
		return $resultado->usu_id;
	}

	/**
	 * insertar un registro en la tabla usuario
	 */
	public function insert($usu_nombre='',$usu_ap='',$usu_am='',$usu_dni='')
	{
		//$usu_fecha_nac = date("Y-m-d", strtotime(!empty($this->input->post("usu_fecha_nac"))?$this->input->post("usu_fecha_nac"):"2000-09-29"));

		$data = array(
				"usu_id" 		=> null,

				"usu_nombre"	=> !empty($this->input->post("usu_nombre"))?$this->input->post("usu_nombre"):$usu_nombre,
				"usu_ap"		=> !empty($this->input->post("usu_ap"))?$this->input->post("usu_ap"):$usu_ap,
				"usu_am"		=> !empty($this->input->post("usu_am"))?$this->input->post("usu_am"):$usu_am,

				"usu_email"		=> !empty($this->input->post("usu_email"))?$this->input->post("usu_email"):"",
				"usu_estado"	=> !empty($this->input->post("usu_estado"))?$this->input->post("usu_estado"):"1",

				"usu_telefono"	=> !empty($this->input->post("usu_telefono"))?$this->input->post("usu_telefono"):"",
				"usu_celular"	=> !empty($this->input->post("usu_celular"))?$this->input->post("usu_celular"):"",
				"usu_direccion"	=> !empty($this->input->post("usu_direccion"))?$this->input->post("usu_direccion"):"",

				"usu_dni"		=> !empty($this->input->post("usu_dni"))?$this->input->post("usu_dni"):$usu_dni,
				//"usu_especialidad"=> $this->input->post("usu_especialidad"),
				"usu_sexo"		=> !empty($this->input->post("usu_sexo"))?$this->input->post("usu_sexo"):"m",
				"usu_fecha_nac"	=> $this->input->post("usu_fecha_nac"),
				"usu_tipo"		=> !empty($this->input->post("usu_tipo"))?$this->input->post("usu_tipo"):"Estudiante",

				"usu_username"	=> !empty($this->input->post("usu_username"))?$this->input->post("usu_username"):$usu_ci,
				"usu_password"	=> md5(!empty($this->input->post("usu_password"))?$this->input->post("usu_password"):""),

				"usu_fecha_registro"=>$this->input->post('usu_fecha_alta')." ".date('H:i:s'),
				"usu_fecha_modificacion"=>date("Y-m-d H:i:s")
			);
		$this->db->insert("usuario", $data);
	}


	/**
	 * Obtener información un usuario por su id
	 */
	public function getId($id)
	{
		$query = $this->db->get_where("usuario", array("usu_id"=>$id));

		if($query->num_rows() > 0)
		{
			return $query->row();
		}else
			return false;
	}

	/**
	 * Obtener datos de usuarios teniendo como dato username
	 */
	public function getUserName($username)
	{
		$query = $this->db->get_where("usuario", array("usu_username"=>$username));

		if($query->num_rows() > 0)
		{
			return $query->row();
		}else
			return false;
	}

	/**
	 * Obtener tipo de usuario
	 */
	public function getTipo($usu_id)
	{
		$query = $this->db->get_where("usuario", array("usu_id"=>$usu_id));
		$result =  $query->row();
		return $result->usu_tipo;
	}

	/**
	 * editar el registro de la base de datos
	 */
	public function edit()
	{
		$usu_fecha_nac = date("Y-m-d", strtotime($this->input->post("usu_fecha_nac")));

		$data = array(

				"usu_nombre"	=> $this->input->post("usu_nombre"),
				"usu_ap"		=> $this->input->post("usu_ap"),
				"usu_am"		=> $this->input->post("usu_am"),

				"usu_email"		=> $this->input->post("usu_email"),
				"usu_estado"		=> $this->input->post("usu_estado"),

				"usu_telefono"	=> $this->input->post("usu_telefono"),
				"usu_celular"	=> $this->input->post("usu_celular"),
				"usu_direccion"	=> $this->input->post("usu_direccion"),

				"usu_dni"		=> $this->input->post("usu_dni"),
				//"usu_especialidad"=> $this->input->post("usu_especialidad"),
				"usu_sexo"=> $this->input->post("usu_sexo"),
				"usu_fecha_nac"=> $usu_fecha_nac,
				"usu_tipo"		=> $this->input->post("usu_tipo"),

				"usu_username"	=> $this->input->post("usu_username"),
				"usu_fecha_registro"=>$this->input->post('usu_fecha_alta')." ".date('H:i:s'),
				"usu_fecha_modificacion"=>date("Y-m-d H:i:m")
			);
		if($this->input->post("usu_password") != "")
			$data["usu_password"] = md5($this->input->post("usu_password"));

		$this->db->where("usu_id", $this->input->post("usu_id"));
		$this->db->update("usuario", $data);

	}

	public function delete($id)
	{
		if($id == 'null'){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("UPDATE usuario SET usu_estado='0' WHERE usu_id IN(".$lista.")");
		}else
			return $this->db->query("UPDATE usuario SET usu_estado='0' WHERE usu_id='$id'");
	}

	public function delete_fisica($id)
	{
		if($id == 'null'){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM usuario WHERE usu_id IN(".$lista.")");
		}else{
			return $this->db->query("DELETE FROM usuario WHERE usu_id='$id'");
		}
	}

	/**
	 * Cambiar de estado a un usuario
	 */
	public function setApAmNom($usu_id, $ap, $am, $nom)
	{
		$data = array(
			"usu_ap" => $ap,
			"usu_am" => $am,
			"usu_nombre" => $nom
		);
		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}

	/**
	 * guardar foto
	 */
	public function setFoto($usu_id, $ruta_foto)
	{
		$data = array("usu_foto" => $ruta_foto);
		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}

	/**
	 * Cambiar de estado a un usuario
	 */
	public function setEstado($usu_id, $estado)
	{
		$data = array("usu_estado" => $estado);
		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}

	/**
	 * Cambiar de username
	 */
	public function setUserName($usu_id, $username)
	{
		$data = array("usu_username" => $username);
		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}

	/**
	 * Cambiar de password
	 */
	public function setPassword($usu_id, $password)
	{
		$data = array("usu_password" => $password);
		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}

	/**
	 * Cambiar Inscripcion tipo
	 */
	public function setInscriptionTipo($usu_id, $tipo)
	{
		$data = array("usu_inscripcion_tipo" => $tipo);
		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}

	/**
	 * Cambiar de observacion
	 */
	public function setObservacion($usu_id, $observacion)
	{
		$data = array("usu_observacion" => $observacion);
		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}

	public function setCode($usu_id, $code)
	{
		$data = array(
			"usu_code_login" => $code
		);

		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}

	public function setEmptyCode($usu_id)
	{
		$data = array(
			"usu_code_login" => ""
		);

		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}




	public function verificarExisteUsername($valor, $usu_id)
	{
		$query = $this->db->get_where("usuario", array(
			"usu_username"=>$valor,
			"usu_id !=" => $usu_id
		));
		$num = $query->num_rows();

		if($num >= 1)
			return true;
		else
			return false;
	}
	public function verificarExisteEmail($valor)
	{
		$query = $this->db->get_where("usuario", array("usu_email"=>$valor));
		$num = $query->num_rows();

		if($num >= 1)
			return true;
		else
			return false;
	}

	/**
	 * obtener estado de permiso
	 */
	public function getPermiso($modulo, $rol)
	{
		$data = array(
			"modulo" => $modulo,
			"rol" => $rol
		);

		$query = $this->db->get_where("permisos", $data);

		if($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result->estado;
		}else
			return false;
	}

	public function setPermiso($modulo, $rol, $estado)
	{
		$data = array(
			"estado" => $estado
		);

		$this->db->where("modulo", $modulo);
		$this->db->where("rol", $rol);
		$this->db->update("permisos", $data);
	}

	/**
	 * establecer si un usuario esta online o no
	 */
	public function setOnline($usu_id, $online)
	{
		$data = array(
			"usu_online" => $online
		);

		$this->db->where("usu_id", $usu_id);
		$this->db->update("usuario", $data);
	}
}
 ?>
