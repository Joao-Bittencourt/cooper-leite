<?php ?>

<!doctype html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </head>
    <body>
        <style>
            .nav-link {
                color: white !important;
            }
            .dropdown-menu > li:hover > ul.dropdown-menu {
                display: block;
            }
            .dropdown-submenu {
                position:relative;
            }
            .dropdown-submenu > .dropdown-menu {
                top: 0;
                right: 100%;
                margin-top:-6px;
            }

            /* rotate caret on hover */
            .dropdown-menu > li > a:hover:after {
                text-decoration: underline;
                transform: rotate(90deg);
            } 

        </style>
        <div class="card rounded-0 bg-primary mb-3" style="--bs-bg-opacity: .5;">

            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link btn btn-secondary" href="<?php echo base_url('/'); ?>">Home</a>
                </li>
                
                <li class="nav-item d-flex ms-auto">
                    <a class="nav-link btn btn-secondary dropdown-toggle" type="button" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Configs
                    </a>
                    <ul class="dropdown-menu dropstart" aria-labelledby="navbarDropdownMenuLink">
                        
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle">
                                Usuarios
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="<?php echo base_url('/users'); ?>">Listar</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"  href="<?php echo base_url('/users/cadastrar'); ?>">Cadastrar</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle">
                                Grupos
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="<?php echo base_url('/groups'); ?>">Listar</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"  href="<?php echo base_url('/groups/adastrar'); ?>">Cadastrar</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="container">
            <?php display_flash_message(); ?>
