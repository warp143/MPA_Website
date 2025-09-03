// Modern Liquid MPA Website JavaScript

// Theme Management
let currentTheme = localStorage.getItem('theme') || 'auto';
let isAutoMode = currentTheme === 'auto';

function getAutoTheme() {
    const now = new Date();
    const hour = now.getHours();
    // Auto switch: dark mode from 7 PM to 7 AM, light mode from 7 AM to 7 PM
    return (hour >= 19 || hour < 7) ? 'dark' : 'light';
}

function applyTheme(theme) {
    const body = document.body;
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle?.querySelector('.theme-icon');
    const autoIndicator = document.getElementById('autoIndicator');
    
    if (theme === 'light') {
        body.classList.add('light-mode');
        if (themeIcon) themeIcon.textContent = '☀️';
    } else {
        body.classList.remove('light-mode');
        if (themeIcon) themeIcon.textContent = '🌙';
    }
    
    // Show/hide auto indicator
    if (autoIndicator) {
        if (isAutoMode) {
            autoIndicator.classList.remove('hidden');
        } else {
            autoIndicator.classList.add('hidden');
        }
    }
    
    // Update logo based on theme
    updateLogoForTheme(theme);
}

function updateLogoForTheme(theme) {
    const logoImg = document.querySelector('.logo-img');
    if (logoImg) {
        if (theme === 'light') {
            logoImg.src = window.location.origin + '/wp-content/themes/mpa-custom/assets/mpa-logo.png';
        } else {
            logoImg.src = window.location.origin + '/wp-content/themes/mpa-custom/assets/MPA-logo-white-transparent-res.png';
        }
    }
}

function checkAndUpdateTheme() {
    if (isAutoMode) {
        const autoTheme = getAutoTheme();
        applyTheme(autoTheme);
    } else {
        applyTheme(currentTheme);
    }
}

// Expose checkAndUpdateTheme globally for header component integration
window.checkAndUpdateTheme = checkAndUpdateTheme;

function setTheme(theme) {
    currentTheme = theme;
    isAutoMode = theme === 'auto';
    localStorage.setItem('theme', theme);
    checkAndUpdateTheme();
    updateAutoIndicator(theme);
}

function cycleTheme() {
    const themes = ['auto', 'light', 'dark'];
    const currentIndex = themes.indexOf(currentTheme);
    const nextIndex = (currentIndex + 1) % themes.length;
    const newTheme = themes[nextIndex];
    setTheme(newTheme);
}

// Expose cycleTheme globally for header component integration
window.cycleTheme = cycleTheme;

function updateThemeIcon(theme) {
    const themeIcon = document.querySelector('.theme-icon');
    if (themeIcon) {
        if (theme === 'light') {
            themeIcon.textContent = '☀️';
        } else {
            themeIcon.textContent = '🌙';
        }
    }
}

