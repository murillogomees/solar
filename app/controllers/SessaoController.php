<?php
/**
 * User Controller
 */
class SessaoController extends Controller
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
        }

        if (Input::post("action") == "reloginAdm") {
            $this->reloginAdm();
        }        
    }
	
	/**
     * Login
     * @return void
     */
    private function reloginAdm()
    {   
				$this->resp->result = 0;
			
				$SessaoAntiga = Input::post("sessaoAntiga");
			
				setcookie("nplh", $SessaoAntiga, $exp, "/");
			
				setcookie("nplhA", "", time() - 3600);	
				
				$this->resp->result = 1;
			
				$this->jsonecho();				
        
    }
    

}
