        <div  class="skeleton skeleton--full" id="clients">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/clients";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results" style="background-color: #fff";>
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/clients?aid=".$User->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/clients/".($User->isAvailable() ? $User->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                            <?php
                                if(null !== $User->get("id")){
                                    $titulo = "Cliente: <label style=\"color:#51524f;\">" . htmlchars($User->get("name")) . "</label>";
                                } else {
                                    $titulo = "Cadastro de Cliente";
                                }
                             ?>

                        <div class="section-header" style="border-left: 5px solid #f07e13">
                            <?= $titulo; ?>
                        </div>
                        <div class="section-content">
                            <div class="form-result"></div>
                                <div class="clearfix mb-20">
                                  <?php if($AuthUser->get("account_type") != "integrador"):?>
                                   <div class="col s6 m6 l6">
                                            <label class="form-label">
                                                <?= __("Código Santri") ?>
                                                <span class="tooltip tippy"
                                                      type="text"
                                                      data-position="top"
                                                      data-size="small"                                                      
                                                      title="<?= __("Insira o código do cliente do Santri.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input cnpjField"
                                                   name="cod_santri"
                                                   type="text"
                                                   onkeypress="onlynumberrealy();"                                                   
                                                   value="<?= !$User->isAvailable() ? "" : $User->get("cod_santri") ?>"
                                                   maxlength="14">
                                        </div>
                                     <?php endif; ?>
                                        <div class="col s6 s-last m6 l6 l-last">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("CNPJ") ?>
                                                <span class="tooltip tippy"
                                                      type="number"
                                                      data-position="top"
                                                      data-size="small"                                                      
                                                      title="<?= __("Insira um CNPJ/CPF válido.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input js-required cnpjField"
                                                   name="cnpj"
                                                   type="text"
                                                   onkeypress="onlynumberrealy();" 
                                                   onfocus="javascript: cleanFormat(this);"
                                                   onblur="javascript: formatField(this);"
                                                   value="<?= !$User->isAvailable() ? "" : formatar('cnpj', $User->get("cnpj")) ?>"
                                                   maxlength="18">
                                        </div>
                                     </div>
                                        <div class="clearfix">
                                            <div class="col s12 m12 l12 mt_mobile">
                                                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Razão Social") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Insira o Nome/Razão social do cliente.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input js-required razaoField"
                                                    name="name"
                                                    type="text"
                                                    value="<?= mb_strtoupper($User->get("name"),"UTF-8") ?>"
                                                    maxlength="150">
                                            </div> 
                                         </div>
                                          
                                       <div class="clearfix mb-20 mt-20">    
                                        <div class="col s6 m6 l6">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Tipo de Cliente") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Selecione o tipo do Cliente.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                                 <!-- SELECT -->  
                                              <select class="input select2 js-required" name="taxProfile">
                                                 <option value="" selected disabled hidden>Escolha o tipo de cliente</option>                                                 
                                                <?php foreach ($TaxProfile->getDataAs("TaxProfile") as $key) : ?>
                                                  <option <?= $User->get("client_type") == $key->get("name")  ? "selected" : ""?> value="<?= $key->get("name") ?>" ><?= $key->get("name") ?></option>
                                                <?php endforeach; ?>       
                                              </select>
                                        </div>

                                       <?php if($AuthUser->get("account_type") != "integrador"): ?>
                                            <div class="col s6 s-last m6 m-last l6 l-last">
                                               <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Filial de Origem:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione a filial responsável pelo cliente.") ?>">
                                                        <span class="mdi mdi-help-circle" ></span>
                                              </label>

                                              <select class="input select2 js-required" name="branch">
                                                 <option value="" selected disabled hidden>Filial de Origem</option>                                                                                                
                                                  <?php foreach($Branchs->getDataAs("Branch") as $k):?>
                                                    <option <?= !$User->isAvailable() ? "selected"  : "" ?> value="<?= $k->get("name") ?>" <?= $User->get("branch") == $k->get("name") ? "selected"  : "" ?> ><?= $k->get("name") ?></option>
                                                  <?php endforeach;?>                                                                                                  
                                              </select>  
                                            </div>
                                          <?php else:?>
                                              <div class="col s6 s-last m6 m-last l6 l-last">
                                               <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Filial de Origem:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione a filial responsável pelo cliente.") ?>">
                                                        <span class="mdi mdi-help-circle" ></span>
                                              </label>

                                              <select class="input select2 js-required " name="branch">
                                                    <option value="externo" selected>Externo</option>  
                                              </select>  
                                            </div>
                                          <?php endif; ?> 
                                          </div>
                                        
                                     <div class="clearfix mb-20">
                                       <div class="col s6 m6 l6">
                                             <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Telefone") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Insira um telefone válido.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input js-required"
                                                    name="phone"
                                                    type="tel"
                                                    onkeypress="onlynumberrealy();"  
                                                    placeholder="Ex: (99) 9 9999-9999"
                                                    onblur="javascript: formatTel(this);"
                                                    onfocus="javascript: cleanFormat(this);"
                                                    value="<?= !$User->isAvailable() ? "" : formatar('fone', $User->get("phone")) ?>"
                                                    maxlength="11">                                                                                                 
                                        </div>
                                        
                                            <div class="col s6 s-last m6 m-last l6 l-last">
                                                <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("CEP") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Digite o CEP do endereço.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                <input class="input cepField js-required"
                                                    name="cep"
                                                    type="text"
                                                    onkeypress="onlynumberrealy();"
                                                    onblur="javascript: formatCep(this);"
                                                    onfocus="javascript: cleanFormat(this);"
                                                    placeholder="Ex: 00000-000"
                                                    value="<?= !$User->isAvailable() ? "" : formatar('cep', $User->get("cep")) ?>"
                                                    maxlength="8">
                                            </div>
                                         </div>
                                         
                                       <div class="clearfix mb-20">
                                        <div class="col s6 m6 l6">
                                            <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                                <?= __("Cidade") ?>                                                
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Insira a cidade correspondente.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input localidadeField js-required"
                                                name="city"
                                                type="text"
                                                placeholder="Ex: Brasília"
                                                value="<?= htmlchars($User->get("city")) ?>"
                                                maxlength="20"
                                                >
                                        </div>

                                        
                                            <div class="col s6 s-last m6 m-last l6 l-last">
                                                <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Estado") ?>                                              
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Selecione a UF do Estado.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

                                                 <select class="input select2 estadoField js-required" name="uf">
                                                 <option value="" selected disabled hidden>UF do Cliente</option>                                                                                                
                                                  <?php foreach($States->getDataAs("State") as $k):?>
                                                    <option value="<?= strtoupper($k->get("uf")) ?>" <?= $User->get("uf") == strtoupper($k->get("uf")) ? "selected"  : "" ?> ><?= strtoupper($k->get("uf")) ?></option>
                                                  <?php endforeach;?>                                                                                                  
                                              </select>
                                            </div>
                                        </div>

                                        <div class="clearfix mb-20">
                                           <div class="col s12 m6 l6 mt_mobile">
                                            <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                                <?= __("Logradouro") ?>                                              
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Insira o endereço correspondente ao cliente.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input logradouroField js-required"
                                                name="address"
                                                type="text"
                                                placeholder="SIBS Quadra 1 Conjunto B, Lote 15"
                                                value="<?= htmlchars($User->get("address")) ?>"
                                                maxlength="80">
                                        </div>
                                     
                                       
                                           <div class="col s12 m6 m-last l6 l-last">
                                            <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                                <?= __("Bairro") ?>                                              
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Insira o endereço correspondente ao cliente.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input bairroField js-required"
                                                name="bairro"
                                                type="text"
                                                placeholder="Núcleo Bandeirante"
                                                value="<?= htmlchars($User->get("bairro")) ?>"
                                                maxlength="80">
                                        </div>
                                      </div>
                                      <?php if($AuthUser->isSetorFinanceiro()): ?>       
                                       <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
                                          <span class="form1-label">Parametrizações:</span>
                                       </div>      
                                       <div class="clearfix mb-20">
                                         <div class="col s12 m12 l12 mt_mobile">
                                            <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                                <?= __("Forma de pagamento permitido") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Insira as formas de pagamentos disponíveis para este cliente.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>
                                             
                                            <?php $condicaoP = json_decode($User->get("p_pagamentos"), true); ?>
                                    
                                            <select id="condicaoCliente"  style="width:100%" class="select2 browser-default"  name="pagamentos[]" class="select2 browser-default" multiple="multiple">
                                              <?php foreach($ArrayP as $p): ?>
                                              <option <?php if($condicaoP != null) {
                                              foreach($condicaoP as $c){
                                                if($c == $p['id']){
                                                  echo "selected";
                                                } else {
                                                  echo "";
                                                }
                                              }}
                                              ?> value="<?= $p['id'] ?>"><?= $p['nome'] ?></option>
                                              <?php endforeach; ?>
                                              </select>
                                         </div>
                                       </div>
                                         <?php endif; ?>
                                         
                                       <?php if($AuthUser->isMaster()): ?>
                                       <div class="clearfix mb-20">
                                         <div class="col s12 m12 l12 mt_mobile">
                                            <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                                <?= __("Margem adicional a venda") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Determina a margem que sera acrescida no calculo do orçamento.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>
                                               <input class="input js-required "
                                                  placeholder="Ex: -10"
                                                  onkeypress="onlynumber();"
                                                   name="adicional-venda"
                                                   type="text"
                                                   value="<?= $User->get("adicional_venda") ?>"
                                                   maxlength="3">    
                                         </div>
                                       </div>  
                                       <?php endif; ?>

                            <div class="clearfix">
                                <div  style="width:100%"  class="col s12 m12 l2">
                                    <input style="width:100%" class="fluid button" type="submit" value="<?= __("Salvar") ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>