        <div class="skeleton skeleton--full" id="users">
            <div class="clearfix">
                <aside class="skeleton-aside">
                    <?php
                        $form_action = APPURL."/ncm";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php";
                    ?>

                    <div class="js-search-results">
                        <?php if ($Users->getTotalCount() > 0): ?>
                            <?php $active_item_id = Input::get("id"); ?>
                            <div class="aside-list js-loadmore-content" data-loadmore-id="1">

                                <?php foreach ($Users->getDataAs("User") as $u): ?>
                                  <?php
                                    if($u->get("is_active")){
                                      $status = "<label style=\"font-size:10px;\" class=\"color-success mdi mdi-check-circle\"> Ativado </label>";
                                    } else {
                                      $status = "<label style=\"font-size:10px;\" class=\"color-danger mdi mdi-close-circle\"> Desativado </label>";
                                    }
                                    $title = htmlchars($u->get("cod_ncm"));
                                  ?>
                                    <div style="background-color: #fff;" class="aside-list-item js-list-item <?= $active_item_id == $u->get("id") ? "active" : "" ?>">
                                        <div class="clearfix">


                                            <div class="inner">
                                                <div class="title" style="font-size: 15px;font-weight: bolder;color: #2a3f54">NCM:
                                                  <?= $title . " " . $status ?>
                                                </div>
                                                <?php
                                                        $date = date("d/m/Y H:i:s", strtotime($u->get("date")));
                                                        $resp = $this->responsavel($u->get("owner"));
                                                ?>

                                                <div class="sub"><b style="color: #506982">Data da ultima alteração: </b><?= ucFirst($date)?></div>
                                                <div class="sub"><b style="color: #506982">Responsável pela ultima alteração: </b><?php echo $resp->get("firstname"); ?></div>

                                            </div>

                                            <?php if ($AuthUser->canEdit($u)): ?>
                                                <div class="options context-menu-wrapper">
                                                    <a href="javascript:void(0)" class="mdi mdi-dots-vertical"></a>

                                                    <div class="context-menu">
                                                        <ul>
                                                            <li>
                                                                <a
                                                                href="javascript:void(0)"
                                                                   class="js-remove-list-item"
                                                                   data-id="<?= $u->get("id") ?>"
                                                                   data-url="<?= APPURL."/ncm" ?>">
                                                                    <?= __("Delete") ?>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <a class="full-link js-ajaxload-content" href="<?= APPURL."/ncm/".$u->get("id") ?>"></a>
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
                                          <?= __("Load More") ?>
                                      </a>
                                    </center>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($Users->searchPerformed()): ?>
                                <p class="search-no-result">
                                    <?= __("Couldn't find any result for your search query.") ?>
                                </p>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </aside>

                <section class="skeleton-content hide-on-medium-and-down">
                    <div class="no-data">
                        <span class="no-data-icon sli sli-book-open"></span>
                        <p><?= __("Selecione um NCM ao lado para visualizar os detalhes ou cadastre um novo no botão a cima da lista.") ?></p>
                    </div>
                </section>
            </div>
        </div>
