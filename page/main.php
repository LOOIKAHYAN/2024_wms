<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default page is 'home'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management System</title>
    <link rel="stylesheet" href="../css/index.css">
    <style>
        .logout-button img {
            position: fixed;
            right: 10px;
            top: 8px;
            z-index: 2000;
            cursor: pointer;
            width: 30px;
            border-radius: 15px;
        }
    </style>
    <script>
        function loadContent(page) {
            var contentUrl = page + '.php';
            fetch(contentUrl)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('content').innerHTML = html;

                    // Update the breadcrumb based on the page
                    var breadcrumb = '<ol>';

                    // Define breadcrumb paths
                    var paths = {
                        'staff': 'Staff',
                        'customer': 'Entities > Customer',
                        'supplier': 'Entities > Supplier',
                        'product': 'Product',
                        'inventory_summary': 'Inventory > Inventory Summary',
                        'inventory_details': 'Inventory > Inventory Details',
                    };

                    // Check if the page has a defined breadcrumb path
                    if (paths[page]) {
                        breadcrumb += '<li class="active">' + paths[page] + '</li>';
                    } else {
                        breadcrumb += '<li class="active">' + page.charAt(0).toUpperCase() + page.slice(1) + '</li>';
                    }

                    breadcrumb += '</ol>';
                    document.querySelector('.breadcrumb').innerHTML = breadcrumb;
                })
                .catch(error => {
                    console.error('Error loading content:', error);
                });
        }

        function toggleDropdown(id) {
            var dropdown = document.getElementById(id + '-dropdown');

            // Toggle the 'show' class on the clicked dropdown
            dropdown.classList.toggle('show');

            // Hide all other dropdowns
            var allDropdowns = document.querySelectorAll('.dropdown-menu');
            allDropdowns.forEach(function (menu) {
                if (menu.id !== id + '-dropdown') {
                    menu.classList.remove('show');
                }
            });
        }

        function getQueryParam(param) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        document.addEventListener('DOMContentLoaded', function () {
            var page = getQueryParam('page');
            if (page) {
                loadContent(page);
            }
        });
    </script>

    <script>
        function confirmLogout() {
            // Show confirmation dialog
            if (confirm("Are you sure you want to logout?")) {
                // Redirect to logout.php if user confirms
                window.location.href = '../logout/logout.php';
            }
        }
    </script>

</head>

<body>
    <button class="logout-button" onclick="confirmLogout()"><img src="../images/logout.png"></button>
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <ol>
            <li><span>Warehouse Management System</span></li>
        </ol>

    </nav>

    <aside class="sidebar">
        <ul>
            <li><a onclick="loadContent('home')">Home</a></li>
            <li><a onclick="loadContent('staff')">Staff</a></li>
            <li class="dropdown">
                <a href="#" onclick="toggleDropdown('entities')">Entities</a>
                <ul id="entities-dropdown" class="dropdown-menu">
                    <li><a onclick="loadContent('customer')">Customer</a></li>
                    <li><a onclick="loadContent('supplier')">Supplier</a></li>
                </ul>
            </li>
            <ul>
                <li><a onclick="loadContent('product')">Product</a></li>
            </ul>
            <li class="dropdown">
                <a href="#" onclick="toggleDropdown('inventory')">Inventory</a>
                <ul id="inventory-dropdown" class="dropdown-menu">
                    <li><a onclick="loadContent('inventory_summary')">Inventory Summary</a></li>
                    <li><a onclick="loadContent('inventory_details')">Inventory Details</a></li>
                </ul>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="content" id="content">
        <?php include "home.php" ?>
    </main>
</body>

</html>

</html>