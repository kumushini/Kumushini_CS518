<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kumushini's demo</title>

    <link rel="stylesheet" type="text/css" href="./assets/css/distcssbootstrap453.min.css" />

</head>

<body>
    <!-- <h1>Hello, world!</h1> -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="./index.php">Archiveia</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Content</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="./src/logout.php">Sign Out</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action 1</a>
                        <a class="dropdown-item" href="#">Action 2</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Action 3</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
        </div>
    </nav>

    <div class="jumbotron">
        <div clas="container">
            <h1 class="display-4 ml-5">Knowledge is the key to success</h1>
            <h2 class="text-muted ml-5">Welcome to the Archiveia digital library</h2>
        </div>
        <hr class="my-4">
        <div class="container warapper">
            <form class="input-group input-group-lg">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div class="mt-3">

                <!-- <p class="lead">Libraries store the energy that fuels the imagination. 
                    They open up windows to the world and inspire us to explore and achieve, 
                    and contribute to imroving our quality of life.</p>
                <p class="lead">Sidney Sheldon<p>   -->

                <blockquote class="blockquote">
                    <p class="mb-0">Libraries store the energy that fuels the imagination.
                        They open up windows to the world and inspire us to explore and achieve,
                        and contribute to imroving our quality of life.</p>
                    <footer class="blockquote-footer">Sidney Sheldon</cite></footer>
                </blockquote>



            </div>
        </div>
        <hr class="my-4">
        <div class="container warapper">
            <!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="./src/signup.php" role="button">Sign Up</a>
                <a class="btn btn-primary btn-lg" href="./src/login.php" role="button">Log in</a>
            </p>
        </div>
    </div>


    <script src="./assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
</body>

</html>