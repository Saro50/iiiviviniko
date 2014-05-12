<?php


class AdminController extends AppController {
    public $uses = array("User","Serise","Product","Resource","Activity","About","Store","Gallery","Exhibition","Slider","Message");

    public $layout = "admin";

    public $menu = array("Collection" => "Collection" ,
    		 "Activity" => "Activity" , 
    		 "Store" => "Store",
    		 "About us" => "About" , 
    		 'EXHIBTION' => "exhibition",
    		 "Press/Letter" => "press" ,
    		 "Work" => "work"
    		  );

    public $components = array(
    	"Session",'Auth','Upload' ,'Captcha'
	     );

   public function beforeFilter(){
   	$this->autoRender = false;
   	$this->Auth->authenticate = array(
   		'Normal' => array(
   			"instance" => $this
   			)
   		);
   	$this->Auth->loginAction = array('controller' => 'admin', 'action' => 'login');
   	$this->Auth->allow( 'login','capt');// 
   	$this->Captcha->config(array(
   		"width" => 125,
   		"height" => 60 ,
   		"code_length" => 4 
   		));
   }

   public function beforeRender(){
    	$name = $this->Session->read("Auth.User.name");
    	$this->set("userName" , $name  );
    	$this->set("menu" , $this->menu);
   }


   public function login(){

    	$this->layout = "login";
		 if ($this->request->is('post')) {
				if( !$this->Captcha->check($this->request->data["ct_captcha"]) ){
					$this->Session->setFlash(
			          'captcha wrong',
			          'flash_msg',
			            array('class' => 'example_class')
			            );
				}else{

			    	if( (bool)$this->Auth->login() ){

			    		$this->redirect( 
				 			array(
				 				'controller' => 'admin',
				 				 'action' => 'index'
				 				 )
				 			);
			    	}else{
			    		$this->Session->setFlash(
			          ' Username or password is incorrect',
			          'flash_msg',
			            array('class' => 'example_class')
			            );
			    	}
			     }
		}
		
	    $this->render("login");
    }

    /**
     * [Collection description]
     */
    public function Collection(){
    	$page = array("title"=>"网站管理");
        $this->set('site',$page);
        $this->render("collection");
    }


   public function user(){
   		$page = array("title"=>"网站管理");
   		$u_data = $this->User->find("all",array( 'conditions' => array('u_name !=' => 'wn')) );
   		$this->set("u_data" , $u_data);
        $this->set('site',$page);
        $this->render("user_center");
   }
    public function Activity(){
    	$page = array("title"=>"网站管理");
        $this->set('site',$page);
        $this->render("activity");
    }

    public function Store(){
		$page = array("title"=>"网站管理");
        $this->set('site',$page);
        $this->render("store");
    }

    public function about(){
		$page = array("title"=>"网站管理");
        $this->set('site',$page);
        $data = $this->About->find("first",array(
        	"conditions" => array(
        		"About.id" => '1'
        		)
        	));
        $this->set('content', $data['About']["content"]);
        $this->render("about");
    }

    public function index() {	
    	$page = array("title"=>"网站管理");
        $result = $this->Serise->find("all");
        $this->set('site',$page);
	    $this->set('data',$result);
        $this->render("index");

    }

    public function readImg(){
    	$this->autoRender = false;
    	$this->layout = 'ajax';
    	$data = array();

    	array_push($data, array("name"=>"img.jpg", "type"=>"f","size"=>73289));
    	
    	$this->set('data',$data);
    	$this->response->type('json');
   
    	$this->render("ajax");
    }

    public function imgThumbnail(){
    	$this->autoRender = false;
    	$this->layout = 'ajax';
    	$data = array();
    	array_push($data, array("name"=>"img.jpg"));
    	$this->set('data',$data);
    	$this->render("ajax");
    }
   
