<?php
/**
 * User Controller
 */
class PaymentController extends Controller
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
        } else if (!$AuthUser->isAdmin()) {
            header("Location: ".APPURL."/order");
            exit;
        }


        $User = Controller::model("Payment");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/payments");
                exit;
            }
        }


        $this->setVariable("User", $User);


        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("payment");
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

        /*  Check required fields
        $required_fields = ["name", "is_active"];


        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Missing some of required data.");
                $this->jsonecho();
            }
        }

*/
      
        // Start setting data
        $User->set("name", Input::post("name"))
             ->set("is_active", Input::post("is_active"))
             ->set("site", Input::post("site"))
             ->set("juros", Input::post("juros"));
                   

          try {
        $User->save();
          
        $this->logs($AuthUser->get("id"), "success","Forma de Pagamento","Forma de pagamento" . " salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Ncm","Erro ao modificar a Forma de Pagamento. " . $e);
        }  


        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Condição de pagamento cadastrada com sucesso! Por favor, recarregue a página.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
