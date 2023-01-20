<?php ?>
<div class = "card">
    <div class = "card-body">
        <form class="row g-3" action="<?php echo base_url('/clientes/store');?>" method = "POST">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome">
            </div>
            
            <div class="col-md-6">
                <label for="tipo_pessoa" class="form-label">Tipo Pessoa</label>
                <select id="tipo_pessoa" name="tipo_pessoa" class="form-select">
                    <option disabled selected value> selecione </option>
                    <option value="F">Fisica</option>
                    <option value="J">Juridica</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="papel" class="form-label">Tipo</label>
                <select id="papel" name="papel" class="form-select">
                    <option disabled selected value> selecione </option>
                    <option value="C">Cliente</option>
                    <option value="F">Fornecedor</option>
                    <option value="I">Funcionario</option>
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

