<?php
/**
 * User Controller
 */
class IcmController extends Controller
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


      $Icm = Controller::model("Icm");
      
      // Get Users
        $States = Controller::model("States");
            $States->setPageSize(27)
                  ->setPage(Input::get("page"))
                  ->orderBy("id","ASC")
                  ->fetchData();
    

      if (isset($Route->params->id)) {
          $Icm->select($Route->params->id);

          if (!$Icm->isAvailable()) {
              header("Location: ".APPURL."/icms");
              exit;
          }
      }
      $this->setVariable("States", $States);
      $this->setVariable("User", $Icm);


      if (Input::post("action") == "save") {
          $this->save();
      }

      $this->view("icm");
    }


    /**
     * Save (new|edit) user
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $IcmExactly = $this->getVariable("IcmExactly");

        $User = $this->getVariable("User");

        // Check if this is new or not
        $is_new = !$User->isAvailable();

        $required_fields = ["ac", "al","ap","am","ba","ce","df","es","go","ma","mt","ms",
                            "mg","pa","pb","pr","pe","pi","rj","rn","rs","ro","rr","sc","sp","se","to"];

        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Preencha todos os campos obrigatórios");
                $this->jsonecho();
            }
        }

        // Start setting data
        $User->set("uf_beggin", Input::post("uf_beggin"))
             ->set("owner", $AuthUser->get("id"))
             ->set("ac", Input::post("ac"))
             ->set("al", Input::post("al"))
             ->set("ap", Input::post("ap"))
             ->set("am", Input::post("am"))
             ->set("ba", Input::post("ba"))
             ->set("ce", Input::post("ce"))
             ->set("df", Input::post("df"))
             ->set("es", Input::post("es"))
             ->set("go", Input::post("go"))
             ->set("ma", Input::post("ma"))
             ->set("mt", Input::post("mt"))
             ->set("ms", Input::post("ms"))
             ->set("mg", Input::post("mg"))
             ->set("pa", Input::post("pa"))
             ->set("pb", Input::post("pb"))
             ->set("pr", Input::post("pr"))
             ->set("pe", Input::post("pe"))
             ->set("pi", Input::post("pi"))
             ->set("rj", Input::post("rj"))
             ->set("rn", Input::post("rn"))
             ->set("rs", Input::post("rs"))
             ->set("ro", Input::post("ro"))
             ->set("rr", Input::post("rr"))
             ->set("sc", Input::post("sc"))
             ->set("sp", Input::post("sp"))
             ->set("se", Input::post("se"))
             ->set("to", Input::post("to"));

         try {
        $User->save();
          
        $this->logs($AuthUser->get("id"), "success","Icm","Icms"  . " salvo com sucesso");  
        } catch (Exception $e){
        $this->logs($AuthUser->get("id"), "error","Cliente","Erro ao modificar o Usuário. " . $e);
        }  

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("ICMS adicionado com sucesso! Por favor, atualize a página.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Changes saved!");
        }
        $this->jsonecho();
    }

}
