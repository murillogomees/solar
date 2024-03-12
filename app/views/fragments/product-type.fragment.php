        <div class="skeleton skeleton--full" id="user">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/product-types";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/product-types?aid=".$ProdType->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/product-types/".($ProdType->isAvailable() ? $ProdType->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                        <?php
                            if(null !== $ProdType->get("id")){
                                if($ProdType->get("is_active")){
                                  $titulo = "Tipo de Produto: <label style=\"color:green;\">" . htmlchars($ProdType->get("name")) . "</label>";
                                }else{
                                  $titulo = "Tipo de Produto: <label style=\"color:red;\">" . htmlchars($ProdType->get("name")) .  "</label>";
                                }
                            } else {
                                $titulo = "Cadastro de Tipo de Produto";
                            }
                        ?>

                        <div class="section-header" style="border-left: 5px solid #2a3f54">
                            <?= $titulo; ?>
                        </div>

                        <div class="section-content">
                            <div class="form-result"></div>


                            <div class="clearfix mb-20">                             

                              <div class="col s6 m6 l6 ">
                                  <label class="form-label">
                                  <span class="compulsory-field-indicator">*</span>
                                  <?= __("Status") ?>
                                  <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Determina se o tipo de produto estará Ativo/Desativado.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                  </span>
                                  </label>

                                  <select class="input"
                                          name="is_active">
                                      <?php
                                          if ($ProdType->isAvailable()) {
                                              $status = $ProdType->get("is_active") ? 1 : 0;
                                          } else {
                                              $status = 1;
                                          }
                                      ?>
                                      <option value="1" <?= $status == 1 ? "selected" : "" ?>><?= __("Ativo") ?></option>
                                      <option value="0" <?= $status == 0 ? "selected" : "" ?>><?= __("Desativado") ?></option>
                                  </select>
                              </div>
                              
                               <div class="col s6 s-last m6 m-last l6 l-last">
                                <label class="form-label">
                                <span class="compulsory-field-indicator">*</span>
                                <?= __("Nome") ?>
                                <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __('Digite aqui o nome do tipo de produto a ser cadastrado.') ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                                </span>
                                          </label>

                                          <input class="input js-required"
                                                 name="name"
                                                 type="text"
                                                 value="<?= htmlchars($ProdType->get("name")) ?>"
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
        