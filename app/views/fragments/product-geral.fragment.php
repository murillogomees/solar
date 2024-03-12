<div class="clearfix mb-20">
  <div class="col s12 m12 l2 ">
    <label class="form-label">
                                            <span class="compulsory-field-indicator">*</span>
                                            <?= __("Status") ?>
                                            <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __("Determina se o produto estará Ativo/Desativado.") ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                          </label>

    <select class="input" name="is_active">
                                                <?php
                                                    if ($User->isAvailable()) {
                                                        $status = $User->get("is_active") ? 1 : 0;
                                                    } else {
                                                        $status = 1;
                                                    }
                                                ?>
                                                <option value="1" <?= $status == 1 ? "selected" : "" ?>><?= __("Ativo") ?></option>
                                                <option value="0" <?= $status == 0 ? "selected" : "" ?>><?= __("Desativado") ?></option>
                                            </select>
  </div>
  <div class="col s12 m12 l3">
    <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Código Santri") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Digite o código do Produto no sistema Santri.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

    <input class="input js-required" name="santri_cod" type="text" value="<?= htmlchars($User->get("santri_cod")) ?>" maxlength="150">
  </div>
  <div class="col s12 m12 l7 l-last">
    <label class="form-label">
                                                    <span class="compulsory-field-indicator">*</span>
                                                    <?= __("Nome do Produto") ?>
                                                    <span class="tooltip tippy"
                                                          data-position="top"
                                                          data-size="small"
                                                          title="<?= __("Determina o nome do Produto.") ?>">
                                                          <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </label>

    <input class="input js-required" name="name" type="text" value="<?= htmlchars($User->get("name")) ?>" maxlength="150">
  </div>
</div>

<div class="clearfix mb-20">
  <div class="col s12 m12 l12">
    <div class="pos-r">
      <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("Descrição do Produto") ?>
                                              <span class="tooltip tippy"
                                                    data-position="top"
                                                    data-size="small"
                                                    title="<?= __("Escreva a descrição sobre o produto.") ?>">
                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                          </label>

      <textarea id="description" class="input js-required" name="description" maxlength="500" rows="2"><?= htmlchars($User->get("description")) ?></textarea>

    </div>
  </div>
</div>


