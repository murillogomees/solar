<?php
/**
 * Product Types Controller
 */
class ProductTypesController extends Controller
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

        // Get fixkits
        $ProdTypes = Controller::model("ProductTypes");
        $ProdTypes->search(Input::get("q"))
                  ->setPageSize(20)
                  ->setPage(Input::get("page"))
                  ->orderBy("id","DESC")
                  ->fetchData();

        $this->setVariable("ProdTypes", $ProdTypes);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
      
        $this->view("product-types");
    }


    /**
     * Remove Product Type
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

        $ProdType = Controller::model("ProductType", Input::post("id"));

        if (!$ProdType->isAvailable()) {
            $this->resp->msg = __("Tipo de Produto não cadastrado!");
            $this->jsonecho();
        }

        $ProdType->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
