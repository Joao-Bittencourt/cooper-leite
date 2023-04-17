<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <div class="sidebar">
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="<?php echo base_url('/dashboard'); ?>" class="nav-link">
                        <i class="bi bi-speedometer"></i>
                        <p> Dashboard </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-person-video"></i>
                        <p>Clientes</p>
                        <i class="right bi bi-caret-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('/clientes'); ?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Listar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/clientes/cadastrar'); ?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Cadastrar</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-box"></i>
                        <p>Produtos</p>
                        <i class="right bi bi-caret-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('/produtos'); ?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Listar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('/produtos/cadastrar'); ?>" class="nav-link">
                                <i class="far nav-icon"></i>
                                <p>Cadastrar</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear"></i>
                        <p>Config</p>
                        <i class="right bi bi-caret-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="bi bi-people"></i>
                                <p>Grupos</p>
                                <i class="right bi bi-caret-left"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo base_url('/grupos'); ?>" class="nav-link">
                                        <i class="far nav-icon"></i>
                                        <p>Listar</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url('/grupos/cadastrar'); ?>" class="nav-link">
                                        <i class="far nav-icon"></i>
                                        <p>Cadastrar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="bi bi-person"></i>
                                <p>Usuarios</p>
                                <i class="right bi bi-caret-left"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo base_url('/usuarios'); ?>" class="nav-link">
                                        <i class="far nav-icon"></i>
                                        <p>Listar</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url('/usuarios/cadastrar'); ?>" class="nav-link">
                                        <i class="far nav-icon"></i>
                                        <p>Cadastrar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>

