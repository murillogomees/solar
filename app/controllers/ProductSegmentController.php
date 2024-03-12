<?php
/**
 * Product Segment Controller
 */
class ProductSegmentController extends Controller
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


        $ProdSegment = Controller::model("ProductSegment");

        if (isset($Route->params->id)) {
            $ProdSegment->select($Route->params->id);

            if (!$ProdSegment->isAvailable()) {
                header("Location: ".APPURL."/product-segments");
                exit;
            }
        }
      
        $Estados = Controller::model("States");
        $Estados->where("is_active", "=", "1")
             ->orderBy("id","ASC")
             ->fetchData();

        $this->setVariable("Estados", $Estados);

        $fields = json_decode($ProdSegment->get("field"), true);
        $fieldsIcms = json_decode($ProdSegment->get("icms"), true);

        $this->setVariable("fieldsIcms", $fieldsIcms);
        $this->setVariable("Fields", $fields);
        $this->setVariable("ProdSegment", $ProdSegment);


        if (Input::post("action") == "save") {
          $this->save();
        } 

        $this->view("product-segment");
    }


    /**
     * Save (new|edit) Product Segment
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $ProdSegment = $this->getVariable("ProdSegment");

        // Check if this is new or not
        $is_new = !$ProdSegment->isAvailable();

        $fields = [];
        $fieldsIcms = [];
        // Settings
        if (!$is_new) {
          $fields = json_decode($ProdSegment->get("field"), true);
          $fieldsIcms = json_decode($ProdSegment->get("icms"), true);
        }

        $fields["fiscal"] = [
           "ipi" => Input::post("ipi"),
           "origin" => Input::post("origin"),
           "deb_icms" => Input::post("deb_icms"),
           "cred_icms" => Input::post("cred_icms"),
           "deb_pis" => Input::post("deb_pis"),
           "cred_pis" => Input::post("cred_pis"),
           "deb_cofins" => Input::post("deb_cofins"),
           "cred_cofins" => Input::post("cred_cofins"),
           "mva" => Input::post("mva"),
           "mb" => Input::post("mb"),
           "price" => "on",
        ];

        if (Input::post(is_active_icms) == 1){
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

        $fields = json_encode($fields);

        $fieldsIcms = json_encode($fieldsIcms);

        // Start setting data
        $ProdSegment->set("name", Input::post("name"))
             ->set("is_active", Input::post("is_active"))
             ->set("is_active_icms", Input::post("is_active_icms"))
             ->set("kitfix", Input::post("kitfix"))
             ->set("icms", $fieldsIcms)
             ->set("owner", $AuthUser->get("id"))
             ->set("field", $fields);


        $ProdSegment->save();

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Segmento cadastrado com sucesso!");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
