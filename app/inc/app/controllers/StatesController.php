<?php
/**
 * States Controller
 */
class StatesController extends Controller
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

        // Get States
        $States = Controller::model("States");
            $States->search(Input::get("q"))
                  ->setPageSize(27)
                  ->setPage(Input::get("page"))
                  ->orderBy("id","ASC")
                  ->fetchData();

        $this->setVariable("States", $States);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
        $this->view("states");
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

        $State = Controller::model("State", Input::post("id"));

        if (!$State->isAvailable()) {
            $this->resp->msg = __("Estado não cadastrado!");
            $this->jsonecho();
        }

        $State->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
