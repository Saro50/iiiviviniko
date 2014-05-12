<?php



/**
 *  Captcha component
 */

App::uses('Component', 'Controller');



class EmailComponent extends Component {
	public $mail;
	public function __construct(){
			/**
			 *   Requir lib check
			 */
		require_once "class.phpmailer.php";
		require_once "class.smtp.php";
		$this->mail=new PHPMailer();
		// 设置PHPMailer使用SMTP服务器发送Email
		$this->mail->IsSMTP();
		 // 设置邮件的字符编码，若不指定，则为'UTF-8'
		$this->mail->CharSet='UTF-8';

		 // 添加收件人地址，可以多次使用来添加多个收件人
	
		 // 设置SMTP服务器。这里使用网易的SMTP服务器。
		$this->mail->Host='smtp.126.com';

		 // 设置为“需要验证”
		$this->mail->SMTPAuth=true;

		 // 设置用户名和密码，即网易邮件的用户名和密码。
		$this->mail->Username='VIVINIKO_PR@126.com';
		$this->mail->Password='viviniko123456';

	}


	//  Info@iiiviviniko.com
		
	public function setAndSend( $Address , $name , $body , $title ){
		$this->mail->AddAddress($Address);

 		$this->mail->Body = $body;

 		$this->mail->From='VIVINIKO_PR@126.com';

		// 设置发件人名字
		$this->mail->FromName = $name ;

		 // 设置邮件标题
		$this->mail->Subject = $title;

		return $this->mail->Send();
	}



}

?>