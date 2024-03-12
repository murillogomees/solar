<?php
/**
 * User Controller
 */
class TaxBenefitController extends Controller
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


        $User = Controller::model("TaxBenefit");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/benefits");
                exit;
            }

        }

        $taxProfile = Controller::model("TaxProfiles");
        $taxProfile->search(Input::request("q"))
              ->setPageSize(27)
              ->setPage(Input::get("page"))
              ->orderBy("id","DESC")
              ->fetchData();

        $this->setVariable("taxProfile", $taxProfile);

        $States = Controller::model("States");
        $States->search(Input::request("q"))
              ->setPageSize(27)
              ->setPage(Input::get("page"))
              ->orderBy("id","ASC")
              ->fetchData();

        $this->setVariable("States", $States);

        $Ncms = Controller::model("Ncms");
        $Ncms->orderBy("id","ASC")
             ->fetchData();

        $this->setVariable("Ncms", $Ncms);

        $this->setVariable("User", $User);


        if (Input::post("action") == "saveJs") {
            $this->save();
        } else if (Input::post("action") == "uf"){
            $this->uf();
        } else if (Input::post("action") == "ncm"){
            $this->ncm();
        } else if (Input::post("action") == "taxProfile") {
            $this->taxProfile();
        }  else if (Input::post("action") == "insert-ncm") {
            $this->insertNcm();
        }

        $this->view("tax-benefit");
    }

    /**
     * Search UF (new|edit) States
     * @return void
     */
    private function uf()
    {
      $this->resp->result = 0;

      $Categories = Controller::model("States");
      $Categories->search(Input::request("q"))
            ->setPageSize(27)
            ->setPage(Input::get("page"))
            ->orderBy("id","DESC")
            ->fetchData();


      if (!Input::request("q")) {
         $this->resp->msg = __("Missing some of required data.");
         $this->jsonecho();
      }

      $this->resp->items = [];

      foreach ($Categories->getDataAs("State") as $r) {
        $this->resp->items[] = [
          "value" => $r->get("name"),
          "data" => [
            "id" => $r->get("id"),
            "type" => "uf"
          ]
        ];
      };

      $this->resp->result = 1;
      $this->jsonecho();
    }

    /**
     * Search UF (new|edit) States
     * @return void
     */
    private function insertNcm()
    {
         $this->resp->result = 0;
         $AuthUser = $this->getVariable("AuthUser");

         $targets = Input::post("targets_list");

         $targets = str_replace(" ", "", $targets);
         $targets = explode("\n", str_replace("\r", "", $targets));

         $filtered_targets = [];
         foreach ($targets as $key) {
           $ncmChecked = $this->checkNcm($key);
           if ($ncmChecked == "true"){
             $filtered_targets[] = [
               "type" => "ncm",
               "value" => $key,
             ];
           }
         }

         $this->resp->filtered_targets = json_encode($filtered_targets, true);
         $this->resp->result = 1;
         $this->jsonecho();
    }

    /**
     * Search UF (new|edit) States
     * @return void
     */
    private function checkNcm($target)
    {
      $this->resp->result = 0;

      $checkNcm = Controller::model("Ncms");
      $checkNcm->search($target)
            ->orderBy("id","DESC")
            ->fetchData();

      foreach ($checkNcm->getDataAs("Ncm") as $key) {
        return true;
      }

      return false;
    }

    /**
     * Search UF (new|edit) States
     * @return void
     */
    private function taxProfile()
    {
      $this->resp->result = 0;

      $Categories = Controller::model("TaxProfiles");
      $Categories->search(Input::request("q"))
            ->setPageSize(27)
            ->setPage(Input::get("page"))
            ->orderBy("id","DESC")
            ->fetchData();


      if (!Input::request("q")) {
         $this->resp->msg = __("Missing some of required data.");
         $this->jsonecho();
      }

      $this->resp->items = [];

      foreach ($Categories->getDataAs("TaxProfile") as $r) {
        $this->resp->items[] = [
            "value" => $r->get("name"),
            "data" => [
              "id" => $r->get("id"),
              "type" => "taxProfile"
            ]
        ];
      };

      $this->resp->result = 1;
      $this->jsonecho();
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

        // Targets
        $targets = json_decode(Input::post("targets"));
        $uf = checkUf(Input::post("ufOrigin"));

        if ($is_new){
            $categories = Controller::model("TaxBenefits");
            $categories->search($uf)
                  ->setPageSize(27)
                  ->setPage(Input::get("page"))
                  ->orderBy("id","DESC")
                  ->fetchData();

            $id = $categories->getTotalCount();
            $name = strtoupper($uf) . " - ". $id;
        } else {
          $name = $User->get("name");
        }

        $valid_targetsNcm = [];
        $valid_targetsTaxProfile = [];
        $valid_targetsUfDestiny = [];
        $valid_benefitsRank = [];
        $valid_apuracao = [];
        $valid_base = [];
        $valid_aliquota = [];
        $valid_nf = [];

        foreach ($targets as $t) {

          if($t->type == "ncm"){
              $valid_targetsNcm[] = [
              "type" => $t->type,  
              "value" => $t->value
              ];
          } else if($t->type == "taxProfile"){
              $valid_targetsTaxProfile[] = [   
              "type" => $t->type,
              "value" => $t->value
              ];
          }  else if($t->type == "uf"){
              $valid_targetsUfDestiny[] = [   
              "type" => $t->type,
              "value" => $t->value
              ];
          }

        }

        // Targets
       $benefitsRank = json_decode(Input::post("benefitsRank"));
       $valid_NF = json_decode(Input::post("taxNF")); 
       $valid_tax_base = json_decode(Input::post("taxBase"));
       $valid_tax_aliquota = json_decode(Input::post("taxAliquota"));
       $valid_tax_apuracao = json_decode(Input::post("taxApuracao"));

        foreach ($benefitsRank as $t) {
              $valid_benefitsRank[] = [ 
              "type" => $t->type,
              "id" => $t->id,
              "value" => $t->value
              ];
        }
      
      foreach ($valid_NF as $v) {
              $valid_nf[$v->type] = [             
              "id" => $v->id,
              "value" => $v->value
              ];
        }
      
        foreach ($valid_tax_base as $v) {
              $valid_base[$v->type] = [                 
              "id" => $v->id,
              "value" => $v->value
              ];
        }
      
      foreach ($valid_tax_aliquota as $v) {
              $valid_aliquota[$v->type] = [         
              "id" => $v->id,
              "value" => $v->value
              ];
        }
      
       foreach ($valid_tax_apuracao as $v) {
        
         if ($v->value != ""){
           $valid_apuracao[$v->type] = [
           "id" => $v->id,           
           "value" => $v->value
           ];
         }
        }

        $benefitsRank = json_encode($valid_benefitsRank);  
        $targetsNcm = json_encode($valid_targetsNcm);
        $targetsTaxProfile = json_encode($valid_targetsTaxProfile);
        $valid_targetsUfDestiny = json_encode($valid_targetsUfDestiny);      
        
        $valid_nf = json_encode($valid_nf); 
        $valid_apuracao = json_encode($valid_apuracao);
        $valid_aliquota = json_encode($valid_aliquota);
        $valid_base = json_encode($valid_base); 

        // Start setting data
        $User->set("name", $name)
             ->set("uf_origin", $uf)
             ->set("ncm", $targetsNcm)
             ->set("is_active", Input::post("is_active"))
             ->set("description", Input::post("description"))
             ->set("tax_profiles", $targetsTaxProfile)
             ->set("benefits", $benefitsRank)
             ->set("uf_destiny", $valid_targetsUfDestiny)
             ->set("owner", $AuthUser->get("id"))
             ->set("tax_base", $valid_base)
             ->set("tax_aliquota", $valid_aliquota)
             ->set("tax_apuracao", $valid_apuracao)
             ->set("nota_fiscal", $valid_nf)
             ->save();



        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Benefício cadastrado com sucesso!");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
