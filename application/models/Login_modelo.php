<?php
class Login_modelo extends CI_Model
{
      public function __construct()
     {
        parent::__construct();
    }

    public function very($variable,$campo)
    {
        $consulta = $this->db->get_where(
                                    'usuarios',
                                    array(
                                            $campo   => $variable,
                                            "usu_estado" => "1"
                                          )
                                );
        if($consulta->num_rows() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function forgot_password()
    {
        //buscar al email
        $consulta = $this->db->get_where(
            'usuario',
            array("usu_email" => $this->input->post("email"))
        );
        //si lo encuentra cambiar el password
        if($consulta->num_rows() == 1)
        {
            $usuario = $consulta->row_array();
            //generar password
            $password = randomPassword();
            //cambiar el password para ese email
            $data = array(
                'usu_password'  => md5($password)
            );
            $this->db->where("usu_email", $this->input->post("email"));
            $this->db->update("usuario", $data);

            //enviar un email con el código al usuario
            $this->load->library('Myemail'); //include controller
            $this->myemail->send_mail_change_password($usuario['usu_id'], $password);

            return true;
        }//si no retornar false;
        else
        {
            return false;
        }
    }

    public function very_sesion()
    {
        $consulta =$this->db->get_where('usuario',
                                        array(
                                            'usu_username'  => $this->input->post('usu_username',TRUE),
                                            'usu_password'  => md5($this->input->post('usu_password',TRUE))
                                        )
                                    );

        if($consulta->num_rows() == 1)
        {
            return $consulta->row_array();
        }
        else
        {
            return false;
        }
    }

    public function very_code()
    {
        /*
        $consulta =$this->db->get_where('usuario',
                                        array(
                                            'usu_code_login'  => $this->input->post('usu_code_login',TRUE)
                                        )
                                    );

        if($consulta->num_rows() == 1)
        {
            return $consulta->row_array();
        }
        else
        {
            return false;
        }*/
        
        $consulta =$this->db->get_where('usuario',
                                        array(
                                            'usu_username'  => $this->input->post('usu_username',TRUE),
                                            'usu_password'  => md5($this->input->post('usu_password',TRUE))
                                        )
                                    );

        if($consulta->num_rows() == 1)
        {
            return $consulta->row_array();
        }
        else
        {
            return false;
        }
    }

}
