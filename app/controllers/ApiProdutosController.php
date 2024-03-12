<?php

class ApiProdutosController extends Controller
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
        if ($Route->params->hash != "341a2ad0ef4f621b2f9d93c4dfd0ca1a05b149d4"){
          
          // Setar informações do erro
          $error[] = [
           "codigo" => "001",
           "nome" => "API Key Inválida",
           "texto" => "API Key Inválida!"
          ];
          
          // Codificar Informações Erro
          $error = json_encode($error);
          
          // Retornar Informações Erro
          echo $error;
          
          // Finalizar Aplicação
          die;
        }
      
        // Consulta de Produtos
        $Products = Controller::model("Products");       
        $Products->where("name","!=","")
                 ->where("is_active","=","1")
                 ->orderBy("name","ASC")
                 ->fetchData();        
      
        // Percorrer Produtos
        foreach($Products->getDataAs("Product") as $p){
          
          // Pegar Variaveis Especificas do Produto
          $Preco = preg_replace('#[^0-9\.]#', '', $p->get("price"));          
          $Financas = json_decode($p->get("finance"), true);
           
          // Verificar se o Produto é Painel
          if ($p->get("product_type") == "Painel"){
           $Painel = "S";  
          } else {
           $Painel = "N";  
          }
          
          // Setar informações do Produto RESPOSTA API
          $Produtos[] = [
           "id" => $p->get("id"),
           "nome" => $p->get("name"),
           "tipo_produto" => $p->get("product_type"), 
           "modelo_produto" => $p->get("product_model"),
           "fabricante" => $p->get("producer"),
           "ncm" => $p->get("ncm"),
           "garantia" => $p->get("garantia"),
           "preco" => $Preco,
           "descricao" => $p->get("description"),
           "peso" => $p->get("peso"),
           "altura" => $p->get("altura"), 
           "comprimento" => $p->get("comprimento"),
           "largura" => $p->get("largura"),
           "watts" => $Financas['watts'],
           "va" => $Financas['va'],
           "kit" => $Painel,  
           "datasheet" => $p->get("datasheet"), 
          ];
        }
      
        // Codificar Informações Produto
        $Produtos = json_encode($Produtos);
        
        // Retornar Informações Produto
        echo $Produtos;
    }
    
}