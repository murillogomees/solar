<?php
/**
 * Users Controller
 */
class NcmsController extends Controller
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
        $Users = Controller::model("Ncms");
            $Users->search(Input::get("q"))
                  ->setPageSize(20)
                  ->setPage(Input::get("page"))
                  ->orderBy("id","DESC")
                  ->fetchData();

        $this->setVariable("Users", $Users);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
        $this->view("ncms");
    }

    /**
     * Remove User
     * @return void
     */
    public function responsavel($id)
    {

        $Usuario = Controller::model("User", $id);

        return $Usuario;
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

        $User = Controller::model("Ncm", Input::post("id"));
        $codNcm = $User->get("cod_ncm");

        $States = Controller::model("States");
        $States->fetchData();

        foreach ($States->getDataAs("State") as $s) {
          $IcmsLine = DB::table("np_icms")
                     ->where("uf_beggin", "=", $s->get("uf"))
                     ->where("ncm", "=", $codNcm)
                     ->select("*")
                     ->delete();
        }

        if (!$User->isAvailable()) {
            $this->resp->msg = __("NCM não cadastrado!");
            $this->jsonecho();
        }

        $User->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
