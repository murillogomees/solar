<?php 
	/**
	 * Order Model
	 *
	 * @version 1.0
	 * @author Onelab <hello@onelab.co> 
	 * 
	 */
	
	class RascunhoModel extends DataEntry
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
	    	$where = [];
    	if (is_array($uniqid)) {
    		$where = $uniqid;	
    	} if (is_int($uniqid) || ctype_digit($uniqid)) {
    		if ($uniqid > 0) {
    			$where["id"] = $uniqid;
    		}
    	}

    	if ($where) {
	    	$query = \DB::table(TABLE_PREFIX.TABLE_RASCUNHO);

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
	    		"order_id" => 0,
          "santri_id" => "",
	    		"version" => 1,
	    		"status" => "2",
	    		"client" => "{}",
	    		"seller" => "{}",
	    		"branch" => "",
					"destiny" => "",
					"valorFrete" => "",
					"uf_frete" => "",
	    		"payment_details" => "{}",
	    		"product_details" => "{}",
					"products_order" => "{}",
					"power" => "",
          "comissao" => "",
          "comissao_liquida" => "",
          "margem_real" => "",
					"comissao_active" => "",
					"responsavel" => "",
					"loja_responsavel" => "",
					"order_value" => "{}",
          "order_description" => "",
					"expirate_date" => date("Y-m-d H:i:s"),
					"origem_date" => date("Y-m-d H:i:s"),
	    		"date" => date("Y-m-d H:i:s"),
					"owner" => "",
          "prazo_entrega" => "",
					"descriptionP" => ""
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_RASCUNHO)
		    	->insert(array(
		    		"id" => null,
		    		"order_id" => $this->get("order_id"),
            "santri_id" => $this->get("santri_id"),
		    		"version" => $this->get("version"),
		    		"status" => $this->get("status"),
		    		"client" => $this->get("client"),
		    		"seller" => $this->get("seller"),
		    		"branch" => $this->get("branch"),
						"destiny" => $this->get("destiny"),
						"valorFrete" => $this->get("valorFrete"),
						"uf_frete" => $this->get("uf_frete"),
						"responsavel" => $this->get("responsavel"),
						"loja_responsavel" => $this->get("loja_responsavel"),
		    		"payment_details" => $this->get("payment_details"),
		    		"product_details" => $this->get("product_details"),
						"products_order" => $this->get("products_order"),
		    		"power" => $this->get("power"),
						"order_value" => $this->get("order_value"),
            "order_description" => $this->get("order_description"),
            "comissao" => $this->get("comissao"),
            "comissao_liquida" => $this->get("comissao_liquida"),
            "margem_real" => $this->get("margem_real"),
						"comissao_active" => $this->get("comissao_active"),
		    		"expirate_date" => $this->get("expirate_date"),
						"origem_date" => $this->get("origem_date"),
						"owner" => $this->get("owner"),
		    		"date" => $this->get("date"),
            "prazo_entrega" => $this->get("prazo_entrega"),
						"descriptionP" => $this->get("descriptionP"),
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_RASCUNHO)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
		    		"order_id" => $this->get("order_id"),
            "santri_id" => $this->get("santri_id"),
		    		"version" => $this->get("version"),
		    		"status" => $this->get("status"),
		    		"client" => $this->get("client"),
		    		"seller" => $this->get("seller"),
		    		"branch" => $this->get("branch"),
						"destiny" => $this->get("destiny"),
						"valorFrete" => $this->get("valorFrete"),
						"uf_frete" => $this->get("uf_frete"),
						"responsavel" => $this->get("responsavel"),
						"loja_responsavel" => $this->get("loja_responsavel"),
		    		"payment_details" => $this->get("payment_details"),
		    		"product_details" => $this->get("product_details"),
						"products_order" => $this->get("products_order"),
		    		"power" => $this->get("power"),
						"order_value" => $this->get("order_value"),
            "order_description" => $this->get("order_description"),
            "comissao" => $this->get("comissao"),
            "comissao_liquida" => $this->get("comissao_liquida"),
            "margem_real" => $this->get("margem_real"),
						"comissao_active" => $this->get("comissao_active"),
		    		"expirate_date" => $this->get("expirate_date"),
						"origem_date" => $this->get("origem_date"),
						"owner" => $this->get("owner"),
		    		"date" => $this->get("date"),
            "prazo_entrega" => $this->get("prazo_entrega"),
						"descriptionP" => $this->get("descriptionP"),
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

	    	DB::table(TABLE_PREFIX.TABLE_RASCUNHO)->where("id", "=", $this->get("id"))->delete();
	    	$this->is_available = false;
	    	return true;
	    }
	
	}
