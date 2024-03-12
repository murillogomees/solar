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
			
			$num = "18629";
			$User = Controller::model("Order");
			$User->select($num, "order_id");
			var_dump($User);
		}
}