<?php
class Subject extends AppModel {
	public $validate = array(
		    's_title' => array(
		    	'rule1' => array(
			        'rule'    => array('maxLength', 21),
			        'message' => 'title must be no larger than 21 characters long.'
			        ),
		    	'rule2'=> array(
			        'rule'    => 'isUnique',
			        'message' => 'title has already been taken.'
			    )
		    )
		);
}
?>