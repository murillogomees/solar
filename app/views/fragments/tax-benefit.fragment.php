        <div class="skeleton skeleton--full" id="benefits">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/benefits";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/benefits?aid=".$User->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form-benefits"
                          action="<?= APPURL."/benefits/".($User->isAvailable() ? $User->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                        <?php
                            if(null !== $User->get("id")){
                                if($User->get("is_active")){
                                  $titulo = "Benefício Fiscal: <label style=\"color:#51524f;\">" . htmlchars($User->get("name")) . "</label>";
                                }else{
                                  $titulo = "Benefício Fiscal: <label style=\"color:red;\">" . htmlchars($User->get("name"))  . "</label>";
                                }
                            } else {
                                $titulo = "Cadastro de Perfil Tributário";
                            }
                        ?>

                        <div class="section-header" style="border-left: 5px solid #f07e13">
                            <?= $titulo; ?>
                        </div>

                        <div id="tabs" class="af-tab-heads clearfix">
                            <a class="tab-benefits active" id="geral" href="javascript:void(0)"><?= __("Descrições do Produto") ?></a>
                            <?php $benefits = $User->isAvailable()
                                       ? json_decode($User->get("benefits"))
                                       : [];?>

                          <?php foreach ($benefits as $b): ?>                         
                            <?php
                              if ($b->id == "aliquota"){
                                $aliquota = 1;
                              } else if ($b->id == "base"){
                                $base = 1;
                              } else if ($b->id == "apuracao"){
                                $apuracao = 1;
                              }
                            ?>
                            <a class="<?= "tab-benefits " . $b->id?>" id="<?= $b->id ?>" href="javascript:void(0)"><?= ucfirst($b->value) ?></a>
                          <?php endforeach; ?>
                        </div>

                        <div class="section-content">

                              <div class="form-result"></div>

                              <div id="geral_tab" class="tab_content clearfix" > 
                                <?php require_once(APPPATH.'/views/fragments/tax-benefit-geral.fragment.php'); ?>
                              </div>

                              <div class="tab_content" id="aliquota_tab" hidden>
                                <?php require_once(APPPATH.'/views/fragments/tax-benefit-aliquota.fragment.php'); ?>
                              </div>

                              <div class="tab_content" id="base_tab" hidden>
                                <?php require_once(APPPATH.'/views/fragments/tax-benefit-base.fragment.php'); ?>
                              </div>

                              <div class="tab_content" id="apuracao_tab" hidden>
                                <?php require_once(APPPATH.'/views/fragments/tax-benefit-apuracao.fragment.php'); ?>
                              </div>                          

                              <div class="clearfix">
                                  <div class="col s12 s-last m12 m-last l12 l-last">
                                      <input class="fluid button" name="submit" type="submit" value="<?= __("Salvar") ?>">
                                  </div>
                              </div>


                        </div>
                    </form>
                </section>
            </div>
        </div>
        
