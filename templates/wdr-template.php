<?php
/*
Template Name: Cennik
*/
?>

<head>
    <?php get_header(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>


    <main id="content" <?php post_class( 'site-main' ); ?>>
        <?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
            <header class="page-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header>
        <?php endif; ?>

        <div class="page-content">
            <?php the_content(); ?>

            <div id="app">

            </div>
            <div class="post-tags">
                <?php the_tags( '<span class="tag-links">' . esc_html__( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
            </div>
            <?php wp_link_pages(); ?>
        </div>

        <?php comments_template(); ?>
    </main>

    <script type="module" src="/wp-content/plugins/wdr-gsheets-importer/static/javascripts/wdr-app/dist/plugin.js"></script>
    <link rel="stylesheet" href="/wp-content/plugins/wdr-gsheets-importer/static/javascripts/wdr-app/dist/plugin.css"/>

    <?php get_footer(); ?>
</body>
