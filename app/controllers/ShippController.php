<?php
/**
 * User Controller
 */
class ShippController extends Controller
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


        $User = Controller::model("Shipp");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/shipping");
                exit;
            }
        }


        $this->setVariable("User", $User);


        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("shipp");
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
        $required_fields = ["name", "is_active","cod_origin"];


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
             ->set("price_shipp", Input::post("price_shipp"));




        if ($AuthUser->get("id") != $User->get("id")) {
            // Don't allow to change self account type, status or expire date
            // This could cause to lost of access to the app with
            // default (and only) admin account



        }



        $User->save();

        // update cookies
        if ($User->get("id") == $AuthUser->get("id")) {
            setcookie("nplh", $AuthUser->get("id").".".md5($User->get("password")), 0, "/");
        }

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Origem do produto cadastrada com sucesso! Por favor, recarregue a página.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