    /**
     * [uploadImg description]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    protected  function uploadImg($request){

    	try{
    		$data = $this->Upload->save( $this->request );
    	}catch(Exception $e){
	 		$data = $e->getMessage();
	 	}
	 	return $data;
    }


    protected function formatArray($data , $modelName , $isSingle = false ){
    		$result = array();
    		if($isSingle){
    			$result = $data[$modelName];
    		}else{
	    		foreach($data as $key => $val ){
	    			array_push($result, $val[$modelName]);
	    		}
    		}
    		return $result;
    }

    protected function kendoPage( $modelsName , $request ,$conditions = array() ){
    		$limit = $request->query['pageSize'];
    		$page = $request->query['page'];
    		$offset = $request->query['skip'];
    		$total = $this->$modelsName->find("count" , array(
    			"conditions" => $conditions
    			) );
    		$options = array(		
    						'limit' => $limit ,
					    	'offset' => $offset,
					    	'page' => $page
					    	);
    		if(isset( $request->query['sort'] ) ){
    			$sort = $request->query['sort'];
    			$field = $sort[0]['field'];
    			$dir = $sort[0]['dir'];
    			$compare = $sort[0]['compare'];
    			$options['order'] = $modelsName.".".$field." ".$dir;
    		}
    			$options['conditions'] = $conditions;
  			//  array(
			//     'conditions' => array('Model.field' => $thisValue), //array of conditions
			//     'recursive' => 1, //int
			//     //array of field names
			//     'fields' => array('Model.field1', 'DISTINCT Model.field2'),
			//     //string or array defining order
			//     'order' => array('Model.created', 'Model.field3 DESC'),
			//     'group' => array('Model.field'), //fields to GROUP BY
			//     'limit' => n, //int
			//     'page' => n, //int
			//     'offset' => n, //int
			//     'callbacks' => true //other possible values are false, 'before', 'after'
			// )
    		return array(
    			'total' => $total,
    			'data' => $this -> formatArray ( $this->$modelsName->find( "all", $options ) , $modelsName )
    			);
    		

    }
    /**
     * [Serise description]
     * @return [type] [description]
     */
    public function readSe(){
    	$this->layout = "ajax";
    	$total = $this->Serise->find('count');
    	$data =$this->kendoPage("Serise",$this->request);
    	// var_dump($data);
    	// $data['total'] = $total;

    	$this->set("data",$data);
    	$this->render('ajax');
    }

    public function updateSe(){
    	$this->layout = "ajax";
    	
    	$data = $this->request['data'];

    	// $data = get_object_vars($data);//get_object_vars convers stdObj to array

    	$callback = $this->request->query['callback'];
    	$this->set("callback",$callback );
    	
    	$this->Serise->id = $data['id'];
    	$this->Serise->set($data);
    	if($this->Serise->save()){
    		$this->set("data",$data);
    	}else{
    		$this->set("data",array('errors'=> $this->Serise->validationErrors));
    	}


    	$this->render('jsonp');
    }

    public function createSe(){
    	$this->layout = "ajax";
    	
    	$data = $this->request['data'];
    	// $data =  get_object_vars($data);
    	// var_dump($data);
    	$callback = $this->request->query['callback'];
    	$data['id'] = null;
    	$this->Serise->set($data);

    	$this->set("callback",$callback );

    	if($this->Serise->save()){

    		$this->set("data",$data);
    	}else{
    		$this->set("data",array('errors'=> $this->Serise->validationErrors));
    	}


    	$this->render('jsonp');
    }


    public function destroySe(){
    	$this->layout = "ajax";
    	$data = $this->request['data'];


    	$callback = $this->request->query['callback'];

    	$this->Serise->delete($data['id']);

    	$this->set("callback",$callback );
    	$this->set("data",$data);
    	$this->render('jsonp');
    }

/**
 * [Product description]
 * @return [type] [description]
 */
    public function createPr(){
    	$this->autoRender = false;
 		$this->layout = 'ajax';

    	$id = $this->request->data['id'];
    	$series = $this->request->data['series'];
    	$path = $this->uploadImg( $this->request );
    	$result = array(
    		'p_belong' => $id ,
    		'p_series' => $series,
    		'p_path' => $path['file'],
    		'p_thumb' => $path['thumb']
    		);
    	$this->Product->set( $result );

    	if($this->Product->save()){
    		$this->set("data",array("msg"=>"success!"));
    	}else{
    		$this->set("data",array("msg"=>"fail!"));
    	}
    	$this->render("ajax");
    }

    public function readPr(){
    	$this->layout = "ajax";
    	$total = $this->Product->find('count');
    	$data =$this->kendoPage("Product",$this->request , array(
    		'Product.p_belong' => $this->request->query['s_id']
    		)
    	);


    	$this->set("data",$data);
    	$this->render('ajax');
    }

