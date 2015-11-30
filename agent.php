<?php
/**
*Class Agent - P.W.S.M.
*Author Roman Shneer romanshneer@gmail.com
*1.02.2012
*changed 01.11.2015
*/
Class Agent
{
var $db,$db_type,$object,$templates;
function Agent()
{
$dir=$this->find_agent_library();
$this->include_agent_library($dir);

$this->register_agent();

$this->load_templates();

$this->chk_request();
  
$this->kill_agent();

}
function db_unloaded()
{
$this->legalprocess=false;
return false;
}
function kill_agent()
{
	if($this->db_type=='mysql')
	{
	mysqli_close($this->db);
	}elseif($this->db_type=='postgresql')
	{
	pg_close($this->db);
	}
unset($this);
}
function chrH($vars){
     $vars_after=$this->chk_variables_via_pattern($vars);
    
     if($vars_after!=$vars)
        {
      
            $this->reg_bad_request($vars,$vars_after);
            $vars=$vars_after;
        }elseif(!$this->object->stoped_only){
            $this->reg_request($vars);
        }
        return $vars;
}
function chk_request()
{
    
 switch($_SERVER['REQUEST_METHOD'])
 {
 	case 'GET':
            if($this->object->GET)
            {
                if(count($_GET)){
                    
                    $_GET=$this->chrH($_GET);
                    
                }
                elseif(!$this->object->stoped_only)$this->reg_request($_GET);
            }
            
 	break;
 	case 'POST':
            if($this->object->POST)
            {
                if(count($_POST)) $_POST=$this->chrH($_POST);
                elseif(!$this->object->stoped_only)$this->reg_request($_POST);
            }   
 	break;
        case 'COOKIE':
            if($this->object->COOKIE)
            {
                if(count($_COOKIE))$_COOKIE=$this->chrH($_COOKIE);
                elseif(!$this->object->stoped_only)$this->reg_request($_COOKIE);
            }
 	
 	break;
 }
}
function reg_bad_request($value,$new_value)
{
#$pattern=$template->code;
$reason="Request <b>".$this->Q($_SERVER['REQUEST_URI'])."</b>
Blocked value <b>".htmlspecialchars(print_r($value,1))."</b>
Changed to <b>".htmlspecialchars(print_r($new_value,1))."</b>";
$qs="http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
$url="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$sql="INSERT INTO pwsm_requests (url,method,query_string,reason,status,object_id,created,remote_addr) "
        . "VALUES ('".$this->Q($url)."','".$this->Q($_SERVER['REQUEST_METHOD'])."','".$this->Q($qs)."','".$this->Q($reason)."',1,".$this->object->id.",".time().",'".$this->Q($_SERVER['REMOTE_ADDR'])."')";

$idd=$this->QUERY($sql);
}
function reg_request($variables=array())
{
$names=array_keys($variables);
$reason="Request Accepted";
if(count($variables))$reason.="<br>variables accepted:<br>";
foreach($names as $name){$reason.="<br><font color='red'>".$name."</font>";}
#print_r($_SERVER);
$qs="http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
$url="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$sql="INSERT INTO pwsm_requests (url,method,query_string,reason,status,object_id,created,remote_addr) "
        . "VALUES ('".$this->Q($url)."','".$this->Q($_SERVER['REQUEST_METHOD'])."','".$this->Q($qs)."','".$this->Q($reason)."',0,".$this->object->id.",".time().",'".$this->Q($_SERVER['REMOTE_ADDR'])."')";
#die($sql);
$this->QUERY($sql);
}
function chk_variables_via_pattern($variables)
{
    
if(count($variables))
{
  
foreach($variables as $name=>$value)
	{
	$vars[$name]=$value;
	if($this->templates)
	{
            
		foreach($this->templates as $template)
		{		
		
		  $pattern=$template->code;
		  if(stristr($value,$pattern)||stristr($value,"%".bin2hex($pattern)))
			  {
		  $new_value=substr($value,0,strpos($value,$pattern)).substr($value,strpos($value,$pattern)+strlen($pattern),strlen($value)-strpos($value,$pattern)+strlen($pattern));
	
		  $vars[$name]=$new_value;
		 
		  $value=$new_value;
			  }
	  
	  	}
	}
	}
}

if(isset($new_value))
    {
    return $this->chk_variables_via_pattern($vars);
    }else return $vars;
}
function load_templates()
{
$sql="SELECT *
FROM pwsm_templates 
WHERE status=1";
$this->templates=$this->LIST_Q($sql);

}
function register_agent()
{
 $this->object=$this->chk_agent_object_registration($_SERVER['SCRIPT_FILENAME']);

}
function chk_agent_object_registration($source)
{
 return $this->ROW_Q("SELECT * FROM pwsm_objects WHERE object_source='".$this->Q($source)."'");
}
 function find_agent_library()
 {
 $files=get_included_files();
 foreach($files as $file)
 	{
 		if(strstr($file,"agent.php"))
 		{
        return substr($file,0,strrpos($file,"agent.php"));
 		}
 	}
 }
 function include_agent_library($dir)
 {
 	include_once $dir."conf/config.php";
    $this->db=$this->db_load($db_type,$db_host,$db_name,$db_user,$db_pass);

 }
 function db_load($db_type,$db_host,$db_name,$db_user,$db_password)
 {
 $this->dbtype=$db_type;
 	if($db_type=='mysql')
 	{
	  if($conn=mysqli_connect($db_host,$db_user,$db_password,$db_name))
	  {
	  #mysql_select_db($db_name,$conn);
	  return $conn;
	  }else{
	  return $this->db_unloaded();
	  }
 	}elseif($db_type=='postgresql')
 	{
 	$dbstring="host=".$db_host." port=5432 dbname=".$db_name." user=".$db_user." password=".$db_password;

	  if($conn=@pg_connect($dbstring))
	  {
	  return $conn;
	  }else{
	  return $this->db_unloaded();	  
	  }
 	}
 }
 function ROW_Q($sql)
 {
 $result=$this->QUERY($sql);
 if(!$result)return false;
 if($this->dbtype=='mysql')
 	{
     $ob=mysqli_fetch_object($result);
 	}elseif($this->dbtype=='postgresql')
 	{
    $ob=pg_fetch_object($result);
 	}
 	return $ob;
 }
 function LIST_Q($sql)
 {
 $result=$this->QUERY($sql);
 if(!$result)return false;
 if($this->dbtype=='mysql')
 	{
     while($ob=mysqli_fetch_object($result))
     	$objects[]=$ob;
 	}elseif($this->dbtype=='postgresql')
 	{
    while($ob=pg_fetch_object($result))
    	$objects[]=$ob;
 	}
 	return (isset($objects)?$objects:false);

 }
 function QUERY($sql)
 {
    # echo $sql;
 if($this->dbtype=='mysql')
 	{
     $result=mysqli_query($this->db,$sql);
     if($result==false)print "<div style='color:red;font-weight:bold;'>".mysql_error().'</div>';
     return $result;
 	}elseif($this->dbtype=='postgresql')
 	{
     return pg_query($this->db,	$sql);
 	}
 }
 function Q($sql)
 {
 	if($this->dbtype=='mysql')
 	{
     return mysqli_real_escape_string($this->db,$sql);
 	}elseif($this->dbtype=='postgresql')
 	{
     return pg_escape_string($sql);
 	}
 }
}
$a=new Agent;
?>