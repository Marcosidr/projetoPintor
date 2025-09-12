<div class="container my-5">
  <h2 class="text-center mb-4">Registrar</h2>
  <form method="post" action="/register">
    <div class="mb-3">
      <label for="nome" class="form-label">Nome</label>
      <input type="text" class="form-control" id="nome" name="nome" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">E-mail</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
      <label for="senha" class="form-label">Senha</label>
      <input type="password" class="form-control" id="senha" name="senha" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Registrar</button>
  </form>
</div>
