<?php
// Language slug
//
// Will be used theme routes
$langs = [];
foreach (Config::get("applangs") as $l) {
    if (!in_array($l["code"], $langs)) {
        $langs[] = $l["code"];
    }

    if (!in_array($l["shortcode"], $langs)) {
        $langs[] = $l["shortcode"];
    }
}
$langslug = $langs ? "[".implode("|", $langs).":lang]" : "";


/**
 * Theme Routes
 */

// Index (Landing Page)
//
// Replace "Index" with "Login" to completely disable Landing page
// After this change, Login page will be your default landing page
//
// This is useful in case of self use, or having different
// landing page in different address. For ex: you can install the script
// to subdirectory or subdomain of your wordpress website.
App::addRoute("GET|POST", "/", "Login");
App::addRoute("GET|POST", "/".$langslug."?/?", "Login");

// Login
App::addRoute("GET|POST", "/".$langslug."?/login/?", "Login");

// Signup
//
//  Remove or comment following line to completely
//  disable signup page. This might be useful in case
//  of self use of the script
App::addRoute("GET|POST", "/".$langslug."?/signup/?", "Signup");

// Logout
App::addRoute("GET", "/".$langslug."?/logout/?", "Logout");

// Recovery
App::addRoute("GET|POST", "/".$langslug."?/recovery/?", "Recovery");
App::addRoute("GET|POST", "/".$langslug."?/recovery/[i:id].[a:hash]/?", "PasswordReset");
App::addRoute("GET|POST", "/".$langslug."?/novasenha/?", "NovaSenha");

/**
 * App Routes
 */

App::addRoute("GET|POST", "/margem/?", "Margem");

// Settings
$settings_pages = [
  "site", "logotype", "notifications", "smtp"
];
App::addRoute("GET|POST", "/settings/[".implode("|", $settings_pages).":page]?/?", "Settings");

// Users
App::addRoute("GET|POST", "/users/?", "Users");
// New User
App::addRoute("GET|POST", "/users/new/?", "User");
// Edit User
App::addRoute("GET|POST", "/users/[i:id]/?", "User");
App::addRoute("GET|POST", "/profile/?", "Profile");

// Edit API Produtos
App::addRoute("GET|POST", "/api/produtos/[a:hash]/?", "ApiProdutos");

App::addRoute("GET|POST", "/ajax/?", "Ajax");

App::addRoute("GET|POST", "/inatividade/?", "CronInatividade");
// Cliente
App::addRoute("GET|POST", "/clients/?", "Clientes");
// New Client
App::addRoute("GET|POST", "/clients/new/?", "Cliente");
// Edit Client
App::addRoute("GET|POST", "/clients/[i:id]/?", "Cliente");

// ICMS
App::addRoute("GET|POST", "/icms/?", "Icms");
// New ICMS
App::addRoute("GET|POST", "/icms/new/?", "Icm");
// Edit ICMS
App::addRoute("GET|POST", "/icms/[i:id]/?", "Icm");

// Edit ICMS
App::addRoute("GET|POST", "/teste/?", "Teste");

// NCM
App::addRoute("GET|POST", "/ncm/?", "Ncms");
// New NCM
App::addRoute("GET|POST", "/ncm/new/?", "Ncm");
// Edit NCM
App::addRoute("GET|POST", "/ncm/[i:id]/?", "Ncm");

// Product
App::addRoute("GET|POST", "/products/?", "Products");
// New Product
App::addRoute("GET|POST", "/products/new/?", "Product");
// Edit Product
App::addRoute("GET|POST", "/products/[i:id]/?", "Product");

// Product Segments
App::addRoute("GET|POST", "/product-segments/?", "ProductSegments");
// New Product Segments
App::addRoute("GET|POST", "/product-segments/new/?", "ProductSegment");
// Edit Product Segments
App::addRoute("GET|POST", "/product-segments/[i:id]/?", "ProductSegment");

// Product Kits
App::addRoute("GET|POST", "/product-kits/?", "ProductKits");
// New Product Kits
App::addRoute("GET|POST", "/product-kits/new/?", "ProductKit");
// Edit Product Kits
App::addRoute("GET|POST", "/product-kits/[i:id]/?", "ProductKit");

// Origin
App::addRoute("GET|POST", "/origins/?", "Origins");
// New Origin
App::addRoute("GET|POST", "/origins/new/?", "Origin");
// Edit Origin
App::addRoute("GET|POST", "/origins/[i:id]/?", "Origin");

// Product Models
App::addRoute("GET|POST", "/product-models/?", "ProductModels");
// New Product Models
App::addRoute("GET|POST", "/product-models/new/?", "ProductModel");
// Edit Product Models
App::addRoute("GET|POST", "/product-models/[i:id]/?", "ProductModel");

// Tax Profiles
App::addRoute("GET|POST", "/taxprofiles/?", "TaxProfiles");
// New Tax Profile
App::addRoute("GET|POST", "/taxprofiles/new/?", "TaxProfile");
// Edit Tax Profile
App::addRoute("GET|POST", "/taxprofiles/[i:id]/?", "TaxProfile");

// Producers
App::addRoute("GET|POST", "/producers/?", "Producers");
// New Tax Producer
App::addRoute("GET|POST", "/producers/new/?", "Producer");
// Edit Tax Producer
App::addRoute("GET|POST", "/producers/[i:id]/?", "Producer");

