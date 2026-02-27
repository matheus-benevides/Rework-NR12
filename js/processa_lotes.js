/**
 * Sistema Centralizado de Processamento de Lotes
 * Concentra toda a lógica de upload de arquivos CSV/Excel e feedback para o usuário.
 */

const API_BASE_LOTE = '../apis/processa_lote/';

/**
 * Função genérica para envio de lote
 * @param {string} formId ID do formulário
 * @param {string} inputId ID do input de arquivo
 * @param {string} apiPath Caminho da API relativa a API_BASE_LOTE
 */
async function processarLote(formId, inputId, apiPath) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const fileInput = document.getElementById(inputId);
        if (!fileInput || !fileInput.files.length) {
            alert('Por favor, selecione um arquivo.');
            return;
        }

        const formData = new FormData();
        formData.append('arquivo', fileInput.files[0]);

        // Feedback visual (opcional)
        const btnSubmit = form.querySelector('button[type="submit"]');
        const originalText = btnSubmit.innerHTML;
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processando...';

        try {
            const response = await fetch(API_BASE_LOTE + apiPath, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                let msg = `Processamento concluído.\n\n✅ Sucessos: ${result.sucesso}\n❌ Erros: ${result.erros_count}`;

                if (result.detalhes_erro && result.detalhes_erro.length > 0) {
                    msg += `\n\nDetalhes dos erros:\n- ${result.detalhes_erro.slice(0, 5).join('\n- ')}`;
                    if (result.detalhes_erro.length > 5) {
                        msg += `\n... e mais ${result.detalhes_erro.length - 5} erros.`;
                    }
                }

                alert(msg);
                location.reload();
            } else {
                alert('Erro: ' + (result.mensagem || 'Falha ao processar arquivo.'));
            }
        } catch (error) {
            console.error('Erro no processamento de lote:', error);
            alert('Erro crítico ao processar cadastro em lote. Verifique o console.');
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalText;
        }
    });
}

// Inicializar Listeners quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    // Alunos
    processarLote('form-cad-aluno-lote', 'arquivo-aluno', 'lote_aluno.php');

    // Cursos
    processarLote('form-cad-curso-lote', 'arquivo-curso', 'lote_curso.php');

    // Turmas
    processarLote('form-cad-turma-lote', 'arquivo-turma', 'lote_turma.php');

    // Unidades
    processarLote('form-cad-unidade-lote', 'arquivo-unidade', 'lote_unidade.php');

    // Setores
    processarLote('form-cad-setor-lote', 'arquivo-setor', 'lote_setor.php');

    // Colaboradores
    processarLote('form-cad-colaborador-lote', 'arquivo-colaborador', 'lote_colaborador.php');
});
