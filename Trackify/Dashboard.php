<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: /Trackify/Login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        kanit: ['Kanit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#66bb60',
                        primaryHover: '#55aa50',
                        darkBg: '#131212',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0, transform: 'translateY(20px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #131212;
        }
        ::-webkit-scrollbar-thumb {
            background: #66bb60;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #55aa50;
        }
        
        /* Mobile sidebar styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: fixed;
                bottom: 0;
                left: 0;
                z-index: 50;
                display: flex;
                flex-direction: row;
                justify-content: space-around;
                padding: 0.5rem 0;
                box-shadow: 0 -2px 10px rgba(0,0,0,0.5);
            }
            .sidebar-nav {
                display: flex;
                flex-direction: row;
                width: 100%;
            }
            .sidebar-nav a {
                flex: 1;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 0.75rem;
                font-size: 0.75rem;
                text-align: center;
            }
            .sidebar-nav i {
                margin-right: 0;
                margin-bottom: 0.25rem;
                font-size: 1rem;
            }
            .sidebar-brand {
                display: none;
            }
            .main-content {
                margin-left: 0;
                margin-top:15%;
                padding: 1rem;
                margin-bottom: 70px; /* Space for mobile sidebar */
            }
            .dashboard-card {
                height: auto;
                min-height: 200px;
            }
            .mobile-menu-button {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 60;
                background: #66bb60;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }
            .desktop-sidebar {
                display: none;
            }
            .mobile-sidebar {
                display: flex;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-menu-button {
                display: none;
            }
            .desktop-sidebar {
                display: block;
            }
            .mobile-sidebar {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-[#131212] text-white font-kanit min-h-screen">
    <div id="preloader" class="fixed inset-0 bg-darkBg flex items-center justify-center z-[9999] transition-opacity duration-500">
        <div class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
    </div>

    <!-- Mobile menu button -->
    <button id="mobileMenuButton" class="mobile-menu-button md:hidden">
        <i class="fas fa-bars"></i>
    </button>

    <div class="flex min-h-screen">
        <!-- Desktop Sidebar -->
        <div class="desktop-sidebar w-64 bg-darkBg fixed h-full z-10 shadow-lg">
            <div class="p-6 text-3xl font-semibold">
                Track<span class="text-primary">ify</span>
            </div>
            <nav class="mt-8">
                <a href="./Dashboard.php" class="flex items-center px-6 py-3 text-gray-300 hover:text-primary hover:bg-black/30 transition-colors">
                    <i class="fas fa-columns mr-3"></i>
                    Dashboard
                </a>
                <a href="./Tracking.php" class="flex items-center px-6 py-3 text-gray-300 hover:text-primary hover:bg-black/30 transition-colors" onclick="window.location.href='./Tracking.php'">
                    <i class="fas fa-clock mr-3"></i>
                    Time Tracker
                </a>
                <a href="./Client.php" class="flex items-center px-6 py-3 text-gray-300 hover:text-primary hover:bg-black/30 transition-colors">
                    <i class="fas fa-user mr-3"></i>
                    Clients
                </a>
                <a href="./Invoice.php" class="flex items-center px-6 py-3 text-gray-300 hover:text-primary hover:bg-black/30 transition-colors">
                    <i class="fas fa-file-invoice-dollar mr-3"></i>
                    Invoice
                </a>
            </nav>
        </div>

        <!-- Mobile Sidebar -->
        <div id="mobileSidebar" class="mobile-sidebar sidebar bg-darkBg">
            <nav class="sidebar-nav">
                <a href="./Dashboard.php" class="flex items-center text-gray-300 hover:text-primary transition-colors">
                    <i class="fas fa-columns"></i>
                    <span>Dashboard</span>
                </a>
                <a href="./Tracking.php" class="flex items-center text-gray-300 hover:text-primary transition-colors" onclick="window.location.href='./Tracking.php'">
                    <i class="fas fa-clock"></i>
                    <span>Tracker</span>
                </a>
                <a href="./Client.php" class="flex items-center text-gray-300 hover:text-primary transition-colors">
                    <i class="fas fa-user"></i>
                    <span>Clients</span>
                </a>
                <a href="./Invoice.php" class="flex items-center text-gray-300 hover:text-primary transition-colors">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Invoice</span>
                </a>
            </nav>
        </div>

        <div class="main-content flex-1 ml-0 md:ml-64 p-4 md:p-8">
            <div class="mb-6">
                <a href="./landing.html" target="_blank" class=" text-lg text-white  hover:text-primary hover transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Landing page
                </a>
            </div>

            <h1 class="text-2xl md:text-4xl font-bold mb-6 animate-fade-in">Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-6">
                <div class="dashboard-card bg-[#41414148] rounded-xl p-4 md:p-6 shadow-[2.2px_-2.2px_20px_#66bb60] hover:scale-[1.02] transition-all duration-300 animate-fade-in">
                    <h2 class="text-lg md:text-xl font-semibold mb-4">Project Overview</h2>
                    <div class="text-sm md:text-base text-gray-300">
                        Your project statistics and summary will appear here.
                    </div>
                </div>

                <div class="dashboard-card bg-[#41414148] rounded-xl p-4 md:p-6 shadow-[2.2px_-2.2px_20px_#66bb60] hover:scale-[1.02] transition-all duration-300 animate-fade-in">
                    <h2 class="text-lg md:text-xl font-semibold mb-4">Recent Activity</h2>
                    <div class="text-sm md:text-base text-gray-300">
                        Your recent time tracking activities will appear here.
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div class="dashboard-card bg-[#41414148] rounded-xl p-4 md:p-6 shadow-[2.2px_-2.2px_20px_#66bb60] hover:scale-[1.02] transition-all duration-300 animate-fade-in">
                    <h2 class="text-lg md:text-xl font-semibold mb-4">Time Analysis</h2>
                    <div class="text-sm md:text-base text-gray-300">
                        Visual charts of your time distribution will appear here.
                    </div>
                </div>

                <div class="dashboard-card bg-[#41414148] rounded-xl p-4 md:p-6 shadow-[2.2px_-2.2px_20px_#66bb60] hover:scale-[1.02] transition-all duration-300 animate-fade-in">
                    <h2 class="text-lg md:text-xl font-semibold mb-4">Upcoming Tasks</h2>
                    <div class="text-sm md:text-base text-gray-300">
                        Your pending tasks and deadlines will appear here.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            setTimeout(() => {
                preloader.style.transition = 'opacity 0.3s ease-out, visibility 0.3s';
                preloader.style.opacity = '0';
                preloader.style.visibility = 'hidden';
                setTimeout(() => {
                    document.body.style.overflow = 'auto';
                }, 500);
            }, 800);
        });

        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const sidebar = document.getElementById('mobileSidebar');
            const isHidden = sidebar.style.transform === 'translateY(100%)' || !sidebar.style.transform;
            
            if (isHidden) {
                sidebar.style.transform = 'translateY(0)';
                this.innerHTML = '<i class="fas fa-times"></i>';
            } else {
                sidebar.style.transform = 'translateY(100%)';
                this.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });

        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.style.scrollBehavior = 'smooth';
            
            const animatedElements = document.querySelectorAll('.animate-fade-in');
            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
            });

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            animatedElements.forEach(el => observer.observe(el));

            // Initialize mobile sidebar position
            if (window.innerWidth < 768) {
                document.getElementById('mobileSidebar').style.transform = 'translateY(100%)';
            }
        });

        // Scroll to top button
        window.addEventListener('scroll', function() {
            const scrollToTop = document.createElement('div');
            scrollToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
            scrollToTop.className = 'fixed bottom-20 md:bottom-8 right-4 md:right-8 w-10 h-10 md:w-12 md:h-12 bg-primary rounded-full flex items-center justify-center cursor-pointer opacity-0 invisible transition-all duration-300 shadow-lg hover:bg-primaryHover';
            scrollToTop.id = 'scrollToTop';
            
            if (window.scrollY > 300 && !document.getElementById('scrollToTop')) {
                document.body.appendChild(scrollToTop);
                setTimeout(() => {
                    document.getElementById('scrollToTop').style.opacity = '1';
                    document.getElementById('scrollToTop').style.visibility = 'visible';
                }, 50);
                
                document.getElementById('scrollToTop').addEventListener('click', () => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            } else if (window.scrollY <= 300 && document.getElementById('scrollToTop')) {
                document.getElementById('scrollToTop').style.opacity = '0';
                document.getElementById('scrollToTop').style.visibility = 'hidden';
                setTimeout(() => {
                    if (document.getElementById('scrollToTop')) {
                        document.getElementById('scrollToTop').remove();
                    }
                }, 300);
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.getElementById('mobileSidebar').style.transform = '';
                document.getElementById('mobileMenuButton').innerHTML = '<i class="fas fa-bars"></i>';
            } else {
                document.getElementById('mobileSidebar').style.transform = 'translateY(100%)';
            }
        });
    </script>
</body>
</html>