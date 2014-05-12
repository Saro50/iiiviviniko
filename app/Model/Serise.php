<?php
class Serise extends AppModel {

	public $validate = array(
		    's_title' => array(
		    		'max' => array(
			            'rule' => array('maxLength', 30),
			            'required' => true,
			            'message'  => '标题为必填项，并且最多输入30个字符!'
			        ),
		    		'unique'=> array(
			  	   	  'rule'    => 'isUnique',
			     	  'message' => '此系列主题已经存在！请重新输入'
			  	   )
		    	)
		);




}
?>