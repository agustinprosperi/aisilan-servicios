<?php

class Myemail
{
	private $CI;

	public function __construct()
	{
		$this->CI = & get_instance();
		$this->CI->load->model('usuario_modelo');
		$this->CI->load->library('email');
	}

	public function send_mail_code($usu_id, $code)
	{
		//asunto del email
		$subject = "Código de verificación";
		//cuerpo del email
		$email_body = "El código de verifación es: ".$code;
		//averiguar usu_email
		$usuario = $this->CI->usuario_modelo->getId($usu_id);
		//enviar email
        $from_email = "ebim@gmail";
        $to_email = $usuario['usu_email'];
        //Load email library

        $this->CI->email->from($from_email, 'E.B.I.M.');
        $this->CI->email->to($to_email);
        $this->CI->email->subject($subject);
        $this->CI->email->message($email_body);
        //Send mail
        if($this->CI->email->send())
		{
			return "yes";
		}else{
			return "no";
		}
    }

    public function send_mail_change_password($usu_id, $code)
	{
		//asunto del email
		$subject = "Nuevo password";
		//cuerpo del email
		$email_body = "El nuevo password es: ".$code;
		//averiguar usu_email
		$usuario = $this->CI->usuario_modelo->getId($usu_id);
		//enviar email
        $from_email = "ebim@gmail";
        $to_email = $usuario->usu_email;
        //Load email library

        $this->CI->email->from($from_email, 'E.B.I.M.');
        $this->CI->email->to($to_email);
        $this->CI->email->subject($subject);
        $this->CI->email->message($email_body);
        //Send mail
        if($this->CI->email->send())
		{
			return "yes";
		}else{
			return "no";
		}
    }
}

