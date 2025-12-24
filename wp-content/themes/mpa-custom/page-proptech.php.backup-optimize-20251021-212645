<?php get_header(); ?>

<!-- Set custom page title -->
<script>
</script>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1><?php the_title(); ?></h1>
            <p><?php 
                $hero_description = get_post_meta(get_the_ID(), '_hero_description', true);
                echo $hero_description ?: 'Transforming the Real Estate Industry Through Innovation';
            ?></p>
        </div>
        <div class="hero-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('alt' => get_the_title() . ' Hero')); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/proptech-hero.jpg" alt="<?php echo esc_attr(get_the_title()); ?>">
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- What is PropTech -->
<section class="proptech-intro">
    <div class="container">
        <div class="intro-content">
            <div class="intro-text">
                <h2>What is PropTech</h2>
                <p>PropTech, short for Property Technology, refers to the digital transformation of the real estate and built environment sectors through innovative technologies. At its core, PropTech aims to enhance efficiency, transparency, and sustainability across the entire property lifecycle, from planning to construction, buy & sell, lease, manage, and maintain.</p>
                <p>PropTech represents a paradigm shift across the entire property lifecycle introducing innovative solutions to empower all industry stakeholders with data-driven insights and automation tools that reduce costs, improve safety, and elevate user experience.</p>
            </div>
            <div class="intro-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/proptech-innovation.jpg" alt="PropTech Innovation">
            </div>
        </div>
    </div>
</section>

<!-- PropTech Categories -->
<section class="proptech-categories">
    <div class="container">
        <div class="section-header">
            <h2>PropTech Categories</h2>
            <p>Exploring the diverse landscape of property technology solutions</p>
        </div>
        <div class="categories-grid">
            <div class="category-card">
                <i class="fas fa-home"></i>
                <h3>Real Estate Platforms</h3>
                <p>Online marketplaces, listing platforms, and transaction management systems that streamline property buying, selling, and renting processes.</p>
                <ul>
                    <li>Property listing platforms</li>
                    <li>Virtual property tours</li>
                    <li>Transaction management</li>
                    <li>Tenant screening</li>
                </ul>
            </div>
            <div class="category-card">
                <i class="fas fa-building"></i>
                <h3>Smart Buildings</h3>
                <p>IoT-enabled buildings with automated systems for energy management, security, maintenance, and tenant experience optimization.</p>
                <ul>
                    <li>Building automation systems</li>
                    <li>Energy management</li>
                    <li>Smart security</li>
                    <li>Facility management</li>
                </ul>
            </div>
            <div class="category-card">
                <i class="fas fa-chart-line"></i>
                <h3>Analytics & Data</h3>
                <p>Big data analytics, market intelligence, and predictive modeling tools that provide insights for investment and development decisions.</p>
                <ul>
                    <li>Market analytics</li>
                    <li>Investment analysis</li>
                    <li>Predictive modeling</li>
                    <li>Risk assessment</li>
                </ul>
            </div>
            <div class="category-card">
                <i class="fas fa-hammer"></i>
                <h3>Construction Tech</h3>
                <p>Innovative construction technologies providing enhanced data control and management from design stage till completion of the construction.</p>
                <p>This includes but is not limited to:</p>
                <ul>
                    <li>Building Information Modeling (BIM)</li>
                    <li>Construction e-procurement</li>
                    <li>Cost Control & resources management</li>
                    <li>Project management</li>
                </ul>
            </div>
            <div class="category-card">
                <i class="fas fa-robot"></i>
                <h3>AI & Automation</h3>
                <p>Artificial intelligence and automation solutions for property management, customer service, and operational efficiency.</p>
                <ul>
                    <li>Chatbots and virtual assistants</li>
                    <li>Automated valuation models</li>
                    <li>Predictive maintenance</li>
                    <li>Process automation</li>
                </ul>
            </div>
            <div class="category-card">
                <i class="fas fa-leaf"></i>
                <h3>Sustainability Tech</h3>
                <p>Green building technologies, renewable energy solutions, and sustainability monitoring systems for eco-friendly real estate.</p>
                <ul>
                    <li>Green building certification</li>
                    <li>Renewable energy integration</li>
                    <li>Carbon footprint tracking</li>
                    <li>Sustainable materials</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- MPA's Role in PropTech -->
