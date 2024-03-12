        <div class="skeleton skeleton--full" id="branch">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/branchs";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/branchs?aid=".$User->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/branchs/".($User->isAvailable() ? $User->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                        <?php
                            if(null !== $User->get("id")){
                                if($User->get("is_active")){
                                  $titulo = "Usuário: <label style=\"color:green;\">" . htmlchars($User->get("name")) . " - ". strtoupper($User->get("uf")) . "</label>";
                                }else{
                                  $titulo = "Usuário: <label style=\"color:red;\">" . htmlchars($User->get("name")) . " - ". strtoupper($User->get("uf")) . "</label>";
                                }
                            } else {
                                $titulo = "Cadastro de Usuário";
                            }
                        ?>

                        <div class="section-header" style="border-left: 5px solid #2a3f54">
                            <?= $titulo; ?>
                        </div>

                        <div class="section-content">
                            <div class="form-result"></div>

                            <div class="clearfix">
                                    <div class="clearfix mb-20">                                        

                                        <div class="col s6 s-last m6 m-last l2">
                                            <label class="form-label">
                                            <span class="compulsory-field-indicator">*</span>
                                              <?= __("Status") ?>
                                            <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __("Determina se a filial ficará ativa ou desativada.") ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <select class="input"
                                                    name="is_active"
                                                    >
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
                                           <div class="col s6 s-last m6 m-last l2">
                                            <label class="form-label">
                                            <span class="compulsory-field-indicator">*</span>
                                              <?= __("Tipo Filial") ?>
                                            <span class="tooltip tippy"
                                                  data-position="top"
                                                  data-size="small"
                                                  title="<?= __("Determina se a filial ") ?>">
                                                  <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <select class="input"
                                                    name="tipoFilial"
                                                    >
                                                <?php $tipo_filial =  $User->get("tipo_filial") ?>
                                                <option value="1" <?= $tipo_filial == 1 ? "selected" : "" ?>>Fisica</option>
                                                <option value="0" <?= $tipo_filial == 0 ? "selected" : "" ?>>Virtual</option>
                                            </select>
                                        </div>
                                   

                                        <div class="col s6 m6 l3 mb-20">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Nome") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Determina o nome para a filial.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input js-required"
                                                   name="name"
                                                   type="text"
                                                   value="<?= htmlchars($User->get("name")) ?>"
                                                   maxlength="30">
                                        </div>

                                        <div class="col s6 s-last m6 m-last l2 mb-20 ">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("UF") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Defina a sigla da unidade federativa.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                               <select class="input select2" name="uf">
                                                 <option value="" selected disabled hidden>UF da Filial</option>                                                                                                
                                                  <?php foreach($States->getDataAs("State") as $k):?>
                                                    <option <?= $User->get("uf") == $k->get("uf") ? "selected" : "" ?> value="<?=  $k->get("uf") ?>" ><?= strtoupper($k->get("uf")) ?></option>
                                                  <?php endforeach;?>                                                                                                  
                                              </select>
                                        </div>
                                    

                                        <div class="col s6 m6 l3 l-last">
                                            <label class="form-label">
                                                <span class="compulsory-field-indicator">*</span>
                                                <?= __("Cidade") ?>
                                                <span class="tooltip tippy"
                                                      data-position="top"
                                                      data-size="small"
                                                      title="<?= __("Insira o nome da cidade.") ?>">
                                                      <span class="mdi mdi-help-circle" style="font-size:13px;"></span>
                                            </label>

                                            <input class="input js-required"
                                                   name="city"
                                                   type="text"                                                 
                                                   value="<?= htmlchars($User->get("city")) ?>"
                                                   maxlength="11">
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
                                      