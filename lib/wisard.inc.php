<?php
/**
*Class Wisard - P.W.S.M.
*Installer functions
*Author Roman Shneer romanshneer@gmail.com
*1.02.2012
*changed 01.11.2015
*/
Class Wisard{
var $step=0;
var $tables;
    function Wisard()
    {

    $this->tables['mysql']=Array('pwsm_objects'=>"CREATE TABLE `pwsm_objects` (
  `id` bigint(20) NOT NULL auto_increment,
  `object_source` varchar(1024) collate utf8_bin NOT NULL,
  `monitor_status` tinyint(4) NOT NULL default '0',
  `created` bigint(9) default NULL,
  `POST` tinyint(1) NOT NULL default '0',
  `GET` tinyint(1) NOT NULL default '0',
  `COOKIE` tinyint(1) NOT NULL default '0',
  `stoped_only` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;",
'pwsm_requests'=>"CREATE TABLE `pwsm_requests` (
  `id` bigint(20) NOT NULL auto_increment,
  `url` varchar(1024) collate utf8_bin NOT NULL,
  `method` varchar(7) collate utf8_bin NOT NULL,
  `query_string` varchar(500) collate utf8_bin NOT NULL,
  `reason` varchar(512) collate utf8_bin NOT NULL,
  `status` tinyint(4) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `remote_addr` varchar(50) collate utf8_bin NOT NULL,
  `created` bigint(20) NOT NULL,
  `vars` text collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `folder_id` (`object_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7643 DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;",
'pwsm_templates'=>"CREATE TABLE `pwsm_templates` (
  `id` mediumint(9) NOT NULL auto_increment,
  `description` text collate utf8_bin NOT NULL,
  `code` text collate utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL default 1,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;",

'pwsm_users'=>"CREATE TABLE `pwsm_users` (
  `id` mediumint(9) NOT NULL auto_increment,
  `pass` varchar(32) collate utf8_bin default NULL,
  `email` varchar(512) collate utf8_bin NOT NULL,
  `created` bigint(20) NOT NULL,
  `chg_pass_time` bigint(20) NOT NULL,
  
  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;"
);
  
	$this->tables['postgresql']=Array(
'pwsm_objects'=>'CREATE TABLE pwsm_objects
(
  id serial NOT NULL,
  object_source character varying(1024),
  monitor_status smallint NOT NULL DEFAULT 0,
  created bigint,
  POST tinyint,
  GET tinyint,
  COOKIE tinyint,
  stoped_only,
  CONSTRAINT pwsm_objects_id_idx PRIMARY KEY (id)
)
WITH (OIDS=FALSE);',
'pwsm_requests'=>'CREATE TABLE pwsm_requests
(
  id bigserial NOT NULL,
  url character varying(1024),
  method character varying(7),
  query_string character varying(500),
  reason character varying(512),
  status smallint NOT NULL DEFAULT 0,
  object_id bigint,
  remote_addr character varying(50),
  created bigint,
  vars text,
  CONSTRAINT pwsm_requests_id_idx PRIMARY KEY (id)
)
WITH (OIDS=FALSE);',
  'pwsm_templates'=>'CREATE TABLE pwsm_templates
(
  id serial NOT NULL,
  code text,
  description text,
  status tinyint,
  CONSTRAINT pwsm_templates_id_idx PRIMARY KEY (id)
)
WITH (OIDS=FALSE);',
'CREATE INDEX pwsm_requests_object_id_idx
  ON pwsm_requests
  USING btree
  (object_id);
 CREATE INDEX pwsm_requests_template_id_idx
  ON pwsm_requests
  USING btree
  (template_id); 
  ',
  'pwsm_users'=>'CREATE TABLE pwsm_users
(
  id serial NOT NULL,
  pass character varying(32),
  "email" character varying(512),
  created bigint,
  chg_pass_time bigint,
  CONSTRAINT pwsm_users_id_idx PRIMARY KEY (id)
)
WITH (OIDS=FALSE);'
);
    }
    
    ### test connection to specified db server ###
    function chk_db_connect($post)
    {
            if($post['dbtype']=='mysql')
            {
                    $conn=@mysql_connect($post['host'],$post['user'],$post['pass']);
                    return @mysql_stat($conn);
            }elseif($post['dbtype']=='postgresql')
            {
                    $conn=pg_connect("host=".$post['host']." port=5432 dbname=template1 user=".$post['user']." password=".$post['pass']);

                    return $conn;
            }
    }
	### test connection to specified database resource###
    function chk_if_db_exists($post)
    {
      if($post['dbtype']=='mysql')
      {
      	return mysql_select_db($post['dbname']);
      }else{
      pg_connection_status();
      }
    }
    ### checking if config file exists ###
    function chk_configfile()
    {
    return file_exists("../conf/config.php");
    }
    ### creation config file via data gived by user ###
    function config_dir_writeble()
    {
        $config_file="../conf/config.php";
    $config_file_dir=substr($config_file,0,strlen($config_file)-10);
    
        if(!is_writable($config_file_dir))
        {

        return false;
        }else{
         return true;   
        }
    }
    function create_configfile($post)
    {
        //check connection
    
    //write config file
    $_SESSION['post']=$post;
    $config_file="../conf/config.php";
    $config_file_dir=substr($config_file,0,strlen($config_file)-10);
    
        if(!is_writable($config_file_dir))
        {

        return false;
        }
       $f=fopen($config_file,"w");
       fwrite($f,"<?php

       $"."db_host='".$post['host']."';
       $"."db_name='".$post['dbname']."';
       $"."db_user='".$post['user']."';
       $"."db_pass='".$post['pass']."';
       $"."db_type='".$post['dbtype']."';




       ?>");
    fclose($f);
    return file_exists("../conf/config.php");
     }
    ### delete config file ###
    function delete_config_file()
    {
            @unlink("../conf/config.php");
    }
    function check_connect($post)
    {
            if($post['dbtype']=='mysql')
            {

            $conn=@mysql_connect($post['host'],$post['user'],$post['pass']);
            return $conn;
            #return $conn;
            }else{
            $conn=@pg_connect("host=".$post['host']." port=5432 user=".$post['user']." password=".$post['pass']);
            return $conn;
            }
    }
    ### check & connect to specified database resourse ###
    function db_exists($dbname)
    {
            if($_SESSION['post']['dbtype']=='mysql')
            {

            $conn=mysql_connect($_SESSION['post']['host'],$_SESSION['post']['user'],$_SESSION['post']['pass']);
            return mysql_select_db($dbname,$conn)	;
            #return $conn;
            }else{
    $conn=@pg_connect("host=".$_SESSION['post']['host']." port=5432 dbname=".$dbname." user=".$_SESSION['post']['user']." password=".$_SESSION['post']['pass']);
            return $conn;
            }

    }
    ### creating new database ###
    function create_new_db($dbname)
    {

   # $this->nextstep();
    $sql="CREATE DATABASE ".$this->Q($dbname,1);
$conn=$this->dbconnect_root();
    $res=$this->QUERY($sql,$conn);
    return $res;
    }
    ### drop new database ###
    function drop_db($dbname)
    {

    $rez=$this->QUERY("DROP DATABASE ".$this->Q($dbname,1),$this->dbconnect_root());
    return $rez;
    }
    ### db connection to main db ###
    function dbconnect_root()
    {
            if($_SESSION['post']['dbtype']=='mysql')
            {

         $conn=mysql_connect($_SESSION['post']['host'],$_SESSION['post']['user'],$_SESSION['post']['pass']);
             mysql_select_db($_SESSION['post']['dbname'],$conn);
            }elseif($_SESSION['post']['dbtype']=='postgresql')
            {

                    $dbstring="host=".$_SESSION['post']['host']." port=5432 dbname=template1 user=".$_SESSION['post']['user']." password=".$_SESSION['post']['pass'];

                    $conn=pg_connect($dbstring);
            }
            return $conn;
    }
    ### db connection to specified db ###
    function dbconnect()
    {
            #$post=$_SESSION['post'];
            if($_SESSION['post']['dbtype']=='mysql')
            {
             $conn=mysql_connect($_SESSION['post']['host'],$_SESSION['post']['user'],$_SESSION['post']['pass']);
             mysql_select_db($_SESSION['post']['dbname'],$conn);
             $this->dbtype=$_SESSION['post']['dbtype'];
            }elseif($_SESSION['post']['dbtype']=='postgresql')
            {
            $dbstring="host=".$_SESSION['post']['host']." port=5432 dbname=".$_SESSION['post']['dbname']." user=".$_SESSION['post']['user']." password=".$_SESSION['post']['pass'];
            $conn=pg_connect($dbstring);
            $this->dbtype=$_SESSION['post']['dbtype'];
            }
            return $conn;
    }
    ### db func 4 query ###
    function QUERY($sql,$conn)
    {
            #$conn=$this->dbconnect();
            if($_SESSION['post']['dbtype']=='mysql')
            {
            return mysql_query($sql,$conn);
            }elseif($_SESSION['post']['dbtype']=='postgresql')
            {
            return pg_query($conn,$sql) or print ($sql."<hr>".pg_last_error())."<hr>";
            }
    }
    ### db func return one element of result - array ###
    function ROW_Q($sql,$conn)
    {
       # echo $sql;
            $result=$this->QUERY($sql,$conn);
          
            if($this->dbtype=='mysql')
            {
                 # print_r($result);
            return ($result)?mysql_fetch_assoc($result):$result;
            }elseif($this->dbtype=='postgresql'){
            return ($result?pg_fetch_assoc($result):$result);
            }
    }
    ### db func for num_rows ###
    function affected_rows($res)
    {
            if($_SESSION['post']['dbtype']=='mysql')
            {
            return mysql_affected_rows($res);
            }elseif($_SESSION['post']['dbtype']=='postgresql')
            {
            return pg_affected_rows($res);
            }
    }
### check if specified table exists ###
    function chk_table_exists($table,$conn)
    {

    if($_SESSION['post']['dbtype']=='mysql')
            $rez=$this->QUERY("SELECT 1 FROM ".$this->Q($table,1)."",$conn);
    elseif($_SESSION['post']['dbtype']=='postgresql')
            $rez=$this->QUERY("select * from pg_tables where schemaname='public' and tablename='".$table."';",$conn);
return @$this->affected_rows($rez);
    }
    ### check if tables exists and create if not ###
    function chk_tables_exists()
    {

    $conn=$this->dbconnect();
$html='';
            foreach($this->tables[trim($_SESSION['post']['dbtype'])] as $table=>$value)
            {
        $r=$this->chk_table_exists($table,$conn);

                    if(!$r&&($this->QUERY($value,$conn)))
                            {
                                    #print $r."<hr>";
                                    $html.='<div class="message">Table '.$table.' created'."</div>";
                            }else{
                                    $html.='<div class="message error">Table '.$table.' already exists'."</div>";
                            }

            }
            #die($html);
            $this->nextstep();
            return $html;
    }
function load_patterns2db($data)
 {
  $conn=$this->dbconnect();
 $answer=Array();
 $html='';
 if(isset($data['patterns']['pattern']))
 {
 #die("<hr>");
 $never=true;
	foreach($data['patterns']['pattern'] as $pattern)
	{
	$sql="SELECT id FROM pwsm_templates WHERE code='".$this->Q($pattern->code,1)."'";
	#print $sql."<hr>";
	$temp=$this->ROW_Q($sql,$conn);
	    if(!$temp)
	    {
	     $this->QUERY("INSERT INTO pwsm_templates(code,description) VALUES ('".$this->Q($pattern->code,1)."','".$this->Q($pattern->description,1)."')",$conn);
	     $html.="<p><b>".htmlspecialchars($pattern->code)."</b> - ".$pattern->description."</p>";
	     $never=false;
	    }
	}
	#$answer['msgs'][]='<h5>Loaded new templates:</h5>'.$html."</div>";
if($never)$answer['errors'][]='New templates not exists in update.';
 else $answer['msgs'][]='<h5>Loaded new templates:</h5>'.$html;
}else{
	$answer['errors'][]='<div class="error">No JSON File loaded!!:</div>';
	 }
	return $answer;
 }
    #### db func security for escape string ###
    function Q($value,$str=false)
    {

    if(($str==false)&&(!is_integer($value)))$value=-1;

    if($_SESSION['post']['dbtype']=='mysql')
            {
            return mysql_escape_string($value);
            }elseif($_SESSION['post']['dbtype']=='postgresql')
            {
            return pg_escape_string($value);
            }
    }
}
?>