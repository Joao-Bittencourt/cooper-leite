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
                            <a class="dropdown-item"  href="<?php echo base_url('/groups/cadastrar'); ?>">Cadastrar</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle">
                        Clientes
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('/clientes'); ?>">Listar</a>
                        </li>
                        <li>
                            <a class="dropdown-item"  href="<?php echo base_url('/clientes/add'); ?>">Cadastrar</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>