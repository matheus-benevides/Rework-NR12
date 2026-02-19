/**
 * Configuração da API
 */
const API_URL_CURSO = '../apis/processa_cursos.php';

// --- ELEMENTOS DO DOM ---

// Formulário de Cadastro
const formCadCurso = document.getElementById('form-cad-curso');

// Formulário de Edição
const formEditCurso = document.getElementById('form-edit-curso');
const idCursoEdit = document.getElementById('id_curso_edit');
const nomeCursoEdit = document.getElementById('nome_curso_edit');

// Botão de Deletar (Modal)
const btnConfirmaDelete = document.getElementById('btn-confirmar-deletar-curso');
const idCursoDelete = document.getElementById('id_curso_delete');

// --- EVENT LISTENERS ---

// 1. CADASTRAR (POST)
if (formCadCurso) {
    formCadCurso.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nome = document.getElementById('nome_curso_cad').value;

        if (!nome) {
            alert('Por favor, preencha o nome do curso.');
            return;
        }

        const dados = { nome: nome };

        try {
            const response = await fetch(API_URL_CURSO, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('adicaoCurso');
                formCadCurso.reset();
                location.reload(); // Recarrega para mostrar o novo curso
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar cadastrar.');
        }
    });
}

// 2. PREPARAR EDIÇÃO (Chamado pelo botão na tabela)
function abrirModalEdicaoCurso(id, nome) {
    if (idCursoEdit && nomeCursoEdit) {
        idCursoEdit.value = id;
        nomeCursoEdit.value = nome;
        showModal('edicaoCurso');
    } else {
        console.error('Elementos do modal de edição não encontrados.');
    }
}

// 3. EDITAR (PUT)
if (formEditCurso) {
    formEditCurso.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = idCursoEdit.value;
        const nome = nomeCursoEdit.value;

        if (!id || !nome) {
            alert('Dados incompletos para edição.');
            return;
        }

        const dados = { id: id, nome: nome };

        try {
            const response = await fetch(API_URL_CURSO, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('edicaoCurso');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar editar.');
        }
    });
}



