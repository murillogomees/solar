<?php
/**
 * Product Kit Controller
 */
class ProductKitController extends Controller {
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


        $ProdKit = Controller::model("ProductKit");

        if (isset($Route->params->id)) {
            $ProdKit->select($Route->params->id);

            if (!$ProdKit->isAvailable()) {
                header("Location: ".APPURL."/product-kits");
                exit;
            }
        }

        $fieldsIcms = json_decode($ProdKit->get("icms"), true);
       
        $Estados = Controller::model("States");
        $Estados->where("is_active", "=", "1")
             ->orderBy("id","ASC")
             ->fetchData();

        $this->setVariable("Estados", $Estados);
        
 
        $this->setVariable("fieldsIcms", $fieldsIcms);
        $this->setVariable("ProdKit", $ProdKit);

        if (Input::post("action") == "save") {
          $this->save();
        } 

        $this->view("product-kit");
    }


    /**
     * Save (new|edit) Product Segment
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $ProdKit = $this->getVariable("ProdKit");

        // Check if this is new or not
        $is_new = !$ProdKit->isAvailable();
        
       
        $fieldsIcms = [];
        // Settings
        if (!$is_new) {
          
          $fieldsIcms = json_decode($ProdKit->get("icms"), true);
        }
      

        if (Input::post("is_active_icms") == 1){
          $States = Controller::model("States");
          $States->orderBy("uf","ASC")
                 ->fetchData();

          foreach ($States->getDataAs("State") as $s){

          $ufActive = $s->get("uf");

          $fieldsIcms[$ufActive] = [
                     "ac" => Input::post($ufActive."-ac"),
                     "al" => Input::post($ufActive."-al"),
                     "ap" => Input::post($ufActive."-ap"),
                     "am" => Input::post($ufActive."-am"),
                     "ba" => Input::post($ufActive."-ba"),
                     "ce" => Input::post($ufActive."-ce"),
                     "df" => Input::post($ufActive."-df"),
                     "es" => Input::post($ufActive."-es"),
                     "go" => Input::post($ufActive."-go"),
                     "ma" => Input::post($ufActive."-ma"),
                     "mt" => Input::post($ufActive."-mt"),
                     "ms" => Input::post($ufActive."-ms"),
                     "mg" => Input::post($ufActive."-mg"),
                     "pa" => Input::post($ufActive."-pa"),
                     "pb" => Input::post($ufActive."-pb"),
                     "pr" => Input::post($ufActive."-pr"),
                     "pe" => Input::post($ufActive."-pe"),
                     "pi" => Input::post($ufActive."-pi"),
                     "rj" => Input::post($ufActive."-rj"),
                     "rn" => Input::post($ufActive."-rn"),
                     "rs" => Input::post($ufActive."-rs"),
                     "ro" => Input::post($ufActive."-ro"),
                     "rr" => Input::post($ufActive."-rr"),
                     "sc" => Input::post($ufActive."-sc"),
                     "sp" => Input::post($ufActive."-sp"),
                     "se" => Input::post($ufActive."-se"),
                     "to" => Input::post($ufActive."-to"),
          ];
         }
        }

       
        $fieldsIcms = json_encode($fieldsIcms);

        // Start setting data
        $ProdKit->set("name", Input::post("name"))
             ->set("is_active", Input::post("is_active"))
             ->set("is_active_icms", Input::post("is_active_icms"))
             ->set("margem_bruta", Input::post("margem_bruta"))
             ->set("icms", $fieldsIcms)             
             ->set("owner", $AuthUser->get("id"));
 
        $ProdKit->save();

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Kit cadastrado com sucesso!");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }

}
