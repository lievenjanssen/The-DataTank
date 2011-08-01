<?php
  /**
   * This file prettyprints autogenerated API Documentation.
   * and return the result of that call.
   * @package The-Datatank/docs
   * @copyright (C) 2011 by iRail vzw/asbl
   * @license AGPLv3
   * @author Pieter Colpaert   <pieter@iRail.be>
   * @author Jan Vansteenlandt <jan@iRail.be>
   */

ini_set("include_path", "../");
include_once("Config.class.php");
include_once("TDT.class.php");
include_once("modules/ProxyModules.php");


/**
 * Get all derived classes from a given class.
 * @param string $classname Classname of the class of which all the derived classes need to be found.
 * @return mixed Returns all derived classes of the $classname.
 */
class Docs {
    	
    private static function getAllDerivedClasses($classname){
	$result = array();
	foreach(get_declared_classes() as $class){
	    if(get_parent_class($class) == $classname){
		$result[] = $class;
	    }
	}
	return $result;
    }

    function GET() {

//print page
	include_once("templates/TheDataTank/header.php");
	$url = Config::$HOSTNAME . Config::$SUBDIR."TDTInfo/Modules/?format=json&proxy=1";
	$stats = "";
	$stats = json_decode(TDT::HttpRequest($url)->data);

//Test whether HttpRequest succeeded 
	if(isset($stats->module)){
	    echo "<h1>Modules and methods</h1>";
	    foreach($stats->module as $modu){
		$name = $modu->name;
		//echo "<h2><a href=\"". Config::$HOSTNAME .Config::$SUBDIR. $modu->url ."docs/\">$name</a>&nbsp;<small>(". $modu->url  .")</small></h2>\n";
		echo "<h2><a href=\"". $modu->url ."docs/\">$name</a>&nbsp;<small>(". $modu->url  .")</small></h2>\n";
		if(sizeof($modu->method) > 0){
		    echo "<ul>";
		    foreach($modu->method as $method){
			$methodname = $method->name;
			echo "<li><a href=\"". Config::$HOSTNAME . Config::$SUBDIR . "docs/$name/$methodname/\">$methodname</a> - ". $method->doc ."</li>";
		    }
		    echo "</ul>";
		}else{
		    echo "<p>No methods in this module</p>";
		}
	    }
	}else{
	    echo "Error occured: check " . $url;
	}

	echo "<h1>Errors</h1>";

	foreach(Docs::getAllDerivedClasses("AbstractTDTException") as $class){
	    echo "<h4>".$class::$error." - $class</h4>";
	    echo "<p>" .$class::getDoc() . "</p>";
	}
	include_once("templates/TheDataTank/footer.php");
    }
}


?>
