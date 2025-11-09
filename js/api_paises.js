document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalDetalhes');
    const btnFechar = modal.querySelector('.close');
    const paisNomeModal = document.getElementById('paisNomeModal');
    const detalhesConteudo = document.getElementById('detalhesConteudo');

    // Função para abrir o modal e buscar os dados
    document.querySelectorAll('.btn-detalhes').forEach(button => {
        button.addEventListener('click', function() {
            const nomePais = this.getAttribute('data-nome');
            paisNomeModal.textContent = nomePais;
            detalhesConteudo.innerHTML = '<p>Carregando detalhes da API...</p>';
            modal.style.display = 'block';

            // Requisição AJAX para o script PHP
            fetch(`paises/api_detalhes.php?nome=${encodeURIComponent(nomePais)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        detalhesConteudo.innerHTML = `<p style="color: red;">Erro: ${data.erro}</p>`;
                    } else {
                        let html = `
                            <p><strong>Capital:</strong> ${data.capital}</p>
                            <p><strong>Região:</strong> ${data.regiao} (${data.subregiao})</p>
                            <p><strong>Moeda:</strong> ${data.moeda} (${data.moeda_nome})</p>
                        `;
                        if (data.bandeira_url) {
                            html += `<p><strong>Bandeira:</strong></p><img src="${data.bandeira_url}" alt="Bandeira" style="width: 100px; border: 1px solid #ccc;">`;
                        }
                        detalhesConteudo.innerHTML = html;
                    }
                })
                .catch(error => {
                    detalhesConteudo.innerHTML = `<p style="color: red;">Erro ao buscar dados: ${error.message}</p>`;
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