App::addRoute("GET|POST", "/relatorio/frete/?", "OrdersB");
// Producers
App::addRoute("GET|POST", "/order/?", "Orders");
// New Producer
App::addRoute("GET|POST", "/order/new/?", "Order");
// Edit Producer
App::addRoute("GET|POST", "/order/[i:id]/?", "Order");

App::addRoute("GET|POST", "/rascunho/[i:id]/?", "Rascunho");

// Fix Kit
App::addRoute("GET|POST", "/product-types/?", "ProductTypes");
// Fix kir
App::addRoute("GET|POST", "/product-types/new/?", "ProductType");
// Fix kit
App::addRoute("GET|POST", "/product-types/[i:id]/?", "ProductType");

// Origin
App::addRoute("GET|POST", "/payments/?", "Payments");
// New Origin
App::addRoute("GET|POST", "/payments/new/?", "Payment");
// Edit Origin
App::addRoute("GET|POST", "/payments/[i:id]/?", "Payment");

// Branch
App::addRoute("GET|POST", "/branchs/?", "Branchs");
// New Branch
App::addRoute("GET|POST", "/branchs/new/?", "Branch");
// Edit Branch
App::addRoute("GET|POST", "/branchs/[i:id]/?", "Branch");

// State
App::addRoute("GET|POST", "/states/?", "States");
// New State
App::addRoute("GET|POST", "/states/new/?", "State");
// Edit State
App::addRoute("GET|POST", "/states/[i:id]/?", "State");

// Frete
App::addRoute("GET|POST", "/frete/[i:id]/?", "Frete");

// State
App::addRoute("GET|POST", "/budget/?", "Budget");
// New State
App::addRoute("GET|POST", "/budget/new/?", "Budget");
// Edit State
App::addRoute("GET|POST", "/budget/[i:id]/?", "Budget");

App::addRoute("GET|POST", "/orcamento/[a:hash]/?", "OrcamentoCliente");

// Shipp
App::addRoute("GET|POST", "/shipping/?", "Shipping");
// New Shipp
App::addRoute("GET|POST", "/shipping/new/?", "Shipp");
// Edit Shipp
App::addRoute("GET|POST", "/shipping/[i:id]/?", "Shipp");

// Calendar
//App::addRoute("GET|POST", "/calendar/?", "Calendar");
///App::addRoute("GET|POST", "/calendar/[i:year]/[i:month]/?", "Calendar");
// Calendar Day
//App::addRoute("GET|POST", "/calendar/[i:year]/[i:month]/[i:day]?", "Calendar");

// Edit Shipp
App::addRoute("GET|POST", "/cronteste/?", "CronTeste");

// Edit Shipp
App::addRoute("GET|POST", "/santri/?", "SantriCategory");
// Edit Cron Geral
App::addRoute("GET|POST", "/cron/vencimento/?", "CronGeral");
// Edit Cron Geral
App::addRoute("GET|POST", "/cronfrete/?", "CronFrete");
// Edit Cron Geral
App::addRoute("GET|POST", "/cronfilialorder/?", "CronFilialOrder");
// Edit Cron Geral
App::addRoute("GET|POST", "/cronentregas/?", "CronEntregas");
App::addRoute("GET|POST", "/cron/valor/pedido/?", "CronValorPedido");

// Edit Cron Geral
App::addRoute("GET|POST", "/cronstatus/?", "CronStatus");

App::addRoute("GET|POST", "/valor/pedido?", "ValorPedido");
// Checkout Results
//App::addRoute("GET|POST", "/checkout/[i:id].[a:hash]/?", "CheckoutResult");
//App::addRoute("GET|POST", "/checkout/error/?", "CheckoutResult");
// Edit Shipp
App::addRoute("GET|POST", "/logs/?", "Logs");
// Cron
App::addRoute("GET|POST", "/cron/?", "Cron");
App::addRoute("GET|POST", "/cronroller/?", "CronRoller");
// Cron
App::addRoute("GET|POST", "/cronestoque/?", "CronEstoqueSantri");

// Email verification
App::addRoute("GET|POST", "/verification/email/[i:id].[a:hash]?/?", "EmailVerification");

// Email verification
App::addRoute("GET|POST", "/consulta/solar/budget/[i:id]/?", "BudgetFrete");

// Email verification
App::addRoute("GET|POST", "/garantias/?", "Garantias");
// Email verification
App::addRoute("GET|POST", "/garantias/new/?", "Garantia");
// Email verification
App::addRoute("GET|POST", "/garantias/[i:id]/?", "Garantia");

// Email verification
App::addRoute("GET|POST", "/aguarde/?", "AguardeCadastro");

// Email verification
App::addRoute("GET|POST", "/sessao/?", "Sessao");

// Email verification
App::addRoute("GET|POST", "/politica-privacidade/?", "Politica");
App::addRoute("GET|POST", "/termo/?", "Termo");
// Email verification
App::addRoute("GET|POST", "/cron/rascunho/?", "CronRascunho");

App::addRoute("GET|POST", "/relatorio/?", "Relatorio");

App::addRoute("GET|POST", "/comissionamentos/?", "Comissionamentos");
App::addRoute("GET|POST", "/comissionamentos/[i:id]/?", "Comissionamento");