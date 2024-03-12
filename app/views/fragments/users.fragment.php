        <div class="skeleton skeleton--full" id="users">
            <div class="clearfix">
                <aside class="skeleton-aside">
                    <?php
                        $form_action = APPURL."/users";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>
                    <div class="js-search-results">
                        <?php if ($Users->getTotalCount() > 0): ?>
                            <?php $active_item_id = Input::get("id"); ?>
                            <div class="aside-list js-loadmore-content" data-loadmore-id="1">
                                <?php foreach ($Users->getDataAs("User") as $u): ?>
                                    <div style="background-color: #fff;" class="aside-list-item js-list-item <?= $active_item_id == $u->get("id") ? "active" : "" ?>">
                                        <div class="clearfix">
                                            <?php $title = $u->get("firstname")." ".$u->get("lastname"); ?>
                                            <div class="inner">
                                                <div class="title" style="font-size: 15px;font-weight: bolder;color: #51524f"><span style="color:#f07e13">»</span> <?= $title ?></div>
                                                <?php $office = $u->get("office"); $type = $u->get("account_type"); ?>
                                                <div class="sub"><b>Nível: </b><?= ucFirst($type)?></div>
                                                <?php if($u->get("account_type") != "integrador"): ?>
                                                <div class="sub"><b>Loja: </b><?= ucFirst($office)?></div>        
                                                <?php endif; ?>                                             
                                                <div class="meta">

                                                    <?php if ($u->get("is_active")): ?>
                                                        <span class="color-success">
                                                            <span class="mdi mdi-check-circle"></span>
                                                            <?= "Ativado" ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="color-danger">
                                                            <span class="mdi mdi-close-circle"></span>
                                                            <?= "Desativado" ?>
                                                        </span>
                                                    <?php endif; ?>

                                                    <?php if ($u->get("title")): ?>
                                                        <span>
                                                            <span class="mdi mdi-package-variant"></span>
                                                            <?= $u->get("title") ?>
                                                        </span>
                                                    <?php endif ?>
                                                </div>
                                            </div>

                                            <?php if ($AuthUser->canEditOrder($u)): ?>
                                                <div class="options context-menu-wrapper">
                                                    <a href="javascript:void(0)" class="mdi mdi-dots-vertical"></a>

                                                    <div class="context-menu">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0)"
                                                                   class="js-remove-list-item"
                                                                   data-id="<?= $u->get("id") ?>"
                                                                   data-url="<?= APPURL."/users" ?>">
                                                                    <?= "Delete" ?>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <a class="full-link" href="<?= APPURL."/users/".$u->get("id") ?>"></a>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>

                            <?php if($Users->getPage() < $Users->getPageCount()): ?>
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
                                    <a class="fluid button" data-loadmore-id="1" href="<?= $url.($Users->getPage()+1) ?>">
                                        <span class="icon sli sli-refresh"></span>
                                        <?= "Carregar Mais" ?>
                                    </a>
                                  </center>  
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($Users->searchPerformed()): ?>
                                <p class="search-no-result">
                                    <?= "Não foi possível encontrar os dados selecionados" ?>
                                </p>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </aside>

                <section class="skeleton-content hide-on-medium-and-down">
                    <div class="no-data">
                        <span class="no-data-icon sli sli-user"></span>
                        <p><?= "Selecione um usuário na lista ao lado para ver os detalhes ou cadastre um novo no botão acima da lista." ?></p>
                    </div>
                </section>
            </div>
        </div>
