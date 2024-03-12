        <div class="skeleton skeleton--full" id="product">
            <div class="clearfix">              
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/products";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/products?aid=".$User->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/products/".($User->isAvailable() ? $User->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                        <?php
                            if(!$User->isAvailable()){                                
                                if($User->get("is_active")){
                                  $titulo = "Produtos: <label style=\"color:#51524f;\">" . htmlchars($User->get("name")) . "</label>";
                                }else{
                                  $titulo = "Produtos: <label style=\"color:red;\">" . htmlchars($User->get("name")) . "</label>";
                                }
                            } else {
                                $titulo = "Cadastro de Produto";                                
                            }
                        ?>

                        <div class="section-header" style="border-left: 5px solid #f07e13">
                              <div class="clearfix">
                                     <div class="col s12 m12 l12">
                                        <?= $titulo; ?>
                                     </div>     
                             </div>
                        </div>

                       <div id="tabs" class="af-tab-heads clearfix">
                           <a href="javascript:void(0)" id="geral" class="tab-product geral active"><?= __("Descrições do Produto") ?></a>
                           <a href="javascript:void(0)" id="fiscal" class="tab-product fiscal"><?= __("Informações do Produto") ?></a>
                       </div>

                        <div class="section-content" style="max-width:100%">
                            <div class="form-result"></div>
                           
                              <div id="geral_tab" class="tab_content clearfix" >
                                <?php require_once(APPPATH.'/views/fragments/product-geral.fragment.php'); ?>
                              </div>

                              <div id="fiscal_tab" class="tab_content" hidden style="margin-left:15px;">
                                <?php require_once(APPPATH.'/views/fragments/product-fiscal.fragment.php'); ?>
                              </div>
                          
                              <div class="clearfix">
                                  <div class="col s12 m12 l12">
                                      <input style="width:100%" class="fluid button" name="submit" type="submit" value="<?= __("Salvar") ?>">
                                  </div>
                              </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>

