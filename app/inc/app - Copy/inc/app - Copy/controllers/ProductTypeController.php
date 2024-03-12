<?php
/**
 * Product Type Controller
 */
class ProductTypeController extends Controller
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


        $ProdType = Controller::model("ProductType");

        if (isset($Route->params->id)) {
            $ProdType->select($Route->params->id);

            if (!$ProdType->isAvailable()) {
                header("Location: ".APPURL."/product_types");
                exit;
            }
        }

        $this->setVariable("ProdType", $ProdType);


        if (Input::post("action") == "save") {
            $this->save();
        }

        $this->view("product-type");
    }


    /**
     * Save (new|edit) Product Type
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $ProdType = $this->getVariable("ProdType");

        // Check if this is new or not
        $is_new = !$ProdType->isAvailable();

        // Check required fields
        $required_fields = ["name", "is_active"];


        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Missing some of required data.");
                $this->jsonecho();
            }
        }

        // Start setting data
        $ProdType->set("name", Input::post("name"))
                 ->set("is_active", Input::post("is_active"))
                 ->set("owner", $AuthUser->get("id"));


        $ProdType->save();

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Tipo de produto cadastrado com sucesso!");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