<section class="mpa-role">
    <div class="container">
        <div class="role-content">
            <div class="role-text">
                <h2>MPA's Role in PropTech</h2>
                <p>The Malaysia Proptech Association plays a crucial role in fostering innovation and growth in the Malaysian PropTech ecosystem. We serve as a catalyst for digital transformation in the property industry.</p>
                
                <div class="role-highlights">
                    <div class="highlight">
                        <i class="fas fa-lightbulb"></i>
                        <h4>Innovation Hub</h4>
                        <p>We connect startups, established companies, and investors to drive innovation in PropTech solutions.</p>
                    </div>
                    <div class="highlight">
                        <i class="fas fa-users"></i>
                        <h4>Community Building</h4>
                        <p>We build a strong network of PropTech professionals, fostering collaboration and knowledge sharing.</p>
                    </div>
                    <div class="highlight">
                        <i class="fas fa-graduation-cap"></i>
                        <h4>Education & Training</h4>
                        <p>We provide educational resources and training programs to upskill the industry workforce.</p>
                    </div>
                    <div class="highlight">
                        <i class="fas fa-handshake"></i>
                        <h4>Advocacy</h4>
                        <p>We advocate for PropTech adoption and work with government agencies to create supportive policies.</p>
                    </div>
                </div>
            </div>
            <div class="role-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/proptech-hero.jpg" alt="MPA's Role in PropTech">
            </div>
        </div>
    </div>
</section>

<!-- Member Categories -->
<section class="member-categories">
    <div class="container">
        <div class="section-header">
            <h2>Member Categories</h2>
            <p>Diverse representation across the PropTech ecosystem organized by vertical</p>
        </div>
        <div class="categories-grid">
            <div class="category-card plan-category">
                <i class="fas fa-map-marked-alt"></i>
                <h3>PLAN & CONSTRUCT</h3>
                <p>Market and Feasibility data-driven studies, land use, design, BIM, e-procurement, digitalized Bill of Quantities, cost control, resources management, project management, carbon supply-chain.</p>
                <div class="subcategories">
                    <span class="subcategory">Market & Feasibility</span>
                    <span class="subcategory">Land Use</span>
                    <span class="subcategory">Design</span>
                    <span class="subcategory">BIM</span>
                    <span class="subcategory">e-procurement</span>
                    <span class="subcategory">BoQ</span>
                    <span class="subcategory">e-Tender</span>
                    <span class="subcategory">e-Contract</span>
                    <span class="subcategory">Project Management</span>
                    <span class="subcategory">ESG Compliance</span>
                    <span class="subcategory">Carbon/Supply Chain</span>
                    <span class="subcategory">Permitting</span>
                </div>
                <div class="category-count">15+ Members</div>
            </div>
            <div class="category-card transact-category">
                <i class="fas fa-exchange-alt"></i>
                <h3>MARKET & TRANSACT</h3>
                <p>Sales, leasing, finance, marketplaces, CRM, digital contracts, title/registry, crowdfunding/tokenized REITs.</p>
                <div class="subcategories">
                    <span class="subcategory">Sales</span>
                    <span class="subcategory">Leasing</span>
                    <span class="subcategory">Finance</span>
                    <span class="subcategory">Marketplaces</span>
                    <span class="subcategory">CRM</span>
                    <span class="subcategory">Digital Contracts</span>
                    <span class="subcategory">Title/Registry</span>
                    <span class="subcategory">Crowdfunding/Tokenized REITs</span>
                </div>
                <div class="category-count">18+ Members</div>
            </div>
            <div class="category-card manage-category">
                <i class="fas fa-cogs"></i>
                <h3>OPERATE & MANAGE</h3>
                <p>Property/facility mgmt, IoT, utilities, tenant/citizen experience, mobility integration, health/wellness, cybersecurity.</p>
                <div class="subcategories">
                    <span class="subcategory">Property/Facility Mgmt</span>
                    <span class="subcategory">IoT</span>
                    <span class="subcategory">Utilities</span>
                    <span class="subcategory">Tenant/Citizen Experience</span>
                    <span class="subcategory">Mobility Integration</span>
                    <span class="subcategory">Health/Wellness</span>
                    <span class="subcategory">Cybersecurity</span>
                </div>
                <div class="category-count">25+ Members</div>
            </div>
            <div class="category-card plan-category">
                <i class="fas fa-recycle"></i>
                <h3>REINVEST, REPORT & REGENERATE</h3>
                <p>ESG & financial reporting, portfolio analytics, regeneration, recycling, circular economy, deconstruction.</p>
                <div class="subcategories">
                    <span class="subcategory">ESG & Financial Reporting</span>
                    <span class="subcategory">Portfolio Analytics</span>
                    <span class="subcategory">Regeneration</span>
                    <span class="subcategory">Recycling</span>
                    <span class="subcategory">Circular Economy</span>
                    <span class="subcategory">Deconstruction</span>
                </div>
                <div class="category-count">10+ Members</div>
            </div>
        </div>
    </div>
