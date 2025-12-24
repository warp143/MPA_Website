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
                echo $hero_description ?: 'Meet the innovative companies and professionals driving Malaysia\'s PropTech ecosystem';
            ?></p>
        </div>
        <div class="hero-image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('alt' => get_the_title() . ' Hero')); ?>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/members-hero.jpg" alt="<?php echo esc_attr(get_the_title()); ?>">
            <?php endif; ?>
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
                <p>Feasibility, land use, design, BIM/digital twins, modular, carbon/supply chain, resilience & permitting.</p>
                <div class="subcategories">
                    <span class="subcategory">Feasibility</span>
                    <span class="subcategory">Land Use</span>
                    <span class="subcategory">Design</span>
                    <span class="subcategory">BIM/Digital Twins</span>
                    <span class="subcategory">Modular</span>
                    <span class="subcategory">Carbon/Supply Chain</span>
                    <span class="subcategory">Resilience</span>
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

<!-- Featured Members -->
<section class="featured-members">
    <div class="container">
        <div class="section-header">
            <h2>Featured Members</h2>
            <p>Showcasing some of our most innovative and active members</p>
        </div>
        <div class="members-grid" id="featuredMembersGrid">
            <!-- Featured members will be populated dynamically from member directory -->
        </div>
    </div>
</section>

<!-- Member Benefits -->
<section class="member-benefits">
    <div class="container">
        <div class="section-header">
            <h2>Member Benefits</h2>
            <p>Exclusive advantages for MPA members</p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-card">
                <i class="fas fa-calendar-alt"></i>
                <h3>Event Access</h3>
                <p>Priority registration and discounted rates for all MPA events, workshops, and conferences.</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-users"></i>
                <h3>Networking</h3>
                <p>Connect with industry leaders, investors, and fellow PropTech professionals through our exclusive networking events.</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-lightbulb"></i>
                <h3>Innovation Showcase</h3>
                <p>Opportunities to showcase your products and innovations to the Malaysian PropTech community.</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-graduation-cap"></i>
                <h3>Education & Training</h3>
                <p>Access to educational resources, training programs, and industry insights to stay ahead of the curve.</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-handshake"></i>
                <h3>Partnership Opportunities</h3>
                <p>Connect with potential partners, clients, and collaborators within the MPA ecosystem.</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-bullhorn"></i>
                <h3>Advocacy & Representation</h3>
                <p>Your voice represented in industry discussions and policy-making processes.</p>
            </div>
        </div>
    </div>
</section>

