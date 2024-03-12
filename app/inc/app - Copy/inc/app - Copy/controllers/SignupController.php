<?php
/**
 * Signup Controller
 */
class SignupController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $AuthUser = $this->getVariable("AuthUser");

        if ($AuthUser) {
            if ($AuthUser->get("is_active") == 0) {
             header("Location: ".APPURL."/aguarde");
             exit;
            } else {
             header("Location: ".APPURL."/order");
             exit; 
            }            
        }           

        if (Input::post("action") == "signup") {
            $this->signup();
        } 
      
        $this->view("signup", "site");
    }


    /**
     * Signup
     * @return void
     */
    private function signup()
    {        
        $errors = [];

        $required_fields  = [
            "firstname", "cpf/cnpj", "email", "phone",
            "password", "password-confirm"
        ];

        $required_ok = true;
        foreach ($required_fields as $field) {
            if (!Input::post($field)) {
                $required_ok = false;
            }
        }

        if (!$required_ok) {
            $errors[] = __("All fields are required");
        }


        if (empty($errors)) {
            if (!filter_var(Input::post("email"), FILTER_VALIDATE_EMAIL)) {
                $errors[] = __("Email is not valid!");
            } else {
                $User = Controller::model("User", Input::post("email"));
                if ($User->isAvailable()) {
                    $errors[] = __("Email is not available!");
                }
            }

            if (mb_strlen(Input::post("password")) < 6) {
                $errors[] = __("Password must be at least 6 character length!");
            } else if (Input::post("password-confirm") != Input::post("password")) {
                $errors[] = __("Password confirmation didn't match!");
            }
        }
            

            $User->set("email", strtolower(Input::post("email")))
                 ->set("password", 
                       password_hash(Input::post("password"), PASSWORD_DEFAULT))
                 ->set("firstname", Input::post("firstname"))
                 ->set("account_type", "integrador")                
                 ->set("office", "externo")
                 ->set("team", "externo")
                 ->set("phone", Input::post("phone"))               
                 ->set("is_active", 0)
                 ->set("owner", "0")
                 ->set("cpf/cnpj", Input::post("cpf/cnpj"))
                 ->save();          
      
            $send = \Email::sendNotification("sign-up", ["email" => strtolower(Input::post("email")), "nome" => Input::post("firstname"), "cnpj" => Input::post("cpf/cnpj")]);
           

            // Fire user.signup event
            Event::trigger("user.signup", $User);     
      
            // Logging in
            setcookie("nplh", $User->get("id").".".md5($User->get("password")), 0, "/");

            header("Location: ".APPURL."/aguarde");
            exit;
      

        $this->setVariable("FormErrors", $errors);
        
        return $this;
    }
}