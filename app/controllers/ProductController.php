<?php
/**
 * User Controller
 */
class ProductController extends Controller
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
        } else if (!$AuthUser->canEdit($AuthUser)) {
            header("Location: ".APPURL."/order");
            exit;
        }  

        $User = Controller::model("Product");

        if (isset($Route->params->id)) {
            $User->select($Route->params->id);

            if (!$User->isAvailable()) {
                header("Location: ".APPURL."/products");
                exit;
            }
        }
      
        $fieldsIcms = json_decode($User->get("icms"), true);
      
        $this->setVariable("User", $User);
        
        $this->setVariable("fieldsIcms", $fieldsIcms); 
      
        
        $Segments = Controller::model("ProductSegments");
        $Segments->where("is_active", "=", "1")
             ->orderBy("id","DESC")
             ->fetchData();

        $this->setVariable("Segments", $Segments);
      
        $Types = Controller::model("ProductTypes");
        $Types->where("is_active", "=", "1")
             ->orderBy("id","DESC")
             ->fetchData();

        $this->setVariable("Types", $Types);
      
        $Estados = Controller::model("States");
        $Estados->where("is_active", "=", "1")
             ->orderBy("id","ASC")
             ->fetchData();

        $this->setVariable("Estados", $Estados);
      
        $Garantias = Controller::model("Garantias");
        $Garantias->where("is_active", "=", "1")
             ->orderBy("id","ASC")
             ->fetchData();

        $this->setVariable("Garantias", $Garantias);
      
       $Models = Controller::model("ProductModels");
       $Models->where("is_active", "=", "1")
             ->orderBy("id","DESC")
             ->fetchData();

        $this->setVariable("Models", $Models);
      
       $Producers = Controller::model("Producers");
       $Producers->where("is_active", "=", "1")
             ->orderBy("id","DESC")
             ->fetchData();

        $this->setVariable("Producers", $Producers);
      
       $Origins = Controller::model("Origins");
       $Origins->where("is_active", "=", "1")
             ->orderBy("id","DESC")
             ->fetchData();

        $this->setVariable("Origins", $Origins);
      
        $Ncms = Controller::model("Ncms");
        $Ncms->orderBy("id","ASC")
             ->fetchData();

        $this->setVariable("Ncms", $Ncms);

        if (Input::post("action") == "save") {
            $this->save();
        } else if(Input::post("action") == "priceProduct"){
            $this->priceProduct();
        } 

        $this->view("product");     
        
    }    
  
    /**
     * priceProduct (new|edit) Product
     * @return void
     */
    private function priceProduct()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $Product = $this->getVariable("User");
          
        $IPI = str_replace(',', '.',Input::post("ipi"))/100;
        $CustoUnitario = str_replace(',', '.',Input::post("cust"));
        $CredIcms = str_replace(',', '.',Input::post("cred_icms"))/100;        
        $CredPisCofins = (str_replace(',', '.',Input::post("cred_pis")) + str_replace(',', '.',Input::post("cred_cofins")))/100;
          
        $PrimeiroCampo = $CustoUnitario * (1 + $IPI) ;
      
        $SegundoCampo = $PrimeiroCampo * $CredPisCofins;
        $TerceiroCampo = $CustoUnitario * $CredIcms;  
          
        $CustoLiquido = $PrimeiroCampo - $SegundoCampo - $TerceiroCampo;          
       
       $this->resp->retorno =  $CredIcms;
      
        $this->resp->valorCust = $CustoLiquido;
          
        $DebIcms = str_replace(',', '.',Input::post("deb_icms"))/100;
        $MargemBruta = str_replace(',', '.',Input::post("margem_product"))/100;
        $DebPisCofins = (str_replace(',', '.',Input::post("deb_pis")) + str_replace(',', '.',Input::post("deb_cofins")))/100;
          
        $CampoDivisao =  1 - $DebIcms - $DebPisCofins - $MargemBruta;
          
        $PrecoProduto = $CustoLiquido / $CampoDivisao;  
       
        $this->resp->valorPrice = $PrecoProduto;
       
        $this->resp->result = 1;        
        $this->jsonecho();
    }


    /**
     * Save (new|edit) Product
     * @return void
     */
    private function save()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $User = $this->getVariable("User");
   

        // Check if this is new or not
        $is_new = !$User->isAvailable();
        
        $fiscal = [];
        $fieldsIcms = [];
      
      
        if (Input::post("is_active_icms") == 1){
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
      
        $fiscal = [
          "watts" => Input::post("watts"),
          "va" => Input::post("va"),
          "mppt" => Input::post("mppt"),
          "ipi" => Input::post("ipi"),
          "deb_cofins" => Input::post("deb_cofins"),
          "cred_cofins" => Input::post("cred_cofins"),
          "deb_icms" => Input::post("deb_icms"),
          "cred_icms" => Input::post("cred_icms"),
          "deb_pis" => Input::post("deb_pis"),
          "cred_pis" => Input::post("cred_pis"),
          "mvaexterno" => Input::post("mvaexterno"),
          "mvainterno" => Input::post("mvainterno"),
          "mb" => Input::post("mb"),
        ];      
     
        $fiscal = json_encode($fiscal);
        $fieldsIcms = json_encode($fieldsIcms);

        // Start setting data
             
             $User->set("is_active", Input::post("is_active"))
             ->set("is_active_icms", Input::post("is_active_icms")) 
             ->set("is_active_st", Input::post("is_active_st"))   
             ->set("owner", $AuthUser->get("id"))
             ->set("segment", Input::post("segment"))
             ->set("product_type", Input::post("product_type"))
             ->set("product_model", Input::post("product_model")) 
             ->set("santri_cod", Input::post("santri_cod"))   
             ->set("prazo_entrega", Input::post("prazo_entrega"))     
             ->set("name", Input::post("name"))   
             ->set("producer", Input::post("producer")) 
             ->set("ncm", Input::post("ncm"))
             ->set("icms", $fieldsIcms)
             ->set("finance", $fiscal)
             ->set("description", Input::post("description")) 
             ->set("peso", Input::post("peso"))   
             ->set("altura", Input::post("altura"))   
             ->set("largura", Input::post("largura"))   
             ->set("comprimento", Input::post("comprimento"))     
             ->set("margem_product", Input::post("margem_product"))
             ->set("margem_kit", Input::post("margem_kit"))
             ->set("liquid_cust", Input::post("liquid_cust"))
             ->set("cust", Input::post("cust"))
             ->set("price", Input::post("price"))
             ->set("garantia", Input::post("garantia"))  
             ->set("type_unit", Input::post("type_unit"))
             ->set("datasheet", Input::post("datasheet"))  
             ->set("part_number", Input::post("part_number"))  
             ->set("origin", Input::post("origin"));


        $User->save();

        $this->resp->result = 1;
        if ($is_new) {
            $this->resp->msg = __("Produto cadastrado com sucesso.");
            $this->resp->reset = true;
        } else {
            $this->resp->msg = __("Alterações realizadas.");
        }
        $this->jsonecho();
    }


}
