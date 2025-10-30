<?php get_header(); ?>
        <!-- Header Placeholder -->
    <div class="header-placeholder"></div>

<!-- Hero Section -->
    <section class="page-hero">
        <div class="container">
            <div class="hero-content">
                <h1><?php the_title(); ?></h1>
                <p><?php 
                    $hero_description = get_post_meta(get_the_ID(), '_hero_description', true);
                    echo $hero_description ?: 'Honoring the contributions of our past committee members who helped build MPA\'s foundation';
                ?></p>
            </div>
            <div class="hero-image">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', array('alt' => get_the_title() . ' Hero')); ?>
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/hero-image.jpg" alt="<?php echo esc_attr(get_the_title()); ?>">
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Year Navigation -->
    <section class="year-navigation">
        <div class="container">
            <div class="year-tabs">
                <button class="year-tab active" data-year="2021-2023">2021-2023</button>
                <button class="year-tab" data-year="2023-2025">2023-2025</button>
            </div>
        </div>
    </section>

    <!-- Previous Committee Members -->
    <section class="committee">
        <div class="container">
            <div class="section-header">
                <h2>Previous Committee Members</h2>
                <p>We acknowledge and thank these dedicated individuals who served on our committee in previous years</p>
            </div>
            
            <!-- 2021-2023 Committee -->
            <div class="committee-year active" id="2021-2023">
                <h3>Committee Members (2021-2023)</h3>
                <div class="committee-grid">
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/daniele-gambero.webp" alt="Dr. Daniele Gambero">
                        <h3>Dr. Daniele Gambero</h3>
                        <p class="position">President</p>
                        <div class="position-description">
                            <p>• Leads the overall strategic direction of MPA</p>
                            <p>• Represents the association at national and international events</p>
                            <p>• Oversees all committee activities and member engagement</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://propenomy.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:daniele.g@reigroup.com.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/propenomist/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/jason-ding.webp" alt="Jason Ding">
                        <h3>Jason Ding</h3>
                        <p class="position">Deputy President</p>
                        <div class="position-description">
                            <p>• Supports the President in strategic leadership</p>
                            <p>• Manages operational activities and committee coordination</p>
                            <p>• Acts as President in their absence</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://mhub.my/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:info@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/jasondjs/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/kw-wong.png" alt="Wong Keh Wei">
                        <h3>Wong Keh Wei</h3>
                        <p class="position">Secretary</p>
                        <div class="position-description">
                            <p>• Manages official correspondence and documentation</p>
                            <p>• Maintains meeting records and association minutes</p>
                            <p>• Coordinates communication between committee members</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.rentlab.com.my" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:info@rentlab.com.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/wongkw33" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/jacky-chuah.webp" alt="Jacky Chuah">
                        <h3>Jacky Chuah</h3>
                        <p class="position">Assistant Secretary</p>
                        <div class="position-description">
                            <p>• Supports the Secretary in administrative tasks</p>
                            <p>• Assists with meeting coordination and documentation</p>
                            <p>• Helps maintain member records and communications</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.rekatone.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:info@rekatone.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/liz-ang.webp" alt="Liz Ang Gaik See">
                        <h3>Liz Ang Gaik See</h3>
                        <p class="position">Treasurer</p>
                        <div class="position-description">
                            <p>• Manages financial planning and budgeting</p>
                            <p>• Oversees membership fees and financial reporting</p>
                            <p>• Ensures financial compliance and transparency</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.imortgage2u.com/promo/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:liz.ang@techapp.com.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/liz-ang-140506117/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/angela-kew.png" alt="Angela Kew Chui Teen">
                        <h3>Angela Kew Chui Teen</h3>
                        <p class="position">VP Membership</p>
                        <div class="position-description">
                            <p>• Develops membership growth strategies</p>
                            <p>• Manages member onboarding and retention programs</p>
                            <p>• Coordinates member benefits and engagement activities</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.living.my" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:support@living.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/angela-kew/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/michele-tan.webp" alt="Michele Tan">
                        <h3>Michele Tan</h3>
                        <p class="position">Membership Committee</p>
                        <div class="position-description">
                            <p>• Supports membership recruitment and retention</p>
                            <p>• Assists with member communications and support</p>
                            <p>• Helps organize member-focused events and activities</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.servedeck.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:michele.tan@servedeck.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/servedeckmicheletan" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/naga-krishnan.webp" alt="Naga R Krishnan">
                        <h3>Naga R Krishnan</h3>
                        <p class="position">VP Events</p>
                        <div class="position-description">
                            <p>• Plans and executes industry conferences and workshops</p>
                            <p>• Coordinates networking events and meetups</p>
                            <p>• Manages event partnerships and sponsorships</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://novoreperio.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:naga.krishnan@novoreperio.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/nagakrishnan/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/aiden-teh.webp" alt="Aiden Teh">
                        <h3>Aiden Teh</h3>
                        <p class="position">VP Marketing & PR</p>
                        <div class="position-description">
                            <p>• Develops marketing strategies and brand positioning</p>
                            <p>• Manages public relations and media communications</p>
                            <p>• Coordinates digital marketing and social media presence</p>
                        </div>
                        <div class="member-contact">
                            <a href="http://www.i-neighbour.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:aiden@i-neighbour.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/teh-ke-huan-aiden-a6702858/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/benny-wee.webp" alt="Benny Wee">
                        <h3>Benny Wee</h3>
                        <p class="position">Marketing Deputy</p>
                        <div class="position-description">
                            <p>• Supports marketing campaigns and initiatives</p>
                            <p>• Assists with content creation and distribution</p>
                            <p>• Helps manage marketing partnerships and collaborations</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.vendfun.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:bennywee@gmail.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/benny-wee-b2010513" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/azlan-zainuddin.webp" alt="Azlan Bin Zainuddin">
                        <h3>Azlan Bin Zainuddin</h3>
                        <p class="position">VP Innovation & Technology</p>
                        <div class="position-description">
                            <p>• Drives technology innovation and digital transformation</p>
                            <p>• Oversees tech partnerships and industry collaborations</p>
                            <p>• Manages innovation programs and technology initiatives</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.aivot.my" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:azlan@aivot.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/azlan-zainuddin" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/christina-leong.webp" alt="Christina Leong">
                        <h3>Christina Leong</h3>
                        <p class="position">VP Academic Partnerships</p>
                        <div class="position-description">
                            <p>• Develops partnerships with universities and institutions</p>
                            <p>• Coordinates research collaborations and academic programs</p>
                            <p>• Manages educational initiatives and knowledge sharing</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.prosales.tech" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:christina@infradigital.com.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/christina-leong-prosales/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/tharma-gannasin.png" alt="Tharma Gannasin">
                        <h3>Tharma Gannasin</h3>
                        <p class="position">Committee Member</p>
                        <div class="position-description">
                            <p>• Supports various committee initiatives and projects</p>
                            <p>• Contributes to strategic planning and decision making</p>
                            <p>• Assists with special projects and ad-hoc committees</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://bwave.co/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:info@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/tharma/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>

            <!-- 2023-2025 Committee -->
            <div class="committee-year" id="2023-2025">
                <h3>Committee Members (2023-2025)</h3>
                <div class="committee-grid">
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/daniele-gambero.webp" alt="Dr. Daniele Gambero">
                        <h3>Dr. Daniele Gambero</h3>
                        <p class="position">President</p>
                        <div class="position-description">
                            <p>• Leads the overall strategic direction of MPA</p>
                            <p>• Represents the association at national and international events</p>
                            <p>• Oversees all committee activities and member engagement</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://propenomy.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:daniele.g@reigroup.com.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/propenomist/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/jason-ding.webp" alt="Jason Ding">
                        <h3>Jason Ding</h3>
                        <p class="position">Deputy President</p>
                        <div class="position-description">
                            <p>• Supports the President in strategic leadership</p>
                            <p>• Manages operational activities and committee coordination</p>
                            <p>• Acts as President in their absence</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://mhub.my/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:info@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/jasondjs/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/kw-wong.png" alt="Wong Keh Wei">
                        <h3>Wong Keh Wei</h3>
                        <p class="position">Secretary</p>
                        <div class="position-description">
                            <p>• Manages official correspondence and documentation</p>
                            <p>• Maintains meeting records and association minutes</p>
                            <p>• Coordinates communication between committee members</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.rentlab.com.my" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:info@rentlab.com.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/wongkw33" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/jacky-chuah.webp" alt="Jacky Chuah">
                        <h3>Jacky Chuah</h3>
                        <p class="position">Assistant Secretary</p>
                        <div class="position-description">
                            <p>• Supports the Secretary in administrative tasks</p>
                            <p>• Assists with meeting coordination and documentation</p>
                            <p>• Helps maintain member records and communications</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.rekatone.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:info@rekatone.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/liz-ang.webp" alt="Liz Ang Gaik See">
                        <h3>Liz Ang Gaik See</h3>
                        <p class="position">Treasurer</p>
                        <div class="position-description">
                            <p>• Manages financial planning and budgeting</p>
                            <p>• Oversees membership fees and financial reporting</p>
                            <p>• Ensures financial compliance and transparency</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.imortgage2u.com/promo/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:liz.ang@techapp.com.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/liz-ang-140506117/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/angela-kew.png" alt="Angela Kew Chui Teen">
                        <h3>Angela Kew Chui Teen</h3>
                        <p class="position">VP Membership</p>
                        <div class="position-description">
                            <p>• Develops membership growth strategies</p>
                            <p>• Manages member onboarding and retention programs</p>
                            <p>• Coordinates member benefits and engagement activities</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.living.my" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:support@living.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/angela-kew/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/michele-tan.webp" alt="Michele Tan">
                        <h3>Michele Tan</h3>
                        <p class="position">Membership Committee</p>
                        <div class="position-description">
                            <p>• Supports membership recruitment and retention</p>
                            <p>• Assists with member communications and support</p>
                            <p>• Helps organize member-focused events and activities</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.servedeck.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:michele.tan@servedeck.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/servedeckmicheletan" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/naga-krishnan.webp" alt="Naga R Krishnan">
                        <h3>Naga R Krishnan</h3>
                        <p class="position">VP Events</p>
                        <div class="position-description">
                            <p>• Plans and executes industry conferences and workshops</p>
                            <p>• Coordinates networking events and meetups</p>
                            <p>• Manages event partnerships and sponsorships</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://novoreperio.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:naga.krishnan@novoreperio.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/nagakrishnan/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/aiden-teh.webp" alt="Aiden Teh">
                        <h3>Aiden Teh</h3>
                        <p class="position">VP Marketing & PR</p>
                        <div class="position-description">
                            <p>• Develops marketing strategies and brand positioning</p>
                            <p>• Manages public relations and media communications</p>
                            <p>• Coordinates digital marketing and social media presence</p>
                        </div>
                        <div class="member-contact">
                            <a href="http://www.i-neighbour.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:aiden@i-neighbour.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/teh-ke-huan-aiden-a6702858/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/benny-wee.webp" alt="Benny Wee">
                        <h3>Benny Wee</h3>
                        <p class="position">Marketing Deputy</p>
                        <div class="position-description">
                            <p>• Supports marketing campaigns and initiatives</p>
                            <p>• Assists with content creation and distribution</p>
                            <p>• Helps manage marketing partnerships and collaborations</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.vendfun.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:bennywee@gmail.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/benny-wee-b2010513" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/azlan-zainuddin.webp" alt="Azlan Bin Zainuddin">
                        <h3>Azlan Bin Zainuddin</h3>
                        <p class="position">VP Innovation & Technology</p>
                        <div class="position-description">
                            <p>• Drives technology innovation and digital transformation</p>
                            <p>• Oversees tech partnerships and industry collaborations</p>
                            <p>• Manages innovation programs and technology initiatives</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.aivot.my" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:azlan@aivot.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/azlan-zainuddin" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/christina-leong.webp" alt="Christina Leong">
                        <h3>Christina Leong</h3>
                        <p class="position">VP Academic Partnerships</p>
                        <div class="position-description">
                            <p>• Develops partnerships with universities and institutions</p>
                            <p>• Coordinates research collaborations and academic programs</p>
                            <p>• Manages educational initiatives and knowledge sharing</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://www.prosales.tech" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:christina@infradigital.com.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/christina-leong-prosales/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="committee-member">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/old-members/tharma-gannasin.png" alt="Tharma Gannasin">
                        <h3>Tharma Gannasin</h3>
                        <p class="position">Committee Member</p>
                        <div class="position-description">
                            <p>• Supports various committee initiatives and projects</p>
                            <p>• Contributes to strategic planning and decision making</p>
                            <p>• Assists with special projects and ad-hoc committees</p>
                        </div>
                        <div class="member-contact">
                            <a href="https://bwave.co/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                            <a href="mailto:info@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                            <a href="https://www.linkedin.com/in/tharma/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>

            <div class="text-center">
                <a href="<?php echo esc_url(home_url('/association/')); ?>" class="btn-primary">View Current Committee</a>
            </div>
        </div>
    </section>

        <!-- Footer Placeholder -->
    <div class="footer-placeholder"></div>

    <script src="scripts/header-loader.js"></script>
    <script src="scripts/footer-loader.js"></script>
<?php get_footer(); ?>
</html>
