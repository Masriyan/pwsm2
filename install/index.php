<?php
/**
*Installator - P.W.S.M.
*Author Roman Shneer romanshneer@gmail.com
*1.02.2012
*changed 01.11.2015
*/

include_once("../lib/start.inc.php");
include_once("../lib/wisard.inc.php");
$start=new Start;
$wisard=new Wisard;
$step=(isset($_GET['step']))?$_GET['step']:0;
### wellcome2 installer ###
if(($wisard->chk_configfile()==true)&&($step!=7))$step=1000;

switch($step)
{
    case 0:
        $template='window_wellcome';    
    break;
    case 1:
        $template='window_create_config_file';
    break;
    case 2:
        $template='check_before_install';
       
    break;
    case 3:
        $template='install_db';
       
    break;
    case 4:
        
        $template='chk_tables_exists';
    break;
    case 5:
        
        $template='window_create_user';  
     
    break;
    case 6:
       $template='finall_installation';  
    break;
    case 7:
    
       $template='install_loading_patterns';  
    break;
    
    //error\hlp pages
    case 400:
        $template='user_exists_confirm';  
    break;
    case 500:
        $template='rollback';  
    break;
    case 1000:
        $template='window_wellcome0';
    break;
}

include_once "../actions/actions.class.php";
$Actions=new Actions;
$fn='execute_'.$template;
$data=$Actions->$fn();
$headers=array('title'=>'Wellcome to Installation PWSM 2.0',
               'description'=>'Wellcome to Installation PWSM 2.0',
               'keywords'=>'Wellcome to Installation PWSM 2.0',
               'type'=>'install',
               'footer'=>'Copiright 2012-'.date('Y').',PHP Web Security Monitor 2.0  <a href="mailto:romanshneer@gmail.com">Contact</a>');
               
 print $start->dtemplate_html($headers,$template,$data);
 #echo "<hr>".$wisard->step()."<hr>";
 #   print $start->template_html4install($content);
 
?>