// 5. DESATIVAR / DELETAR (PATCH)
if (btnConfirmaDelete) {
    btnConfirmaDelete.addEventListener('click', async () => {
        const id = idCursoDelete.value;

        if (!id) {
            alert('ID não encontrado para deleção.');
            return;
        }

        const dados = { id: id, status: 'Inativo' };

        try {
            const response = await fetch(API_URL_CURSO, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('desativarCurso');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar desativar.');
        }
    });
}



// 7. ATIVAR (PATCH)
const btnConfirmaAtivar = document.getElementById('btn-confirmar-ativar-curso');
if (btnConfirmaAtivar) {
    btnConfirmaAtivar.addEventListener('click', async () => {
        const id = document.getElementById('id_curso_ativar').value;

        if (!id) {
            alert('ID não encontrado para ativação.');
            return;
        }

        const dados = { id: id, status: 'Ativo' };

        try {
            const response = await fetch(API_URL_CURSO, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('ativarCurso');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar ativar.');
        }
    });
}


// --- TURMAS ---

const API_URL_TURMA = '../apis/processa_turmas.php';

// Formulário de Cadastro Turma
const formCadTurma = document.getElementById('form-cad-turma');

// Formulário de Edição Turma
const formEditTurma = document.getElementById('form-edit-turma');
const idTurmaEdit = document.getElementById('id_turma_edit');
const nomeTurmaEdit = document.getElementById('nome_turma_edit');
const periodoTurmaEdit = document.getElementById('periodo_turma_edit');
const colaboradorTurmaEdit = document.getElementById('colaborador_turma_edit');
const inicioTurmaEdit = document.getElementById('inicio_turma_edit');
const fimTurmaEdit = document.getElementById('fim_turma_edit');
const cursoTurmaEdit = document.getElementById('curso_turma_edit');

// Botão de Deletar Turma (Modal)
const btnConfirmaDeleteTurma = document.getElementById('btn-confirmar-deletar-turma');
const idTurmaDelete = document.getElementById('id_turma_delete');

// Botão de Ativar Turma (Modal)
const btnConfirmaAtivarTurma = document.getElementById('btn-confirmar-ativar-turma');
const idTurmaAtivar = document.getElementById('id_turma_ativar');


// 1. CADASTRAR TURMA (POST)
if (formCadTurma) {
    formCadTurma.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nome = document.getElementById('nome_turma_cad').value;
        const periodo = document.getElementById('periodo_turma_cad').value;
        const colaborador = document.getElementById('colaborador_turma_cad').value;
        const inicio = document.getElementById('inicio_turma_cad').value;
        const fim = document.getElementById('fim_turma_cad').value;
        const curso = document.getElementById('curso_turma_cad').value;

        if (!nome || !periodo || !colaborador || !inicio || !fim || !curso) {
            alert('Por favor, preencha todos os campos da turma.');
            return;
        }

        const dados = {
            nome: nome,
            periodo: periodo,
            colaborador_id: colaborador,
            inicio: inicio,
            fim: fim,
            curso_id: curso
        };

        try {
            const response = await fetch(API_URL_TURMA, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('adicaoTurma');
                formCadTurma.reset();
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar cadastrar turma.');
        }
    });
}

// 2. PREPARAR EDIÇÃO TURMA
function abrirModalEdicaoTurma(id, nome, periodo, colaborador, inicio, fim, curso) {
    if (idTurmaEdit) {
        idTurmaEdit.value = id;
        nomeTurmaEdit.value = nome;
        periodoTurmaEdit.value = periodo;
        colaboradorTurmaEdit.value = colaborador;
        inicioTurmaEdit.value = inicio;
        fimTurmaEdit.value = fim;
        cursoTurmaEdit.value = curso;
        showModal('edicaoTurma');
    } else {
        console.error('Elementos do modal de edição de turma não encontrados.');
    }
}

// 3. EDITAR TURMA (PUT)
if (formEditTurma) {
    formEditTurma.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = idTurmaEdit.value;
        const nome = nomeTurmaEdit.value;
        const periodo = periodoTurmaEdit.value;
        const colaborador = colaboradorTurmaEdit.value;
        const inicio = inicioTurmaEdit.value;
        const fim = fimTurmaEdit.value;
        const curso = cursoTurmaEdit.value;

        if (!id || !nome || !periodo || !colaborador || !inicio || !fim || !curso) {
            alert('Dados incompletos para edição da turma.');
            return;
        }

        const dados = {
            id: id,
            nome: nome,
            periodo: periodo,
            colaborador_id: colaborador,
            inicio: inicio,
            fim: fim,
            curso_id: curso
        };

        try {
            const response = await fetch(API_URL_TURMA, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('edicaoTurma');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar editar turma.');
        }
    });
}



