<?php ?>
<div class = "card">
    <div class = "card-body">
        <form class="row g-3" action="<?php echo base_url('/users/store');?>" method = "POST">
            <div class="col-md-6">
                <label for="login" class="form-label">Login</label>
                <input type="text" class="form-control" name="login">
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="col-6">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email">
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>
</div>

