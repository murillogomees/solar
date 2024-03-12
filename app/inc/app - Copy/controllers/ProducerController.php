<?php
/**
 * Producer Controller
 */
class ProducerController extends Controller
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


        $User = Controller::model("Producer");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/producers");
                exit;
            }
        }

        $this->setVariable("User", $User);


        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("producer");
    }


    /**
     * Save (new|edit) Producer
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
        $required_fields = ["name", "is_active"];


        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Missing some of required data.");
                $this->jsonecho();
            }
        }




            if (Input::post("account_type")) {

              // Start setting data
              $User->set("name", Input::post("name"))
                   ->set("is_active", Input::post("is_active"))
                   ->set("owner", $AuthUser->get("id"));

            } else {

              // Start setting data
              $User->set("name", Input::post("name"))
                   ->set("is_active", Input::post("is_active"))
                   ->set("owner", $AuthUser->get("id"));
            }



        if (mb_strlen(Input::post("password")) > 0) {
            $passhash = password_hash(Input::post("password"), PASSWORD_DEFAULT);
            $User->set("password", $passhash);
        }


        if ($AuthUser->get("id") != $User->get("id")) {
            // Don't allow to change self account type, status or expire date
            // This could cause to lost of access to the app with
            // default (and only) admin account

        }


          try {
        $User->save();
          
        $this->logs($AuthUser->get("id"), "success","Fabricante","Fabricante" . " salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Fabricante","Erro ao modificar o Fabricante . " . $e);
        }  


        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Fabricante cadastrado com sucesso!");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
