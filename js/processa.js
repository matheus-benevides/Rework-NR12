/**
 * Configuração da API e manipulação de requisições.
 * As APIs suportam o método OPTIONS para preflight CORS.
 */
const API_URL_CURSO = '../apis/processa_cursos.php';
const API_URL_SUPORTE = '../apis/processa_suporte.php';

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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
const API_URL_LOTE_ALUNO = '../apis/processa_lote/lote_aluno.php';

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
        const email = document.getElementById('email_aluno_cad').value;
        const matricula = document.getElementById('matricula_aluno_cad').value;
        const turma = document.getElementById('turma_aluno_cad').value;

        if (!nome || !matricula || !turma) {
            alert('Por favor, preencha todos os campos do aluno.');
            return;
        }

        const dados = { nome: nome, email: email, matricula: matricula, turma_id: turma };
        console.log('Enviando dados do aluno:', dados);

        try {
            const response = await fetch(API_URL_ALUNO, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            console.log('Resposta da API (status):', response.status);
            const result = await response.json();
            console.log('Resultado da API:', result);

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
        const email = document.getElementById('email_aluno_edit').value;
        const matricula = document.getElementById('matricula_aluno_edit').value;
        const turma = document.getElementById('turma_aluno_edit').value;

        if (!id || !nome || !matricula || !turma) {
            alert('Dados incompletos para edição do aluno.');
            return;
        }

        const dados = { id: id, nome: nome, email: email, matricula: matricula, turma_id: turma };

        try {
            const response = await fetch(API_URL_ALUNO, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
                exibirSucesso(result.mensagem);
                closeModal('desativarAluno');
                setTimeout(() => location.reload(), 1500);
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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
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
function abrirModalEdicaoAluno(id, nome, email, matricula, turma) {
    const idEdit = document.getElementById('id_aluno_edit');
    const nomeEdit = document.getElementById('nome_aluno_edit');
    const emailEdit = document.getElementById('email_aluno_edit');
    const matriculaEdit = document.getElementById('matricula_aluno_edit');
    const turmaEdit = document.getElementById('turma_aluno_edit');

    if (idEdit && nomeEdit && emailEdit && matriculaEdit && turmaEdit) {
        idEdit.value = id;
        nomeEdit.value = nome;
        emailEdit.value = email;
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
window.abrirModalEdicaoUnidade = abrirModalEdicaoUnidade;


// --- UNIDADES ---

const API_URL_UNIDADE = '../apis/processa_unidade.php';

const formCadUnidade = document.getElementById('form-cad-unidade');
const formEditUnidade = document.getElementById('form-edit-unidade');
const btnConfirmaDesativarUnidade = document.getElementById('btn-confirmar-desativar-unidade');
const btnConfirmaAtivarUnidade = document.getElementById('btn-confirmar-ativar-unidade');

// 1. CADASTRAR UNIDADE (POST)
if (formCadUnidade) {
    formCadUnidade.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nome = document.getElementById('nome_unidade_cad').value;
        const cidade = document.getElementById('cidade_unidade_cad').value;
        const estado = document.getElementById('estado_unidade_cad').value;
        const numero = document.getElementById('numero_unidade_cad').value;

        if (!nome || !cidade || !estado) {
            alert('Por favor, preencha nome, cidade e estado da unidade.');
            return;
        }

        const dados = { nome, cidade, estado, numero };

        try {
            const response = await fetch(API_URL_UNIDADE, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao cadastrar unidade.');
        }
    });
}

// 2. EDITAR UNIDADE (PUT)
if (formEditUnidade) {
    formEditUnidade.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = document.getElementById('id_unidade_edit').value;
        const nome = document.getElementById('nome_unidade_edit').value;
        const cidade = document.getElementById('cidade_unidade_edit').value;
        const estado = document.getElementById('estado_unidade_edit').value;
        const numero = document.getElementById('numero_unidade_edit').value;

        if (!id || !nome || !cidade || !estado) {
            alert('Dados incompletos para edição da unidade.');
            return;
        }

        const dados = { id, nome, cidade, estado, numero };

        try {
            const response = await fetch(API_URL_UNIDADE, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao editar unidade.');
        }
    });
}

// 3. DESATIVAR UNIDADE (PATCH)
if (btnConfirmaDesativarUnidade) {
    btnConfirmaDesativarUnidade.addEventListener('click', async () => {
        const id = document.getElementById('id_unidade_desativar').value;
        if (!id) return alert('ID não encontrado.');

        try {
            const response = await fetch(API_URL_UNIDADE, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, status: 'Inativo' })
            });
            const result = await response.json();
            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao desativar unidade.');
        }
    });
}

// 4. ATIVAR UNIDADE (PATCH)
if (btnConfirmaAtivarUnidade) {
    btnConfirmaAtivarUnidade.addEventListener('click', async () => {
        const id = document.getElementById('id_unidade_ativar').value;
        if (!id) return alert('ID não encontrado.');

        try {
            const response = await fetch(API_URL_UNIDADE, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, status: 'Ativo' })
            });
            const result = await response.json();
            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao ativar unidade.');
        }
    });
}

