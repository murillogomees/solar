<?php
/**
 * Users Controller
 */
class IcmsController extends Controller
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
      }  else if ($AuthUser->get("is_active") == 0) {
             header("Location: ".APPURL."/aguarde");
             exit;
        } else if (!$AuthUser->isAdmin()) {
          header("Location: ".APPURL."/order");
          exit;
      }

      // Get Users
      $Users = Controller::model("Icms");
          $Users->search(Input::get("q"))
                ->setPageSize(27)
                ->setPage(Input::get("page"))
                ->orderBy("uf_beggin","ASC")
                ->fetchData();

      $this->setVariable("Users", $Users);

      if (Input::post("action") == "remove") {
          $this->remove();
      }
      $this->view("icms");
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

}