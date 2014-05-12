<?php
/**
* Generate Static files to the cache folder
* USAGE: $this->static->start();
* @package default
* @author Eric@Web
*/

class StaticComponent 
{
   var $cache_root = '/Applications/xampp/xamppfiles/htdocs/cms/app/webroot/cache/';
   var $htaccess = '/Applications/xampp/xamppfiles/htdocs/cms/.htaccess';
   var $cache_address = 'app/webroot/cache/';
   var $domain = 'http://hi.baidu.com/';
   var $request_url = 'xeboy';   
   var $controller ;
   var $file_extension = '.html'; 

    function startup( &$controller)
    { 
             $this->controller = &$controller; 
    }
   /**
   * Get String form object
   *
   * @return void
   * @author Eric@Web
   */
   
   function getActionToString() 
   {
        $action = $this->controller->action;
        return '/'.$action;
    }
   /**
   * Get String form object
   *
   * @return void
   * @author Eric@Web
   */
   
   function getReControllerToString() 
   {
        $action = $this->controller->action;
        return $action.'/';
    }
   /**
   * Get String form object
   *
   * @return void
   * @author Eric@Web
   */
   
   function getControllerToString()
   {
       $controller = strtolower($this->controller->name);
       return $controller; 
   }
   /**
   * Get htaccess url for the rewrite rule
   *
   * @author Eric@Web
   */
   function getURL()
   {
       $url = substr($this->controller->here,1);
       return $url;
   }
   
   /**
   * Static request controller/action
   * -- Check the request controller/action already has folder & file.
   *       if true, save_as_html
   *       if false, mkdir and then save_as_html
   * @return void
   * @author Eric@Web
   */
   function start( )
   {
           $html_file_name = $this->cache_root.$this->getControllerToString().$this->getActionToString().$this->file_extension;
           $target_url = $this->domain.$this->request_url;
           
           if(file_exists($this->cache_root.$this->getControllerToString()))   
           {
                   $this->save_as_html($html_file_name,$target_url);
                   return true;
           }
           else
           {
                   if(mkdir($this->cache_root.$this->getControllerToString()))
                   {                   
                       $this->save_as_html($html_file_name,$target_url);
                       return true;
                   }
                   else
                   {
                       echo "Can't create new folder ! Check the folder permission \n try chmod -R 777 'your folder'";
                   }
           }
   }
   /**
   * Check the request URL while in the .htaccess file
   *
   * @param string $content 
   * @return void
   * @author Eric@Web
   */
   
   function htaccess_exists($content)
   {
       $ori_htaccess = file_get_contents($this->htaccess);
       $is_htaccess_exist = strpos($ori_htaccess, $content);
       if($is_htaccess_exist === false)
       {
           return false;
       }
       else
       {
           return true;
       }
   }
   /**
   * Add new rules in the .htaccess file
   *
   * @return void
   * @author Eric@Web
   */
   
   function update_htaccess()
   {
       $content = "<IfModule mod_rewrite.c> \n";
       $content = $content."    # Modify by Eric@Web at ".date("F j, Y, g:i a")." \n";
        $content = $content."    RewriteEngine   on \n";
        $ori_htaccess = file_get_contents($this->htaccess);
       $rlen = strpos($ori_htaccess, 'RewriteEngine on');
       
       $requset_url = $this->getControllerToString().$this->getActionToString();
       $rewrite_url = $this->getURL();
       
        $new_htaccess = trim(substr($ori_htaccess,$rlen+16));
       $is_htaccess_exist = strpos($new_htaccess, $requset_url);
       
       if ($is_htaccess_exist === false)
       {
           $content = $content."   RewriteRule   ^".$rewrite_url."$     ".$this->cache_address.$requset_url.$this->file_extension." [L] \n";
       }
       
       $content = $content.'   '.$new_htaccess;
       if($target_len = file_put_contents($this->htaccess,$content))
        {
             return true;
         }
      else
       {
            return false;
       }
   }

   /**
   * When the content of the page update, just need to re-new the html file, no need for edit the .htaccess file
   *
   * @param string $controller 
   * @param string $action 
   * @return void
   * @author Eric@Web
   */
   
   function re_new_static($controller,$action)
   {
       $target_url = $this->domain.'/'.$controller.'/'.$action;
       $html_file_name = $this->cache_root.$controller.'/'.$action.$this->file_extension;
       
       $target_content = file_get_contents($target_url);
       //$target_content = iconv("gb2312", "utf-8",file_get_contents($target_url)); 

       $target_len = file_put_contents($html_file_name,$target_content);

       if($target_len)
       {
           echo "We truly saved the file !";
       }
       else
       {
           echo "Can't save the file !";
       }
   }
   /**
   * Save request URL pages as a static html and also re-write the .htaccess rules
   *
   * @param string $html_file_name 
   * @param string $target_url 
   * @return void
   * @author Eric@Web
   */
   
   function save_as_html($html_file_name,$target_url)
   {
       $target_content = file_get_contents($target_url);
       //$target_content = iconv("gb2312", "utf-8",file_get_contents($target_url));        
       $target_len = file_put_contents($html_file_name,$target_content);
       
       if($target_len)
       {
           if($this->update_htaccess())
           {
               echo "We truly saved the file !";
           }
           else
           {
               echo "Can't save the new htaccess file !";
           }
       }
       else
       {
           echo "Can't save the file !";
       }
   }
   /**
   * When the static file is missing, according to the .htaccess rules, the request URL still re-direct to that static page,
   * So, it will request /cache/controller/action pages. Create a new cache controller and re-generate the static file and show it.
   * @param string $action 
   * @return void
   * @author Eric@Web
   */
   
   function re_start($action)
   {
       $html_file_name = $this->cache_root.$this->getReControllerToString().$action;
       $this->re_new_html($html_file_name,$this->target_url);
   }
}
?>