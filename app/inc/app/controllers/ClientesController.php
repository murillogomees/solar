<?php
/**
 * Users Controller
 */
class ClientesController extends Controller
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
        }else if($AuthUser->get("start_pw") == 1){
          header("Location: ".APPURL."/novasenha");
        }


        // Get User
        $User = Controller::model("User", $AuthUser->get("id"));
        $Clientes = Controller::model("Clientes");       
      
        if ($AuthUser->get("account_type") == "integrador"){          
        $Clientes->search(Input::get("q"))
                 ->where("owner","=", $AuthUser->get("id"))
                 ->setPageSize(20)
                 ->setPage(Input::get("page"))
                 ->orderBy("name","ASC")
                 ->fetchData();
        } else {
          $Clientes->search(Input::get("q"))
                 ->setPageSize(20)
                 ->setPage(Input::get("page"))
                 ->orderBy("name","ASC")
                 ->fetchData();
        }
       
        $this->setVariable("Users", $Clientes);
        $this->setVariable("User", $User);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
        $this->view("clientes");
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
            $this->resp->msg = __("ID is required!");
            $this->jsonecho();
        }

        $User = Controller::model("User", $AuthUser->get("id"));
        
        $Client = Controller::model("Cliente", Input::post("id"));        
       

        if (!$AuthUser->canEdit($User)) {
            $this->resp->msg = __("Você não possui as permissões necessárias para alteração dos dados!");
            $this->jsonecho();   
        }
      

        $Client->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}