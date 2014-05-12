<?php
class Activity extends AppModel {

	public $validate = array(
		    'a_title' => array(
		    		'max' => array(
			            'rule' => array('maxLength', 80),
			            'required' => true,
			            'message'  => '标题为必填项，并且最多填写80个字符!'
			        ),
		    		'unique'=> array(
			  	   	  'rule'    => 'isUnique',
			     	  'message' => '标题必须唯一！'
			  	   )
		    	)
		);

	public function afterFind($results, $primary = false) {
		$data = array();
		foreach ($results as $key => $value) {
			if(isset($value["Activity"])){

				$tmp = explode(" ", $value["Activity"]['a_modified_date']);
				$value["Activity"]['a_modified_date'] = $tmp[0];
				array_push($data, $value);
			}else{
				array_push($data, $value);
				continue;
			}
		}
		$results = $data;
	    return $data;
	}




}
?>