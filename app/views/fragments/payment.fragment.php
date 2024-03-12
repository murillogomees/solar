        <div class="skeleton skeleton--full" id="user">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/payments";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/payments?aid=".$User->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/payments/".($User->isAvailable() ? $User->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                        <?php
                            if(null !== $User->get("id")){
                                if($User->get("is_active")){
                                  $titulo = "Condição de Pagamento: <label style=\"color:#51524f;\">" . htmlchars($User->get("name")) . "</label>";
                                }else{
                                  $titulo = "Condição de Pagamento: <label style=\"color:red;\">" . htmlchars($User->get("name")) .  "</label>";
                                }
                            } else {
                                $titulo = "Cadastro de Condição de Pagamento";
                            }
                        ?>

                        <div class="section-header" style="border-left: 5px solid #f07e13">
                            <?= $titulo; ?>
                        </div>

                        <div class="section-content">
                            <div class="form-result"></div>


                            <div class="clearfix mb-20">
                              <div class="col s6 m6 l4">
                                 <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("Nome") ?>
                                              <span class="tooltip tippy"
                                                    data-position="top"
                                                    data-size="small"
                                                    title="<?= __("Determina o nome para a Condição de Pagamento.") ?>">
                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                          </label>

                                          <input class="input js-required"
                                                 name="name"
                                                 type="text"
                                                 value="<?= htmlchars($User->get("name")) ?>"
                                                 maxlength="300">
                              </div>

                              <div class="col s6 s-last m6 m-last l4">
                                  <label class="form-label">
                                    <span class="compulsory-field-indicator">*</span>
                                    <?= __("Status") ?>
                                    <span class="tooltip tippy"
                                        data-position="top"
                                        data-size="small"
                                        title="<?= __("Determina se a condição de pagamento cadastrada estará Ativada/Desativada.") ?>">
                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                  </label>

                                  <select class="input"
                                          name="is_active">
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
                                
                                 <div class="col s12 m6 l4 l-last">
                                 <label class="form-label">
                                              <span class="compulsory-field-indicator">*</span>
                                              <?= __("Taxa de juros") ?>
                                              <span class="tooltip tippy"
                                                    data-position="top"
                                                    
                                                    data-size="small"
                                                    title="<?= __("Determina a taxa de juros para a Condição de Pagamento.") ?>">
                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                          </label>

                                           <input class="input js-required"
                                                 name="juros"
                                                 type="text"
                                                 value="<?= htmlchars($User->get("juros")) ?>"
                                                 maxlength="300">
                              </div>                               
                            </div>
                                <div class="clearfix mb-20">    
                               <div class="col s12 m6 m-last l12 l-last">
                                 <label class="form-label">                                             
                                              <?= __("Site Financiamento") ?>
                                              <span class="tooltip tippy"
                                                    data-position="top"
                                                    data-size="small"
                                                    title="<?= __("Determina a taxa de juros para a Condição de Pagamento.") ?>">
                                                    <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                          </label>

                                           <input class="input"
                                                 name="site"
                                                 type="text"
                                                 value="<?= htmlchars($User->get("site")) ?>"
                                                 maxlength="300">
                              </div>  
                                 </div>


                            <div class="clearfix">
                                <div class="col s12 m12 l6">
                                    <input class="fluid button" type="submit" value="<?= __("Salvar") ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
