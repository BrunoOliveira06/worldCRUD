document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalClima');
    const btnFechar = modal.querySelector('.close');
    const cidadeNomeModal = document.getElementById('cidadeNomeModal');
    const climaConteudo = document.getElementById('climaConteudo');

    // Função para abrir o modal e buscar os dados
    document.querySelectorAll('.btn-clima').forEach(button => {
        button.addEventListener('click', function() {
            const nomeCidade = this.getAttribute('data-nome');
            cidadeNomeModal.textContent = nomeCidade;
            climaConteudo.innerHTML = '<p>Carregando dados de clima da API...</p>';
            modal.style.display = 'block';

            // Requisição AJAX para o script PHP
            fetch(`api_clima.php?nome=${encodeURIComponent(nomeCidade)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        climaConteudo.innerHTML = `<p style="color: red;">Erro: ${data.erro}</p>`;
                    } else {
                        let html = `
                            <p><strong>Condição:</strong> ${data.descricao}</p>
                            <p><strong>Temperatura Atual:</strong> ${data.temperatura}°C</p>
                            <p><strong>Mínima/Máxima:</strong> ${data.minima}°C / ${data.maxima}°C</p>
                            <p><strong>Umidade:</strong> ${data.umidade}%</p>
                            <p><strong>Vento:</strong> ${data.vento} m/s</p>
                        `;
                        climaConteudo.innerHTML = html;
                    }
                })
                .catch(error => {
                    climaConteudo.innerHTML = `<p style="color: red;">Erro ao buscar dados: ${error.message}</p>`;
                });
        });
    });

    // Função para fechar o modal
    btnFechar.onclick = function() {
        modal.style.display = 'none';
    }

    // Fechar o modal se o usuário clicar fora dele
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
