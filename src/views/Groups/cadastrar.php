<?php

echo '
<div class = "card">
    <div class = "card-body">
        <form class="row g-3" action="' . base_url('/groups/store') . '" method = "POST">
  <div class="col-md-6">
    <label for="name" class="form-label">Nome grupo</label>
    <input type="text" class="form-control" name="name">
  </div>
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Salvar</button>
  </div>
</form>
    </div>
</div>
';
