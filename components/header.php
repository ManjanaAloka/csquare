<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CSQUARE ERP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= setActiveNav("customers") ?>" href="?page=customers" id="nav-customers">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= setActiveNav("items") ?> " href="?page=items" id="nav-items">Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= setActiveNav("reports") ?>" href="?page=reports" id="nav-reports">Reports</a>
                </li>
            </ul>
        </div>
    </div>
</nav>|