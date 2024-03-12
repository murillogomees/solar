<?php
/**
 * Users Controller
 */
class UsersController extends Controller
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
        } else if (!$AuthUser->canEditOrder($AuthUser)) {
            header("Location: ".APPURL."/order");
            exit;
        }else if($AuthUser->get("start_pw") == 1){
          header("Location: ".APPURL."/novasenha");
        }
      
      
      if ($AuthUser->isMaster()){
           // Get Users
           $Users = Controller::model("Users");
           $Users->search(Input::get("q"))
                 ->setPageSize(20)
                 ->setPage(Input::get("page"))
                 ->orderBy("id","ASC")
                 ->fetchData();
        } else if ($AuthUser->isAdmin()){
           // Get Users
           $Users = Controller::model("Users");
           $Users->search(Input::get("q"))
                 ->where("account_type", "!=", 'diretoria')
                 ->setPageSize(20)
                 ->setPage(Input::get("page"))
                 ->orderBy("id","ASC")
                 ->fetchData();
        } else if ($AuthUser->get("account_type") == "gerente") {
          // Get Users
          $Users = Controller::model("Users");
          $Users->search(Input::get("q"))
                ->where(DB::raw("account_type = 'vendedor' OR account_type = 'supervisor' "))
                ->setPageSize(20)
                ->setPage(Input::get("page"))
                ->orderBy("id","ASC")
                ->fetchData();
        } else if ($AuthUser->get("account_type") == "supervisor" || $AuthUser->get("account_type") == "representante") {
          // Get Users
          $Users = Controller::model("Users");
          $Users->search(Input::get("q"))
                ->where("office", "=", $AuthUser->get("office"))
                ->where("account_type", "=", 'vendedor')
                ->setPageSize(20)
                ->setPage(Input::get("page"))
                ->orderBy("id","ASC")
                ->fetchData();
        }

        $this->setVariable("Users", $Users);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
      
        $this->view("users");
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

        $User = Controller::model("User", Input::post("id"));

        if (!$User->isAvailable()) {
            $this->resp->msg = __("Usuário não cadastrado!");
            $this->jsonecho();
        }

        if (!$AuthUser->canEdit($User)) {
            $this->resp->msg = __("Você não possui as permissões necessárias para alteração dos dados!");
            $this->jsonecho();   
        }

        if ($AuthUser->get("id") == $User->get("id")) {
            $this->resp->msg = __("Você não pode excluir sua própria conta!");
            $this->jsonecho();
        }

        $User->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}