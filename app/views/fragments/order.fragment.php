<?php
  if ($User->isAvailable()) {
     $order_id = $User->get("order_id"); $version = $User->get("version"); $status_order = "1"; $expirate_date = $User->get("expirate_date"); $delivery_date = $User->get("delivery_date");
  } else {                                                
     $order_id = ""; $version = "1.0"; $status_order = "0"; $expirate_date = date("d-m-Y", strtotime("+2 days")); $delivery_date = date ("d-m-Y", strtotime("+30 days"));
  }
?>
  
<div class='skeleton' id="order">

  <form  class="js-ajax-form-order" action="<?= APPURL . "/order" ?>" id="orderForm" method="POST">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="vrf" id="vrf" value="padrao">
    <div class="idoc">
    </div>
    <div class="row clearfix">
      <section class="section">
        <div class="section-content">
          <div class="form-result"></div>   
            <div  style="border-bottom:solid 1px #cecece" class="mb-40">
              <input type="hidden" name="isv" id="isv" >
              <span style="font-size:20px" class="form-label">Número  <?= $rascunho == 1 ? "do Rascunho: " : "do Orçamento: "?> <?= $order_id ?></span>
              <?php if($status_order == "1" && $User->get("status") != "4" && $rascunho == 0 ):?>
            <label class="form-label2" style= "position:absolute; "><?= __("Versão: v." . $version) ?> </label>
              
            <label class="form-label3" style="display: flex; justify-content: flex-end ">
              
              <a class="duplicar" id="1" href="javascript:void(0)"> <span class="mdi mdi-content-copy pos-order" title="<?= __("Duplicar Proposta.") ?>"></span> </a>
              <a class="imprimirPDF" href="<?= APPURL."/budget/".$User->get("id") ?>"> <span class="mdi mdi-printer pos-order" title="<?= __("Gerar proposta.") ?>"></span> </a>
                       
              <?php endif; ?>     
            </div>

            <div  class="clearfix mb-20">
              <div <?= $User->get("status") == 1 && !$AuthUser->isAdmin()  ? "hidden" : ""?> id="divStatus"  class="col s12 m8 m-last l2 mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Status do Orçamento") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determina se o orçamento é aprovado ou não.") ?>">
                                                          <span class="mdi mdi-help-circle"></span>
                                                </label>
                  
                  

                <select  class="input js-required select2 status calcPrice" id="statusOrcamento" data-type="status" name="status">

                <option value="2" <?= !$User->get("status") == "2" ? "selected" : "" ?> >
                  <?= __("Em análise") ?>
                </option>

                <option value="1" <?= $status_order == "0" ? "disabled" : ""?> <?= $User->get("status") == "4" ? "disabled" : ""?> <?= $User->get("status") == "1" ? "selected" : "" ?>>
                  <?= __("Aprovado") ?>
                </option> 

                <option value="3" <?= $status_order == "0" ? "disabled" : ""?> <?= $User->get("status") == "4" ? "disabled" : ""?> <?= $User->get("status") == "3" ? "selected" : "" ?>>
                  <?= __("Reprovado") ?>
                </option>   

                 <option value="4" <?= $status_order == "0" ? "disabled" : ""?> disabled <?= $User->get("status") == "4" ? "selected" : "" ?>>
                  <?= __("Vencido") ?>
                 </option>
                  
              </select>
                  
              </div>

              <div  class="col s12 m8 l3 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Cliente:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione o cliente que já foi cadastrado.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                          </label>
                <?php $Cliente = json_decode($User->get("client")); ?>
                <?php $PayDetails = json_decode($User->get("payment_details")); ?>
                <?php $ProdDetails = json_decode($User->get("product_details")); ?>
                <?php $ProdOrder = json_decode($User->get("products_order")); ?>
                <?php $ProdTotal = json_decode($User->get("order_value")); ?>
                <?php $TipoKit = $PayDetails[0]->typeOrder ?>  
                <select onchange="autosave()"  id="cliente" class="autosave input select2 selectCliente calcPrice typeOrderKit" name="client">                   
                   <option data-id="<?= $Cliente[0]->id ?>" value="<?= $Cliente[0]->id ?>" selected ><?= $Cliente[0]->name . " - " . formata_cpf_cnpj($Cliente[0]->cnpj) ?></option>                 
                </select>
              </div>

              <div class="col s6 m6 l2 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Tipo de Cliente:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Informa qual tipo de cliente  foi cadastrado.") ?>">
                                                        <span class="mdi mdi-help-circle" ></span>
                                              </label>

                <input onchange="autosave()" id="tipoClient" class="autosave input inputType type-client" value="<?= $Cliente[0]->type ?>" name="tipoClient" readonly>
              </div>
              <div class="col s6 s-last m6 m-last l1">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("UF:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Informa qual UF o cliente foi cadastrado.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                          </label>
                <input onchange="autosave()" id="ufClient" class="input inputUF" value="<?= strtoupper($Cliente[0]->uf) ?>" name="ufClient" readonly>
              </div>
                
                <div class="col s12 m8 l2 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Uso e Consumo:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione para uso e consumo proprio ou não.") ?>">
                                                        <span class="mdi mdi-help-circle" ></span>
                                          </label>
                <select onchange="autosave()" id="usoconsumo" class="autosave input select2 use-consume calcPrice typeOrderKit" name="use-consume">
                                                 <option value="" disabled hidden>Escolha</option> 
                                                  <option selected value="Não" <?= $PayDetails[0]->useConsume == "Não" ? "selected" : "" ?>><?= __("Não") ?></option>
                                                  <option value="Sim" <?= $PayDetails[0]->useConsume == "Sim" ? "selected" : "" ?>><?= __("Sim") ?></option>                                                
                                              
                                              </select>
              </div>
               <?php if($AuthUser->get("account_type") != "integrador"): ?>   
               <div class="col s12 m6 l2 l-last mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("ID santri:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Digite o código do Santri para esse orçamento") ?>">
                                                        <span class="mdi mdi-help-circle" ></span>
                                              </label>
                <input onchange="autosave()" id="santri_cod" class="autosave input santri_id" value="<?= $User->get("santri_id") ?>" name="santri_id">
              </div>
              <?php endif; ?>   
                  
              
            </div>

            <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
              <span class="form1-label" >Condição de equipamento:</span>
            </div>
            <div class="clearfix mb-20">
              <div class="col s12 m4 l2 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Tipo de Orçamento:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione se o orçamento irá utilizar unidade ou kit.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                              </label>
                <select onchange="autosave()" id="tpOrcamento" class=" autosave input select2 type-order calcPrice typeOrderKit" name="tipo_orcamento">
                                                 <option value="" selected disabled hidden>Tipo de Orçamento</option> 
                                                  <option value="Unidade" <?= $TipoKit == "Unidade" ? "selected" : "" ?>><?= __("Unidade") ?></option>
                                                <optgroup label="Kits">
                                                  
                                                  <?php foreach($ProductKits->getDataAs("ProductKit") as $k):?>
                                                    <option value="<?= $k->get("id") ?>" <?= $TipoKit == $k->get("id") ? "selected" : "" ?>><?= $k->get("name") ?></option>
                                                  <?php endforeach;?>
                                                </optgroup>                                                  
                                              </select>
              </div>
                            <div class="col s12 s-last m4 m-last l2 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Fabricante Kit Fixação:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione o fabricante do kit de fixação.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                              </label>
               
                <select onchange="autosave()" id="selectkitprod" class="autosave input select2 changeKit producerKit selectProducerKit " name="producer_kit">
                   <option value="" selected disabled hidden>Selecione o fabricante</option>                                                 
                    <?php foreach ($ProdKit as $pk): ?> 
                    <option value="<?= $pk ?>" <?= $ProdDetails[0]->producerKit == $pk ? "selected" : "" ?>  ><?= strtoupper($pk) ?></option> 
                  <?php endforeach; ?>
                </select>              
              </div>  
             <div class="col s12 m4 l2 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Fabricante de Inversor:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione o fabricante do inversor.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                              </label>
                  
                <select onchange="autosave()" id="fabricanteInversor" class="autosave input select2 producerInversor changeInversor selectProducerInversor typeOrderKit" name="producer_inversor">
                                                 <option value="" selected disabled hidden>Selecione o fabricante</option>                                                 
                                                  <?php foreach ($ProdInversor as $pi): ?>                                                 
                                                  <option value="<?= $pi ?>"  <?= $ProdDetails[0]->producerInversor == $pi ? "selected"  : "" ?> ><?= strtoupper($pi) ?></option>  
                                                <?php endforeach; ?>
                </select>
              </div> 
             <div id="div_tensao" class="col s12 m4 l2 mb-20" hidden>
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Tensão da Rede:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determina a tensão da rede.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                              </label>
                <select  onchange="autosave()" id="tensao" class=" autosave input select2  changeFase changeAcoplador" name="tensao">
                                                 <option value="" selected disabled hidden>Selecione a tensão da rede</option>                         
                                                  <option value="1" <?= $ProdDetails[0]->tensao == 1 ? "selected"  : "" ?>   >TRI 380V </option>  
                                                  <option value="2" <?= $ProdDetails[0]->tensao == 2 ? "selected"  : "" ?> >BI 380V </option> 
                                                   <option value="3"<?= $ProdDetails[0]->tensao == 3 ? "selected"  : "" ?> >TRI 220V </option> 
                                                  <option value="4" <?= $ProdDetails[0]->tensao == 4 ? "selected"  : "" ?> >BI 220V </option> 
                                                  <option value="5" <?= $ProdDetails[0]->tensao == 5 ? "selected"  : "" ?>>MONO 220V </option> 
                                          
                </select>
              </div> 
               <div id="div_cc" class="col s12 m4 l2 mb-20" hidden>
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Considerar cabos e conectores?") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determina se irá calcula conectores e cabos") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                              </label>
                <select  onchange="autosave()" id="medir_cc" class="autosave input select2  calcPrice changeConsidera" name="medir_cc">
                                                 <option value="" selected disabled hidden>Selecione</option>                         
                                                  <option value="1" <?= $ProdDetails[0]->medir_cc == 1 ? "selected"  : "" ?>  >Sim </option>  
                                                  <option value="2" <?= $ProdDetails[0]->medir_cc == 2 ? "selected"  : "" ?> >Não </option> 
                                                
                                          
                </select>
              </div>   
               <div id="div_consumo" class="col s12 m4 l2 l-last  mb-20" hidden>
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Medir Consumo?") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determina se ira medir consumo ou não.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                              </label>
                <select  onchange="autosave()" id="medir" class="autosave input select2 calcPrice  changeTC" name="medir">
                                                 <option value="" selected disabled hidden>Selecione</option>                         
                                                  <option value="1" <?= $ProdDetails[0]->medir == 1 ? "selected"  : "" ?>  >Sim </option>  
                                                  <option value="2" <?= $ProdDetails[0]->medir == 2 ? "selected"  : "" ?> >Não </option> 
                                                
                                          
                </select>
              </div>  
              <div id="div_fases" class="col s12 m4 l2 mb-20" hidden>
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Fases utilizadas nos Micros:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determina as fases utilizadas para conexão dos micros") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                              </label>
                <select  onchange="autosave()" id="fases" class="autosave input select2  calcPrice changeAcoplador" name="fases">
                                                 <option value="" selected disabled hidden>Selecione</option>                         
                                                  <option value="1" <?= $ProdDetails[0]->fases == 1 ? "selected"  : "" ?>  >1 (L1) </option>  
                                                  <option value="2" <?= $ProdDetails[0]->fases == 2 ? "selected"  : "" ?> >2 (L1 e L2) </option> 
                                                  <option value="3" <?= $ProdDetails[0]->fases == 3 ? "selected"  : "" ?> >3 (L1, L2 e L3)</option> 
                                                
                                          
                </select>
              </div>    

              <div class="col s12 m4 l2 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Tipo de Telha:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione o tipo do material da telha.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                              </label>

                <select onchange="autosave()" id="selectkittipo" class="autosave input select2 changeKit model-select " name="model_select">
                                                 <option value="" selected disabled hidden>Tipo de telhas</option>                                                 
                                                  <?php foreach ($ProdModel->getDataAs("ProductModel") as $Ms) : ?>
                                                  <option value="<?= $Ms->get("name") ?>" <?= $ProdDetails[0]->modelType == $Ms->get("name") ? "selected" : "" ?> ><?= $Ms->get("name") ?></option>
                                                <?php endforeach; ?>
                                              </select>
                
              </div>
              <div id="div_fCabo" class="col s12 m4 l2  mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Fabricante de Cabo:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione o fabricante do inversor.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                              </label>
   
                <select onchange="cabo()" onchange="autosave()" id="fabricanteCabo" class="autosave input select2 producerCabo  selectProducerCabo typeOrderKit" name="producer_cabo">
                                                 <option value="" selected disabled hidden>Selecione o fabricante</option>                                                 
                                                  <?php foreach ($ProdCabo as $pc): ?>                                                 
                                                  <option value="<?= $pc ?>"  <?= $ProdDetails[0]->producerCabo == $pc ? "selected"  : "" ?> ><?= strtoupper($pc) ?></option>  
                                                <?php endforeach; ?>
                </select>
              </div>  
              <div class="col s12 s-last m4 m-last l2 l-last pos-r">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Potência (KwP):") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione a potência em Watt-pico.") ?>">
                                                        <span class="mdi mdi-help-circle" ></span>
                                              </label>

                <input onchange="autosave()" onblur="caboKwp()" onkeypress="onlynumberfull();" data-type="kwp" class="autosave input rightpad calcPrice power typeOrderKit" id="kwp" name="power" value="<?= $User->get("power") ?>">                
                <input onchange="autosave()" type="hidden" class="input rightpad tipoConta" value="<?= $AuthUser->get("account_type") ?>"> 
                <a href="javascript:void(0)">
                <span class="sli sli-bulb field-icon--right calculatorKwp" style="bottom: 3px;right: 5px;padding:3px;width:20px;height:20px; background-color: #51524f;color:#fff;border-radius:50px;cursor:pointer;position:absolute;"></span>
                </a>  
              </div>
            </div>

            <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece; font-size:15px;">
              <span class="form1-label">Condições de Pagamento</span>
            </div>

            <div class="clearfix mb-20">
              <div class="col s12 m4 l4 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Filial de Origem:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione a origem da filial de saída do produto.") ?>">
                                                        <span class="mdi mdi-help-circle" ></span>
                                              </label>

