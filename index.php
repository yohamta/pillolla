<?php get_header(); ?>

<div class="container">
  <div class="contents">

    <?php if(is_category() || is_tag() || is_year() || is_month()): ?>
      <div class="contents-description">
        <?php if(is_category() || is_tag()): ?>
          <h2><?php single_cat_title() ?>の記事一覧</h2>
        <?php elseif(is_year()): ?>
          <h2><?php the_time("Y年") ?>の記事一覧</h2>
        <?php elseif(is_month()): ?>
          <h2><?php the_time("Y年m月") ?>の記事一覧</h2>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if(have_posts()): while(have_posts()): the_post(); ?>
      <article <?php post_class( 'kiji-list' ); ?>>
        <a href="<?php the_permalink(); ?>">

          <?php /* 画像を追加 */ ?>
          <?php if( has_post_thumbnail() && get_the_post_thumbnail_url() != "" ): ?>
            <?php the_post_thumbnail('medium'); ?>
          <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/img/no-image.jpg" alt="no-img"/>
          <?php endif; ?>

          <div class="text">

            <!--タイトル-->
            <h2><?php the_title(); ?></h2>

            <!--投稿日を表示-->
            <span class="kiji-date">
              <i class="fas fa-pencil-alt"></i>
              <time datetime="<?php echo get_the_date( 'Y-m-d' ); ?>">
                <?php echo get_the_date(); ?>
              </time>
            </span>

            <!--カテゴリ-->
            <?php if (!is_category()): ?>
              <?php if( has_category() ): ?>
              <span class="cat-data">
                <?php $postcat=get_the_category(); echo $postcat[0]->name; ?>
              </span>
              <?php endif; ?>
            <?php endif; ?>

            <!--抜粋-->
            <?php the_excerpt(); ?>

          </div>

        </a>
      </article>
    <?php endwhile; endif; ?><!--ループ終了-->

    <div class="pagination">
      <?php echo paginate_links( array(
        'type' => 'list',
        'mid_size' => '1',
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;'
        ) ); ?>
    </div>

  </div>

  <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
