<?php
/* Copyright (C) 2011 by iRail vzw/asbl
 *
 * Author: Pieter Colpaert <pieter aŧ iRail.be>
 * License: AGPLv3
 *
 * This file prettyprints autogenerated API Documentation
 */

ini_set("include_path", "../");
include_once("Config.class.php");

//get the right variables or redirect to home
if(!isset($_GET["module"]) || !isset($_GET["method"])){
     header("Location: /");
     exit(0);
}

$module = $_GET["module"];
$method = $_GET["method"];

//include the right class
include_once("modules/" . $module . "/" . $method .".class.php");
include_once("templates/TheDataTank/header.php");

echo "<h1>" . $module."/". $method ."</h1>";
//get a sequence of the parameters
$args = "";
if(sizeof($method::getRequiredParameters()) > 0){
     $params = $method::getRequiredParameters();
     $args="?" . $params[0] . "=...";
     $i = 0;
     foreach($params as $var){
	  if($i != 0){
	       $args .= "&$var=...";
	  }
	  $i++;
     }
}

$url = Config::$HOSTNAME . "$module/$method/$args";
echo "<a href=\"$url\">$url</a>";
echo "<h3>Description</h3>";
echo $method::getDoc();
if(sizeof($method::getParameters())>0){
     echo "<h3>All possible parameters:</h3>";
     echo "<ul>\n";
     foreach($method::getParameters() as $var => $doc){
	  echo "<li><strong>$var:</strong> $doc\n";
     }
     echo "</ul>\n";
}else{
     echo "<h3>This method has no parameters.</h3>";
}

echo "<br/>";
echo "<a href=\"/docs/\">&laquo; Back to the datasets</a>";
include_once("templates/TheDataTank/footer.php");
?>