<!--                 <select onchange="autosave()" id="filialOrigem" class="autosave input  uf-branch calcPrice " name="branch_origin" required>
                                                    <option selected readonly>Filial Brasilia</option>
                                              </select> -->
                   <input onchange="autosave()" id="filialOrigem" class="autosave input2  uf-branch calcPrice " name="branch_origin" value="Filial Brasilia" readonly required>
   
              </div>
                <div class="col s12 m4 l4 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Destino do frete:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione o estado de destino do frete.") ?>">
                                                        <span class="mdi mdi-help-circle" ></span>
                                              </label>
                <select onchange="autosave()" id="destinoFrete" class=" autosave input select2 ufFrete calcPrice " name="destiny_frete">
                   <option value="" selected disabled hidden>Destino do Frete</option>                    
                    <?php foreach($Fretes->getDataAs("Shipp") as $k): ?>
                      <option value="<?= $k->get("id") ?>" <?= $User->get("uf_frete") == $k->get("id") || $k->get("id") == 56 ? "selected"  : "" ?>><?= $k->get("name") ?></option>
                    <?php endforeach;?>                                                                                                  
                </select>
                  
              </div>

              <div class="col s12 m4 l4 l-last mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Condição Pagamento:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Escolha a forma de pagamento.") ?>">
                                                        <span class="mdi mdi-help-circle" ></span> 
                                              </label>

                <select onchange="autosave()" id="pagamento" class="autosave input select2 paymentMode calcPrice " name="payment_select">
                                                 <option value="" selected disabled hidden>Selecione uma forma pagamento</option>  
                  
                                                  <?php foreach ($Payment->getDataAs("Payment") as $pay): ?>
                                                  
                                                  <option value="<?= $pay->get("id") ?>" <?= $PayDetails[0]->paymentTerms == $pay->get("id") ? "selected" : "" ?> ><?= $pay->get("name") ?></option>
                                                <?php endforeach; ?>
                   
                                              </select>
              </div>  
             <?php $link = $this->linkFinanciamentoEstatico($PayDetails[0]->paymentTerms) ?>                  
              <div <?= $link != "" ? "" : "style='display:none'" ?> id="divFinanciamento" class="col s12 m4 l2 mb-20" style="padding-top:8px !important;">
                <a href="<?= $link ?>" id="linkFinan" target="_blank"><input class="button button--oval" style="background-color:#585858;border: 1px #585858" value="Simular Financiamento" readonly></a>
              </div>  
                
                <div class="col s12 m12 l12 l-last">
                                <label class="form-label"><?= __("Detalhes do Orçamento") ?>
                                  <span class="tooltip tippy"
                                          data-position="top"
                                          data-size="small"
                                          title="<?= __('Escreva observações importantes que sera exibida na proposta.') ?>">
                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                        </label>

                                <textarea onchange="autosave()" class="autosave input description"
                                          name="description"
                                          maxlength="255"
                                          rows="3"><?= $User->get("order_description") ?></textarea>

                                <ul class="field-tips">
                                    <li><?= __("Escreva anotações sobre o orçamento.") ?></li>
                                </ul>
              </div>
              <div class="col s12 m12 l12 l-last mb-20">
                  <label class="form-label"><?= __("Detalhes Proposta") ?>
                    <span class="tooltip tippy"
                            data-position="top"
                            data-size="small"
                            title="<?= __('Escreva observações importantes a constarem no orçamento.') ?>">
                            <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                          </label>

                  <textarea onchange="autosave()" class="autosave input descriptionP"
                            name="descriptionP"
                            maxlength="255"
                            rows="3"><?= $User->get("descriptionP") ?></textarea>

                  <ul class="field-tips">
                      <li><?= __("Escreva anotações para a proposta.") ?></li>
                  </ul>
              </div>   
            
               
            </div>
                
              
            <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece; font-size:15px;">
              <span class="form1-label">Detalhes vendedor</span>
            </div>
           <div class="clearfix mb-20">
             <div class="col s12 s-last m12 m-last l3 mb-20">
                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Vendedor:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Informa qual vendedor cadastrou o cliente.") ?>">
                                                        <span class="mdi mdi-help-circle"></span>
                                                  

                                              </label>     
                   <select onchange="autosave()" id="vendedorS" class="calcPrice autosave input select2 seller" name="vendedor">
                     <option class="input" selected disabled hidden>Escolha o Vendedor</option>
                      <?php foreach($Usuarios->getDataAs("User") as $k):?>
                         <?php if($User->get("responsavel") == null): ?>
                        <option class="input" data-id="<?= $k->get("id") ?>" <?= $AuthUser->get("id") == $k->get("id")  ? "selected" : "" ?> ><?= $k->get("firstname") . " " . $k->get("lastname") . "  (".ucFirst($k->get("office")) .")" ?></option>
                       <?php else: ?>
                         <option class="input" data-id="<?= $k->get("id") ?>" <?= $User->get("responsavel") == $k->get("id")  ? "selected" : "" ?> ><?= $k->get("firstname") . " " . $k->get("lastname") . "  (".ucFirst($k->get("office")) .")" ?></option>
                       <?php endif; ?>
                     <?php endforeach;?>                    
                   </select>
              </div>
             <div class="col s12 s-last m12 m-last l3">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Venda Comissionada") ?>
                                                <span class="tooltip tippy"
                                                      type="number"
                                                      data-position="top"
                                                      data-size="small"                                                      
                                                      title="<?= __("Insira um valor de comissão.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                           <select onload="comissaoS()" onchange="autosave()" class="autosave input select2 comissaoActive calcPrice" id="comissaoActive" name="comissao_active" > 
                                                 <option value="0" <?= $User->get("comissao_active") == "0" ? "selected" : "" ?> selected>Não</option> 
                                              <optgroup label="Sim">
                                    
                                                  <option value="1" <?= $User->get("comissao_active") == "1" ? "selected" : "" ?> ><?= __("Valor Cheio (R$)") ?></option>
                                                 </optgroup>                                                                                                  
                                            </select>
                                        </div>
               <div class="col s12 s-last m12 m-last l3">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Comissão") ?>
                                                <span class="tooltip tippy"
                                                      type="number"
                                                      data-position="top"
                                                      data-size="small"                                                      
                                                      title="<?= __("Insira um valor de comissão.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input onchange="autosave()"  id="comissao" class="autosave input js-required comissao calcPrice"
                                                   name="comissao"
                                                   type="text"
                                                   
                                                   onkeypress="onlynumberfull();"
                                                   value=" <?= $User->get("comissao") == "0" ? "0" : $User->get("comissao")?>" >                                                 
                                        </div>
                
                
     
            <div class="col s12 s-last m12 m-last l3 l-last">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Comissão Liquida") ?>
                                                <span class="tooltip tippy"
                                                      type="number"
                                                      data-position="top"
                                                      data-size="small"                                                      
                                                      title="<?= __("Comissão Liquida.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>
                                             <input onchange="autosave()"  id="precoTotalComissao" value="<?= $User->get("comissao_liquida") ?>" class="input    row-total  "  readonly>
                                                                                        
                                        </div>
                
                
               
            </div>
             
            <div class="clearfix mb-20" style="border-bottom:solid 1px #cecece">
              <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #2a3f54;font-weight: 500; line-height: 17px">Descrição da Proposta</span>
            </div>
                
              <div class="clearfix mb-20">  
                <div class="col s12 s-last m12 m-last l3">
                  <label class="form-label">
                        <?= __("KWp Real") ?>
                    </label>
                 <input onchange="autosave()" class="input2 rightpad calcPrice kwpReal typeOrderKit" value="<?= $ProdDetails[0]->kwpReal ?>" readonly>
                </div>  
                <div <?= $AuthUser->isAdmin() ? "" : "hidden" ?> class="col s12 s-last m12 m-last l3">
                                            
                                            <label class="form-label">
                                                <?= __("Margem") ?>
                                            </label>

                                           <input onchange="autosave()" class="input2 margemLucro" value="<?= $ProdTotal[0]->margemLucro ?>"
                    maxlength="50" readonly>
                 </div>
                 <div <?= $AuthUser->isAdmin() ? "" : "hidden" ?> class="col s12 s-last m12 m-last l3">
                                            
                                            <label class="form-label">
                                                <?= __("Margem Real Produtos") ?>
                                            </label>

                                           <input id="margemRealProdutos" onchange="autosave()" class="input2 " value="<?= $User->get("margem_real") ?>"
                    maxlength="50" readonly>
                 </div>
                  <div class="col s12 s-last m12 m-last l3 l-last"  <?= $AuthUser->isMaster() ? "" : "hidden" ?>>
                                            
                    <label class="form-label">
                        <?= __("Desconto") ?>
                    </label>

                   <input onchange="autosave()"   id="desconto" <?= $AuthUser->isMaster() ? "" : "hidden" ?> style="background-color:#fbfbfb" class="autosave input2 calcPrice desconto" value="<?= $ProdTotal[0]->desconto ?>" maxlength="5" >
                 </div>
                       
                  
                </div>
            <div class="clearfix mb-20 table-responsive" style="overflow-x:auto;">
              <table id="orderTable" border="1" class="ps-table table-responsive table table-hover display nowrap" style="margin-top:30px;">  
                <thead>
                  <tr>
                    <th style="width:40%">Produto</th>
                    <th>DataSheet</th>
                    <th>Quantidade <span id="renewQNT"  class="mdi mdi-autorenew calcPrice" data-type="renew" style="font-size:14px;cursor:pointer;"></span></th>
                    <th id="pUnitario" <?= $TipoKit == "Unidade" || $User->get("status") == 1  ? "" : "hidden" ?>>Preço Unitário</th>     
                    <th id="pTotal" <?= $TipoKit == "Unidade" || $User->get("status") == 1  ? "" : "hidden" ?>>Preço Total</th>
                    <th hidden>Preço Sem A</th>
                    <th hidden>Margem de Lucro</th>
                    <th style="width:10%" hiddenstyle="color:#fff; width:10%">Ações</th>
                  </tr>
                  </thead>
                <tbody class="table_order_pos">
                  <?php if($status_order == "1"):?>
                    <?php $OrcamentoFeito = json_decode($User->get("products_order")); ?>                 
                      <?php foreach($OrcamentoFeito as $o): ?>
                   <?php if($o->id != ""): ?>
                   <?php $classPainel = "sem"; ?>  
                        <?php $Produto = $this->InfoProduto($o->id); 
                              $urlProduto = $Produto->get("datasheet");?> 
                       <?php if(strpos($Produto->get("name"), 'CONECTOR MACHO') !== false): ?> 
                       <?php $tipoProduto = "ConectorMachotr"; ?>
                       <?php elseif(strpos($Produto->get("name"), 'CONECTOR FEMEA') !== false): ?> 
                       <?php $tipoProduto = "ConectorFemeatr"; ?>
                       <?php elseif(strpos($Produto->get("name"), 'ACOPLADOR') !== false): ?> 
                       <?php $tipoProduto = "acopladorTD"; ?>
                       <?php elseif(strpos($Produto->get("name"), 'PAINEL') !== false): ?> 
                       <?php $classPainel = "SelecPainel"; ?>
                       <?php elseif(strpos($Produto->get("name"), 'STRING BOX') !== false): ?> 
                       <?php $classPainel = "stringbox"; ?>
                       <?php else: ?>
                       <?php $tipoProduto = preg_replace("/\s+/", "", $Produto->get("product_type"));  ?>
                              
                  
                      <?php endif; ?>
                  
                  
                        <tr id="<?= $tipoProduto ?>" data-type="<?= $tipoProduto ?>">                          
                          <td style="color:#000">
                            <select onchange="calcPrice()" onchange="autosave()" id="<?= $tipoProduto ?>" class="<?= $classPainel ?>  autosave  select-table selectProduct calcPrice select3">
                              <option value="0"><?= $Produto->get("product_type") ?></option>
                              <?php foreach ($Prod->getDataAs("Product") as $key): ?>
                             
                              
                                <?php if ($key->get("product_type") == $Produto->get("product_type")) :?>
                                <option value="<?= $key->get("id") ?>" <?= $Produto->get("id") == $key->get("id") ? "selected" : "" ?>>                                
                                  <?= "(" . $key->get("santri_cod") . ") " . $key->get("name") ?></option>
                                <?php endif; ?>
                              <?php endforeach; ?>
                            </select>
                          </td>    
                          <td>
                            <?php if($Produto->get("datasheet") != ""): ?>                            
                            <a class="datasheet" target="_blank" href="<?= $Produto->get("datasheet") ?>"><span class='mdi mdi-file-pdf' style='font-size:20px'></span></a>
                            <?php else: ?>
                            <a href="javascript:void(0)" style="color:#6b6b6b"><span class='mdi mdi-file-pdf' style='font-size:20px'></span></a>
                            <?php endif; ?>  
                          </td>
                          <td style="color:#000">
                            <input  onchange="autosave()"  type="text" class="input-table-order calcPrice" onchange="javascript:valorTotal(this)" value="<?= $o->quantidade ?>">
                          </td>
                            
                          <td class="hiddenOUT" <?= $TipoKit == "Unidade" || $User->get("status") == 1  ? "" : "hidden" ?>  style="color:#000">
                            <input onchange="autosave()"  type="text" class="input-table-order unitPrice totalUnit" onchange="javascript:valorTotal(this)" value="<?= $o->price ?>" readonly>
                          </td>
                         
                          <td class="hiddenOUT"  <?= $TipoKit == "Unidade" || $User->get("status") == 1  ? "" : "hidden" ?>  style="color:#000">
                            <input  onchange="autosave()"  type="text" class="input-table-order unitTotal totalUnit" onchange="javascript:valorTotal(this)" value="<?= $o->priceTotal ?>" readonly>
                          </td>
                          <td hidden >
                            <input onchange="autosave()"  type="hidden" class="input-table-order row-total priceLiq" value="" readonly>
                          </td>                           
                          <td hidden >
                            <input  onchange="autosave()"  class="input-table-order row-total margemTotal" value="" readonly>
                          </td>                          
                          <td style="color:#000;">
                          <?php if(($Produto->get("product_type") != "Painel") ):?>
                          <?php if(($Produto->get("product_type") != "String Box")):?>  
                              <a class="erase-line" onclick="javascript:valorTotal(this)" href="javascript:void(0)">
                               <span class="mdi mdi-eraser icon_order" style="color:#163145;"></span>
                             </a>   
                             <a class="remove-line" href="javascript:void(0)">
                                 <span class="mdi mdi-close icon_order" style="color:red;"></span>
                             </a>
                             <?php endif; ?>
                            <?php endif; ?>
                          </td>
                          <td hidden>
                            <input  onchange="autosave()"   class="input-table-order row-total valorIPI" value="0" readonly>
                          </td> 
                          <td hidden>
                            <input  onchange="autosave()"   class="input-table-order row-total ValorCustoTotal" value="0" readonly>
                          </td> 
                          <td hidden>
                            <input  onchange="autosave()"   class="input-table-order row-total precoComissao" value="0" readonly>
                          </td>
                          <td hidden>
                            <input  onchange="autosave()"   class="input-table-order row-total precoSemComissao" value="0" readonly>
                          </td> 
                          <td hidden>
                            <input  onchange="autosave()"   class="input-table-order row-total margemSemComissao" value="0" readonly>
                          </td> 
                        </tr>
                       <?php endif;?>
                       <?php endforeach;?>
                       <?php endif; ?>
                </tbody>               
                <tfoot class="linha_order" style="color:#ececec">
                <tr>
                  <td style="color:#000;" class="linha_order_mt">
                    <a class="add-line" href="javascript:void(0)">
                      <span class="mdi mdi-plus-box" onClick="AddTableRow()" style="font-size: 25px;position: relative;top: 3px;color:#526269;" title="<?= __("Adicionar linha.") ?>"></span>
                    </a>
                  </td>                  
                  <td style="color:#000"></td>      
                  <td style="color:#000"></td>     
                  <td hidden style="color:#fff"><input onchange="autosave()"  id="vuntTotal" type="text" class="input-table-order row-total totalUnitField" value="<?php echo format_price($ProdTotal[0]->totalUnit) ?>" readonly></td>
                  <td style="color:#000"></td>
                  <td hidden><input onchange="autosave()"  id="vtotalPriceSemJuros" type="hidden" class="input-table-order row-total vmargemTotal" value="<?= $ProdTotal[0]->semJuros ?>" readonly></td> 
                  <td hidden><input onchange="autosave()"  id="vmargemTotal"  class="input-table-order row-total vmargemTotal" value="<?= $ProdTotal[0]->margemLucro ?>" readonly></td> 
                  <td hidden style="color:#000;"></td> 
                  <td hidden style="color:#000;"><input onchange="autosave()"  id="valorIPI" value="0" class="input-table-order row-total "  readonly></td> 
                  <td hidden style="color:#000;"><input onchange="autosave()"  id="TotalCusto" value="0" class="input-table-order row-total  "  readonly></td>
                  <td  style="color:#000;"></td> 
                  <td hidden style="color:#000;"><input onchange="autosave()"  id="precoTOTALsemComissao" value="<?= $ProdTotal[0]->precoRealProdutos ?>" class="input-table-order row-total  "  readonly></td> 
                </tr>
                  </tfoot>
              </table>
            </div>        
           </div>
            <div class="clearfix mb-20" style="text-align: -webkit-center;">
             <div class="col s12 m12 l12">
                <input style=" background: #f07e13; font-size: 32px; border-radius: 10px; color: antiquewhite;"; onchange="autosave()"  id="vtotalTotal" type="text" class="input-table-order row-total totalTotalField" value="<?php echo format_price($ProdTotal[0]->totalTotal) ?>" readonly>
             </div>
          </div>
           <div <?= $User->get("status") == 1 && !$AuthUser->isAdmin()  ? "hidden" : ""?>  class="clearfix " style="text-align: -webkit-center;">
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