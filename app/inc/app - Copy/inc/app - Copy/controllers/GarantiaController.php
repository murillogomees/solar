<?php
/**
 * User Controller
 */
class GarantiaController extends Controller
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


        $User = Controller::model("Garantia");

        if (isset($Route->params->id)) {
          $User->select($Route->params->id);

          if (!$User->isAvailable()) {
              header("Location: ".APPURL."/garantias");
              exit;
          }
        }


        $this->setVariable("User", $User);


        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("garantia");
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
      
        // Start setting data
        $User->set("name", Input::post("name"))
             ->set("is_active", Input::post("is_active"));
      
        try {
        $User->save();
          
        $this->logs($AuthUser->get("id"), "success","Garantias","Garantia " . Input::post("name") . " salva com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Garantias","Erro ao modificar a Garantia. " . $e);
        }  


        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Prazo de Garantia cadastrado com sucesso! Por favor, recarregue a página.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
