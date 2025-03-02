# Code Citations

## License: unknown
https://github.com/afonsocrg/mementoMori/tree/f9a35b18d050964678a204fd1c56f23c1426c305/by_year/memento_mori.html

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Time Capsule</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Homepage specific styles */
        .home-container {
            max-width: 1280px;
            margin: 40px auto;
            padding: 0 16px;
        }

        .hero-section {
            position: relative;
            text-align: center;
            margin-bottom: 64px;
            background: url('images/landscape.jpg') no-repeat center center/cover;
            padding: 120px 20px;
            color: var(--github-white);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .hero-description {
            font-size: 20px;
            color: var(--github-gray);
            margin-bottom: 32px;
        }

        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-btn {
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
        }

        .primary-cta {
            background-color: var(--github-green);
            color: var(--github-white);
        }

        .secondary-cta {
            background-color: var(--github-header-bg);
            color: var(--github-white);
            border: 1px solid var(--github-border);
        }

        .features-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 64px;
        }

        .feature-card {
            padding: 24px;
            background-color: var(--github-header-bg);
            border: 1px solid var(--github-border);
            border-radius: 6px;
        }

        .feature-title {
            font-size: 20px;
            margin-bottom: 16px;
        }

        .feature-description {
            color: var(--github-gray);
            line-height: 1.5;
        }

        .logo img {
            height: 40px;
            vertical-align: middle;
            border-radius: 8px; /* Add rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            background: transparent; /* Ensure background is transparent */
        }

        .signup-section {
            background: url('images/signup.jpg') no-repeat center center/cover;
            padding: 60px 20px;
            color: var(--github-white);
            text-align: center;
            margin-top: 40px;
            border-radius: 8px;
        }

        .signup-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
            z-index: 1;
        }

        .signup-content {
            position: relative;
            z-index: 2;
        }

        .signup-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 36px;
            }

            .hero-description {
                font-size: 18px;
            }

            .cta-btn {
                padding: 10px 20px;
                font-size: 14px;
            }

            .feature-title {
                font-size: 18px;
            }

            .feature-description {
                font-size: 16px;
            }

            .signup-title {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 28px;
            }

            .hero-description {
                font-size: 16px;
            }

            .cta-btn {
                padding: 8px 16px;
                font-size: 12px;
            }

            .feature-title {
                font-size: 16px;
            }

            .feature-description {
                font-size: 14px;
            }

            .signup-title {
                font-size: 24px;
            }
        }

        .footer {
            background-color: var(--github-header-bg);
            color: var(--github-gray);
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            border-top: 1px solid var(--github-border);
        }

        .footer a {
            color: var(--github-gray);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="home-container">
        <header class="header">
            <a href="index.html" class="logo">
                <img src="images/WhatsApp Image 2025-02-20 at 21.36.47_1fdb0e35.jpg" alt="Digital Time Capsule Logo">
                Digital Time Capsule
            </a>
            <nav class="nav-links">
                <a href="dashboard.html" class="nav-link">Dashboard</a>
                <a href="new-capsule.html" class="nav-link">New Capsule</a>
                <a href="pricing.html" class="nav-link">Pricing</a>
                <a href="about.html" class="nav-link">About</a>
            </nav>
        </header>

        <div class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">Preserve Your Digital Legacy</h1>
                <p class="hero-description">
                    Secure time-locked storage for your most important memories
                </p>
                <div class="cta-buttons">
                    <a href="new-capsule.html" class="cta-btn primary-cta" id="createCapsuleBtn">Create Capsule</a>
                    <a href="about.html" class="cta-btn secondary-cta">Learn More</a>
                </div>
            </div>
        </div>

        <div class="features-section">
            <div class="feature-card">
                <h3 class="feature-title">Secure Storage</h3>
                <p class="feature-description">
                    Military-grade encryption ensures your memories stay private until 
                    your specified unlock date.
                </p>
            </div>
            <div class="feature-card">
                <h3 class="feature-title">Multi-Format Support</h3>
                <p class="feature-description">
                    Store text, images, videos, documents, and any digital format 
                    with our universal storage system.
                </p>
            </div>
            <div class="feature-card">
                <h3 class="feature-title">Time Lock</h3>
                <p class="feature-description">
                    Set future unlock dates ranging from 1 year to 100 years. 
                    Your capsule becomes inaccessible until the target date.
                </p>
            </div>
        </div>

        <div class="cta-buttons">
            <a href="signup.html" class="cta-btn primary-cta">Start Preserving Today</a>
        </div>

        <div class="signup-section">
            <div class="signup-content">
                <h2 class="signup-title">Join Us Today</h2>
                <a href="signup.html" class="cta-btn primary-cta">Sign Up</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Digital Time Capsule. All rights reserved.</p>
        <p>
            <a href="privacy.html">Privacy Policy</a> |
            <a href="terms.html">Terms of Service</a> |
            <a href="contact.html">Contact Us</a>
        </p>
    </footer>

    <!-- Add this script for navigation -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Check authentication status
            const currentUser = localStorage.getItem('currentUser');
            
            // Protect authenticated routes
            const createCapsuleBtn = document.getElementById('createCapsuleBtn');
            
            createCapsuleBtn.addEventListener('click', (e) => {
                if (!currentUser) {
                    e.preventDefault();
                    alert('Please login first!');
                    window.location.href = 'login.html';
                }
            });
        });
    </script>
    <script src="scripts.js"></script>
</body>
</html>
```


## License: unknown
https://github.com/anithainfo/Courier-management-system/tree/ad41729cac620e32871461569aec8412e04a9ce8/home/price.php

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing
```

