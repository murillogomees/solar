<?php
/**
 * Aba de Contas em Configurações 
 */
class TesteController extends Controller
{
    /**
     * Process
     */
    public function process()
    {

      
      	$Types = Controller::model("Products");
        $Types->fetchData();
		
		
		foreach($Types->getDataAs("Product") as $p){
			
			        $IPI = str_replace(',', '.',$p->get("finance.ipi"))/100;
        $CustoUnitario = str_replace(',', '.',$p->get("cust"));
        $CredIcms = str_replace(',', '.',$p->get("finance.cred_icms"))/100;        
        $CredPisCofins = (str_replace(',', '.',$p->get("finance.cred_pis")) + str_replace(',', '.',$p->get("finance.cred_cofins")))/100;
          
        $PrimeiroCampo = $CustoUnitario * (1 + $IPI) ;
      
        $SegundoCampo = $PrimeiroCampo * $CredPisCofins;
        $TerceiroCampo = $CustoUnitario * $CredIcms;  
          
        $CustoLiquido = $PrimeiroCampo - $SegundoCampo - $TerceiroCampo;          
       
        
          
        $DebIcms = str_replace(',', '.',$p->get("finance.deb_icms"))/100;
        $MargemBruta = str_replace(',', '.',$p->get("margem_product"))/100;
        $DebPisCofins = (str_replace(',', '.',$p->get("finance.deb_pis")) + str_replace(',', '.',$p->get("finance.deb_cofins")))/100;
          
        $CampoDivisao =  1 - $DebIcms - $DebPisCofins - $MargemBruta;
          
        $PrecoProduto = $CustoLiquido / $CampoDivisao;  
			
		$PrecoProduto =	round($PrecoProduto, 2);
			$CustoLiquido =	round($CustoLiquido, 2);
			
			
			$p->set("liquid_cust",$CustoLiquido)
				->set("price",$PrecoProduto);
      $p->save();
			
			echo "id ". $p->get("id") . " Preco Produto  " . $PrecoProduto . " Custo Liquido " . $CustoLiquido . " Custo  " . $p->get("cust") . "<br>";
			
		}
			
			exit;
		
      
      
		}
}