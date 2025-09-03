<?php get_header(); ?>

<!-- Set custom page title -->
<script>
document.title = 'Association |';
</script>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1>Association</h1>
            <p><?php 
                $hero_description = get_post_meta(get_the_ID(), '_hero_description', true);
                echo $hero_description ?: 'Leading The Digital Transformation of the Property Industry in Malaysia';
            ?></p>
        </div>
        <div class="hero-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('alt' => get_the_title() . ' Hero')); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/association-hero.jpg" alt="<?php echo esc_attr(get_the_title()); ?> Hero">
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Editable Content Section -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php if (get_the_content()) : ?>
    <section class="page-content">
        <div class="container">
            <div class="content-area">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
<?php endwhile; endif; ?>

<!-- President's Message -->
<section class="president-message">
    <div class="container">
        <div class="message-content">
            <div class="president-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/wp-content_uploads_2024_07_Daniele-Gambero.webp" alt="Dr. Daniele Gambero - MPA President">
            </div>
            <div class="message-text">
                <h2>Word From The President</h2>
                <h3>Dr. Daniele Gambero</h3>
                <p>Welcome to the Malaysia PropTech Association (MPA), a dynamic hub where innovation meets purpose, and where Malaysia's built environment is being reimagined through technology.</p>
                <p>Since our inception, MPA has united the country's most forward-thinking startups in property and construction tech. Together, we are driving digital transformation, boosting collaboration, and amplifying the voice of Malaysia's proptech ecosystem across borders.</p>
                <div class="goals">
                    <h4>Our mission is clear:</h4>
                    <ul>
                        <li>To position MPA as the recognized industry association for proptech in Malaysia and emerging markets</li>
                        <li>To connect our members with global investors, venture capitalists, and strategic partners</li>
                        <li>To build a thriving ecosystem where Malaysian startups scale globally and lead regional innovation</li>
                        <li>And yes, to see one of our members rise to unicorn status, proving that Malaysia is helping to shape the future of the built environment!</li>
                    </ul>
                </div>
                <p>Whether you're a founder, investor, ecosystem stakeholder, policymaker, or curious visitor, we invite you to join us in this journey.</p>
                <p><strong>The future of property is digital, inclusive, and collaborative and MPA is proud to be leading the way!</strong></p>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="mission-vision">
    <div class="container">
        <div class="mission-content">
            <div class="mission-text">
                <h2>Mission & Vision</h2>
                <h3>People</h3>
                <p>People shall be the main focus of our association and all our members. When addressing pain points and problem statements from the property industry stakeholders people should always be the main beneficiary of our members' digital solutions.</p>
                <p>We respect and are committed in helping the growth of everyone notwithstanding disabilities, sex, race or religion and there shall never be a compromise on this. In our association woman will always be given the same opportunities as man and the association is strongly committed towards the achievement of Goal: 5 of SDG-2030 "Gender Equality".</p>
                
                <h3>MPA Mandates</h3>
                <div class="mandates-grid">
                    <div class="mandate-card">
                        <i class="fas fa-shield-alt"></i>
                        <h4>Trust</h4>
                        <p>Trust, which is one of the pillars of a successful digital transformation, should not be traded, ever.</p>
                    </div>
                    <div class="mandate-card">
                        <i class="fas fa-balance-scale"></i>
                        <h4>Truth</h4>
                        <p>To promote truth, in both our internal and external communication truth shall always prevail and be the engine of the trust building process.</p>
                    </div>
                    <div class="mandate-card">
                        <i class="fas fa-user-graduate"></i>
                        <h4>Talent</h4>
                        <p>To nurture talents leveraging on a preferential relationship with local and international universities and attract them towards our association to contribute to their and our members wellbeing.</p>
                    </div>
                    <div class="mandate-card">
                        <i class="fas fa-microchip"></i>
                        <h4>Technology</h4>
                        <p>To nurture and stimulate the research for new innovative technologies to help the built environment ecosystem to become more resilient, user friendly and solution providing to all parties.</p>
                    </div>
                </div>
                
                <a href="#" class="btn-primary">Read Full Mission & Vision</a>
            </div>
            <div class="mission-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/association-mission.jpg" alt="MPA Mission & Vision">
            </div>
        </div>
    </div>