    public function updatePr(){
    	$this->layout = "ajax";

    	$data = $this->request['data'];

    	$callback = $this->request->query['callback'];
    	$this->set("callback",$callback );
    	
    	$this->Product->id = $data['id'];
    	$this->Product->set($data);
    	if($this->Product->save()){
    		$this->set("data",$data);
    	}else{
    		$this->set("data",array('errors'=> $this->Product->validationErrors));
    	}

    	$this->render('jsonp');
    }

    public function destroyPr(){
    	$this->layout = "ajax";
    	$data = $this->request['data'];

    	$callback = $this->request->query['callback'];

 
    	$this->Product->delete($data['id']);
    			
    	$this->set("callback",$callback );
    	$this->set("data",$data);
    	$this->render('jsonp');
    }

    /**
     * news
     */

    public function createNe(){
    	$this->layout = "ajax";
    	
    	$data = $this->request['data'];
    	// $data =  get_object_vars($data);
    	// var_dump($data);
    	$callback = $this->request->query['callback'];
    	$data['id'] = null;
    	$this->Activity->set($data);

    	$this->set("callback",$callback );

    	if($this->Activity->save()){

    		$this->set("data",$data);
    	}else{
    		$this->set("data",array('errors'=> $this->Activity->validationErrors));
    	}
    	$this->render('jsonp');
    }

    public function destroyNe(){
    	$this->layout = "ajax";
    	$data = $this->request['data'];

    	$callback = $this->request->query['callback'];

 
    	$this->Activity->delete($data['id']);
    			
    	$this->set("callback",$callback );
    	$this->set("data",$data);
    	$this->render('jsonp');
    }

    public function updateNe(){
    	$this->layout = "ajax";

    	$data = $this->request['data'];

    	$callback = $this->request->query['callback'];
    	$this->set("callback",$callback );
    	
    	$this->Activity->id = $data['id'];
    	$this->Activity->set($data);
    	if($this->Activity->save()){
    		$this->set("data",$data);
    	}else{
    		$this->set("data",array('errors'=> $this->Activity->validationErrors));
    	}

    	$this->render('jsonp');
    }

    public function readNe(){
    	$this->layout = "ajax";
    	$total = $this->Activity->find('count');
    	$data =$this->kendoPage("Activity",$this->request );


    	$this->set("data",$data);
    	$this->render('ajax');
    }

    /**
     * Store
     */
    public function readSt(){
    	$this->layout = "ajax";
    	$total = $this->Store->find('count');
    	$data =$this->kendoPage("Store",$this->request );
    
    	$this->set("data",$data);
    	$this->render('ajax');
    }

    public function createSt(){
    	$this->layout = "ajax";
    	$data = $this->request['data'];
    	// $data =  get_object_vars($data);
    	// var_dump($data);
    	$callback = $this->request->query['callback'];
    	$data['id'] = null;
    	$this->Store->set($data);

    	$this->set("callback",$callback );

    	if($this->Store->save()){

    		$this->set("data",$data);
    	}else{
    		$this->set("data",array('errors'=> $this->Store->validationErrors));
    	}
    	$this->render('jsonp');
    }

    public function updateSt(){
    	$this->layout = "ajax";
    	$data = $this->request['data'];

    	$callback = $this->request->query['callback'];
    	$this->set("callback",$callback );
    	
    	$this->Store->id = $data['id'];
    	$this->Store->set($data);
    	if($this->Store->save()){
    		$this->set("data",$data);
    	}else{
    		$this->set("data",array('errors'=> $this->Store->validationErrors));
    	}

    	$this->render('jsonp');
    }

    /**
     * [ImgSort description]
     * sort img
     */
    public function ImgSort(){
    	$this->layout = "ajax";
    	$this->autoRender = false;
    	$id = $this->request->query["id"];
    	if(!isset($this->request->query['m'])){
    		$model = "Product";
    		$se = $this->request->query['s'];
    		$conditions = array(
    			"p_belong" => $id,
    			"p_series" => $se
    			);
    		$order = array("Product.p_sort DESC","Product.id DESC");

    	}else{
    		$model = $this->request->query["m"];
    		$sort = $this->request->query["sort"];
    		$conditions = array( 'id' => $id );
    		$order = array( $sort." DESC","id DESC");
    	}
    
    	$data = $this->$model->find("all",array(
    		"conditions" => $conditions,
    		"order" => $order
    		));
    	$data = $this->formatArray($data,$model);

    	$this->set("data", $data );
    	$this->render('ajax');
    }

