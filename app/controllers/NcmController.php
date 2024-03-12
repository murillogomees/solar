<?php
/**
 * User Controller
 */
class NcmController extends Controller
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


        $User = Controller::model("Ncm");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/ncm");
                exit;
            }
        }        

        $this->setVariable("User", $User);

        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("ncm");
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
        $required_fields = ["cod_ncm", "is_active"];

        foreach ($required_fields as $field) {
            if (is_null(Input::post($field))) {
                $this->resp->msg = __("Missing some of required data.");
                $this->jsonecho();
            }
        }  

        // Start setting data
        $User->set("cod_ncm", Input::post("cod_ncm"))
             ->set("is_active", Input::post("is_active"))
             ->set("owner", $AuthUser->get("id"))
             ->set("description", Input::post("description"));

         try {
        $User->save();
          
        $this->logs($AuthUser->get("id"), "success","Ncm","Ncm" . " salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Ncm","Erro ao modificar o Ncm. " . $e);
        }  

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("NCM cadastrado com sucesso! Por favor, recarregue a página.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
