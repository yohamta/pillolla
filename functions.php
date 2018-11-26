<?php
//テーマのセットアップ
// titleタグをhead内に生成する
add_theme_support( 'title-tag' );
// HTML5でマークアップさせる
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
// Feedのリンクを自動で生成する
add_theme_support( 'automatic-feed-links' );
//アイキャッチ画像を使用する設定
add_theme_support( 'post-thumbnails' );

//カスタムメニュー
register_nav_menu( 'header-nav',  ' ヘッダーナビゲーション ' );
register_nav_menu( 'footer-nav',  ' フッターナビゲーション ' );
	
//サイドバーにウィジェット追加
function widgetarea_init() {
  register_sidebar(array(
      'name'=>'サイドバー',
      'id' => 'side-widget',
      'before_widget'=>'<div id="%1$s" class="%2$s sidebar-wrapper">',
      'after_widget'=>'</div>',
      'before_title' => '<h4 class="sidebar-title">',
      'after_title' => '</h4>'
    ));
}
add_action( 'widgets_init', 'widgetarea_init' );

// CSS and Scripts
function add_stylesheets_and_scripts() {
  wp_enqueue_style( 'pillolla-theme-css', get_stylesheet_uri() );
  wp_enqueue_script( 'pillolla-navbutton-script', get_template_directory_uri() .'/js/navbutton.js', array('jquery') );
}
add_action( 'wp_enqueue_scripts', 'add_stylesheets_and_scripts' );


