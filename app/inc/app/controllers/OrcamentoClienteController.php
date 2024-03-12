<?php
/**
 * User Controller
 */
class OrcamentoClienteController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $Route = $this->getVariable("Route");
        $AuthUser = $this->getVariable("AuthUser");
			

        $User = Controller::model("Order");

        if (isset($Route->params->hash)) {
					
					if (is_int($Route->params->hash) || ctype_digit($Route->params->hash)){
						header("Location: ".APPURL."/order");
						exit;
					}
					
					$User->select($Route->params->hash, "hash_link");
					var_dump($User);
					exit;
					if (!$User->isAvailable()) {
							header("Location: ".APPURL."/order");
							exit;
					}        
				} else {
					header("Location: ".APPURL."/order");
					exit;
				}
          
        $Usuario = Controller::model("User");
        $Usuario->select($User->get("responsavel"));       
        
        $this->setVariable("User", $User);
        $this->setVariable("Usuario", $Usuario);
        $this->view("budget");
    }
  
  public function idProduto($id) {
    $Produto = Controller::model("Product", $id);
    
    return $Produto;
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
