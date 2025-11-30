<?php
class Reporte_modelo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * obtener en un array toda la lista de materias
	 */
	public function getReporteTareas()
	{
		$usu_tipo_actual = $this->session->userdata("usu_tipo_actual");
		$usu_id_actual = $this->session->userdata("usu_id_actual");
		

		if($usu_tipo_actual == "Coordinador")
			$where_coo = "e.coo_id = '".$usu_id_actual."'";
		else 
			$where_coo = "1";

		if($usu_tipo_actual == "Trabajador")
			$where_tra = "ew.tra_id = '".$usu_id_actual."'";
		else
			$where_tra = '1';

		// DATE RANGE
		$date_range = $this->input->get('date_range');
		if($date_range){
			$date_explode = explode(" - ", $date_range);
			$date_start = $date_explode[0];
			$date_end = $date_explode[1];
			//exit;

			$where_date_range = "e.eve_date BETWEEN '".$date_start."' AND '".$date_end."'";
		}else{
			//$date_start_init = date("Y-m-d", strtotime('-6 days'));
			//$date_end_init = date("Y-m-d");
			$where_date_range = "1";
		}

		// TRABAJADOR
		$tra_id = $this->input->get('tra_id');
		if($tra_id){
			$where_tra_id = "ew.tra_id = '".$tra_id."'";
		}else{
			$where_tra_id = "1";
		}

		// CLIENTE
		$cli_id = $this->input->get('cli_id');
		if($cli_id){
			$where_cli_id = "pro.cli_id = '".$cli_id."'";
		}else{
			$where_cli_id = "1";
		}

		// CENTRO
		$cen_id = $this->input->get('cen_id');
		if($cen_id){
			$where_cen_id = "cc.cen_id = '".$cen_id."'";
		}else{
			$where_cen_id = "1";
		}

		// PROYECTO
		$pro_id = $this->input->get('pro_id');
		if($pro_id){
			$where_pro_id = "pro.pro_id = '".$pro_id."'";
		}else{
			$where_pro_id = "1";
		}
		
		// EVENTO
		$eve_id = $this->input->get('eve_id');
		if($eve_id){
			$where_eve_id = "e.eve_id = '".$eve_id."'";
		}else{
			$where_eve_id = "1";
		}

		// EVENTO ESTADO
		$eve_state = $this->input->get('eve_state');
		if($eve_state == 0 or $eve_state == 1 or $eve_state == 2){
			$where_eve_state = "e.eve_state = '".$eve_state."'";
		}else{
			$where_eve_state = 1;
		}

		// EVENTO - IMPUTACION
		$eve_imputacion = $this->input->get('eve_imputacion');
		if($eve_imputacion){
			$where_eve_imputacion = "e.eve_imputacion = '".$eve_imputacion."'";
		}else{
			$where_eve_imputacion = "1";
		}

		// TAREA
		$tar_id = $this->input->get('tar_id');
		if($tar_id){
			$where_tar_id = "ew.eve_tar_ids = '".$tar_id."'";
		}else{
			$where_tar_id = "1";
		}

		$query = $this->db->query("	SELECT * 
									FROM wfc_event_task_worker ew
                                    INNER JOIN wfc_events e ON e.eve_id = ew.eve_id
                                    INNER JOIN usuario u ON u.usu_id = ew.tra_id
                                    INNER JOIN wfc_projects pro ON pro.pro_id = ew.pro_id
                                    INNER JOIN wfc_client cli ON cli.cli_id = pro.cli_id 

                                    INNER JOIN wfc_client_center cc ON cc.cli_id = pro.cli_id
                                    INNER JOIN wfc_centers cen ON cen.cen_id = cc.cen_id

									WHERE ew.eve_validar='1'
									      /*AND e.eve_state = 1
									      AND u.usu_estado = 1
									      AND pro.pro_state = 1
									      AND cli.cli_state = 1
									      AND cen.cen_state = 1*/

										  AND $where_coo
										  AND $where_tra
										  AND $where_date_range
										  AND $where_tra_id
										  AND $where_cli_id
										  AND $where_cen_id
										  AND $where_pro_id
										  AND $where_eve_id
										  AND $where_eve_state
										  AND $where_eve_imputacion
										  AND $where_tar_id

									GROUP BY ew.eve_tar_id
                                    ORDER BY e.eve_date DESC
                                ");
		return $query->result();
	}
	/*
	public function getReporteTareasss($sw = '')
	{
		$query = $this->db->query("	SELECT * from wfc_event_worker ew
                                    INNER JOIN wfc_events e ON e.eve_id = ew.eve_id
                                    //INNER JOIN usuario u ON u.usu_id = ew.tra_id
                                    INNER JOIN wfc_projects pro ON pro.pro_id = ew.pro_id
                                    INNER JOIN wfc_categorias cat ON cat.cat_id = ew.cat_id 

                                    INNER JOIN wfc_client_center cc ON cc.cli_id = pro.cli_id
                                    INNER JOIN wfc_centers cen ON cen.cen_id = cc.cen_id
									where ew.eve_tra_checked_horario='checked'
									GROUP BY ew.eve_tar_id
                                    order by e.eve_date DESC
                                ");
		return $query->result();
	}*/
}
 ?>
