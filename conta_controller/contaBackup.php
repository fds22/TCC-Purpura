<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consulta CEP</title>
    <script>
    function buscarCEP() {
        const cep = document.getElementById("cep").value;

        if (cep.length !== 8 || isNaN(cep)) {
            alert("Digite um CEP válido com 8 dígitos numéricos.");
            return;
        }

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => {
                if (!response.ok) throw new Error("Erro ao consultar o CEP");
                return response.json();
            })
            .then(data => {
                if (data.erro) {
                    alert("CEP não encontrado!");
                    return;
                }

                // Preencher os campos
                document.getElementById("rua").value = data.logradouro;
                document.getElementById("bairro").value = data.bairro;
                document.getElementById("cidade").value = data.localidade;
                document.getElementById("uf").value = data.uf;
            })
            .catch(error => {
                console.error("Erro:", error);
                alert("Erro ao buscar CEP.");
            });
    }
    </script>
</head>
<body>
    <h2>Cadastro de Endereço</h2>
    <form>
        <label>CEP:</label>
        <input type="text" id="cep" maxlength="8" required>
        <button type="button" onclick="buscarCEP()">Buscar</button><br><br>

        <label>Rua:</label>
        <input type="text" id="rua" name="rua"><br><br>

        <label>Bairro:</label>
        <input type="text" id="bairro" name="bairro"><br><br>

        <label>Cidade:</label>
        <input type="text" id="cidade" name="cidade"><br><br>

        <label>UF:</label>
        <input type="text" id="uf" name="uf"><br><br>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
