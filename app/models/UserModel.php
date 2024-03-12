<?php 
	/**
	 * User Model
	 *
	 * @version 1.0
	 * @author Onelab <hello@onelab.co> 
	 * 
	 */
	
	class UserModel extends DataEntry
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
		    	$query = DB::table(TABLE_PREFIX.TABLE_USERS)
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
	    		"account_type" => "",
          "api_key" => "",
	    		"email" => uniqid()."@horustelecom.com.br",
	    		"username" => "user_".uniqid(),
	    		"password" => uniqid(),
	    		"firstname" => "",	    		
	    		"settings" => "{}",
	    		"is_active" => "1",
	    		"date" => date("Y-m-d H:i:s"),
					"data" => '{}',
					"phone" => "",
					"logotipo" => "",
					"imagem" => "",
					"address" => "",
					"cep" => "",	
					"office" => "",
					"team" => "",
          "cpf_responsavel" => "",
          "rg_responsavel" => "",
          "nome_responsavel" => "",
					"cpf/cnpj" => "",
					"owner" => "",
          "start_pw" => "0",
					"permissoes_usuarios" => "",
					"permissoes_filiais" => "",
          "estados_atuacao" => "",
					"margem_usuario" => ""
					
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_USERS)
		    	->insert(array(
		    		"id" => null,
            "api_key" => $this->get("api_key"),
		    		"account_type" => $this->get("account_type"),
		    		"email" => $this->get("email"),
		    		"username" => $this->get("username"),
		    		"password" => $this->get("password"),
		    		"firstname" => $this->get("firstname"),		    		
		    		"settings" => $this->get("settings"),
		    		"is_active" => $this->get("is_active"),
		    		"date" => $this->get("date"),
						"logotipo" => $this->get("logotipo"),
						"imagem" => $this->get("imagem"),	
						"data" => $this->get("data"),
						"phone" => $this->get("phone"),
						"office" => $this->get("office"),
						"address" => $this->get("address"),
						"cep" => $this->get("cep"),	
						"team" => $this->get("team"),
						"cpf/cnpj" => $this->get("cpf/cnpj"),
						"cpf_responsavel" => $this->get("cpf_responsavel"),
						"nome_responsavel" => $this->get("nome_responsavel"),
						"rg_responsavel" => $this->get("rg_responsavel"),
						"owner" => $this->get("owner"),
						"start_pw" => $this->get("start_pw"),
						"permissoes_usuarios" => $this->get("permissoes_usuarios"),
						"permissoes_filiais" => $this->get("permissoes_filiais"),
            "estados_atuacao" => $this->get("estados_atuacao"),
						"margem_usuario" => $this->get("margem_usuario")
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

	    	$id = DB::table(TABLE_PREFIX.TABLE_USERS)
	    		->where("id", "=", $this->get("id"))
		    	->update(array(
		    		"account_type" => $this->get("account_type"),
            "api_key" => $this->get("api_key"),
		    		"email" => $this->get("email"),
		    		"username" => $this->get("username"),
		    		"password" => $this->get("password"),
		    		"firstname" => $this->get("firstname"),		    		
		    		"settings" => $this->get("settings"),
		    		"is_active" => $this->get("is_active"),
		    		"date" => $this->get("date"),
            "logotipo" => $this->get("logotipo"),
            "imagem" => $this->get("imagem"),	
            "data" => $this->get("data"),
            "phone" => $this->get("phone"),
            "office" => $this->get("office"),
            "team" => $this->get("team"),
            "address" => $this->get("address"),
            "cep" => $this->get("cep"),		
            "cpf/cnpj" => $this->get("cpf/cnpj"),
            "cpf_responsavel" => $this->get("cpf_responsavel"),
            "nome_responsavel" => $this->get("nome_responsavel"),
            "rg_responsavel" => $this->get("rg_responsavel"),
            "owner" => $this->get("owner"),
            "start_pw" => $this->get("start_pw"),
						"permissoes_usuarios" => $this->get("permissoes_usuarios"),
						"permissoes_filiais" => $this->get("permissoes_filiais"),
            "estados_atuacao" => $this->get("estados_atuacao"),
						"margem_usuario" => $this->get("margem_usuario")
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

	    	DB::table(TABLE_PREFIX.TABLE_USERS)->where("id", "=", $this->get("id"))->delete();
	    	$this->is_available = false;
	    	return true;
	    }


        public function isMaster()
	    {
	    	if ($this->isAvailable() && in_array($this->get("account_type"), array("diretoria"))) {
	    		return true;
	    	}

	    	return false;
	    }
    
    
	    public function isAdmin()
	    {
	    	if ($this->isAvailable() && in_array($this->get("account_type"), array("diretoria", "admin"))) {
	    		return true;
	    	}

	    	return false;
	    }
		
		
			 /**
	     * Check if account has administrative privilages
	     * @return boolean 
	     */
	    public function isFunctionary()
	    {
	    	if ($this->isAvailable() && in_array($this->get("account_type"), array("diretoria", "admin","gerente","representante","supervisor","vendedor"))) {
	    		return true;
	    	}

	    	return false;
	    }
		
			/**
	     * Check if account has administrative privilages
	     * @return boolean 
	     */
	    public function isFinanceiro()
	    {
	    	if ($this->isAvailable() && in_array($this->get("account_type"), array("financeiro", "admin" , "diretoria","gerente"))) {
	    		return true;
	    	}

	    	return false;
	    }
    
    public function isSetorFinanceiro()
	    {
	    	if ($this->isAvailable() && in_array($this->get("account_type"), array("financeiro","diretoria"))) {
	    		return true;
	    	}

	    	return false;
	    }



	    /**
	     * Checks if this user can edit another user's data
	     * 
	     * @param  UserModel $User Another user
	     * @return boolean          
	     */
	    public function canEdit(UserModel $User)
	    {	
	    		  
    		if ($this->get("account_type") == "admin" || $this->get("account_type") == "diretoria" || $this->get("account_type") == "gerente"){
    			return true;    				
    		}
	    	
	    	return false;
	    }	    
		
			/**
	     * Checks if this user can edit another user's data
	     * 
	     * @param  UserModel $User Another user
	     * @return boolean          
	     */
	    public function canEditOrder(UserModel $User)
	    {	
	    		  
    		if ($this->get("account_type") == "diretoria" || $this->get("account_type") == "admin" || $this->get("account_type") == "gerente" || $this->get("account_type") == "supervisor" || $this->get("account_type") == "representante"){
    			return true;    				
    		}
	    	
	    	return false;
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


	    /**
	     * Check if user's (primary) email is verified or not
	     * @return boolean 
	     */
	    public function isEmailVerified()
	    {
	    	if (!$this->isAvailable()) {
	    		return false;
	    	}

	    	if ($this->get("data.email_verification_hash")) {
	    		return false;
	    	}

	    	return true;
	    }


	    /**
	     * Send verification email to the user
	     * @param  boolean $force_new Create a new hash if it's true
	     * @return [bool]                  
	     */
	    public function sendVerificationEmail($force_new = false)
	    {
	    	if (!$this->isAvailable()) {
	    		return false;
	    	}

	    	$hash = $this->get("data.email_verification_hash");

	    	if (!$hash || $force_new) {
	    		$hash = sha1(uniqid(readableRandomString(10), true));
	    	}


	    	// Get site settings
	    	$site_settings = \Controller::model("GeneralData", "settings");
	    	

	    	// Send mail
	    	$mail = new \Email;
	    	$mail->addAddress($this->get("email"));
	    	$mail->Subject = __("{site_name} Account Activation", [
	    		"{site_name}" => $site_settings->get("data.site_name")
	    	]);

	    	$body = "<p>" . __("Hi %s", htmlchars($this->get("firstname"))) . ", </p>"
                  . "<p>" . __("Please verify the email address {email} belongs to you. To do so, simply click the button below.", ["{email}" => "<strong>" . $this->get("email") . "</strong>"])
                  . "<div style='margin-top: 30px; font-size: 14px; color: #9b9b9b'>"
                  . "<a style='display: inline-block; background-color: #3b7cff; color: #fff; font-size: 14px; line-height: 24px; text-decoration: none; padding: 6px 12px; border-radius: 4px;' href='".APPURL."/verification/email/".$this->get("id").".".$hash."'>".__("Verify Email")."</a>"
                  . "</div>";
            $mail->sendmail($body);

	    	// Save (new) hash
	    	$this->set("data.email_verification_hash", $hash)
	    	     ->save();

	    	return true;
	    }


	    /**
	     * Set the user's (primary) email address as verified
	     */
	    public function setEmailAsVerified()
	    {
	    	if (!$this->isAvailable()) {
	    		return false;
	    	}

	    	$data = json_decode($this->get("data"));
	    	if (isset($data->email_verification_hash)) {
		    	unset($data->email_verification_hash);
		    	$this->set("data", json_encode($data))
		    	     ->update();
	    	}

	    	return true;
	    }
	}
?>