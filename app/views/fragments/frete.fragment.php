<?php $Cliente = json_decode($User->get("client")) ?>
<?php $Endereco = json_decode($Frete->get("endereco")) ?>
<?php $ClienteReal = json_decode($Frete->get("cliente")) ?>
<?php $Produtos = json_decode($Frete->get("produtos")) ?>
<?php $comissao = str_replace(".", "", $User->get("comissao_liquida")); $valor = $comissao / 100;  ?>



<div class='skeleton' id="frete">
  <form class="js-ajax-form-order" enctype="multipart/form-data" action="<?= APPURL . "/frete/" . $User->get("id") ?>" id="freteForm" method="POST">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id_original" value="<?= $User->get("id")?>">
    <input type="hidden" name="id_order" value="<?= $User->get("order_id")?>">
    <input type="hidden" name="frete" value="<?= $Frete->get("id") ?>">
    <input type="hidden" name="status_frete" value="<?= $Frete->get("status") ?>">

    <div class="row clearfix">
      <section class="section">
        <div class="section-content">
          <div class="form-result"></div>   
            <div class="mb-25" style="border-bottom:solid 1px #cecece">
              <span style="font-size:20px" class="form-label">Número: <?= $User->get("order_id") ?></span> 
            </div>

            <div class="clearfix mb-20">
              <div class="col s12 m6 m-last l2 mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Status do Orçamento") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina se o orçamento é aprovado ou não.") ?>">
                       <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <select class="input js-required select2 status" data-type="status" name="status">
                  <option value="2" selected <?= $AuthUser->canEditOrder($AuthUser) ? "" : "disabled" ?> <?= $Frete->get("status") == "2" ? "selected" : "" ?> >
                    <?= __("Em análise") ?>
                  </option>
                  
                  <option value="5" disabled <?= $Frete->get("status") == "5" ? "selected" : "" ?>>
                    <?= __("Campos Pendentes") ?>
                  </option>  
                  <option value="13" <?= $AuthUser->canEditOrder($AuthUser) ? "" : "disabled" ?> <?= $Frete->get("status") == "13" ? "selected" : "" ?>>
                     <?= __("Cotação Aprovada") ?>
                  </option>  
                  <option value="1" <?= $AuthUser->canEditOrder($AuthUser) ? "" : "disabled" ?> <?= $Frete->get("nota_liberada") == "1" ? "" : "disabled" ?> <?= $Frete->get("tipo_transporte") == "1" || $Frete->get("tipo_transporte") == "2" ? "" : "disabled" ?> <?= $Frete->get("status") == "1" ? "selected" : "" ?>>
                    <?= __("Aprovado") ?>
                  </option> 

                  <option value="3" <?= $AuthUser->canEditOrder($AuthUser) ? "" : "disabled" ?> <?= $Frete->get("nota_liberada") == "1" ? "" : "disabled" ?> <?= $Frete->get("status") == "3" ? "selected" : "" ?>>
                    <?= __("Reprovado") ?>
                  </option>   
                  
                  <option value="4" disabled <?= $Frete->get("status") == "4" ? "selected" : "" ?>>
                    <?= __("Vencido") ?>
                  </option> 
                  
                  <option value="10" disabled <?= $Frete->get("status") == "10" ? "selected" : "" ?>>
                    <?= __("Em Separação") ?>
                  </option>
                  
                  <option value="6" disabled <?= $Frete->get("status") == "6" ? "selected" : "" ?>>
                    <?= __("Separado para Envio") ?>
                  </option>  
                  
                  <option value="8" disabled <?= $Frete->get("status") == "8" ? "selected" : "" ?>>
                     <?= __("Despachado") ?>
                  </option>
                  
                  <option value="9" disabled <?= $Frete->get("status") == "9" ? "selected" : "" ?>>
                     <?= __("Despachado em Parte") ?>
                  </option>
                  
                  <option value="7" disabled <?= $Frete->get("status") == "7" ? "selected" : "" ?>>
                     <?= __("Entregue em Parte") ?>
                  </option> 
                  <option value="11" disabled <?= $Frete->get("status") == "11" ? "selected" : "" ?>>
                     <?= __("Entrega Realizada") ?>
                  </option>  
                </select>
              </div>   
               <div class="col s12 s-last m6 m-last l2 mb-20">
                <label class="form-label">                  
                      <?= __("Código Cliente Santri") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Código do cliente no santri") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>                        
                <input class="input" name="id_cliente_santri" maxlenght="11" onkeypress="onlynumber();" value="<?= $Frete->get("id_cliente_santri") ?>">           
              </div>  
                <div class="col s12 m6 m-last l2  mb-20">
                <label class="form-label"> 
                      <span class="compulsory-field-indicator">*</span> 
                      <?= __("Nrº do pedido (Santri)") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Número do pedido do Santri.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <input class="input" name="numero_santri" onkeypress="onlynumberrealy();" value="<?= $Frete->get("numero_pedido_santri") ?>" required>           
              </div> 
    
						
							<div class="col s12 s-last m6 m-last l2 mb-20">
                <label class="form-label">                  
                      <?= __("Número da NF ") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Número da NF de simples faturamento") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <input class="input" name="numero_nf" maxlenght="11" onkeypress="onlynumber();" value="<?= $Frete->get("numero_nf") ?>">           
              </div>
             <div class="col s12 s-last m6 m-last l2  mb-20">
                <label class="form-label">                  
                      <?= __("Nrº da NF (Remessa)") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Número da Nota Fiscal") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>                        
                <input class="input" name="numero_nf_remessa" maxlenght="11" onkeypress="onlynumber();" value="<?= $Frete->get("numero_nf_remessa") ?>">           
              </div>
                 <div class="col s12 m6 m-last l2 l-last mb-20"    >
                <label class="form-label">                 
                      <?= __("Tipo de Transporte") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Define o tipo de transporte") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <select class="input js-required select2 tipo_frete" name="tipo_transporte" >
                  <option value="0" disabled>
                    <?= __("Escolha uma opção") ?>
                  </option>
                  <option value="3" selected <?= $Frete->get("tipo_transporte") == "3" ? "selected" : "" ?>>  
                    <?= __("Cotação de Frete") ?>
                  </option>
                  
                  <option value="1" <?= $Frete->get("tipo_transporte") == "1" ? "selected" : "" ?> disabled>
                    <?= __("Frota Própria") ?>
                  </option>

                   <option value="2" <?= $Frete->get("tipo_transporte") == "2" ? "selected" : "" ?> disabled >
                    <?= __("Transportadora") ?>
                  </option>
                </select>                
              </div> 
                
              <div class="col s12 m6 l2 mb-20" <?= $Frete->get("tipo_transporte") != "2" ? "style='display:none'" : "" ?>>
                <label class="form-label">         
                      <span class="compulsory-field-indicator">*</span>
                      <?= __("Cotação Escolhida") ?>                    
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina qual a melhor cotação enviada.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
               <select class="input js-required select2" id="cotacao" name="cotacao">
                  <option value="0" disabled selected>
                    <?= __("Escolha uma opção") ?>
                  </option>
                  
                  <option value="1" <?= $Frete->get("cotacao") == "1" ? "selected" : "" ?> >
                    <?= __("Cotação 01") ?>
                  </option>

                  <option value="2" <?= $Frete->get("cotacao") == "2" ? "selected" : "" ?>>
                    <?= __("Cotação 02") ?>
                  </option>
                 
                  <option value="3" <?= $Frete->get("cotacao") == "3" ? "selected" : "" ?>>
                    <?= __("Cotação 03") ?>
                  </option>
                </select> 
              </div>
                
               <div class="col s12 m6 l2 mb-20 " id="transportadora" <?= $Frete->get("tipo_transporte") == "2" ? "" : "hidden" ?>>   
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Tipo de Frete") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina o tipo de frete.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                <select class="input js-required select2" id="cif_fob" name="cif_fob">
                  <option value="0" disabled selected>
                    <?= __("Escolha uma opção") ?>
                  </option>
                  
                  <option value="1" <?= $Frete->get("cif_fob") == "1" ? "selected" : "" ?>>
                    <?= __("CIF") ?>
                  </option>

                  <option value="2" <?= $Frete->get("cif_fob") == "2" ? "selected" : "" ?>>
                    <?= __("FOB") ?>
                  </option>
                </select>      
              </div>
               
               </div>
                   <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 20px;color: #51524f;font-weight: 600; line-height: 30px">Dados Financeiro</span>
              </div>
              <div class="clearfix">
                	<div class="col s12 s-last m6 m-last l2   mb-20">
                <label class="form-label">                  
                      <?= __("Valor Real do Pedido") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Valor Pedido") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>                        
                <input readonly class="input" name="valorPedido" maxlenght="11"  onInput="mascaraMoeda(event)"  value="<?= format_price($Frete->get("valor_pedido")) ?>">           
              </div>
               <div class="col s12 s-last m6 m-last l2  mb-20" >   
                <label class="form-label">     
                  <span class="compulsory-field-indicator" <?= $AuthUser->isSetorFinanceiro() ? "" : "style='display:none'" ?>>*</span>
                      <?= __("Nota está liberada") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina se a Nota já foi liberada pelo financeiro.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                <select class="input js-required select2" id="nota_liberada" name="nota_liberada">
                  <option value="0" disabled >
                    <?= __("Escolha uma opção") ?>
                  </option>
                   <option value="2" <?= $AuthUser->isSetorFinanceiro() ? "" : "disabled" ?> selected>
                    <?= __("Não") ?>
                  </option>
                  
                  <option value="1" <?= $AuthUser->isSetorFinanceiro() ? "" : "disabled" ?> <?= $Frete->get("nota_liberada") == "1" ? "selected" : "" ?>  >
                    <?= __("Sim") ?>
                  </option>
                </select>      
              </div>    
              <?php if($User->get("comissao_active") == 1): ?>
               <div class="col s12 s-last m6 m-last l2 mb-20">
                <label class="form-label">                  
                       Comissão Bruta
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Valor Comissão") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <input disabled class="input" name="" maxlenght="11" onkeypress="onlynumber();" value="<?= format_price($User->get("comissao"))?>">           
             </div>
             <div class="col s12 s-last m6 m-last l2  mb-20">
                <label class="form-label">                  
                       Comissão Liquida
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Valor Comissão Liquida") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>                        
                <input disabled class="input" name="" maxlenght="11" onkeypress="onlynumber();" value="<?= format_price($valor) ?>">           
              </div>
              <?php endif; ?> 
             
                
              </div>  
                
                
               <div class="clearfix">
                  <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Dados do Cliente Faturamento<span>
              </div>
             <div class="col s12 m6 l2 mb-20">
              <label class="form-label">
               <span class="compulsory-field-indicator">*</span> 
              <?= __("Nome do cliente") ?>
               </label>
              <input type="text" class="input" name="nome_cliente" value="<?= $ClienteReal->nome ? $ClienteReal->nome : $Cliente[0]->name ?>" required>   
             </div>
             <div class="col s12 m6 l2 mb-20">   
              <label class="form-label">
               <span class="compulsory-field-indicator">*</span>
              <?= __("CNPJ do cliente") ?>
              </label>
              <input required type="text" type="text" class="input" name="cnpj_cliente" onkeypress="onlynumberrealy();" onfocus="javascript: cleanFormat(this);" onblur="javascript: formatField(this);" value="<?= $ClienteReal->cnpj ? $ClienteReal->cnpj : formata_cpf_cnpj($Cliente[0]->cnpj) ?>" maxlength="14"> 
             </div>
             <div class="col s12 m6 l2 l2 mb-20" >   
              <label class="form-label">
                <span class="compulsory-field-indicator">*</span>
              <?= __("Telefone do cliente") ?>
              </label>
              <input required type="text" class="input" name="telefone_cliente" onkeypress="onlynumberrealy();" onfocus="javascript: cleanFormat(this);" onblur="javascript: formatTel(this);" value="<?= $ClienteReal->telefone ? $ClienteReal->telefone : formatar("fone", $Cliente[0]->phone) ?>" maxlength="12"> 
             </div>  
              <div class="col s12 m6 l3 l-last mb-20" >   
              <label class="form-label">
                <span class="compulsory-field-indicator">*</span>
              <?= __("Unidade Responsável Frete") ?>
              </label>
                  <select class="input select2" name="filial" required>        
								  <option value="" disabled selected>Escolha a unidade responsável pelo frete</option>
                    <?php foreach($Branch->getDataAs("Branch") as $k):?>
                      <option value="<?= $k->get("name") ?>"   <?= $Frete->get("filial") == $k->get("name") ? "selected"  : "" ?> ><?= $k->get("name") ?></option>
                    <?php endforeach;?>                                                                                                  
                </select>           
                </div>  
            </div>

            <div> 
          
             <div class="clearfix">   
              <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Endereço de Entrega</span>
              </div>
               <div class="col s12 m4 m-last l2 mb-20">   
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Tipo de Local") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina o tipo de local onde será entregue.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                <select class="input js-required select2" id="tipo_local" name="tipo_local" required>
                  <option value="0" disabled selected>
                    <?= __("Escolha uma opção") ?>
                  </option>
                  
                  <option value="comercio" <?= $Frete->get("tipo_local") == "comercio" ? "selected" : "" ?>>
                    <?= __("Comércio") ?>
                  </option>
                  
                  <option value="fazenda" <?= $Frete->get("tipo_local") == "fazenda" ? "selected" : "" ?>>
                    <?= __("Fazenda") ?>
                  </option>
                  
                  <option value="industria" <?= $Frete->get("tipo_local") == "industria" ? "selected" : "" ?>>
                    <?= __("Industria") ?>
                  </option>
                  
                  <option value="residencia" <?= $Frete->get("tipo_local") == "residencia" ? "selected" : "" ?> >
                    <?= __("Residência") ?>
                  </option>

                  <option value="zona rural" <?= $Frete->get("tipo_local") == "zona rural" ? "selected" : "" ?>>
                    <?= __("Zona Rural") ?>
                  </option>
                </select>      
              </div>  
                <div class="col s12 m6 m-last l2  mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("CEP de Entrega") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina o CEP para entrega.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <input required class="input cepField" type="text" name="cep_entrega" maxlength="10" onkeypress="onlynumberrealy();" onfocus="javascript: cleanFormat(this);" onblur="javascript: formatCep(this);" value="<?= formatar("cep", $Endereco->cep) ?>"> 
              </div>     
              <div class="col s12 m4 m-last l2 mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Endereço de Entrega") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina o endereço para entrega") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <input class="input logradouroField" type="text" name="endereco_entrega" value="<?= $Endereco->endereco ?>">           
              </div>
              <div class="col s12 m4 m-last l2 mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Bairro de Entrega") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina o nome do bairro para entrega.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <input class="input bairroField" type="text" name="bairro_entrega" value="<?= $Endereco->bairro ?>" required>           
              </div> 
              <div class="col s12 m6 m-last l2 mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Cidade de Entrega") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina o nome da cidade para entrega.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <input class="input localidadeField" type="text" name="cidade_entrega" value="<?= mb_convert_case($Endereco->cidade, MB_CASE_TITLE, "UTF-8")  ?>" required>            
              </div> 
              <div class="col s12 m6 m-last l2 l-last mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("UF de Entrega") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina a UF para entrega.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>   
                 <?php $EstadoFrete = $Endereco->uf ?>
                <select class="input js-required select2  estadoField" name="uf_entrega" required>
                  <option value="0" disabled selected>
                    <?= __("Escolha uma opção") ?>
                  </option>
                   <?php foreach($Estados->getDataAs("State") as $e): ?>
                   <option value="<?= strtoupper($e->get("uf"))?>" <?= $EstadoFrete == strtoupper($e->get("uf")) ? "selected" : "" ?> ><?= $e->get("name")?></option>                  
                  <?php endforeach; ?>
                </select>           
              </div>
        
              <div class="col s12 m12 m-last l12 l-last mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Observações de Entrega") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Detalhes adicionais sobre a entrega.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                  <textarea class="input" type="text" name="observacao" required ><?= $Frete->get("observacao") ?></textarea>           
              </div>    
                </div>
                <div class="clearfix" id="frota_propria" <?= $Frete->get("tipo_transporte") == "1" ? "" : "hidden" ?>>   
              <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Observações de Entrega</span>
              </div>            
              <div class="col s12 m6 m-last l3 mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Terá equipe no local para auxiliar no descarregamento?") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina se terá equipe no local para auxiliar na entrega.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
               <select class="input js-required select2" id="equipe_auxilio" name="equipe_auxilio">
                  <option value="0" disabled selected>
                    <?= __("Escolha uma opção") ?>
                  </option>
                  
                  <option value="1" <?= $Frete->get("equipe_auxilio") == "1" ? "selected" : "" ?> >
                    <?= __("Sim") ?>
                  </option>

                  <option value="2" <?= $Frete->get("equipe_auxilio") == "2" ? "selected" : "" ?>>
                    <?= __("Não") ?>
                  </option>
                </select>           
              </div>
              <div class="col s12 m6 m-last l3 mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Terá equipamento no local para auxiliar no descarregamento?") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina se será necessário equipamento para descarregar.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
               <select class="input js-required select2" id="equipamento_auxilio" name="equipamento_auxilio">
                  <option value="0" disabled selected>
                    <?= __("Escolha uma opção") ?>
                  </option>
                  
                  <option value="1" <?= $Frete->get("equipamento_auxilio") == "1" ? "selected" : "" ?> >
                    <?= __("Sim") ?>
                  </option>

                  <option value="2" <?= $Frete->get("equipamento_auxilio") == "2" ? "selected" : "" ?>>
                    <?= __("Não") ?>
                  </option>
                </select>           
              </div>
              <div class="col s12 m6 m-last l4 l-last mb-20">
                  <label class="form-label">                  
                      <?= __("Custo considerado quando tiver deslocamento da frota para distâncias fora do raio de atuação.") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina se o orçamento é aprovado ou não.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
               <input class="input" type="text" name="custo_considerado" value="<?= format_price($Frete->get("custo_considerado")) ?>">          
              </div>              
                </div>
               <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 20px;color: #51524f;font-weight: 600; line-height: 30px">Almoxarifado</span>
              </div>
              <div class="clearfix">
                 <div class="col s12 m6 l2 mb-20">   
                <label class="form-label">
                     <?= __("Valor Total do Frete") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina o valor total do frente") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                  <input disabled class="input" type="text" name="valor_total" value="<?= format_price($Frete->get("valor_total")) ?>">
              </div> 
                  <div class="col s12 m6 m-last l2 l-last mb-20">   
                <label class="form-label">
                   <?= __("Data de Validade") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina a data de validade para está cotação.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                  <input disabled class="input" type="date" name="data_validade" value="<?= $Frete->get("data_validade") ?>">
              </div>
                   </div> 
                
              <div class="clearfix" <?= $Frete->get("tipo_transporte") == "2" ? "" : "hidden" ?>>                  
              <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Dados de Entrega</span>
              </div>   
              
                <div class="col s12 m3 l3 mb-20">
                  <label class="form-label">
                     <?= __("Data Envio Encomenda") ?>
                        <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina a data de envio da encomenda.") ?>">
                        <span class="mdi mdi-help-circle"></span>
                    </label>

                    <input class="input" type="date" disabled name="data_envio" value="<?= $Frete->get("data_envio") ?>">           
                </div>  
                <div class="col s12 m3 l3 mb-20">
                  <label class="form-label">
                      <?= __("Data Previsão de Entrega") ?>
                        <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina a data de previsão máxima para entrega.") ?>">
                        <span class="mdi mdi-help-circle"></span>
                    </label>

                    <input class="input" type="date" disabled name="data_previsao" value="<?= $Frete->get("data_previsao") ?>">           
                </div>
                <div class="col s12 m3 m-last l3 mb-20">
                      <label class="form-label">
                        <?= __("Data de Entrega") ?>
                            <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina a data de entrega.") ?>">
                            <span class="mdi mdi-help-circle"></span>
                        </label>

                        <input class="input" type="date" name="data_entrega" value="<?= $User->get("data_entrega") ?>" disabled>          
                   </div> 
                   <div class="col s12 m4 m-last l3 l-last mb-20">
                      <label class="form-label">
                         <?= __("Código Rastreamento") ?>
                            <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina o código de rastreio da encomenda.") ?>">
                            <span class="mdi mdi-help-circle"></span>
                        </label>

                        <input class="input" readonly type="text" name="rastreamento" value="<?= $User->get("rastreamento") ?>">          
                   </div>   
                </div> 
                   <div class="clearfix">
                    <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                      <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Arquivos Úteis<span>
                    </div>
                         <div class="col s12 m3 l3 mb-20">
                          <label class="form-label"> <?= __("NOTA FISCAL:") ?> </label>
                          <input name="arquivoNF" type="file"/><br />
                          <?php if($Frete->get("arquivo_nf")): ?>  
                           <a class="iframe-popup" href="<?= $Frete->get("arquivo_nf") ?>">
                           <div style="z-index:99999999";  class="iframe-popup" src="<?= $Frete->get("arquivo_nf") ?>" >
                            <embed class="iframe-popup" src="<?= $Frete->get("arquivo_nf") ?>" style="width:100px;margin-top:8px">                          
                            <label class="form-label"> 
                            <?= __("Imagem Nota Fiscal atual") ?>
                            </label>
                           </div>
                          </a> 
                           
                          <?php endif; ?>
                        </div>
                       <div class="col s12 m3 l3 mb-20 ArquivoCotacao" <?= $Frete->get("tipo_transporte") == "2" ? "" : "hidden" ?>>
                          <label class="form-label"> <?= __("COTAÇÃO TRANSPORTADORA 01:") ?> </label>
                         
                          <?php if($Frete->get("arquivo_cotacao")): ?> 
                        	<div class="zoom-gallery">
	                         <a href="<?= $Frete->get("arquivo_cotacao") ?>" title="Cotação 1" style="width:82px;height:125px;">
                            <img width="50%" height="50%" style="border-radius:20px;" src="<?= $Frete->get("arquivo_cotacao") ?>" alt="Cotação 1">                  
	                         </a>
                          </div>
                         <?php endif; ?>
                       </div>
                        <div class="col s12 m3 l3 mb-20 ArquivoCotacao"  <?= $Frete->get("tipo_transporte") == "2" ? "" : "hidden" ?>>
                          <label class="form-label"> <?= __("COTAÇÃO TRANSPORTADORA 02:") ?> </label>
                         
                          <?php if($Frete->get("arquivo_cotacao2")): ?>
                          <div class="zoom-gallery">
	                         <a href="<?= $Frete->get("arquivo_cotacao2") ?>" title="Cotação 2" style="width:82px;height:125px;">
                            <img width="50%" height="50%" style="border-radius:20px;" src="<?= $Frete->get("arquivo_cotacao2") ?>" alt="Cotação 2">                  
	                         </a>
                          </div>
                          <?php endif; ?>
                       </div>
                        <div class="col s12 m3 m-last l3 l-last mb-20 ArquivoCotacao" <?= $Frete->get("tipo_transporte") == "2" ? "" : "hidden" ?>>
                          <label class="form-label"> <?= __("COTAÇÃO TRANSPORTADORA 03:") ?> </label>
                       
                          <?php if($Frete->get("arquivo_cotacao3")): ?>
                         <div class="zoom-gallery">
	                         <a href="<?= $Frete->get("arquivo_cotacao3") ?>" title="Cotação 3" style="width:82px;height:125px;">
                            <img width="50%" height="50%" style="border-radius:20px;" src="<?= $Frete->get("arquivo_cotacao3") ?>" alt="Cotação 3">                  
	                         </a>
                          </div>
                          <?php endif; ?>
                       </div>
                  </div>
                  <?php $Produtos = json_decode($Frete->get("produtos")) ?>   
                  <div class="clearfix mb-25" <?= $Frete->get("status") >= "6" ? "" : "style='display:none'"?>>
                    <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                      <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Produtos Logistica<span>
                    </div>
                    <table>
                      <thead>
                        <tr>
                          <th>Produto</th> 
                          <th>Quantidade Total</th>
                          <th>Quantidade Pendente</th>
                          <th>Quantidade NF Gerada</th>   
                          <th>Situação Entrega</th> 
                        </tr>
                      </thead>  
                      <tbody>
                       <?php foreach($Produtos as $p): ?>
                        <tr>
                        <td><?= "(" . $p->idProduto . ") - " . $p->nomeProduto  ?></td>
                          <td><?= $p->quantidadeTotal ?></td>
                          <td><?= $p->quantidadePendente ?></td>
                          <td><?= $p->quantidadeEntregue ?></td>                         
                          <?php if($p->quantidadePendente != ""): ?>
                          <td>Pendente de Entrega</td>
                          <?php else: ?>
                            <?php if($p->nomePessoaRecebeu != ""): ?>
                              <td>Recebido por: <?= $p->nomePessoaRecebeu ?></td>
                            <?php else: ?>
                              <td>Em Processo de Entrega</td>
                            <?php endif; ?>
                          <?php endif; ?>                          
                        </tr>
                       <?php endforeach; ?> 
                      </tbody>  
                    </table> 
                  </div>         
                  
            </div> 
                 
          <div class="clearfix" style="text-align: -webkit-center;">
             <div class="col s12 m12 l12">
                 <input class="button button--oval" type="submit" value="<?= __("Confirmar Orçamento") ?>">
             </div>
          </div>
        </div>
    </div>
    </section>
</div>
</form>
</div>