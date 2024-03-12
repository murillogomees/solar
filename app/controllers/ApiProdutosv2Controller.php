<?php

class ApiProdutosv2Controller extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        // Rota
        $Route = $this->getVariable("Route");   
      
        // Headers
        header('Content-Type: application/json');
        header('X-Content-Type-Options: nosniff');
        header('X-HTTP-Method-Override: GET');
        header('X-XSS-Protection: 1; mode=block');
        header('X-Frame-Options: deny');
        header('Strict-Transport-Security: max-age=16070400; includeSubDomains');
      
        // Verificação de Hash
        if ($Route->params->hash != "8fdab3b1232fda00e469231c36fadd8d7fd3a11f"){
          
          // Setar informações do erro
          $error[] = [
           "codigo" => "001",           
           "texto" => "API Key Inválida!"
          ];
          
          // Codificar Informações Erro
          $error = json_encode($error);
          
          // Retornar Informações Erro
          echo $error;
          
          // Finalizar Aplicação
          die;
        }
      
        // Setando Variável da KEYAPI
        $APIKey = $Route->params->hash;
      
        // Consultando Usuários relacionados a KEYAPI
        $Users = Controller::model("Users");       
        $Users->where("is_active","=","1")
              ->where("api_key","=",$APIKey)
              ->orderBy("id","ASC")
              ->fetchData(); 
      
       
        // Percorrer usuários
        foreach($Users->getDataAs("User") as $u){
          
          // Consulta de Orçamentos
          $Orders = Controller::model("Orders");       
          $Orders->where("responsavel","=", $u->get("id"))
                 ->orderBy("id","ASC")
                 ->fetchData(); 
          
          // Percorrer Produtos
          foreach($Orders->getDataAs("Order") as $o){

            // Pegar Variaveis Especificas do Produto          
            $Valores = json_decode($o->get("order_value"), true);  
            
            // Verificar Status Orçamento
            if ($o->get("status") == "1"){
              $Status = "Aprovado";
            } else if ($o->get("status") == "2") {
              $Status = "Em Análise";
            } else if ($o->get("status") == "3") {
               $Status = "Reprovado";
            } else if ($o->get("status") == "4") {
               $Status = "Vencido";
            } 
            
            // Criar Campo dos Produtos Orçados
            // Pegar Variaveis Especificas do Produto          
            $ProdutosCampo = json_decode($o->get("products_order"), true);  
            $DetalhesOrcamento = json_decode($o->get("product_details"), true);
            // Percorrer Produtos do Orçamento
            foreach($ProdutosCampo as $p){
              
              // Pegar Variaveis Especificas doS Produtos
              $PrecoTotal = preg_replace('#[^0-9\.,]#', '', $p['priceTotal']);
              $PrecoTotal = str_replace('.', '',$PrecoTotal);
              $PrecoTotal = str_replace(',', '.',$PrecoTotal); 
              
              // Setar informações que irão para API
              $ProdutosFinal[] = [
                "id_produto" => $p['id'],
                "nome" => $p['product'],
                "quantidade" => $p['quantidade'],
                "preco_total" => $PrecoTotal,
              ];
            } 
            
            // Setar informações do Orçamentos RESPOSTA API
            $Orcamentos[] = [
             "id" => $o->get("order_id"), 
             "status" => $Status,
             "id_responsavel" => $u->get("id"),
             "nome_responsavel" => $u->get("firstname"), 
             "cnpj_responsavel" => formata_cpf_cnpj($u->get("cpf/cnpj")),
             "produtos" => $ProdutosFinal, 
             "valor_total" => $Valores[0]['totalTotal'], 
             "kwp_real" => $DetalhesOrcamento[0]['kwpReal'],
             "data_orcamento" => $o->get("origem_date")            
            ];
          }
          
        }
      
        // Codificar Informações Orçamentos
        $Orcamentos = json_encode($Orcamentos);
        
        // Retornar Informações Orçamentos
        echo $Orcamentos;
    }
    
}