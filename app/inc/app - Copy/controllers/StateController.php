<?php
/**
 * state Controller
 */
class StateController extends Controller
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


        $State = Controller::model("State");

        if (isset($Route->params->id)) {
            $State->select($Route->params->id);

            if (!$State->isAvailable()) {
                header("Location: ".APPURL."/states");
                exit;
            }
        }

        $this->setVariable("State", $State);


        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("state");
    }


    /**
     * Save (new|edit) state
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $State = $this->getVariable("State");

        // Check if this is new or not
        $is_new = !$State->isAvailable();

        // Check required fields
        $required_fields = ["name", "is_active", "st_active" ];


        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Missing some of required data.");
                $this->jsonecho();
            }
        }

              // Start setting data
              $State->set("name", Input::post("name"))
                   ->set("is_active", Input::post("is_active"))
                   ->set("st_active", Input::post("st_active"))
                   ->set("owner", $AuthUser->get("id"));

        $State->save();

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Estado cadastrado com sucesso!");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
