<?php
/**
 * Template Name: Page Template
 * Description: Шаблон для отображения страниц в теме CareerPro
 */

get_header(); ?>

<main>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </div>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
    <?php else : ?>
        <p><?php _e('Контент не найден.', 'careerpro'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>