<!-- Member Directory -->
<section class="member-directory">
    <div class="container">
        <div class="section-header">
            <h2>Member Directory</h2>
            <p>Search and connect with our diverse member network</p>
        </div>
        <div class="directory-search">
            <div class="search-container">
                <input type="text" placeholder="Search members by name, category, or technology...">
                <button class="search-btn"><i class="fas fa-search"></i></button>
            </div>
            <div class="filter-options">
                <select class="vertical-filter">
                    <option value="">All Verticals</option>
                    <option value="plan">PLAN</option>
                    <option value="construct">CONSTRUCT</option>
                    <option value="transact">TRANSACT</option>
                    <option value="manage">MANAGE</option>
                </select>
                <select class="category-filter">
                    <option value="">All Subcategories</option>
                    <!-- PLAN Subcategories -->
                    <option value="property-development">Property Development</option>
                    <option value="mapping">Mapping</option>
                    <option value="ar-vr">AR & VR</option>
                    <option value="smart-cities">Smart Cities</option>
                    <!-- CONSTRUCT Subcategories -->
                    <option value="contech">ConTech</option>
                    <option value="renovation-tech">Renovation Tech</option>
                    <option value="iot">IoT</option>
                    <option value="smart-homes">Smart Homes</option>
                    <!-- TRANSACT Subcategories -->
                    <option value="property-marketplace">Property Marketplace</option>
                    <option value="rental-marketplace">Rental Marketplace</option>
                    <option value="fintech">Fintech</option>
                    <option value="crowdfunding">Crowdfunding</option>
                    <option value="mortgages">Mortgages</option>
                    <option value="legal-tech">Legal Tech</option>
                    <!-- MANAGE Subcategories -->
                    <option value="property-management">Property Management</option>
                    <option value="tenant-management">Tenant Management</option>
                    <option value="sales-booking">Sales & Booking</option>
                    <option value="property-community">Property Community</option>
                    <option value="big-data">Big Data</option>
                    <option value="ai">AI, DL & ML</option>
                    <option value="blockchain">Blockchain</option>
                </select>
            </div>
        </div>
        <div class="directory-grid">
            <div class="directory-item" data-categories="crowdfunding fintech">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/pitchin-logo.png" alt="pitchIN">
                </div>
                <div class="member-info">
                    <h3>pitchIN</h3>
                    <div class="member-categories">
                        <span class="member-category">Crowdfunding</span>
                        <span class="member-category">Fintech</span>
                    </div>
                    <p class="member-description">pitchIN provides crowdfunding platform for users. pitchIN believe in the democratisation of fundraising and investing. pitchIN allows investors</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="rental-marketplace">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/homii-logo.png" alt="HOMII Management Sdn Bhd">
                </div>
                <div class="member-info">
                    <h3>HOMII Management Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">Rental Marketplace</span>
                    </div>
                    <p class="member-description">HOMII supply the market with its signature room rental service inspired by co-living concept. HOMII also help property</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="contech">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/speedbrick-logo.png" alt="Speedbrick Sdn Bhd">
                </div>
                <div class="member-info">
                    <h3>Speedbrick Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">ConTech</span>
                    </div>
                    <p class="member-description">Nuveq Mobile Access allows you to use your own smartphone as a key to access doors, facilities, and</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="fintech">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/axai-logo.png" alt="Axai Digital Sdn Bhd">
                </div>
                <div class="member-info">
                    <h3>Axai Digital Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">Fintech</span>
                    </div>
                    <p class="member-description">Axaipay is the digital payments and fintech business. Axaipay offers a smarter, faster and safer payment gateway solution</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="iot">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icares-logo.png" alt="iCares Technology Sdn Bhd">
                </div>
                <div class="member-info">
                    <h3>iCares Technology Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">IoT</span>
                    </div>
                    <p class="member-description">iCares Technology is the Malaysia’s first most innovative property management platform with Smart IoT technology & designed for</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="iot">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/nuveq-logo.png" alt="Nuveq Sdn Bhd">
                </div>
                <div class="member-info">
                    <h3>Nuveq Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">IoT</span>
                    </div>
                    <p class="member-description">Nuveq Mobile Access allows you to use your own smartphone as a key to access doors, facilities, and</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-development">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/hck-properties-logo.png" alt="HCK Properties Sdn. Bhd.">
                </div>
                <div class="member-info">
                    <h3>HCK Properties Sdn. Bhd.</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Development</span>
                    </div>
                    <p class="member-description">HCK Properties Sdn Bhd, is a property developer, and part of HCK Capital Group Bhd., the latter was</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="big-data contech smart-cities">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/softwareone-experts-logo.png" alt="SoftwareONE Experts">
                </div>
                <div class="member-info">
                    <h3>SoftwareONE Experts</h3>
                    <div class="member-categories">
                        <span class="member-category">Big Data</span>
                        <span class="member-category">ConTech</span>
                        <span class="member-category">Smart Cities</span>
                    </div>
                    <p class="member-description">Empowering Companies to Transform</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="big-data bmi iot property-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/mandarin-fox-logo.png" alt="Mandarin Fox Sdn Bhd">
                </div>
                <div class="member-info">
                    <h3>Mandarin Fox Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">Big Data</span>
                        <span class="member-category">BMI</span>
                        <span class="member-category">IoT</span>
                        <span class="member-category">Property Management</span>
                    </div>
                    <p class="member-description">"Building Maintenance Reimagined"</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="big-data marketing">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/alphacore-technology-logo.png" alt="Alphacore Technology">
                </div>
                <div class="member-info">
                    <h3>Alphacore Technology</h3>
                    <div class="member-categories">
                        <span class="member-category">Big Data</span>
                        <span class="member-category">Marketing</span>
                    </div>
                    <p class="member-description">Bring Your Vision to Life with Technology</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ar-vr mapping">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/novo-reperio-logo.png" alt="Novo Reperio">
                </div>
                <div class="member-info">
                    <h3>Novo Reperio</h3>
                    <div class="member-categories">
                        <span class="member-category">AR & VR</span>
                        <span class="member-category">Mapping</span>
                    </div>
                    <p class="member-description">Your Space, Indestructible Virtually</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-community sales-booking-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/fusionqb-logo.png" alt="FusionQB">
                </div>
                <div class="member-info">
                    <h3>FusionQB</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Community</span>
                        <span class="member-category">Sales & Booking Management</span>
                    </div>
                    <p class="member-description">FusionQB is a data-driven platform that enriches your customer data in an all-in-one platform, for better customer experience</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ai-dl-ml">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/nextsix-property-logo.png" alt="Nextsix Property">
                </div>
                <div class="member-info">
                    <h3>Nextsix Property</h3>
                    <div class="member-categories">
                        <span class="member-category">AI, DL & ML</span>
                    </div>
                    <p class="member-description">Nextsix is a one-stop property platform, pioneering a GPS search engine that connects property seekers to professional real</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ai-dl-ml">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/isolutions-logo.png" alt="iSolutions">
                </div>
                <div class="member-info">
                    <h3>iSolutions</h3>
                    <div class="member-categories">
                        <span class="member-category">AI, DL & ML</span>
                    </div>
                    <p class="member-description">China Mobile International Limited (CMI) is a wholly-owned subsidiary of China Mobile. In order to provide better services</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ai-dl-ml property-community property-management property-marketplace rental-marketplace tenant-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/squarefeet-pro-logo.png" alt="Squarefeet Pro">
                </div>
                <div class="member-info">
                    <h3>Squarefeet Pro</h3>
                    <div class="member-categories">
                        <span class="member-category">AI, DL & ML</span>
                        <span class="member-category">Property Community</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Rental Marketplace</span>
                        <span class="member-category">Tenant Management</span>
                    </div>
                    <p class="member-description">Squarefeet Pro is a premier student accommodation provider since 1992. Boasting 2,550 rooms under our management at over</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ai-dl-ml big-data fintech legal-tech mortgages property-marketplace renovation-tech sales-booking-management tenant-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/heyprop-logo.png" alt="HeyProp">
                </div>
                <div class="member-info">
                    <h3>HeyProp</h3>
                    <div class="member-categories">
                        <span class="member-category">AI, DL & ML</span>
                        <span class="member-category">Big Data</span>
                        <span class="member-category">Fintech</span>
                        <span class="member-category">Legal Tech</span>
                        <span class="member-category">Mortgages</span>
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Renovation Tech</span>
                        <span class="member-category">Sales & Booking Management</span>
                        <span class="member-category">Tenant Management</span>
                    </div>
                    <p class="member-description">HeyProp is the first tech-enabled real estate platform to digitalize the entire process from viewing to buying to</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-community property-management smart-cities smart-homes">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/ineighbour-logo.png" alt="iNeighbour">
                </div>
                <div class="member-info">
                    <h3>iNeighbour</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Community</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Smart Cities</span>
                        <span class="member-category">Smart Homes</span>
                    </div>
                    <p class="member-description">Property Management System</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ai-dl-ml property-community property-management property-marketplace rental-marketplace tenant-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/vendfun-logo.png" alt="Vendfun Sdn Bhd">
                </div>
                <div class="member-info">
                    <h3>Vendfun Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">AI, DL & ML</span>
                        <span class="member-category">Property Community</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Rental Marketplace</span>
                        <span class="member-category">Tenant Management</span>
                    </div>
                    <p class="member-description">Industry’s First Hybrid Kiosk that helps hospitality operators to provide a unique check-in/out experience for your guest, save</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-management renovation-tech rental-marketplace tenant-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/cozyhomes-logo.png" alt="CozyHomes">
                </div>
                <div class="member-info">
                    <h3>CozyHomes</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Renovation Tech</span>
                        <span class="member-category">Rental Marketplace</span>
                        <span class="member-category">Tenant Management</span>
                    </div>
                    <p class="member-description">CozyHomes is a property solution company. We provide tenancy management service to property investors and at the same</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ar-vr property-management property-marketplace rental-marketplace smart-cities">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/smplrspace-logo.png" alt="Smplrspace">
                </div>
                <div class="member-info">
                    <h3>Smplrspace</h3>
                    <div class="member-categories">
                        <span class="member-category">AR & VR</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Rental Marketplace</span>
                        <span class="member-category">Smart Cities</span>
                    </div>
                    <p class="member-description">Smplrspace's floor plan platform lets businesses and app builders add interactive 2D & 3D floor plans to their</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-management rental-marketplace tenant-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/widebed-logo.png" alt="Widebed">
                </div>
                <div class="member-info">
                    <h3>Widebed</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Rental Marketplace</span>
                        <span class="member-category">Tenant Management</span>
                    </div>
                    <p class="member-description">Widebed is Malaysia’s Pioneer Rental Property Management Services Platform since 2011. We help property owners maximize rental property</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ai-dl-ml property-management property-marketplace tenant-management web-development">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/salescandy-logo.png" alt="SalesCandy">
                </div>
                <div class="member-info">
                    <h3>SalesCandy</h3>
                    <div class="member-categories">
                        <span class="member-category">AI, DL & ML</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Tenant Management</span>
                        <span class="member-category">Web Development</span>
                    </div>
                    <p class="member-description">With SalesCandy, we help you enforce a contact strategy, trace every sale, and pinpoint the ads that give</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="big-data property-management rental-marketplace tenant-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/hostplatform-logo.png" alt="HostPlatform">
                </div>
                <div class="member-info">
                    <h3>HostPlatform</h3>
                    <div class="member-categories">
                        <span class="member-category">Big Data</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Rental Marketplace</span>
                        <span class="member-category">Tenant Management</span>
                    </div>
                    <p class="member-description">We are a team of enthusiastic young blood with the Mission to create a positive impact to the</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-community">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/1balcony-logo.png" alt="1Balcony">
                </div>
                <div class="member-info">
                    <h3>1Balcony</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Community</span>
                    </div>
                    <p class="member-description">It includes News & Articles, Online Investment Education, Online TV, Property Market Place, Online Bookstore, E-Publication, as well</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-management property-marketplace tenant-management web-development">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/tplus-logo.png" alt="Tplus">
                </div>
                <div class="member-info">
                    <h3>Tplus</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Tenant Management</span>
                        <span class="member-category">Web Development</span>
                    </div>
                    <p class="member-description">Tplus, the leading tenancy operating system in Malaysia that provides an end-to-end solution. We build the technology; you</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="iot property-management tenant-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/servedeck-logo.png" alt="ServeDeck">
                </div>
                <div class="member-info">
                    <h3>ServeDeck</h3>
                    <div class="member-categories">
                        <span class="member-category">IoT</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Tenant Management</span>
                    </div>
                    <p class="member-description">ServeDeck™ is a smart facility operation and management platform offered as a subscription cloud-based solution.</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="rental-marketplace">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/rentlab-logo.png" alt="Rentlab">
                </div>
                <div class="member-info">
                    <h3>Rentlab</h3>
                    <div class="member-categories">
                        <span class="member-category">Rental Marketplace</span>
                    </div>
                    <p class="member-description">Advocating Trust & Transparency in Property Rental</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="renovation-tech">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/rekatone-logo.png" alt="Rekatone">
                </div>
                <div class="member-info">
                    <h3>Rekatone</h3>
                    <div class="member-categories">
                        <span class="member-category">Renovation Tech</span>
                    </div>
                    <p class="member-description">Match,design & bid your property renovation via trusted and transparent platform</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="big-data contech sales-booking-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/prosales-logo.png" alt="ProSales">
                </div>
                <div class="member-info">
                    <h3>ProSales</h3>
                    <div class="member-categories">
                        <span class="member-category">Big Data</span>
                        <span class="member-category">ConTech</span>
                        <span class="member-category">Sales & Booking Management</span>
                    </div>
                    <p class="member-description">ProSales Digital Solutions are tailored to the needs of Construction Communication and Defect Management and provide End-to-End Property</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-marketplace rental-marketplace">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/property-hunter-logo.png" alt="Property Hunter">
                </div>
                <div class="member-info">
                    <h3>Property Hunter</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Rental Marketplace</span>
                    </div>
                    <p class="member-description">Always ask ourselves "Have we done our best?"</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-community property-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/properly-logo.png" alt="ProperLy">
                </div>
                <div class="member-info">
                    <h3>ProperLy</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Community</span>
                        <span class="member-category">Property Management</span>
                    </div>
                    <p class="member-description">Resident Satisfaction Empowers Communities</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="big-data">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/propenomy-logo.png" alt="Propenomy">
                </div>
                <div class="member-info">
                    <h3>Propenomy</h3>
                    <div class="member-categories">
                        <span class="member-category">Big Data</span>
                    </div>
                    <p class="member-description">Connecting Data, Property, People & Digital Transformation and Make Sense Out of It</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ai-dl-ml big-data property-community property-management smart-cities">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/myliving-mylife-logo.png" alt="myliving.mylife">
                </div>
                <div class="member-info">
                    <h3>myliving.mylife</h3>
                    <div class="member-categories">
                        <span class="member-category">AI, DL & ML</span>
                        <span class="member-category">Big Data</span>
                        <span class="member-category">Property Community</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Smart Cities</span>
                    </div>
                    <p class="member-description">We believe everyone deserves a better lifestyle</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ar-vr fintech legal-tech mortgages property-community property-management property-marketplace sales-booking-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/mhub-logo.png" alt="MHub">
                </div>
                <div class="member-info">
                    <h3>MHub</h3>
                    <div class="member-categories">
                        <span class="member-category">AR & VR</span>
                        <span class="member-category">Fintech</span>
                        <span class="member-category">Legal Tech</span>
                        <span class="member-category">Mortgages</span>
                        <span class="member-category">Property Community</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Sales & Booking Management</span>
                    </div>
                    <p class="member-description">People Powered Property Platform</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="iot property-community property-management property-marketplace smart-homes">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/linkzzapp-pro-logo.png" alt="LinkZZapp PRO">
                </div>
                <div class="member-info">
                    <h3>LinkZZapp PRO</h3>
                    <div class="member-categories">
                        <span class="member-category">IoT</span>
                        <span class="member-category">Property Community</span>
                        <span class="member-category">Property Management</span>
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Smart Homes</span>
                    </div>
                    <p class="member-description">LinkZZapp PRO Comprehensive end-to-end software &amp; mobile APP, built specifically for the property industry to help to improve</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-marketplace rental-marketplace">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/estate-123-logo.png" alt="Estate123">
                </div>
                <div class="member-info">
                    <h3>Estate123</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Marketplace</span>
                        <span class="member-category">Rental Marketplace</span>
                    </div>
                    <p class="member-description">Focus on Growth Rather Than Perfection.</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="property-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/dax-logo.png" alt="DAX">
                </div>
                <div class="member-info">
                    <h3>DAX</h3>
                    <div class="member-categories">
                        <span class="member-category">Property Management</span>
                    </div>
                    <p class="member-description">“We understand what it takes to deliver best-in-class asset lifecycle technology and integrated solutions to optimise the performance</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="iot smart-cities smart-homes">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/bwave-logo.png" alt="bWave">
                </div>
                <div class="member-info">
                    <h3>bWave</h3>
                    <div class="member-categories">
                        <span class="member-category">IoT</span>
                        <span class="member-category">Smart Cities</span>
                        <span class="member-category">Smart Homes</span>
                    </div>
                    <p class="member-description">Unlock & Accelerate Connected Opportunities Together</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="ai-dl-ml ar-vr big-data blockchain">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/briq-bloq-logo.png" alt="Briq Bloq">
                </div>
                <div class="member-info">
                    <h3>Briq Bloq</h3>
                    <div class="member-categories">
                        <span class="member-category">AI, DL & ML</span>
                        <span class="member-category">AR & VR</span>
                        <span class="member-category">Big Data</span>
                        <span class="member-category">Blockchain</span>
                    </div>
                    <p class="member-description">Accurately Delivering Critical and Transparent Information to the Commercial Real Estate Ecosystem</p>
                </div>
                <div class="member-actions">
                    <a href="#" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Join CTA -->
