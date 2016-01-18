<?php
/**
*Class PSS - P.W.S.M.
*Main P.W.S.M functions 
*Author Roman Shneer romanshneer@gmail.com
*1.02.2012
*changed 01.11.2015  
*/
Class PSS
{
var $db,$results_count,$object_name;
static $results_step=20;
var $memcache_obj;
 function PSS()
 {
 global $start;
 //extending db class
 $this->db=$start->db;
 

   #$this->chk_db();
 }
 function delete_user($user)
 {
 $sql="DELETE FROM pwsm_users WHERE id=".$this->db->Q($user['id']);	
 $this->db->QUERY($sql);
 header("Location:index.php?q=users");	
 exit();
 }
 function save_user($user)
 {
 if($user['id'])
 {	
 $sql="UPDATE pwsm_users SET email='".$this->db->Q($user['email'])."'";
 	if(($user['password1'])&&($user['password1']==$user['password2']))
 	{
 	$sql.=",pass='".md5($user['password1'])."'";
 	}
 $sql.=" WHERE id=".$this->db->Q($user['id']);
 }else{
 $sql="INSERT INTO pwsm_users (email,pass) VALUES ('".$this->db->Q($user['email'])."','".md5($user['password1'])."')";
 }
 $this->db->QUERY($sql);
 header("Location:index.php?q=users");	
 exit();
 }
 function get_user($id)
 {
 return $this->db->ROW_Q("SELECT * FROM pwsm_users WHERE id=".$this->db->Q($id));
 }
 function get_users()
 {
 return $this->db->LIST_Q("SELECT * FROM pwsm_users");
 }
 
 function browse_filesystem()
 {
	 if((isset($_GET['dir']))&&(strlen($_GET['dir'])))
	 {
	 	$path=$_GET['dir'];
	 }else $path=$_SERVER['DOCUMENT_ROOT'];
	 
	 $html=$this->browse_folder($path);
	 return $html;
 }
 ### view files&folders via path
 function browse_folder($path)
 {
     
 $html='';
 $list=glob($path."/*");
 $html.='<div class="left"><p><i><a href="?q=new_agent&dir='.substr($path,0,strrpos($path,"/")).'" class="status_inline green">UP to '.substr($path,0,strrpos($path,"/")).'</a>&nbsp;
 <a href="?q=new_agent&dir='.$_SERVER['DOCUMENT_ROOT'].'"  class="status_inline red">Back to DOCUMENT_ROOT '.$_SERVER['DOCUMENT_ROOT'].'</a></i></p>';
 $html.='<ul style=list-style:none;"">';
	 foreach($list as $l)
	 {
	 $html.='<li>'.(is_file($l)?$this->draw_file4browse('?q=new_agent&patch='.$l.'&dir='.((isset($_GET['dir']))?$_GET['dir']:""),'?q=new_agent&unpatch='.$l.'&dir='.((isset($_GET['dir']))?$_GET['dir']:""),$l):$this->draw_folder4browse('?q=new_agent&dir='.$l,$l)).'</li>';
	 }
 $html.='</ul></div>';
 return $html;
 }
 
 ### Draw file-link for browse filesystem  ###
 function draw_file4browse($url,$url_unpatch,$text)
 {
	 if(file_exists("backups/".urlencode($text)))
	 {
	  if($this->chk_agent_code($text))
	  {
	    $object=$this->db->ROW_Q("SELECT * FROM pwsm_objects WHERE object_source='".$this->db->Q($text)."'");
	    if($object['id'])$html='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?q=view_file&id='.$object['id'].'" style="color:'.(strstr($text,"index.php")?'maroon':(strstr($text,".php")?'maroon':'brown')).'">'.$text.'</a><span style="color:red;font-weight:bold;">Patched</span>';
	    else $html='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript://" onClick="show_info(e,\'wai\',\''.urlencode($text).'|'.urlencode($url_unpatch).'\')" style="color:'.(strstr($text,"index.php")?'maroon':(strstr($text,".php")?'maroon':'brown')).'">'.$text.'</a><span style="color:green;font-weight:bold;">Waiting agent initilisation</span>';
	   
	  }else
	  {
	  $html='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$url.'" class="file_link" style="color:'.(strstr($text,"index.php")?'red':(strstr($text,".php")?'darkgreen':'dimgray')).'">'.$text.'</a><span style="color:red;font-weight:bold;">Backup exists,but code not found!</span>'; 
	  
	  }
	 
	 }else{
	 $html='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$url.'" class="file_link" style="color:'.(strstr($text,"index.php")?'red':(strstr($text,".php")?'darkgreen':'dimgray')).'">'.$text.'</a>';
	 }

	 return $html;
	 }
 ### Draw folder-link for browse filesystem  ###
 function draw_folder4browse($url,$text)
 {
 return '<a href="'.$url.'" class="folder_link"><img src="staff/folder.gif">&nbsp;'.$text.'</a>';
 }
 ### cheking if code already exists in the file ###
 function chk_agent_code($filename)
 {
	 $content=file_get_contents($filename);
	 $agent_code=$this->insert_agent_call();
	 if(substr($content,0,strlen($agent_code))==$agent_code)return true;
	 else return false;
 }
 ### patching file ###
 function patch_target($filename)
 {
	 $content=file_get_contents($filename);
	 $agent_code=$this->insert_agent_call();
	 $new_content=$agent_code.$content;
         if(!$this->get_object_by_source($filename))
         {
             $this->save_object($filename);
         }
	 return file_put_contents($filename,$new_content);
 }
 ### return php code of absolute agent calling ###
 function insert_agent_call()
 {
  $agent_path=substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],"/")+1)."agent.php";
  return "<?php @include_once '".$agent_path."';?>";
 }
 ### checking if php file ###
 function chk_php_file($filename)
 {
     $ext=substr($filename,(strrpos($filename,".")+1));
     if($ext=='php')return true;
     else return false;
 }
 ### create backup file from original source ###
 function backupfile($filename)
 {
	 $backupfile=urlencode($filename);

	 $f=fopen("backups/".$backupfile,"w");
	 fwrite($f,file_get_contents($filename));
	 fclose($f);
	 return true;
 }

 function _insert_template()
 {
	
	$reg_date=(empty($_POST['reg_date'])?time():strtotime($_POST['reg_date']));
	$sql="INSERT INTO pwsm_templates(code,description,status) VALUES ('".$this->db->Q($_POST['code'],1)."','".$this->db->Q($_POST['description'],1)."',1)";
	$rez=$this->db->QUERY($sql);
	
 }
 function _update_template()
 {
     $sql="UPDATE pwsm_templates SET 
                        code='".$this->db->Q($_POST['code'],1)."',
                        description='".$this->db->Q($_POST['description'],1)."'
                        WHERE id=".$this->db->Q($_POST['id']);
     
  $rez=$this->db->QUERY($sql);
  
 }
 function _delete_template()
 {
  $rez=$this->db->QUERY("DELETE FROM pwsm_templates WHERE id=".$this->db->Q($_POST['id']));
  
 }
 
 function chk_dublicate_template($id,$code)
 {
 	$sql="SELECT * FROM pwsm_templates WHERE code='".$this->db->Q($code,1)."'";
 	if($id)$sql.=" AND id!=".$this->db->Q($id);
 	$r=$this->db->QUERY($sql);
 	return $this->db->NUM_ROWS($r);
 }
 function load_patterns2db($data)
 {
 
 $html='';
 if(isset($data)&&(count($data)))
 {
 #print_r($data);
 $never=true;
	foreach($data as $pattern)
	{
	$sql="SELECT id FROM pwsm_templates WHERE code='".$this->db->Q($pattern->code,1)."'";
	
	$temp=$this->db->ROW_Q($sql);
	    if(!$temp)
	    {
	     $this->db->QUERY("INSERT INTO pwsm_templates(code,description,status) VALUES ('".$this->db->Q($pattern->code,1)."','".$this->db->Q($pattern->description,1)."',1)");
	     $html.="<p><b>".$pattern->name."</b> - ".$pattern->description."</p>";
	     $never=false;
	    }
	}
	#die("<hr>");
if($never)$html.='<div class="error">New templates not exists in update.</div>';
 else $html='<div class="message"><h5>Loaded new templates:</h5>'.$html."</div>";
}else{
	$html.='<div class="error">No JSON File loaded!!:</div>';
	 }
         # print_r($data);
#    die();
	return $html;
 }
 function save_templates($patterns)
 {
 if(count($patterns))
 {
 $ids=Array();    
 foreach($patterns as $template_id=>$value)
 	{
 	$this->db->QUERY("UPDATE pwsm_templates SET status=".(($value=='on')?1:0)." WHERE id=".$this->db->Q($template_id));
        $ids[]=$this->db->Q($template_id);
 	}
        $this->db->QUERY("UPDATE pwsm_templates SET status=0 WHERE id NOT IN (".implode(",",$ids).")");
 }
 }
 
 
 public function get_requests($get)
 {
     
 	$where='';
	 if(isset($get['status'])&&($get['status']!='all'))
	 {

	 	$where.=" AND r.status=".$this->db->Q($get['status']);
	 }
        if(isset($get['method'])&&($get['method']!='all'))
        {
           $where.=" AND r.method='".$this->db->Q($get['method'])."'";
        }
    if(isset($get['ip'])&&(!empty($get['ip'])))$where.=" AND r.remote_addr='".$this->db->Q($get['ip'],1)."'";
    if(isset($get['query'])&&(!empty($get['query'])))$where.=" AND r.query_string like '%".$this->db->Q($get['query'],1)."%'";
    if(isset($get['from'])&&(!empty($get['from'])))$where.=" AND r.created >='".$this->db->Q($get['from'],1)."'";
    if(isset($get['to'])&&(!empty($get['to'])))$where.=" AND r.created <='".$this->db->Q($get['to'],1)."'";
 
    $order=' ORDER BY r.created DESC';
     $n=$this->db->ROW_Q("SELECT count(id) as num FROM pwsm_requests r WHERE r.object_id=".$this->db->Q($get['id'])." ".$where);
     $this->results_count=$n['num'];
     $sql="SELECT r.*
		FROM pwsm_requests r
		WHERE r.object_id=".$this->db->Q($_GET['id'])." ".$where.$order." LIMIT ".self::$results_step." OFFSET ".$get['offset'];
    # echo $sql;
	 $requests=$this->db->LIST_Q($sql);
	 return $requests;
 }
 public function get_object($id)
 {
 	return $this->db->ROW_Q("SELECT * FROM pwsm_objects WHERE id=".$this->db->Q($id));
 }
 public function remove_object_statistics($id)
 {
     $this->db->QUERY("DELETE FROM pwsm_requests WHERE object_id=".$this->db->Q($id));
 }
 public function request_statistics($get)
 {
 
 $get['offset']=0;
 $data['requests']=$this->get_requests($get);
 $data['object']=$this->get_object($get['id']);
 $data['pss']=$this;
 return $data;
 }

 static function copy_link($url,$vars=Array(),$method='GET')
 {
 	return '<a href="?q=test_form&url='.urlencode($url).((count($vars))?'&vars='.urlencode($vars):'').'&method='.$method.'" class="copy_lnk" title="copy URL to Test JS Form">Copy</a>';
 }
 static function _draw_request_status($status)
 {
 	return ($status)?'<span class="status red btn">Blocked</span>':'<span class="status green green_cl btn">Accepted</span>';
 }
 static function choise_selection($agent_id,$template_id,$ids)
 {
	foreach($ids as $d)
	{
		if(($d['object_id']==$agent_id)&&($template_id==$d['template_id'])) return ' checked';

	}
	return '';

 }
