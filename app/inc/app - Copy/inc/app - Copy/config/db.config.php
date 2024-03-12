<?php
/**
 * Define database credentials
 */
define("DB_HOST", "localhost");
define("DB_NAME", "banco_dev_solar");
define("DB_USER", "usuario_dev_solar");
define("DB_PASS", "!YnG;uGHT^ct{!6");
define("DB_ENCODING", "utf8mb4"); // DB connnection charset


/**
 * Define DB tables
 */
define("TABLE_PREFIX", "np_");

// Set table names without prefix
define("TABLE_USERS", "users");
define("TABLE_CLIENT", "client");
define("TABLE_ICMS", "icms");
define("TABLE_STATES", "states");
define("TABLE_NCM", "ncm");
define("TABLE_PRODUCTS", "products");
define("TABLE_PRODUCT_SEGMENTS", "product_segments");
define("TABLE_PRODUCT_KITS", "product_kits");
define("TABLE_ORIGINS", "origin");
define("TABLE_PRODUCT_MODELS", "product_models");
define("TABLE_BENEFITS", "tax_benefits");
define("TABLE_PROFILES", "tax_profile");
define("TABLE_PRODUCERS", "producer");
define("TABLE_PRODUCT_TYPES", "product_types");
define("TABLE_RASCUNHO", "rascunho");
define("TABLE_ORDERS", "orders");
define("TABLE_PAYMENTS", "payments");
define("TABLE_BRANCH", "branch");
define("TABLE_SHIPPING", "shipping");
define("TABLE_LOGS", "logs");
define("TABLE_FRETE", "frete");
define("TABLE_GARANTIAS", "garantias");

define("TABLE_GENERAL_DATA", "general_data");
define("TABLE_OPTIONS", "options");
define("TABLE_FILES", "files");
define("TABLE_WEBHOOK", "webhook");
define("TABLE_OPCOES_MENSAGENS", "opcoes_mensagens");
