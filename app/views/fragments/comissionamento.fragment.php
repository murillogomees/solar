<?php $PayDetails = json_decode($Order->get("payment_details"));  ?>
<?php $Cliente = json_decode($Order->get("client")) ?>
<?php $vendedor = json_decode($Order->get("seller")) ?>
<?php $Endereco = json_decode($Frete->get("endereco")) ?>
<?php $ClienteReal = json_decode($Frete->get("cliente")) ?>
<?php $Produtos = json_decode($Frete->get("produtos")) ?>
<?php $comissao = str_replace(".", "", $Order->get("comissao_liquida")); $valor = $comissao / 100;  ?>


<div class='skeleton' id="frete">
  <form class="js-ajax-form-order" enctype="multipart/form-data" action="<?= APPURL . "/comissionamentos/" . $Order->get("id") ?>" id="freteForm" method="POST">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id_original" value="<?= encrypt($Order->get("id"))?>">
    <div class="row clearfix">
      <section class="section">
        <div class="section-content">
          <div class="form-result"></div>   
            <div class="mb-25" style="border-bottom:solid 1px #cecece">
              <span style="font-size:20px" class="form-label">Número: <?= $Order->get("order_id") ?></span> 
            </div>
            <div class="clearfix mb-20">
              <div class="col s12 m6  l3 mb-20">
                <label class="form-label">
                  <span class="compulsory-field-indicator">*</span>
                      <?= __("Status de Pagamento") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina se o comissionamento foi pago") ?>">
                       <span class="mdi mdi-help-circle"></span>
                  </label>
                <select class="input js-required select2 status" data-type="status" name="status_comissionamento">
                  <option value="1" <?= !$AuthUser->isAdmin()  ? "disabled" : "" ?>  <?= $comissionamento->get("status") == "1" ? "selected" : "" ?>>
                     Liberado Controladoria
                  </option> 
                  <option value="2" <?= !$AuthUser->isSetorFinanceiro()  ? "disabled" : "" ?>  <?= $comissionamento->get("status") == "2" ? "selected" : "" ?>>
                     Comissionamento Pago
                  </option> 
                  <option  value="3"  <?= $comissionamento->get("status") == "3" || $comissionamento->get("status") == ""  ? "selected" : "" ?>>
                     Comissionamento Solicitado
                  </option> 
                </select>
              </div>   
              <div class="col s12 m6 m-last l3  mb-20">
                <label class="form-label"> 
                      <?= __("Nrº do pedido (Santri)") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Número do pedido do Santri.") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                <input  class="input" name="numero_santri" onkeypress="onlynumberrealy();" value="<?= $comissionamento->get("pedido_santri") ?>" required>           
              </div> 
							<div class="col s12 s-last m6  l3 mb-20">
                <label class="form-label">                  
                      <?= __("Número da NF ") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Número da NF de simples faturamento") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                <input required class="input" name="numero_nf" maxlenght="11" onkeypress="onlynumberrealy();" value="<?= $comissionamento->get("nota_fiscal") ?>">           
              </div>
              <div class="col s12 s-last m6 l3 l-last mb-20">
                <label class="form-label">                  
                      Condição de pagamento
                      <span class="tooltip tippy" data-position="top" data-size="small" title="Condição de pagamento">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                <input disabled class="input" name="" maxlenght="11" onkeypress="onlynumber();" value="<?= $this->retornoPagamento($PayDetails[0]->paymentTerms) ?>">           
              </div>  
              </div>
              <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 20px;color: #51524f;font-weight: 600; line-height: 30px">Dados Financeiro</span>
              </div>
              <div class="clearfix">
              <div class="col s12 s-last m12 l3 mb-20">
                <label class="form-label">                  
                      <?= __("Valor Real do Pedido") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Valor Pedido") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>                        
                <input  disabled readonly class="input" name="valorPedido" maxlenght="11"  onInput="mascaraMoeda(event)"  value="<?= format_price($comissionamento->get("valor_pedido_santri")) ?>">           
              </div>
              <div class="col s12 s-last m12 l3  mb-20">
                <label class="form-label">                  
                       Comissão Bruta
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Valor Comissão") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                        
                <input disabled class="input" name="" maxlenght="11" onkeypress="onlynumber();" value="<?= format_price($Order->get("comissao"))?>">           
             </div>
             <div class="col s12 s-last m12 l3 mb-20">
                <label class="form-label">                  
                       Comissão Liquida
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Valor Comissão Liquida") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>                        
                <input disabled  class="input" name="" maxlenght="11" onkeypress="onlynumber();" value="<?= format_price($valor) ?>">           
              </div>
               <div class="col s12 m6 l3 l-last mb-20">   
                <label class="form-label">
                     <?= __("Valor Total do Frete") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Determina o valor total do frente") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>
                  <input disabled  class="input" type="text" name="valor_total" value="<?= format_price($Frete->get("valor_total")) ?>">
              </div>  
              </div>  
               <div class="clearfix">
               <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Dados do Cliente Faturamento<span>
               </div>
               <div class="col s12 s-last m6 l3 mb-20">
                <label class="form-label">                  
                      <?= __("Código Cliente Santri") ?>
                      <span class="tooltip tippy" data-position="top" data-size="small" title="<?= __("Código do cliente no santri") ?>">
                      <span class="mdi mdi-help-circle"></span>
                  </label>                        
                <input required class="input" name="id_cliente_santri" maxlenght="11" onkeypress="onlynumber();" value="<?= $comissionamento->get("id_cliente_santri") ?>">           
              </div>
             <div class="col s12 m6 m-last l3 mb-20">
              <label class="form-label">
              <?= __("Nome do cliente") ?>
               </label>
              <input  required type="text" class="input" name="nome_cliente" value="<?= $comissionamento->get("razao_social") ?>" required>   
             </div>
             <div class="col s12 m6  l3 mb-20">   
              <label class="form-label">
              <?= __("CNPJ do cliente") ?>
              </label>
              <input required type="text" type="text" class="input" name="cnpj_cliente" onkeypress="onlynumberrealy();" onfocus="javascript: cleanFormat(this);" onblur="javascript: formatField(this);" value="<?= formata_cpf_cnpj($comissionamento->get("cnpj")) ?>" maxlength="14"> 
             </div>
             <div class="col s12 m6 m-last l3 l-last mb-20" >   
              <label class="form-label">
              <?= __("Telefone do cliente") ?>
              </label>
              <input required  type="text" class="input" name="telefone_cliente" onkeypress="onlynumberrealy();" onfocus="javascript: cleanFormat(this);" onblur="javascript: formatTel(this);" value="<?=  formatar("fone", $comissionamento->get("telefone")) ?>" maxlength="12"> 
             </div>  
             <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Dados do Vendedor<span>
              </div>  
              <div class="col s12 m12 m-last l4 mb-20">
               <label class="form-label">
               <?= __("Nome Vendedor") ?>
               </label>
              <input disabled  type="text" class="input" name="" value="<?= $vendedor[0]->name   ?>" required>   
              </div>
              <div class="col s12 m12 m-last l4 mb-20">
               <label class="form-label">
               <?= __("Telefone") ?>
               </label>
              <input disabled  type="text" class="input" name="" value="<?= formatar("fone", $vendedor[0]->phone)  ?>" required>   
              </div>
              <div class="col s12 m12 m-last l4 l-last mb-20">
               <label class="form-label">
               <?= __("E-mail") ?>
               </label>
              <input disabled  type="text" class="input" name="" value="<?=  $vendedor[0]->email  ?>" required>   
              </div> 
              <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Dados Pagamento<span>
              </div>     
              <div class="col s12 m12 m-last l12 l-last mb-20" >   
              <label class="form-label">
                <span class="compulsory-field-indicator">*</span>
                Dados bancário
              </label>
                <textarea required type="text" class="input" name="dados_pagamento"   value="<?= $comissionamento->get("dados_pagamento") ?>" ><?= $comissionamento->get("dados_pagamento") ?></textarea>
             </div>      
            </div>
            <div> 
           <div class="clearfix">
            <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
              <span class="form1-label" style="display: inline-block; margin-bottom: 5px; font-size: 15px;color: #51524f;font-weight: 500; line-height: 17px">Arquivos Úteis<span>
            </div>
                 <?php $versao = rand(5, 15); ?>
               <div class="col s12 m12 l6 mb-20">
                  <label class="form-label"> <?= __("NOTA FISCAL:") ?> </label>
                  <input name="arquivoNF" type="file"/><br />
                  <?php if(file_exists($_SERVER['DOCUMENT_ROOT']."/assets/uploads/".$Order->get("id")."/comissionamento/nf_comissao.pdf")): ?>  
                   <a class="iframe-popup" href="<?= APPURL."/assets/uploads/".$Order->get("id")."/comissionamento/nf_comissao.pdf" ?>">
                   <div style="z-index:99999999";  class="iframe-popup" src="<?= APPURL."/assets/uploads/".$Order->get("id")."/nf_comissao.pdf" ?>" >
                    <embed class="iframe-popup" src="<?= APPURL."/assets/uploads/".$Order->get("id")."/comissionamento/nf_comissao.pdf" ?>" style="width:100%;margin-top:10px">                          
                    <label class="form-label"> 
                    <?= __("Imagem Nota Fiscal atual") ?>
                    </label>
                   </div>
                  </a> 

                  <?php endif; ?>
               </div>
                <div class="col s12 m12 l6 l-last mb-20 " <?= $comissionamento->get("status") <= 2 ? "" : "hidden" ?> >
                          <label class="form-label"> Comprovante de pagamento </label>
                         <input name="comprovante" type="file" /><br />
                           <div class="zoom-gallery">
	                         <a href="<?= $comissionamento->get("link_comprovante") ?>" title="Cotação 2" style="width:82px;height:125px;">
                            <img width="50%" height="50%" style="border-radius:20px;" src="<?= $comissionamento->get("link_comprovante") ?>" alt="Comprovante Pagamento">                  
	                         </a>
                          </div>
                        
                       </div>
            </div>
            </div> 
          <div class="clearfix" style="text-align: -webkit-center;">
             <div class="col s12 m12 l12">
                 <input style="width:10%" class="button button--oval" type="submit" value="<?= __("Salvar") ?>">
             </div>
          </div>
        </div>
    </div>
    </section>
</div>
</form>
</div>