// 5. PREPARAR EDIÇÃO UNIDADE
function abrirModalEdicaoUnidade(id, nome, cidade, estado, numero) {
    const idEdit = document.getElementById('id_unidade_edit');
    const nomeEdit = document.getElementById('nome_unidade_edit');
    const cidadeEdit = document.getElementById('cidade_unidade_edit');
    const estadoEdit = document.getElementById('estado_unidade_edit');
    const numeroEdit = document.getElementById('numero_unidade_edit');

    if (idEdit && nomeEdit && cidadeEdit && estadoEdit && numeroEdit) {
        idEdit.value = id;
        nomeEdit.value = nome;
        cidadeEdit.value = cidade;
        estadoEdit.value = estado;
        numeroEdit.value = numero || '';
        showModal('edicaoUnidade');
    } else {
        console.error('Elementos do modal de edição de unidade não encontrados.');
    }
}

window.abrirModalEdicaoUnidade = abrirModalEdicaoUnidade;


// --- SETORES ---

const API_URL_SETOR = '../apis/processa_setores.php';

const formCadSetor = document.getElementById('form-cad-setor');
const formEditSetor = document.getElementById('form-edit-setor');
const btnConfirmaDesativarSetor = document.getElementById('btn-confirmar-desativar-setor');
const btnConfirmaAtivarSetor = document.getElementById('btn-confirmar-ativar-setor');

// 1. CADASTRAR SETOR (POST)
if (formCadSetor) {
    formCadSetor.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nome = document.getElementById('nome_setor_cad').value;
        const unidade = document.getElementById('unidade_setor_cad').value;

        if (!nome || !unidade) {
            alert('Por favor, preencha nome e unidade do setor.');
            return;
        }

        const dados = { nome: nome, unidade_id: unidade };

        try {
            const response = await fetch(API_URL_SETOR, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar cadastrar setor.');
        }
    });
}

// 2. EDITAR SETOR (PUT)
if (formEditSetor) {
    formEditSetor.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = document.getElementById('id_setor_edit').value;
        const nome = document.getElementById('nome_setor_edit').value;
        const unidade = document.getElementById('unidade_setor_edit').value;

        if (!id || !nome || !unidade) {
            alert('Dados incompletos para edição do setor.');
            return;
        }

        const dados = { id: id, nome: nome, unidade_id: unidade };

        try {
            const response = await fetch(API_URL_SETOR, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar editar setor.');
        }
    });
}

