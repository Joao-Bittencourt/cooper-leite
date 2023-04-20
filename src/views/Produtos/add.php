<?php ?>
<div class = "card">
    <div class = "card-body">
        <form class="row g-3" action="<?php echo base_url('/produtos/store');?>" method = "POST">
            <div class="row">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome">
                </div>
            </div>
            <div class="col-md-12">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" name="descricao">
            </div>
            <div class="col-6">
                <label for="unidade" class="form-label">Unidade</label>
                <input type="text" class="form-control" name="unidade">
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>
</div>

