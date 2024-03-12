<?php
/**
 * Cron Controller
 */
class CronFilialOrderController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
      
      set_time_limit(0);
      $DiaReferencia = date("Y-m-d", strtotime("-180 days"));

      $Orcamentos = Controller::model("Orders");
      $Orcamentos->fetchData();
      
      $quantidade = 0;
      
      foreach($Orcamentos->getDataAs("Order") as $o){

        $Funcionario = Controller::model("User", $o->get("responsavel"));      
        $FilialFuncionario = $Funcionario->get("office");

        $o->set("loja_responsavel", $FilialFuncionario)->save();
        $quantidade++;
      }  
      
      echo "Cron realizada com sucesso, quantidade de orçamentos alterados: " . $quantidade;
    }

 
}