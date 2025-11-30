<?php
class Proyectos extends CI_Controller
{
	//public $username;
	//public $pro_name;

	public $page_title;
	public $page_current_proyecto;

	public $current_proyecto_lista;
	public $current_proyecto_insertar;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Gestión de Proyectos";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        //si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("pro")) redirect (base_url().'backend/');

        $this->load->model("proyecto_modelo");
        $this->load->model("cliente_modelo");
        $this->load->model("usuario_modelo");
        $this->load->model("tarea_modelo");

        $this->page_current_proyecto = "class='current'";
        $this->layout->setTitle($this->page_title);
	}

	public function index($sw='')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("pro_lista")) redirect (base_url().'backend/');

		//page current
		$this->current_proyecto_lista = "class='current'";

		$data = array(
					"lista"  => $this->proyecto_modelo->getLista($sw),
				);

		$this->layout->view("proyecto_list_view", $data);
	}

	public function insertar()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("pro_nuevo")) redirect (base_url().'backend/');
		
		$this->page_title = "Nuevo Proyecto";

		//page current
		$this->current_proyecto_insertar = "class='current'";

		if($this->input->post("submit"))
		{
			$id = $this->proyecto_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/proyectos/editar/".$id);
		}/*elseif($this->input->post("submit-nuevo")){
			$id = $this->proyecto_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			redirect(base_url()."backend/proyectos/insertar/");
		}*/

		$data = array(
					"action"	=> "insertar",
					"pro_id"	=> "",
					"pro_name"	=> '',
					"pro_state"	=> '1',
					"pro_description"	=> '',
					"pro_tipo_horario" => 'Partido',

					"cli_id"	=> '',
					"coo_id"	=> '',

					"proyectos" => $this->proyecto_modelo->getLista(1),
					"clientes" => $this->cliente_modelo->getLista(1),
					"coordinadores" => $this->usuario_modelo->getLista(1,'Coordinador'),
					"trabajadores" => $this->usuario_modelo->getLista(1,'Trabajador'),
					"tareas" => $this->tarea_modelo->getLista(1),
					"lista_trabajadores_proyecto" => array(),
				);
		$this->layout->view("proyecto_form_view", $data);
	}

	public function editar($id='')
	{
		$this->page_title = "Editar Proyecto";

		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("pro_editar")) redirect (base_url().'backend/');

		$this->current_proyecto_insertar = "class='current'";

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			$this->proyecto_modelo->edit();
			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/proyectos/editar/".$this->input->post("pro_id"));
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->proyecto_modelo->getId($id);

		if($consulta == true)
		{
			$data = array(
				"action"		=> "editar",
				"pro_id" 		=> $consulta->pro_id,

				"pro_name"	=> $consulta->pro_name,
				"pro_state"=> $consulta->pro_state,
				"pro_description"=> $consulta->pro_description,
				"pro_tipo_horario"=> $consulta->pro_tipo_horario,
				
				"cli_id"=> $consulta->cli_id,
				"coo_id"=> $consulta->coo_id,
				
				"proyectos" => $this->proyecto_modelo->getLista(1),
				"clientes" => $this->cliente_modelo->getLista(1),
				"coordinadores" => $this->usuario_modelo->getLista(1,'Coordinador'),
				"tareas" => $this->tarea_modelo->getLista(1),

				"trabajadores" => $this->proyecto_modelo->getListaTrabajadores($consulta->pro_id),
				
				"lista_trabajadores_proyecto" => $this->proyecto_modelo->getListaTrabajadoresDeProyecto($consulta->pro_id),
			);

			$this->layout->view("proyecto_form_view", $data);
		}
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("pro_eliminar")) redirect (base_url().'backend/');

		if($w == 'DEL')
			$this->proyecto_modelo->delete_fisica($id);
		else
			$this->proyecto_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/proyectos/index/1");
	}

	public function activar()
	{
		//si no tiene permisos es redirigido al escritorio
		//if(!verificarPermiso("pro_eliminar")) redirect (base_url().'backend/');

		$this->proyecto_modelo->activar($id);

		$this->message->set("info","<strong>Registros activados!</strong> Los registros fueron actividades satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/proyectos/index/1");
	}

	public function aniadir_trabajador(){
		$pro_id = $this->input->post('pro_id');
		$usu_id = $this->input->post('usu_id');
		$wor_ids = $this->input->post('wor_ids');

		if(!empty($usu_id)){
			$pro_tra_lastid = $this->proyecto_modelo->insertarTrabajadorEnProyecto($pro_id, $usu_id);
			
			$lista_trabajadores = $this->proyecto_modelo->getListaTrabajadoresDeProyecto($pro_id);
			$table = ""; $i = 1;
			if(count($lista_trabajadores)>0)
				foreach($lista_trabajadores as $item){
					$table .= "
						<tr>
							<td class='align-center'>".$i."</td>";
					$table .= "<td>".$item->usu_ap." ".$item->usu_am." ".$item->usu_nombre."</td>";
					$table .= "<td class=\"text-center\">
								<ul class=\"table-controls\">
									<li><a href=\"javascript:void(0)\" onclick=\"ajax_eliminar_trabajador_proyecto('".base_url()."backend/proyectos/eliminar_trabajador','".$item->pro_id."', '".$item->usu_id."', 'script', '".base_url()."backend/proyectos/')\" class=\"bs-tooltip confirm-dialog-delete\" title=\"Eliminar\"><i class=\"icon-remove\"></i></a></li>
								</ul>
							</td>
						</tr>";
					$i++;
				}
			else
				$table = '<tr><td align="center" colspan="4">No existe trabajadores!</td></tr>';

			echo $table;
		}
		
	}

	public function eliminar_trabajador(){
		$pro_id = $this->input->post('pro_id');
		$usu_id = $this->input->post('usu_id');

		$this->proyecto_modelo->eliminarTrabajador($pro_id, $usu_id);
		//$this->tarea_modelo->eliminarTareasDelTrabajador($pro_id, $usu_id);
		
		$lista_trabajadores = $this->proyecto_modelo->getListaTrabajadoresDeProyecto($pro_id);
		
		$table = ""; $i = 1;
		if(count($lista_trabajadores)>0)
			foreach($lista_trabajadores as $item){
				$table .= "
					<tr>
						<td class='align-center'>".$i."</td>
						<td>".$item->usu_ap." ".$item->usu_am." ".$item->usu_nombre."</td>
						<td class=\"text-center\">
							<ul class=\"table-controls\">
								<li><a href=\"javascript:void(0)\" onclick=\"ajax_eliminar_trabajador_proyecto('".base_url()."backend/proyectos/eliminar_trabajador', '".$item->pro_id."', '".$item->usu_id."', 'script', '".base_url()."backend/proyectos/')\" class=\"bs-tooltip confirm-dialog-delete\" title=\"Eliminar\"><i class=\"icon-remove\"></i></a></li>
							</ul>
						</td>
					</tr>";
				$i++;
			}
		else
			$table = '<tr><td align="center" colspan="3">No existe trabajadores!</td></tr>';

		echo $table;
	}

	public function cargar_trabajador_ajax()
	{
		$pro_id = $this->input->post("pro_id");
		$txt = "<option value=''></option>";
		$trabajadores = $this->proyecto_modelo->getListaTrabajadores($pro_id);
		foreach ($trabajadores as $item) {
			$txt .= "<option value='".$item->usu_id."'>".$item->usu_ap." ".$item->usu_am." ".$item->usu_nombre."</option>";
		}
		echo $txt;
	}
}
 ?>
