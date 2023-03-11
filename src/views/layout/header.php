<?php

if ($this->layout == 'home') {
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

if ($this->layout == 'default') {
   include 'menu.php';  
}