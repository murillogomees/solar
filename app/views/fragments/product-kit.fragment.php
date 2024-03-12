        <div class="skeleton skeleton--full" id="product-kit">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/product-kits";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/product-kits?aid=".$ProdKit->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/product-kits/".($ProdKit->isAvailable() ? $ProdKit->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                        <?php
                            if(null !== $ProdKit->get("id")){
                                if($ProdKit->get("is_active")){
                                  $titulo = "Edição do Kit: <label style=\"color:green;\">" . htmlchars($ProdKit->get("name")) .  "</label>";
                                }else{
                                  $titulo = "Edição do Kit: <label style=\"color:red;\">" . htmlchars($ProdKit->get("name")) . "</label>";
                                }
                            } else {
                                $titulo = "Criação do Kit";
                            }
                        ?>

                        <div class="section-header" style="border-left: 5px solid #2a3f54">
                            <?= $titulo; ?>
                        </div>

                        <div class="af-tab-heads clearfix">
                            <a href="javascript:void(0)" id="geral" class="tab-product-kits active"><?= __("Descrição do Kit") ?></a>
                            <a href="javascript:void(0)" id="icms" class="tab-product-kits" ><?= __("ICMS") ?></a>
                        </div>

                        <div class="section-content">
                            <div class="form-result"></div>

                            <div class="tab_content" id="geral_tab">
                                <?php require_once(APPPATH.'/views/fragments/product-kit-geral.fragment.php'); ?>
                            </div>

                            <div class="tab_content" id="icms_tab" hidden>
                                <?php require_once(APPPATH.'/views/fragments/product-kit-icms.fragment.php'); ?>
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
