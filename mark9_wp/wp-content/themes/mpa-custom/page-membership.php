<?php get_header(); ?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <h1>Join MPA</h1>
        <p>Become part of Malaysia's leading PropTech community and drive innovation together</p>
    </div>
</section>

<!-- Why Join Section -->
<section class="why-join">
    <div class="container">
        <div class="section-header">
            <h2>Why Join MPA?</h2>
            <p>Discover the benefits of being part of Malaysia's PropTech ecosystem</p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-card">
                <i class="fas fa-calendar-alt"></i>
                <h3>Strong Outreach Through Events</h3>
                <p>Participate in our local and internationally promoted events. MPA believes in a strong outreach within the local tech world, but also into the local property and construction industry. Our events provide unparalleled networking opportunities and exposure to the latest industry trends.</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-handshake"></i>
                <h3>Partnerships Form Our Foundation</h3>
                <p>Respecting each other's values drives innovation. We fully understand that taking on one of the largest industries in the country and feeding them with the latest technology and innovations, is a mammoth task. Through strategic partnerships, we create synergies that benefit all members.</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-chart-line"></i>
                <h3>Funding Moves Businesses To Greater Heights</h3>
                <p>In a relatively young industry start-ups and scale-ups flourish and thrive. Asia's strong funding ecosystem is gaining even more strength with international players taking a peek at the Asian PropTech landscape continuously. MPA connects members with investors and funding opportunities.</p>
            </div>
        </div>
    </div>
</section>

<!-- Membership Tiers -->
<section class="membership-tiers">
    <div class="container">
        <div class="section-header">
            <h2>Choose Your Membership</h2>
            <p>Select the membership tier that best fits your needs and goals</p>
        </div>
        <div class="tiers-grid">
            <div class="tier-card">
                <div class="tier-header">
                    <h3>Startup</h3>
                    <div class="price">RM 500<span>/year</span></div>
                    <p>Perfect for early-stage PropTech startups</p>
                </div>
                <ul class="tier-benefits">
                    <li><i class="fas fa-check"></i> Access to all MPA events and webinars</li>
                    <li><i class="fas fa-check"></i> Member directory listing</li>
                    <li><i class="fas fa-check"></i> Monthly newsletter subscription</li>
                    <li><i class="fas fa-check"></i> Access to resource library</li>
                    <li><i class="fas fa-check"></i> Networking opportunities</li>
                    <li><i class="fas fa-check"></i> MPA logo usage rights</li>
                    <li><i class="fas fa-check"></i> Basic mentorship support</li>
                </ul>
                <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-outline">Join Startup</a>
            </div>

            <div class="tier-card featured">
                <div class="tier-header">
                    <h3>Professional</h3>
                    <div class="price">RM 1,000<span>/year</span></div>
                    <p>For established companies and professionals</p>
                </div>
                <ul class="tier-benefits">
                    <li><i class="fas fa-check"></i> All Startup benefits</li>
                    <li><i class="fas fa-check"></i> Priority event registration</li>
                    <li><i class="fas fa-check"></i> Exclusive networking events</li>
                    <li><i class="fas fa-check"></i> Mentorship program access</li>
                    <li><i class="fas fa-check"></i> Speaking opportunities at events</li>
                    <li><i class="fas fa-check"></i> Industry research reports</li>
                    <li><i class="fas fa-check"></i> Discounted event tickets</li>
                    <li><i class="fas fa-check"></i> Advanced training programs</li>
                </ul>
                <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary">Join Professional</a>
            </div>

            <div class="tier-card">
                <div class="tier-header">
                    <h3>Enterprise</h3>
                    <div class="price">RM 5,000<span>/year</span></div>
                    <p>For large organizations and industry leaders</p>
                </div>
                <ul class="tier-benefits">
                    <li><i class="fas fa-check"></i> All Professional benefits</li>
                    <li><i class="fas fa-check"></i> Board advisory opportunities</li>
                    <li><i class="fas fa-check"></i> Custom workshops and training</li>
                    <li><i class="fas fa-check"></i> Dedicated account manager</li>
                    <li><i class="fas fa-check"></i> Strategic partnership opportunities</li>
                    <li><i class="fas fa-check"></i> Thought leadership platform</li>
                    <li><i class="fas fa-check"></i> Exclusive investor access</li>
                    <li><i class="fas fa-check"></i> Custom research and insights</li>
                    <li><i class="fas fa-check"></i> Event sponsorship opportunities</li>
                </ul>
                <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-outline">Join Enterprise</a>
            </div>
        </div>
    </div>
