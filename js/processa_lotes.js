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

    const fileInput = document.getElementById(inputId);
    const labelArquivo = form.querySelector('.label-arquivo');
    const dropArea = form.querySelector('.arquivos-div');

    if (fileInput) {
        fileInput.addEventListener('change', () => {
            const previewContainer = document.getElementById(`preview-${formId.split('-')[2]}`);
            const files = fileInput.files;

            if (files.length > 0) {
                if (labelArquivo) {
                    labelArquivo.textContent = files.length > 1
                        ? `${files.length} arquivos selecionados`
                        : files[0].name;
                    labelArquivo.style.color = 'var(--corDestaque)';
                }

                if (previewContainer) {
                    previewContainer.innerHTML = '';
                    Array.from(files).forEach((file, index) => {
                        const item = document.createElement('div');
                        item.className = 'arquivo-item';
                        item.innerHTML = `
                            <span><i class="bi bi-file-earmark-text"></i> ${file.name}</span>
                            <button type="button" class="remover-arquivo" data-index="${index}">
                                <i class="bi bi-trash"></i>
                            </button>
                        `;
                        previewContainer.appendChild(item);
                    });

                    previewContainer.querySelectorAll('.remover-arquivo').forEach(btn => {
                        btn.addEventListener('click', (e) => {
                            e.preventDefault();
                            const dt = new DataTransfer();
                            const idx = parseInt(btn.getAttribute('data-index'));
                            Array.from(fileInput.files)
                                .filter((_, i) => i !== idx)
                                .forEach(f => dt.items.add(f));
                            fileInput.files = dt.files;
                            fileInput.dispatchEvent(new Event('change'));
                        });
                    });
                }
            } else {
                if (labelArquivo) {
                    labelArquivo.textContent = 'Arraste ou Pressione o Arquivo.';
                    labelArquivo.style.color = '';
                }
                if (previewContainer) previewContainer.innerHTML = '';
            }
        });
    }

    // Suporte básico a Drag & Drop
    if (dropArea && fileInput) {
        ['dragover', 'dragenter'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropArea.style.borderColor = 'var(--corDestaque)';
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropArea.style.borderColor = 'var(--corBase)';
            });
        });

        dropArea.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        });
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!fileInput || !fileInput.files.length) {
            alert('Por favor, selecione um arquivo.');
            return;
        }

        const formData = new FormData();
        formData.append('arquivo', fileInput.files[0]);

        // Feedback visual
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
                let msg = `Processamento concluído.\n✅ Sucessos: ${result.sucesso}\n❌ Erros: ${result.erros_count}`;

                if (result.detalhes_erro && result.detalhes_erro.length > 0) {
                    msg += `\n\nDetalhes dos erros (primeiros 5):\n- ${result.detalhes_erro.slice(0, 5).join('\n- ')}`;
                    if (result.detalhes_erro.length > 5) {
                        msg += `\n... e mais ${result.detalhes_erro.length - 5} erros.`;
                    }
                }

                if (result.erros_count > 0) {
                    // Se houver erros, talvez seja melhor não usar a modal automática de sucesso
                    // ou criar uma modal de aviso/erro específica. 
                    // Por enquanto, vamos usar alert para casos com erro para não perder o texto longo,
                    // ou registrar no sessionStorage se o usuário preferir.
                    alert(msg);
                    location.reload();
                } else {
                    sessionStorage.setItem('pendingSuccessMessage', `Sucesso! Total de ${result.sucesso} registros processados.`);
                    location.reload();
                }
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