</section>

<!-- PropTech Trends -->
<section class="proptech-trends">
    <div class="container">
        <div class="section-header">
            <h2>Emerging PropTech Trends</h2>
            <p>Stay ahead of the curve with the latest innovations in property technology</p>
        </div>
        <div class="trends-grid">
            <div class="trend-card">
                <div class="trend-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <h3>Digital Twin Technology</h3>
                <p>Virtual replicas of physical assets buildings digital twins enable predictive maintenance, energy modeling, and scenario testing without disrupting operations.</p>
            </div>
            <div class="trend-card">
                <div class="trend-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>AI-Driven Sustainability Platforms</h3>
                <p>AI is being used to optimize energy consumption, automate ESG reporting, and simulate climate resilience strategies helping developers and facility managers align with SDG-2030 and carbon neutrality goals.</p>
            </div>
            <div class="trend-card">
                <div class="trend-icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <h3>Smart Contracts & e-Signature Integration</h3>
                <p>Smart contracts and digital signing tools are streamlining construction tenders & contracts, property transactions, lease agreements, and compliance workflows while accelerating transparency and reducing friction in real estate deals.</p>
            </div>
            <div class="trend-card">
                <div class="trend-icon">
                    <i class="fas fa-microchip"></i>
                </div>
                <h3>Edge Computing for Smart Buildings</h3>
                <p>By processing data locally, within the building itself, edge computing enables faster responses for security, HVAC, and lighting systems. It also enhances privacy and reduces cloud dependency.</p>
            </div>
            <div class="trend-card">
                <div class="trend-icon">
                    <i class="fas fa-microphone"></i>
                </div>
                <h3>Voice-Activated Property Management</h3>
                <p>Voice interfaces are expanding into tenant services and facility operations, allowing hands-free control of lighting, temperature, access, and maintenance requests. This boosts accessibility and user experience.</p>
            </div>
            <div class="trend-card">
                <div class="trend-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <h3>5G-Enabled IoT Ecosystems</h3>
                <p>With 5G rollout, PropTech devices, from sensors to surveillance, can operate with ultra-low latency unlocking real-time monitoring, smart grid integration, and hyper-connected building systems.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="proptech-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Join the PropTech Revolution</h2>
            <p>Be part of Malaysia's growing PropTech ecosystem. Connect with innovators, learn about emerging technologies, and contribute to the digital transformation of the property industry.</p>
            <div class="cta-buttons">
                <a href="<?php echo esc_url(home_url('/membership/')); ?>" class="btn-primary cta-btn-primary">
                    <i class="fas fa-users"></i>
                    <span>Become a Member</span>
                </a>
                <a href="<?php echo esc_url(home_url('/events/')); ?>" class="btn-outline cta-btn-secondary">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Attend Events</span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
