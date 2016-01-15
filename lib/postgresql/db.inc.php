<?php
/**
*Class DB PostgreSQL - P.W.S.M.
*db lib for p.w.s.m work
*Author Roman Shneer romanshneer@gmail.com
*1.02.2012
*Any changes at your risk and criminal responsibility
*/
/*############ database basic interface ####################*/
Class DB
{
        var $conn;
        function DB($db_host,$db_name,$db_user,$db_pass)
        {
        #global $db_host,$db_name,$db_user,$db_pass;
        
        #print $db_host.":".$db_user.":".$db_pass."<hr>";
        $dbstring="host=".$db_host." port=5432 dbname=".$db_name." user=".$db_user." password=".$db_pass;
        
        if(!$this->conn = @pg_connect($dbstring))
        {
        die("<div style='color:red'>impossible connect to db server ".$db_host." dbname ".$db_name."</div>");
        exit();
        }
        
        }
        function redirect($f)
        {
        header("Location:".$f);
        exit();
        }
        #############################
        function QUERY($sql)
        {
         #print $sql."\n";

        $result=pg_query($sql);
        #print $result."<hr>";
        if($result)return $result;
        else $this->log_db_error($sql,pg_last_error($this->conn));
        }
        #############################
        function LIST_Q($sql)
        {
        #print $sql."<hr>";
        $result=$this->QUERY($sql);

        if(pg_num_rows($result)==0)return false;

        while($row=pg_fetch_assoc($result))
                {
                $data[]=$row;
                }

        return $data;
        }
        ###########################
        function ROW_Q($sql)
        {
        $result=$this->QUERY($sql);
        if(@pg_num_rows($result)==0)return false;

        return pg_fetch_assoc($result);
        }
        function Q($sql,$str=false)
        {
        if(($str==false)&&(!is_integer($sql)))
		{
			$value=-1;
		}
        return pg_escape_string($sql);
        }
        function log_db_error($sql,$message)
        {
        print "<div style='border:solid black 1px;'><div style='border:solid blue 1px;'>".$sql."</div><div style='border:solid red 1px;'>".$message."</div><div style='border:solid green 1px;'>".date("h:i d-m-y")."</div></div><br><br>\n";
        #$f=fopen("../conf/sql_error.html","a");
        #fwrite($f,"<div style='border:solid black 1px;'><div style='border:solid blue 1px;'>".$sql."</div><div style='border:solid red 1px;'>".$message."</div><div style='border:solid green 1px;'>".date("h:i d-m-y")."</div></div><br><br>\n");
        #fclose($f);
        }
        function NUM_ROWS($result)
        {
        	return pg_num_rows($result);
        }
}
?>