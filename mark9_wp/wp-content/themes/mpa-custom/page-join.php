<?php get_header(); ?>

<style>
.page-hero {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    padding: 60px 0;
    margin-bottom: 0;
}

.join-form-section {
    background: #ffffff;
    padding: 0;
    margin: 0;
}

.join-form-section .container {
    max-width: 1200px;
    padding: 0;
}

.form-container {
    background: white;
    border-radius: 0;
    box-shadow: none;
}
</style>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content" style="text-align: center; color: white;">
            <h1 style="color: white; font-size: 3rem; margin-bottom: 20px;"><?php the_title(); ?></h1>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.9);">
                <?php 
                $hero_description = get_post_meta(get_the_ID(), '_hero_description', true);
                echo $hero_description ?: 'Complete your membership application to become part of Malaysia\'s leading PropTech community';
                ?>
            </p>
        </div>
    </div>
</section>

<!-- Embedded Registration Form via Proxy -->
<section class="join-form-section">
    <div class="container">
        <div class="form-container">
            <iframe 
                src="<?php echo home_url('/join-proxy.php'); ?>" 
                style="width: 100%; min-height: 2500px; border: none; display: block;"
                frameborder="0"
                scrolling="no"
                id="registrationFrame"
                onload="
                    var iframe = this;
                    try {
                        iframe.style.height = (iframe.contentWindow.document.documentElement.scrollHeight + 100) + 'px';
                    } catch(e) {
                        // Fallback if cross-origin
                        iframe.style.height = '2500px';
                    }
                ">
            </iframe>
        </div>
    </div>
</section>

<?php get_footer(); ?>
