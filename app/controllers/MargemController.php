<?php
/**
 * User Controller
 */
class MargemController extends Controller
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


        $opcao = Controller::model("Option");
        $opcao->select(3);

          if (!$opcao->isAvailable()) {
              header("Location: ".APPURL."/");
              exit;
          }
        


        $this->setVariable("opcao", $opcao);


        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("margem");
    }


    /**
     * Save (new|edit) user
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $opcao = $this->getVariable("opcao");

        // Check if this is new or not
        $is_new = !$opcao->isAvailable();
      
        // Start setting data
        $opcao->set("margem_kit", Input::post("kit"))
             ->set("margem_un", Input::post("unitario"));
      
        try {
        $opcao->save();
          
        $this->logs($AuthUser->get("id"), "success","Margem","margem  salva com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Margem","Erro ao modificar a margem. " . $e);
        }  


        $this->resp->result = 1;
        $this->resp->msg = __("Alterações realizadas.");
        
        $this->jsonecho();
    }


}
