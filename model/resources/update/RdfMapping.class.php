<?php

/**
 * This will add ontological information to a 
 * @package The-Datatank/model/resources/actions
 * @copyright (C) 2011 by iRail vzw/asbl
 * @license AGPLv3
 * @author Pieter Colpaert
 */
include_once("AUpdater.class.php");

class RdfMapping extends AUpdater {
    
    private $params = array();

    public function __construct($package, $resource) {
        parent::__construct($package, $resource);
    }

    public function getParameters() {
        return array(
            "update_type" => "...",
            "rdf_mapping_method" => "The method by which the rdf should be mapped.",
            "rdf_mapping_bash" => "If this is set, that indicates that there are multiple related resources to be mapped.",
            "rdf_mapping_class" => "The RDF class to map to the resource.",
            "rdf_mapping_nmsp" => "The namespace of the RDF mapping class."
        );
    }

    public function getRequiredParameters() {
        return array("rdf_mapping_method");
    }

    public function getDocumentation() {
        return "This class will assign a RDF mapping to an URI";
    }

    protected function setParameter($key, $value) {
        $this->params[$key] = $value;
    }

    public function update() {
  
        $rdfmapper = new RDFMapper();
        //need full path for adding semantics!!
        $resource = RequestURI::getInstance()->getRealWorldObjectURI();
        
        $rdfmapper->update($this->package, $resource, $this->params);

    }

}

?>