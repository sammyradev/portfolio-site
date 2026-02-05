// CÓDIGO DE ROLAGEM "CÂMERA LENTA"

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Trava o clique padrão

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            const targetPosition = targetElement.offsetTop;
            const startPosition = window.pageYOffset;
            const distance = targetPosition - startPosition;
            
            // --- AQUI ESTÁ O CONTROLE DA LENTIDÃO ---
            // 3000 = 3 segundos. 
            // Se quiser MAIS lento, mude para 4000 ou 5000.
            const duration = 2000; 
            // ----------------------------------------

            let start = null;

            window.requestAnimationFrame(step);

            function step(timestamp) {
                if (!start) start = timestamp;
                const progress = timestamp - start;
                
                // Essa matemática garante que não dê "soquinhos"
                const ease = easeInOutCubic(progress, startPosition, distance, duration);
                
                window.scrollTo(0, ease);

                if (progress < duration) {
                    window.requestAnimationFrame(step);
                }
            }
        }
    });
});

// Função para o movimento ser macio (acelera no começo, freia no fim)
function easeInOutCubic(t, b, c, d) {
    t /= d / 2;
    if (t < 1) return c / 2 * t * t * t + b;
    t -= 2;
    return c / 2 * (t * t * t + 2) + b;
}

function validarEEnviar() {
    // 1. Validação do Robô
    var checkbox = document.getElementById("not-robot");
    if (!checkbox.checked) {
        alert("Por favor, confirme que você não é um robô.");
        return;
    }

    // 2. Validação dos Campos
    var nome = document.getElementById("nome").value;
    var email = document.getElementById("email").value;

    if (nome === "" || email === "") {
        alert("Por favor, preencha todos os campos obrigatórios.");
        return;
    }

    // 3. Preparação para Envio
    var botao = document.querySelector(".btn-submit");
    var textoOriginal = botao.innerHTML;
    
    botao.innerHTML = "Enviando...";
    botao.disabled = true;
    botao.style.backgroundColor = "#ccc";

    // Pega todos os dados do formulário
    var formulario = document.getElementById("form-orcamento");
    var dados = new FormData(formulario);

    // 4. Envia para o PHP (A Mágica)
    fetch("enviar.php", {
        method: "POST",
        body: dados
    })
    .then(response => response.text())
    .then(resultado => {
        if(resultado.trim() === "sucesso") {
            // SUCESSO!
            alert("✅ Solicitação enviada com sucesso! Cheque seu e-mail.");
            formulario.reset(); // Limpa os campos
            botao.innerHTML = "Enviado!";
            botao.style.backgroundColor = "#28a745"; // Verde
        } else {
            // ERRO NO PHP
            alert("❌ Ocorreu um erro ao enviar. Tente novamente ou nos chame no WhatsApp.");
            botao.innerHTML = textoOriginal;
            botao.disabled = false;
            botao.style.backgroundColor = "#ffcc00";
        }
    })
    .catch(error => {
        // ERRO DE REDE
        console.error("Erro:", error);
        alert("Erro de conexão. Verifique sua internet.");
        botao.innerHTML = textoOriginal;
        botao.disabled = false;
        botao.style.backgroundColor = "#ffcc00";
    });
}