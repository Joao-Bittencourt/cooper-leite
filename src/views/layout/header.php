<?php

if (isset($this->layout) && $this->layout == 'home') {
    echo
    '<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <span class="fs-4">Cooper Leite</span>
        </a>

        <ul class="nav nav-pills align-items-center">
            <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Sobre</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Contato</a></li>
        </ul>
    </header>
</div>';
}

if (isset($this->layout) &&  $this->layout == 'default') {
    echo "
    <nav class='main-header navbar navbar-expand navbar-white navbar-light'>
        <ul class='navbar-nav'>
            <li class='nav-item'>
                <a class='nav-link' data-widget='pushmenu' href='#' role='button'><i class='bi bi-list'></i></a>
            </li>
            <li class='nav-item d-none d-sm-inline-block'>
                <a href='". base_url('/') ."'class='nav-link'>Home</a>
            </li>
            <li class='nav-item d-none d-sm-inline-block'>
                <a href='#' class='nav-link'>Contact</a>
            </li>
        </ul>
        <ul class='navbar-nav ml-auto'>
            <li class='nav-item'>
            <a href='". base_url('/auth/user/logout') ."' class='btn btn-sm btn-danger' title='sair'>
                    <i class='bi bi-box-arrow-left'></i>
            </a>
            </li>
        <ul/>
    </nav>";
    
   include_once 'menu.php';  
}