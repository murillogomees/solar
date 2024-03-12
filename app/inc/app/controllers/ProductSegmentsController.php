<?php
/**
 * Product Segments Controller
 *
 * @version 1.0
 * @author Storgetec
 *
 */
class ProductSegmentsController extends Controller
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

        // Get Product Segments
        $ProdSegments = Controller::model("ProductSegments");
        $ProdSegments->search(Input::get("q"))
                    ->setPageSize(20)
                    ->setPage(Input::get("page"))
                    ->orderBy("id","DESC")
                    ->fetchData();

        $this->setVariable("ProdSegments", $ProdSegments);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
        $this->view("product-segments");
    }


    /**
     * Remove Product Segments
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

        $ProdSegment = Controller::model("ProductSegment", Input::post("id"));

        if (!$ProdSegment->isAvailable()) {
            $this->resp->msg = __("Segmento não cadastrado!");
            $this->jsonecho();
        }

        $ProdSegment->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
