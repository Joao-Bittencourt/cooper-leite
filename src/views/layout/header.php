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

        </style>
        <div class="card rounded-0 bg-primary mb-3" style="--bs-bg-opacity: .5;">

            <ul class="nav nav-pills">
                <li class="nav-item">
                    
                   <a class="nav-link btn btn-secondary" href="<?php echo base_url('/');?>">Home</a>
                   
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        User
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('/users');?>">Listar</a>
                        </li>
                        <li>
                            <a class="dropdown-item"  href="<?php echo base_url('/users/cadastrar');?>">Cadastrar</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="container">