</section>

<!-- Mission, Vision & SDG-2030 Section -->
<section class="mission-vision-sdg">
    <div class="container">
        <div class="section-header">
            <h2>Mission, Vision & SDG-2030 Commitment</h2>
        </div>
        
        <div class="mission-vision-content">
            <div class="mission-vision-text">
                <div class="mission-section">
                    <h3>Mission</h3>
                    <p>To support the growth of a sustainable PropTech ecosystem by creating a meaningful impact on the Malaysian built environment, easing a fully digital and highly inclusive transformation adoption focused on people, and contributing to the achievement of SDG-2030.</p>
                </div>
                
                <div class="vision-section">
                    <h3>Vision</h3>
                    <p>To be the inspiring force for all stakeholders in the built environment towards a consistent, responsible and sustainable use of technology and to contribute to the wellbeing of all our members.</p>
                </div>
                
                <div class="people-section">
                    <h3>People</h3>
                    <p>People is the main focus of our association and all our members. When addressing pain points and problem statements from the built environment stakeholders people should always be the main beneficiary of our members' digital solutions.</p>
                    <p>We respect and are committed in helping the growth of everyone notwithstanding disabilities, sex, race or religion and there shall never be a compromise on this. In our association women will always be given the same opportunities as men and the association is strongly committed towards the achievement of Goal: 5 of SDG-2030 "Gender Equality".</p>
                </div>
            </div>
        </div>
        
        <div class="sdg-commitment">
            <div class="sdg-commitment-content">
                <h3>MPA's Commitment to Sustainability and SDG-2030</h3>
                <div class="sdg-commitment-text">
                    <p>At the Malaysia PropTech Association (MPA), we believe that the future of the built environment must be sustainable, inclusive, and purpose driven.</p>
                    <p>Our commitment to the United Nations Sustainable Development Goals (SDG-2030) is strong and consistent. While we support the spirit of all 17 goals, our focus and actions are mostly aligned with the six SDGs that shape the future of the built environment and construction.</p>
                </div>
            </div>
            
            <div class="sdg-image-container">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/un-sdg-goals.jpg" alt="UN Sustainable Development Goals - All 17 Goals" class="sdg-image" onerror="this.style.display='none'">
                <div class="sdg-fallback" style="display: none; padding: 2rem; text-align: center; background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius: 12px; color: white;">
                    <h4>🌍 UN Sustainable Development Goals</h4>
                    <p>17 Goals for a Better World by 2030</p>
                </div>
            </div>
            
            <div class="sdg-tabs">
                <div class="sdg-tab active" data-sdg="5">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/E-WEB-Goal-05.png" alt="SDG 5 - Gender Equality" class="sdg-goal-image">
                    <div class="sdg-title">Gender Equality</div>
                </div>
                <div class="sdg-tab" data-sdg="7">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/E-WEB-Goal-07.png" alt="SDG 7 - Affordable and Clean Energy" class="sdg-goal-image">
                    <div class="sdg-title">Affordable and Clean Energy</div>
                </div>
                <div class="sdg-tab" data-sdg="9">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/E-WEB-Goal-09.png" alt="SDG 9 - Industry, Innovation and Infrastructure" class="sdg-goal-image">
                    <div class="sdg-title">Industry, Innovation and Infrastructure</div>
                </div>
                <div class="sdg-tab" data-sdg="10">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/E-WEB-Goal-10.png" alt="SDG 10 - Reduced Inequalities" class="sdg-goal-image">
                    <div class="sdg-title">Reduced Inequalities</div>
                </div>
                <div class="sdg-tab" data-sdg="11">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/E-WEB-Goal-11.png" alt="SDG 11 - Sustainable Cities and Communities" class="sdg-goal-image">
                    <div class="sdg-title">Sustainable Cities and Communities</div>
                </div>
                <div class="sdg-tab" data-sdg="17">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/E-WEB-Goal-17.png" alt="SDG 17 - Partnerships for the Goals" class="sdg-goal-image">
                    <div class="sdg-title">Partnerships for the Goals</div>
                </div>
            </div>
            
            <div class="sdg-content">
                <div class="sdg-description active" data-sdg="5">
                    <h4>SDG 5 – Gender Equality</h4>
                    <p>Championing equal opportunities in proptech, from leadership to innovation</p>
                </div>
                <div class="sdg-description" data-sdg="7">
                    <h4>SDG 7 – Affordable and Clean Energy</h4>
                    <p>Supporting energy-efficient solutions and smart building technologies</p>
                </div>
                <div class="sdg-description" data-sdg="9">
                    <h4>SDG 9 – Industry, Innovation and Infrastructure</h4>
                    <p>Accelerating digitalisation and ecosystem transformation</p>
                </div>
                <div class="sdg-description" data-sdg="10">
                    <h4>SDG 10 – Reduced Inequalities</h4>
                    <p>Empowering startups and underserved communities through access and inclusion</p>
                </div>
                <div class="sdg-description" data-sdg="11">
                    <h4>SDG 11 – Sustainable Cities and Communities</h4>
                    <p>Driving smart urban development and ESG-aligned practice</p>
                </div>
                <div class="sdg-description" data-sdg="17">
                    <h4>SDG 17 – Partnerships for the Goals</h4>
                    <p>Building bridges across sectors, borders, and industries to scale impact</p>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- SDG Conclusion Section -->
