        <div class="skeleton skeleton--full" id="product-models">
            <div class="clearfix">
                <aside class="skeleton-aside">
                    <?php
                        $form_action = APPURL."/product-models";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <?php if ($ProdModels->getTotalCount() > 0): ?>
                            <?php $active_item_id = Input::get("aid"); ?>
                            <div class="aside-list js-loadmore-content" data-loadmore-id="1">

                                <?php foreach ($ProdModels->getDataAs("ProductModel") as $u): ?>

                                    <div style="background-color: #fff;" class="aside-list-item js-list-item <?= $active_item_id == $u->get("id") ? "active" : "" ?>">
                                        <div class="clearfix">

                                            <?php $title = htmlchars($u->get("name")." "); ?>

                                            <div class="inner">
                                                <div class="title" style="font-size: 15px;font-weight: bolder;color: #51524f"><span style="color:#f07e13">»</span> <?= $title ?></div>
                                                <?php

                                                        $active_is = $u->get("is_active");

                                                ?>

                                                <div class="sub"><b style="color: #506982">Código de Origem: </b><?= ucFirst($is_active)?></div>
                                                <div class="meta">

                                                    <?php if ($u->get("is_active")): ?>
                                                        <span class="color-success">
                                                            <span class="mdi mdi-check-circle"></span>
                                                            <?= __("Ativado") ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="color-danger">
                                                            <span class="mdi mdi-close-circle"></span>
                                                            <?= __("Desativado") ?>
                                                        </span>
                                                    <?php endif; ?>

                                                    <?php if ($u->get("title")): ?>
                                                        <span>
                                                            <span class="mdi mdi-package-variant"></span>
                                                            <?= htmlchars($u->get("title")) ?>
                                                        </span>
                                                    <?php endif ?>
                                                </div>
                                            </div>

                                            
                                                <div class="options context-menu-wrapper">
                                                    <a href="javascript:void(0)" class="mdi mdi-dots-vertical"></a>

                                                    <div class="context-menu">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0)"
                                                                   class="js-remove-list-item"
                                                                   data-id="<?= $u->get("id") ?>"
                                                                   data-url="<?= APPURL."/product-models" ?>">
                                                                    <?= __("Delete") ?>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <a class="full-link js-ajaxload-content" href="<?= APPURL."/product-models/".$u->get("id") ?>"></a>
                                        
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>

                            <?php if($ProdModels->getPage() < $ProdModels->getPageCount()): ?>
                                <div class="loadmore mt-20">
                                    <?php
                                        $url = parse_url($_SERVER["REQUEST_URI"]);
                                        $path = $url["path"];
                                        if(isset($url["query"])){
                                            $qs = parse_str($url["query"], $qsarray);
                                            unset($qsarray["page"]);


                                            $url = $path."?".(count($qsarray) > 0 ? http_build_query($qsarray)."&" : "")."page=";
                                        }else{
                                            $url = $path."?page=";
                                        }
                                    ?>
                                  <center>
                                    <a class="fluid button" data-loadmore-id="1" href="<?= $url.($ProdModels->getPage()+1) ?>">
                                        <span class="icon sli sli-refresh"></span>
                                        <?= __("Load More") ?>
                                    </a>
                                  </center>  
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($ProdModels->searchPerformed()): ?>
                                <p class="search-no-result">
                                    <?= __("Couldn't find any result for your search query.") ?>
                                </p>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </aside>

                <section class="skeleton-content hide-on-medium-and-down">
                    <div class="no-data">
                        <span class="no-data-icon sli sli-puzzle"></span>
                        <p><?= __("Selecione um Modelo de Produto na lista ao lado para visualizar os detalhes ou cadastre um novo no botão acima da lista.") ?></p>
                    </div>
                </section>
            </div>
        </div>
