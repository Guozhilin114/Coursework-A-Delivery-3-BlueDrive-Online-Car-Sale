<?php

$siteRoot = '';
$searchPage = $siteRoot . 'search.php';
$logoPath = '../assets/images/logo1.jpg';
$bgImage = 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Used Car Marketplace</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background-image: url('<?php echo $bgImage; ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
        }

        .enter-button {
            position: absolute;
            left: 20%;
            bottom: 20%;
            transform: translateX(-50%) translateY(0);
            background-color: #1a73e8;
            color: white;
            padding: 20px 50px;
            text-decoration: none;
            border-radius: 12px;
            font-size: 28px;
            font-weight: bold;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            min-width: 380px;
            text-align: center;
            z-index: 10;
        }

        .enter-button:hover {
            background-color: #0d5bb5;
            transform: translateX(-50%) translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.4);
        }

        .logo {
            position: absolute;
            top: 30px;
            left: 30px;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-img {
            height: 80px;
            width: auto;
            object-fit: contain;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .introduction-section {
            position: relative;
            z-index: 2;
            margin-top: 100vh;
            background: rgba(255, 255, 255, 0.95);
            padding: 60px 20px;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease-out;
        }

        .introduction-section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .introduction-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
        }

        .section-title {
            font-size: 36px;
            color: #1a73e8;
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
        }

        .intro-text {
            font-size: 18px;
            line-height: 1.8;
            color: #333;
            text-align: center;
        }

        .placeholder-text {
            font-size: 20px;
            color: #666;
            text-align: center;
            line-height: 2;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        .main-screen {
            height: 100vh;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        @media (max-width: 768px) {
            .logo {
                top: 20px;
                left: 20px;
                font-size: 18px;
                gap: 8px;
            }

            .logo-img {
                height: 55px;
            }

            .enter-button {
                left: 50%;
                bottom: 18%;
                min-width: 260px;
                padding: 16px 28px;
                font-size: 20px;
                border-radius: 10px;
            }

            .introduction-section {
                padding: 40px 15px;
            }

            .introduction-content {
                padding: 25px 15px;
            }

            .section-title {
                font-size: 28px;
                margin-bottom: 20px;
            }

            .intro-text {
                font-size: 16px;
                line-height: 1.6;
            }

            .placeholder-text {
                font-size: 16px;
                line-height: 1.7;
            }
        }

    </style>
</head>

<body>
    <div class="overlay"></div>

    <div class="logo">
        <img src="<?php echo $logoPath; ?>" alt="Lingshui Used Car Market Logo" class="logo-img">
        Lingshui Used Car Market
    </div>

    <div class="main-screen">
        <a href="<?php echo $searchPage; ?>" class="enter-button">
            Enter Lingshui CarMarketplace
        </a>
    </div>

    <section class="introduction-section" id="introduction">
        <div class="introduction-content">
            <h2 class="section-title">About Lingshui Used Car Market</h2>
            <div class="intro-text">
                <div class="placeholder-text">
                    <p>Our website is a professional one-stop vehicle trading platform dedicated to providing safe,
                        transparent and efficient car-buying and selling services for customers.</p>
                    <p>We offer a wide range of high-quality vehicles, including new cars, used cars, sedans, SUVs and
                        new energy vehicles, with strictly selected sources and complete vehicle information.
                        Every vehicle on our platform undergoes professional inspection to ensure no major accidents,
                        flood damage or fire damage.</p>
                    <p>We also provide customers with convenient services such as online browsing, test drive
                        appointment, free valuation, vehicle financing and transfer agency.</p>
                    <p>Adhering to the principles of integrity, transparency and customer-first service, we strive to
                        build a reliable and user-friendly automobile trading platform, making vehicle transactions
                        easier and more reassuring for every user.</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const introSection = document.getElementById('introduction');

            window.addEventListener('scroll', function() {
                const sectionTop = introSection.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;

                if (sectionTop < windowHeight * 0.8) {
                    introSection.classList.add('visible');
                }
            });

            const sectionTop = introSection.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            if (sectionTop < windowHeight * 0.8) {
                introSection.classList.add('visible');
            }
        });
    </script>
</body>

</html>