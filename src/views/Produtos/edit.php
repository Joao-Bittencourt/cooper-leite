<?php
$produto = array_get((array) $this->data, 'produto');

if (!empty($produto)) {
    ?>

    <form action="<?php echo base_url("/produtos/update/{$produto->id}"); ?>" method = "POST">
        <div class = "card">
            <div class = "card-body">
                <div class="row g-3 mb-3">
                    <input type="hidden" class="form-control" name="id" value="<?php echo $produto->id ?? ''; ?>">
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" value="<?php echo $produto->nome ?? ''; ?>">
                    </div>


                </div>

                <div class="row mt-2 mb-3">

                    <div class="col-md-6">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" name="descricao" value="<?php echo $produto->descricao ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="unidade" class="form-label">Unidade</label>
                        <input type="text" class="form-control" name="unidade" value="<?php echo $produto->unidade ?? ''; ?>">
                    </div>

                </div>
                <div class="card-footer">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
    </form>
    <?php
}