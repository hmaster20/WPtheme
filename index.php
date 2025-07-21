<?php get_header(); ?>

<main>
    <?php if (is_home() || is_front_page()) : ?>
        <div class="banner">
            <h1><?php _e('Выбор профессии', 'careerpro'); ?></h1>
            <p><?php _e('Поможем выбрать профессию и построить карьеру', 'careerpro'); ?></p>
            <a href="<?php echo esc_url(home_url('/courses')); ?>" class="button"><?php _e('Узнать больше', 'careerpro'); ?></a>
        </div>
    <?php endif; ?>

    <?php if (have_posts()) : ?>
        <div class="entry-header">
            <h1 class="entry-title"><?php bloginfo('name'); ?></h1>
        </div>
        
        <div class="posts-container">
            <?php while (have_posts()) : the_post(); ?>
                <article class="service-card">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="button"><?php _e('Читать далее', 'careerpro'); ?></a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        
        <?php the_posts_navigation(); ?>
    <?php else : ?>
        <p><?php _e('Контент не найден.', 'careerpro'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>