    /**
     * [saveImgSort description]
     * @return [type] [description]
     */
    public function saveImgSort(){
    	$this->layout = "ajax";
    	$data = $this->request['data'];
    	$wrong = array();
    	foreach ($data as $key => $value) {
    		$this->Product->id = $value['id'];
    		$this->Product->set($value);
    		if($this->Product->save()){

    		}
    		else{
    			array_push($wrong, $this->Product->validationErrors);
    			break;
    		}
    	}
    	if(count($wrong) == 0){
    		$this->set("data",array("info" => " sucess "));
    	}else{
    		$this->set("data",$wrong);
    	}
    	$this->render('ajax');
    }

    public function destroySt(){
    	$this->layout = "ajax";
    	$data = $this->request['data'];

    	$callback = $this->request->query['callback'];

 
    	$this->Store->delete($data['id']);
    			
    	$this->set("callback",$callback );
    	$this->set("data",$data);
    	$this->render('jsonp');
    }
    /**
     * 
     */
    public function readAb(){
    	$this->layout = "ajax";
    	$data = $this->About->find('first' , array( 'conditions' => array('About.id' => 1)) );


    	// $this->set("content",$data[0]['About']['content']);
    	
    	$this->render('ajax');
    }
    public function updateAb(){
    	$this->layout = "ajax";

    	$data = $this->request['data'];

    	$this -> autoRender = false;
    	$this->About->id = $data['id'];
    	$this->About->set($data);
    	if($this->About->save()){
    		$this->set("data",$data);
    		$result = "sucess";
    	}else{
    		$this->set("data",array('errors'=> $this->About->validationErrors));
    		$result = "error";
    	}
    	$this->set("data", $result);
    	$this->render('ajax');
    }

    public  function uploader(){
    	$this->autoRender = false;
    	
 		$this->layout = 'ajax';

		$path = $this->uploadImg($this->request); 

		$this->set("data", $path);

		$this->render("ajax");
    }

    public function uploadImage(){
    	// $this->request->data['id']

 		$this->autoRender = false;

 		$this->layout = 'ajax';
 		try{

	 		$data =  $this->Upload->save( $this->request );

	 		$this->set('data' , $data['thumb'] );

	 	}catch(Exception $e){
	 		$this->set('data' , $e->getMessage() );
	 	}

 		$this->render("ajax");

    }

    public function capt(){
    	 $this->Captcha->show();
    }

 	public function loginOut()
 	{
 
    	$this->Session->delete("Auth");
 		return $this->redirect( $this->Auth->logout() );
 	}

 	/**
 	 * exhibition
 	 * 
 	 */
 	public function exhibition(){
 		
 		$this->render("exhibition");
 	}

 	public function createGl(){
 		$this->autoRender = false;
 		$this->layout = 'ajax';

    	$belong = $this->request->data['belong'];
    	$path = $this->uploadImg( $this->request );
    	$result = array(
    		'belong' => $belong ,
    		'path' => $path['file'],
    		'thumb' => $path['thumb']
    		);
    	$this->Gallery->set( $result );

    	if($this->Gallery->save()){
    		$this->set("data",array("msg"=>"success!"));
    	}else{
    		$this->set("data",array("msg"=>"fail!"));
    	}
    	$this->render("ajax");	
 	}

 	public function read(){
 		$this->layout = "ajax";
 		$modelName = $this->request->query['model'];
 		if(isset($this->request->query['conditions'])){
 			$conditions = $this->request->query['conditions'];
 			$conditions = array( $conditions => $this->request->query[$conditions] );
 		}else{
 			$conditions = array();
 		}

 		$data =$this->kendoPage( $modelName ,$this->request , $conditions);

    	$this->set("data",$data);
    	$this->render('ajax');

 	}
 	public function create(){
 		$this->layout = "ajax";
    	$data = $this->request['data'];
    	$callback = $this->request->query['callback'];
    	$modelName = $data['model'];
    	$data['id'] = null;
    	$this->$modelName->set($data);

    	$this->set("callback",$callback );

    	if($this->$modelName->save()){

    		$this->set("data",$data);
    	}else{
    		$this->set("data",array('errors'=> $this->$modelName->validationErrors));
    	}
    	$this->render('jsonp');
 	}

