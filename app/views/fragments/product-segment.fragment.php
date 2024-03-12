        <div class="skeleton skeleton--full" id="product-segment">
            <div class="clearfix">
                <aside class="skeleton-aside hide-on-medium-and-down">
                    <?php
                        $form_action = APPURL."/product-segments";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <div class="aside-list js-loadmore-content" data-loadmore-id="1"></div>

                        <div class="loadmore pt-20 none">
                            <a class="fluid button button--light-outline js-loadmore-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= APPURL."/product-segments?aid=".$ProdSegment->get("id")."&q=".urlencode(Input::get("q")) ?>">
                                <span class="icon sli sli-refresh"></span>
                                <?= __("Carregar Mais") ?>
                            </a>
                        </div>
                    </div>
                </aside>

                <section class="skeleton-content">
                    <form class="js-ajax-form"
                          action="<?= APPURL."/product-segments/".($ProdSegment->isAvailable() ? $ProdSegment->get("id") : "new") ?>"
                          method="POST">

                        <input type="hidden" name="action" value="save">

                        <?php
                            if(null !== $ProdSegment->get("id")){
                                if($ProdSegment->get("is_active")){
                                  $titulo = "Edição do Segmento: <label style=\"color:green;\">" . htmlchars($ProdSegment->get("name")) .  "</label>";
                                }else{
                                  $titulo = "Edição do Segmento: <label style=\"color:red;\">" . htmlchars($ProdSegment->get("name")) . "</label>";
                                }
                            } else {
                                $titulo = "Criação do Segmento";
                            }
                        ?>

                        <div class="section-header" style="border-left: 5px solid #2a3f54">
                            <?= $titulo; ?>
                        </div>

                        <div class="af-tab-heads clearfix">
                            <a href="javascript:void(0)" id="geral" class="tab-product-segments active"><?= __("Descrições do Segmento") ?></a>
                            <a href="javascript:void(0)" id="icms" class="tab-product-segments" ><?= __("ICMS") ?></a>
                        </div>

                        <div class="section-content">
                            <div class="form-result"></div>

                            <div class="tab_content" id="geral_tab">
                                <?php require_once(APPPATH.'/views/fragments/product-segment-geral.fragment.php'); ?>
                            </div>

                            <div class="tab_content" id="icms_tab" hidden>
                                <?php require_once(APPPATH.'/views/fragments/product-segment-icms.fragment.php'); ?>
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
