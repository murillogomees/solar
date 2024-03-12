<?php
/**
 * Users Controller
 */
class GarantiasController extends Controller
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

        // Get Users
        $Users = Controller::model("Garantias");
            $Users->search(Input::get("q"))
                  ->setPageSize(20)
                  ->setPage(Input::get("page"))
                  ->orderBy("id","DESC")
                  ->fetchData();

        $this->setVariable("Users", $Users);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
        $this->view("garantias");
    }


    /**
     * Remove User
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

        $Payment = Controller::model("Garantia", Input::post("id"));

        if (!$Payment->isAvailable()) {
            $this->resp->msg = __("Garantia não cadastrada!");
            $this->jsonecho();
        }

        $Payment->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
