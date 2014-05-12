<?php
class WorldController extends AppController {
    public $helpers = array('Html', 'Form');
    public $uses = array("City","Country","CountryLanguage");
    public $layout = "world";

    public $cache_root = 'app/webroot/cache/';
 	public $file_extension = '.html';
    public function index() {
    	$this->set('title_for_layout', 'All world');


        $this->set('countres', $this->Country->find('all'));
   		

   		// $html_file_name = $this->cache_root.$this->getControllerToString().$this->getActionToString().$this->file_extension;
          
        // $target_c = file_get_contents($target_url);

   		// $target_url = $this->domain.$this->request_url;
        // $target_len = file_put_contents($html_file_name,$target_content);
    }
    public function city(){
    	$code = $this->request->query['code'];
    	$data = $this->City->find("all" , array(
    		'conditions' => array('CountryCode =' => $code )
    		));
    	$this->set('cities' , $data);
    	$this->render('city_list');
    }
}
?>