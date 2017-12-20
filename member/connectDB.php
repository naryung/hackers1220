<?php
session_start();
error_reporting(E_ALL^ E_NOTICE); 
ini_set("display_errors", 1);
$connect = mysql_connect('localhost', 'root', 'localhost'); 
mysql_query("set names utf8"); 
mysql_select_db('test' ,$connect);
?>