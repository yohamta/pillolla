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

// 省略文字数
function my_excerpt_length($length) {
  return 200;
}
add_filter('excerpt_length', 'my_excerpt_length');

//概要（抜粋）の省略文字
function my_excerpt_more($more) {
  return '...';
}
add_filter('excerpt_more', 'my_excerpt_more');

// CSS and Scripts
function add_stylesheets_and_scripts() {
  wp_enqueue_style( 'pillolla-theme-css', get_stylesheet_uri() );
  wp_enqueue_script( 'pillolla-navbutton-script', get_template_directory_uri() .'/js/navbutton.js', array('jquery') );
}
add_action( 'wp_enqueue_scripts', 'add_stylesheets_and_scripts' );

// Settings
function theme_customize_register($wp_customize) {
  /* セクション追加 */
  $wp_customize->add_section('original_settings', array(
    'title' =>'独自設定',
    'priority' => 100,
  ));
  // favicon url
  $wp_customize->add_setting('orig_options[favicon_url]', array(
    'type' => 'option',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('original_favicon_url_text', array(
    'settings' => 'orig_options[favicon_url]',
    'label' => 'Favicon URL',
    'section' => 'original_settings',
    'type' => 'text',
  ));

  // no_image url
  $wp_customize->add_setting('orig_options[no_image_url]', array(
    'type' => 'option',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('original_no_image_url_text', array(
    'settings' => 'orig_options[no_image_url]',
    'label' => 'No Image Image URL',
    'section' => 'original_settings',
    'type' => 'text',
  ));
}
add_action( 'customize_register', 'theme_customize_register' );

function get_original_setting($option) {
  $opt = get_option('orig_options');
  if (isset($opt[$option])) {
    return $opt[$option];
  }
  return null;
}

// --------------------
// ShortCodes

// Related Articles
function sc_related($atts) {
  extract(shortcode_atts(array(
      'id' => 0,
  ), $atts));

  $post = get_post($id);
  $title = esc_html(get_the_title($id));
  $img_tag = "";
  if( has_post_thumbnail() && get_the_post_thumbnail_url() != "" ) {
    $img_tag .= get_the_post_thumbnail($id, 'medium');
  } else {
    $img_tag .= '<img src="' . get_template_directory_uri() . '/img/no-image.jpg" alt="no-img" />';
  }
  $out = '<div class="blog-card">';
  $out .= '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( $post->post_title ) . '">';
  $out .= '<div class="blog-card-thumbnail">' . $img_tag . '</div>';
  $out .= '<div class="blog-card-content">';
  $out .= '</div>';
  $out .= '<div class="blog-card-title">'. $title .' </div>';
  $out .= '</a></div>';
  return $out;
}
add_shortcode('related', 'sc_related');

