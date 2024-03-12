        <div class="skeleton skeleton--full" id="user">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/taxprofiles";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                          <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/taxprofiles?aid=".$User->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/taxprofiles/".($User->isAvailable() ? $User->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                        <?php
                            if(null !== $User->get("id")){
                                if($User->get("is_active")){
                                  $titulo = "Perfil Tributário: <label style=\"color:#51524f;\">" . htmlchars($User->get("name")) . "</label>";
                                }else{
                                  $titulo = "Perfil Tributário: <label style=\"color:red;\">" . htmlchars($User->get("name"))  . "</label>";
                                }
                            } else {
                                $titulo = "Cadastro de Perfil Tributário";
                            }
                        ?>

                        <div class="section-header" style="border-left: 5px solid #f07e13">
                            <?= $titulo; ?>
                        </div>

                        <div class="section-content">
                            <div class="form-result"></div>

                            <div class="clearfix">
                                    <div class="clearfix mb-20">
                                        <div class="col s6 m6 l3">
                                            <label class="form-label">
                                            <span class="compulsory-field-indicator">*</span>
                                              <?= __("Status") ?>
                                            <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __("Determina se o perfil tributário estará Ativo/Desativado.") ?>">
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


                                        <div class="col s6 s-last m6 m-last l3">
                                            <div class="pos-r">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Nome") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Informe o nome para esse Perfil Tributário.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input js-required"
                                                   name="name"
                                                   type="text"
                                                   value="<?= htmlchars($User->get("name")) ?>"
                                                   maxlength="30">
                                            </div>
                                        </div>

                                            
                                            <div class="col s12 m4 l3 mb-20"> 
                                                  <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Substituição Tributária:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determina se o perfil tributário irá substituir ou não para as opções abaixo.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

                                                 <select class="input select2" name="tax_subs">
                                                 <option value="" selected disabled hidden>Escolha uma opção</option> 
                                                 <option <?= $User->get("tax-subs") == 0 ? "selected" : "" ?> value="0"><?= __("Não") ?></option>
                                                 <optgroup label="Sim">
                                                 <option <?= $User->get("tax-subs") == 1 ? "selected" : "" ?> value="1"><?= __("Substituto") ?></option>
                                                 <option <?= $User->get("tax-subs") == 2 ? "selected" : "" ?> value="2"><?= __("Substituído") ?></option>
                                                </optgroup> 
                                              </select>
                                            </div>
                                              
                                              <div class="col s12 s-last m12 m-last l3 l-last">
                                                 <label class="form-label">
                                                  <span class="compulsory-field-indicator">*</span>
                                                  <?= __("Uso e consumo:") ?>
                                                  <span class="tooltip tippy"
                                                        data-position="top"
                                                        data-size="small"
                                                        title="<?= __("Determine se o perfil tributário cadastrado irá ser de uso e consumo próprio ou não.") ?>">
                                                        <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                              </label>

                                                 <select class="input select2" name="use-consume">
                                                 <option value="" selected disabled hidden>Escolha uma opção</option> 
                                                 <option <?= $User->get("use-consume") == 0 ? "selected" : "" ?> value="0"><?= __("Sim") ?></option>
                                                 <option <?= $User->get("use-consume") == 1 ? "selected" : "" ?> value="1"><?= __("Não") ?></option>
                                              </select>
                                            
                                          </div>
                                                                                    
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
