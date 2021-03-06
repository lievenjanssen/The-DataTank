<?php
/**
 * Class to delete a generic resource
 *
 * @package The-Datatank/model/resources/delete
 * @copyright (C) 2011 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jan Vansteenlandt
 */
include_once("ADeleter.class.php");
include_once("model/resources/GenericResource.class.php");

class GenericResourceDeleter extends ADeleter{
    
    public function __construct($package,$resource){
        parent::__construct($package,$resource);
    }

    /**
     * execution method
     */
    public function delete(){
        $resource = new GenericResource($this->package,$this->resource);
        $strategy = $resource->getStrategy();
        $strategy->onDelete($this->package,$this->resource);

        DBQueries::deleteForeignRelation($this->package,$this->resource);
            
        // delete any published columns entry
        DBQueries::deletePublishedColumns($this->package,$this->resource);
        
        //now the only thing left to delete is the main row
        DBQueries::deleteGenericResource($this->package, $this->resource);

        // also delete the resource entry
        DBQueries::deleteResource($this->package,$this->resource);
    }
}
?>