<section class="sdg-conclusion-section">
    <div class="container">
        <div class="sdg-conclusion">
            <p><strong>Through advocacy, education, and collaboration, MPA is shaping a responsible growth of the built environment!</strong></p>
        </div>
    </div>
</section>

<!-- MPA Pillars -->
<section class="mpa-pillars">
    <div class="container" id="mpa-pillars-component">
        <!-- Component will be loaded here -->
    </div>
</section>

<!-- Committee -->
<section class="committee">
    <div class="container">
        <div class="section-header">
            <h2>Our Committee</h2>
            <p>Meet the leadership team driving Malaysia's PropTech transformation (2025-2026 Term)</p>
        </div>
        <div class="committee-grid">
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/wp-content_uploads_2024_07_Daniele-Gambero.webp" alt="Dr. Daniele Gambero">
                <h3>Dr. Daniele Gambero</h3>
                <p class="position">President</p>
                <div class="position-description">
                    <p>• Provide strategic leadership to achieve association goals and OKRs</p>
                    <p>• Represent the association in national and international forums</p>
                    <p>• Drive policy advocacy and industry influence</p>
                    <p>• Ensure alignment of all committees towards mission and revenue targets</p>
                </div>
                <div class="member-contact">
                    <a href="https://propenomy.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:presidency@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.linkedin.com/in/propenomist/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/wp-content_uploads_2021_01_jason-ding.webp" alt="Jason Ding">
                <h3>Jason Ding</h3>
                <p class="position">Deputy President</p>
                <div class="position-description">
                    <p>• Support President in strategic planning and execution</p>
                    <p>• Oversee cross-committee collaboration and ensure timely deliverables</p>
                    <p>• Lead special projects (e.g., high-level partnerships, cross-border initiatives)</p>
                </div>
                <div class="member-contact">
                    <a href="https://mhub.my/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:info@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.linkedin.com/in/jasondjs/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/wp-content_uploads_2021_08_KW_Wong.png" alt="Wong Keh Wei">
                <h3>Wong Keh Wei</h3>
                <p class="position">Secretary General</p>
                <div class="position-description">
                    <p>• Oversee governance, compliance, and documentation</p>
                    <p>• Ensure smooth communication between committees and members</p>
                    <p>• Maintain updated association policies and procedures</p>
                </div>
                <div class="member-contact">
                    <a href="https://www.rentlab.com.my" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:secretariat@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.linkedin.com/in/wongkw33" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/wp-content_uploads_2021_01_Liz-Ang.webp" alt="Liz Ang Gaik See">
                <h3>Liz Ang Gaik See</h3>
                <p class="position">Treasurer</p>
                <div class="position-description">
                    <p>• Manage financial planning, budgeting, and reporting</p>
                    <p>• Ensure proper allocation of event and operational funds</p>
                    <p>• Drive financial sustainability and transparency</p>
                </div>
                <div class="member-contact">
                    <a href="https://www.imortgage2u.com/promo/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:liz.ang@techapp.com.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.linkedin.com/in/liz-ang-140506117/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/wp-content_uploads_2021_08_Angela_Kew.png" alt="Angela Kew Chui Teen">
                <h3>Angela Kew Chui Teen</h3>
                <p class="position">Membership</p>
                <div class="position-description">
                    <p>• Recruit and retain normal, associate, and corporate members</p>
                    <p>• Build membership value proposition</p>
                    <p>• Manage onboarding, renewals, and engagement</p>
                </div>
                <div class="member-contact">
                    <a href="https://www.living.my" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:membership@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.linkedin.com/in/angela-kew/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/wp-content_uploads_2021_01_Michele-Tan.webp" alt="Michele Tan">
                <h3>Michele Tan</h3>
                <p class="position">Community Engagement, Partnership</p>
                <div class="position-description">
                    <p>• Strengthen member networking and collaboration</p>
                    <p>• Create channels for peer-to-peer support and industry conversations</p>
                    <p>• Drive grassroots involvement in PropTech initiatives</p>
                    <p>• Develop collaborations with industry associations, academia, government agencies, and international PropTech bodies</p>
                    <p>• Create cross-promotional and co-hosted event opportunities</p>
                </div>
                <div class="member-contact">
                    <a href="https://www.servedeck.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:michele.tan@servedeck.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.linkedin.com/in/servedeckmicheletan" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/wp-content_uploads_2024_07_Naga-R-Krishnan-.webp" alt="Naga R Krishnan">
                <h3>Naga R Krishnan</h3>
                <p class="position">Events</p>
                <div class="position-description">
                    <p>• Plan and execute small to large-scale events (Tech Talk, PropTech Connect, Annual Dinner)</p>
                    <p>• Ensure events drive business opportunities and member engagement</p>
                </div>
                <div class="member-contact">
                    <a href="https://novoreperio.com/" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:naga.krishnan@novoreperio.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.linkedin.com/in/nagakrishnan/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/Andrew.png" alt="Andrew Michael Kho">
                <h3>Andrew Michael Kho</h3>
                <p class="position">Events, Marketing & Communication, Tech & Innovation</p>
                <div class="position-description">
                    <p>• Plan and execute small to large-scale events (Tech Talk, PropTech Connect, Annual Dinner)</p>
                    <p>• Manage brand, PR, and digital communication strategy</p>
                    <p>• Oversee PropTech-related initiatives, innovation showcases, and knowledge sharing</p>
                    <p>• Drive adoption of new tech tools for members and the association</p>
                </div>
                <div class="member-contact">
                    <a href="https://www.homesifu.io" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:amk@homesifu.io" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.linkedin.com/in/andrewmichaelkho/" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-member.svg" alt="Dr Darren">
                <h3>Dr Darren</h3>
                <p class="position">Events, Marketing & Communication</p>
                <div class="position-description">
                    <p>• Plan and execute small to large-scale events (Tech Talk, PropTech Connect, Annual Dinner)</p>
                    <p>• Manage brand, PR, and digital communication strategy</p>
                    <p>• Promote events, membership benefits, and advocacy efforts</p>
                    <p>• Support recruitment through marketing campaigns</p>
                </div>
                <div class="member-contact">
                    <a href="#" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:info@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="#" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-member.svg" alt="Eugene Teow">
                <h3>Eugene Teow</h3>
                <p class="position">Tech & Innovation</p>
                <div class="position-description">
                    <p>• Oversee PropTech-related initiatives, innovation showcases, and knowledge sharing</p>
                    <p>• Drive adoption of new tech tools for members and the association</p>
                </div>
                <div class="member-contact">
                    <a href="#" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:info@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="#" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/wp-content_uploads_2021_01_azlan-zainuddin.webp" alt="Azlan Bin Zainuddin">
                <h3>Azlan Bin Zainuddin</h3>
                <p class="position">Tech & Innovation</p>
                <div class="position-description">
                    <p>• Oversee PropTech-related initiatives, innovation showcases, and knowledge sharing</p>
                    <p>• Drive adoption of new tech tools for members and the association</p>
                </div>
                <div class="member-contact">
                    <a href="https://www.aivot.my" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:azlan@aivot.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://www.linkedin.com/in/azlan-zainuddin" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/lim-sook-khim.jpeg" alt="Lim Sook Khim">
                <h3>Lim Sook Khim</h3>
                <p class="position">Sponsorship</p>
                <div class="position-description">
                    <p>• Identify and secure sponsorship for events and initiatives</p>
                    <p>• Build long-term relationships with corporate sponsors</p>
                </div>
                <div class="member-contact">
                    <a href="#" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:info@proptech.org.my" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="#" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="committee-member">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/dato-joseph-hii.png" alt="Dato' Joseph Hii W S">
                <h3>Dato' Joseph Hii W S</h3>
                <p class="position">Sponsorship, Partnership</p>
                <div class="position-description">
                    <p>• Identify and secure sponsorship for events and initiatives</p>
                    <p>• Build long-term relationships with corporate sponsors</p>
                    <p>• Develop collaborations with industry associations, academia, government agencies, and international PropTech bodies</p>
                    <p>• Create cross-promotional and co-hosted event opportunities</p>
                </div>
                <div class="member-contact">
                    <a href="#" class="contact-link" title="Website"><i class="fas fa-globe"></i></a>
                    <a href="mailto:joehws1308@gmail.com" class="contact-link" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="#" class="contact-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>

        </div>
        <div class="text-center" style="margin-top: var(--spacing-xxl);">
            <a href="<?php echo esc_url(home_url('/old-members/')); ?>" class="btn-primary">View Previous Committee Members (2021-2023)</a>
        </div>
    </div>
