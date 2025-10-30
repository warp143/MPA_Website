<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Your blank canvas starts here -->
    <div id="blank-canvas" style="min-height: 100vh; background: white;">
        <!-- Add your custom HTML here -->
        <h1 style="text-align: center; padding-top: 50px; color: #333;">
            Blank Canvas - Start Building Your MPA Website
        </h1>
        
        <p style="text-align: center; margin-top: 20px; color: #666;">
            This is a completely blank page. Add your custom HTML, CSS, and JavaScript here.
        </p>
        
        <!-- Example: Add your MPA content here -->
        <div style="max-width: 800px; margin: 50px auto; padding: 20px;">
            <h2>Malaysia Proptech Association</h2>
            <p>Your content goes here...</p>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