// 3. DESATIVAR SETOR (PATCH)
if (btnConfirmaDesativarSetor) {
    btnConfirmaDesativarSetor.addEventListener('click', async () => {
        const id = document.getElementById('id_setor_desativar').value;
        if (!id) return alert('ID não encontrado.');

        const dados = { id: id, status: 'Inativo' };

        try {
            const response = await fetch(API_URL_SETOR, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar desativar setor.');
        }
    });
}

// 4. ATIVAR SETOR (PATCH)
if (btnConfirmaAtivarSetor) {
    btnConfirmaAtivarSetor.addEventListener('click', async () => {
        const id = document.getElementById('id_setor_ativar').value;
        if (!id) return alert('ID não encontrado.');

        const dados = { id: id, status: 'Ativo' };

        try {
            const response = await fetch(API_URL_SETOR, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar ativar setor.');
        }
    });
}

// 5. PREPARAR EDIÇÃO SETOR
function abrirModalEdicaoSetor(id, nome, unidade) {
    const idEdit = document.getElementById('id_setor_edit');
    const nomeEdit = document.getElementById('nome_setor_edit');
    const unidadeEdit = document.getElementById('unidade_setor_edit');

    if (idEdit && nomeEdit && unidadeEdit) {
        idEdit.value = id;
        nomeEdit.value = nome;
        unidadeEdit.value = unidade;
        showModal('editarSetor');
    } else {
        console.error('Elementos do modal de edição de setor não encontrados.');
    }
}

window.abrirModalEdicaoSetor = abrirModalEdicaoSetor;
// --- COLABORADORES ---

const API_URL_COLABORADOR = '../apis/processa_colaboradores.php';

const formCadColaborador = document.getElementById('form-cad-colaborador');
const formEditColaborador = document.getElementById('form-edit-colaborador');
const btnConfirmaDesativarColaborador = document.getElementById('btn-confirmar-deletar-colaborador');
const btnConfirmaAtivarColaborador = document.getElementById('btn-confirmar-ativar-colaborador');

// 1. CADASTRAR COLABORADOR (POST)
if (formCadColaborador) {
    formCadColaborador.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nome = document.getElementById('nome_colaborador_cad').value;
        const email = document.getElementById('email_colaborador_cad').value;
        const senha = document.getElementById('senha_colaborador_cad').value;
        const nif = document.getElementById('nif_colaborador_cad').value;
        const tipo = document.getElementById('tipo_colaborador_cad').value;
        const setor = document.getElementById('setor_colaborador_cad').value;

        if (!nome || !email || !nif || !tipo || !setor) {
            alert('Por favor, preencha todos os campos obrigatórios.');
            return;
        }

        const dados = { nome, email, senha, nif, tipo, setor };

        try {
            const response = await fetch(API_URL_COLABORADOR, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar cadastrar colaborador.');
        }
    });
}

// 2. EDITAR COLABORADOR (PUT)
if (formEditColaborador) {
    formEditColaborador.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = document.getElementById('id_colaborador_edit').value;
        const nome = document.getElementById('nome_colaborador_edit').value;
        const email = document.getElementById('email_colaborador_edit').value;
        const senha = document.getElementById('senha_colaborador_edit').value; // Opcional
        const nif = document.getElementById('nif_colaborador_edit').value;
        const tipo = document.getElementById('tipo_colaborador_edit').value;
        const setor = document.getElementById('setor_colaborador_edit').value;

        if (!id || !nome || !email || !nif || !tipo || !setor) {
            alert('Dados incompletos para edição do colaborador.');
            return;
        }

        const dados = { id, nome, email, senha, nif, tipo, setor };

        try {
            const response = await fetch(API_URL_COLABORADOR, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar editar colaborador.');
        }
    });
}


