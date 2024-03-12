<?php
/**
 * User Controller
 */
class ClienteController extends Controller
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
        }


       $User = Controller::model("Cliente");

       $User1 = Controller::model("User");
      
       if($AuthUser->canEdit($AuthUser)){
       $Branchs = Controller::model("Branchs");
       $Branchs->orderBy("id","DESC")
               ->fetchData();
       } else {
       $Branchs = Controller::model("Branchs");
       $Branchs->where("name","=", $AuthUser->get("office"))
               ->orderBy("id","DESC")
               ->fetchData();
       }
      
       $States = Controller::model("States");
       $States->orderBy("name","ASC")
              ->fetchData();

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/clients");
                exit;
            }
        }
      
        $TaxProfile = Controller::model("TaxProfiles");
        $TaxProfile->orderBy("id","DESC")
                 ->fetchData();
      
        $condicao = Controller::model("Payments");
        $condicao->orderBY("id", "DESC")
                  ->fetchData();
      
        $this->setVariable("condicao" , $condicao);
      
        foreach($condicao->getDataAs("Payment") as $p){
             $ArrayP[] =  array( 
                "id" => $p->get("id"),
                "nome" => $p->get("name")
             ); 
          }
          $this->setVariable("ArrayP", $ArrayP);
        
        
        $this->setVariable("TaxProfile", $TaxProfile);

        $this->setVariable("User", $User);
      
        $this->setVariable("Branchs" , $Branchs);
        $this->setVariable("States" , $States);

        if (Input::post("action") == "save") {
            $this->save();
        } else if (Input::post("action") == "searchCep") {
            $this->searchCep();
        } else if (Input::post("action") == "searchCnpj") {
            $this->searchCnpj();
        } 
      
        $this->view("cliente");
    }
  

    /**
     * Save (new|edit) user
     * @return void
     */
    private function searchCnpj()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
      
        $User = $this->getVariable("User");
        $clearFormatCnpj= preg_replace("/[^0-9]/","", Input::post("cnpj"));
      
        if (strlen($clearFormatCnpj) == 0){
           $this->resp->cnpj = "";
           $this->jsonecho();
        } 
      
        $resultado = cnpj($clearFormatCnpj);
        $this->resp->cnpj = $resultado;
      
      
        $this->resp->result = 1;
        $this->jsonecho();  
    }
    
     /**
     * Save (new|edit) user
     * @return void
     */
    private function searchCep()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
      
        $User = $this->getVariable("User");
        $clearFormatCnpj= preg_replace("/[^0-9]/","", Input::post("cep"));
      
        if (strlen($clearFormatCnpj) == 0){
           $this->resp->cep = "";
           $this->jsonecho();
        } 
      
        $resultado = cep($clearFormatCnpj);
        $this->resp->logradouro = $resultado['logradouro'];
        $this->resp->bairro = $resultado['bairro'];
        $this->resp->uf = $resultado['uf'];
        $this->resp->localidade = $resultado['localidade'];
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
        $required_fields = ["cnpj", "name", "taxProfile","uf","cep","city","branch","address","bairro", "phone"];
          
      
        foreach ($required_fields as $field) {
          if (!Input::post($field)) {
              $this->resp->msg = __("Preencha todos os campos obrigatórios:");
              $this->jsonecho();
          }          
        }
        
        $clearFormatTel = preg_replace("/[^0-9]/","", Input::post("phone"));
        $clearFormatCnpj = preg_replace("/[^0-9]/","", Input::post("cnpj"));
        
       /** if ($is_new) {
          $ConsultaCNPJ = Controller::model("Clientes");
          $ConsultaCNPJ->where("cnpj","=", $clearFormatCnpj)
                       ->orderBy("id","DESC")
                       ->fetchData();

          if ($ConsultaCNPJ->getDataAs("Cliente")){
            $this->resp->msg = __("CNPJ já cadastrado no sistema.");
            $this->jsonecho();
          } 
        }**/
      
        if (strlen($clearFormatTel) < 10){
          $this->resp->msg = __("Celular com quantidade de Caraceteres Inválidos.");
          $this->jsonecho();
        }

        
        $clearFormatCep= preg_replace("/[^0-9]/","", Input::post("cep"));
        $CodSantri = preg_replace("/[^0-9]/","", Input::post("cod_santri"));
        $pagamento = [
          "pagamentos" => Input::post("pagamentos"),
        ];        
				$pagamentoPermitido = json_encode($pagamento);
      
      $encodePagamento = "";
			if(Input::post("pagamentos") != null){
			$arrayUnique =  array_unique(Input::post("pagamentos"));
      $encodePagamento = json_encode($arrayUnique, true);
			}
      
      if(!$User->isAvailable()){
         $User->set("adicional_venda", 0);
         $User->set("p_pagamentos", '["23","12","11","5","3","2"]');
      }
      
      
            
        // Start setting data
        $User->set("name", Input::post("name"))
             ->set("cod_santri", $CodSantri)
             ->set("cnpj", $clearFormatCnpj)
             ->set("phone", $clearFormatTel)
             ->set("client_type", Input::post("taxProfile"))
             ->set("uf", Input::post("uf"))
             ->set("branch", Input::post("branch"))
             ->set("cep", $clearFormatCep)
             ->set("city", Input::post("city"))
             ->set("bairro", Input::post("bairro"))
             ->set("address", Input::post("address"))
             ->set("owner", $AuthUser->get("id"));
      if($AuthUser->isSetorFinanceiro()){
        $User->set("p_pagamentos", $encodePagamento);
      }
      if($AuthUser->isMaster()){
         $User->set("adicional_venda", Input::post("adicional-venda"));
       }
            
      
        try {
        $User->save();
          
        $this->logs($AuthUser->get("id"), "success","Cliente","Cliente: <b>" . Input::post("name") . "</b> salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Cliente","Erro ao modificar o Cliente. " . $e);
        }  
      

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Cliente cadastrado com sucesso!");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Changes saved!");
        }
        $this->jsonecho();
        header('Refresh:0');
    }
}
