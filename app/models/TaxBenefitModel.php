<?php
	/**
	 * User Model
	 *
	 * @version 1.0
	 * @author Onelab <hello@onelab.co>
	 *
	 */

	class TaxBenefitModel extends DataEntry
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
		    	$query = DB::table(TABLE_PREFIX.TABLE_BENEFITS)
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
	    		"is_active" => "1",
	    		"uf_origin" => "",
	    		"uf_destiny" => "{}",
					"ncm" => "{}",
	    		"benefits" => "{}",
					"description" => "",
	    		"tax_profiles" => "{}",	  
							"tax_aliquota" => "{}",	
						"tax_base" => "{}",	
						"tax_apuracao" => "{}",	
					"nota_fiscal" => "{}",
	    		"owner" => "",
	    		"date" => date("Y-m-d H:i:s"),
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_BENEFITS)
		    	->insert(array(
		    		"id" => null,
		    		"name" => $this->get("name"),
		    		"is_active" => $this->get("is_active"),
		    		"uf_origin" => $this->get("uf_origin"),
		    		"uf_destiny" => $this->get("uf_destiny"),
						"ncm" =>  $this->get("ncm"),
		    		"benefits" => $this->get("benefits"),
						"description" => $this->get("description"),
		    		"tax_profiles" => $this->get("tax_profiles"),	
						"tax_aliquota" => $this->get("tax_aliquota"),	
						"tax_base" => $this->get("tax_base"),	
						"tax_apuracao" => $this->get("tax_apuracao"),	
						"nota_fiscal" => $this->get("nota_fiscal"),	
		    		"owner" => $this->get("owner"),
		    		"date" => $this->get("date"),
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_BENEFITS)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
						"name" => $this->get("name"),
		    		"is_active" => $this->get("is_active"),
		    		"uf_origin" => $this->get("uf_origin"),
		    		"uf_destiny" => $this->get("uf_destiny"),
		    		"benefits" => $this->get("benefits"),
						"description" => $this->get("description"),
						"ncm" =>  $this->get("ncm"),
		    		"tax_profiles" => $this->get("tax_profiles"),	
								"tax_aliquota" => $this->get("tax_aliquota"),	
						"tax_base" => $this->get("tax_base"),	
						"tax_apuracao" => $this->get("tax_apuracao"),	
						"nota_fiscal" => $this->get("nota_fiscal"),	
		    		"owner" => $this->get("owner"),
		    		"date" => $this->get("date"),
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

	    	DB::table(TABLE_PREFIX.TABLE_BENEFITS)->where("id", "=", $this->get("id"))->delete();
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
