<?php
	/**
	 * User Model
	 *
	 * @version 1.0
	 * @author Onelab <hello@onelab.co>
	 *
	 */

	class NcmModel extends DataEntry
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
					$col = "cod_ncm";
				}

	    	if ($col) {
		    	$query = DB::table(TABLE_PREFIX.TABLE_NCM)
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
	    		"cod_ncm" => "",
					"is_active" => "",
	    		"date" => date("Y-m-d H:i:s"),
					"owner" => "",
					"description" => "",
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_NCM)
		    	->insert(array(
		    		"id" => null,
		    		"cod_ncm" => $this->get("cod_ncm"),
		    		"is_active" => $this->get("is_active"),
		    		"date" => $this->get("date"),
						"owner" => $this->get("owner"),
						"description" => $this->get("description"),
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_NCM)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
		    		"cod_ncm" => $this->get("cod_ncm"),
						"is_active" => $this->get("is_active"),
		    		"date" => $this->get("date"),
						"owner" => $this->get("owner"),
						"description" => $this->get("description"),
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

	    	DB::table(TABLE_PREFIX.TABLE_NCM)->where("id", "=", $this->get("id"))->delete();
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

		/**
	     * get phone format preference
	     * @return null|string
	     */
	    public function getNumberFormat($info)
	    {
	    	if (!$this->isAvailable()) {
	    		return null;
	    	}

			return preg_replace("/[^0-9]/", "", $info);
	    }

	}
?>
