<?php
echo '

<header class="bg-white shadow-sm py-4 px-6">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center gap-5"> 
            <a class="flex items-center text-2xl font-bold text-gray-900" href="dashboard.php">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="h-6 w-6 mr-2"
                >
                    <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                    <path d="M7 3v18"></path>
                    <path d="M3 7.5h4"></path>
                    <path d="M3 12h18"></path>
                    <path d="M3 16.5h4"></path>
                    <path d="M17 3v18"></path>
                    <path d="M17 7.5h4"></path>
                    <path d="M17 16.5h4"></path>
                </svg>
                MovieFinder Admin
            </a>
            <div class="">
            <a href="index.php">View Webpage</a>
            </div>
            </div>
            
            <div class="flex items-center gap-4">
                <a class="text-gray-900" href="add-movie.php">
                    Añadir Película
                </a>
                <a class="text-gray-900" href="logout.php?redirect=login.php">
                    Logout
                </a>
            </div>
        </div>
    </header>

';
?>
