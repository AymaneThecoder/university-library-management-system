        

        <nav class="navbar navbar-expand sticky-top bg-white">
            <div class="container py-2 px-3 px-sm-0">
                       <!-- LOGO -->
                   <a class="navbar-brand" href="home.php">
                       <h2>jaliss</h2>
                   </a>

                  <!-- nav links -->
                  <?php
                        require_once 'nav-links.php';
                    ?>
                    
                   <ul class="navbar-nav navbar-right align-items-center column-gap-2">
                       <li class="nav-item">
                            <a href="signup.php" class="signup-btn btn btn-lg  btn-outline-secondary">Creer votre compte</a>
                       </li>
                       <li class="nav-item">
                            <a href="login.php" class="signin-btn btn btn-lg btn-primary">Se connecter</a>
                       </li>
                   </ul>

                   <!--Navbar right Dropdown for smaller devices -->
                   <div class="login-dropdown dropdown d-none">
                       <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
                           <i class="fa fa-user"></i>
                       </button>
                       <div class="dropdown-menu dropdown-menu-end">
                           <li class="dropdown-item">
                               <a class="signup-btn-dropdown btn btn-outline-secondary w-100">Creer votre compte</a>
                           </li>
                           <li class="dropdown-item">
                               <a class="signin-btn-dropdown btn btn-primary w-100">Se connecter</a>
                           </li>
                       </div>
                   </div>

               <!-- navbar small toggler button -->
               <button class="slide-navbar-toggler-btn d-none btn">
                   <i class="fa fa-bars"></i>
               </button>
            </div>

            <!-- Navbar for tablet and mobile devices -->
            <div class="navbar-small-devices">
               <button class="slide-navbar-close-btn btn">
                   <i class="fa fa-close"></i>
               </button>
               <div class="navbar-action-btns mb-5 d-flex p-2 column-gap-1">
                   <a href="#" class="signup-tbn btn btn-secondary w-50">Creer votre compte</a>
                   <a href="#" class="signin-btn btn btn-primary w-50 d-flex justify-content-center align-items-center">Se connecter</a>
               </div>
               <ul class="navbar-nav d-flex flex-column">
                   <li><a class="nav-link active" href="#">Tous</a></li>
                   <li><a class="nav-link" href="#">Articles</a></li>
                   <li><a class="nav-link" href="#">Livres</a></li>
                   <li><a class="nav-link" href="#">Periodiques</a></li>
               </ul>
                <!-- burger menu LOGO -->
                <a class="navbar-brand" href="booksExploreView.html">
                   <h2>jaliss</h2>
               </a>
            </div>
           </nav>
       