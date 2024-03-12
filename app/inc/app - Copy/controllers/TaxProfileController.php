<?php
/**
 * TaxProfile Controller
 */
class TaxProfileController extends Controller
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


        $User = Controller::model("TaxProfile");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/taxprofiles");
                exit;
            }
        }


        $this->setVariable("User", $User);


        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("tax-profile");
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

         // Check if this is new or notfilial da empresa
         $is_new = !$User->isAvailable();

         // Check required fields
         $required_fields = ["name", "is_active"];

         foreach ($required_fields as $field) {
             if (is_null(Input::post($field))) {
                 $this->resp->msg = __("Missing some of required data. ");
                 $this->jsonecho();
             }
         }

         // Start setting data
         $User->set("name", Input::post("name"))
              ->set("is_active", Input::post("is_active"))
              ->set("owner", $AuthUser->get("id"))
              ->set("use-consume", (bool)Input::post("use-consume"))
              ->set("tax-subs", (bool)Input::post("tax-subs"));

         $User->save();



        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Perfil Tributário cadastrado com sucesso.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
