<?php
/**
 * Users Controller
 */
class ProductsController extends Controller
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
        } else if (!$AuthUser->canEdit($AuthUser)) {
            header("Location: ".APPURL."/order");
            exit;
        }else if($AuthUser->get("start_pw") == 1){
          header("Location: ".APPURL."/novaSenha");
        }

        // Get Users
        $Users = Controller::model("Products");
        $Users->search(Input::get("q"))
              ->setPageSize(50)
              ->select("id","name","producer","ncm","product_type")
              ->setPage(Input::get("page"))
              ->orderBy("is_active","DESC")
              ->fetchData();

        $this->setVariable("Users", $Users);

        if (Input::post("action") == "remove") {
            $this->remove();
        }
        $this->view("products");
    }


    /**
     * Remove User
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

        $User = Controller::model("Product", Input::post("id"));

        if (!$User->isAvailable()) {
            $this->resp->msg = __("Produto não cadastrado!");
            $this->jsonecho();
        }       

        $User->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
