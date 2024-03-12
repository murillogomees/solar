<?php 
	/**
	 * Order Model
	 *
	 * @version 1.0
	 * @author Onelab <hello@onelab.co> 
	 * 
	 */
	
	class FreteModel extends DataEntry
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
    			$where["id_orcamento"] = $uniqid;
    		}
    	}

    	if ($where) {
	    	$query = \DB::table(TABLE_PREFIX.TABLE_FRETE);

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
					"id_orcamento" => "",
	    		"status" => "2",
	    		"tipo_transporte" => "",
					"cotacao" => "0",			
					"rastreamento" => "",			
	    		"numero_nf" => "",
          "numero_nf_remessa" => "",
					"numero_pedido_santri" => "",
          "id_cliente_santri" => "",
					"cliente" => "",
					"filial" => "",
					"vendedor_responsavel" => "",
					"responsavel" => "",
	    		"nota_liberada" => "",	    
	    		"tipo_local" => "",				
					"endereco" => "{}",		
	    		"observacao" => "",	  
					"cif_fob" => "",
					"equipe_auxilio" => "",
					"equipamento_auxilio" => "",
          "custo_considerado" => "",	
					"produtos" => "",	
					"valor_total" => "",
					"valor_pedido" => "",
					"arquivo_nf" => "",	
					"arquivo_cotacao" => "",
					"arquivo_cotacao2" => "",
					"arquivo_cotacao3" => "",
					"data_origem" => date("Y-m-d H:i:s"),
					"data_validade" => "",
					"data_envio" => "",
					"data_previsao" => "",
          "data_previsao_fixa" => "",
					"data_entrega" => ""
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_FRETE)
		    	->insert(array(
		    		"id" => null,
						"id_orcamento" => $this->get("id_orcamento"),
		    		"status" => $this->get("status"),
		    		"tipo_transporte" => $this->get("tipo_transporte"),		
						"cotacao" => $this->get("cotacao"),	
						"rastreamento" => $this->get("rastreamento"),	
		    		"numero_nf" => $this->get("numero_nf"),
            "numero_nf_remessa" => $this->get("numero_nf_remessa"),
						"numero_pedido_santri" => $this->get("numero_pedido_santri"),
						"filial" => $this->get("filial"),
            "cliente" => $this->get("cliente"),
						"id_cliente_santri" => $this->get("id_cliente_santri"),
						"vendedor_responsavel" => $this->get("vendedor_responsavel"),	
						"responsavel" => $this->get("responsavel"),	
		    		"nota_liberada" => $this->get("nota_liberada"),		    	
		    		"tipo_local" => $this->get("tipo_local"),					
						"endereco" => $this->get("endereco"),						
						"observacao" => $this->get("observacao"),		
						"cif_fob" => $this->get("cif_fob"),
						"equipe_auxilio" => $this->get("equipe_auxilio"),
						"equipamento_auxilio" => $this->get("equipamento_auxilio"),
		    		"custo_considerado" => $this->get("custo_considerado"),		
						"produtos" => $this->get("produtos"),	
						"valor_total" => $this->get("valor_total"),	
						"valor_pedido" => $this->get("valor_pedido"),	
						"arquivo_nf" => $this->get("arquivo_nf"),	
						"arquivo_cotacao" => $this->get("arquivo_cotacao"),	
						"arquivo_cotacao2" => $this->get("arquivo_cotacao2"),
						"arquivo_cotacao3" => $this->get("arquivo_cotacao3"),
						"data_origem" => $this->get("data_origem"),
		    		"data_validade" => $this->get("data_validade"),
						"data_envio" => $this->get("data_envio"),
		    		"data_previsao" => $this->get("data_previsao"),
            "data_previsao_fixa" => $this->get("data_previsao_fixa"),
		    		"data_entrega" => $this->get("data_entrega")
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_FRETE)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
						"id_orcamento" => $this->get("id_orcamento"),
		    		"status" => $this->get("status"),
		    		"tipo_transporte" => $this->get("tipo_transporte"),	
						"cotacao" => $this->get("cotacao"),	
						"rastreamento" => $this->get("rastreamento"),	
		    		"numero_nf" => $this->get("numero_nf"),
            "numero_nf_remessa" => $this->get("numero_nf_remessa"),
						"numero_pedido_santri" => $this->get("numero_pedido_santri"),
						"filial" => $this->get("filial"),
            "id_cliente_santri" => $this->get("id_cliente_santri"),
						"cliente" => $this->get("cliente"),
						"vendedor_responsavel" => $this->get("vendedor_responsavel"),
						"responsavel" => $this->get("responsavel"),	
		    		"nota_liberada" => $this->get("nota_liberada"),		    	
		    		"tipo_local" => $this->get("tipo_local"),					
						"endereco" => $this->get("endereco"),						
						"observacao" => $this->get("observacao"),		
						"cif_fob" => $this->get("cif_fob"),
						"equipe_auxilio" => $this->get("equipe_auxilio"),
						"equipamento_auxilio" => $this->get("equipamento_auxilio"),
		    		"custo_considerado" => $this->get("custo_considerado"),	
						"produtos" => $this->get("produtos"),
						"valor_total" => $this->get("valor_total"),	
						"valor_pedido" => $this->get("valor_pedido"),	
						"arquivo_nf" => $this->get("arquivo_nf"),	
						"arquivo_cotacao" => $this->get("arquivo_cotacao"),
						"arquivo_cotacao2" => $this->get("arquivo_cotacao2"),
						"arquivo_cotacao3" => $this->get("arquivo_cotacao3"),
						"data_origem" => $this->get("data_origem"),
		    		"data_validade" => $this->get("data_validade"),
						"data_envio" => $this->get("data_envio"),
		    		"data_previsao" => $this->get("data_previsao"),
            "data_previsao_fixa" => $this->get("data_previsao_fixa"),
		    		"data_entrega" => $this->get("data_entrega")
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

	    	DB::table(TABLE_PREFIX.TABLE_FRETE)->where("id", "=", $this->get("id"))->delete();
	    	$this->is_available = false;
	    	return true;
	    }
	
	}
?>