<?php
class Exhibition extends AppModel {

	public $hasMany = array(
        'Gallery' => array(
            'className' => 'Gallery',
            'foreignKey' => 'belong',
             'order' => 'Gallery.sort DESC',
        )
    );
		// public $validate = array(
		//     'title' => array(
		//     		'max' => array(
		// 	            'rule' => array('maxLength', 10),
		// 	            'required' => true,
		// 	            'message'  => '标题为必填项，并且最多输入10个字符!'
		// 	        ),
		//     		'unique'=> array(
		// 	  	   	  'rule'    => 'isUnique',
		// 	     	  'message' => '此栏目已存在，请重新输入！'
		// 	  	   )
		//     	)
		// );


}
?>