<?php
/**
 * Template part for displaying the social proof section
 *
 * @package Mongruas
 * @since 1.0.0
 */

// Get testimonials
$testimonials_args = array(
    'post_type' => 'testimonial',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC'
);
$testimonials_query = new WP_Query($testimonials_args);

// Get statistics
$statistics = get_field('statistics', 'option');
$certifications = get_field('certifications', 'option');
?>

<section id="social-proof" class="social-proof-section section">
    <div class="container">
        <!-- Statistics Grid -->
        <div class="statistics-grid">
            <?php if ($statistics) : ?>
                <?php foreach ($statistics as $stat) : ?>
                    <div class="stat-item">
                        <div class="stat-number" data-target="<?php echo esc_attr($stat['stat_number']); ?>">
                            <?php echo esc_html($stat['stat_number']); ?>
                        </div>
                        <div class="stat-label"><?php echo esc_html($stat['stat_label']); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Default statistics -->
                <div class="stat-item">
                    <div class="stat-number" data-target="20">20</div>
                    <div class="stat-label">Años de Experiencia</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-target="2000">2000+</div>
                    <div class="stat-label">Cursos Disponibles</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-target="200">200+</div>
                    <div class="stat-label">Empresas Gestionadas (PRL)</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-target="3">3</div>
                    <div class="stat-label">Certificados Acreditados</div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Testimonials Carousel -->
        <?php if ($testimonials_query->have_posts()) : ?>
            <div class="testimonials-section">
                <h2 class="section-title text-center"><?php esc_html_e('Lo Que Dicen Nuestros Alumnos', 'mongruas'); ?></h2>
                
                <div class="testimonials-carousel">
                    <div class="testimonials-wrapper">
                        <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post(); ?>
                            <?php
                            $author_name = get_field('testimonial_author_name');
                            $author_role = get_field('testimonial_author_role');
                            $author_photo = get_field('testimonial_author_photo');
                            $rating = get_field('testimonial_rating');
                            ?>
                            <div class="testimonial-item">
                                <div class="testimonial-content">
                                    <div class="testimonial-text">
                                        <?php the_content(); ?>
                                    </div>
                                    
                                    <?php if ($rating) : ?>
                                        <div class="testimonial-rating">
                                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                                <span class="star <?php echo $i < $rating ? 'filled' : ''; ?>">★</span>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="testimonial-author">
                                    <?php if ($author_photo) : ?>
                                        <img src="<?php echo esc_url($author_photo['url']); ?>" 
                                             alt="<?php echo esc_attr($author_name); ?>"
                                             class="author-photo">
                                    <?php endif; ?>
                                    <div class="author-info">
                                        <div class="author-name"><?php echo esc_html($author_name); ?></div>
                                        <?php if ($author_role) : ?>
                                            <div class="author-role"><?php echo esc_html($author_role); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                    
                    <button class="carousel-nav prev" aria-label="<?php esc_attr_e('Previous', 'mongruas'); ?>">‹</button>
                    <button class="carousel-nav next" aria-label="<?php esc_attr_e('Next', 'mongruas'); ?>">›</button>
                    
                    <div class="carousel-dots"></div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Certifications -->
        <?php if ($certifications) : ?>
            <div class="certifications-section">
                <h3 class="text-center"><?php esc_html_e('Acreditaciones Oficiales', 'mongruas'); ?></h3>
                <div class="certifications-grid">
                    <?php foreach ($certifications as $cert) : ?>
                        <div class="certification-item">
                            <?php if (!empty($cert['certification_logo'])) : ?>
                                <img src="<?php echo esc_url($cert['certification_logo']['url']); ?>" 
                                     alt="<?php echo esc_attr($cert['certification_name']); ?>"
                                     loading="lazy">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
