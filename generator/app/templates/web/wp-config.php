<?php

/** Include Genesis to use with WordPress */
require_once(dirname(__FILE__) . '/../bower_components/genesis-wordpress/src/Genesis.php');
<%= wpConfigFile
  // Already started PHP
  .replace('<?php', '')

  // Replace DB_*
  .replace('database_name_here',  props.DB_NAME)
  .replace('username_here',       props.DB_USER)
  .replace('password_here',       props.DB_PASSWORD)
  .replace('localhost',           props.DB_HOST)

  // Replace WP_DEBUG
  .replace(/define\('WP_DEBUG'.+\);/, "define('WP_DEBUG', WP_ENV === 'local');")

  // Replace salts
  .replace(/(\/\*\*#@\+(?:.|[\r\n])+?\*\/[\r\n]+)(?:.|[\r\n])+?([\r\n]+\/\*\*#@-\*\/)/m, '$1__GENERATED_SALTS_PLACEHOLDER__$2')
  .split('__GENERATED_SALTS_PLACEHOLDER__').join(props.salts)

  // Limit to 5 post revisions
  .replace("/* That's all,", "define('WP_POST_REVISIONS', 5);\n\n/*That's all,")
%>
if (WP_ENV !== 'www') {
  Genesis::rewriteUrls();
}
