<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Double Menu</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for your navigation bars */
        .navbar {
            background-color: #004080; /* Dark blue color */
            color: white;
            padding: 0;
        }

        .navbar .navbar-nav .nav-link {
            color: white;
        }

        .navbar .navbar-brand {
            color: white;
        }

        .navbar-toggler {
            border-color: white;
        }

        .navbar-light .navbar-toggler-icon {
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .navbar-nav {
                text-align: center;
            }
        }

        /* Secondary menu specific styles */
        .secondary-menu {
            background-color: #e6e6e6; /* Light grey color */
            padding: 0.5rem 1rem;
        }

        .secondary-menu .nav-link {
            color: #004080; /* Dark blue color */
            padding-left: 0;
            padding-right: 0;
            margin-right: 1rem; /* Space between links */
        }

        .secondary-menu .nav-item:last-child .nav-link {
            margin-right: 0;
        }

        /* Smaller padding for all links in both navbars */
        .navbar .nav-link {
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body>

<nav  class="navbar navbar-expand-lg navbar-light bg-light">
    <div style="background-color: navy" class="container">
        <a class="navbar-brand" href="#">FBC Holdings Limited</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrimary"
                aria-controls="navbarPrimary" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarPrimary">
            <ul  class="navbar-nav ml-auto">
                <!-- Primary menu items -->
                <!-- ... other primary items ... -->
                <li class="nav-item">
                    <a class="nav-link" href="#">Internet Banking</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Internet Banking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Internet Banking</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Internet Banking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Internet Banking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Internet Banking</a>
                </li>


                <!-- ... -->
            </ul>
        </div>
    </div>
</nav>

<nav class="secondary-menu">
    <div class="container">
        <ul class="nav justify-content-start">
            <!-- Secondary menu items -->
            <li class="nav-item">
                <a class="nav-link" href="#">Banking</a>
            </li>
            <!-- ... other secondary items ... -->
            <li class="nav-item">
                <a class="nav-link" href="#">Mortgages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Mortgages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Mortgages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Mortgages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Mortgages</a>
            </li>

            <!-- ... -->
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.5/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
