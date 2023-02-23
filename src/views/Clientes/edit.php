<?php
$cliente = array_get($this->data, 'Cliente');

if (!empty($cliente)) {
    ?>

    <form action="<?php echo base_url("/clientes/update/{$cliente->id}"); ?>" method = "POST">
        <div class = "card">
            <div class = "card-body">
                <div class="row g-3 mb-3">
                    <input type="hidden" class="form-control" name="id" value="<?php echo $cliente->id ?? ''; ?>">
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" value="<?php echo $cliente->nome ?? ''; ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="tipo_pessoa" class="form-label">Tipo Pessoa</label>
                        <select id="tipo_pessoa" name="tipo_pessoa" onchange='tipoPessoa()' class="form-select">
                            <option disabled selected value> selecione </option>
                            <?php foreach ($cliente->clienteTipoPessoa as $chave => $valor) { ?>
                                <option <?php
                                if ($chave === $cliente->tipo_pessoa) {
                                    echo 'selected';
                                }
                                ?> 
                                    value="<?php echo $chave; ?>"><?php echo $valor; ?>
                                </option>
                            <?php }
                            ?>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3 ">
                        <label for="papel" class="form-label">Tipo</label>
                        <select id="papel" name="papel" class="form-select">
                            <option disabled selected value> selecione </option>
                            <?php foreach ($cliente->clientePapel as $chave => $valor) { ?>
                                <option 
                                <?php
                                if ($chave === $cliente->papel) {
                                    echo 'selected';
                                }
                                ?> 
                                    value="<?php echo $chave; ?>"><?php echo $valor; ?>
                                </option>
                            <?php }
                            ?>

                        </select>
                    </div>
                </div>

                <div class="row mt-2 mb-3 " id="tipo-pessoa-fisica">
                    <label for="PessoaFisica-panel" class="fw-bold border-bottom">Pessoa fisica</label>
                    <input type="hidden" class="form-control" name="PessoaFisica-id" value="<?php echo $cliente->pessoaFisica->id ?? ''; ?>">
                    <div class="col-md-6">
                        <label for="PessoaFisica-nome_civil" class="form-label">Nome social</label>
                        <input type="text" class="form-control" name="PessoaFisica-nome_civil" value="<?php echo $cliente->pessoaFisica->nome_civil ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="PessoaFisica-dt_nascimento" class="form-label">Data nascimento</label>
                        <input type="text" class="form-control" name="PessoaFisica-dt_nascimento" value="<?php echo $cliente->pessoaFisica->dt_nascimento ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="PessoaFisica-cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" name="PessoaFisica-cpf" value="<?php echo $cliente->pessoaFisica->cpf ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="PessoaFisica-rg" class="form-label">RG</label>
                        <input type="text" class="form-control" name="PessoaFisica-rg" value="<?php echo $cliente->pessoaFisica->rg ?? ''; ?>">
                    </div>
                </div>
                <div class="row" id="tipo-pessoa-juridica">
                    <input type="hidden" class="form-control" name="PessoaJuridica-id" value="<?php echo $cliente->pessoaJuridica->id ?? ''; ?>">
                    <label for="PessoaJuridica-panel" class="fw-bold border-bottom">Pessoa juridica</label>
                    <div class="col-md-6">
                        <label for="PessoaJuridica-cnpj" class="form-label">CNPJ</label>
                        <input type="text" class="form-control" name="PessoaJuridica-cnpj" value="<?php echo $cliente->pessoaJuridica->cnpj ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="PessoaJuridica-razao_social" class="form-label">Razao social</label>
                        <input type="text" class="form-control" name="PessoaJuridica-razao_social" value="<?php echo $cliente->pessoaJuridica->razao_social ?? ''; ?>">
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
            var tipo_pessoa = document.getElementById('tipo_pessoa').value;
            if (tipo_pessoa == "F") {
                document.getElementById('tipo-pessoa-fisica').style.display = '';
                document.getElementById('tipo-pessoa-juridica').style.display = "none";
            }

            if (tipo_pessoa == "J") {
                document.getElementById('tipo-pessoa-juridica').style.display = '';
                document.getElementById('tipo-pessoa-fisica').style.display = "none";
            }
        }
        tipoPessoa()
    </script> 
    <?php
}