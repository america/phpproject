<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'wordpress');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'takashi');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'tuio1049');

/** MySQL のホスト名 */
define('DB_HOST', 'localhost');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'bt|yK+`i7!B5,|qg{kXusY^c!z2FOS6,ZAz-WKQ$,sLHY{Jow;-(}!G)y;-4wu^u');
define('SECURE_AUTH_KEY',  'LEONdrk.utl3Mx!v9L$mW=f9r>zo+p*#UOYSD4-JFpk&&de:(:zHC9t2H ZxQDC1');
define('LOGGED_IN_KEY',    '44_E$}_0m6;y0J +h_`ZpeQ?no.K<M1%|t8IIJ^coE(]i0PXVT>u*:G+9wSKlQ+r');
define('NONCE_KEY',        '%aA+F:B>+6m~|(kBO|E]u4rvxz+}I|j}RBI|nAXGW&jzytf5~D- [/P#(1r_0PED');
define('AUTH_SALT',        '0$YJ*fUt2]9xxwBQN=[;f|0iw~,~d$Nh+s`R;zX=[h(RqWLY1.go}#9MOKbkoJ}6');
define('SECURE_AUTH_SALT', 'XY}T:aL/y<3=FQc:mjHsapcGgjm=-$edl$}<*z6FJ:_~!:]kTKZ|4Uo5E@0c,Hbh');
define('LOGGED_IN_SALT',   'u([%IVZ=P,N&FGK-:Ei`,^?-GZJz!y}>?uNsR;|/H|)0^u8uA`8s-90zB1wO}|%Y');
define('NONCE_SALT',       'wiqa +gqOV6SpD0[}$|V@J48Uu00|wQxgVJCpcGx5(#-!e2s5R|D.?XXaG#;i`m5');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

define('WP_SITEURL', 'http://america66.work/blog');

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

define('FS_METHOD', 'direct');

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
