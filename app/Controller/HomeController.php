<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class HomeController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array("Resource","Slider","Serise","Product","Activity","About","Store","Exhibition","Gallery","Message");
	public $menu = array(
			"COLLECTION" => "Collection" ,
			"ACTIVITY" => "Activity" , 
			"ABOUT" => array(
				"type" => 1,
				"value" => "aboutDetail"
				) ,
			"STORES" => "Store",
			"CONTACTS" => "Contacts" );


	public $bottom_menu = array(
		'EXHIBTION' => "exhibition",
		'LETTER' => "letter",
		'PRESS' => 'press',
		'WORK' => "work",
		'FOLLOW US' => array(
			'type' => '1',
			'value' => "follow"
			)
		);

	public $components = array('Cookie',"Email","Captcha");
	public $num_to_mouth = array(
			"01" => "Jan." ,
			"02" => "Feb." ,
			"03" => "Mar." ,
			"04" => "Apr." ,
			"05" => "May." ,
			"06" => "Jun." ,
			"07" => "Jul." ,
			"08" => "Aug." ,
			"09" => "Sep." ,
			"10" => "Oct." ,
			"11" => "Nov." ,
			"12" => "Dec."
		);

	public $layout = 'home';

	protected function filterData( $data ){
		$result  = array();
		foreach ($data as $key => $value) {
			if( is_array($value) ){
				foreach ($value as $k => $v) {
					array_push($result, $v);
				}
			}
		}
		return $result;
	}

	public function beforeRender(){
		$show_cover = true;

		$data = $this->Slider->find("first", array( 'conditions' => array('s_type' => 'About')) );

		$this->set("about_cover",$data);

		$this->set("cur_action", $this->request['action']);
		if(!$this->Cookie->check('cover')){
				$this->Cookie->write('cover', 'true');
			}else{
				$this->Cookie->write('cover', 'false');
			}
			
		if($this->Cookie->read('cover') == "false"){
			$show_cover = false;
		}
		// $this -> set("show_cover" , $show_cover);
		
		// $this -> set("description" , "Fashion simple iiiviviniko"  );
	
    	$this -> set( "title_for_layout" , "home");
		$this -> set( 'menu' , $this->menu );
		$this -> set( 'bottom_menu' , $this->bottom_menu );
	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */

	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Cookie->time = 3600;  // or '1 hour'
	    $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';

	}

	public function index(){
		$this -> set("description" , "HOME - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "HOME");
    	
		$this->autoRender = false;
		$data = $this->filterData($this->Slider->find("all",array(
			"conditions" => array(
				"s_type" => "Home"
				),
			'order' => array( 'sort DESC' ,'id DESC')
			))
		);
		$this->set('data', $data);
		$this->render("home");
		return;
	}

	public function Collection(){

		$this -> set("description" , "COLLECTION - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "COLLECTION");

		$this->autoRender = false;
		$data = array();

		$sub_menu = $this->Serise->find("all" , array(
				'conditions' => array(
					"Serise.s_use"=> 1
				 ) ,
				'order' => array( 'Serise.s_date DESC' )
				));
		$sub_menu = $this->filterData($sub_menu);

		$id = @$this->request->query["r"];
		if( isset($this->request->query["r"]) && is_numeric($id) ){
			$series = $this->Serise->find("first",array(
				'conditions' => array(
					"Serise.id"=> $this->request->query["r"]
				 ) 
			));

			if(count($series) == 0){
				$series = $this->Serise->find("first" );
			}else{
				$this->set("cur_id",$series["Serise"]['id']);
			}
		}else{
			$series = $this->Serise->find("first" , array(
					"order" => array("Serise.s_date DESC")
					));
			$this->set("cur_id",$series["Serise"]['id']);
		}
	
	

		$data = $this->Product->find("all",array(
			// 'limit' => 8,
			'conditions' => array(
				"Product.p_belong"=> $series['Serise']['id'] ,
			 	"Product.p_series" => "CAMPAIGN"
			 ) ,
			'order' => array('Product.p_sort DESC',"Product.id DESC")
			));
		$data = $this->filterData($data);
		$this->set("series" , $series["Serise"] );
		$this->set("sub_menu", $sub_menu );
		$this->set("data" , $data );
		$this->render("index");	
	}

	public function About(){

		$this -> set("description" , "ABOUT - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "ABOUT");
    	
		$this->autoRender = false;
		$data = $this->About->find("first");
        $this->set('content', $data['About']["content"]);
		$this->render("about");
	}
	public function Contacts(){
		$this -> set("description" , "CONTACTS - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "CONTACTS");
    	
		$this->autoRender = false;


		$this->render("contacts");
	}	

	public function store(){

		$this -> set("description" , "STORES - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "STORES");
    	
		$this->autoRender = false;
		$_area=array("hd","hz","hb","db","xn","xb");
		$area = @$this->request->query['a'];
		if(in_array($area , $_area)){
			$data = $this->Store->find("all",array(
				'conditions' => array(
					"Store.s_area"=> $area
			 	) 
				));
			$data = $this->filterData($data);
			$this->set('data',$data);
			$this->render("json");
			return;
		}else{
				$data = $this->Store->find("all",array(
					'conditions' => array(
						"Store.s_area"=> "hd"
				 	) 
				));
		}
		$sliders = $this->filterData($this->Slider->find("all",array(
			"conditions" => array(
				"s_type" => "shop"
				),
			'order' => array( 'sort DESC' ,'id DESC')
			))
		);
		$this->set('sliders', $sliders);

		$data = $this->filterData($data);
		$this->set('data',$data);
		$this->render("store");
	}
	public function getCity(){
		$this->autoRender = false;
		$this->layout = "ajax";
		$_region=array("hd","hz","hn","hb","db","xn","xb");
		$region = @$this->request->query['r'];
		if(in_array($region , $_region)){
			$data = $this->Store->find("all",array(
				'fields' => array( "DISTINCT s_city"),
				'conditions' => array(
					"s_area"=> $region
			 		)
				));	
			$data = $this->filterData($data);
			$this->set('data',$data);
			$this->render("json");
			return;
		}


	}

	public function getStore(){
		$this->autoRender = false;
		$this->layout = "ajax";
		// explode
		$city = @$this->request->query['c'];

		$city = explode(" " , $city);
		$city = $city[0];
		if( $city != "" ){
			$data = $this->Store->find("all",array(
				'conditions' => array(
					"Store.s_city"=> $city
			 	) 
				));
			$data = $this->filterData($data);
			$this->set('data',$data);
			$this->render("json");
		}else{
			$this->set('data',array());
			$this->render("json");
			return;
		}

	}

	public function activity(){

		$this -> set("description" , "ACTIVITY - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "ACTIVITY");
			$query_y = @$this->request->query['y'];
			if(isset($this->request->query['y'])&&is_numeric($query_y) ){
				$query_m = @$this->request->query['m'];

				if(isset($this->request->query['m'])&&(strlen($query_m)==3)){
					$data = $this->Activity->find("all",array(
					'conditions' => array('Activity.a_type' => "ACTIVITY",
							"DATE_FORMAT(a_modified_date,'%Y')" => $query_y ,
							"DATE_FORMAT(a_modified_date,'%b')" => $query_m
							 ), 
					'order' => array( 'Activity.a_modified_date DESC'),
					));
				}else{
					$data = $this->Activity->find("all",array(
						'conditions' => array('Activity.a_type' => "ACTIVITY", "DATE_FORMAT(a_modified_date,'%Y')" => $query_y ), 
						'order' => array( 'Activity.a_modified_date DESC')
						));
				}
			}else{
				$data = $this->Activity->find("all",array(
					'conditions' => array('Activity.a_type' => "ACTIVITY"), 
					'order' => array( 'Activity.a_modified_date DESC')
					));
			}
			$_year = $this->Activity->find("all",array(
				'fields' => array(' DISTINCT DATE_FORMAT(a_modified_date,"%Y %b") as "date" '),
				'conditions' => array('Activity.a_type' => "ACTIVITY"), 
				'order' => array( 'Activity.a_modified_date DESC')
				));

			$this->set("year", $_year );
			$data = $this->filterData($data);
		
			$this->set('data',$data);
			$this->render("activity");
	}

	public function gets(){
		$this->autoRender = false;
		$this->layout = 'ajax';
		$type = $this->request->query['t'];
		$id = $this->request->query['i'];
		if(!is_numeric($id) ){
			$id = 1;
		}
		if( count(explode(" ", $type)) > 1 ){
			$type = "CAMPAIGN";
		}
		$data = $this->Product->find("all",array(
			'conditions' => array(
				"Product.p_belong"=> $id ,
			 	"Product.p_series" => $type
			 ),
			'order' => array('Product.p_sort',"Product.id")
			));

		$this->set("data",$this->filterData($data) );
		$this->render("json");
	}


/**
 *
 * bottom menu
 */

	public function exhibition(){

		$this -> set("description" , "EXHIBITION - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "EXHIBITION");
		$this -> autoRender = false ; 
		$data = $this->Exhibition->find( "all" , array(
			'order' => array('Exhibition.e_rank DESC')
			));
		$gallery =$this->filterData($this->Gallery->find("all" ,  array(  
		 	'recursive' => 0 
		 )));
		$this -> set( "data" , $data );
		$this-> set("gallery", $gallery );
		$this -> render("exhibition");
	}

	public function letter(){

		$this -> set("description" , "LETTER - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "LETTER");
		$this -> autoRender = false ; 

		$data = $this->Resource->find("all", array( 
			'conditions' => array('Resource.type_name' => 'Letter'),
			'order' => array( 'Resource.display_date DESC')
			) );

		$data = $this->filterData($data);

		$this->set("data", $data);

		$this -> render("letter");	
	}

	public function press(){

		$this -> set("description" , "PRESS - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "PRESS");
		$this -> autoRender = false; 
		$data = $this->Resource->find("all", array( 
			'conditions' => array('Resource.type_name' => 'press'),
			'order' => array( 'display_date DESC' ,'id DESC')
			) );
		$data = $this->filterData($data);
		$tmp_data = array();
			foreach($data as $val){
				$arr = array();
				foreach ($val as $k => $v) {
					if($k == "display_date" && $v != NUll ){
				
						$v = explode("-",$v);
						$v[1] = $this->num_to_mouth[$v[1]];
						$v = $v[1].$v[0];
					}
					$arr[$k] = $v;
				}
				array_push( $tmp_data , $arr );
			}
		$data = $tmp_data;
		$this->set("data", $data);
		$this -> render("press");	
	}

	public function work(){

		$this -> set("description" , "WORK - IIIVIVINIKO.COM"  );
    	$this -> set( "title_for_layout" , "WORK");
		$this -> autoRender = false ; 

		$data = $this->About->find('first' , array( 'conditions' => array('About.id' => 2)) );

    	$this->set("content",$data['About']["content"]);

		$this -> render("work");	
	}

	public function capt(){
    	 $this->Captcha->show();
    }

	public function sendMessage(){
		$this -> autoRender = false ; 
		$this->layout='ajax';
		$name = @htmlspecialchars($this->request['data']["user"]);
		$email = @htmlspecialchars($this->request['data']["email"]);
		$message = @htmlspecialchars($this->request['data']["message"]);

		if( !$this->Captcha->check($this->request->data["capt"]) ){
			$this->set("message",array(
				"mes" => "验证码错误，发送失败!" ,
				'stauts' => 1
				));
			$this->render("message");
			return;
		}
		$data = $this->request['data'];
    	// $data =  get_object_vars($data);
    	// var_dump($data);
    	$this->Message->set($data);


    	if($this->Message->save()){

    		// $this->set("data",$data);
    	}else{
    		// $this->set("data",array('errors'=> $this->Serise->validationErrors));
    	}
        //  Info@iiiviviniko.com
        //  
        //  
		
		$result = $this->Email->setAndSend("Info@iiiviviniko.com",$email ,$message,$name);
		$this->set("message",array(
					"mes" => "发送成功!感谢您的来信!" ,
					'stauts' => 0
					));
		$this->render("message");
	
    	//$this->redirect(array('action' => 'index'));
	}
}
