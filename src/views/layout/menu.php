<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <div class="sidebar">
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="<?php echo base_url('/dashboard');?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                    
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Clientes</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('/clientes');?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Listar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/clientes/cadastrar');?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Cadastrar</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Grupos</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('/grupos');?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Listar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/grupos/cadastrar');?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Cadastrar</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Usuarios</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('/usuarios');?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Listar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/usuarios/cadastrar');?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Cadastrar</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>

