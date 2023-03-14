<?php ?>
<div class="row justify-content-center">
    <div class="card">
        <div class="card-body">
            <div>CooperLeite</div>

            <form action="<?php echo base_url('/auth'); ?>" method = "POST">
                <div class="form-group">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" class="form-control" name="login">
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <!--                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me"> Remember Me
                                    </label>
                                </div>-->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>   
            </form>
        </div>
    </div>
</div>