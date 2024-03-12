<?php
/**
 * User Controller
 */
class BudgetController extends Controller
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
			

        $User = Controller::model("Order");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/orders");
                exit;
            }
          
          if ($AuthUser->get("account_type") == "vendedor"){
						if ($User->get("responsavel") != $AuthUser->get("id")){
							header("Location: ".APPURL."/order");
							exit;
						}
					} else if ($AuthUser->get("account_type") == "supervisor"){					
						if ($User->get("office") != $AuthUser->get("loja_responsavel")){
							header("Location: ".APPURL."/order");
							exit;
						}
					}
              

					
					
        $Usuario = Controller::model("User");
        $Usuario->select($User->get("responsavel"));          
     
        }
			
				if(Input::post("action") == "logWhats"){
					$this->logWhats($AuthUser, $User);
				}
        
        $this->setVariable("User", $User);
        $this->setVariable("Usuario", $Usuario);
        $this->view("budget");
    }
	
	private function logWhats($AuthUser, $User) {

    $this->logs($AuthUser->get("id"), "success","WhatsApp","Proposta para o <b>Nº " . $User->get("order_id") . "</b> enviadas através do WhatsApp.");  
    $this->jsonecho();
  }
  
  public function idProduto($id) {
    $Produto = Controller::model("Product", $id);
    
    return $Produto;
  }
	
	  public function freteUF($id) {
				$Fretes = Controller::model("Shipp");	
			  $Fretes->select($id,"id");
			  $porcentagem = $Fretes->get("price_shipp");
			$array = array(
		    "valor" => $porcentagem,
		    "nome" => $Fretes->get("name"),
		);
			
    return $array;
  }
	
	
	
  public function frete($id) {
    $Frete =  Controller::model("Frete");
		$str = ltrim($id, "0"); 
    $Frete->select($str,"id_orcamento");
		$status = $Frete->get("status");
		$transporte = $Frete->get("tipo_transporte");
		$valor = $Frete->get("valor_total");
		$ID = $Frete->get("id");
		$array = array(
		"status" => $status,
		"tipo_transporte" => $transporte,
		"valor_total" => $valor,
			"id" => $ID,
		);
    return $array;
  }	
	
  
}
