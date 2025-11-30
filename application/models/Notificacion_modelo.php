<?php
class Notificacion_modelo extends CI_Model
{
    
	public function __construct()
	{
		parent::__construct();
	}

	public function lista_notificaciones($when = '')
	{
		if($when == "hoy") $where_when = "DATE(created_at) = CURRENT_DATE()";
		elseif($when == "ayer") $where_when = "DATE(created_at) = DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)";
		elseif($when == "ni_hoy_ayer") $where_when = "DATE(created_at) NOT IN (CURRENT_DATE(), DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY))";
		else $where_when = 1;

		//mostrar notificaciones solo del trabajador si esta logueado
		if($this->session->userdata("usu_tipo_actual") == "Trabajador")
			$where_only_trabajador = "no.tra_id = '".$this->session->userdata("usu_id_actual")."'";
		else
			$where_only_trabajador = 1;

		//mostrar notificaciones solo del coordinador si esta logueado
		if($this->session->userdata("usu_tipo_actual") == "Coordinador")
			$where_only_coordinador = "e.coo_id = '".$this->session->userdata("usu_id_actual")."'";
		else
			$where_only_coordinador = 1;

		$query = $this->db->query("	SELECT * 
									FROM wfc_notification no
									INNER JOIN usuario u ON u.usu_id = no.tra_id
									INNER JOIN wfc_events e ON e.eve_id = no.eve_id
									WHERE $where_when and $where_only_trabajador and $where_only_coordinador and not_state=0
									ORDER BY created_at DESC
									/*LIMIT 50*/
								");

		$result = $query->result();

		/*foreach($result as $not){
			$coo_id = $not->coo_id;
			$not_id = $not->not_id;
			$this->db->query("UPDATE wfc_notification SET coo_id='$coo_id' WHERE not_id='$not_id'");
		}*/
		return $result;
	}

	public function lista_notificaciones_menu($limit = '')
	{
		//mostrar notificaciones solo del trabajador si esta logueado
		if($this->session->userdata("usu_tipo_actual") == "Trabajador")
			$where_only_trabajador = "no.tra_id = '".$this->session->userdata("usu_id_actual")."'";
		else
			$where_only_trabajador = 1;

		//mostrar notificaciones solo del coordinador si esta logueado
		if($this->session->userdata("usu_tipo_actual") == "Coordinador")
			$where_only_coordinador = "e.coo_id = '".$this->session->userdata("usu_id_actual")."'";
		else
			$where_only_coordinador = 1;

		if($limit == '')
			$limitsql = "";
		else
			$limitsql = "LIMIT $limit";

		$query = $this->db->query("	SELECT * 
									FROM wfc_notification no
									INNER JOIN usuario u ON u.usu_id = no.tra_id
									INNER JOIN wfc_events e ON e.eve_id = no.eve_id
									WHERE $where_only_trabajador and $where_only_coordinador and no.not_state=0
									ORDER BY created_at DESC
									$limitsql
								");
		return $query->result();
	}

	public function getId($id)
	{
		$query = $this->db->get_where("wfc_notification", array("prov_id"=>$id));

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	public function getNotificacionesByEveTarId($eve_tar_id)
	{
        $query = $this->db->query("	SELECT * 
									FROM wfc_notification
                                    WHERE eve_tar_id='$eve_tar_id'
									ORDER BY created_at DESC");
		return $query->result();
    }
    
    public function crear_notificacion_trabajador($not_message, $not_type, $eve_id, $eve_tar_id, $tra_id, $coo_id)
	{
        $not_state = 0;

        $created_at = $updated_at = date('Y-m-d H:i:s');

        $data = array(
            "not_id" 		=> null,
            "not_message"	=> $not_message,
            "not_type"	    => $not_type,
			"not_state"	    => $not_state,
            "eve_id"	    => $eve_id,
            "eve_tar_id"	=> $eve_tar_id,
			"coo_id"		=> $coo_id,
            "tra_id"	    => $tra_id,
            "origen_id"		=> $this->session->userdata("usu_id_actual"),

            "created_at"	=> $created_at,
            "updated_at"	=> $updated_at,
        );
        $this->db->insert("wfc_notification", $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

	public function actualizar_estado($not_id)
	{
		$data = array(
				"not_state"	=> 1,
			);

		$this->db->where("not_id", $not_id);
		$this->db->update("wfc_notification", $data);

	}
	
    public function delete_fisica($id, $delete_by = '')
	{
		if(!empty($delete_by))
			$where_delete_by = $delete_by . "= '".$id."'";
		else
			$where_delete_by = "1";
		if(empty($id)){
			$lista = implode(',',$this->input->post("seleccion"));
			return $this->db->query("DELETE FROM wfc_notification WHERE not_id IN(".$lista.")");
		}else{
			if(empty($delete_by))
				return $this->db->query("DELETE FROM wfc_notification WHERE not_id='$id'");
			else
				return $this->db->query("DELETE FROM wfc_notification WHERE $where_delete_by");
		}
	}
    
}
 ?>
