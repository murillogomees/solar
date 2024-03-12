<?php
/**
 * User Controller
 */
class AguardeCadastroController extends Controller
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
        } else if ($AuthUser->get("is_active") == 1) {
            header("Location: ".APPURL."/order");
            exit;
        }       

        $this->view("aguarde");
    }

}
