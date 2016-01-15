<?php
/**
*Controller - P.W.S.M. 2.0
*Author Roman Shneer romanshneer@gmail.com
*created 01.11.2015
*/
Class Actions{
    
    public function execute_config(){
        $pss=new PSS;
        if(isset($_POST['op'])&&($_POST['op']=='save')&&(isset($_POST['patterns'])))
 	{
            $pss->save_templates($_POST['patterns']);
 	} 
        $data['templates']=$pss->db->LIST_Q("SELECT * FROM pwsm_templates WHERE 1=1");
        return $data;
        
    }
    public function execute_new_template(){
         $pss=new PSS;
         $msg=false;
        if(isset($_POST['code']))
	 {
	 switch($_POST['op'])
	 	{
	 		case 'save':
	 		if(!$pss->chk_dublicate_template((isset($_POST['id'])?$_POST['id']:""),$_POST['code']))
	 		{
                            
	 		if(isset($_POST['id']))
			 {

			  $pss->_update_template();
			 }else{
			 
			  $pss->_insert_template();
			 }
                       
			}else{
			$_SESSION['error']='<div class="error">Impossible to save template dublicated</div>';
			}
			header("Location:?q=config");
			exit();
	 		break;
	 		case 'delete':
	 		
			$pss->_delete_template();
			
	  		header("Location:?q=config");
	  		exit();
	 		break;
	 		case 'cancel':
	 		header("Location:?q=config");
	 		exit();
	 		break;
	 	}


     }
     $data['msg']=$msg;
    if(isset($_GET['id']))
   {
   	$data['temp']=$pss->db->ROW_Q("SELECT * FROM pwsm_templates WHERE id=".$pss->db->Q($_GET['id'],0));
   	$data['title']="Edit Security pattern ".htmlspecialchars($data['temp']['code']).", for your risk and garanty";
   }else{
   $data['title']="Create new security pattern by your self and share with frends";
   }
   return $data;
    }
    public function execute_new_xml_load(){
        $pss=new PSS;
        $start=new Start;
         if(isset($_POST['url']))
            {
            $json=$start->request($_POST['url']);
           
            $data=  json_decode($json);
            
            $_SESSION['error']=$pss->load_patterns2db($data);
            header("Location:?q=config");
            exit();
            }
     return Array();
    }
    public function execute_users(){
         $pss=new PSS;
        $data['users']=$pss->get_users();
        return $data;
    }
    public function execute_user(){
        global $pss;
        if(isset($_POST['op'])&&($_POST['op']=='save'))
 	{
 	$pss->save_user($_POST);
 	}elseif(isset($_POST['op'])&&($_POST['op']=='delete'))
 	{
 	$pss->delete_user($_POST);
 	}
        $data['user']=$pss->get_user($_GET['id']);
        return $data;
    }
    public function execute_test_form(){
         $pss=new PSS;
        if(!isset($_GET['id']))$_GET['id']=0;
        $data['object']=$pss->get_object($_GET['id']);
        return $data;
    }
    public function execute_agents_list(){
        $pss=new PSS;
       
        $data['title']='Objects list';
        $data['objects']=$pss->db->LIST_Q("SELECT * FROM pwsm_objects");
                
        return $data;
    }
    public function execute_request_statistics()
    {
         $pss=new PSS;
         if(isset($_POST['op'])&&($_POST['op']=='Remove Statistics'))
            {
               $pss->remove_object_statistics($_GET['id']);  
            }
         $data=$pss->request_statistics($_GET);
         $data['title']='Object '.$pss->object_name.' statistics';
         $data['id']=$_GET['id'];
         return $data;
    }
    public function execute_new_agent(){
      #  $pss->wisard_new_agent()
        $pss=new PSS;
        $data=Array();
        if(isset($_GET['patch'])&&(strlen($_GET['patch'])))
        {
            $filename=$_GET['patch'];
            $backupfile=urlencode($filename);
         if(filesize($filename)>200000)$data['errors'][]="Patching stopped! File is too large, impossible to patch";
	 else if(!is_writable($filename))$data['errors'][]="Patching stopped! Check permission for file writing, impossible to patch";
	 else if(!$pss->chk_php_file($filename))$data['errors'][]="Patching stopped! Is not php file, impossible to patch";
	 else if(file_exists($backupfile))$data['errors'][]="Patching stopped! Backup file ".$backupfile." already exists, cannot continue backup";
	 else if(!$pss->backupfile($filename))$data['errors'][]="Patching stopped! Cannot backup filem ,check permissions of backup/ directory, impossible to patch";
         else if($pss->chk_agent_code($filename)) $data['errors'][]="Patching stopped! Cannot patch,code already injected";
         else if($pss->patch_target($filename))
            {
                #header('Location:?q=agents_list&new_agent='.urlencode($filename));
                $data['msgs'][]="Patched ".$filename.". Check in `<a href=\"?q=agents_list\">Objects list</a>` statistics.";
            }else{
                $data['errors'][]="Patching stopped! Cannot patch,check permissions";
            }
        }elseif((isset($_GET['unpatch']))&&(strlen($_GET['unpatch'])))
        {
             $filename=$_GET['unpatch'];
              
              $backupfile="backups/".urlencode($filename);
           
            if(!$pss->chk_agent_code($filename))$data['errors'][]="Unpatching stopped! Agent code not exists in the file:<b>".$filename."</b>, impossible unpatch";
            
            if(!file_exists($backupfile))$data['errors'][]="Unpatching stopped! Backup file ".$backupfile." doesnt exists, impossible return original file";

            if($pss->restore_original($filename))
                 {

                    unlink($backupfile);
                    $data['msgs'][]="UnPatched";
                
                 }else $data['errors'][]="Unpatching stopped! Cannot unpatch,check permissions";
                 
                 
        }
        $data['pss']=$pss;    
        return $data;
    }
    public function execute_login_form()
    {
        global $start;
        $data=Array();
       # $start=new Start;
        if(isset($_POST['email'])&&isset($_POST['password']))
		{
                $db=$start->db;
                $user=$db->ROW_Q("SELECT * FROM pwsm_users where email='".$db->Q($_POST['email'],1)."' AND pass='".md5($db->Q($_POST['password'],1))."'");

                if($user)
                {
                        $_SESSION['user']=$user;

                        header("Location:".substr($_SERVER['REQUEST_URI'],0,strlen($_SERVER['REQUEST_URI'])-6));
                        exit();
                        #

                }else{
                    $data['error']='Wrong email or password';
                #$html.='<div class="message error">Wrong username or password</div>';
                }

		}
        return $data;
    }
    public function execute_restore_form(){
        global $start;
        #die(isset($start)."<hr>");
        $data=Array();
        #$start=new Start;
     if(isset($_POST['email']))
    {
    	$sql="SELECT * FROM pwsm_users WHERE email='".$start->db->Q($_POST['email'])."'";
    	$user=$start->db->ROW_Q($sql);
      
    	if($user['id'])
    	{
    	$subject="You( or somebody) try use module forget password on system PSS of ".$_SERVER['SERVER_NAME']." SERVER";
    	$body="You( or somebody) try use module forget password on system PSS of ".$_SERVER['SERVER_NAME']." SERVER<br>";
    	$body.="If it's true, continue with temporary secure link for change password is valid 2 hours<br>";
    	$body.=$start->create_secure_forgot_link($user);
    	 # print_r($user);
       # die($body);
    	mail($user['email'],$subject,$body);
         
    	$start->db->QUERY("UPDATE pwsm_users SET chg_pass_time=".time()." WHERE id=".$start->db->Q($user['id']));
    	$data['msg']='E-mail sended, please check your incoming box<br><a href="login/">Back to Login page</a>';  
       #die($body);
    	}else{
    	$data['error']='User not found!';
    	}

    }
    return $data;
    }
    public function execute_restorenow_form(){
         global $start;
         $data=Array();
         $sql="SELECT  * FROM pwsm_users WHERE md5(CONCAT(email,created))='".$start->db->Q($_GET['key'])."' AND chg_pass_time>".strtotime("-2 hours");
        #echo $sql;
       #die();
	$user=$start->db->ROW_Q($sql);
        
        if($user==false)
        {
            $data['error']='Security Link not valid,please restore password again <a href="login/?act=restore">Back to Restore password</a>';
        }else{
            
	if(isset($_POST['password1'])&&isset($_POST['password2']))
		{
                #print_r($_POST);
                #die();
		$start->db->QUERY("UPDATE pwsm_users SET pass='".md5($_POST['password1'])."' WHERE id=".$user['id']);
		$data['msg']='Password changed, now try go to login page <a href="login/">Back to Login page</a>';
		}
        }        
        #print_r($data);
        #die();
	return $data;
    }
    public function execute_view_file(){
        global $pss;
        $data=Array();
        if($_GET['id'])
	{
  		#$pss->view_file($_GET['id']);
                $data['object']=$pss->get_object($_GET['id']);
                $data['content']=file_get_contents($data['object']['object_source']);
                $data['agent_content']=$pss->insert_agent_call();
  		
	}
        return $data;
    }
    public function execute_window_wellcome(){
        global $wisard;
        if(isset($_POST['op'])&&($_POST['op']=='start'))
        {
#    	$wisard->nextstep();
     	#header("Refresh:1");
        header("Location:?step=1");
        }
        return array();
    }
    public function execute_window_create_config_file(){
        global $wisard;
        $data=Array();
        if(isset($_POST['dbtype'])&&count($_POST))
        {
            $_SESSION['post']=$_POST;
            header("Location:?step=2");
        }
        return $data;
    }
    public function execute_window_create_config_file_finished(){
         $data=Array();
          global $wisard;
        $data['msg']="conf/config.php file created";
        return $data;
    }
    public function execute_window_create_new_db(){
     global $wisard;
        $data=Array();    
     $data['dbname']=$dbname=$_SESSION['post']['dbname'];
     if(!$wisard->db_exists($dbname))
	{
	 $data['msg']=$wisard->create_new_db($dbname);
         header("Location:?step=5");
	}else{ 
	 if(isset($_POST['op']))
            {
                        if($_POST['op']=='delete')
                        {
                        $wisard->drop_db($dbname);
                        $data['msg']=$wisard->create_new_db($dbname);
                       header("Location:?step=5");
                        }else{ 
                            $data['msg']=" using exists db ".$dbname;
                            header("Location:?step=5");
                        }
            }
	
	}
   
    
    return $data;
    }
    public function execute_window_create_user(){
         global $wisard;
          $data=Array();    

        $conn=$wisard->dbconnect();
                    
	if(isset($_POST['email'])&&isset($_POST['password']))
	{
        
	$someuser=$wisard->ROW_Q("SELECT count(*) as num FROM pwsm_users WHERE email='".$wisard->Q($_POST['email'],1)."'",$conn);
  
	if($someuser['num']>0)
	  {
            $_SESSION['post'][400]=$_POST;
            header("Location:?step=400");
	
	  }elseif(strlen(trim($_POST['password']))&&($_POST['password']==$_POST['password1']))
		{
		  $wisard->QUERY("INSERT INTO pwsm_users (email, pass,created) VALUES ('".$wisard->Q($_POST['email'],1)."','".md5($wisard->Q($_POST['password'],1))."',".time().")",$conn);
		 
		  $data['msg']="User registered";
             
                  header("Location:?step=6");
		  
		}elseif($_POST['password']!=$_POST['password1'])
		{
		$data['error']="Please password and retype again the some password.";
		}
	
		
	 } 
		//check if user already exists
		
	
    $data['countuser']=$wisard->ROW_Q("SELECT count(id) as num FROM pwsm_users where length(email)>0 and length(pass)>0",$conn);
               
        return $data;        
    }
    public function execute_finall_installation(){
        global $wisard;
        $data=Array();
        if($wisard->create_configfile($_SESSION['post']))
        {
            $data['success']=true;
        }else{
            $data['success']=false;
           
        }
        
        return $data;
       
    }
    public function execute_create_config_file_false(){
        global $wisard;
          $data=Array();   
        if($wisard->chk_db_connect($_SESSION['post'])==false)
        {
              $wisard->delete_config_file();
        
              $data['success']=false;
              $data['error']='<p>Connect error - please recheck connection data</p>
                          <h5>conf/config.inc.php deleted, please change username/password/hostname and create new one.</h5>';
        }else{
            $data['msg']='<p>Connected succefully.</p>';
            $data['success']=true;
       
        }
         return $data;       
    }
    public function execute_chk_tables_exists(){
          global $wisard;
        
        $conn=$wisard->dbconnect();

            foreach($wisard->tables[trim($_SESSION['post']['dbtype'])] as $table=>$value)
            {
        $r=$wisard->chk_table_exists($table,$conn);

                    if(!$r&&($wisard->QUERY($value,$conn)))
                            {
                                   
                                    $data['msgs'][]='<p>Table '.$table.' created'."</p>";
                            }else{
                                    $data['errors'][]='<p>Table '.$table.' already exists'."</p>";
                            }

            }
    return $data;        
    }
    public function execute_user_exists_confirm(){
        $data=array('email'=>$_SESSION['post'][400]['email'],'password'=>$_SESSION['post'][400]['password']);
             global $wisard;
          
        $conn=$wisard->dbconnect();
        if(isset($_POST['op']))
        {
            if($_POST['op']=='Accept Replace')
            {
                unset($_SESSION['post'][400]);
                 $wisard->QUERY("INSERT INTO pwsm_users (email, pass,created) VALUES ('".$wisard->Q($data['email'],1)."','".md5($wisard->Q($data['password'],1))."',".time().")",$conn);
		
                  header("Location:?step=6");
            }elseif($_POST['op']=='Insert new email')
            {
                unset($_SESSION['post'][400]);
                header("Location:?step=5");
            }
        }
            return $data;
    }
    public function execute_window_wellcome0()
    {
        return array();
    }
    public function execute_check_before_install(){
    global $wisard;
    $data=Array();
    $data['success']=true;
    if(!$wisard->check_connect($_SESSION['post']))
         {
        $data['success']=false;
             $data['errors'][]="Impossible connect to DB server";
         }else{
             
             $data['msgs'][]="Connect to DB server successfully";
         }
         
        if($wisard->config_dir_writeble()==false)
        {
            $data['errors'][]="Directory conf not writeble";
            $data['success']=false;
        }else{
             $data['msgs'][]="Directory conf writeble";
        }
        return $data;
    }
    public function execute_install_db(){
        global $wisard;
    $data=Array();
        $dbname=$_SESSION['post']['dbname'];
        
              if($wisard->db_exists($dbname))
                {
                  
                  $data['errors'][]="Database ".$dbname." already exists";
                  $data['success']=false;
                  if(isset($_GET['act']))
                  {
                      switch($_GET['act'])
                      {
                          case 'use':
                            header("Location:?step=4");  
                              exit();
                          break;
                          case 'replace':
                              $wisard->drop_db($dbname);
                              $wisard->create_new_db($dbname);
                              header("Location:?step=4");
                              exit();
                          break;
                      }
                  }
                }else{
                     $wisard->create_new_db($dbname);
                  $data['success']=true;  
                   header("Location:?step=4");  
                }
     return $data;
    }
    public function execute_rollback(){
        global $wisard;
        $wisard->drop_db($_SESSION['post']['dbname']);
        
    }
    public function execute_export_json(){
        global $pss;
        $templates=$pss->db->LIST_Q("SELECT code,description FROM pwsm_templates ORDER BY id");
        header ("Content-Type:application/json");
        header('Content-Disposition: attachment; filename='.basename('patterns.json'));
        die(json_encode($templates,1));
    }
    public function execute_about(){
        return array();
    }
    public function execute_install_loading_patterns(){
        global $wisard;
        $json=file_get_contents("../staff/patterns.json");
        $patterns=json_decode($json);
        $data=Array('patterns'=>array('pattern'=>$patterns));
        $answer=$wisard->load_patterns2db($data);
        return $answer;
    }
    public function execute_chg_status()
    {
        return array('id'=>$_GET['id']);
    }
    public function execute_chg_method(){
        return array('id'=>$_GET['id']);
    }
    public function execute_chg_url(){
        return array('id'=>$_GET['id']);
    }
    public function execute_chg_query_string(){
        return array('id'=>$_GET['id']);
    }
    public function execute_chg_remote_ip(){
        return array('id'=>$_GET['id']);
    }
    public function execute_chg_date(){
        return array('id'=>$_GET['id']);
    }
    public function execute_request_more_info(){
      global $pss;
       $get=$_GET;
       $get['offset']=$_GET['result_num'];        
       
       $requests=$pss->get_requests($get);
       return array('requests'=>$requests);
        
    }
    public function execute_wai(){
        $ids=explode("|",$_GET['id']);

	$filename=urldecode($ids[0]);
	$unpatch_url=urldecode($ids[1]);
        return array('filename'=>$filename,'unpatch_url'=>$unpatch_url);
      
    }
    public function execute_alcb(){
       global $pss;
        $pss->alcb($_GET['type'],$_GET['id'],$_GET['value']);
        die('ok');
    }
    public function execute_request_reason(){
        global $pss;
        $obj=$pss->db->ROW_Q("SELECT reason FROM pwsm_requests WHERE id=".$pss->db->Q($_GET['id']));
        return array('obj'=>$obj);
    }
    public function execute_uninstall_object(){
        global $pss;
         
        if($_GET['id'])
	{
                $object=$pss->get_object($_GET['id']);
  		$pss->uninstall_object($object);
  		$headers['title']='Uninstalling object '.$pss->object_name;
	}
    }
}
?>