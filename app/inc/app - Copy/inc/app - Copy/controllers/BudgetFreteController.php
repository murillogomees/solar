<?php
/**
 * User Controller
 */
class BudgetFreteController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $Route = $this->getVariable("Route");
        $AuthUser = $this->getVariable("AuthUser");

        $User = Controller::model("Order");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/orders");
                exit;
            }         
				}
          
        $Usuario = Controller::model("User");
        $Usuario->select($User->get("responsavel"));  
        
        $this->setVariable("User", $User);
        $this->setVariable("Usuario", $Usuario);
        $this->view("budget-frete");
    }
  
  public function idProduto($id) {
			$Produto = Controller::model("Product", $id);

			return $Produto;
  }
  
}
