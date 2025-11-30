<?php
class Eventos extends CI_Controller
{
	//public $username;
	//public $eve_name;

	public $page_title;
	public $page_current_evento;

	public $current_evento_lista;
	public $current_evento_insertar;

	public function __construct()
	{
		parent::__construct();

		$this->layout->setLayout("backend/template_backend");

		$this->page_title = "Gestión de Eventos";

		/*
            Si no esta logueado lo redirigmos al formulario de login.
        */
        if(!@$this->session->userdata('username')) redirect (base_url().'backend/login');

        //si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("eve")) redirect (base_url().'backend/');

        $this->load->model("proyecto_modelo");
        $this->load->model("evento_modelo");
        $this->load->model("cliente_modelo");
        $this->load->model("usuario_modelo");
        $this->load->model("categoria_modelo");
        $this->load->model("tarea_modelo");
        $this->load->model("notificacion_modelo");

        $this->page_current_evento = "class='current'";
        $this->layout->setTitle($this->page_title);
	}

	public function index($sw='', $eve_tipo='Simple')
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("eve_lista")) redirect (base_url().'backend/');

		//page current
		if($eve_tipo == "Simple") $this->current_evento_lista_simple = "class='current'";
		if($eve_tipo == "Multiple") $this->current_evento_lista_multiple = "class='current'";

		$data = array(
					"lista"  	=> $this->evento_modelo->getLista($sw, $eve_tipo),
					"eve_tipo" 	=> $eve_tipo,
					
				);

		$this->layout->view("evento_list_view", $data);
	}

	public function miseventos()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("eve_mi_lista")) redirect (base_url().'backend/');

		$this->page_title = "Mis Eventos";

		//page current
		$this->current_evento_lista = "class='current'";
		$tra_id = $this->session->userdata("usu_id_actual");

		$data = array(
					"evetos_lista"  => $this->evento_modelo->getMiLista($tra_id),
				);

		$this->layout->view("evento_mylist_view", $data);
	}

	public function lista_tareas_trabajador($eve_id, $tra_id){
		$evento = $this->evento_modelo->getId($eve_id);
		$proyecto = $this->proyecto_modelo->getId($evento->pro_id);
		$cliente = $this->cliente_modelo->getId($evento->cli_id);
		$coordinador = $this->usuario_modelo->getId($evento->coo_id);
		$trabajador = $this->usuario_modelo->getId($tra_id);

		$data = array(
			
			"eve_id"		=> $eve_id,
			"eve_name"		=> $evento->eve_name,
			"eve_description"=> $evento->eve_description,
			"eve_date"		=> $evento->eve_date,
			"eve_tipo_horario" => $evento->eve_tipo_horario, 

			"pro_id"		=> $evento->pro_id,
			"proyecto" 		=> $proyecto->pro_name,
			"cliente" 		=> $cliente->cli_name,
			"coo_id" 		=> $coordinador->usu_id,
			"coordinador" 	=> $coordinador->usu_ap." ".$coordinador->usu_am." ".$coordinador->usu_nombre,
			"categorias" 	=> $this->categoria_modelo->getLista(1),

			'tra_id' 		=> $tra_id,
			'trabajador' 	=> $trabajador->usu_ap." ".$trabajador->usu_am." ".$trabajador->usu_nombre,

			'tareas_morning'=> $this->evento_modelo->getListaTareasByEveIdTraId($eve_id, $tra_id, 'morning'),
			'tareas_afternoon'=> $this->evento_modelo->getListaTareasByEveIdTraId($eve_id, $tra_id, 'afternoon'),
			'tareas_night'	=> $this->evento_modelo->getListaTareasByEveIdTraId($eve_id, $tra_id, 'night'),

			'tareas_continue'=> $this->evento_modelo->getListaTareasByEveIdTraId($eve_id, $tra_id, 'Continuo'),

			'_evento' 		=> $evento,
			'_proyecto' 	=> $proyecto,
			'_cliente' 		=> $cliente,
			'_coordinador' 	=> $coordinador,
			'_trabajador' 	=> $trabajador,
		);
		$this->layout->view("evento_form_tarea_view", $data);
	}

	public function insertar_tarea($eve_id_padre='0')
	{
		//si no tiene permisos es redirigido al escritorio
		//if(!verificarPermiso("eve_nuevo")) redirect (base_url().'backend/');
		
		$this->page_title = "Nuevo Evento";

		//page current
		$this->current_evento_insertar = "class='current'";

		if($this->input->post("submit"))
		{
			$id = $this->evento_modelo->insert();
			$this->message->set("success","<strong>Registro salvado!</strong> El registro fue insertado satisfactoriamente.", true);
			//$eve_id_padre = $this->evento_modelo->getId($id)->eve_id_padre;
			redirect(base_url()."backend/eventos/editar/".$id. "/". $eve_id_padre);
		}

		$eve_id_padre = $this->uri->segment(5)?$this->uri->segment(5):0;

		if($eve_id_padre != 0){
			$eve_padre = $this->evento_modelo->getId($eve_id_padre);
			
			$eve_description = $eve_padre->eve_description;
			$pro_id = $eve_padre->pro_id;
			$cli_id = $eve_padre->cli_id;
			$coo_id = $eve_padre->coo_id;
			$eve_date = $eve_padre->eve_date;
			$eve_tipo_horario = $eve_padre->eve_tipo_horario;
			$eve_imputacion = $eve_padre->eve_imputacion;
			
		}else{
			$eve_description = "";
			$pro_id = 0;
			$cli_id = 0;
			$coo_id = 0;
			$eve_date = "";
			$eve_tipo_horario = "";
			$eve_imputacion = "";
		}

		$data = array(
					"action"	=> "insertar_tarea/".$eve_id_padre,
					"eve_id"	=> "0",
					"eve_name"	=> '',
					"eve_state"	=> '1',
					"eve_description"	=> $eve_description,

					"pro_id"	=> $pro_id,
					"cli_id"	=> $cli_id,
					"coo_id"	=> $coo_id,

					"eve_date" 	=> $eve_date,

					"eve_tipo_horario" => $eve_tipo_horario,
					"eve_tipo" 		=> "Simple",
					"eve_imputacion"=> $eve_imputacion,
					"eve_id_padre" 	=> $eve_id_padre,

					"proyectos" 	=> $this->proyecto_modelo->getLista(1),
					"clientes" 		=> $this->cliente_modelo->getLista(1),
					"coordinadores" => $this->usuario_modelo->getLista(1,'Coordinador'),
					"trabajadores" 	=> array(),
					"categorias" 	=> $this->categoria_modelo->getLista(1),
					"tareas" 		=> array(),
					"lista_trabajadores_evento" => array(),
				);
		$this->layout->view("evento_form_view", $data);
	}

	public function editar($id='')
	{
		$this->page_title = "Editar Evento";

		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("eve_editar")) redirect (base_url().'backend/');

		$this->current_evento_insertar = "class='current'";

		//una vez hecho submit editar la base de datos
		if($this->input->post("submit"))
		{
			//antes de actualizar el evento debemos eliminar a los trabajadores guardados anteriormente con el PRO_ID y EVE_ID
			$eve_id = $this->input->post('eve_id');
			$evento = $this->evento_modelo->getId($eve_id);
			$pro_id = $evento->pro_id;
			if($this->input->post("pro_id") !== $pro_id)
				$this->evento_modelo->deleteEventWorkerByEveÍdProId($eve_id, $pro_id);

			$this->evento_modelo->edit();

			//proceso para cambiar las fechas a las siguientes tablas: wfc_event_task y wfc_event_task_worker
			$this->evento_modelo->cambiarFechaTareas($this->input->post('eve_date'), $eve_id);

			$this->message->set("success","<strong>Registro actualizado!</strong> El registro fue modificado satisfactoriamente.", true);
			redirect(base_url()."backend/eventos/editar/".$this->input->post("eve_id")."/".$evento->eve_id_padre);
		}
		//poblar el formulario si existe el usuario
		$consulta = $this->evento_modelo->getId($id);

		if($consulta == true)
		{
			$data = array(
				"action"		=> "editar",
				//"action_modal"	=> "aniadir_trabajador",

				"eve_id" 		=> $consulta->eve_id,

				"eve_name"		=> $consulta->eve_name,
				"eve_state"		=> $consulta->eve_state,
				"eve_description"=> $consulta->eve_description,
				
				"pro_id"		=> $consulta->pro_id,				
				"cli_id"		=> $consulta->cli_id,
				"coo_id"		=> $consulta->coo_id,

				"eve_date"		=> $consulta->eve_date,
				"eve_tipo_horario" => $consulta->eve_tipo_horario,
				"eve_tipo" 		=> $consulta->eve_tipo,
				"eve_imputacion"=> $consulta->eve_imputacion,
				"eve_id_padre"	=> $consulta->eve_id_padre,
				
				"proyectos" 	=> $this->proyecto_modelo->getLista(),
				"clientes" 		=> $this->cliente_modelo->getLista(1),
				"coordinadores" => $this->usuario_modelo->getLista(1,'Coordinador'),
				"categorias" 	=> $this->categoria_modelo->getLista(1),
				"tareas" 		=> array(),

				"trabajadores" => $this->evento_modelo->getListaTrabajadores($consulta->pro_id, $consulta->eve_id, 1),
				"lista_trabajadores_evento" => $this->evento_modelo->getListaTrabajadoresDeEvento($consulta->pro_id, $consulta->eve_id),
			);

			$this->layout->view("evento_form_view", $data);
		}
	}

	public function ver($eve_id)
	{
		$tra_id = $this->session->userdata("usu_id_actual");
		
		$evento = $this->evento_modelo->getId($eve_id);
		$proyecto = $this->proyecto_modelo->getId($evento->pro_id);
		$cliente = $this->cliente_modelo->getId($evento->cli_id);
		$coordinador = $this->usuario_modelo->getId($evento->coo_id);
		$trabajador = $this->usuario_modelo->getId($tra_id);

		$all_tareas = $this->categoria_modelo->getListaByEveIdTraId($eve_id, $tra_id);
		$all_tareas_array = array();
		foreach($all_tareas as $item)
		{
			$aux = explode(',', $item->eve_tar_ids);
			if(count($aux) > 1){
				foreach($aux as $x)
					$all_tareas_array[] = $x;
			}else
				$all_tareas_array[] = $item->eve_tar_ids;
		}

		$all_tareas = $this->tarea_modelo->getAllTareas(implode(',', $all_tareas_array));
		//print_r($all_tareas);exit;
		//print_r(array_unique($all_tareas_array)); exit;

		$data = array(
			
			"eve_id"		=> $eve_id,
			"eve_name"		=> $evento->eve_name,
			"eve_description"=> $evento->eve_description,
			"eve_date"		=> $evento->eve_date,
			"eve_tipo_horario" => $evento->eve_tipo_horario, 

			"pro_id"		=> $evento->pro_id,
			"proyecto" 		=> $proyecto->pro_name,
			"cliente" 		=> $cliente->cli_name,
			"coordinador" 	=> $coordinador->usu_ap." ".$coordinador->usu_am." ".$coordinador->usu_nombre,

			'tra_id' 		=> $tra_id,
			'trabajador' 	=> $trabajador->usu_ap." ".$trabajador->usu_am." ".$trabajador->usu_nombre,

			'tareas_morning'=> $this->evento_modelo->getListaTareasByEveIdTraId($eve_id, $tra_id, 'morning'),
			'tareas_afternoon'=> $this->evento_modelo->getListaTareasByEveIdTraId($eve_id, $tra_id, 'afternoon'),
			'tareas_night'	=> $this->evento_modelo->getListaTareasByEveIdTraId($eve_id, $tra_id, 'night'),

			'tareas_continue'=> $this->evento_modelo->getListaTareasByEveIdTraId($eve_id, $tra_id, 'Continuo'),

			//PARA REGISTRAR
			"all_tareas" 	 => $all_tareas,
			'tareas_registradas_morning'=> $this->evento_modelo->getListaTareasRegistradasByEveIdTraId($eve_id, $tra_id, 'morning'),
			'tareas_registradas_afternoon'=> $this->evento_modelo->getListaTareasRegistradasByEveIdTraId($eve_id, $tra_id, 'afternoon'),
			'tareas_registradas_night'	=> $this->evento_modelo->getListaTareasRegistradasByEveIdTraId($eve_id, $tra_id, 'night'),

			'tareas_registradas_continue'	=> $this->evento_modelo->getListaTareasRegistradasByEveIdTraId($eve_id, $tra_id, 'Continuo'),
		);

		$this->layout->view("evento_formver_view", $data);
	}

	public function eliminar($w = '', $id = null)
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("eve_eliminar")) redirect (base_url().'backend/');

		if(!empty($this->input->post('eve_tipo')))
			$eve_tipo = $this->input->post('eve_tipo');
		else
			$eve_tipo = $this->evento_modelo->getId($id)->eve_tipo;

		if($w == 'DEL' && $eve_tipo == "Simple")
			$this->evento_modelo->delete_fisica($id);
		elseif($w == 'DEL' && $eve_tipo == "Multiple")
			$this->evento_modelo->delete_fisica_multiple($id);
		else
			$this->evento_modelo->delete($id);

		$this->message->set("info","<strong>Registro removido!</strong> El registro fue eliminado satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/eventos/index/1/".$eve_tipo);
	}
	// activar eventos
	public function activar()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("eve_eliminar")) redirect (base_url().'backend/');

		$this->evento_modelo->activar();

		$this->message->set("info","<strong>Eventos activados!</strong> Los eventos fueron activados satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/eventos/index/1/".$this->input->post('eve_tipo'));
	}
	//cerrar eventos
	public function cerrar()
	{
		//si no tiene permisos es redirigido al escritorio
		if(!verificarPermiso("eve_eliminar")) redirect (base_url().'backend/');

		$this->evento_modelo->cerrar();

		$this->message->set("info","<strong>Eventos cerrados!</strong> Los eventos fueron cerrados satisfactoriamente.", true);
		$resultado = redirect(base_url()."backend/eventos/index/1/".$this->input->post('eve_tipo'));
	}
	/*
	public function aniadir_trabajador(){
		$eve_tipo_horario = $this->input->post("eve_tipo_horario");

		if($this->input->post('action_modal') == "editar"){
			$this->evento_modelo->eliminarTodosTrabajadoresEventoByEveIdTraId($eve_id, $tra_id);
		}

		if($eve_tipo_horario == "Partido"){
				$this->evento_modelo->insertarTrabajadorEnEvento(
					$this->input->post("eve_tar_type"),
					$this->input->post('eve_tar_cat'),
					$this->input->post('eve_tar_task'),
					$this->input->post('eve_tar_from'),
					$this->input->post('eve_tar_to')
				);
		}
		if($eve_tipo_horario == "Continuo"){
			//guardamos horario
			$this->evento_modelo->insertarTrabajadorEnEvento(
				'Continuo',
				$this->input->post('eve_tar_cat'),
				$this->input->post('eve_tar_task'),
				$this->input->post('eve_tar_from'),
				$this->input->post('eve_tar_to')
			);
		}
		
		redirect(base_url()."backend/eventos/lista_tareas_trabajador/" . $this->input->post('eve_id')."/".$this->input->post('tra_id'));
	}*/

	public function eliminar_trabajador($eve_id, $tra_id)
	{
		$this->evento_modelo->eliminarTrabajador($eve_id, $tra_id);
		
		redirect(base_url()."backend/eventos/editar/" . $eve_id . "#trabajadores");
	}

	public function cargar_cliente_name_ajax() // yess
	{
		$pro_id = $this->input->post("pro_id");
		if($pro_id != '' or $pro_id != null){
			$proyecto = $this->proyecto_modelo->getId($pro_id);
			$cli_id = $proyecto->cli_id;
			$cliente = $this->cliente_modelo->getId($cli_id);
			?>
			<a href="<?php echo base_url() ?>backend/clientes/editar/<?php echo $cli_id ?>" target="_blank" class="control-label not-bold">
				<?php echo $cli_id?$cliente->cli_name:""; ?><i class='ml10 fa fa-external-link'></i>
			</a><?php
		}else
			echo "";
	}
	public function cargar_cliente_id_ajax() // yess
	{
		$pro_id = $this->input->post("pro_id");
		if($pro_id != '' or $pro_id != null){
			$proyecto = $this->proyecto_modelo->getId($pro_id);
			$cli_id = $proyecto->cli_id;
			echo $cli_id;
		}else
			echo "";
	}

	public function cargar_coordinador_name_ajax() // yess
	{
		$pro_id = $this->input->post("pro_id");
		if($pro_id != '' or $pro_id != null){
			$proyecto = $this->proyecto_modelo->getId($pro_id);
			$coo_id = $proyecto->coo_id;
			$coordinador = $this->usuario_modelo->getId($coo_id);
			?>
			<a href="<?php echo base_url() ?>backend/usuario/editar/<?php echo $coo_id ?>/Coordinador" target="_blank" class="control-label not-bold">
				<?php echo $coo_id?$coordinador->usu_ap." ".$coordinador->usu_am." ".$coordinador->usu_nombre:""; ?><i class='ml10 fa fa-external-link'></i>
			</a>
			<?php
		}else
			echo "";
	}
	public function cargar_coordinador_id_ajax() // yess
	{
		$pro_id = $this->input->post("pro_id");
		if($pro_id != '' or $pro_id != null){
			$proyecto = $this->proyecto_modelo->getId($pro_id);
			$coo_id = $proyecto->coo_id;
			echo $coo_id;
		}else	
			echo "";
	}

	public function cargar_tipo_horario_ajax() // yess
	{
		$pro_id = $this->input->post("pro_id");
		if($pro_id != '' or $pro_id != null){
			$proyecto = $this->proyecto_modelo->getId($pro_id);
			if($proyecto->pro_tipo_horario == "Partido"){
				?>
				<script>
					jQuery('#horario-partido').show();
					jQuery('#horario-continuo').hide();
					jQuery('.input-tipo-horario').val('<?php echo $proyecto->pro_tipo_horario ?>');
				</script>
				<?php
			}elseif($proyecto->pro_tipo_horario == "Continuo"){
				?>
				<script>
					jQuery('#horario-partido').hide();
					jQuery('#horario-continuo').show();
					jQuery('.input-tipo-horario').val('<?php echo $proyecto->pro_tipo_horario ?>');
				</script>
				<?php
			}
		}else	
			echo "";
	}

	public function clonar_evento()//new
	{
		$eve_id_original = $this->input->post('eve_id');
		$eve_tipo = $this->input->post('eve_tipo');
		$eve_id_padre = $this->input->post('eve_id_padre')!= 0?$this->input->post('eve_id_padre'):'';

		if($eve_tipo == "Simple")
		{
			$eve_original = $this->evento_modelo->getId($eve_id_original);

			$lista_trabajadores_evento_original = $this->evento_modelo->getListaTrabajadoresDeEventoByEveId($eve_id_original);
			
			$begin = new DateTime( $this->input->post('date_start') );
			$end = new DateTime( $this->input->post('date_end') );
			$end = $end->modify( '+1 day' );
			
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);
			
			foreach($daterange as $date)
			{
				//clonamos el evento para una fecha y obtenemos su ID
				$eve_id_last = $this->evento_modelo->clonar_event($eve_original, $date->format("Y-m-d"));

				//asignamos los trabajadores para el evento clonado
				foreach($lista_trabajadores_evento_original as $trabajador)
					$this->evento_modelo->clonar_event_task($trabajador, $eve_id_last, $date->format("Y-m-d"));
			}
		}elseif($eve_tipo == "Multiple")
		{
			//$date_new = $this->input->post('fecha');
			$date_new = $this->input->post('eve_date');
			
			$eve_original_padre = $this->evento_modelo->getId($eve_id_original);

			//obtenemos lista de sub eventos del evento padre original
			$lista_subeventos_del_evento_original = $this->evento_modelo->getListaSubEventos($eve_id_original);

			//creamos un nuevo evento padre copiando los datos
			$eve_id_padre_last = $this->evento_modelo->clonar_event($eve_original_padre, $date_new);

			//clonar los subeventos añadiendo el nuevo ID del evento padre recien creado ($eve_id_padre_last)
			//recorrer la lista de subeventos	
			foreach($lista_subeventos_del_evento_original as $evento)
			{
				//clonamos el evento para una fecha y obtenemos su ID
				$eve_id_last = $this->evento_modelo->clonar_event($evento, $date_new, $eve_id_padre_last);

				$lista_trabajadores_evento_original = $this->evento_modelo->getListaTrabajadoresDeEventoByEveId($evento->eve_id);

				//asignamos los trabajadores para el evento clonado
				foreach($lista_trabajadores_evento_original as $trabajador)
					$this->evento_modelo->clonar_event_task($trabajador, $eve_id_last, $date_new);
			}

		}
		$this->message->set("info","Los eventos fueron clonados satisfactoriamente.", true);
		redirect(base_url()."backend/eventos/index/1/".$eve_tipo."/".$eve_id_padre);
	}
	/**
	 * Añadir-Editar tarea por un trabajador
	 */
	public function aniadir_editar_tarea_trabajador(){//new
		$this->tarea_modelo->insertarEditarTareaTrabajadorEnEvento();
		redirect(base_url()."backend/eventos/lista_tareas_trabajador/" . $this->input->post('eve_id')."/".$this->input->post('tra_id'));
	}

	public function ajax_editar_tarea()//new
	{
		$eve_tar_id = $this->input->post("eve_tar_id");
		$evento_tarea = $this->tarea_modelo->getEventoTarea($eve_tar_id);

		$eve_id = $evento_tarea->eve_id;
		$tra_id = $evento_tarea->tra_id;
		$eve_tar_type = $evento_tarea->eve_tar_type;//morning, afternoon o night, incluso Continuo

		//tareas seleccionadas
		$tareas_selected = explode(',', $evento_tarea->eve_tar_ids);
		
		//cargar tareas para su categoría y seleccionarlas
		$tarea_options = "<option value=''></option>";
		
		$tareas = $this->categoria_modelo->getListaTareas($evento_tarea->cat_id);
		foreach ($tareas as $item) {
			$obj = in_array($item->tar_id, $tareas_selected);
			$selected = $obj?"selected":"";	
			$tarea_options .= "<option ".$selected." value='".$item->tar_id."'>".$item->tar_name."</option>";
		}

		//calculo de horas entre 2 fechas
		$resultado = calcularHorasYMinutos($evento_tarea->eve_tar_horario_from, $evento_tarea->eve_tar_horario_to);
		$horas = $resultado['horas'] . " hora(s), " . $resultado['minutos']." minuto(s)";
		?>
		<script>
			jQuery('#eve_tar_id').val('<?php echo $eve_tar_id; ?>');
			//seleccionar la categoría
			jQuery("#eve_tar_cat").select2("val", "<?php echo $evento_tarea->cat_id ?>");
			
			jQuery('#eve_tar_type').val('<?php echo $evento_tarea->eve_tar_type ?>');
			//seleccionar las tareas
			//var selectedValues = ['24'];
			jQuery('#eve_tar_task').html('').append("<?php echo $tarea_options ?>").trigger('change');
			//llenar info en horarios
			jQuery('#eve_tar_horario_from').val('<?php echo date('H:i', strtotime($evento_tarea->eve_tar_horario_from)); ?>'); 
			jQuery('#eve_tar_horario_to').val('<?php echo date('H:i', strtotime($evento_tarea->eve_tar_horario_to)); ?>');
			jQuery('#eve_tar_nota').val('<?php echo $evento_tarea->eve_tar_nota; ?>');
			jQuery('#wrap_calculo_horas').html('<?php echo $horas ?>');
			
		</script>
		<?php
	}
	/**
	 * Añadir-Editar tarea registrada por un trabajador
	 */
	public function aniadir_editar_tarea_registrada_trabajador()//new
	{
		
		$res = $this->evento_modelo->verificar_hora_solapada();
		
		if($res){
			$eve_tar_horario_from = $this->input->post("eve_tar_horario_from");
			$eve_tar_horario_to   = $this->input->post("eve_tar_horario_to");
			$this->message->set("danger","<strong>Error en el rango de horas!</strong> La hora ".$eve_tar_horario_from." o ".$eve_tar_horario_to." ya esta registrado en otro rango de horas, intente nuevamente.", true);
			redirect(base_url()."backend/eventos/ver/" . $this->input->post('eve_id') . "#table-" . $this->input->post("eve_tar_type"));
		}
		$this->message->set("success","<strong>Registro salvado!</strong> La información fue registrada satisfactoriamente.", true);
		$last_eve_tar_id = $this->tarea_modelo->insertarEditarTareaRegistradaDeTrabajadorEnEvento();
		
		//aqui suponenmos que el campo eve_validar es 2 (error de horas)
		//si es 2 entonces el trabajador leyo la notificación y procede a arreglar las horas
		$eve_id = $this->input->post("eve_id");
		$tra_id = $this->input->post("tra_id");

		if($last_eve_tar_id)
			$eve_tar_id = $last_eve_tar_id;
		else
			$eve_tar_id = $this->input->post("eve_tar_id");

		$evento = $this->evento_modelo->getId($eve_id);

		if($this->input->post('eve_validar') == 2){
			// cambiar la validadión de 2 a 0
			$this->tarea_modelo->validarTarea($this->input->post('eve_tar_id'), 0);
			//Notificación de sistema: Avisar que se modifico la tarea
			$not_message = "El trabajador modificó las horas";
			$not_type = '0';//informativo

			$this->notificacion_modelo->crear_notificacion_trabajador($not_message, $not_type, $eve_id, $eve_tar_id, $tra_id, $evento->coo_id);
		}else{
			//enviar notificación
			$not_message = "El trabajador registro tarea.";
			$not_type = '0';//informativo
			$this->notificacion_modelo->crear_notificacion_trabajador($not_message, $not_type, $eve_id, $eve_tar_id, $tra_id, $evento->coo_id);
		}

		redirect(base_url()."backend/eventos/ver/" . $this->input->post('eve_id') . "#table-" . $this->input->post("eve_tar_type"));
	}

	public function ajax_editar_tarea_registrada()//new
	{
		$eve_tar_id = $this->input->post("eve_tar_id");
		$tarea_registrada = $this->tarea_modelo->getEventoTareaRegistrada($eve_tar_id);

		$evento = $this->evento_modelo->getId($tarea_registrada->eve_id);

		//calculo de horas entre 2 fechas
		$resultado = calcularHorasYMinutos($tarea_registrada->eve_tar_horario_from, $tarea_registrada->eve_tar_horario_to);
		$horas = $resultado['horas'] . " hora(s), " . $resultado['minutos']." minuto(s)";

		?>
		<script type="text/javascript">
			jQuery('#eve_tar_id').val('<?php echo $eve_tar_id ?>');

			jQuery('#eve_tar_ids').select2('val', <?php echo $tarea_registrada->eve_tar_ids ?>);
			jQuery('#eve_tar_horario_from').val('<?php echo date("H:i", strtotime($tarea_registrada->eve_tar_horario_from)) ?>');
			jQuery('#eve_tar_horario_to').val('<?php echo date("H:i", strtotime($tarea_registrada->eve_tar_horario_to)) ?>');
			jQuery('#eve_tar_nota').html('<?php echo $tarea_registrada->eve_tar_nota ?>');

			jQuery('#pro_id').val('<?php echo $tarea_registrada->pro_id ?>');
			jQuery('#eve_id').val('<?php echo $tarea_registrada->eve_id ?>');
			jQuery('#eve_date').val('<?php echo $evento->eve_date ?>');

			jQuery('#eve_tar_type').val('<?php echo $tarea_registrada->eve_tar_type ?>');
			jQuery('#eve_validar').val('<?php echo $tarea_registrada->eve_validar ?>');
			jQuery('#tra_id').val('<?php echo $tarea_registrada->tra_id ?>');
			jQuery('#eve_tipo_horario').val('<?php echo $evento->eve_tipo_horario ?>');
			jQuery('#wrap_calculo_horas').html('<?php echo $horas ?>');
		</script>
		<?php
	}

	public function eliminar_tarea_trabajador($eve_tar_id, $eve_id, $tra_id)//new
	{
		$this->evento_modelo->eliminarTareaTrabajador($eve_tar_id);
		redirect(base_url()."backend/eventos/lista_tareas_trabajador/" . $eve_id . "/" . $tra_id);
	}

	public function eliminar_tarea_registrada_trabajador($eve_tar_id, $eve_id, $tra_id)//new
	{
		// Eliminamos notificaciones que tenga que ver con el eve_tar_id
		$this->notificacion_modelo->delete_fisica($eve_tar_id, "eve_tar_id");

		// Eliminamos la tarea
		$this->tarea_modelo->eliminarEventoTareaTrabajador($eve_tar_id);
		redirect(base_url()."backend/eventos/ver/" . $eve_id . "/" . $tra_id);
	}

	/**
	 * Crear notificación  para trabajador
	 */
	public function crear_notificacion_trabajador(){
		$not_message = $this->input->post("not_message");
		$not_type = $this->input->post("not_type");

		$eve_id = $this->input->post("eve_id");
		$eve_tar_id = $this->input->post("eve_tar_id");
		$tra_id = $this->input->post("tra_id");

		$evento = $this->evento_modelo->getId($eve_id);

		$resp = $this->notificacion_modelo->crear_notificacion_trabajador($not_message, $not_type, $eve_id, $eve_tar_id, $tra_id, $evento->coo_id);
		if(!$resp): 
			echo '<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Error!</h4>
					El mensaje no se envío, intente nuevamente.
				</div>';
		else:
			//cambiar el campo eve_validar a valor "2" que significa la tarea fue invalidada
			if($this->input->post('not_type') == 2){
				
				?>
				<script>
					$('#ck-validar-<?php echo $this->input->post('eve_tar_id') ?>').prop('disabled', 'disabled');
					$('#ck-validar-<?php echo $this->input->post('eve_tar_id') ?>').parent('.toggle').find('.toggle-off').html('Invalidada');
					$('#ck-validar-<?php echo $this->input->post('eve_tar_id') ?>').parent('.toggle').addClass('off')
				</script>
				<?php
				$this->tarea_modelo->validarTarea($this->input->post('eve_tar_id'), 2);
			}
		?>
		<script>
			$('#notaParaTrabajadorModal-<?php echo $this->input->post('eve_tar_id') ?>').modal('hide');
			toastr.success('El mensaje fue enviado al trabajador!');

			
		</script>
		<?php endif; ?>
		<?php
	}
}