</section>

<!-- Member Success Stories -->
<section class="member-stories">
    <div class="container">
        <div class="section-header">
            <h2>Member Success Stories</h2>
            <p>Hear from our members about their MPA experience</p>
        </div>
        <div class="stories-grid">
            <div class="story-card">
                <div class="story-content">
                    <p>"Joining MPA has been transformative for our startup. The networking opportunities and mentorship program have accelerated our growth significantly."</p>
                </div>
                <div class="story-author">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/Andrew.png" alt="Andrew Michael Kho">
                    <div class="author-info">
                        <h4>Andrew Michael Kho</h4>
                        <p>Founder, HomeSifu</p>
                    </div>
                </div>
            </div>
            <div class="story-card">
                <div class="story-content">
                    <p>"The MPA community has provided invaluable connections and insights that have helped us navigate the PropTech landscape in Malaysia."</p>
                </div>
                <div class="story-author">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-member.svg" alt="Dr. Daniele Gambero">
                    <div class="author-info">
                        <h4>Dr. Daniele Gambero</h4>
                        <p>President, MPA</p>
                    </div>
                </div>
            </div>
            <div class="story-card">
                <div class="story-content">
                    <p>"Through MPA, we've gained access to industry leaders and potential partners that have been crucial to our business development."</p>
                </div>
                <div class="story-author">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-member.svg" alt="Jason Ding">
                    <div class="author-info">
                        <h4>Jason Ding</h4>
                        <p>Deputy President, MPA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Membership Process -->
<section class="membership-process">
    <div class="container">
        <div class="section-header">
            <h2>How to Join</h2>
            <p>Simple steps to become an MPA member</p>
        </div>
        <div class="process-steps">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Choose Your Tier</h3>
                    <p>Select the membership tier that best fits your company's needs and goals.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Complete Application</h3>
                    <p>Fill out our comprehensive membership application form with your company details.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Review Process</h3>
                    <p>Our team reviews your application within 5-7 business days.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3>Welcome to MPA</h3>
                    <p>Once approved, you'll receive your welcome package and access to all member benefits.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="membership-faq">
    <div class="container">
        <div class="section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Common questions about MPA membership</p>
        </div>
        <div class="faq-grid">
            <div class="faq-item">
                <h3>What are the eligibility criteria for membership?</h3>
                <p>MPA is open to companies and individuals involved in PropTech, ConTech, or related technology sectors. We welcome startups, established companies, academic institutions, and government agencies.</p>
            </div>
            <div class="faq-item">
                <h3>Can I upgrade my membership tier later?</h3>
                <p>Yes, you can upgrade your membership tier at any time. The price difference will be prorated based on your remaining membership period.</p>
            </div>
            <div class="faq-item">
                <h3>What happens if my application is not approved?</h3>
                <p>While most applications are approved, if yours isn't, we'll provide feedback and guidance on how to strengthen your application for future consideration.</p>
            </div>
            <div class="faq-item">
                <h3>Are there any additional fees beyond membership?</h3>
                <p>Most MPA events and resources are included in your membership. Some premium workshops or specialized training may have additional fees, but members receive significant discounts.</p>
            </div>
            <div class="faq-item">
                <h3>Can I cancel my membership?</h3>
                <p>Yes, you can cancel your membership at any time. However, membership fees are non-refundable for the current membership year.</p>
            </div>
            <div class="faq-item">
                <h3>Do you offer corporate or group memberships?</h3>
                <p>Yes, we offer special rates for multiple memberships from the same organization. Contact us for custom pricing based on your needs.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="membership-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Transform Malaysia's PropTech Landscape?</h2>
            <p>Join MPA today and become part of a community that's shaping the future of real estate technology in Malaysia and beyond.</p>
            <div class="cta-buttons">
                <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary">Apply for Membership</a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-outline">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