// 5. DESATIVAR TURMA (PATCH)
if (btnConfirmaDeleteTurma) {
    btnConfirmaDeleteTurma.addEventListener('click', async () => {
        const id = idTurmaDelete.value;

        if (!id) {
            alert('ID não encontrado para deleção.');
            return;
        }

        const dados = { id: id, status: 'Inativo' };

        try {
            const response = await fetch(API_URL_TURMA, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('deletarTurma');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar desativar turma.');
        }
    });
}



// 7. ATIVAR TURMA (PATCH)
if (btnConfirmaAtivarTurma) {
    btnConfirmaAtivarTurma.addEventListener('click', async () => {
        const id = document.getElementById('id_turma_ativar').value;

        if (!id) {
            alert('ID não encontrado para ativação.');
            return;
        }

        const dados = { id: id, status: 'Ativo' };

        try {
            const response = await fetch(API_URL_TURMA, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('ativarTurma');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar ativar turma.');
        }
    });
}

// --- ALUNOS ---

const API_URL_ALUNO = '../apis/processa_alunos.php';

const formCadAluno = document.getElementById('form-cad-aluno');
const formEditAluno = document.getElementById('form-edit-aluno');
const btnConfirmaDesativarAluno = document.getElementById('btn-confirmar-desativar-aluno');
const btnConfirmaAtivarAluno = document.getElementById('btn-confirmar-ativar-aluno');
const btnConfirmaDeletarAluno = document.getElementById('btn-confirmar-deletar-aluno');

// 1. CADASTRAR ALUNO (POST)
if (formCadAluno) {
    formCadAluno.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nome = document.getElementById('nome_aluno_cad').value;
        const matricula = document.getElementById('matricula_aluno_cad').value;
        const turma = document.getElementById('turma_aluno_cad').value;

        if (!nome || !matricula || !turma) {
            alert('Por favor, preencha todos os campos do aluno.');
            return;
        }

        const dados = { nome: nome, matricula: matricula, turma_id: turma };

        try {
            const response = await fetch(API_URL_ALUNO, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('adicaoAluno');
                formCadAluno.reset();
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao cadastrar aluno.');
        }
    });
}

// 2. EDITAR ALUNO (PUT)
if (formEditAluno) {
    formEditAluno.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = document.getElementById('id_aluno_edit').value;
        const nome = document.getElementById('nome_aluno_edit').value;
        const matricula = document.getElementById('matricula_aluno_edit').value;
        const turma = document.getElementById('turma_aluno_edit').value;

        if (!id || !nome || !matricula || !turma) {
            alert('Dados incompletos para edição do aluno.');
            return;
        }

        const dados = { id: id, nome: nome, matricula: matricula, turma_id: turma };

        try {
            const response = await fetch(API_URL_ALUNO, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.mensagem);
                closeModal('edicaoAluno');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao editar aluno.');
        }
    });
}

// 3. DESATIVAR ALUNO (PATCH)
if (btnConfirmaDesativarAluno) {
    btnConfirmaDesativarAluno.addEventListener('click', async () => {
        const id = document.getElementById('id_aluno_desativar').value;
        if (!id) return alert('ID não encontrado.');

        try {
            const response = await fetch(API_URL_ALUNO, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, status: 'Inativo' })
            });
            const result = await response.json();
            if (response.ok) {
                alert(result.mensagem);
                closeModal('desativarAluno');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao desativar.');
        }
    });
}

// 4. ATIVAR ALUNO (PATCH)
if (btnConfirmaAtivarAluno) {
    btnConfirmaAtivarAluno.addEventListener('click', async () => {
        const id = document.getElementById('id_aluno_ativar').value;
        if (!id) return alert('ID não encontrado.');

        try {
            const response = await fetch(API_URL_ALUNO, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, status: 'Ativo' })
            });
            const result = await response.json();
            if (response.ok) {
                alert(result.mensagem);
                closeModal('ativarAluno');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao ativar.');
        }
    });
}

// 5. DELETAR ALUNO (DELETE)
if (btnConfirmaDeletarAluno) {
    btnConfirmaDeletarAluno.addEventListener('click', async () => {
        const id = document.getElementById('id_aluno_delete').value;
        if (!id) return alert('ID não encontrado.');

        try {
            const response = await fetch(API_URL_ALUNO, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });
            const result = await response.json();
            if (response.ok) {
                alert(result.mensagem);
                closeModal('deletarAluno');
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao deletar.');
        }
    });
}

// 6. PREPARAR EDIÇÃO ALUNO
function abrirModalEdicaoAluno(id, nome, matricula, turma) {
    const idEdit = document.getElementById('id_aluno_edit');
    const nomeEdit = document.getElementById('nome_aluno_edit');
    const matriculaEdit = document.getElementById('matricula_aluno_edit');
    const turmaEdit = document.getElementById('turma_aluno_edit');

    if (idEdit && nomeEdit && matriculaEdit && turmaEdit) {
        idEdit.value = id;
        nomeEdit.value = nome;
        matriculaEdit.value = matricula;
        turmaEdit.value = turma;
        showModal('edicaoAluno');
    } else {
        console.error('Elementos do modal de edição de aluno não encontrados.');
    }
}

// Expõe as funções para o escopo global
window.abrirModalEdicaoCurso = abrirModalEdicaoCurso;
window.abrirModalEdicaoTurma = abrirModalEdicaoTurma;
window.abrirModalEdicaoAluno = abrirModalEdicaoAluno;
