<?php get_header(); ?>

<!-- Set custom page title -->
<script>
document.title = 'Members |';
</script>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1>Our Members</h1>
            <p>Meet the innovative companies and professionals driving Malaysia's PropTech ecosystem</p>
        </div>
        <div class="hero-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/members-hero.jpg" alt="MPA Members">
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
                    <p class="member-description">Crowdfunding platform for democratisation of fundraising and investing</p>
                </div>
                <div class="member-actions">
                    <a href="https://www.pitchin.my/" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="rental-marketplace">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/homii-logo.png" alt="HOMII Management">
                </div>
                <div class="member-info">
                    <h3>HOMII Management Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">Rental Marketplace</span>
                    </div>
                    <p class="member-description">Room rental service inspired by co-living concept</p>
                </div>
                <div class="member-actions">
                    <a href="https://homii.com.my/" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="contech">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/speedbrick-logo-new.png" alt="Speedbrick">
                </div>
                <div class="member-info">
                    <h3>Speedbrick Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">ConTech</span>
                    </div>
                    <p class="member-description">Nuveq Mobile Access allows you to use your own smartphone as a key to access doors, facilities, and more.</p>
                </div>
                <div class="member-actions">
                    <a href="https://speedbrick.com.my/" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="fintech">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/axai-logo.png" alt="Axai Digital">
                </div>
                <div class="member-info">
                    <h3>Axai Digital Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">Fintech</span>
                    </div>
                    <p class="member-description">Axaipay is the digital payments and fintech business. Axaipay offers a smarter, faster and safer payment gateway solution for businesses.</p>
                </div>
                <div class="member-actions">
                    <a href="https://axaipay.com/" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="iot property-management">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icares-logo.png" alt="iCares Technology">
                </div>
                <div class="member-info">
                    <h3>iCares Technology Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">IoT</span>
                    </div>
                    <p class="member-description">iCares Technology is the Malaysia's first most innovative property management platform with Smart IoT technology & designed for modern property management needs.</p>
                </div>
                <div class="member-actions">
                    <a href="https://icares.com.my/" class="btn-outline" target="_blank">View Website</a>
                </div>
            </div>
            <div class="directory-item" data-categories="iot">
                <div class="member-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/nuveq-logo.png" alt="Nuveq">
                </div>
                <div class="member-info">
                    <h3>Nuveq Sdn Bhd</h3>
                    <div class="member-categories">
                        <span class="member-category">IoT</span>
                    </div>
                    <p class="member-description">Nuveq Mobile Access allows you to use your own smartphone as a key to access doors, facilities, and more.</p>
                </div>
                <div class="member-actions">
                    <a href="https://nuveq.com.my/" class="btn-outline" target="_blank">View Website</a>
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