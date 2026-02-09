<?php
/**
 * The main template file
 *
 * @package Mongruas
 * @since 1.0.0
 */

// Si es un archivo (blog/anuncios), usar el template de archive
if (is_archive() || is_home()) {
    include(locate_template('archive.php'));
    return;
}
// Forzar recarga 2

get_header();
?>

<main id="primary" class="site-main">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
    else :
        ?>
        <p><?php esc_html_e('No content found', 'mongruas'); ?></p>
        <?php
    endif;
    ?>
</main>

<?php
get_footer();