// 3. DESATIVAR COLABORADOR (PATCH)
if (btnConfirmaDesativarColaborador) {
    btnConfirmaDesativarColaborador.addEventListener('click', async () => {
        const id = document.getElementById('id_colaborador_delete').value;
        if (!id) return alert('ID não encontrado.');

        const dados = { id: id, status: 'Inativo' };

        try {
            const response = await fetch(API_URL_COLABORADOR, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar desativar colaborador.');
        }
    });
}

// 4. ATIVAR COLABORADOR (PATCH)
if (btnConfirmaAtivarColaborador) {
    btnConfirmaAtivarColaborador.addEventListener('click', async () => {
        const id = document.getElementById('id_colaborador_ativar').value;
        if (!id) return alert('ID não encontrado.');

        const dados = { id: id, status: 'Ativo' };

        try {
            const response = await fetch(API_URL_COLABORADOR, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao ativar colaborador.');
        }
    });
}

// 5. PREPARAR EDIÇÃO COLABORADOR
function abrirModalEdicaoColaborador(id, nome, email, tipo, nif, setor) {
    const idEdit = document.getElementById('id_colaborador_edit');
    const nomeEdit = document.getElementById('nome_colaborador_edit');
    const emailEdit = document.getElementById('email_colaborador_edit');
    const tipoEdit = document.getElementById('tipo_colaborador_edit');
    const nifEdit = document.getElementById('nif_colaborador_edit');
    const setorEdit = document.getElementById('setor_colaborador_edit');

    if (idEdit && nomeEdit && emailEdit && tipoEdit && nifEdit && setorEdit) {
        idEdit.value = id;
        nomeEdit.value = nome;
        emailEdit.value = email;
        tipoEdit.value = tipo;
        nifEdit.value = nif;
        setorEdit.value = setor;
        showModal('editarColaborador');
    } else {
        console.error('Elementos do modal de edição de colaborador não encontrados.');
    }
}

window.abrirModalEdicaoColaborador = abrirModalEdicaoColaborador;

// --- TROCA DE SENHA OBRIGATÓRIA ---

const formChangePassword = document.getElementById('form-change-password');

if (formChangePassword) {
    formChangePassword.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nova_senha = document.getElementById('nova_senha').value;
        const confirmar_senha = document.getElementById('confirmar_senha').value;

        if (nova_senha !== confirmar_senha) {
            alert('As senhas não coincidem!');
            return;
        }

        if (nova_senha.length < 4) {
            alert('A senha deve ter pelo menos 4 caracteres.');
            return;
        }

        const dados = {
            action: 'change_password',
            nova_senha: nova_senha
        };

        try {
            const response = await fetch(API_URL_COLABORADOR, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar alterar senha.');
        }
    });
}

// --- SUPORTE ---

const formSuporte = document.getElementById('form-suporte');

if (formSuporte) {
    formSuporte.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id_colaborador = document.getElementById('id_colaborador_suporte_cad').value;
        const onde = document.getElementById('onde').value;
        const tipo = document.querySelector('select[tipo]').value;
        const urgenciaEle = document.querySelector('input[name="urgencia"]:checked');
        const desc_erro = document.getElementById('desc_suporte_cad').value;

        if (!onde || !tipo || !urgenciaEle || !desc_erro) {
            alert('Por favor, preencha todos os campos do suporte.');
            return;
        }

        const dados = {
            id_colaborador: id_colaborador,
            onde: onde,
            tipo: tipo,
            urgencia: urgenciaEle.value,
            desc_erro: desc_erro
        };

        try {
            const response = await fetch(API_URL_SUPORTE, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar enviar suporte.');
        }
    });
}

async function resolverSuporte(id) {
    if (!confirm('Deseja marcar esta solicitação como resolvida?')) {
        return;
    }

    try {
        const response = await fetch(API_URL_SUPORTE, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        });

        const result = await response.json();

        if (response.ok) {
            sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
            location.reload();
        } else {
            alert('Erro: ' + result.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro de conexão ao tentar resolver suporte.');
    }
}

window.resolverSuporte = resolverSuporte;

async function resetarSenha(id) {
    if (!id) return alert('ID inválido.');

    try {
        const response = await fetch(API_URL_COLABORADOR, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, reset_password: true })
        });

        const result = await response.json();

        if (response.ok) {
            sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
            location.reload();
        } else {
            alert('Erro: ' + result.mensagem);
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro de conexão ao tentar resetar senha.');
    }
}

window.resetarSenha = resetarSenha;

// --- CHECKLISTS ALUNO ---

async function enviarChecklist(event, tipo) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const data = {
        tipo_checklist: tipo,
        colaborador_id: formData.get('colaborador_id'),
        requisitos_ids: formData.getAll('requisitos_ids[]'),
        requisitos_especifico_ids: formData.getAll('requisitos_especifico_ids[]')
    };

    const button = form.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="bi bi-hourglass-split"></i> Enviando...';

    try {
        const response = await fetch('../apis/processa_checklist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: result.mensagem,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                closeModal(tipo);
                location.reload();
            });
        } else {
            throw new Error(result.mensagem || 'Erro ao processar checklist.');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: error.message
        });
    } finally {
        button.disabled = false;
        button.innerHTML = originalText;
    }
}

window.enviarChecklist = enviarChecklist;

// ==========================================
// CRUD REQUISITOS (requisitos.php)
// ==========================================

const API_URL_REQUISITO = '../apis/processa_requisitos.php';

