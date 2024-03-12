<?php
	/**
	 * User Model
	 *
	 * @version 1.0
	 * @author Onelab <hello@onelab.co>
	 *
	 */

	class ProductModel extends DataEntry
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


public function select($uniqid, $type = "id")
    {
		$where = [];
    	if (is_array($uniqid)) {
    		$where = $uniqid;	
    	} if (is_int($uniqid) || ctype_digit($uniqid)) {
    		if ($uniqid > 0) {
					if ($type == "id"){
    			$where["id"] = $uniqid;
					} else {
						$where["santri_cod"] = $uniqid;
					}
    		}
    	}
			

    	if ($where) {
	    	$query = DB::table(TABLE_PREFIX.TABLE_PRODUCTS);

	    	foreach ($where as $k => $v) {
	    	    $query->where($k, "=", $v);
	    	}
		    	      
		    $query->limit(1)->select("*");
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
					"description" => "",
					"icms" => "{}",
					"origin" => "",			
					"finance" => "{}",
					"santri_cod" => "",
					"ncm" => "",
					"segment" => "",
					"product_type" => "",
					"product_model" => "",
					"producer" => "",
					"margem_product" => "",
          "margem_kit" => "",
					"garantia" => "",
					"prazo_entrega" => "",
					"liquid_cust" => "",
					"estoque" => "",
					"cust" => "",	
					"price" => "",
					"is_active" => "1",
					"is_active_icms" => "0",
					"is_active_st" => "0",
					"owner" => "",
					"description" => "",
					"peso" => "",
					"altura" => "",
					"largura" => "",
					"comprimento" => "",
					"datasheet" => "",
					"part_number" => "",
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_PRODUCTS)
		    	->insert(array(
		    		"id" => null,
		    		"is_active" => $this->get("is_active"),
						"is_active_icms" => $this->get("is_active_icms"),
						"is_active_st" => $this->get("is_active_st"),
		    		"ncm" => $this->get("ncm"),
						"origin" => $this->get("origin"),
						"santri_cod" => $this->get("santri_cod"),
						"name" => $this->get("name"),
		    		"segment" => $this->get("segment"),
		    		"description" => $this->get("description"),
						"product_type" => $this->get("product_type"),
						"garantia" => $this->get("garantia"),
						"prazo_entrega" => $this->get("prazo_entrega"),
						"product_model" => $this->get("product_model"),
						"cust" => $this->get("cust"),
						"estoque" => $this->get("estoque"),	
						"liquid_cust" => $this->get("liquid_cust"),
						"margem_product" => $this->get("margem_product"),
            "margem_kit" => $this->get("margem_kit"),	
		    		"producer" => $this->get("producer"),		    		
		    		"icms" => $this->get("icms"),
						"date" => date("Y-m-d H:i:s"),
		    		"finance" => $this->get("finance"),
						"price" => $this->get("price"),
						"peso" => $this->get("peso"),
						"altura" => $this->get("altura"),
						"largura" => $this->get("largura"),
						"comprimento" => $this->get("comprimento"),
						"datasheet" => $this->get("datasheet"),
						"part_number" => $this->get("part_number"),
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_PRODUCTS)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
		    		"is_active" => $this->get("is_active"),
						"is_active_icms" => $this->get("is_active_icms"),
						"is_active_st" => $this->get("is_active_st"),
		    		"ncm" => $this->get("ncm"),
						"name" => $this->get("name"),
						"santri_cod" => $this->get("santri_cod"),
		    		"segment" => $this->get("segment"),
						"product_type" => $this->get("product_type"),
						"product_model" => $this->get("product_model"),
						"cust" => $this->get("cust"),
						"liquid_cust" => $this->get("liquid_cust"),
						"margem_product" => $this->get("margem_product"),
            "margem_kit" => $this->get("margem_kit"),	
						"garantia" => $this->get("garantia"),
						"estoque" => $this->get("estoque"),	
						"prazo_entrega" => $this->get("prazo_entrega"),
		    		"description" => $this->get("description"),
		    		"producer" => $this->get("producer"),		    	
		    		"icms" => $this->get("icms"),
						"date" => date("Y-m-d H:i:s"),
						"origin" => $this->get("origin"),
		    		"finance" => $this->get("finance"),
						"price" => $this->get("price"),
						"peso" => $this->get("peso"),
						"altura" => $this->get("altura"),
						"largura" => $this->get("largura"),
						"comprimento" => $this->get("comprimento"),
						"datasheet" => $this->get("datasheet"),
						"part_number" => $this->get("part_number"),
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

	    	DB::table(TABLE_PREFIX.TABLE_PRODUCTS)->where("id", "=", $this->get("id"))->delete();
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