</section>

<!-- Cookie Consent Banner -->
<div class="cookie-banner" id="cookieBanner">
    <div class="container">
        <div class="cookie-content">
            <div class="cookie-text">
                <h4>Cookie & Privacy Notice</h4>
                <p>We use cookies and similar technologies to enhance your browsing experience, analyze site traffic, and personalize content. By continuing to use our website, you consent to our use of cookies in accordance with our Privacy Policy.</p>
            </div>
            <div class="cookie-actions">
                <button class="btn-primary" id="acceptCookies">Accept All</button>
                <button class="btn-outline" id="rejectCookies">Reject</button>
                <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" class="btn-outline">Learn More</a>
            </div>
        </div>
    </div>
</div>

<script>
// Cookie Banner
document.addEventListener('DOMContentLoaded', function() {
    const cookieBanner = document.getElementById('cookieBanner');
    const acceptCookies = document.getElementById('acceptCookies');
    const rejectCookies = document.getElementById('rejectCookies');

    // Check if user has already made a choice
    const cookieChoice = localStorage.getItem('cookieChoice');
    if (cookieChoice) {
        cookieBanner.style.display = 'none';
    }

    acceptCookies.addEventListener('click', function() {
        localStorage.setItem('cookieChoice', 'accepted');
        cookieBanner.style.display = 'none';
        showNotification('Cookie preferences saved. Thank you!', 'success');
    });

    rejectCookies.addEventListener('click', function() {
        localStorage.setItem('cookieChoice', 'rejected');
        cookieBanner.style.display = 'none';
        showNotification('Cookie preferences saved. Some features may be limited.', 'info');
    });

    // SDG Tabs functionality
    initSDGTabs();
});

function initSDGTabs() {
    const sdgTabs = document.querySelectorAll('.sdg-tab');
    const sdgDescriptions = document.querySelectorAll('.sdg-description');

    sdgTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetSDG = this.getAttribute('data-sdg');
            
            // Remove active class from all tabs and descriptions
            sdgTabs.forEach(t => t.classList.remove('active'));
            sdgDescriptions.forEach(d => d.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding description
            this.classList.add('active');
            const targetDescription = document.querySelector(`.sdg-description[data-sdg="${targetSDG}"]`);
            if (targetDescription) {
                targetDescription.classList.add('active');
            }
        });
    });
}
</script>

<?php get_footer(); ?>
