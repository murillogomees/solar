<?php 
	/**
	 * Option Model
	 *
	 * @version 1.0
	 * @author Onelab <hello@onelab.co> 
	 * 
	 */
	
	class OptionModel extends DataEntry
	{	
		/**
		 * Extend parents constructor and select entry
		 * @param mixed $uniqid Value of the unique identifier
		 */
	    public function __construct($uniqid=0, $col = "id")
	    {
	        parent::__construct();
	        $this->select($uniqid, $col = "id");
	    }



	    /**
	     * Select entry with uniqid
	     * @param  int|string $uniqid Value of the any unique field
	     * @return self       
	     */
	    public function select($uniqid, $col = "id")
	    {
	    	
	    	if ($col) {
		    	$query = DB::table(TABLE_PREFIX.TABLE_OPTIONS)
			    	      ->where($col, "=", $uniqid)
			    	      ->limit(1)
			    	      ->select("*");
		    	if ($query->count() == 1) {
		    		$resp = $query->get();
		    		$r = $resp[0];

		    		foreach ($r as $field => $value)
		    			$this->set($field, $value);

		    		$this->is_available = true;
		    	} else {
		    		$this->data = array();
		    		$this->is_available = false;
		    	}
	    	}

	    	return $this;
	    }


	    /**
	     * Extend default values
	     * @return self
	     */
	    public function extendDefaults()
	    {
	    	$defaults = array(
	    		"options_name" => uniqid(),
	    		"option_value" => "",
          "margem_kit" => "",
          "margem_un" => ""
	    	);


	    	foreach ($defaults as $field => $value) {
	    		if (is_null($this->get($field)))
	    			$this->set($field, $value);
	    	}
	    }


	    /**
	     * Insert Data as new entry
	     */
	    public function insert()
	    {
	    	if ($this->isAvailable())
	    		return false;

	    	$this->extendDefaults();

	    	$id = DB::table(TABLE_PREFIX.TABLE_OPTIONS)
		    	->insert(array(
		    		"id" => null,
		    		"option_name" => $this->get("option_name"),
		    		"option_value" => $this->get("option_value"),
            "margem_kit" => $this->get("margem_kit"),
            "margem_un" => $this->get("margem_un"),
		    	));

	    	$this->set("id", $id);
	    	$this->markAsAvailable();
	    	return $this->get("id");
	    }


	    /**
	     * Update selected entry with Data
	     */
	    public function update()
	    {
	    	if (!$this->isAvailable())
	    		return false;

	    	$this->extendDefaults();

	    	$id = DB::table(TABLE_PREFIX.TABLE_OPTIONS)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
		    		"option_name" => $this->get("option_name"),
		    		"option_value" => $this->get("option_value"),
            "margem_kit" => $this->get("margem_kit"),
            "margem_un" => $this->get("margem_un"),
		    	));

	    	return $this;
	    }


	    /**
		 * Remove selected entry from database
		 */
	    public function delete()
	    {
	    	if(!$this->isAvailable())
	    		return false;

	    	DB::table(TABLE_PREFIX.TABLE_OPTIONS)->where("id", "=", $this->get("id"))->delete();
	    	$this->is_available = false;
	    	return true;
	    }
	}
?>