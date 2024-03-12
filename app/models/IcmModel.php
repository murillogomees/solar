<?php
	/**
	 * User Model
	 *
	 * @version 1.0
	 * @author Onelab <hello@onelab.co>
	 *
	 */

	class IcmModel extends DataEntry
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
					$col = "uf_beggin";
				}

				if ($col) {
					$query = DB::table(TABLE_PREFIX.TABLE_ICMS)
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
	    		"uf_beggin" => "",
	    		"ac" => "",
	    		"al" => "",
	    		"ap" => "",
	    		"am" => "",
	    		"ba" => "",
	    		"ce" => "",
	    		"df" => "",
	    		"es" => "",
					"go" => "",
					"ma" => "",
					"mt" => "",
					"ms" => "",
					"mg" => "",
					"pa" => "",
					"pb" => "",
					"pr" => "",
					"pe" => "",
					"pi" => "",
					"rj" => "",
					"rn" => "",
					"rs" => "",
					"ro" => "",
					"rr" => "",
					"sc" => "",
					"sp" => "",
					"se" => "",
					"to" => "",
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_ICMS)
		    	->insert(array(
		    		"id" => null,
		    		"uf_beggin" => $this->get("uf_beggin"),
		    		"ac" => $this->get("ac"),
		    		"al" => $this->get("al"),
		    		"ap" => $this->get("ap"),
		    		"am" => $this->get("am"),
		    		"ba" => $this->get("ba"),
		    		"ce" => $this->get("ce"),
		    		"df" => $this->get("df"),
		    		"es" => $this->get("es"),
						"go" => $this->get("go"),
						"ma" => $this->get("ma"),
						"mt" => $this->get("mt"),
						"ms" => $this->get("ms"),
						"mg" => $this->get("mg"),
						"pa" => $this->get("pa"),
						"pb" => $this->get("pb"),
						"pr" => $this->get("pr"),
						"pe" => $this->get("pe"),
						"pi" => $this->get("pi"),
						"rj" => $this->get("rj"),
						"rn" => $this->get("rn"),
						"rs" => $this->get("rs"),
						"ro" => $this->get("ro"),
						"rr" => $this->get("rr"),
						"sc" => $this->get("sc"),
						"sp" => $this->get("sp"),
						"se" => $this->get("se"),
						"to" => $this->get("to"),
						"owner" => $this->get("owner"),
						"date" => date("Y-m-d H:i:s"),
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_ICMS)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
		    		"uf_beggin" => $this->get("uf_beggin"),
		    		"ac" => $this->get("ac"),
		    		"al" => $this->get("al"),
		    		"ap" => $this->get("ap"),
		    		"am" => $this->get("am"),
		    		"ba" => $this->get("ba"),
		    		"ce" => $this->get("ce"),
		    		"df" => $this->get("df"),
		    		"es" => $this->get("es"),
						"go" => $this->get("go"),
						"ma" => $this->get("ma"),
						"mt" => $this->get("mt"),
						"ms" => $this->get("ms"),
						"mg" => $this->get("mg"),
						"pa" => $this->get("pa"),
						"pb" => $this->get("pb"),
						"pr" => $this->get("pr"),
						"pe" => $this->get("pe"),
						"pi" => $this->get("pi"),
						"rj" => $this->get("rj"),
						"rn" => $this->get("rn"),
						"rs" => $this->get("rs"),
						"ro" => $this->get("ro"),
						"rr" => $this->get("rr"),
						"sc" => $this->get("sc"),
						"sp" => $this->get("sp"),
						"se" => $this->get("se"),
						"to" => $this->get("to"),
						"owner" => $this->get("owner"),
						"date" => date("Y-m-d H:i:s"),
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

	    	DB::table(TABLE_PREFIX.TABLE_ICMS)->where("id", "=", $this->get("id"))->delete();
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