<div class="clearfix mb-20">
  <div class="col s12 m6 l3 mb-20">
    <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Segmento do Produto:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Escolha o Segmento do Produto.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

    <select class="input select2 combobox2" name="segment">
                                                 <option value="" selected disabled hidden>Escolha o Segmento</option>                                                 
                                                  <?php foreach ($Segments->getDataAs("ProductSegment") as $key) : ?>
                                                  <option <?= $key->get("name") == $User->get("segment") ? "selected" : ""?> value="<?= $key->get("name") ?>" ><?= $key->get("name") ?></option>
                                                <?php endforeach; ?>
                                              </select>

  </div>

  <div class="col s12 s-last m6 m-last l3 mb-20">
    <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Tipo do Produto:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Escolha o Tipo do Produto.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

    <select class="input select2 combobox2" name="product_type">
                                                 <option value="" selected disabled hidden>Escolha o Tipo de Produto</option>                                                 
                                                  <?php foreach ($Types->getDataAs("ProductType") as $key) : ?>
                                                  <option <?= $key->get("name") == $User->get("product_type") ? "selected" : ""?> value="<?= $key->get("name") ?>" ><?= $key->get("name") ?></option>
                                                <?php endforeach; ?>
                                              </select>
  </div>


  <div class="col s12 m6 l3 mb-20">
    <div class="pos-r">
      <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("Modelo do Produto") ?>
                                              <span class="tooltip tippy"
                                                    data-position="top"
                                                    data-size="small"
                                                    title="<?= __("Escolha o Modelo do Produto") ?>">
                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                          </label>

      <select class="input select2 combobox2" name="product_model">
                                                 <option value="" selected disabled hidden>Escolha o Modelo de Produto</option>
                                                  <option <?= $User->get("product_model") == "Não se aplica" ? "selected" : ""?> value="Não se aplica" ><?= __("Não se Aplica") ?></option>
                                                  <?php foreach ($Models->getDataAs("ProductModel") as $key) : ?>
                                                  <option <?= $key->get("name") == $User->get("product_model") ? "selected" : ""?> value="<?= $key->get("name") ?>" ><?= $key->get("name") ?></option>
                                                <?php endforeach; ?>
                                              </select>

    </div>
  </div>

  <div class="col s12 m6 m-last l3 l-last mb-20">
    <div class="pos-r">
      <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("Fabricante") ?>
                                              <span class="tooltip tippy"
                                                    data-position="top"
                                                    data-size="small"
                                                    title="<?= __("Escolha o Fabricante do Produto.") ?>">
                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                          </label>

      <select class="input select2 combobox2" name="producer">
                                                 <option value="" selected disabled hidden>Escolha o Tipo de Produto</option>
                                                  <option <?= $User->get("product_model") == "Não se aplica" ? "selected" : ""?> value="Não se aplica" ><?= __("Não se Aplica") ?></option>
                                                  <?php foreach ($Producers->getDataAs("Producer") as $key) : ?>
                                                  <option <?= $key->get("name") == $User->get("producer") ? "selected" : ""?> value="<?= $key->get("name") ?>" ><?= $key->get("name") ?></option>
                                                <?php endforeach; ?>
                                              </select>

    </div>
  </div>

  <div class="clearfix">
    <div class="col s12 s-last m12 m-last l3 mb-20">
      <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Origem") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione o tipo de origem do produto.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

      <select class="input select2" name="origin">
                                                 <option value="" selected disabled hidden>Escolha a Origem</option>                                                 
                                                  <?php foreach ($Origins->getDataAs("Origin") as $key) : ?>
                                                  <option <?= $key->get("name") == $User->get("origin") ? "selected" : ""?> value="<?= $key->get("name") ?>" ><?= $key->get("name") ?></option>
                                                <?php endforeach; ?>
                                              </select>
    </div>

    <div class="col s12 s-last m12 m-last l3 mb-20">
      <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("NCM do Produto") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione os ncms que fazem parte do benefício fiscal.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

      <select class="input select2" name="ncm">
                                                 <option value="" selected disabled hidden>Escolha o NCM do produto</option>                                                 
                                                  <?php foreach ($Ncms->getDataAs("Ncm") as $key) : ?>
                                                  <option <?= $key->get("cod_ncm") == $User->get("ncm") ? "selected" : ""?> value="<?= $key->get("cod_ncm") ?>" ><?= $key->get("cod_ncm") ?></option>
                                                <?php endforeach; ?>
                                              </select>
    </div>
    <div class="col s12 s-last m12 m-last l3 mb-20">
      <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Produto se enquadra para ST") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Selecione \"SIM\" caso o produto se enquadre para substituição tributária.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

      <select class="input select2" name="is_active_st">
                                                 <option value="" selected disabled hidden>Substituição Tributária</option>
                                                 <option value="0" <?= $User->get("is_active_st") == 0 ? "selected" : "" ?>><?= __("Não") ?></option>
                                                 <option value="1" <?= $User->get("is_active_st") == 1 ? "selected" : "" ?>><?= __("Sim") ?></option>                                                 
                                              </select>
    </div>
    <div class="col s12 s-last m12 m-last l3 l-last mb-20">
      <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Garantia do Produto") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Escolha a garantia do produto.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

      <select class="input select2" name="garantia">
                                                 <option value="" selected disabled hidden>Garantia de Produto</option>
                                                 <option value="Sem Garantia" <?= $User->get("garantia") == "Sem Garantia" ? "selected" : "" ?>><?= __("Sem Garantia") ?></option>
                                                 <?php foreach ($Garantias->getDataAs("Garantia") as $key) : ?>
                                                  <option <?= $key->get("name") == $User->get("garantia") ? "selected" : ""?> value="<?= $key->get("name") ?>" ><?= ucfirst($key->get("name")) ?></option>
                                                <?php endforeach; ?> 
                                              </select>
    </div>

  </div>

  <div class="clearfix">
    <div class="col s12 s-last m12 m-last l3 mb-20">
      <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Prazo de Entrega do Produto") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Escolha o prazo de entrega em DIAS do produto.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

      <input class="input js-required" name="prazo_entrega" type="text" value="<?= $User->get("prazo_entrega") ?>" maxlength="5">
    </div>


    <div class="col s12 s-last m12 m-last l3 mb-20">
      <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Estoque do Produto") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Quantidade de produtos no estoque do Santri.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

      <input class="input js-required" name="estoque" type="text" value="<?= $User->get("estoque") ?>" maxlength="5">
    </div>
  </div>

  <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
    <span class="form1-label">Condição de equipamento:</span>
  </div>

  <div class="clearfix">

    <div class="col s12 s-last m12 m-last l3 mb-20">
      <label class="form-label">
                                                            <span class="compulsory-field-indicator">*</span>
                                                            <?= __("Peso do Produto") ?>
                                                            <span class="tooltip tippy"
                                                                  data-position="top"
                                                                  data-size="small"
                                                                  title="<?= __("Peso em Kg do produto com embalagem.") ?>">
                                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                        </label>

      <input class="input js-required" name="peso" type="text" value="<?= $User->get("peso") ?>" maxlength="5">
    </div>


    <div class="col s12 s-last m12 m-last l3 mb-20">
      <label class="form-label">
                                                              <span class="compulsory-field-indicator">*</span>
                                                              <?= __("Altura do Produto") ?>
                                                              <span class="tooltip tippy"
                                                                    data-position="top"
                                                                    data-size="small"
                                                                    title="<?= __("Altura em cm da embalagem do produto.") ?>">
                                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                          </label>

      <input class="input js-required" name="altura" type="text" value="<?= $User->get("altura") ?>" maxlength="5">
    </div>

    <div class="col s12 s-last m12 m-last l3 mb-20">
      <label class="form-label">
                                                              <span class="compulsory-field-indicator">*</span>
                                                              <?= __("Largura do Produto") ?>
                                                              <span class="tooltip tippy"
                                                                    data-position="top"
                                                                    data-size="small"
                                                                    title="<?= __("Largura em cm da embalagem do produto..") ?>">
                                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                          </label>

      <input class="input js-required" name="largura" type="text" value="<?= $User->get("largura") ?>" maxlength="5">
    </div>


    <div class="col s12 s-last m12 m-last l3 l-last">
      <label class="form-label">
                                                            <span class="compulsory-field-indicator">*</span>
                                                            <?= __("Comprimento do Produto") ?>
                                                            <span class="tooltip tippy"
                                                                  data-position="top"
                                                                  data-size="small"
                                                                  title="<?= __("Comprimento em cm da embalagem do produto.") ?>">
                                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                        </label>

      <input class="input js-required" name="comprimento" type="text" value="<?= $User->get("comprimento") ?>" maxlength="5">
    </div>
  </div>
 <div class="clearfix mb-25" style="border-bottom:solid 1px #cecece">
      <span class="form1-label">DataSheet Produto:</span>
    </div>
             
    <div class="clearfix"> 
        <div class="row" >   
           <div class="col s12 s-last m12 m-last l6 mb-20">
            <label class="form-label">          
              <?= __("Url do DataSheet:") ?>
              <span class="tooltip tippy"
                    data-position="top"
                    data-size="small"
                    title="<?= __("Digite a url do DataSheet em PDF.") ?>">
                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
            </label>

            <input class="input" name="datasheet" type="text" value="<?= $User->get("datasheet") ?>">
          </div>
               <div class="col s12 s-last m12 m-last l6 l-last mb-20">
                       <label class="form-label">          
              <?= __("Part number:") ?>
              <span class="tooltip tippy"
                    data-position="top"
                    data-size="small"
                    title="<?= __("Digite o Part number do produto") ?>">
                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
            </label>

            <input class="input" name="part_number" type="text" value="<?= $User->get("part_number") ?>">
                 </div>
             </div>   
          </div>  
           
     </div>        
</div>