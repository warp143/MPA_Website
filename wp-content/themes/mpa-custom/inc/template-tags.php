<?php
/**
 * Custom template tags for this theme
 *
 * @package MPA_Custom
 */

if (!function_exists('mpa_custom_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function mpa_custom_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        echo '<span class="posted-on">' . sprintf(
            /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'mpa-custom'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        ) . '</span>';
    }
endif;

if (!function_exists('mpa_custom_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function mpa_custom_posted_by() {
        echo '<span class="byline">' . sprintf(
            /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'mpa-custom'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        ) . '</span>';
    }
endif;

if (!function_exists('mpa_custom_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function mpa_custom_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'mpa-custom'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'mpa-custom') . '</span>', $categories_list);
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'mpa-custom'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'mpa-custom') . '</span>', $tags_list);
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mpa-custom'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'mpa-custom'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('mpa_custom_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function mpa_custom_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->
            <?php
        else :
            ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'post-thumbnail',
                    array(
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
                ?>
            </a>
            <?php
        endif;
    }
endif;

if (!function_exists('mpa_custom_pagination')) :
    /**
     * Display pagination
     */
    function mpa_custom_pagination() {
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => __('Previous', 'mpa-custom'),
            'next_text' => __('Next', 'mpa-custom'),
        ));
    }
endif;

if (!function_exists('mpa_custom_breadcrumbs')) :
    /**
     * Display breadcrumbs
     */
    function mpa_custom_breadcrumbs() {
        if (is_front_page()) {
            return;
        }

        echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('Breadcrumb', 'mpa-custom') . '">';
        echo '<ol>';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'mpa-custom') . '</a></li>';

        if (is_category() || is_single()) {
            if (is_single()) {
                $categories = get_the_category();
                if ($categories) {
                    echo '<li><a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a></li>';
                }
            } else {
                echo '<li>' . single_cat_title('', false) . '</li>';
            }
        } elseif (is_page()) {
            echo '<li>' . get_the_title() . '</li>';
        }

        echo '</ol>';
        echo '</nav>';
    }
endif;
