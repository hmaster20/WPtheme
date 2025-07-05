<?php
/**
 * Template Name: Single Post Template
 * Description: Шаблон для отображения отдельных записей в теме CareerPro
 */

get_header(); ?>

<main>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="service-card">
            <div class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </div>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            <div class="post-meta">
                <p><?php _e('Опубликовано', 'careerpro'); ?>: <?php the_date(); ?> | <?php _e('Автор', 'careerpro'); ?>: <?php the_author(); ?></p>
            </div>
        </article>
    <?php endwhile; ?>
    <?php else : ?>
        <p><?php _e('Контент не найден.', 'careerpro'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>