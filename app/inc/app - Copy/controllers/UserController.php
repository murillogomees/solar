<?php
/**
 * User Controller
 */
class UserController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $Route = $this->getVariable("Route");
        $AuthUser = $this->getVariable("AuthUser");

        // Auth
        if (!$AuthUser){
            header("Location: ".APPURL."/login");
            exit;
        } else if ($AuthUser->get("is_active") == 0) {
            header("Location: ".APPURL."/aguarde");
            exit;
        } else if (!$AuthUser->canEditOrder($AuthUser)) {
            header("Location: ".APPURL."/order");
            exit;
        }


        $User = Controller::model("User");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/users");
                exit;
            }
					
						if($User->get("id") == "888"){
							 header("Location: ".APPURL."/users");
               exit;
						}
        }

				if (!$AuthUser->isAdmin($AuthUser)){
					if ($User->get('office') != $AuthUser->get('office') || $User->get('account_type') == 'admin' || $User->get('account_type') == 'gerente' || $User->get('account_type') == 'supervisor') { 
						if($AuthUser->get('account_type') != 'gerente'){
						  header("Location: ".APPURL."/users");
              exit;
						}
						
					}
				}
			
     
       $Users = Controller::model("Users");
       $Users->orderBy("id","DESC")
				     ->where(DB::raw("is_active = '1' "))
             ->fetchData();
			
				foreach($Users->getDataAs("User") as $US){
					 $ArrayUsuarios[] =  array( 
							"id" => $US->get("id"),
							"nome" => $US->get("firstname")
					 ); 
				}
			
			  $this->setVariable("ArrayUsuarios", $ArrayUsuarios);			
			
			 $Filial = Controller::model("Branchs");
			 $Filial->orderBy("id","DESC")
				 			->where('is_active', '=', '1');	
			
			  if($AuthUser->get('account_type') == "supervisor"){
				  $Filial->where('name', '=', $AuthUser->get('office'));					
			  }      
			
        $Filial->fetchData();
			
				foreach($Filial->getDataAs("Branch") as $US){
					 $ArrayFiliais[] =  array( 
							"id" => $US->get("id"),
							"nome" => $US->get("name")
					 ); 
				}
			
			  $this->setVariable("ArrayFiliais", $ArrayFiliais);		
			
        $Branch = Controller::model("Branchs");
        $Branch->orderBy("name","DESC")
                 ->fetchData();
      
        $this->setVariable("Branch", $Branch);
        $this->setVariable("User", $User);


        if (Input::post("action") == "save") {
            $this->save();
        } else if (Input::post("action") == "generator") {
            $this->generator();
        } else if (Input::post("action") == "login") {
            $this->login($User);
        }

        $this->view("user");
    }
  
	
	
	
     private function generator($qtCaracteres = 11)
  {
     $this->resp->result = 0;
    //Letras minúsculas embaralhadas
    $lower = str_shuffle('abcdefghijklmnopqrstuvwxyz');
 
    //Letras maiúsculas embaralhadas
    $upper = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
 
    //Números aleatórios
    $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
    $numbers .= 1234567890;
 
    //Caracteres Especiais
    $special = str_shuffle('!@#$%*-');
 
    //Junta tudo
    $characters = $upper.$lower.$numbers.$special;
 
    //Embaralha e pega apenas a quantidade de caracteres informada no parâmetro
    $password = substr(str_shuffle($characters), 0, $qtCaracteres);
     
     $Usuarios = Controller::model("Users");
     $Usuarios->orderBy("id", "DESC")
              ->where("api_key","<>","")
              ->fetchData();
     $hash = hash('sha256', $password);
     foreach($Usuarios->getDataAs("User") as $u){
       if ($u->get("api_key") != $hash){
         $hash = $hash;
       } else {
         $hash = "Em Branco";
       }
     }
     
    //Retorna a senha com a criptografada com SHA2
    $this->resp->variavelhash = $hash;    
     
    $this->resp->result = 1;
    $this->jsonecho(); 
}
  

    /**
     * Save (new|edit) user
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
			   
        $AuthUser = $this->getVariable("AuthUser");
        $User = $this->getVariable("User");
			
        // Check if this is new or not
        $is_new = !$User->isAvailable();

        // Check required fields
        $required_fields = ["email", "firstname","cpf"];
        if ($is_new) {
            $required_fields[] = "password";
            $required_fields[] = "password-confirm";
        }

        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Missing some of required data.");
                $this->jsonecho();
            }
        }

        // Check email
        if (!filter_var(Input::post("email"), FILTER_VALIDATE_EMAIL)) {
            $this->resp->msg = __("E-mail inválido.");
            $this->jsonecho();
        }

        $u = Controller::model("User", Input::post("email"));
        if ($u->isAvailable() && $u->get("id") != $User->get("id")) {
            $this->resp->msg = __("E-mail já cadastrado.");
            $this->jsonecho();
        }
			
      
        $Users = Controller::model("Users");
             $Users->orderBy("id","DESC")
               ->fetchData();
      
        foreach($Users->getDataAs("User") as $u){
          if ($u->get("api_key") == Input::post("api_key")) {
					 if($u->get("id") != $User->get("id")){
						 $this->resp->msg = __("API key já cadastrada, favor gerar outro.");
           	 $this->jsonecho();
					 }           
          }
        } 
      
        

        // Check pass.
        if (mb_strlen(Input::post("password")) > 0) {
            if (mb_strlen(Input::post("password")) < 6) {
                $this->resp->msg = __("A senha deve conter no mínimo 6 dígitos!");
                $this->jsonecho();
            }

            if (Input::post("password-confirm") != Input::post("password")) {
                $this->resp->msg = __("Senha de confirmação inválida!");
                $this->jsonecho();
            }
        }
      
        $clearFormatCnpj= preg_replace("/[^0-9]/","", Input::post("cpf"));
         $clearFormatTel = preg_replace("/[^0-9]/","", Input::post("phone")); 

        // Check CPF.
        if (mb_strlen(Input::post("cpf")) > 0) {
            if (mb_strlen(Input::post("cpf")) < 11) {
                $this->resp->msg = __("CPF precisa ter no mínimo 11 dígitos.");
                $this->jsonecho();
            }
        }

        // Check Telefone.
        if (mb_strlen(Input::post("phone")) > 0) {
            if (mb_strlen(Input::post("phone")) < 10) {
                $this->resp->msg = __("O telefone precisa ter no mínimo 10 dígitos.");
                $this->jsonecho();
            }
        }    
             
// 			    $permissoes['filiais'] = array(
// 						  "mtz" => Input::post("filial1"),
// 							"gyn" => Input::post("filial2"),
// 							"plm" => Input::post("filial3"),
// 							"rvd" => Input::post("filial4"),margem_usuario
// 							"gdr" => Input::post("filial7"),
// 							"ftz" => Input::post("filial8"),
// 							"fbe" => Input::post("filial9")
							
// 						);
// 			  $filiais = json_encode($permissoes);
			$encodeUserSelecionado = "";
			if(Input::post("usuariosSelecionado") != null){
				$arrayUniqueuser =  array_unique(Input::post("usuariosSelecionado"));
      $encodeUserSelecionado = json_encode($arrayUniqueuser, true);
			}
			if(Input::post("filialSelecionada") != null){
			$encodeFilialSelecionada = json_encode(Input::post("filialSelecionada"), true);
			}
			
            if (Input::post("account_type") == "integrador") {

              // Start setting data
              $User->set("firstname", Input::post("firstname"))
                   ->set("lastname", Input::post("lastname"))
                   ->set("cpf/cnpj", $clearFormatCnpj)
                   ->set("phone",  $clearFormatTel)
                   ->set("branch", "externo")
                   ->set("is_active", Input::post("is_active"))       
                   ->set("owner", $AuthUser->get("id"))
                   ->set("email", Input::post("email"))
                   ->set("office", Input::post("branch"))
                   ->set("cpf_responsavel", Input::post("cpf_responsavel"))
                   ->set("nome_responsavel", Input::post("nome_responsavel"))
                   ->set("rg_responsavel", Input::post("rg_responsavel"))
								   ->set("permissoes_usuarios", $encodeUserSelecionado)
								   ->set("permissoes_filiais", $encodeFilialSelecionada)
								   ->set("margem_usuario", Input::post("margem_usuario"))
									 ->set("api_key" , Input::post("api_key"));

            } else {

              // Start setting data
              $User->set("firstname", Input::post("firstname"))
                   ->set("lastname", Input::post("lastname"))
                   ->set("cpf/cnpj",  $clearFormatCnpj)
                   ->set("phone", $clearFormatTel)                   
                   ->set("is_active", Input::post("is_active"))
                   ->set("office", Input::post("branch"))
                   ->set("team", Input::post("team"))
                   ->set("owner", $AuthUser->get("id"))
                   ->set("email", Input::post("email"))
                   ->set("cpf_responsavel", Input::post("cpf_responsavel"))
                   ->set("nome_responsavel", Input::post("nome_responsavel"))
                   ->set("permissoes_usuarios", $encodeUserSelecionado)
							     ->set("permissoes_filiais", $encodeFilialSelecionada)
							     ->set("margem_usuario", Input::post("margem_usuario"))
                   ->set("api_key" , Input::post("api_key"));
            }
			
				if(Input::post("account_type") != null){
          $User->set("account_type", Input::post("account_type"));
        }

        if (mb_strlen(Input::post("password")) > 0) {
            $passhash = password_hash(Input::post("password"), PASSWORD_DEFAULT);
            $User->set("password", $passhash)
                 ->set("start_pw", 1);
        }
        
      
        try {
        $User->save();
          
        $this->logs($AuthUser->get("id"), "success","Usuário","Usuario " . Input::post("firstname") . " salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Usuário","Erro ao modificar o Usuário: ". Input::post("firstname"). "<br/>" .$e);
        }  
      
       if (Input::post("is_active_antigo") != Input::post("is_active")){
        if (Input::post("is_active") == "1"){
          $email = Input::post("email");	
          $nome = Input::post("firstname");	
					$send = \Email::sendNotification("cadastro-aprovado", ["email" => $email, "nome" => $nome]);
        }
        }
      
      
        // update cookies
        if ($User->get("id") == $AuthUser->get("id")) {
            setcookie("nplh", $AuthUser->get("id").".".md5($User->get("password")), 0, "/");
        }
        
        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Usuário cadastrado com sucesso! Por favor, recarregue a página.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }
	
	/**
     * Login
     * @return void
     */
    private function login($User)
    {   
				$this->resp->result = 0;
			
				$SessaoAntiga = Input::post("sessaoAntiga");
			
				setcookie("nplhA", $SessaoAntiga, $exp, "/");
			
				setcookie("nplh", $User->get("id").".".md5($User->get("password")), $exp, "/");
				
				$this->resp->result = 1;
			
				$this->jsonecho();				
        
    }
    

}
