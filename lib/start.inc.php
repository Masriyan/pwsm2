<?php
/**
*Class Start - P.W.S.M.
*templates and auth functions
*Author Roman Shneer romanshneer@gmail.com
*1.02.2012
*changed 01.11.2015
*/
session_start();
Class Start{
var $db;
        


	function chk_installation_login()
	{
	if(!$this->chk_config())$this->send2wisard();

	if(!$this->chk_db())$this->send2wisard();

	if(!$this->chk_user())$this->send2login();

	return true;
	}
    function chk_installation()
	{

	if(!$this->chk_config())$this->send2wisard();
	if(!$this->chk_db())$this->send2wisard();
        
     return true;
	}

	function send2login()
	{
            
    header("Location:login/");
	}
	function chk_config()
	{
	if(!file_exists("conf/config.php")&&!file_exists("../conf/config.php"))return false;
	else return true;
	}
	function chk_user()
	{
            
	if((isset($_SESSION['user']))||(isset($_SESSION['install'])&&($_SESSION['install']['step']==5)))
    	{
    	return true;
    	}else return false;
	}
	
	
	function chk_db()
	{

	if(isset($this->db))return $this->db;

    if(file_exists("conf/config.php"))
    {

    include_once("conf/config.php");

    include_once 'lib/'.$db_type.'/db.inc.php';

    }elseif(file_exists("../conf/config.php")){

    include_once("../conf/config.php");

    include_once '../lib/'.$db_type.'/db.inc.php';
    #die($db_type."XX<hr>");
    }
 
    $db=new DB($db_host,$db_name,$db_user,$db_pass);
    
    $this->db=$db;
#die($db);
    return $db;
    }
    function request($url)
    {
           
       if(is_callable('curl_init'))
       {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html=curl_exec($ch);
        curl_close($ch);
        return $html;   
       }else{
        return file_get_contents($url);    
       }
    }
    function send2wisard()
    {
    $arr=explode("/",$_SERVER['REQUEST_URI']);
    if(in_array('login',$arr))
    {
    array_pop($arr);array_pop($arr);
    }else{
    array_pop($arr);
    }
    $arr[]='install';
    $url_string=implode("/",$arr)."/";
    header("Location:".$url_string);
    }
function create_secure_forgot_link($user)
    {
   
    #die($user['name'].$user['email'].$user['created']);
    $url='http://'.$_SERVER['SERVER_NAME'].substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"?"))."?act=restorenow&key=".md5($user['email'].$user['created']);
    return '<a href="'.$url.'">'.$url.'</a>';
    }
    function dtemplate_html($headers,$template,$data)
    {
    switch($headers['type'])
        {

        case 'login':
        include_once '../templates/dtemplateSuccess_login.php';
        break;
        case 'install':
        include_once '../templates/dtemplateSuccess_install.php';    
        break;
        case 'ajax':
        include_once 'templates/dtemplateSuccess_ajax.php';        
        break;
        case 'regular':
        default:    
        include_once 'templates/dtemplateSuccess.php';         
            
        }

    }
    
    function letter_from_past()
    {
            if(isset($_SESSION['error']))
            {
            $msg=$_SESSION['error'];
    unset($_SESSION['error']);
    return $msg;
            }
            if(isset($_SESSION['msg']))
            {
            $msg=$_SESSION['msg'];
    unset($_SESSION['msg']);
    return $msg;
            }
            return false;
    }
 

}
?>
