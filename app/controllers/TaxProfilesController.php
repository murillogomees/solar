<?php
/**
 * Users Controller
 */
class TaxProfilesController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
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

        // Get TaxProfile
        $Users = Controller::model("TaxProfiles");
            $Users->search(Input::get("q"))
                  ->setPageSize(20)
                  ->setPage(Input::get("page"))
                  ->orderBy("id","DESC")
                  ->fetchData();

        $this->setVariable("Users", $Users);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
        $this->view("tax-profiles");
    }


    /**
     * Remove TaxProfile
     * @return void
     */
    private function remove()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");

        if (!Input::post("id")) {
            $this->resp->msg = __("ID is requred!");
            $this->jsonecho();
        }

        $User = Controller::model("TaxProfile", Input::post("id"));

        if (!$User->isAvailable()) {
            $this->resp->msg = __("Perfil Tributário não cadastrado!");
            $this->jsonecho();
        }

        $User->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
