<h1>Cadastrar planos</h1>
<form action="?page=salvar-planos" method="POST">
    <input type="hidden" name="acao" value="cadastrar">
    
    <div class="mb-3">
        <label>Nome do Plano</label>
        <select name="NomePlano" class="form-control" required>
            <option value="" disabled selected>Escolha o Nome do Plano</option>
            <option value="Plano Básico">Plano Básico</option>
            <option value="Plano Gold">Plano Gold</option>
            <option value="Plano Diamond">Plano Diamond</option>
            </select>
    </div>
    
    <div class="mb-3">
        <label>Valor Mensal
            <input type="number" step="0.01" name="ValorMensal" class="form-control" required>
            
        </label>
    </div>
    
    <div class="mb-3">
        <label>Duração meses
            <input type="number" name="DuracaoMeses" class="form-control" required>
        </label>
    </div>
    
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</form>