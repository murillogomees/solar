<?php
	/**
	 * User Model
	 *
	 * @version 1.0
	 * @author Onelab <hello@onelab.co>
	 *
	 */

	class ComissionamentoModel extends DataEntry
	{

    
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
		    	$query = DB::table(TABLE_PREFIX.TABLE_COMISSIONAMENTOS)
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
 
    
    
    
	    public function extendDefaults()
	    {
	    	$defaults = array(
          "id_orcamento" => "",
					"status" => "",
	    		"pedido_santri" => "",
	    		"nota_fiscal" => "",
	    		"valor_pedido_santri" => "",
	    		"id_cliente_santri" => "",
	    		"razao_social" => "",
					"cnpj" => "",
	    		"telefone" => "",
          "link_comprovante" => "",
	    		"dados_pagamento" => "",
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_COMISSIONAMENTOS)
		    	->insert(array(
		    		"id" => null,
            "id_orcamento" => $this->get("id_orcamento"),
						"status" => $this->get("status"),
		    		"pedido_santri" => $this->get("pedido_santri"),
		    		"nota_fiscal" => $this->get("nota_fiscal"),
		    		"valor_pedido_santri" => $this->get("valor_pedido_santri"),
		    		"id_cliente_santri" => $this->get("id_cliente_santri"),
		    		"razao_social" => $this->get("razao_social"),
						"cnpj" => $this->get("cnpj"),
		    		"telefone" => $this->get("telefone"),
            "link_comprovante" => $this->get("link_comprovante"),
		    		"dados_pagamento" => $this->get("dados_pagamento"),
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_COMISSIONAMENTOS)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
            "id_orcamento" => $this->get("id_orcamento"),
						"status" => $this->get("status"),
		    		"pedido_santri" => $this->get("pedido_santri"),
		    		"nota_fiscal" => $this->get("nota_fiscal"),
		    		"valor_pedido_santri" => $this->get("valor_pedido_santri"),
		    		"id_cliente_santri" => $this->get("id_cliente_santri"),
		    		"razao_social" => $this->get("razao_social"),
						"cnpj" => $this->get("cnpj"),
		    		"telefone" => $this->get("telefone"),
            "link_comprovante" => $this->get("link_comprovante"),
		    		"dados_pagamento" => $this->get("dados_pagamento"),
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

	    	DB::table(TABLE_PREFIX.TABLE_COMISSIONAMENTOS)->where("id", "=", $this->get("id"))->delete();
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
