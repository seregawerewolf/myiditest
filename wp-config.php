<?php
/**оооо
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/var/www/wolf/data/www/blogovo.net/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'wp' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'werewolf' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'W1o8l0v4' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '~Ox=P3sE _Cl9a<$[)i9]$~y`$Jw`W6HsFl)&{:[S%J6>s_c)TOSE]PaRvfWYN-0' );
define( 'SECURE_AUTH_KEY',  'z@D7.[30O^sEI[#R&A4^yH^@xQ&B1L3BN=m@N:m<#?&Osj3OmNVJR*.M)=<50qtt' );
define( 'LOGGED_IN_KEY',    'AgkX*k7hPq!I.G<=(,,1Eof%=-O6y<TuTu`n@BY(7mMAVq?$L 8*YnVmg-JT9MXo' );
define( 'NONCE_KEY',        'Jb8!:RG95F]@qN64Amb)~mLT~H!J[u^^eSv.aqgh JjP%8G1>-!m*;JoNE-TQu~.' );
define( 'AUTH_SALT',        '!k_1Tv(yD&U^I5<z2W<dXibl0#%p]O,`64Bh4N~a?:Ai9@/KZ Y63.jG6r]?OIrG' );
define( 'SECURE_AUTH_SALT', 'O{TbJPG:PMV:>&p?(q3AXbPSCAeX86$@1{=P[1B,8/UB _?Q7]9@fW8`Za[VJsg8' );
define( 'LOGGED_IN_SALT',   'K1c5}JpBo=&$Xv*E@dFJ=^My,eCglNu8;FFT.$4trp7efua/7DTb^r ,aB,.R^=#' );
define( 'NONCE_SALT',       'u>6Ps31g$K-]n5r/joi:1/HO%0)$t4,|7br/ItPV)nX?e,p&C3~}2vpyrCbfJ,m+' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