<section class="join-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Join Malaysia's Leading PropTech Community?</h2>
            <p>Connect with innovative companies, access exclusive benefits, and be part of the digital transformation of Malaysia's property industry.</p>
            <div class="cta-buttons">
                <a href="<?php echo esc_url(home_url('/join/')); ?>" class="btn-primary">Become a Member</a>
                <a href="<?php echo esc_url(home_url('/membership/')); ?>" class="btn-outline">Learn More</a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Member Directory Search and Filter Functionality
    const searchInput = document.querySelector('.directory-search input');
    const searchBtn = document.querySelector('.search-btn');
    const verticalFilter = document.querySelector('.vertical-filter');
    const categoryFilter = document.querySelector('.category-filter');
    const directoryItems = document.querySelectorAll('.directory-item');

    // Featured members functionality
    const featuredMembersGrid = document.getElementById('featuredMembersGrid');
    if (featuredMembersGrid) {
        populateFeaturedMembers();
    }
    
    function populateFeaturedMembers() {
        // Get the first 6 member directory items
        const firstSixMembers = Array.from(directoryItems).slice(0, 6);
        
        firstSixMembers.forEach(memberItem => {
            // Clone the member item
            const clonedMember = memberItem.cloneNode(true);
            
            // Convert to featured member card format
            const memberCard = document.createElement('div');
            memberCard.className = 'member-card';
            
            // Get the logo
            const logo = clonedMember.querySelector('.member-logo img');
            const logoDiv = document.createElement('div');
            logoDiv.className = 'member-logo';
            logoDiv.appendChild(logo.cloneNode(true));
            
            // Get the name
            const name = clonedMember.querySelector('h3');
            const nameH3 = document.createElement('h3');
            nameH3.textContent = name.textContent;
            
            // Get the categories
            const categories = clonedMember.querySelector('.member-categories');
            const categoriesDiv = categories.cloneNode(true);
            
            // Get the description
            const description = clonedMember.querySelector('.member-description');
            const descriptionP = document.createElement('p');
            descriptionP.className = 'member-description';
            descriptionP.textContent = description.textContent;
            
            // Get the action button
            const action = clonedMember.querySelector('.member-actions a');
            const actionDiv = document.createElement('div');
            actionDiv.className = 'member-actions';
            actionDiv.appendChild(action.cloneNode(true));
            
            // Create featured tag
            const featuredTag = document.createElement('div');
            featuredTag.className = 'featured-tag';
            featuredTag.textContent = 'FEATURED';
            
            // Assemble the member card
            memberCard.appendChild(logoDiv);
            memberCard.appendChild(nameH3);
            memberCard.appendChild(categoriesDiv);
            memberCard.appendChild(descriptionP);
            memberCard.appendChild(actionDiv);
            memberCard.appendChild(featuredTag);
            
            // Add to featured members grid
            featuredMembersGrid.appendChild(memberCard);
        });
    }

    function filterMembers() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedVertical = verticalFilter.value;
        const selectedCategory = categoryFilter.value;

        directoryItems.forEach(item => {
            const memberName = item.querySelector('h3').textContent.toLowerCase();
            const memberDescription = item.querySelector('.member-description').textContent.toLowerCase();
            const memberCategories = item.getAttribute('data-categories');
            
            let showItem = true;

            // Search filter
            if (searchTerm && !memberName.includes(searchTerm) && !memberDescription.includes(searchTerm)) {
                showItem = false;
            }

            // Category filter
            if (selectedCategory && !memberCategories.includes(selectedCategory)) {
                showItem = false;
            }

            // Vertical filter (simplified - you can enhance this based on your categorization)
            if (selectedVertical) {
                // Add logic to map verticals to categories if needed
            }

            item.style.display = showItem ? 'block' : 'none';
        });
    }

    // Event listeners
    searchInput.addEventListener('input', filterMembers);
    searchBtn.addEventListener('click', filterMembers);
    verticalFilter.addEventListener('change', filterMembers);
    categoryFilter.addEventListener('change', filterMembers);
});
</script>

<?php get_footer(); ?>