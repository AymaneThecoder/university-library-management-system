

<ul class="navbar-nav navbar-center column-gap-5">
    <li class="nav-item">
        <a href="home.php" class="nav-link <?= @$_GET['doc_type'] == '' ? 'active' : '' ?>">Accueil</a>
    </li>
    <li class="nav-item">
        <a href="search.php?doc_type=article" class="nav-link <?= @$_GET['doc_type'] == 'article' ? 'active' : '' ?>">Articles</a>
    </li>
    <li class="nav-item">
        <a href="search.php?doc_type=livre" class="nav-link <?= @$_GET['doc_type'] == 'livre' ? 'active' : '' ?>">Livres</a>
    </li>
    <li class="nav-item">
        <a href="search.php?doc_type=periodique" class="nav-link <?= @$_GET['doc_type'] == 'periodique' ? 'active' : '' ?>">Periodiques</a>
    </li>
</ul>