 	public function update(){
    	$this->layout = "ajax";
    	$data = $this->request['data'];
    	$modelName = $data['model'];

    	// $data = get_object_vars($data);//get_object_vars convers stdObj to array

    	$callback = $this->request->query['callback'];
    	$this->set("callback",$callback );
    	
    	$this->$modelName->id = $data['id'];
    	$this->$modelName->set($data);
    	if($this->$modelName->save()){
    		$this->set("data",$data);
    	}else{
    		$this->set("data",array('errors'=> $this->$modelName->validationErrors));
    	}
    	$this->render('jsonp');
    }
    public function updateUser(){
    	$this->layout = "ajax";
    	$this->autoRender=false;

    	$data = $this->request['data'];
    	$id = $data["id"];
    	$r_older_pwd = $data['older_pwd'];
    	$new_pwd = $data["new_pwd"];
    	$name = $data["name"];
    	$older_pwd  = $this->User->find("first",array(
    		"conditions" => array(
    			"id" => $id
    			),
    		"fields" => "u_password"
    		));
    	if($r_older_pwd == $older_pwd["User"]["u_password"]){
    		$this->User->id = $id;
    		$this->User->set(array(
    			'u_password'=>$new_pwd
    			));
    		if($this->User->save()){
    			$data["message"] = "修改成功!";
	    		$this->set("data",$data);
	    	}else{
	    		$this->set("data",array('errors'=> $this->User->validationErrors));
	    	}
    	}else{
    		$this->set("data",array(
    			"status" => '0',
    			"message" => "错误的原密码!"
    			));
    	}

    	$this->render('ajax');
    }

    public function destroy(){
    	$this->layout = "ajax";
    	$data = $this->request['data'];
    	$modelName = $data ['model'];
    	$callback = $this->request->query['callback'];
    	$this->$modelName->delete($data['id']);
    	$this->set("callback",$callback );
    	$this->set("data",$data);
    	$this->render('jsonp');
    }

    public function press(){
    	$this->render("press");
    }


    public function createLetter(){
    	$this->autoRender = false;
 		$this->layout = 'ajax';

    	$type_name = $this->request->data['type_name'];
    	$path = $this->uploadImg( $this->request );
    	$result = array(
    		'type_name' => $type_name ,
    		'path' => $path['file'],
    		'thumb' => $path['thumb']
    		);

    	$this->Resource->set( $result );

    	if($this->Resource->save()){
    		$this->set("data",array("msg"=>"success!"));
    	}else{
    		$this->set("data",array("msg"=>"fail!"));
    	}
    	$this->render("ajax");	
    }

    public function createPress(){
    	$this->autoRender = false;
 		$this->layout = 'ajax';

    	$type_name = $this->request->data['type_name'];
    	$path = $this->uploadImg( $this->request );
    	$result = array(
    		'type_name' => $type_name ,
    		'path' => $path['file'],
    		'thumb' => $path['thumb']
    		);

    	$this->Resource->set( $result );

    	if($this->Resource->save()){
    		$this->set("data",array("msg"=>"success!"));
    	}else{
    		$this->set("data",array("msg"=>"fail!"));
    	}
    	$this->render("ajax");	
    }

    public function work(){
    	$data = $this->About->find('first' , array( 'conditions' => array('About.id' => 2)) );
    	$this->set("content",$data['About']["content"]);
    	$this->render("work");
    }

    public function updateWork(){
    	$this->layout = "ajax";

    	$data = $this->request['data'];

    	$this -> autoRender = false;
    	$this->About->id = 2;
    	$this->About->set($data);
    	if($this->About->save()){
    		$this->set("data",$data);
    		$result = "sucess";
    	}else{
    		$this->set("data",array('errors'=> $this->About->validationErrors));
    		$result = "error";
    	}
    	$this->set("data", $result);
    	$this->render('ajax');
    }

}
?>