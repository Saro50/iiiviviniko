<?php
App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class NormalAuthenticate extends BaseAuthenticate {

    public function authenticate(CakeRequest $request, CakeResponse $response) {
   
        if(!isset($request->data["name"])){
        	return false;
        }
        
        $name = $request->data["name"];
        $result = ClassRegistry::init("User")->find('first',
            array(
                "conditions" => array(
                    "User.u_name" => $name
                        )
                )
            );
        // DIE;
        // var_dump($result);
        // $result = $this->User->find("first",array(
        //     'conditions'=>array(
        //         'Users.name'=>$name
        //         )
        //     ));
        // if($result['Users']['u_password'] == mdt($request->data["password"])){
        //     return array();
        // }
        // $result["u_name"]
        

        if(count($result) != 0 && $request->data["password"] == $result['User']["u_password"] ){

            return array('name'=> $name );
        }else{
            return false;
        }
        // Do things for OpenID here.
        // Return an array of user if they could authenticate the user,
        // return false if not
    }
}

?>