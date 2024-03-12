<?php
/**
 * Product Model Controller
 */
class ProductModelController extends Controller
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


        $ProdModel = Controller::model("ProductModel");

        if (isset($Route->params->id)) {
            $ProdModel->select($Route->params->id);

            if (!$ProdModel->isAvailable()) {
                header("Location: ".APPURL."/product-models");
                exit;
            }
        }

        $this->setVariable("ProdModel", $ProdModel);


        if (Input::post("action") == "save") {
            $this->save();
        } 

        $this->view("product-model");
    }

    /**
     * Save (new|edit) Product Model
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $ProdModel = $this->getVariable("ProdModel");

        // Check if this is new or not
        $is_new = !$ProdModel->isAvailable();

        // Check required fields
        $required_fields = ["name"];


        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $this->resp->msg = __("Missing some of required data.");
                $this->jsonecho();
            }
        }

        // Start setting data
        $ProdModel->set("name", Input::post("name"))
             ->set("is_active", Input::post("is_active"))            
             ->set("owner", $AuthUser->get("id"))
             ->set("type", Input::post("type"));

        $ProdModel->save();

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Cadastro de modelo de produto realizado com sucesso.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
