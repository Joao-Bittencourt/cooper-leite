<?php ?>
<form action="<?php echo base_url('/clientes/store'); ?>" method = "POST">
    <div class = "card">
        <div class = "card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome">
                </div>

                <div class="col-md-6">
                    <label for="pessoa" class="form-label">Tipo Pessoa</label>
                    <select id="pessoa" name="pessoa" onchange='tipoPessoa()' class="form-select">
                        <option disabled selected value> selecione </option>
                        <option value="F">Fisica</option>
                        <option value="J">Juridica</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3 ">
                    <label for="papel" class="form-label">Tipo</label>
                    <select id="papel" name="papel" class="form-select">
                        <option disabled selected value> selecione </option>
                        <option value="C">Cliente</option>
                        <option value="F">Fornecedor</option>
                        <option value="I">Funcionario</option>
                    </select>
                </div>
            </div>

            <div class="row mt-2 mb-3 " id="tipo-pessoa-fisica">
                <label for="PessoaFisica-panel" class="fw-bold border-bottom">Pessoa fisica</label>
                <div class="col-md-6">
                    <label for="PessoaFisica-nome_civil" class="form-label">Nome social</label>
                    <input type="text" class="form-control" name="PessoaFisica-nome_civil">
                </div>
                <div class="col-md-6">
                    <label for="PessoaFisica-dt_nascimento" class="form-label">Data nascimento</label>
                    <input type="text" class="form-control" name="PessoaFisica-dt_nascimento">
                </div>
                <div class="col-md-6">
                    <label for="PessoaFisica-cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" name="PessoaFisica-cpf">
                </div>
                <div class="col-md-6">
                    <label for="PessoaFisica-rg" class="form-label">RG</label>
                    <input type="text" class="form-control" name="PessoaFisica-rg">
                </div>
            </div>
            <div class="row" id="tipo-pessoa-juridica">
                <label for="PessoaJuridica-panel" class="fw-bold border-bottom">Pessoa juridica</label>
                <div class="col-md-6">
                    <label for="PessoaJuridica-cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" name="PessoaJuridica-cnpj">
                </div>
                <div class="col-md-6">
                    <label for="PessoaJuridica-razao_social" class="form-label">Razao social</label>
                    <input type="text" class="form-control" name="PessoaJuridica-razao_social">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</form>
<script>

    document.getElementById('tipo-pessoa-fisica').style.display = "none";
    document.getElementById('tipo-pessoa-juridica').style.display = "none";

    function tipoPessoa() {
        var pessoa = document.getElementById('pessoa').value;
        if (pessoa == "F") {
            document.getElementById('tipo-pessoa-fisica').style.display = '';
            document.getElementById('tipo-pessoa-juridica').style.display = "none";
        }

        if (pessoa == "J") {
            document.getElementById('tipo-pessoa-juridica').style.display = '';
            document.getElementById('tipo-pessoa-fisica').style.display = "none";
        }
    }

</script> 
