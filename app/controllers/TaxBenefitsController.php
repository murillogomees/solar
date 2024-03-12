<?php
/**
 * Users Controller
 */
class TaxBenefitsController extends Controller
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
        $Users = Controller::model("TaxBenefits");
            $Users->search(Input::get("q"))
                  ->setPageSize(10)
                  ->setPage(Input::get("page"))
                  ->orderBy("id","DESC")
                  ->select("id","name")
                  ->fetchData();

        $this->setVariable("Users", $Users);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
        $this->view("tax-benefits");
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

        $User = Controller::model("TaxBenefit", Input::post("id"));

        if (!$User->isAvailable()) {
            $this->resp->msg = __("Benefício não cadastrado!");
            $this->jsonecho();
        }

        $User->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
