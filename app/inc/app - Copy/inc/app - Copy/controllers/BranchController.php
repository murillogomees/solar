<?php
/**
 * User Controller
 */
class BranchController extends Controller
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


        $User = Controller::model("Branch");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/branchs");
                exit;
            }
        }
      
        // Get Clients
        $States = Controller::model("States");       
        $States->orderBy("id","ASC")
               ->fetchData();
        
        $this->setVariable("States", $States);
        $this->setVariable("User", $User);


        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("branch");
    }


    /**
     * Save (new|edit) user
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $User = $this->getVariable("User");

        // Check if this is new or not
        $is_new = !$User->isAvailable();

        // Check required fields
        $required_fields = ["name", "city", "uf","is_active"];       

        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Missing some of required data.");
                $this->jsonecho();
            }
        }

              // Start setting data
              $User->set("name", Input::post("name"))
                   ->set("city", Input::post("city"))
                   ->set("uf", Input::post("uf"))
                   ->set("is_active", Input::post("is_active"))
                   ->set("tipo_filial", Input::post("tipoFilial"))
                   ->set("owner", $AuthUser->get("id"));


         try {
        $User->save();
          
        $this->logs($AuthUser->get("id"), "success","Branch","Filial" . Input::post("name") . " salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Branch","Erro ao modificar a Filial. " . $e);
        }  

        

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Filial cadastrado com sucesso! Aguarde a página recarregar.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
