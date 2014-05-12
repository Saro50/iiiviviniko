<?php



/**
 *  Captcha component
 */

App::uses('Component', 'Controller');



class CaptchaComponent extends Component {
	public $Securimage;

	public function __construct(){
			/**
			 *   Requir lib check
			 */
			
		require_once dirname(__FILE__) . '/Captcha/securimage.php';
		$this->Securimage = new Securimage();

	}
	public function config( $config ){

		$this->Securimage->image_width = isset($config["width"]) ? $config["width"] : 215;
		$this->Securimage->image_height = isset($config["height"]) ? $config["height"] :80;
		$this->Securimage->text_color     = isset($config["text_color"]) ?new Securimage_Color($config["text_color"] ):new Securimage_Color('#006699');
		$this->Securimage->image_bg_color = isset($config["image_bg_color"]) ?new Securimage_Color($config["image_bg_color"] ):new Securimage_Color( '#ffffff');
		$this->Securimage->line_color     = isset($config["line_color"]) ?new Securimage_Color($config["line_color"] ):new Securimage_Color( '#006699');
		$this->Securimage->noise_color    = isset($config["noise_color"]) ?new Securimage_Color($config["noise_color"] ):new Securimage_Color( '#ffffff');
		$this->Securimage->code_length    = isset($config["code_length"]) ? $config["code_length"] : 6 ;
		$this->Securimage->session_name   = isset($config["session_name"]) ? $config["session_name"] : "catp" ;
		$this->Securimage->charset        = 'ABCDEFGHKLMNPRSTUVWYZabcdefghklmnprstuvwyz23456789';
	}

    public function show(){
        return $this->Securimage->show();
    }

    public function check( $capt ){
    	return $this->Securimage->check( $capt );
    }
}

?>