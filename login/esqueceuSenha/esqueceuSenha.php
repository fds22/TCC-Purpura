<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Púrpura - Recuperar Senha</title>
    <link rel="shortcut icon" href="../html/css/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="esqueceuSenha.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="brand">
                <a href="index.html">
                    <h1>PÚRPURA</h1>
                    <p class="tagline">Brilhe em Púrpura</p>
                </a>
            </div>

            <h2 class="form-title">Redefinir Senha</h2>
            <p class="recovery-instruction">Digite seu e-mail e uma nova senha para redefinir sua conta.</p>
            
            <div class="error" id="error-message" style="display: none;"></div>
            
            <div class="success" id="success-message" style="display: none;">
                <i class="fas fa-check-circle"></i>
                <span id="success-text"></span>
            </div>
            
            <form class="recovery-form" method="POST" action="processaSenha.php">
                <div class="input-group">
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" placeholder="E-mail cadastrado" name="email" required id="email">
                </div>
                
                <div class="input-group">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" placeholder="Nova senha" name="nova_senha" required minlength="6" id="nova-senha">
                </div>
                
                <div class="input-group">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" placeholder="Confirmar nova senha" name="confirmar_senha" required minlength="6" id="confirmar-senha">
                </div>
                
                <button type="submit" class="btn-login">Redefinir Senha</button>
            </form>
            
            <div class="back-to-login">
                <a href="login.php"><i class="fas fa-arrow-left"></i> Voltar para o login</a>
            </div>
        </div>
        
        <div class="image-container">
            <div class="overlay"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.recovery-form');
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');
            const successText = document.getElementById('success-text');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = document.getElementById('email').value;
                const novaSenha = document.getElementById('nova-senha').value;
                const confirmarSenha = document.getElementById('confirmar-senha').value;
                
                // Validações básicas
                if (!email) {
                    showError('Por favor, informe seu e-mail.');
                    return;
                }
                
                if (!isValidEmail(email)) {
                    showError('Por favor, informe um e-mail válido.');
                    return;
                }
                
                if (novaSenha.length < 6) {
                    showError('A senha deve ter pelo menos 6 caracteres.');
                    return;
                }
                
                if (novaSenha !== confirmarSenha) {
                    showError('As senhas não coincidem.');
                    return;
                }
                
                // Se todas as validações passarem, enviar o formulário
                this.submit();
            });
            
            function showError(message) {
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
                successMessage.style.display = 'none';
                
                // Rolando para o topo do formulário para ver a mensagem de erro
                window.scrollTo(0, 0);
            }
            
            function showSuccess(message) {
                successText.textContent = message;
                successMessage.style.display = 'flex';
                errorMessage.style.display = 'none';
                
                // Rolando para o topo do formulário para ver a mensagem de sucesso
                window.scrollTo(0, 0);
            }
            
            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
            
            // Verificar se há parâmetros de erro ou sucesso na URL
            const urlParams = new URLSearchParams(window.location.search);
            const erro = urlParams.get('erro');
            const sucesso = urlParams.get('sucesso');
            
            if (erro) {
                showError(decodeURIComponent(erro));
            }
            
            if (sucesso) {
                showSuccess(decodeURIComponent(sucesso));
            }
        });
    </script>
</body>
</html>