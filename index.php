<?php
/**
*Main - P.W.S.M.
*Author Roman Shneer romanshneer@gmail.com
*1.02.2012
*changed 01.11.2015
*/
ini_set("display_errors", 1);
include_once("lib/start.inc.php");

include_once("lib/pss.inc.php");
#die("<hr>");
$start=new Start;

$start->chk_installation_login();

$pss=new PSS;

$contents[]=$start->letter_from_past();

#$headers['header']= $pss->draw_menu();
$headers['footer']='<author>Copiright 2012-'.date('Y').',PHP Web Security Monitor 2.0  <a href="mailto:romanshneer@gmail.com">Author</a>&nbsp;<a href="http://romanshneer.info/pwsm/contacts.php">Contact Us</a></author>';
if(!isset($_GET['q']))$_GET['q']=null;
$data=Array();
switch($_GET['q'])
{
case 'new_agent':
 $template='new_agent';
#$contents[]=$pss->wisard_new_agent();
$headers['title']='Patching new monitored object';
break;

case 'view_file':
    $template='view_file';
    $headers['title']='View File Source';

break;
case 'uninstall_object':
    #die("<hr>");
    $template='uninstall_object';

break;
case 'new_json_load':
 $template='new_xml_load';
    $headers['title']='Security Patterns';
break;
case 'export_json':
 $template='export_json';
    $headers['title']='Security Patterns';
break;
case 'create_pattern':
    $template='new_template';
    $headers['title']='Security Patterns';
break;
case 'config':
 $template='config';

$headers['title']='Security Patterns';
break;
case 'test_form':
$template='test_form';    
$headers['title']='Test Form Tool';
break;

case 'users':
 if(isset($_GET['id']))
  {
      
  $template='user';
  }else{
       
   $template='users';
  }

$headers['title']='Users Managment';

break;
case 'about':
$template='about';
#$contents[]=$pss->about_page();
$headers['title']='About P.W.S.M.';
break;
case 'exit':
    unset($_SESSION['user']);
    header("Location:login/");
    exit();
break;
case 'request_statistics':
     $template='request_statistics';
     $headers['title']='Object statistics';
break;    

case 'agents_list':
default:
 $headers['title']='Objects list';
 $template='agents_list';
break;
}
$headers['description']='PHP Web Security Monitor 2.0 is a security filter of REQUEST PHP variables for webmaster';
$headers['keywords']='PHP, Security, Hacked site, hackers';
$headers['type']='regular';
 
include_once "actions/actions.class.php";
$Actions=new Actions;
$fn='execute_'.$template;
$data=$Actions->$fn();
 print $start->dtemplate_html($headers,$template,$data);
?>