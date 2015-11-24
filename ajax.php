<?php
/**
*Ajax engine - P.W.S.M.
*Author Roman Shneer romanshneer@gmail.com
*1.02.2012
*changed 01.11.2015
*/

include_once("lib/start.inc.php");
include_once("lib/pss.inc.php");
$start=new Start;
$start->chk_installation_login();
//$ajax=new _Ajax;
$pss=new PSS;
switch($_GET['act'])
{

 case 'request_reason':
    $template='request_reason';
 break;
 case 'chg_status':
    $template='chg_status';
 break;
 case 'chg_method':
    $template='chg_method';
 break;
 case 'chg_url':
    $template='chg_url';
 break;
 case 'chg_query_string':
    $template='chg_query_string';
 break;
 case 'chg_remote_ip':
    $template='chg_remote_ip';    
 break;
 case 'chg_date':
    $template='chg_date';    
 break;
 case 'request_more_info':
    $template='request_more_info';    
 break;
 case 'wai':
    $template='wai';    
 break;
 case 'alcb':
     $template='alcb';
 break;
 default:
 die("unknow hook");
}
include_once "actions/actions.class.php";
$Actions=new Actions;
$fn='execute_'.$template;
$data=$Actions->$fn();
 print $start->dtemplate_html(array('type'=>'ajax'),$template,$data);
?>
