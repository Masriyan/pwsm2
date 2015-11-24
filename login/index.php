<?php
/**
*Login - P.W.S.M.
*Author Roman Shneer romanshneer@gmail.com
*1.02.2012
*changed 01.11.2015
*/
include_once("../lib/start.inc.php");
$start=new Start;
$start->chk_installation();
if(!$start->chk_user())
{
    
 if((isset($_GET['act']))&&($_GET['act']=='restore'))$template='restore_form';
 elseif((isset($_GET['act']))&&($_GET['act']=='restorenow')&&(isset($_GET['key'])))$template='restorenow_form';
 else $template='login_form';

}else{
	header("Location:".substr($_SERVER['REQUEST_URI'],0,strlen($_SERVER['REQUEST_URI'])-6));
	exit();
}


$headers['footer']='Copiright 2012-'.date('Y').',PHP Web Security Monitor 2.0,Roman Shneer   <a href="mailto:romanshneer@gmail.com">Contact</a>';
$headers['title']='Authorisation';
$headers['description']='PHP Web Security Monitor 2.0 is a security filter and monitor of REQUEST PHP variables for webmaster.';
$headers['keywords']='PHP, Security, hacked site, hackers';
$headers['type']='login';
#print $start->template_html($headers,$html);
include_once "../actions/actions.class.php";
$Actions=new Actions;
$fn='execute_'.$template;
$data=$Actions->$fn();
 print $start->dtemplate_html($headers,$template,$data);
?>