function updateAutoIndicator(savedTheme) {
    const autoIndicator = document.getElementById('autoIndicator');
    const themeToggle = document.getElementById('themeToggle');
    if (autoIndicator && themeToggle) {
        if (savedTheme === 'auto') {
            autoIndicator.classList.remove('hidden');
            themeToggle.classList.remove('auto-hidden');
        } else {
            autoIndicator.classList.add('hidden');
            themeToggle.classList.add('auto-hidden');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Check if all required elements exist
    const requiredElements = [
        'themeToggle',
        'autoIndicator',
        'hamburger',
        'nav-menu'
    ];
    
    requiredElements.forEach(id => {
        const element = document.getElementById(id);
        if (!element) {
            console.warn(`Element missing: ${id}`);
        }
    });
    
    // Initialize theme
    checkAndUpdateTheme();
    
    // Set initial auto-hidden class if needed
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle && currentTheme !== 'auto') {
        themeToggle.classList.add('auto-hidden');
    }
    
    // Theme toggle functionality
    if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            cycleTheme();
        });
    } else {
        console.warn('Theme toggle not found - theme switching disabled');
    }
    
    // Check for system theme changes
    if (window.matchMedia) {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addListener(function(e) {
            if (isAutoMode) {
                checkAndUpdateTheme();
            }
        });
    }
    // Mobile Menu Management
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');

    function toggleMobileMenu() {
        if (!mobileDropdownMenu) return;
        const isActive = mobileDropdownMenu.classList.contains('active');
        
        if (isActive) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }

    function openMobileMenu() {
        if (!mobileDropdownMenu || !mobileMenuToggle) return;
        mobileDropdownMenu.classList.add('active');
        mobileMenuToggle.classList.add('active');
        
        // Add entrance animation to menu items
        const menuItems = mobileDropdownMenu.querySelectorAll('.mobile-dropdown-link');
        menuItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-10px)';
            setTimeout(() => {
                item.style.transition = 'all 0.2s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 50 + (index * 30));
        });
    }

    function closeMobileMenu() {
        if (!mobileDropdownMenu || !mobileMenuToggle) return;
        mobileDropdownMenu.classList.remove('active');
        mobileMenuToggle.classList.remove('active');
        
        // Reset menu items
        const menuItems = mobileDropdownMenu.querySelectorAll('.mobile-dropdown-link');
        menuItems.forEach(item => {
            item.style.opacity = '';
            item.style.transform = '';
            item.style.transition = '';
        });
    }

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', toggleMobileMenu);
    }

    // Language Dropdown Management
    const languageToggle = document.getElementById('languageToggle');
    const languageMenu = document.getElementById('languageMenu');
    const languageDropdown = document.querySelector('.language-dropdown');
    const currentLanguage = document.querySelector('.current-language');

    function toggleLanguageMenu() {
        if (!languageDropdown) return;
        languageDropdown.classList.toggle('active');
    }

    // Translation data
    const translations = {
        en: {
            // Navigation
            'nav-proptech': 'Proptech',
            'nav-about': 'Association',
            'nav-members': 'Members',
            'nav-events': 'Events',
            'nav-news': 'News & Resource',
            'nav-partners': 'Partners',

            'btn-signin': 'Sign In',
            'btn-join': 'Join MPA',
            
            // Hero Section
            'hero-title': 'For The Future of A Sustainable Property Market',
            'hero-subtitle': 'Malaysia Proptech Association - Leading The Digital Transformation of the Property Industry in Malaysia through innovation, collaboration, and sustainable growth. Building a strong community with integrity, inclusivity, and equality.',
            'search-placeholder': 'Find events, members, or resources...',
            'search-btn': 'Search',
            'stat-members': 'Members',
            'stat-events': 'Events',
            'stat-startups': 'Startups',
            'stat-partners': 'Partners',
            
            // Events Section
            'events-title': 'Upcoming Events',
            'view-all-events': 'View all events',
            'event-featured': 'Featured',
            'event-free': 'Free for Members',
            'btn-register': 'Register',

            
            // About Section
            'about-title': 'About MPA',
            'about-text-1': 'The Malaysia Proptech Association (MPA) is the leading organization driving innovation in Malaysia\'s property technology sector. We bring together startups, established companies, investors, and government agencies to accelerate the digital transformation of real estate.',
            'about-text-2': 'Our mission is to foster a sustainable property market through technology innovation, collaboration, and community building. We believe in integrity, inclusivity, and equality for all our members.',
            'feature-community': 'Community',
            'feature-community-desc': 'Connect with 150+ PropTech professionals',
            'feature-innovation': 'Innovation',
            'feature-innovation-desc': 'Drive cutting-edge PropTech solutions',
            'feature-global': 'Global Network',
            'feature-global-desc': 'Access international PropTech ecosystem',
            
            // Membership Section
            'membership-title': 'Join Our Community',
            'membership-subtitle': 'Choose the membership that fits your needs',
            'membership-startup': 'Startup',
            'membership-professional': 'Professional',
            'membership-enterprise': 'Enterprise',
            'membership-year': '/year',
            'benefit-events': 'Access to all events',
            'benefit-directory': 'Member directory',
            'benefit-newsletter': 'Newsletter subscription',
            'benefit-resources': 'Resource library',
            'benefit-priority': 'Priority event registration',
            'benefit-networking': 'Networking opportunities',
            'benefit-mentorship': 'Mentorship program',
            'benefit-speaking': 'Speaking opportunities',
            'benefit-workshops': 'Custom workshops',
            'benefit-advisory': 'Board advisory',
            'benefit-all-startup': 'All Startup benefits',
            'benefit-all-professional': 'All Professional benefits',
            'btn-join-now': 'Join Now',
            
            // Newsletter Section
            'newsletter-title': 'Stay Updated',
            'newsletter-subtitle': 'Get the latest PropTech news, events, and insights delivered to your inbox',
            'newsletter-placeholder': 'Enter your email address',
            'btn-subscribe': 'Subscribe',
            
            // Footer
            'footer-mpa-desc': 'Malaysia\'s leading PropTech community driving innovation in real estate technology.',
            'footer-quick-links': 'Quick Links',
            'footer-about': 'About Us',
            'footer-membership': 'Membership',
            'footer-events': 'Events',
            'footer-news': 'News',
            'footer-contact': 'Contact',
            'footer-copyright': '© 2025 Malaysia Proptech Association. All rights reserved.',
            
            // Privacy Policy
            'privacy-title': 'Privacy Policy',
            'privacy-subtitle': 'Protecting your personal data and ensuring transparency in how we handle your information',
            'download-policy': 'Download Privacy Policy',
            'download-description': 'Download the privacy policy in your preferred language',
            'download-english': 'English PDF',
            'download-bahasa': 'Bahasa Malaysia PDF',
            'privacy-intro-title': 'Introduction',
            'privacy-intro-text': 'Malaysia PropTech Association ("MPA", "we", "us", "our") is committed to protecting your personal data in accordance with the Personal Data Protection Act 2010 [Act 709], as amended by the Personal Data Protection (Amendment) Act 2024. This Privacy Policy outlines how we collect, use, disclose, and safeguard your personal data when you interact with us via our website, membership portal, events, or other services.',
            'privacy-data-title': 'Types of Personal Data Collected',
            'privacy-data-intro': 'We may collect and process the following categories of personal data:',
            'privacy-identity': 'Identity data:',
            'privacy-identity-details': 'Full Name, NRIC / Passport Number, Date of Birth',
            'privacy-contact': 'Contact data:',
            'privacy-contact-details': 'Email Address, Phone Number, Mailing Address',
            'privacy-professional': 'Professional data:',
            'privacy-professional-details': 'Company Name, Job Title, Industry Affiliation',
            'privacy-membership': 'Membership data:',
            'privacy-membership-details': 'Membership Type, Application History, Participation in events',
            'privacy-technical': 'Technical data:',
            'privacy-technical-details': 'IP Address, Browser Type, Device Information, Cookies',
            'privacy-purpose-title': 'Purpose of Collection',
            'privacy-purpose-intro': 'Your personal data is collected for the following purposes:',
            'privacy-purpose-1': 'To process membership applications and renewals',
            'privacy-purpose-2': 'To manage member profiles and provide member-exclusive content',
            'privacy-purpose-3': 'To send newsletters, updates, and event invitations',
            'privacy-purpose-4': 'To facilitate participation in competitions, workshops, and forums',
            'privacy-purpose-5': 'To comply with legal and regulatory obligations',
            'privacy-consent-title': 'Consent and Access',
            'privacy-consent-text': 'By submitting your personal data to us, you consent to its processing for the purposes stated above. You may withdraw consent or request access, correction, or deletion of your data by contacting our Data Protection Officer (DPO) at:',
            'privacy-dpo-name': 'Name:',
            'privacy-dpo-email': 'Email:',
            'privacy-dpo-contact': 'Contact:',
            'privacy-rights-title': 'Your Rights',
            'privacy-rights-intro': 'Under PDPA, you have the right to:',
            'privacy-rights-1': 'Access and correct your personal data',
            'privacy-rights-2': 'Withdraw consent at any time',
            'privacy-rights-3': 'Lodge a complaint with the Department of Personal Data Protection (JPDP)',
            'privacy-updates-title': 'Updates to This Policy',
            'privacy-updates-text': 'We may update this Privacy Policy from time to time. Any changes will be posted on our website with the effective date clearly indicated.',
            
            // Cookie Banner
            'cookie-title': 'Cookie & Privacy Notice',
            'cookie-text': 'We use cookies and similar technologies to enhance your browsing experience, analyze site traffic, and personalize content. By continuing to use our website, you consent to our use of cookies in accordance with our Privacy Policy.',
            'accept-cookies': 'Accept All',
            'reject-cookies': 'Reject',
            'learn-more': 'Learn More'
        },
        bm: {
            // Navigation
            'nav-proptech': 'Proptech',
            'nav-about': 'Persatuan',
            'nav-members': 'Ahli',
            'nav-events': 'Acara',
            'nav-news': 'Berita & Sumber',
            'nav-partners': 'Rakan Kongsi',

            'btn-signin': 'Daftar Masuk',
            'btn-join': 'Sertai MPA',
            
            // Hero Section
            'hero-title': 'Untuk Masa Depan Pasaran Hartanah yang Mampan',
            'hero-subtitle': 'Persatuan Teknologi Hartanah Malaysia - Memimpin Transformasi Digital Industri Hartanah di Malaysia melalui inovasi, kerjasama, dan pertumbuhan mampan. Membina komuniti yang kuat dengan integriti, inklusiviti, dan kesaksamaan.',
            'search-placeholder': 'Cari acara, ahli, atau sumber...',
            'search-btn': 'Cari',
            'stat-members': 'Ahli',
            'stat-events': 'Acara',
            'stat-startups': 'Syarikat Permulaan',
            'stat-partners': 'Rakan Kongsi',
            
            // Events Section
            'events-title': 'Acara Akan Datang',
            'view-all-events': 'Lihat semua acara',
            'event-featured': 'Terserlah',
            'event-free': 'Percuma untuk Ahli',
            'btn-register': 'Daftar',

            
            // About Section
            'about-title': 'Tentang MPA',
            'about-text-1': 'Persatuan Teknologi Hartanah Malaysia (MPA) adalah organisasi terkemuka yang memacu inovasi dalam sektor teknologi hartanah Malaysia. Kami menghimpunkan syarikat permulaan, syarikat yang mantap, pelabur, dan agensi kerajaan untuk mempercepatkan transformasi digital hartanah.',
            'about-text-2': 'Misi kami adalah untuk memupuk pasaran hartanah yang mampan melalui inovasi teknologi, kerjasama, dan pembinaan komuniti. Kami percaya kepada integriti, inklusiviti, dan kesaksamaan untuk semua ahli kami.',
            'feature-community': 'Komuniti',
            'feature-community-desc': 'Berhubung dengan 150+ profesional PropTech',
            'feature-innovation': 'Inovasi',
            'feature-innovation-desc': 'Memacu penyelesaian PropTech terkini',
            'feature-global': 'Rangkaian Global',
            'feature-global-desc': 'Akses ekosistem PropTech antarabangsa',
            
            // Membership Section
            'membership-title': 'Sertai Komuniti Kami',
            'membership-subtitle': 'Pilih keahlian yang sesuai dengan keperluan anda',
            'membership-startup': 'Syarikat Permulaan',
            'membership-professional': 'Profesional',
            'membership-enterprise': 'Syarikat',
            'membership-year': '/tahun',
            'benefit-events': 'Akses kepada semua acara',
            'benefit-directory': 'Direktori ahli',
            'benefit-newsletter': 'Langganan surat berita',
            'benefit-resources': 'Perpustakaan sumber',
            'benefit-priority': 'Pendaftaran acara keutamaan',
            'benefit-networking': 'Peluang rangkaian',
            'benefit-mentorship': 'Program mentor',
            'benefit-speaking': 'Peluang bercakap',
            'benefit-workshops': 'Bengkel tersuai',
            'benefit-advisory': 'Nasihat lembaga',
            'benefit-all-startup': 'Semua faedah Syarikat Permulaan',
            'benefit-all-professional': 'Semua faedah Profesional',
            'btn-join-now': 'Sertai Sekarang',
            
            // Newsletter Section
            'newsletter-title': 'Kekal Dikemas Kini',
            'newsletter-subtitle': 'Dapatkan berita PropTech terkini, acara, dan pandangan yang dihantar ke peti mel anda',
            'newsletter-placeholder': 'Masukkan alamat e-mel anda',
            'btn-subscribe': 'Langgan',
            
            // Footer
            'footer-mpa-desc': 'Komuniti PropTech terkemuka Malaysia yang memacu inovasi dalam teknologi hartanah.',
            'footer-quick-links': 'Pautan Pantas',
            'footer-about': 'Tentang Kami',
            'footer-membership': 'Keahlian',
            'footer-events': 'Acara',
            'footer-news': 'Berita',
            'footer-contact': 'Hubungi',
            'footer-copyright': '© 2025 Persatuan Teknologi Hartanah Malaysia. Hak cipta terpelihara.',
            
            // Privacy Policy
            'privacy-title': 'Dasar Privasi',
            'privacy-subtitle': 'Melindungi data peribadi anda dan memastikan ketelusan dalam cara kami mengendalikan maklumat anda',
            'download-policy': 'Muat Turun Dasar Privasi',
            'download-description': 'Muat turun dasar privasi dalam bahasa pilihan anda',
            'download-english': 'PDF Bahasa Inggeris',
            'download-bahasa': 'PDF Bahasa Malaysia',
            'privacy-intro-title': 'Pengenalan',
            'privacy-intro-text': 'Persatuan Teknologi Hartanah Malaysia ("MPA", "kami") komited untuk melindungi data peribadi anda selaras dengan Akta Perlindungan Data Peribadi 2010 ("PDPA") dan pindaan 2024. Dasar ini menerangkan bagaimana kami mengumpul, menggunakan, mendedahkan dan melindungi data peribadi anda apabila anda berinteraksi dengan laman web, portal keahlian, acara, atau perkhidmatan kami.',
            'privacy-data-title': 'Jenis Data Peribadi yang Dikumpul',
            'privacy-data-intro': 'Kami mungkin mengumpul dan memproses kategori data berikut:',
            'privacy-identity': 'Data Identiti:',
            'privacy-identity-details': 'Nama Penuh, Nombor NRIC / Pasport, Tarikh Lahir',
            'privacy-contact': 'Data Hubungan:',
            'privacy-contact-details': 'Alamat Emel, Nombor Telefon, Alamat Surat-Menyurat',
            'privacy-professional': 'Data Profesional:',
            'privacy-professional-details': 'Nama Syarikat, Jawatan, Sektor Industri',
            'privacy-membership': 'Data Keahlian:',
            'privacy-membership-details': 'Jenis Keahlian, Sejarah Permohonan, Penyertaan Acara',
            'privacy-technical': 'Data Teknikal:',
            'privacy-technical-details': 'Alamat IP, Jenis Pelayar, Maklumat Peranti, Kuki',
            'privacy-purpose-title': 'Tujuan Pengumpulan',
            'privacy-purpose-intro': 'Data peribadi anda dikumpul untuk tujuan berikut:',
            'privacy-purpose-1': 'Memproses permohonan dan pembaharuan keahlian',
            'privacy-purpose-2': 'Mengurus profil ahli dan menyediakan kandungan eksklusif',
            'privacy-purpose-3': 'Menghantar buletin, kemas kini dan jemputan acara',
            'privacy-purpose-4': 'Memudahkan penyertaan dalam pertandingan, bengkel dan forum',
            'privacy-purpose-5': 'Mematuhi keperluan undang-undang dan peraturan',
            'privacy-consent-title': 'Persetujuan dan Akses',
            'privacy-consent-text': 'Dengan menyerahkan data peribadi anda, anda memberikan persetujuan untuk pemprosesan bagi tujuan yang dinyatakan. Anda boleh menarik balik persetujuan atau meminta akses, pembetulan, atau pemadaman data dengan menghubungi Pegawai Perlindungan Data (DPO) kami di:',
            'privacy-dpo-name': 'Nama:',
            'privacy-dpo-email': 'Emel:',
            'privacy-dpo-contact': 'Hubungi:',
            'privacy-rights-title': 'Hak Anda',
            'privacy-rights-intro': 'Di bawah PDPA, anda berhak untuk:',
            'privacy-rights-1': 'Mengakses dan membetulkan data peribadi anda',
            'privacy-rights-2': 'Menarik balik persetujuan bila-bila masa',
            'privacy-rights-3': 'Membuat aduan kepada Jabatan Perlindungan Data Peribadi (JPDP)',
            'privacy-updates-title': 'Kemas Kini Dasar',
            'privacy-updates-text': 'Dasar ini mungkin dikemas kini dari semasa ke semasa. Sebarang perubahan akan dipaparkan di laman web kami dengan tarikh berkuat kuasa yang jelas.',
            
            // Cookie Banner
            'cookie-title': 'Notis Kuki & Privasi',
            'cookie-text': 'Kami menggunakan kuki dan teknologi serupa untuk meningkatkan pengalaman melayari anda, menganalisis trafik laman web, dan menyesuaikan kandungan. Dengan terus menggunakan laman web kami, anda bersetuju dengan penggunaan kuki kami mengikut Dasar Privasi kami.',
            'accept-cookies': 'Terima Semua',
            'reject-cookies': 'Tolak',
            'learn-more': 'Ketahui Lebih Lanjut'
        },
        cn: {
            // Navigation
            'nav-proptech': 'Proptech',
            'nav-about': '协会',
            'nav-members': '会员',
            'nav-events': '活动',
            'nav-news': '新闻与资源',
            'nav-partners': '合作伙伴',

            'btn-signin': '登录',
            'btn-join': '加入MPA',
            
            // Hero Section
            'hero-title': '为可持续房地产市场的未来',
            'hero-subtitle': '马来西亚房地产科技协会 - 通过创新、协作和可持续增长，引领马来西亚房地产行业的数字化转型。以诚信、包容性和平等性建立强大社区。',
            'search-placeholder': '查找活动、会员或资源...',
            'search-btn': '搜索',
            'stat-members': '会员',
            'stat-events': '活动',
            'stat-startups': '初创企业',
            'stat-partners': '合作伙伴',
            
            // Events Section
            'events-title': '即将举行的活动',
            'view-all-events': '查看所有活动',
            'event-featured': '精选',
            'event-free': '会员免费',
            'btn-register': '注册',
            'event-summit-title': 'PropTech峰会2024',
            'event-summit-desc': '加入行业领袖，参加马来西亚最大的PropTech活动。包括主题演讲、小组讨论和网络机会。',
            'event-ai-title': '房地产AI网络研讨会',
            'event-ai-desc': '探索AI在房地产技术中的未来应用以及它如何改变行业。',
            'event-pitch-title': '初创企业路演比赛',
            'event-pitch-desc': '向投资者和导师展示您的PropTech创新。赢得资金和指导机会。',
            
            // About Section
            'about-title': '关于MPA',
            'about-text-1': '马来西亚房地产科技协会（MPA）是推动马来西亚房地产科技领域创新的领先组织。我们汇集初创企业、成熟公司、投资者和政府机构，加速房地产的数字化转型。',
            'about-text-2': '我们的使命是通过技术创新、协作和社区建设来培育可持续的房地产市场。我们相信所有会员的诚信、包容性和平等性。',
            'feature-community': '社区',
            'feature-community-desc': '与150+房地产科技专业人士联系',
            'feature-innovation': '创新',
            'feature-innovation-desc': '推动尖端房地产科技解决方案',
            'feature-global': '全球网络',
            'feature-global-desc': '访问国际房地产科技生态系统',
            
            // Membership Section
            'membership-title': '加入我们的社区',
            'membership-subtitle': '选择适合您需求的会员资格',
            'membership-startup': '初创企业',
            'membership-professional': '专业',
            'membership-enterprise': '企业',
            'membership-year': '/年',
            'benefit-events': '参加所有活动',
            'benefit-directory': '会员目录',
            'benefit-newsletter': '订阅通讯',
            'benefit-resources': '资源库',
            'benefit-priority': '优先活动注册',
            'benefit-networking': '网络机会',
            'benefit-mentorship': '导师计划',
            'benefit-speaking': '演讲机会',
            'benefit-workshops': '定制工作坊',
            'benefit-advisory': '董事会咨询',
            'benefit-all-startup': '所有初创企业福利',
            'benefit-all-professional': '所有专业会员福利',
            'btn-join-now': '立即加入',
            
            // Newsletter Section
            'newsletter-title': '保持更新',
            'newsletter-subtitle': '获取最新的房地产科技新闻、活动和见解，直接发送到您的收件箱',
            'newsletter-placeholder': '输入您的电子邮件地址',
            'btn-subscribe': '订阅',
            
            // Footer
            'footer-mpa-desc': '马来西亚领先的房地产科技社区，推动房地产技术创新。',
            'footer-quick-links': '快速链接',
            'footer-about': '关于我们',
            'footer-membership': '会员资格',
            'footer-events': '活动',
            'footer-news': '新闻',
            'footer-contact': '联系我们',
            'footer-copyright': '© 2025 马来西亚房地产科技协会。保留所有权利。',
            
            // Privacy Policy
            'privacy-title': '隐私政策',
            'privacy-subtitle': '保护您的个人数据并确保我们处理您信息的透明度',
            'download-policy': '下载隐私政策',
            'download-description': '下载您首选语言的隐私政策',
            'download-english': '英文PDF',
            'download-bahasa': '马来文PDF',
            
            // Cookie Banner
            'cookie-title': 'Cookie和隐私通知',
            'cookie-text': '我们使用cookie和类似技术来增强您的浏览体验、分析网站流量并个性化内容。继续使用我们的网站即表示您同意我们根据隐私政策使用cookie。',
            'accept-cookies': '全部接受',
            'reject-cookies': '拒绝',
            'learn-more': '了解更多'
        }
    };

    function selectLanguage(lang) {
        // Update current language display
        const currentLanguage = document.querySelector('.current-language');
        if (currentLanguage) {
            currentLanguage.textContent = lang.toUpperCase();
        }
        
        // Update active states
        document.querySelectorAll('.language-option').forEach(option => {
            option.classList.remove('active');
        });
        const activeOption = document.querySelector(`[data-lang="${lang}"]`);
        if (activeOption) {
            activeOption.classList.add('active');
        }
        
        // Update mobile language options
        document.querySelectorAll('.mobile-language-option').forEach(option => {
            option.classList.remove('active');
        });
        const activeMobileOption = document.querySelector(`.mobile-language-option[data-lang="${lang}"]`);
        if (activeMobileOption) {
            activeMobileOption.classList.add('active');
        }
        
        // Close dropdown
        const languageDropdown = document.querySelector('.language-dropdown');
        if (languageDropdown) {
            languageDropdown.classList.remove('active');
        }
        
        // Store language preference
        localStorage.setItem('selectedLanguage', lang);
        
        // Apply translations with retry mechanism
        applyTranslationsWithRetry(lang);
        
        // Update PDF on privacy policy page
        console.log('selectLanguage called with lang:', lang, 'pathname:', window.location.pathname); // Debug
        if ((window.location.pathname.includes('privacy-policy') || window.location.href.includes('privacy-policy')) && typeof updatePrivacyPolicyPDF === 'function') {
            console.log('Calling updatePrivacyPolicyPDF with lang:', lang); // Debug
            updatePrivacyPolicyPDF(lang);
        } else {
            console.log('Not calling updatePrivacyPolicyPDF - condition not met'); // Debug
        }
    }
    
    // Expose selectLanguage globally for header component integration
    window.selectLanguage = selectLanguage;

    function applyTranslationsWithRetry(lang, retryCount = 0) {
        const maxRetries = 3;
        
        try {
            applyTranslations(lang);
        } catch (error) {
    
            if (retryCount < maxRetries) {
                setTimeout(() => {
                    applyTranslationsWithRetry(lang, retryCount + 1);
                }, 200);
            } else {
                console.error('Failed to apply translations after maximum retries');
            }
        }
    }

    function applyTranslations(lang) {
        const t = translations[lang];
        if (!t) return;

        // Navigation translations
        document.querySelectorAll('.nav-link').forEach(link => {
            const href = link.getAttribute('href');
            if (href === 'proptech.html') link.textContent = t['nav-proptech'];
            else if (href === 'about.html') link.textContent = t['nav-about'];
            else if (href === 'members.html') link.textContent = t['nav-members'];
            else if (href === 'events.html') link.textContent = t['nav-events'];
            else if (href === 'news.html') link.textContent = t['nav-news'];
            else if (href === 'partners.html') link.textContent = t['nav-partners'];
            else if (href === 'contact.html') link.textContent = t['nav-contact'];
        });

        // Mobile navigation translations
        document.querySelectorAll('.mobile-dropdown-link').forEach(link => {
            const href = link.getAttribute('href');
            const span = link.querySelector('span');
            if (span) {
                if (href === 'proptech.html') span.textContent = t['nav-proptech'];
                else if (href === 'about.html') span.textContent = t['nav-about'];
                else if (href === 'members.html') span.textContent = t['nav-members'];
                else if (href === 'events.html') span.textContent = t['nav-events'];
                else if (href === 'news.html') span.textContent = t['nav-news'];
                else if (href === 'partners.html') span.textContent = t['nav-partners'];
                else if (href === 'contact.html') span.textContent = t['nav-contact'];
            }
        });

        // Navigation buttons translations - use data attributes for reliable translation
        const signInBtns = document.querySelectorAll('[data-translate="btn-signin"]');
        const joinBtns = document.querySelectorAll('[data-translate="btn-join"]');
        

        
        // Update all Sign In buttons
        signInBtns.forEach(btn => {
            btn.textContent = t['btn-signin'];
        });
        
        // Update all Join MPA buttons
        joinBtns.forEach(btn => {
            btn.textContent = t['btn-join'];
        });

        // Hero section translations
        const heroTitle = document.querySelector('.hero-title');
        const heroSubtitle = document.querySelector('.hero-subtitle');
        const searchPlaceholder = document.querySelector('.search-input input');
        const searchBtn = document.querySelector('.search-btn');
        
        if (heroTitle) heroTitle.textContent = t['hero-title'];
        if (heroSubtitle) heroSubtitle.textContent = t['hero-subtitle'];
        if (searchPlaceholder) searchPlaceholder.placeholder = t['search-placeholder'];
        if (searchBtn) searchBtn.textContent = t['search-btn'];

        // Stats translations
        const statLabels = document.querySelectorAll('.stat-label');
        if (statLabels.length >= 4) {
            statLabels[0].textContent = t['stat-members'];
            statLabels[1].textContent = t['stat-events'];
            statLabels[2].textContent = t['stat-startups'];
            statLabels[3].textContent = t['stat-partners'];
        }

        // Events section translations
        const eventsTitle = document.querySelector('.featured-events h2');
        const viewAllEvents = document.querySelector('.view-all');
        if (eventsTitle) eventsTitle.textContent = t['events-title'];
        if (viewAllEvents) viewAllEvents.textContent = t['view-all-events'];

        // Event cards translations - removed hardcoded event overrides
        const registerButtons = document.querySelectorAll('.event-footer .btn-outline');
        
        registerButtons.forEach(btn => {
            if (btn.textContent === 'Register') {
                btn.textContent = t['btn-register'];
            }
        });

        // About section translations
        const aboutTitle = document.querySelector('#about h2');
        const aboutTexts = document.querySelectorAll('#about p');
        if (aboutTitle) aboutTitle.textContent = t['about-title'];
        if (aboutTexts.length >= 2) {
            aboutTexts[0].textContent = t['about-text-1'];
            aboutTexts[1].textContent = t['about-text-2'];
        }

        // Features translations
        const features = document.querySelectorAll('#about .feature h4');
        const featureDescs = document.querySelectorAll('#about .feature p');
        if (features.length >= 3) {
            features[0].textContent = t['feature-community'];
            features[1].textContent = t['feature-innovation'];
            features[2].textContent = t['feature-global'];
        }
        if (featureDescs.length >= 3) {
            featureDescs[0].textContent = t['feature-community-desc'];
            featureDescs[1].textContent = t['feature-innovation-desc'];
            featureDescs[2].textContent = t['feature-global-desc'];
        }

        // Membership section translations
        const membershipTitle = document.querySelector('#membership h2');
        const membershipSubtitle = document.querySelector('#membership .section-header p');
        if (membershipTitle) membershipTitle.textContent = t['membership-title'];
        if (membershipSubtitle) membershipSubtitle.textContent = t['membership-subtitle'];

        // Membership benefits translations
        const benefitItems = document.querySelectorAll('.benefits li');
        benefitItems.forEach(item => {
            const text = item.textContent.trim();
            if (text.includes('Access to all events')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-events']}`;
            } else if (text.includes('Member directory')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-directory']}`;
            } else if (text.includes('Newsletter subscription')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-newsletter']}`;
            } else if (text.includes('Resource library')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-resources']}`;
            } else if (text.includes('All Startup benefits')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-all-startup']}`;
            } else if (text.includes('Priority event registration')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-priority']}`;
            } else if (text.includes('Networking opportunities')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-networking']}`;
            } else if (text.includes('Mentorship program')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-mentorship']}`;
            } else if (text.includes('All Professional benefits')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-all-professional']}`;
            } else if (text.includes('Speaking opportunities')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-speaking']}`;
            } else if (text.includes('Custom workshops')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-workshops']}`;
            } else if (text.includes('Board advisory')) {
                item.innerHTML = `<i class="fas fa-check"></i> ${t['benefit-advisory']}`;
            }
        });

        // Join Now buttons
        const joinNowButtons = document.querySelectorAll('.membership-card .btn-primary');
        joinNowButtons.forEach(btn => {
            if (btn.textContent === 'Join Now') {
                btn.textContent = t['btn-join-now'];
            }
        });

        // Newsletter section translations
        const newsletterTitle = document.querySelector('.newsletter h2');
        const newsletterSubtitle = document.querySelector('.newsletter p');
        const newsletterPlaceholder = document.querySelector('.newsletter-form input');
        const subscribeBtn = document.querySelector('.newsletter-form .btn-primary');
        if (newsletterTitle) newsletterTitle.textContent = t['newsletter-title'];
        if (newsletterSubtitle) newsletterSubtitle.textContent = t['newsletter-subtitle'];
        if (newsletterPlaceholder) newsletterPlaceholder.placeholder = t['newsletter-placeholder'];
        if (subscribeBtn) subscribeBtn.textContent = t['btn-subscribe'];

        // Footer translations
        const footerDesc = document.querySelector('.footer-section p');
        const footerLinks = document.querySelectorAll('.footer-section h4');
        const footerCopyright = document.querySelector('.footer-bottom p');
        if (footerDesc) footerDesc.textContent = t['footer-mpa-desc'];
        if (footerCopyright) footerCopyright.textContent = t['footer-copyright'];

        // Privacy Policy translations
        const privacyTitle = document.querySelector('[data-translate="privacy-title"]');
        const privacySubtitle = document.querySelector('[data-translate="privacy-subtitle"]');
        const downloadPolicy = document.querySelector('[data-translate="download-policy"]');
        const downloadDescription = document.querySelector('[data-translate="download-description"]');
        const downloadEnglish = document.querySelector('[data-translate="download-english"]');
        const downloadBahasa = document.querySelector('[data-translate="download-bahasa"]');
        
        if (privacyTitle) privacyTitle.textContent = t['privacy-title'];
        if (privacySubtitle) privacySubtitle.textContent = t['privacy-subtitle'];
        if (downloadPolicy) downloadPolicy.textContent = t['download-policy'];
        if (downloadDescription) downloadDescription.textContent = t['download-description'];
        if (downloadEnglish) downloadEnglish.textContent = t['download-english'];
        if (downloadBahasa) downloadBahasa.textContent = t['download-bahasa'];

        // Privacy Policy content translations
        const privacyIntroTitle = document.querySelector('[data-translate="privacy-intro-title"]');
        const privacyIntroText = document.querySelector('[data-translate="privacy-intro-text"]');
        const privacyDataTitle = document.querySelector('[data-translate="privacy-data-title"]');
        const privacyDataIntro = document.querySelector('[data-translate="privacy-data-intro"]');
        
        if (privacyIntroTitle) privacyIntroTitle.textContent = t['privacy-intro-title'];
        if (privacyIntroText) privacyIntroText.textContent = t['privacy-intro-text'];
        if (privacyDataTitle) privacyDataTitle.textContent = t['privacy-data-title'];
        if (privacyDataIntro) privacyDataIntro.textContent = t['privacy-data-intro'];

        // Privacy Policy data types
        const privacyIdentity = document.querySelector('[data-translate="privacy-identity"]');
        const privacyIdentityDetails = document.querySelector('[data-translate="privacy-identity-details"]');
        const privacyContact = document.querySelector('[data-translate="privacy-contact"]');
        const privacyContactDetails = document.querySelector('[data-translate="privacy-contact-details"]');
        const privacyProfessional = document.querySelector('[data-translate="privacy-professional"]');
        const privacyProfessionalDetails = document.querySelector('[data-translate="privacy-professional-details"]');
        const privacyMembership = document.querySelector('[data-translate="privacy-membership"]');
        const privacyMembershipDetails = document.querySelector('[data-translate="privacy-membership-details"]');
        const privacyTechnical = document.querySelector('[data-translate="privacy-technical"]');
        const privacyTechnicalDetails = document.querySelector('[data-translate="privacy-technical-details"]');
        
        if (privacyIdentity) privacyIdentity.textContent = t['privacy-identity'];
        if (privacyIdentityDetails) privacyIdentityDetails.textContent = t['privacy-identity-details'];
        if (privacyContact) privacyContact.textContent = t['privacy-contact'];
        if (privacyContactDetails) privacyContactDetails.textContent = t['privacy-contact-details'];
        if (privacyProfessional) privacyProfessional.textContent = t['privacy-professional'];
        if (privacyProfessionalDetails) privacyProfessionalDetails.textContent = t['privacy-professional-details'];
        if (privacyMembership) privacyMembership.textContent = t['privacy-membership'];
        if (privacyMembershipDetails) privacyMembershipDetails.textContent = t['privacy-membership-details'];
        if (privacyTechnical) privacyTechnical.textContent = t['privacy-technical'];
        if (privacyTechnicalDetails) privacyTechnicalDetails.textContent = t['privacy-technical-details'];

        // Privacy Policy purpose section
        const privacyPurposeTitle = document.querySelector('[data-translate="privacy-purpose-title"]');
        const privacyPurposeIntro = document.querySelector('[data-translate="privacy-purpose-intro"]');
        const privacyPurpose1 = document.querySelector('[data-translate="privacy-purpose-1"]');
        const privacyPurpose2 = document.querySelector('[data-translate="privacy-purpose-2"]');
        const privacyPurpose3 = document.querySelector('[data-translate="privacy-purpose-3"]');
        const privacyPurpose4 = document.querySelector('[data-translate="privacy-purpose-4"]');
        const privacyPurpose5 = document.querySelector('[data-translate="privacy-purpose-5"]');
        
        if (privacyPurposeTitle) privacyPurposeTitle.textContent = t['privacy-purpose-title'];
        if (privacyPurposeIntro) privacyPurposeIntro.textContent = t['privacy-purpose-intro'];
        if (privacyPurpose1) privacyPurpose1.textContent = t['privacy-purpose-1'];
        if (privacyPurpose2) privacyPurpose2.textContent = t['privacy-purpose-2'];
        if (privacyPurpose3) privacyPurpose3.textContent = t['privacy-purpose-3'];
        if (privacyPurpose4) privacyPurpose4.textContent = t['privacy-purpose-4'];
        if (privacyPurpose5) privacyPurpose5.textContent = t['privacy-purpose-5'];

        // Privacy Policy consent section
        const privacyConsentTitle = document.querySelector('[data-translate="privacy-consent-title"]');
        const privacyConsentText = document.querySelector('[data-translate="privacy-consent-text"]');
        const privacyDpoName = document.querySelector('[data-translate="privacy-dpo-name"]');
        const privacyDpoEmail = document.querySelector('[data-translate="privacy-dpo-email"]');
        const privacyDpoContact = document.querySelector('[data-translate="privacy-dpo-contact"]');
        
        if (privacyConsentTitle) privacyConsentTitle.textContent = t['privacy-consent-title'];
        if (privacyConsentText) privacyConsentText.textContent = t['privacy-consent-text'];
        if (privacyDpoName) privacyDpoName.textContent = t['privacy-dpo-name'];
        if (privacyDpoEmail) privacyDpoEmail.textContent = t['privacy-dpo-email'];
        if (privacyDpoContact) privacyDpoContact.textContent = t['privacy-dpo-contact'];

        // Privacy Policy rights section
        const privacyRightsTitle = document.querySelector('[data-translate="privacy-rights-title"]');
        const privacyRightsIntro = document.querySelector('[data-translate="privacy-rights-intro"]');
        const privacyRights1 = document.querySelector('[data-translate="privacy-rights-1"]');
        const privacyRights2 = document.querySelector('[data-translate="privacy-rights-2"]');
        const privacyRights3 = document.querySelector('[data-translate="privacy-rights-3"]');
        
        if (privacyRightsTitle) privacyRightsTitle.textContent = t['privacy-rights-title'];
        if (privacyRightsIntro) privacyRightsIntro.textContent = t['privacy-rights-intro'];
        if (privacyRights1) privacyRights1.textContent = t['privacy-rights-1'];
        if (privacyRights2) privacyRights2.textContent = t['privacy-rights-2'];
        if (privacyRights3) privacyRights3.textContent = t['privacy-rights-3'];

        // Privacy Policy updates section
        const privacyUpdatesTitle = document.querySelector('[data-translate="privacy-updates-title"]');
        const privacyUpdatesText = document.querySelector('[data-translate="privacy-updates-text"]');
        
        if (privacyUpdatesTitle) privacyUpdatesTitle.textContent = t['privacy-updates-title'];
        if (privacyUpdatesText) privacyUpdatesText.textContent = t['privacy-updates-text'];

        // Cookie Banner translations
        const cookieTitle = document.querySelector('[data-translate="cookie-title"]');
        const cookieText = document.querySelector('[data-translate="cookie-text"]');
        const acceptCookies = document.querySelector('[data-translate="accept-cookies"]');
        const rejectCookies = document.querySelector('[data-translate="reject-cookies"]');
        const learnMore = document.querySelector('[data-translate="learn-more"]');
        
        if (cookieTitle) cookieTitle.textContent = t['cookie-title'];
        if (cookieText) cookieText.textContent = t['cookie-text'];
        if (acceptCookies) acceptCookies.textContent = t['accept-cookies'];
        if (rejectCookies) rejectCookies.textContent = t['reject-cookies'];
        if (learnMore) learnMore.textContent = t['learn-more'];
    }

    if (languageToggle) {
        languageToggle.addEventListener('click', toggleLanguageMenu);
    }

    // Language option click handlers
    document.querySelectorAll('.language-option').forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            console.log('Language option clicked:', lang); // Debug
            selectLanguage(lang);
        });
    });

    // Mobile language option click handlers
    document.querySelectorAll('.mobile-language-option').forEach(option => {
        option.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            selectLanguage(lang);
        });
    });

    // Smooth Scrolling for Navigation Links (only for same-page links)
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            // Check if it's a same-page link (starts with #)
            if (targetId.startsWith('#')) {
                e.preventDefault();
                const targetSection = document.querySelector(targetId);
                
                if (targetSection) {
                    const offsetTop = targetSection.offsetTop - 80; // Account for fixed navbar
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (mobileDropdownMenu && mobileDropdownMenu.classList.contains('active')) {
                        closeMobileMenu();
                    }
                }
            }
            // For external page links (like about.html, events.html), let them work normally
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mobileDropdownMenu && mobileDropdownMenu.classList.contains('active') && 
            !mobileDropdownMenu.contains(e.target) && 
            mobileMenuToggle && !mobileMenuToggle.contains(e.target)) {
            closeMobileMenu();
        }
        
        if (languageDropdown && !languageDropdown.contains(e.target)) {
            languageDropdown.classList.remove('active');
        }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileDropdownMenu && mobileDropdownMenu.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    // Navbar Background on Scroll
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });

    // Search Functionality - Now handled by individual page scripts
    // Removed to prevent conflicts with new search implementation

    // Newsletter Subscription
    const newsletterForm = document.querySelector('.newsletter-form');
    const newsletterInput = document.querySelector('.newsletter-form input');
    const newsletterBtn = document.querySelector('.newsletter-form .btn-primary');
    
    if (newsletterForm && newsletterInput && newsletterBtn) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = newsletterInput.value.trim();
            if (email && isValidEmail(email)) {
                // Implement newsletter subscription here
        
                showNotification('Thank you for subscribing to our newsletter!', 'success');
                newsletterInput.value = '';
            } else {
                showNotification('Please enter a valid email address.', 'warning');
            }
        });
    }

    // Event Registration Buttons
    const eventButtons = document.querySelectorAll('.event-card .btn-outline');
    
    eventButtons.forEach(button => {
        button.addEventListener('click', function() {
            const eventTitle = this.closest('.event-card').querySelector('.event-title').textContent;
            // Implement event registration here
    
            showNotification(`Registration for "${eventTitle}" will be implemented here.`, 'info');
        });
    });

    // Membership Join Buttons - Now handled by links to join.html
    // Removed pop-up functionality since buttons are now proper links

    // Navigation Join MPA Buttons
    const navJoinButtons = document.querySelectorAll('.nav-actions .btn-primary');

    navJoinButtons.forEach(button => {
        button.addEventListener('click', function() {
            window.location.href = 'membership.html';
        });
    });

    // Click Ripple Effect for all buttons
    const allButtons = document.querySelectorAll('.btn-primary, .btn-secondary, .btn-outline, .signin-btn, .signup-btn, .search-btn');
    

    allButtons.forEach(button => {
        button.addEventListener('click', function(e) {
    

            // Create multiple concentric ripples for flower-like effect
            const rippleCount = 3;
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            const maxSize = Math.max(viewportWidth, viewportHeight) * 2;

            // Get click position relative to viewport
            const centerX = e.clientX;
            const centerY = e.clientY;

            for (let i = 0; i < rippleCount; i++) {
                setTimeout(() => {
                    createFlowerRipple(centerX, centerY, maxSize, this, i);
                }, i * 380); // More pronounced stagger for enhanced visibility
            }
        });
    });

    function createFlowerRipple(centerX, centerY, maxSize, button, index) {
        const ripple = document.createElement('div');

        // Vary the size slightly for each ripple
        const sizeVariation = 0.8 + (index * 0.2);
        const rippleSize = maxSize * sizeVariation;

        const x = centerX - rippleSize / 2;
        const y = centerY - rippleSize / 2;

        ripple.style.width = ripple.style.height = rippleSize + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('full-page-ripple');

        // Create subtle colors for each ripple (background-appropriate)
        let colors;
        if (document.body.classList.contains('light-mode')) {
            // Light mode - subtle dark ripples
            colors = [
                ['rgba(0, 0, 0, 0.06)', 'rgba(0, 0, 0, 0.04)'],
                ['rgba(0, 0, 0, 0.04)', 'rgba(0, 0, 0, 0.03)'],
                ['rgba(0, 0, 0, 0.03)', 'rgba(0, 0, 0, 0.02)']
            ];
        } else {
            // Dark mode - subtle light ripples
            colors = [
                ['rgba(255, 255, 255, 0.12)', 'rgba(255, 255, 255, 0.08)'],
                ['rgba(255, 255, 255, 0.08)', 'rgba(255, 255, 255, 0.06)'],
                ['rgba(255, 255, 255, 0.06)', 'rgba(255, 255, 255, 0.04)']
            ];
        }

        ripple.style.background = colors[index][0];
        ripple.style.boxShadow = `0 0 0 0 ${colors[index][1]}`;

        // Add to body for full-page effect
        document.body.appendChild(ripple);


        setTimeout(() => {
            ripple.remove();
    
        }, 2800 + (index * 200)); // Staggered cleanup for slower animation
    }

    // Intersection Observer for Animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animateElements = document.querySelectorAll('.event-card, .membership-card, .feature');
    animateElements.forEach(el => observer.observe(el));

    // Utility Functions
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Add loading animation
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });

    // Parallax effect for hero section - REMOVED to prevent expanding behavior

    // Add hover effects for cards
    const cards = document.querySelectorAll('.event-card, .membership-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Form validation for contact forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic form validation
            const inputs = this.querySelectorAll('input[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            
            if (isValid) {
                // Form is valid, implement submission here
                showNotification('Form submitted successfully!', 'success');
                this.reset();
            } else {
                showNotification('Please fill in all required fields.', 'warning');
            }
        });
    });

    // Add smooth reveal animations
    const revealElements = document.querySelectorAll('.section-header, .about-text, .newsletter-content');
    revealElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 200);
    });

    // Event Filtering
    const filterTabs = document.querySelectorAll('.filter-tab');
    const eventCards = document.querySelectorAll('.event-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter events
            eventCards.forEach(card => {
                const categories = card.getAttribute('data-category').split(' ');
                if (filter === 'all' || categories.includes(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // FAQ Accordion
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Toggle answer visibility
            if (answer.style.maxHeight) {
                answer.style.maxHeight = null;
                icon.style.transform = 'rotate(0deg)';
            } else {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Contact Form Validation
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value.trim();
            
            if (!firstName || !lastName || !email || !subject || !message) {
                showNotification('Please fill in all required fields.', 'warning');
                return;
            }
            
            if (!isValidEmail(email)) {
                showNotification('Please enter a valid email address.', 'warning');
                return;
            }
            
            // Simulate form submission
            showNotification('Thank you for your message! We will get back to you soon.', 'success');
            contactForm.reset();
        });
    }

    // Calendar Navigation and Grid
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const currentMonthEl = document.getElementById('currentMonth');
    const calendarGrid = document.getElementById('calendarGrid');
    
    if (prevMonthBtn && nextMonthBtn && currentMonthEl && calendarGrid) {
        console.log('Calendar functionality initialized');
    } else {
        console.log('Calendar elements not found - calendar functionality disabled');
        return; // Exit early if calendar elements don't exist
    }
    
    if (prevMonthBtn && nextMonthBtn && currentMonthEl && calendarGrid) {
            // Use actual current date
            const today = new Date();
            let currentDate = new Date(today.getFullYear(), today.getMonth(), 1); // First day of current month
            
            // Debug: Log the current date to console
            
        
        // Events data will be loaded from WordPress database
        let events = [];
        
        // Load events from WordPress
        async function loadEvents() {
            try {
                const response = await fetch('/wp-content/themes/mpa-custom/get-events-json.php');
                events = await response.json();
                console.log('Loaded events:', events);
                // Refresh calendar after loading events
                renderCalendar();
            } catch (error) {
                console.error('Failed to load events:', error);
                // Still render calendar even if events fail to load
                renderCalendar();
            }
        }
        
        // Load events when page loads
        loadEvents();
        
        // Initial calendar render will happen after events are loaded
        // No need for setTimeout here since loadEvents() will trigger renderCalendar()
        
        function getISOWeekNumber(date) {
            const d = new Date(date);
            d.setHours(0, 0, 0, 0);
            // Thursday in current week decides the year
            d.setDate(d.getDate() + 3 - (d.getDay() + 6) % 7);
            // January 4 is always in week 1
            const week1 = new Date(d.getFullYear(), 0, 4);
            // Adjust to Thursday in week 1 and count number of weeks from date to week1
            return 1 + Math.round(((d.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
        }
        
        async function getPublicHolidays(year, month) {
            try {
                const response = await fetch(`https://date.nager.at/api/v3/PublicHolidays/${year}/MY`);
                const allHolidays = await response.json();
                
                // Filter holidays for current month
                const monthHolidays = allHolidays.filter(holiday => {
                    const holidayDate = new Date(holiday.date);
                    return holidayDate.getMonth() === month;
                });
                
                return monthHolidays.map(holiday => {
                    const date = new Date(holiday.date);
                    const dateString = date.toLocaleDateString('en-US', { 
                        month: 'short', 
                        day: 'numeric' 
                    });
                    return {
                        date: dateString,
                        name: holiday.localName || holiday.name
                    };
                });
            } catch (error) {
                console.error('Error fetching holidays:', error);
                // Fallback to static data if API fails
                return getStaticHolidays(year, month);
            }
        }
        
        function getStaticHolidays(year, month) {
            const holidays = [];
            
            // Malaysia Public Holidays 2025 (fallback data)
            const allHolidays = [
                { month: 0, day: 1, name: "New Year's Day" },
                { month: 1, day: 1, name: "Chinese New Year" },
                { month: 1, day: 2, name: "Chinese New Year Holiday" },
                { month: 4, day: 1, name: "Labour Day" },
                { month: 4, day: 22, name: "Hari Raya Aidilfitri" },
                { month: 4, day: 23, name: "Hari Raya Aidilfitri Holiday" },
                { month: 5, day: 7, name: "Wesak Day" },
                { month: 6, day: 28, name: "Hari Raya Haji" },
                { month: 7, day: 31, name: "National Day" },
                { month: 8, day: 16, name: "Malaysia Day" },
                { month: 9, day: 6, name: "Prophet Muhammad's Birthday" },
                { month: 10, day: 5, name: "Deepavali" },
                { month: 11, day: 25, name: "Christmas Day" }
            ];
            
            // Filter holidays for current month
            const monthHolidays = allHolidays.filter(holiday => holiday.month === month);
            
            monthHolidays.forEach(holiday => {
                const date = new Date(year, month, holiday.day);
                const dateString = date.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric' 
                });
                holidays.push({
                    date: dateString,
                    name: holiday.name
                });
            });
            
            return holidays;
        }
        
        async function loadPublicHolidays(year, month) {
            const holidaysContainer = document.getElementById('publicHolidays');
            if (!holidaysContainer) return;
            
            try {
                const holidays = await getPublicHolidays(year, month);
                
                if (holidays.length > 0) {
                    holidaysContainer.innerHTML = holidays.map(holiday => `
                        <div class="public-holiday">
                            <span class="date">${holiday.date}</span>
                            <span class="holiday-name">${holiday.name}</span>
                        </div>
                    `).join('');
                    
                    // Mark holidays on calendar with red dots
                    holidays.forEach(holiday => {
                        const dateParts = holiday.date.split(' ');
                        const monthName = dateParts[0];
                        const day = parseInt(dateParts[1]);
                        
                        // Convert month name to number
                        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        const monthIndex = monthNames.indexOf(monthName);
                        
                        if (monthIndex === month) {
                            const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                            const holidayIndicator = document.getElementById(`holiday-${dateString}`);
                            if (holidayIndicator) {
                                holidayIndicator.style.display = 'block';
                                holidayIndicator.title = holiday.name;
                            }
                        }
                    });
                } else {
                    holidaysContainer.innerHTML = '<div class="no-holidays">No public holidays this month</div>';
                }
            } catch (error) {
                console.error('Error loading holidays:', error);
                holidaysContainer.innerHTML = '<div class="error">Unable to load holidays</div>';
            }
        }
        
        function renderCalendar() {
            console.log('Rendering calendar for:', currentDate.getMonth() + 1, currentDate.getFullYear());
            console.log('Available events:', events);
            
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                               'July', 'August', 'September', 'October', 'November', 'December'];
            
            currentMonthEl.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
            
            // Debug: Log what month/year is being rendered
    
            
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDay = firstDay.getDay();
            
            // Debug: Log the first day calculation
            
            
            // Adjust starting day for Monday-first week
            // JavaScript getDay(): 0=Sunday, 1=Monday, 2=Tuesday, 3=Wednesday, 4=Thursday, 5=Friday, 6=Saturday
            // Our Monday-first order: 0=Monday, 1=Tuesday, 2=Wednesday, 3=Thursday, 4=Friday, 5=Saturday, 6=Sunday
            let adjustedStartingDay;
            if (startingDay === 0) { // Sunday
                adjustedStartingDay = 6; // Sunday becomes last column
            } else {
                adjustedStartingDay = startingDay - 1; // Monday=1 becomes 0, Tuesday=2 becomes 1, etc.
            }
            
    
            
            // Create calendar grid with weekday headers as the first row
            let calendarHTML = `
                <div class="calendar-days">
                    <div class="calendar-day weekday-header">W</div>
                    <div class="calendar-day weekday-header">Mon</div>
                    <div class="calendar-day weekday-header">Tue</div>
                    <div class="calendar-day weekday-header">Wed</div>
                    <div class="calendar-day weekday-header">Thu</div>
                    <div class="calendar-day weekday-header">Fri</div>
                    <div class="calendar-day weekday-header">Sat</div>
                    <div class="calendar-day weekday-header">Sun</div>
            `;
            
            // Add week number for first week
            let weekNumber = getISOWeekNumber(new Date(year, month, 1));
            calendarHTML += `<div class="calendar-day week-number">W${String(weekNumber).padStart(2, '0')}</div>`;
            
            // Add empty cells for days before the first day of the month
            for (let i = 0; i < adjustedStartingDay; i++) {
                calendarHTML += '<div class="calendar-day empty"></div>';
            }
            
            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayEvents = events.filter(event => event.date === dateString);
                
                // Debug: Log events for this day
                if (dayEvents.length > 0) {
                    console.log(`Events for ${dateString}:`, dayEvents);
                }
                
                const isToday = today.toDateString() === new Date(year, month, day).toDateString();
                const isPast = new Date(year, month, day) < new Date().setHours(0, 0, 0, 0);
                
                let dayClass = 'calendar-day';
                if (isToday) dayClass += ' today';
                if (isPast) dayClass += ' past';
                if (dayEvents.length > 0) dayClass += ' has-event';
                
                calendarHTML += `
                    <div class="${dayClass}" data-date="${dateString}">
                        <span class="day-number">${day}</span>
                        ${dayEvents.length > 0 ? `<div class="event-indicator" title="${dayEvents.map(e => e.title).join(', ')}"></div>` : ''}
                        <div class="holiday-indicator" id="holiday-${dateString}"></div>
                    </div>
                `;
                
                // Add week number for new weeks (after Sunday)
                const currentDate = new Date(year, month, day);
                if (currentDate.getDay() === 0 && day < daysInMonth) {
                    const nextWeekNumber = getISOWeekNumber(new Date(year, month, day + 1));
                    calendarHTML += `<div class="calendar-day week-number">W${String(nextWeekNumber).padStart(2, '0')}</div>`;
                }
            }
            
            calendarHTML += '</div>';
            
            // Add public holidays section
            calendarHTML += `
                <div class="calendar-footer" id="calendarFooter">
                    <h4>🇲🇾 Public Holidays</h4>
                    <div class="public-holidays" id="publicHolidays">
                        <div class="loading">Loading holidays...</div>
                    </div>
                </div>
            `;
            
            calendarGrid.innerHTML = calendarHTML;
            
            // Load public holidays asynchronously
            loadPublicHolidays(year, month);
            
            // Add click handlers for days with events
            const eventDays = calendarGrid.querySelectorAll('.calendar-day.has-event');
            eventDays.forEach(day => {
                day.addEventListener('click', function() {
                    const date = this.dataset.date;
                    const dayEvents = events.filter(event => event.date === date);
                    showEventDetails(dayEvents, date);
                });
            });
        }
        
        function showEventDetails(dayEvents, date) {
            const eventList = dayEvents.map(event => `
                <div class="calendar-event-item">
                    <div class="event-type ${event.type}"></div>
                    <div class="event-info">
                        <h4>${event.title}</h4>
                        <p>${new Date(date).toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}</p>
                    </div>
                </div>
            `).join('');
            
            const modal = document.createElement('div');
            modal.className = 'calendar-modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Events on ${new Date(date).toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}</h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        ${eventList}
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            // Close modal functionality
            modal.querySelector('.modal-close').addEventListener('click', () => {
                modal.remove();
            });
            
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        }
        
        prevMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });
        
        nextMonthBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
        
        // Initial calendar render happens after events are loaded via loadEvents()
        // No need for setTimeout since events loading will trigger calendar render
    } else {
        console.warn('Calendar elements not found - calendar functionality disabled');
    }

    // Enhanced image error handling with placeholders
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        // Handle image load error
        img.addEventListener('error', function() {
            
            // Determine the type of image based on context and use appropriate placeholder
            const parent = this.closest('.event-image, .news-image, .featured-image');
            const memberCard = this.closest('.member-card, .committee-member');
            
            if (parent) {
                // Event or news image
                if (this.closest('.event-image')) {
                    this.src = 'assets/images/placeholder-event.svg';
                } else if (this.closest('.news-image, .featured-image')) {
                    this.src = 'assets/images/placeholder-news.svg';
                }
            } else if (memberCard) {
                // Member or committee member image
                this.src = 'assets/images/placeholder-member.svg';
            } else if (this.closest('.mission-image, .president-image')) {
                // Mission or president image
                this.src = 'assets/images/placeholder-mission.svg';
            } else {
                // Generic fallback - don't replace logo images
                if (!this.classList.contains('logo-img')) {
                    this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjRkZGRkZGIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OTk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlIG5vdCBhdmFpbGFibGU8L3RleHQ+PC9zdmc+';
                }
            }
        });
        
        // Add loading state
        img.addEventListener('load', function() {
            this.classList.add('loaded');
        });
    });
    
    // Page load completion indicator
    window.addEventListener('load', function() {
        document.body.classList.add('page-loaded');
    });
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .navbar.scrolled {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--glass-border);
        box-shadow: var(--shadow-md);
    }
    
    body.light-mode .navbar.scrolled {
        background: var(--glass-bg-light);
        border-bottom: 1px solid var(--glass-border-light);
    }
    
    .nav-menu.active {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 1rem;
    }
    
    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }
    
    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }
    
    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }
    
    .animate-in {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .loaded {
        opacity: 1;
    }
    
    body {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .error {
        border-color: #FF385C !important;
        box-shadow: 0 0 0 2px rgba(255, 56, 92, 0.2) !important;
    }
`;
document.head.appendChild(style);

// Year tab functionality for old members page
function initYearTabs() {
    const yearTabs = document.querySelectorAll('.year-tab');
    const committeeYears = document.querySelectorAll('.committee-year');
    
    yearTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetYear = tab.getAttribute('data-year');
            
            // Remove active class from all tabs and years
            yearTabs.forEach(t => t.classList.remove('active'));
            committeeYears.forEach(year => year.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding year
            tab.classList.add('active');
            const targetYearElement = document.getElementById(targetYear);
            if (targetYearElement) {
                targetYearElement.classList.add('active');
            }
        });
    });
}

// Initialize year tabs if on old-members page
if (document.querySelector('.year-tabs')) {
    initYearTabs();
}

// Initialize language on page load with delay to ensure DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const savedLanguage = localStorage.getItem('selectedLanguage') || 'en';
    // Add a small delay to ensure all DOM elements are fully loaded
    setTimeout(() => {
        selectLanguage(savedLanguage);
    }, 100);
});

// Global notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? 'var(--accent-green)' : type === 'error' ? 'var(--accent-red)' : type === 'warning' ? 'var(--accent-orange)' : 'var(--accent-blue)'};
        color: white;
        padding: var(--spacing-md);
        border-radius: var(--border-radius-md);
        box-shadow: var(--shadow-md);
        z-index: 1000;
        font-weight: 500;
        animation: slideIn 0.3s ease;
        max-width: 300px;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