function uninstall_object($object)
{
 if($this->restore_original($object['object_source']))
 {
 unlink('backups/'.urlencode($object['object_source']));
    #//delete info about requeest statistics and object info
    $this->db->QUERY("DELETE FROM pwsm_objects WHERE id=".$this->db->Q($object['id']));
    $this->db->QUERY("DELETE FROM pwsm_requests WHERE object_id=".$this->db->Q($object['id']));
    $_SESSION['msg']='Agent code uninstalled';
    header("Location:?q=agents_list");
     exit();
      
 }else{
     	//cannot restore
     $_SESSION['error']='Uninstall programm cannot return backupfile
 	Please check permissions for backupfile: '.'backups/'.urlencode($object['object_source']).'
 	And changed project file '.$object['object_source'];
    #die("<hr>");
      header("Location:?q=agents_list");
      exit();
 }
 
}
function restore_original($filename)
{
 $backupfile=urlencode($filename);
 $content=@file_get_contents("backups/".$backupfile);

 if(strlen($content)==0)return false;
 $f=fopen($filename,"w");

 $result=fwrite($f,$content);
 fclose($f);

 return $result;
}
function save_object($source)
{
$this->db->QUERY("INSERT INTO pwsm_objects	(object_source, created,POST,GET,COOKIE,stoped_only) VALUES ('".$this->db->Q($source,1)."',".time().",1,1,1,0)");
}
function get_object_by_source($source)
{
 return $this->db->ROW_Q("SELECT * FROM pwsm_objects WHERE object_source='".$this->db->Q($source,1)."'");
}
public function alcb($type,$id,$value){
            
             $sql="UPDATE pwsm_objects SET ".$this->db->Q($type,1)."=".(($value=='true')?1:0)." WHERE id=".$this->db->Q($id);
             $this->db->QUERY($sql);
             #return 'ok';
    }
}

?>