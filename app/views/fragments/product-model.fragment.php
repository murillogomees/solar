        <div class="skeleton skeleton--full" id="product-model">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/product-models";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/product-models?aid=".$ProdModel->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/product-models/".($ProdModel->isAvailable() ? $ProdModel->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                        <?php
                            if(null !== $ProdModel->get("id")){
                                if($ProdModel->get("is_active")){
                                  $titulo = "Modelo de Produto: <label style=\"color:green;\">" . htmlchars($ProdModel->get("name")) . "</label>";
                                }else{
                                  $titulo = "Modelo de Produto: <label style=\"color:red;\">" . htmlchars($ProdModel->get("name")) .  "</label>";
                                }
                            } else {
                                $titulo = "Cadastro de Modelo de Produto";
                            }
                        ?>

                        <div class="section-header" style="border-left: 5px solid #2a3f54">
                            <?= $titulo; ?>
                        </div>

                        <div class="section-content">
                            <div class="form-result"></div>


                            <div class="clearfix mb-20">  
                              <div class="col s2 m2 l2">
                                  <label class="form-label">
                                  <span class="compulsory-field-indicator">*</span>
                                  <?= __("Status") ?>
                                  <span class="tooltip tippy"
                                               data-position="top"
                                               data-size="small"
                                               title="<?= __('Determina se o modelo cadastrado estará Ativa/Desativada.') ?>">
                                               <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                  </label>

                                  <select class="input"
                                          name="is_active">
                                      <?php
                                          if ($ProdModel->isAvailable()) {
                                              $status = $ProdModel->get("is_active") ? 1 : 0;
                                          } else {
                                              $status = 1;
                                          }
                                      ?>
                                      <option value="1" <?= $status == 1 ? "selected" : "" ?>><?= __("Ativo") ?></option>
                                      <option value="0" <?= $status == 0 ? "selected" : "" ?>><?= __("Desativado") ?></option>
                                  </select>
                              </div>
                              
                                        <div class="col s2 m12 l2">
                                          <label class="form-label">
                                          <span class="compulsory-field-indicator">*</span>
                                          <?= __("Tipo") ?>
                                          <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Determina o tipo do modelo de produto a ser cadastrado.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </span>
                                          </label>

                                       <select class="input" name="type">                                      
                                          <option value="A" <?= $ProdModel->get("type") == "A" ? "selected" : "" ?>><?= __("A") ?></option>
                                          <option value="B" <?= $ProdModel->get("type") == "B" ? "selected" : "" ?>><?= __("B") ?></option>
                                       </select>                                          
                                      </div>
                              
                                       <div class="col s8 s-last m12 m-last l8 l-last ">
                                          <label class="form-label">
                                          <span class="compulsory-field-indicator">*</span>
                                          <?= __("Nome") ?>
                                          <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Digite o nome do modelo de produto.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </span>
                                          </label>

                                          <input class="input js-required"
                                                 name="name"
                                                 type="text"
                                                 value="<?= htmlchars($ProdModel->get("name")) ?>"
                                                 maxlength="300">
                                        </div>
                                </div>                          
                          
                            <div class="clearfix">
                                <div class="col s12 m12 l12">
                                    <input class="fluid button" type="submit" value="<?= __("Salvar") ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
