<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

	Router::connect('/ACTIVITY', array('controller' => 'home' ,'action'=>'Activity'));
	Router::connect('/COLLECTION', array('controller' => 'home' ,'action'=>'Collection'));
	Router::connect('/STORES', array('controller' => 'home' ,'action'=>'Store'));

	Router::connect('/CONTACT', array('controller' => 'home' ,'action'=>'Contacts'));
	Router::connect('/COVER', array('controller' => 'home' ,'action'=>'COVER'));

	Router::connect('/ABOUT', array('controller' => 'home' ,'action'=>'about'));
	
	Router::connect('/capt',array('controller' => 'home' ,'action'=>'capt'));	
	
	Router::connect('/sendMessage', array('controller' => 'home' ,'action'=>'sendMessage'));


	Router::connect('/EXHIBTION', array('controller' => 'home' ,'action'=>'exhibition'));
	Router::connect('/LETTER', array('controller' => 'home' ,'action'=>'letter'));
	Router::connect('/PRESS', array('controller' => 'home' ,'action'=>'press'));
	Router::connect('/WORK', array('controller' => 'home' ,'action'=>'work'));

	/**
	 * gets Procuts ajax
	 */

	Router::connect('/gets', array('controller' => 'home' ,'action'=>'gets'));
		
	/**
	 * stores ajax link
	 */
	Router::connect('/getStore', array('controller' => 'home' ,'action'=>'getStore'));	
	Router::connect('/getCity', array('controller' => 'home' ,'action'=>'getCity'));
	

	Router::connect('/admin', array('controller' => 'admin'));
	Router::connect('/admin/:action', array('controller' => 'admin'));
	Router::connect('/', array('controller' => 'home'));
	Router::connect('/*', array('controller' => 'home'));

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	// Router::connect('/home/*', array('controller' => 'home', 'action' => 'index'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
