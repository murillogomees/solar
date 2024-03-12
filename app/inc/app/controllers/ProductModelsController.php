<?php
/**
 * ProductModels Controller
 */
class ProductModelsController extends Controller
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
        } else if (!$AuthUser->isAdmin()) {
            header("Location: ".APPURL."/order");
            exit;
        }

        // Get Users
        $ProdModels = Controller::model("ProductModels");
        $ProdModels->search(Input::get("q"))
                   ->setPageSize(20)
                   ->setPage(Input::get("page"))
                   ->orderBy("id","DESC")
                   ->fetchData();

        $this->setVariable("ProdModels", $ProdModels);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
        $this->view("product-models");
    }


    /**
     * Remove Product Models
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

        $ProdModel = Controller::model("ProductModel", Input::post("id"));

        if (!$ProdModel->isAvailable()) {
            $this->resp->msg = __("Modelo não cadastrada!");
            $this->jsonecho();
        }

        $ProdModel->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
