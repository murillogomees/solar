<?php
	/**
	 * Product Segment Model
	 *
	 * @version 1.0
	 * @author Storgetec
	 *
	 */

	class ProductSegmentModel extends DataEntry
	{
		/**
		 * Extend parents constructor and select entry
		 * @param mixed $uniqid Value of the unique identifier
		 */
	    public function __construct($uniqid=0)
	    {
	        parent::__construct();
	        $this->select($uniqid);
	    }



	    /**
	     * Select entry with uniqid
	     * @param  int|string $uniqid Value of the any unique field
	     * @return self
	     */
	    public function select($uniqid)
	    {
	    	if (is_int($uniqid) || ctype_digit($uniqid)) {
	    		$col = $uniqid > 0 ? "id" : null;
	    	} else {
	    		$col = "name";
	    	}

	    	if ($col) {
		    	$query = DB::table(TABLE_PREFIX.TABLE_PRODUCT_SEGMENTS)
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
	    		"name" => "",
	    		"field" => "{}",
					"icms" => "{}",
	    		"is_active" => "1",
					"is_active_icms" => "0",
	    		"date" => date("Y-m-d H:i:s"),
					"owner" => "",
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_PRODUCT_SEGMENTS)
		    	->insert(array(
		    		"id" => null,
		    		"name" => $this->get("name"),
		    		"field" => $this->get("field"),
						"icms" => $this->get("icms"),
		    		"is_active" => $this->get("is_active"),
						"is_active_icms" => $this->get("is_active_icms"),
						"date" => $this->get("date"),
						"owner" => $this->get("owner"),
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_PRODUCT_SEGMENTS)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
						"name" => $this->get("name"),
						"field" => $this->get("field"),
						"icms" => $this->get("icms"),
						"is_active" => $this->get("is_active"),
						"is_active_icms" => $this->get("is_active_icms"),
						"date" => $this->get("date"),
						"owner" => $this->get("owner"),
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

	    	DB::table(TABLE_PREFIX.TABLE_PRODUCT_SEGMENTS)->where("id", "=", $this->get("id"))->delete();
	    	$this->is_available = false;
	    	return true;
	    }



	    /**
	     * get date-time format preference
	     * @return null|string
	     */
	    public function getDateTimeFormat()
	    {
	    	if (!$this->isAvailable()) {
	    		return null;
	    	}

	    	$date_format = $this->get("preferences.dateformat");
	    	$time_format = $this->get("preferences.timeformat") == "24"
	    	             ? "H:i" : "h:i A";
	    	return $date_format . " " . $time_format;
		}		

	}
?>