// 1. CADASTRAR REQUISITO
const formCadRequisito = document.getElementById('form-cad-requisito');

if (formCadRequisito) {
    formCadRequisito.addEventListener('submit', async (e) => {
        e.preventDefault();

        const topico = document.getElementById('nome_requisito_cad').value;
        const tipo = document.getElementById('tipo_requisito_cad').value;

        if (!topico || !tipo) {
            alert('Preencha todos os campos do requisito.');
            return;
        }

        const dados = {
            topico: topico,
            tipo: tipo
        };

        const btnSubmit = formCadRequisito.querySelector('button[type="submit"]');
        const originalText = btnSubmit.innerHTML;
        btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Cadastrando...';
        btnSubmit.disabled = true;

        try {
            const response = await fetch(API_URL_REQUISITO, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar cadastrar requisito.');
        } finally {
            btnSubmit.innerHTML = originalText;
            btnSubmit.disabled = false;
        }
    });
}

// 2. EDITAR REQUISITO
const formEditRequisito = document.getElementById('form-edit-requisito');

if (formEditRequisito) {
    window.abrirModalEdicaoRequisito = function (id, topico, tipo) {
        document.getElementById('id_requisito_edit').value = id;
        document.getElementById('nome_requisito_edit').value = topico;
        document.getElementById('tipo_requisito_edit').value = tipo;
        showModal('edicaoRequisito');
    };

    formEditRequisito.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = document.getElementById('id_requisito_edit').value;
        const topico = document.getElementById('nome_requisito_edit').value;
        const tipo = document.getElementById('tipo_requisito_edit').value;

        if (!id || !topico || !tipo) {
            alert('Preencha os dados obrigatórios para edição.');
            return;
        }

        const dados = {
            id: id,
            topico: topico,
            tipo: tipo
        };

        const btnSubmit = formEditRequisito.querySelector('button[type="submit"]');
        const originalText = btnSubmit.innerHTML;
        btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Editando...';
        btnSubmit.disabled = true;

        try {
            const response = await fetch(API_URL_REQUISITO, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar editar requisito.');
        } finally {
            btnSubmit.innerHTML = originalText;
            btnSubmit.disabled = false;
        }
    });
}

// 3. DESATIVAR REQUISITO
const btnDesativarRequisito = document.getElementById('btn-confirmar-deletar-requisito');

if (btnDesativarRequisito) {
    btnDesativarRequisito.addEventListener('click', async () => {
        const id = document.getElementById('id_requisito_delete').value;

        if (!id) {
            alert('ID do requisito não encontrado para desativação.');
            return;
        }

        const dados = {
            id: id,
            status: 'Inativo'
        };

        const originalText = btnDesativarRequisito.innerHTML;
        btnDesativarRequisito.innerHTML = '<i class="bi bi-hourglass-split"></i> Desativando...';
        btnDesativarRequisito.disabled = true;

        try {
            const response = await fetch(API_URL_REQUISITO, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar desativar requisito.');
        } finally {
            btnDesativarRequisito.innerHTML = originalText;
            btnDesativarRequisito.disabled = false;
        }
    });
}

// 4. ATIVAR REQUISITO
const btnAtivarRequisito = document.getElementById('btn-confirmar-ativar-requisito');

if (btnAtivarRequisito) {
    btnAtivarRequisito.addEventListener('click', async () => {
        const id = document.getElementById('id_requisito_ativar').value;

        if (!id) {
            alert('ID do requisito não encontrado para ativação.');
            return;
        }

        const dados = {
            id: id,
            status: 'Ativo'
        };

        const originalText = btnAtivarRequisito.innerHTML;
        btnAtivarRequisito.innerHTML = '<i class="bi bi-hourglass-split"></i> Ativando...';
        btnAtivarRequisito.disabled = true;

        try {
            const response = await fetch(API_URL_REQUISITO, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (response.ok) {
                sessionStorage.setItem('pendingSuccessMessage', result.mensagem);
                location.reload();
            } else {
                alert('Erro: ' + result.mensagem);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro de conexão ao tentar ativar requisito.');
        } finally {
            btnAtivarRequisito.innerHTML = originalText;
            btnAtivarRequisito.disabled = false;
        }
    });
}