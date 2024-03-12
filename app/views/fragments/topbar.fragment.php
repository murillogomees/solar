        <div id="topbar">
            <div class="clearfix" style="background-color: #fff;color:#51524f">
                <a href="javascript:void(0)" class="topbar-mobile-menu-icon mdi mdi-menu" style></a>

              
                
                <?php if (!empty($TopBar->title)): ?>
                    <h1 class="topbar-title"><?= $TopBar->title ?></h1>
                <?php endif ?>

                <?php if (!empty($TopBar->subtitle)): ?>
                    <div class="topbar-subtitle"><?= $TopBar->subtitle ?></div>
                <?php endif ?>

                <?php if (!empty($TopBar->btn)): ?>                   
                    <a class="topbar-special-link" href="<?= !empty($TopBar->btn["link"]) ? $TopBar->btn["link"] : "javascript:void(0)" ?>">
                        <?php if (!empty($TopBar->btn["icon"])): ?>
                            <span class="icon <?= $TopBar->btn["icon"] ?>"></span>
                        <?php endif ?>   
                      
                        
                        <?php if (!empty($TopBar->btn["title"])): ?>
                            <?= $TopBar->btn["title"] ?>
                        <?php endif ?>
                    </a>
                <?php endif ?>    
                 
              
              
                  <div class="topbar-actions clearfix"> 
                    <a target="_blank" href="https://suporte.horus.com.br"><img class="topbar-title" style="margin-bottom:0;margin-top: 7px; margin-right: 20px; filter: invert(1);" src="<?= APPURL. "/assets/img/sup.png"?>" width="50px"> </a>
                    <span class="mdi mdi-help-circle notificacao topbar-title" style="margin-right:30px;margin-top:22px;font-size:22px"> </span> 
                    <div class="mensagem" id="mensagem" hidden>
                        <div style="margin-bottom:15px">
                           Dicas Principais do Sistema <a href="javascript:void(0)" class="notificacao"  style="float: right; padding-right:10px;">X Fechar</a>
                        </div>
                        <div style="color:#51524f">
                          <li style="margin-bottom:5px"> Lembre-se sempre de salvar as alterações ao conclui-las. </li>
                          <li style="margin-bottom:5px"> Para realizar a cotação de frete clique no ícone do avião <span style="font-size:15px" class="mdi mdi-airplane-off iconmin"></span> na tabela. </li>
                          <li style="margin-bottom:5px"> Caso não aprove suas solicitações, elas não serão computadas para o relatório final de desenvolvimento dos vendedores. </li>
                          <li style="margin-bottom:5px"> Sempre que ocorrer um erro, aperte <b>CTRL + F5</b> na página e tente duas vezes antes de comunicar o suporte, alguns problemas podem </br> ter ocorrido devido a desvio de atenção no preenchimento dos formulários. </li>                                     
                          <li style="margin-bottom:5px"> Sempre que ocorrer um erro, tente duas vezes antes de comunicar o suporte, alguns problemas podem </br> ter ocorrido devido a desvio de atenção no preenchimento dos formulários. </li> 
                          <li style="margin-bottom:25px"> Toda e qualquer dificuldade encontrada deverá ser remetida ao Rainey Soares, que irá instrui-los corretamente sobre a utilização do sistema. </li>
                          <li style="margin-bottom:5px"><b> Caso tenha sugestões ou algum erro no sistema persista <a style="color:#f07e13;" target="_blank" href="https://suporte.horus.com.br">clique aqui</a> e abra um chamado com o suporte!</b></li>
                        </div>
                    </div>
                    <input class="model-notificacao" value="0" hidden>       			
                    <a href="<?= APPURL."/order/new" ?>">
                     <input class="fluid button button--oval topbar-title" style="width: 13rem; height:27px; padding:2px 2px;margin-right:50px;color:#fff;font-size:13px" type="submit" value="Cadastrar Orçamento"> 
                    </a>
                    <div class="topbar-title" style="padding-right:7px;font-size:12px;padding-top:2px;">Conectado como:</div><div class="topbar-title" style="color:#51524f;padding-right: 7px;"><?= $AuthUser->get("firstname") ?></div>
                      <div class="item">
                     
                        <div class="topbar-profile clearfix">   
                          

                            <div class="pull-left clearfix context-menu-wrapper">
                                <?php if($AuthUser->get("imagem") != ""): ?>
                                <a href="javascript:void(0)"><img style="border-radius:100%; width: 45px; height: 45px; margin-top: -4px; margin-left: -8px;background-color:#ffffff;" src="<?= $AuthUser->get("imagem") ?>"></a>
                                <?php else: ?>
                              <a href="javascript:void(0)"><img style="border-radius:100%; width: 45px; height: 45px; margin-top: -4px; margin-left: -8px;background-color:#ffffff;" src="<?=APPURL."/assets/img/horus-icon.png" ?>"></a>
                                <?php endif;?>

                                <div class="context-menu">
                                    <ul>
                                        <li><a href="<?= APPURL."/profile" ?>"><?= __('Perfil') ?></a></li>
                                        <li><a href="<?= APPURL."/logout" ?>"><?= __('Sair') ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        