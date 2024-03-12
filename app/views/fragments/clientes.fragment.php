        <div class="skeleton skeleton--full" id="users">
            <div class="clearfix">
                <aside class="skeleton-aside">
                    <?php 
                        $form_action = APPURL."/clients";
                        include APPPATH."/views/fragments/aside-search-form.fragment.php"; 
                    ?>

                    <div class="js-search-results">
                        <?php if ($Users->getTotalCount() > 0): ?>
                            <?php $active_item_id = Input::get("aid"); ?>
                            <div class="aside-list js-loadmore-content" data-loadmore-id="1">
                            
                                <?php foreach ($Users->getDataAs("User") as $u): ?>
                                    <div style="background-color: #fff;" class="aside-list-item js-list-item <?= $active_item_id == $u->get("id") ? "active" : "" ?>">
                                        <div class="clearfix">
                                            <?php $title = mb_strtoupper($u->get("name"),"UTF-8");  ?>                                             
                                            <div class="inner">
                                                <div class="title" style="font-size: 15px;font-weight: bolder;color: #51524f"><span style="color:#f07e13">»</span>  <?= $title ?></div>
                                                <?php                                                     
                                                        $cnpj = $u->get("cnpj");
                                                        $type = $u->get("client_type");  
                                                        $uf = $u->get("uf"); 
                                                ?>
                                                <div class="sub"><b>UF: </b><?= ucFirst($uf)?></div>
                                                <div class="sub"><b>Tipo: </b><?= ucFirst($type)?></div>
                                                <div class="sub"><b>CNPJ: </b><?= formatar('cnpj',$cnpj)?></div> 
                                            </div>

                                            <?php if ($AuthUser->canEdit($AuthUser)): ?>
                                                <div class="options context-menu-wrapper">
                                                    <a href="javascript:void(0)" class="mdi mdi-dots-vertical"></a>

                                                    <div class="context-menu">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0)" 
                                                                   class="js-remove-list-item" 
                                                                   data-id="<?= $u->get("id") ?>" 
                                                                   data-url="<?= APPURL."/clients" ?>">
                                                                    <?= __("Delete") ?>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>                                                
                                            <?php endif ?>
                                            <a class="full-link js-ajaxload-content" href="<?= APPURL."/clients/".$u->get("id") ?>"></a>
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
                                    <?= __("Não foi encontrado ninguém com as informações digitadas.") ?>
                                </p>
                            <?php endif ?>
                        <?php endif ?>
                    </div>
                </aside>

                <section class="skeleton-content hide-on-medium-and-down">
                    <div class="no-data">
                        <span class="no-data-icon sli sli-user"></span>
                        <p><?= __("Selecione um cliente na lista ao lado para ver os detalhes ou cadastre um novo no botão acima da lista.") ?></p>
                    </div>
                </section>
            </div>
        </div>
