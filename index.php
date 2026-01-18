<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ram Mantra - Lord Ram</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Header Styles */
        header {
            background: linear-gradient(135deg, #FF8C00 0%, #FF6B35 100%);
            color: white;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        nav {
            display: flex;
            gap: 2rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            cursor: pointer;
            transition: opacity 0.3s;
            font-size: 1rem;
        }

        nav a:hover {
            opacity: 0.8;
        }

        .login-btn {
            background-color: #fff;
            color: #FF8C00;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
            transition: transform 0.3s;
        }

        .login-btn:hover {
            transform: scale(1.05);
        }

        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background-color: white;
            border-radius: 3px;
        }

        /* Home Section */
        .section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            scroll-behavior: smooth;
        }

        #home {
            background: linear-gradient(135deg, #FF8C00 0%, #FF6B35 100%);
            color: white;
        }

        .home-content {
            text-align: center;
            max-width: 800px;
        }

        .home-image {
            width: 100%;
            max-width: 500px;
            height: auto;
            margin: 2rem 0;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .home-title {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .home-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* About Section */
        #about {
            background-color: #f5f5f5;
        }

        .about-container {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .about-title {
            font-size: 2.5rem;
            color: #FF8C00;
            margin-bottom: 2rem;
        }

        .about-content {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: left;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .about-hindi {
            margin-top: 2rem;
            padding: 1.5rem;
            background-color: #fff9e6;
            border-left: 5px solid #FF8C00;
            border-radius: 5px;
            font-family: 'Noto Sans Devanagari', Arial;
            line-height: 2;
        }

        /* Video Gallery Section */
        #videos {
            background-color: white;
        }

        .videos-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .videos-title {
            font-size: 2.5rem;
            color: #FF8C00;
            text-align: center;
            margin-bottom: 2rem;
        }

        .video-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .video-card {
            background-color: #f5f5f5;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .video-card:hover {
            transform: translateY(-10px);
        }

        .video-card iframe {
            width: 100%;
            height: 200px;
            border: none;
        }

        .video-title {
            padding: 1rem;
            font-weight: bold;
            color: #333;
        }

        /* Contact Section */
        #contact {
            background: linear-gradient(135deg, #FF8C00 0%, #FF6B35 100%);
            color: white;
        }

        .contact-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-title {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .contact-form {
            background-color: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            font-family: Arial;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            background-color: white;
            color: #FF8C00;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s;
            width: 100%;
        }

        .submit-btn:hover {
            transform: scale(1.02);
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-links {
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: #FF8C00;
            text-decoration: none;
            margin: 0 1rem;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                display: none;
                position: absolute;
                top: 60px;
                right: 0;
                background-color: #FF8C00;
                flex-direction: column;
                width: 100%;
                padding: 1rem;
                gap: 1rem;
            }

            nav.active {
                display: flex;
            }

            .menu-toggle {
                display: flex;
            }

            .header-container {
                flex-wrap: wrap;
            }

            .home-title {
                font-size: 2rem;
            }

            .about-title,
            .videos-title,
            .contact-title {
                font-size: 1.8rem;
            }

            .video-gallery {
                grid-template-columns: 1fr;
            }

            .section {
                min-height: auto;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 0.8rem 1rem;
            }

            .logo {
                font-size: 1.2rem;
            }

            .home-title {
                font-size: 1.5rem;
            }

            .about-title,
            .videos-title,
            .contact-title {
                font-size: 1.5rem;
            }

            .about-content {
                padding: 1rem;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">🕉️ Ram Mantra</div>
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav id="nav">
                <a onclick="scrollToSection('home')">Home</a>
                <a onclick="scrollToSection('about')">About</a>
                <a onclick="scrollToSection('videos')">Videos</a>
                <a onclick="scrollToSection('contact')">Contact</a>
                <a href="login.php" class="login-btn">Login</a>
            </nav>
        </div>
    </header>

    <!-- Home Section -->
    <section id="home" class="section">
        <div class="home-content">
            <h1 class="home-title">Welcome to Ram Mantra</h1>
            <p class="home-subtitle">Discover the divine wisdom of Lord Rama</p>
            <img src="image/Ram.jpg" alt="Lord Ram" class="home-image">
            <p style="font-size: 1.1rem; margin-top: 1rem;">जान आदिकबि नाम प्रतापू। भयउ सुद्ध करि उलटा जापू॥
सहस नाम सम सुनि सिव बानी। जपि जेईं पिय संग भवानी॥
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="about-container">
            <h2 class="about-title">About Lord Rama</h2>
            <div class="about-content">
                
                <div class="about-hindi">
                    <p><strong>हिंदी विवरण (Hindi Description):</strong></p>
                    <p style="margin-top: 1rem;">भारतीय संस्कृति में राम नाम जप को केवल एक धार्मिक क्रिया नहीं, बल्कि आत्मा की जागृति का सीधा मार्ग माना गया है। यह कोई साधारण नाम नहीं, बल्कि एक ऐसा दिव्य शब्द है जो मन, शरीर और आत्मा—तीनों को शुद्ध करता है। तुलसीदास जी ने भी रामचरितमानस में कहा है –
“राम नाम बिनु गति नहीं कोई।”
यह बताता है कि राम नाम ही मोक्ष और शांति का मार्ग है।</p>
                    
                    <p style="margin-top: 1rem;">प्राचीन संतों, योगियों और भक्तों का जीवन गवाह है कि राम नाम जप ने उन्हें सांसारिक मोह, भय, चिंता और दुख से ऊपर उठाकर दिव्यता प्रदान की। संत तुलसीदास, कबीर, रामदास स्वामी और यहां तक कि आधुनिक युग के संत – सबने राम नाम की महिमा का प्रचार किया।</p>
                    
                    <p style="margin-top: 1rem;">राम नाम केवल उच्चारण नहीं है – यह एक कम्पनात्मक ऊर्जा है, जो जब बार-बार दोहराई जाती है तो हमारे शरीर के अंदर सकारात्मक कंपन (vibrations) उत्पन्न करती है। यही कारण है कि राम नाम को “मंत्रों का राजा” कहा गया है।</p>
                </div>
                 <br>
                <p><strong>Lord Rama</strong> In Indian culture, the chanting of the name “Ram” is not considered merely a religious act, but a direct path to the awakening of the soul. It is not just an ordinary name, but a divine word that purifies the mind, body, and soul. Tulsidas also wrote in the Ramcharitmanas.</p>
                
                <p style="margin-top: 1rem;">“Without the name of Ram, there is no true path.”
This signifies that the name of Ram itself is the way to liberation and peace.</p>

                <p style="margin-top: 1rem;">The lives of ancient saints, yogis, and devotees bear witness to how the chanting of Ram’s name lifted them above worldly attachments, fear, anxiety, and sorrow, and brought them closer to divinity. Saints such as Tulsidas, Kabir, Ramdas Swami, and even modern spiritual leaders have all spread the glory of Ram’s name.</p>

            </div>
        </div>
    </section>

    <!-- Video Gallery Section -->
    <section id="videos" class="section">
        <div class="videos-container">
            <h2 class="videos-title">Latest Ram Mantra Videos</h2>
            <div class="video-gallery">
                <!-- Video 1 -->
                <div class="video-card">
                    <iframe src="https://www.youtube.com/embed/mrboSKcDfRM" allowfullscreen="" loading="lazy"></iframe>
                    <div class="video-title">Ram Mantra Chanting</div>
                </div>

                <!-- Video 2 -->
                <div class="video-card">
                    <iframe src="https://www.youtube.com/embed/DYKwyaFp_yk" allowfullscreen="" loading="lazy"></iframe>
                    <div class="video-title">Ram Mantra Chanting</div>
                </div>

                <!-- Video 3 -->
                <div class="video-card">
                    <iframe src="https://www.youtube.com/embed/oPATPHM0oAo" allowfullscreen="" loading="lazy"></iframe>
                    <div class="video-title">Ram Mantra Chanting</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="contact-container">
            <h2 class="contact-title">Contact Us</h2>
            <form class="contact-form" onsubmit="handleContactForm(event)">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone">
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>
                </div>

                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#videos">Videos</a>
                <a href="#contact">Contact</a>
                <a href="privacy.php">Privacy Policy</a>
            </div>
            <p>&copy; 2026 Ram Mantra. All rights reserved. 🕉️</p>
            <p>ॐ नमो भगवते वासुदेवाय ॐ</p>
        </div>
    </footer>

    <script>
        // Smooth scroll to sections
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                section.scrollIntoView({ behavior: 'smooth' });
                // Close mobile menu if open
                const nav = document.getElementById('nav');
                if (nav.classList.contains('active')) {
                    nav.classList.remove('active');
                }
            }
        }

        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const nav = document.getElementById('nav');

        menuToggle.addEventListener('click', () => {
            nav.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('header')) {
                nav.classList.remove('active');
            }
        });

        // Handle contact form submission
        function handleContactForm(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            
            alert(`Thank you ${name}! Your message has been received. We will contact you at ${email} soon.`);
            
            // Reset form
            event.target.reset();
        }

        // Smooth scroll behavior for all anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    scrollToSection(href.substring(1));
                }
            });
        });
    </script>
</body>
</html> 