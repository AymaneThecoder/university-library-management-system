<!-- Footer -->

<footer class="footer">
        <nav class="navbar navbar-expand">
            <div class="container">
                    <a href="http://localhost/management-of-library/public/home.php" class="navbar-brand">
                        <h3>
                            ESTLib
                        </h3>
                    </a>
                <div class="navbar-right">
                    <div class="navbar-nav gap-2 gap-sm-4">
                       <a href="home.php" class="navbar-link text-decoration-none <?= @$_GET['doc_type'] == '' ? 'active' : '' ?>">Accueil</a>
                       <a href="search.php?doc_type=article" class="navbar-link text-decoration-none <?= @$_GET['doc_type'] == 'article' ? 'active' : '' ?>">Articles</a>
                       <a href="search.php?doc_type=livre" class="navbar-link text-decoration-none <?= @$_GET['doc_type'] == 'livre' ? 'active' : '' ?>">Livres</a>
                       <a href="search.php?doc_type=periodique" class="navbar-link text-decoration-none <?= @$_GET['doc_type'] == 'periodique' ? 'active' : '' ?>">Periodiques</a>
                    </div>
                </div>
            </div>
         </nav> 
</footer>