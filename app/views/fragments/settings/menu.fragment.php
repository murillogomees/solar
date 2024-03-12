        <div class="asidenav">
            <div class="asidenav-group">
                <div class="asidenav-title"><?= __("Configuração") ?></div>
                <ul>
                    <li class="<?= $page == "site" ? "active" : "" ?>"><a href="<?= APPURL."/settings/site" ?>"><?= __("Ajustes do site") ?></a></li>
                </ul>
            </div>

            <div class="asidenav-group">
                <div class="asidenav-title"><?= __("Personalização Financeira") ?></div>
                <ul>                 
                    <li class="<?= $page == "margem" ? "active" : "" ?>"><a href="<?= APPURL."/margem" ?>"><?= __("Margem padrão") ?></a></li>
                    <li class="<?= $page == "icms" ? "active" : "" ?>"><a href="<?= APPURL."/icms" ?>"><?= __("Configurações ICMS") ?></a></li>
                    <li class="<?= $page == "benefits" ? "active" : "" ?>"><a href="<?= APPURL."/benefits" ?>"><?= __("Benefícios fiscais") ?></a></li>
                    <li class="<?= $page == "payments" ? "active" : "" ?>"><a href="<?= APPURL."/payments" ?>"><?= __("Condições de pagamento") ?></a></li>
                    <li class="<?= $page == "states" ? "active" : "" ?>"><a href="<?= APPURL."/states" ?>"><?= __("Substituição tributária para Estados") ?></a></li>
                    <li class="<?= $page == "shipping" ? "active" : "" ?>"><a href="<?= APPURL."/shipping" ?>"><?= __("Frete") ?></a></li>
                </ul>
            </div>

            <div class="asidenav-group">
                <div class="asidenav-title"><?= __("Personalização do Produto") ?></div>
                <ul>                    
                    <li class="<?= $page == "ncm" ? "active" : "" ?>"><a href="<?= APPURL."/ncm" ?>"><?= __("Gestão de NCM") ?></a></li>
                    <li class="<?= $page == "producers" ? "active" : "" ?>"><a href="<?= APPURL."/producers" ?>"><?= __("Fabricantes") ?></a></li>
                    <li class="<?= $page == "product-kits" ? "active" : "" ?>"><a href="<?= APPURL."/product-kits" ?>"><?= __("Kit de produtos") ?></a></li>
                    <li class="<?= $page == "product-segments" ? "active" : "" ?>"><a href="<?= APPURL."/product-segments" ?>"><?= __("Segmentos de produtos") ?></a></li>                  
                    <li class="<?= $page == "product-types" ? "active" : "" ?>"><a href="<?= APPURL."/product-types" ?>"><?= __("Tipo do produto") ?></a></li>
                    <li class="<?= $page == "product-models" ? "active" : "" ?>"><a href="<?= APPURL."/product-models" ?>"><?= __("Modelo do produto") ?></a></li>                    
                    <li class="<?= $page == "origins" ? "active" : "" ?>"><a href="<?= APPURL."/origins" ?>"><?= __("Origem dos produtos") ?></a></li>
                    <li class="<?= $page == "garantias" ? "active" : "" ?>"><a href="<?= APPURL."/garantias" ?>"><?= __("Prazo de Garantia") ?></a></li>
                </ul>
            </div>
          
          
            <div class="asidenav-group">
                <div class="asidenav-title"><?= __("Personalização de Cliente") ?></div>
                <ul>   
                    <li class="<?= $page == "branchs" ? "active" : "" ?>"><a href="<?= APPURL."/branchs" ?>"><?= __("Filiais") ?></a></li>
                    <li class="<?= $page == "taxprofiles" ? "active" : "" ?>"><a href="<?= APPURL."/taxprofiles" ?>"><?= __("Perfis Tributários") ?></a></li>                           
                </ul>
            </div>



            <div class="asidenav-group">
                <div class="asidenav-title"><?= __("E-mail") ?></div>
                <ul>
                    <li class="<?= $page == "smtp" ? "active" : "" ?>"><a href="<?= APPURL."/settings/smtp" ?>"><?= __("SMTP") ?></a></li>
                    <li class="<?= $page == "notifications" ? "active" : "" ?>"><a href="<?= APPURL."/settings/notifications" ?>"><?= __("Notificações de E-Mail") ?></a></li>
                </ul>
            </div>


        </div>
