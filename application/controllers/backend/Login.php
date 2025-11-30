<?php

class Login extends CI_Controller
{
    private $_nombre_empresa = "SISTEMA <br>\"A.I.S.I.L.A.N.\"";
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('login_modelo');
        $this->load->model('usuario_modelo');

        $this->load->model('institucion_modelo');

        $this->layout->setLayout("backend/template_login");

    }

    public function index()
    {
        $data = array(
                    "nombre_empresa" => $this->institucion_modelo->getNombre($this->institucion_modelo->getIdEstadoActivo()),
                    "logo" => $this->institucion_modelo->getLogo($this->institucion_modelo->getIdEstadoActivo())
                    //"nombre_empresa" => $this->_nombre_empresa
                );
        $this->layout->view('login', $data);
    }

    public function registro()
    {
        $this->layout->view('registro_view');
    }

    function very_user($user)
    {
        $variable = $this->login_modelo->very($user,'usuario');
        if($variable == true)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    function very_correo($correo)
    {
        $variable = $this->login_modelo->very($correo,'correo');
        if($variable == true)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function very_sesion()
    {
        if($this->input->post('submit'))
        {
            $variable = $this->login_modelo->very_sesion();
            if($variable == true and $variable["usu_estado"] == '1')
            {
                //generar code
                //$code = randomPassword();
                $code = "8A76G";
                //enviar un email con el código al usuario
                //$this->load->library('Myemail'); //include controller
                //$send_email = $this->myemail->send_mail_code($variable['usu_id'], $code);
                //$send_email = $this->myemail->send_mail_code($variable['usu_id'], $code);
                $send_email="yes";
                //guardar el code en el campo usu_code_login de la tabla usuario
                $this->usuario_modelo->setCode($variable['usu_id'], $code);
                //redirect(base_url().'backend/login/verification/1');
                //redirect(base_url().'backend/login/verification/'.$send_email);
                $usuario = $this->login_modelo->very_code();
                
                
                //dejar en blanco el campo usu_code_login
                $this->usuario_modelo->setEmptyCode($usuario['usu_id']);
                
                //crear variables para session
                $variables = array(
                    'username'  => $usuario['usu_username'],
                    'usu_nombre'=> $usuario['usu_nombre'],
                    'usu_ap'=> $usuario['usu_ap'],
                    'usu_am'=> $usuario['usu_am'],
                    'usu_id_actual' => $usuario['usu_id'],
                    'usu_tipo_actual' => $usuario['usu_tipo'],
                    //'gestion_actual' => $this->gestion_modelo->getGestionActual(),
                    'ue_id_actual' => $this->institucion_modelo->getIdEstadoActivo()
                );

                $this->session->set_userdata($variables);
                $this->usuario_modelo->setOnline($usuario['usu_id'], 1);
                redirect(base_url().'backend');
                
            }elseif($variable == true and $variable["usu_estado"] == '0'){
                $data = array(  'mensaje' => 'El usuario <b>'.$variable["usu_username"].'</b> no tiene permisos para ingresar al sistema',
                                 "nombre_empresa" => $this->_nombre_empresa,
                                 "logo" => $this->institucion_modelo->getLogo($this->institucion_modelo->getIdEstadoActivo())
                    );
                $this->layout->view('login',$data);
            }elseif($variable == false){
                $data = array(  'mensaje' => 'El username o password son incorrectos',
                                 "nombre_empresa" => $this->_nombre_empresa,
                                 "logo" => $this->institucion_modelo->getLogo($this->institucion_modelo->getIdEstadoActivo())
                    );
                $this->layout->view('login',$data);
            }
        }
        else
        {
            redirect(base_url().'backend/login');
        }
    }

    public function verification($send_email)
    {
        $send_email = "yes";
        if($send_email == "yes")
            $message = 'Coloque el codigo brindado por el Sistema.';
        else
            $message = "Ocurrió un error en el envío del email, intente nuevamente.";

        $data = array(
            'mensaje' => $message,
            "logo" => $this->institucion_modelo->getLogo($this->institucion_modelo->getIdEstadoActivo())
        );
    	$this->layout->view('verification_login_view', $data);
    }

    public function verification_ok()
    {
        if($this->input->post('submit'))
        {
            $usuario = $this->login_modelo->very_code();
            if($usuario)
            {
                //dejar en blanco el campo usu_code_login
                $this->usuario_modelo->setEmptyCode($usuario['usu_id']);
                //crear variables para session
                $variables = array(
                    'username'  => $usuario['usu_username'],
                    'usu_nombre'=> $usuario['usu_nombre'],
                    'usu_ap'=> $usuario['usu_ap'],
                    'usu_am'=> $usuario['usu_am'],
                    'usu_id_actual' => $usuario['usu_id'],
                    'usu_tipo_actual' => $usuario['usu_tipo'],
                    //'gestion_actual' => $this->gestion_modelo->getGestionActual(),
                    'ue_id_actual' => $this->institucion_modelo->getIdEstadoActivo()
                );

                $this->session->set_userdata($variables);
                $this->usuario_modelo->setOnline($usuario['usu_id'], 1);
                redirect(base_url().'backend');
            }else{
                $data = array(
                    'mensaje' => 'El código es incorrecto.',
                    "logo" => $this->institucion_modelo->getLogo($this->institucion_modelo->getIdEstadoActivo())
                );
                $this->layout->view('verification_login_view',$data);
            }
        }
    }

    public function forgot_password()
    {
        $message = "";

        if($this->input->post("submit"))
        {
            $resu = $this->login_modelo->forgot_password();

            if($resu)
                $message = 'Le enviamos un email con un nuevo password.';
            else
                $message = "El email que ingreso no fue encontrado, intente nuevamente.";

            $data = array(
                'mensaje' => $message,
                "nombre_empresa" => $this->_nombre_empresa,
                "logo" => $this->institucion_modelo->getLogo($this->institucion_modelo->getIdEstadoActivo())
            );

            $this->layout->view('login',$data);
        }else{
            $data = array(
                "nombre_empresa" => $this->_nombre_empresa,
                "logo" => $this->institucion_modelo->getLogo($this->institucion_modelo->getIdEstadoActivo())
            );
            $this->layout->view('forgot_password_view',$data);
        }
    }

    public function logout()
    {
        $this->usuario_modelo->setOnline($this->session->userdata("usu_id_actual"), 0);
    	$this->session->sess_destroy();
		redirect(base_url().'backend/login', 'refresh');
    }
}

