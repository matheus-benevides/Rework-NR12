// Carrega o Ultimo tema salvo no LocalStorage e define uma saudação de acordo com a hora do dia.
window.onload = () => {
    // Se tiver tema no LocalStorage eu pego ele se não coloca "claro" mesmo
    let tema = localStorage.getItem('tema') || 'claro';

    // Definindo atributo "data-tema" com valor da minha variavel tema
    document.documentElement.setAttribute("data-tema", tema);

    // Isso é para mudar o icone dos btns, mas tive que colocar uma condicional para verificar se eles existem ou não
    // Serve também para mudar a logo do senai
    let btnTema = document.getElementById("tema");
    let imgSenai = document.getElementById("senai-logo");
    let imgSenai2 = document.getElementById("senai-logo2");
    if (tema == 'escuro') {
        if (imgSenai != undefined) {
            imgSenai.src = 'assets/imgs/senaiEscuro.png';
        }
        if (imgSenai2 != undefined) {
            imgSenai2.src = '../../assets/imgs/senailogo2.png';
        }
        if (btnTema != undefined) {
            document.getElementById("tema").innerHTML = '<i class="bi bi-moon-stars-fill"></i>';
        }
    } else {
        if (imgSenai != undefined) {
            imgSenai.src = 'assets/imgs/senailogo.png';

        }
        if (imgSenai2 != undefined) {
            imgSenai2.src = '../../assets/imgs/senailogo2.png';
        }
        if (btnTema != undefined) {
            document.getElementById("tema").innerHTML = '<i class="bi bi-brightness-high-fill"></i>';
        }
    }

    let local_txt = document.getElementById("msg_especial");

    // Mudar a mensagem de boas vindas com base no horario do dia 
    if (local_txt != undefined) {
        let data = new Date();
        let hora = data.getHours();
        // console.log(hora);

        if (hora >= 6 && hora < 12) {
            local_txt.innerHTML = "<strong style='color: var(--corBase)'>Bom Dia</strong>";
        } else if (hora >= 12 && hora < 18) {
            local_txt.innerHTML = "<strong style='color: var(--corBase)'>Boa Tarde</strong>";
        } else if (hora >= 18) {
            local_txt.innerHTML = "<strong style='color: var(--corBase)'>Boa Noite</strong>";
        } else {
            local_txt.innerHTML = "<strong style='color: var(--corBase)'>Olá</strong>";
        }
    }

    // Fechar dropdown ao clicar fora
    document.addEventListener('click', (e) => {
        const dropdownUsuario = document.getElementById('dropdown-usuario');
        const avatar = document.querySelector('.avatar');

        if (dropdownUsuario && !dropdownUsuario.contains(e.target) && !avatar.contains(e.target)) {
            dropdownUsuario.classList.remove('ativo');
        }
    });

    var origem = document.getElementById("total-notificacoes");
    if (origem != undefined) {
        var destino = document.querySelector(".div-noti");
        if (destino != undefined) {
            destino.innerHTML = origem.innerHTML;
        }
    }

    var placeholderQuebra = document.querySelectorAll(".quebraMobile");
    var sizeWidth = window.innerWidth;
    if (sizeWidth <= 720) {
        if (placeholderQuebra != undefined) {
            for (let i = 0; i < placeholderQuebra.length; i++) {
                placeholderQuebra[i].style.display = "flex";
                placeholderQuebra[i].style.flexDirection = "column";
            }
        }
    }
}

function showPass() {
    // Coleto e armazenos o Btn do Olho e o Input de Senha

    let eye = document.getElementById("btnEyeLogin");
    let inputPass = document.getElementById("senha");


    if (inputPass.type == "password") {
        inputPass.type = "text";
        eye.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        inputPass.type = "password";
        eye.innerHTML = '<i class="bi bi-eye-fill"></i>';
    }
    console.log(inputPass.type);
    console.log(eye.innerHTML);
}

let modoAluno = false;

function trocarForm1() {
    const inputs = document.querySelectorAll(".input");
    const btnEye = document.getElementById("btnEyeLogin");
    const form = document.querySelector(".login-form");
    const btnTrocar = document.getElementById('trocarForm');
    const icons = document.querySelectorAll(".div-input i ");

    const btnEsp = document.querySelectorAll(".btnEsp");

    if (!modoAluno) {
        inputs[0].type = 'text';
        inputs[1].type = 'text';

        inputs[0].name = 'matricula';
        inputs[1].name = 'nimaquina';
        inputs[0].placeholder = "Matrícula ou E-mail";
        inputs[1].placeholder = "NI da Máquina";
        icons[0].className = "bi bi-person-badge-fill";
        icons[1].className = "bi bi-cpu-fill";

        // btnEsp[0].style.visibility = "visible";
        btnEsp[1].style.visibility = "visible";

        // btnEsp[0].innerHTML = '<i class="bi bi-qr-code-scan"></i>';
        btnEsp[1].innerHTML = '<i class="bi bi-qr-code-scan"></i>';
        // btnEsp[0].onclick = () => lerQr(0);
        btnEsp[1].onclick = () => lerQr(1);

        btnTrocar.innerHTML = "Voltar para Login Colaborador";
        modoAluno = true;
    } else {
        inputs[0].type = "email";
        inputs[1].type = "password";

        inputs[0].name = 'email';
        inputs[1].name = 'senha';
        inputs[0].placeholder = "exemplo@email.com";
        inputs[1].placeholder = "*****";
        icons[0].className = 'bi bi-envelope-fill';
        icons[1].className = 'bi bi-shield-fill';

        btnEsp[0].style.visibility = "hidden";
        btnEsp[1].style.visibility = "visible";

        btnEsp[0].innerHTML = '<i class="bi bi-qr-code-scan"></i>';
        btnEsp[1].innerHTML = '<i class="bi bi-eye-fill"></i>';
        btnEsp[0].onclick = () => lerQr(0);
        btnEsp[1].onclick = () => showPass();

        btnTrocar.innerText = 'Entrar como aluno';
        modoAluno = false;
    }
}

const notificacao = document.getElementById("notificacao");
// const fechar = document.getElementById("fechar-modal");

if (notificacao != undefined) {
    notificacao.addEventListener('mouseover', () => {
        notificacao.style.animation = 'animTremendo 0.25s linear';
    })

    notificacao.addEventListener('mouseout', () => {
        notificacao.style.animation = 'none';
    })
}

let arrow = document.getElementById("fechar-nav");

// função fechar e abrir navbar
if (arrow != undefined) {
    let sidebar = document.querySelector(".sidebar");
    let main = document.querySelector(".sec-main")
    let navLinks = document.querySelector(".div-links");
    let divImg = document.querySelector(".div-img");
    let btnSair = document.querySelector(".sair");
    let divConfig = document.querySelector(".div-configs");
    const mediaQuery = window.matchMedia('(min-width: 768px)');

    if (mediaQuery.matches) {
        sidebar.style.width = '275px';
    } else {
        sidebar.style.width = '10px';
        navLinks.style.display = 'none';
        divImg.style.display = 'none';
        sidebar.style.width = '10px';
        divConfig.style.display = 'none';
        btnSair.style.fontSize = '0px';
        btnSair.style.width = '0px';
        main.style = 'padding-left: 10px';
        arrow.innerHTML = '<i class="bi bi-arrow-right-circle-fill"></i>';
        arrow.style.animation = 'none';
    }

    arrow.addEventListener('click', () => {
        if (arrow.innerHTML.match('<i class="bi bi-arrow-left-circle-fill"></i>')) {

            if (mediaQuery.matches) {
                sidebar.style.animation = 'navbarAnim 0.25s linear';
            } else {
                sidebar.style.animation = 'navbarMobile 0.25s linear';
            }

            setTimeout(() => {
                navLinks.style.display = 'none';
                divImg.style.display = 'none';
                sidebar.style.width = '10px';
                divConfig.style.display = 'none';
                btnSair.style.fontSize = '0px';
                btnSair.style.width = '0px';
                main.style = 'padding-left: 10px';
                arrow.innerHTML = '<i class="bi bi-arrow-right-circle-fill"></i>';
                arrow.style.animation = 'none';
                clearTimeout();
            }, 25)
        }

        if (arrow.innerHTML.match('<i class="bi bi-arrow-right-circle-fill"></i>')) {

            if (mediaQuery.matches) {
                sidebar.style.width = '275px';
            } else {
                sidebar.style.width = '144px';
            }
            arrow.innerHTML = '<i class="bi bi-arrow-left-circle-fill"></i>';

            if (mediaQuery.matches) {
                setTimeout(() => {
                    divImg.style.display = 'flex';
                    divConfig.style.display = 'flex';
                    navLinks.style.display = 'flex';
                    main.style = 'padding-left: 12%';
                    clearTimeout();
                }, 65)
            }
            else {
                setTimeout(() => {
                    divImg.style.display = 'flex';
                    divConfig.style.display = 'flex';
                    navLinks.style.display = 'flex';
                    main.style = 'padding-left: 35%';
                    clearTimeout();
                }, 65)
            }


            setTimeout(() => {
                if (mediaQuery.matches) {
                    btnSair.style.width = '230px';
                    btnSair.style.fontSize = '16px';
                } else {
                    btnSair.style.width = '45px';
                }

            }, 95)
        }
    });
}

// Muda o icone de sol pra lua com base no tema da pagina, além de armazenar no localStorage e mudar o tema em sí
function changeTheme() {
    let tema_atual = document.documentElement.getAttribute("data-tema")
    let imgSenai2 = document.getElementById("senai-logo2");

    if (tema_atual == "escuro") {
        localStorage.removeItem('tema');
        document.documentElement.setAttribute("data-tema", "claro");
        document.getElementById("tema").innerHTML = '<i class="bi bi-brightness-high-fill"></i>';
        localStorage.setItem('tema', 'claro');
        imgSenai2.src = '../../assets/imgs/senailogo2';
        if (imgSenai2 != undefined) {
            imgSenai2.src = '../../assets/imgs/senailogo2.png';
        }
    } else {
        localStorage.removeItem('tema');
        document.documentElement.setAttribute("data-tema", "escuro");
        document.getElementById("tema").innerHTML = '<i class="bi bi-moon-stars-fill"></i>';
        localStorage.setItem('tema', 'escuro');
        if (imgSenai2 != undefined) {
            imgSenai2.src = '../../assets/imgs/senailogo2.png';
        }
    }
}

// Muda o icone da porta
function changeSairBtn(oc) {
    let btnSair = document.querySelector(".sair");
    if (oc == "open") {
        btnSair.innerHTML = 'Sair <i class="bi bi-door-open-fill"></i>';
    } else {
        btnSair.innerHTML = 'Sair <i class="bi bi-door-closed-fill"></i>';
    }
}

function showModal(qual, id) {
    if (qual == "adicaoCurso") {
        document.getElementById("adicaoCurso").style.display = "flex";
    } else if (qual == "desativarCurso") {
        document.getElementById("desativarCurso").style.display = "flex";
        if (id) document.getElementById("id_curso_delete").value = id;
    } else if (qual == "ativarCurso") {
        document.getElementById("ativarCurso").style.display = "flex";
        if (id) document.getElementById("id_curso_ativar").value = id;
    } else if (qual == "edicaoCurso") {
        document.getElementById("edicaoCurso").style.display = "flex";
    } else if (qual == "dell") {
        document.getElementById("dell").style.display = "flex";
    } else if (qual == "adicaoAluno") {
        document.getElementById("adicaoAluno").style.display = "flex";
    } else if (qual == "edicaoAluno") {
        document.getElementById("edicaoAluno").style.display = "flex";
    } else if (qual == "desativarAluno") {
        document.getElementById("desativarAluno").style.display = "flex";
        if (id) document.getElementById("id_aluno_desativar").value = id;
    } else if (qual == "ativarAluno") {
        document.getElementById("ativarAlu  no").style.display = "flex";
        if (id) document.getElementById("id_aluno_ativar").value = id;
    } else if (qual == "deletarAluno") {
        document.getElementById("deletarAluno").style.display = "flex";
        if (id) document.getElementById("id_aluno_delete").value = id;
    } else if (qual == "adicaoTurma") {
        document.getElementById("adicaoTurma").style.display = "flex";
    } else if (qual == "edicaoTurma") {
        document.getElementById("edicaoTurma").style.display = "flex";
    } else if (qual == "deletarTurma") {
        document.getElementById("deletarTurma").style.display = "flex";
        if (id) document.getElementById("id_turma_delete").value = id;
    } else if (qual == "ativarTurma") {
        document.getElementById("ativarTurma").style.display = "flex";
        if (id) document.getElementById("id_turma_ativar").value = id;
    } else if (qual == "adicaoUnidade") {
        document.getElementById("adicaoUnidade").style.display = "flex";
    } else if (qual == "edicaoUnidade") {
        document.getElementById("edicaoUnidade").style.display = "flex";
    } else if (qual == "desativarUnidade") {
        document.getElementById("desativarUnidade").style.display = "flex";
        if (id) document.getElementById("id_unidade_desativar").value = id;
    } else if (qual == "ativarUnidade") {
        document.getElementById("ativarUnidade").style.display = "flex";
        if (id) document.getElementById("id_unidade_ativar").value = id;
    } else if (qual == "adicaoSetor") {
        document.getElementById("adicaoSetor").style.display = "flex";
    } else if (qual == "editarSetor") {
        document.getElementById("editarSetor").style.display = "flex";
    } else if (qual == "desativarSetor") {
        document.getElementById("desativarSetor").style.display = "flex";
        if (id) document.getElementById("id_setor_desativar").value = id;
    } else if (qual == "ativarSetor") {
        document.getElementById("ativarSetor").style.display = "flex";
        if (id) document.getElementById("id_setor_ativar").value = id;
    } else if (qual == "adicaoColaborador") {
        document.getElementById("adicaoColaborador").style.display = "flex";
    } else if (qual == "editarColaborador") {
        document.getElementById("editarColaborador").style.display = "flex";
    } else if (qual == "deletarColaborador") {
        document.getElementById("deletarColaborador").style.display = "flex";
        if (id) document.getElementById("id_colaborador_delete").value = id;
    } else if (qual == "desativarColaborador") {
        document.getElementById("desativarColaborador").style.display = "flex";
        if (id) document.getElementById("id_colaborador_delete").value = id;
    } else if (qual == "ativarColaborador") {
        document.getElementById("ativarColaborador").style.display = "flex";
        if (id) document.getElementById("id_colaborador_ativar").value = id;
    } else if (qual == 'resetPass') {
        document.getElementById('resetPass').style.display = 'flex';
        document.getElementById("id_usuario_reset").value = id;
    } else if (qual == "adicaoMotor") {
        document.getElementById('adicaoMotor').style.display = "flex";
    } else if (qual == "editarMotor") {
        document.getElementById('editarMotor').style.display = "flex";
    } else if (qual == "deletarMotor") {
        document.getElementById('deletarMotor').style.display = "flex";
    } else if (qual == "edicaoMaquina") {
        document.getElementById("edicaoMaquina").style.display = "flex";
        if (id) {
            fetch(`../apis/processa_maquinas.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.id) {
                        document.getElementById("id_maquina_edit").value = data.id;
                        document.getElementById("denominacao_edit").value = data.denominacao;
                        document.getElementById("marca_edit").value = data.marca;
                        document.getElementById("modelo_edit").value = data.modelo;
                        document.getElementById("ano_fabricacao_edit").value = data.ano_fabricacao;
                        document.getElementById("numero_identificacao_edit").value = data.numero_identificacao;
                        document.getElementById("numero_serie_edit").value = data.numero_serie;
                        document.getElementById("setor_edit").value = data.setor;
                        // Opcional: Tipo e Motor (se salvarmos IDs no futuro)
                    }
                })
                .catch(error => console.error('Erro ao buscar máquina:', error));
        }
    } else if (qual == "deletarMaquina") {
        document.getElementById("deletarMaquina").style.display = "flex";
        if (id) {
            document.getElementById("btn-confirmar-deletar-maquina").onclick = () => {
                fetch(`../apis/processa_maquinas.php?id=${id}`, {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' }
                })
                    .then(response => response.json())
                    .then(data => {
                        sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                        location.reload();
                    })
                    .catch(error => console.error('Erro ao excluir máquina:', error));
            };
        }
    } else if (qual == "adicaoMaquina") {
        document.getElementById("adicaoMaquina").style.display = "flex";
    } else if (qual == "adicaoTipoMaquina") {
        document.getElementById("adicaoTipoMaquina").style.display = "flex";
    } else if (qual == "edicaoTipoMaquina") {
        document.getElementById("edicaoTipoMaquina").style.display = "flex";
        if (id) {
            fetch(`../apis/processa_tipomaquina.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("id_tipomaquina_edit").value = data.idtipomaquina;
                    document.getElementById("tipomaquina_nome_edit").value = data.tipomaquina_nome;
                })
                .catch(error => console.error('Erro ao buscar tipo:', error));
        }
    } else if (qual == "deletarTipoMaquina") {
        document.getElementById("deletarTipoMaquina").style.display = "flex";
        if (id) document.querySelector("#deletarTipoMaquina #id_usuario").value = id;
    } else if (qual == "desativarTipMa") {
        document.getElementById("desativarTipMa").style.display = "flex";
        if (id) document.querySelector("#desativarTipMa #id_usuario").value = id;
    } else if (qual == "ativarTipMa") {
        document.getElementById("ativarTipMa").style.display = "flex";
        if (id) document.querySelector("#ativarTipMa #id_usuario").value = id;
    } else if (qual == "adicaoManutencao") {
        document.getElementById("adicaoManutencao").style.display = "flex";
    } else if (qual == "deletarManutencao") {
        document.getElementById("deletarManutencao").style.display = "flex";
    } else if (qual == "desativarManutencao") {
        document.getElementById("desativarManutencao").style.display = "flex";
    } else if (qual == "notificacao-modal") {
        document.getElementById("notificacao-modal").style.display = "flex";
    } else if (qual == "alunosLote") {
        document.getElementById("alunosLote").style.display = "flex";
        document.getElementById("adicaoAluno").style.display = "none";
    } else if (qual == "cursosLote") {
        document.getElementById("cursosLote").style.display = "flex";
        document.getElementById("adicaoCurso").style.display = "none";
    } else if (qual == "turmasLote") {
        document.getElementById("turmasLote").style.display = "flex";
        document.getElementById("adicaoTurma").style.display = "none";
    } else if (qual == "unidadeLote") {
        document.getElementById("unidadeLote").style.display = "flex";
        document.getElementById("adicaoUnidade").style.display = "none";
    } else if (qual == "setoresLote") {
        document.getElementById("setoresLote").style.display = "flex";
        document.getElementById("adicaoSetor").style.display = "none";
    } else if (qual == "colaboradoresLote") {
        document.getElementById("colaboradoresLote").style.display = "flex";
        document.getElementById("adicaoColaborador").style.display = "none";
    } else if (qual == "adicaoSuporte") {
        document.getElementById("adicaoSuporte").style.display = "flex";
    } else if (qual == "changePassword") {
        document.getElementById("changePassword").style.display = "flex";
    } else if (qual == "sucesso") {
        document.getElementById("sucesso").style.display = "flex";
    } else if (qual == "adicaoRequisito") {
        document.getElementById("adicaoRequisito").style.display = "flex";
    } else if (qual == "edicaoRequisito") {
        document.getElementById("edicaoRequisito").style.display = "flex";
        if (id) {
            fetch(`../apis/processa_requisitos.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("id_requisito_edit").value = data.idrequisitos;
                    document.getElementById("nome_requisito_edit").value = data.requisito_topico;
                    document.getElementById("tipo_requisito_edit").value = data.tipo_req;
                })
                .catch(error => console.error('Erro ao buscar requisito:', error));
        }
    } else if (qual == "deletarRequisito") {
        document.getElementById("deletarRequisito").style.display = "flex";
        if (id) document.getElementById("id_requisito_delete").value = id;
    } else if (qual == "ativarRequisito") {
        document.getElementById("ativarRequisito").style.display = "flex";
        if (id) document.getElementById("id_requisito_ativar").value = id;
    } else if (qual == "checkOperacional") {
        document.getElementById("checkOperacional").style.display = "flex";
    } else if (qual == "checkSeguranca") {
        document.getElementById("checkSeguranca").style.display = "flex";
    } else if (qual == "relacionarRequisitos") {
        document.getElementById("relacionarRequisitos").style.display = "flex";
    } else if (qual == "reportarMaquina") {
        document.getElementById("reportarMaquina").style.display = "flex";
    } else if (qual == "confirmarProceed") {
        document.getElementById("confirmarProceed").style.display = "flex";
    } else if (qual == "erro") {
        document.getElementById("erro").style.display = "flex";
    }
}

// REDUZIU 130 LINHAS DE MODAIS
function closeModal(qual){
    document.getElementById(qual).style.display = "none";
}

function exibirSucesso(mensagem) {
    const msgElement = document.getElementById("sucesso-msg");
    if (msgElement) {
        msgElement.innerText = mensagem;
        showModal('sucesso');
    } else {
        alert(mensagem); // Fallback caso o modal não exista na página
    }
}

function resetarSenha(id) {
    window.location.href = '../actions/colaboradores/reset_senha.php?id=' + id;
}

document.addEventListener("DOMContentLoaded", function () {
    // Verificar se há uma mensagem de sucesso pendente do reload anterior
    const pendingMsg = sessionStorage.getItem('pendingSuccessMessage');
    if (pendingMsg) {
        exibirSucesso(pendingMsg);
        sessionStorage.removeItem('pendingSuccessMessage');
    }

    const registrosPorPagina = 10;

    // Declaração de todas as tabelas
    const tabelaCursos1 = document.getElementById("tabela-cursos");
    const tabelaCursos2 = document.getElementById("tabela-turmas");
    const tabelaCursos3 = document.getElementById("tabela-logs");
    const tabelaCursos4 = document.getElementById("tabela-alunos");
    const tabelaCursos5 = document.getElementById("tabela-outros"); // Adicionei esta definição que faltava
    const tabelaCursos6 = document.getElementById("tabela-unidade");
    const tabelaCursos7 = document.getElementById("tabela-historico");
    const tabelaCursos8 = document.getElementById("tabela-motor");
    const tabelaCursos9 = document.getElementById("tabela-setores");
    const tabelaCursos10 = document.getElementById("tabela-colaboradores");
    const tabelaCursos11 = document.getElementById("tabela-maquinas");
    const tabelaCursos12 = document.getElementById("tabela-tipo_maquinas");
    const tabelaCursos13 = document.getElementById("tabela-manuntencao");
    const tabelaCursos14 = document.getElementById("tabela-maquinas");
    const tabelaCursos15 = document.getElementById("tabela-agendamento");
    const tabelaCursos16 = document.getElementById("tabela-motores");
    const tabelaCursos17 = document.getElementById("tabela-suporte");
    const tabelaCursos18 = document.getElementById("tabela-requisitos");
    const tabelaCursos19 = document.getElementById("tabela-requisitos-maquina");

    // --- BLOCO 1 ---
    if (tabelaCursos1 != undefined) {
        let paginaAtual = 1; // Variável movida para dentro (Escopo Local)
        const linhas = Array.from(tabelaCursos1.getElementsByTagName("tr")); // Corrigido de tabelaCursos para tabelaCursos1

        // ATENÇÃO: Se as tabelas estiverem na mesma tela, os IDs dos botões devem ser únicos no HTML (ex: btn-ant-1)
        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação da Tabela 1 não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 2 ---
    if (tabelaCursos2 != undefined) {
        let paginaAtual = 1; // Reinicia contagem para esta tabela
        const linhas = Array.from(tabelaCursos2.getElementsByTagName("tr")); // Corrigido para tabelaCursos2

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 3 ---
    if (tabelaCursos3 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos3.getElementsByTagName("tr")); // Corrigido para tabelaCursos3

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 4 ---
    if (tabelaCursos4 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos4.getElementsByTagName("tr")); // Corrigido para tabelaCursos4

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 5 ---
    if (tabelaCursos5 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos5.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 6 ---
    if (tabelaCursos6 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos6.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 7 ---
    if (tabelaCursos7 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos7.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 8 ---    
    if (tabelaCursos8 != undefined) {
        let paginaAtual = 1; // Reinicia contagem para esta tabela
        const linhas = Array.from(tabelaCursos8.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 9 ---    
    if (tabelaCursos9 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos9.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 10 ---    
    if (tabelaCursos10 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos10.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 11 ---    
    if (tabelaCursos11 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos11.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 12 ---    
    if (tabelaCursos12 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos12.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 13 ---    
    if (tabelaCursos13 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos13.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 14 ---    
    if (tabelaCursos14 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos14.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }
    // --- BLOCO 15 ---    
    if (tabelaCursos15 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos15.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 15 ---    
    if (tabelaCursos15 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos15.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 16 ---    
    if (tabelaCursos16 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos16.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 17 ---    
    if (tabelaCursos17 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos17.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 18 ---
    if (tabelaCursos18 != undefined) { // Verificando tabela 14
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos18.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }

    // --- BLOCO 19 --- Requisitos de Máquinas
    if (tabelaCursos19 != undefined) {
        let paginaAtual = 1;
        const linhas = Array.from(tabelaCursos19.getElementsByTagName("tr"));

        const btnAnterior = document.getElementById("btn-ant");
        const btnProximo = document.getElementById("btn-prox");

        if (!btnAnterior || !btnProximo) {
            console.error("Erro: Botões de paginação não encontrados.");
            return;
        }

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * registrosPorPagina;
            const fim = inicio + registrosPorPagina;

            linhas.forEach((linha, index) => {
                if (index >= inicio && index < fim) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
            atualizarBotoes();
        }

        function atualizarBotoes() {
            if (paginaAtual === 1) {
                btnAnterior.style.opacity = "0.3";
                btnAnterior.disabled = true;
                btnAnterior.style.pointerEvents = "none";
            } else {
                btnAnterior.style.opacity = "1";
                btnAnterior.disabled = false;
                btnAnterior.style.pointerEvents = "auto";
            }

            if (paginaAtual * registrosPorPagina >= linhas.length) {
                btnProximo.style.opacity = "0.3";
                btnProximo.disabled = true;
                btnProximo.style.pointerEvents = "none";
            } else {
                btnProximo.style.opacity = "1";
                btnProximo.disabled = false;
                btnProximo.style.pointerEvents = "auto";
            }
        }

        btnAnterior.addEventListener("click", function () {
            if (paginaAtual > 1) {
                paginaAtual--;
                mostrarPagina(paginaAtual);
            }
        });

        btnProximo.addEventListener("click", function () {
            if ((paginaAtual * registrosPorPagina) < linhas.length) {
                paginaAtual++;
                mostrarPagina(paginaAtual);
            }
        });

        mostrarPagina(1);
    }
});


function filtrarCursos() {
    const select1 = document.querySelector("#select-filtro-cursos");
    const linhas = document.querySelectorAll("#tabela-cursos tr");

    if (!select1) return;

    const filtro = select1.value.toLowerCase().trim();

    linhas.forEach(linha => {
        const colunaStatus = linha.getElementsByTagName("td")[1];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

function filtrarColaboradores() {
    const select2 = document.querySelector("#select-filtro-colaboradores");
    const linhas = document.querySelectorAll("#tabela-colaboradores tr");

    if (!select2) return;

    const filtro = select2.value.toLowerCase().trim();

    linhas.forEach(linha => {
        const colunaStatus = linha.getElementsByTagName("td")[5];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}


function filtrarTurmas() {
    const select = document.querySelector("#select-filtro-turmas");
    const linhas = document.querySelectorAll("#tabela-turmas tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        const colunaStatus = linha.getElementsByTagName("td")[6];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

function filtrarAlunos() {
    const select = document.querySelector("#select-filtro-alunos");
    const linhas = document.querySelectorAll("#tabela-alunos tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        // Índice 4 confirmado (5ª coluna)
        const colunaStatus = linha.getElementsByTagName("td")[4];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

function filtrarSuporte() {
    const select = document.querySelector("#select-filtro-suporte");
    const linhas = document.querySelectorAll("#tabela-suporte tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        // Índice 5 confirmado (6ª coluna)
        const colunaStatus = linha.getElementsByTagName("td")[4];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}


function filtrarMotores() {
    const select = document.querySelector("#select-filtro-motores");
    const linhas = document.querySelectorAll("#tabela-motores tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        // Índice 4 confirmado (5ª coluna)
        const colunaStatus = linha.getElementsByTagName("td")[5];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

function filtrarSetor() {
    const select = document.querySelector("#select-filtro-setor");
    const linhas = document.querySelectorAll("#tabela-setores tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        const colunaStatus = linha.getElementsByTagName("td")[2];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

filtrarManuntencao = () => {
    const select = document.querySelector("#select-filtro-manuntencao");
    const linhas = document.querySelectorAll("#tabela-manuntencao tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        const colunaStatus = linha.getElementsByTagName("td")[7];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });

    if (filtro === "") {
        linhas.forEach(linha => {
            linha.style.display = "";
        });
    }
}

function filtrarMaquinas() {
    const select = document.querySelector("#select-filtro-maquinas");
    const linhas = document.querySelectorAll("#tabela-maquinas tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        // O índice 6 refere-se à 7ª coluna (Status) da sua tabela
        const colunaStatus = linha.getElementsByTagName("td")[5];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

function filtrarProximaManutencao() {
    const select = document.querySelector("#select-filtro-agendamento");
    const linhas = document.querySelectorAll("#tabela-agendamento tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        // O índice 6 refere-se à 7ª coluna (Status) da sua tabela
        const colunaStatus = linha.getElementsByTagName("td")[4];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

function filtrarUnidade() {
    const select = document.querySelector("#select-filtro-unidade");
    const linhas = document.querySelectorAll("#tabela-unidade tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        // O índice 6 refere-se à 7ª coluna (Status) da sua tabela
        const colunaStatus = linha.getElementsByTagName("td")[4];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

function filtrarTipoMaquina() {
    const select = document.querySelector("#select-filtro-tipo-maquina");
    const linhas = document.querySelectorAll("#tabela-tipo_maquinas tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        // O índice 6 refere-se à 7ª coluna (Status) da sua tabela
        const colunaStatus = linha.getElementsByTagName("td")[2];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const selectRequisitos = document.querySelector("#select-filtro-requisito");
    if (selectRequisitos) {
        selectRequisitos.addEventListener("change", filtrarRequisito);
    }

    const selectTipoRequisito = document.querySelector("#select-filtro-tipo");
    if (selectTipoRequisito) {
        selectTipoRequisito.addEventListener("change", filtrarRequisito);
    }

    // Handlers para Requisitos
    const formCadRequisito = document.getElementById('form-cad-requisito');
    if (formCadRequisito) {
        formCadRequisito.addEventListener('submit', function (e) {
            e.preventDefault();
            const topico = document.getElementById('nome_requisito_cad').value;
            const tipo = document.getElementById('tipo_requisito_cad').value;

            fetch('../apis/processa_requisitos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ topico, tipo })
            })
                .then(response => response.json())
                .then(data => {
                    sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                    location.reload();
                })
                .catch(error => console.error('Erro ao cadastrar requisito:', error));
        });
    }

    const formEditRequisito = document.getElementById('form-edit-requisito');
    if (formEditRequisito) {
        formEditRequisito.addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('id_requisito_edit').value;
            const topico = document.getElementById('nome_requisito_edit').value;
            const tipo = document.getElementById('tipo_requisito_edit').value;

            fetch('../apis/processa_requisitos.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, topico, tipo })
            })
                .then(response => response.json())
                .then(data => {
                    sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                    location.reload();
                })
                .catch(error => console.error('Erro ao editar requisito:', error));
        });
    }

    const btnDelRequisito = document.getElementById('btn-confirmar-deletar-requisito');
    if (btnDelRequisito) {
        btnDelRequisito.addEventListener('click', function () {
            const id = document.getElementById('id_requisito_delete').value;
            fetch('../apis/processa_requisitos.php', {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, status: 'Inativo' })
            })
                .then(response => response.json())
                .then(data => {
                    sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                    location.reload();
                })
                .catch(error => console.error('Erro ao desativar requisito:', error));
        });
    }

    const btnAtivarRequisito = document.getElementById('btn-confirmar-ativar-requisito');
    if (btnAtivarRequisito) {
        btnAtivarRequisito.addEventListener('click', function () {
            const id = document.getElementById('id_requisito_ativar').value;
            fetch('../apis/processa_requisitos.php', {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, status: 'Ativo' })
            })
                .then(response => response.json())
                .then(data => {
                    sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                    location.reload();
                })
                .catch(error => console.error('Erro ao ativar requisito:', error));
        });
    }

    // Handlers para Máquinas (Cadastro)
    const formCadMaquina = document.getElementById('form-cad-maquina');
    if (formCadMaquina) {
        formCadMaquina.addEventListener('submit', function (e) {
            e.preventDefault();
            
            const getVal = (id) => {
                const el = document.getElementById(id);
                return el ? el.value : '';
            };

            const data = {
                denominacao: getVal('denominacao'),
                marca: getVal('marca'),
                modelo: getVal('modelo'),
                numero_identificacao: getVal('numero_identificacao'),
                numero_serie: getVal('numero_serie'),
                ano_fabricacao: getVal('ano_fabricacao'),
                setor: getVal('setor'),
                tipomaquina: getVal('tipomaquina')
            };

            fetch('../apis/processa_maquinas.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(err.mensagem || 'Erro no servidor'); });
                    }
                    return response.json();
                })
                .then(data => {
                    sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                    location.reload();
                })
                .catch(error => {
                    console.error('Erro ao cadastrar máquina:', error);
                    alert('Erro ao cadastrar máquina: ' + error.message);
                });
        });
    }

    // Handlers para Máquinas (Edição)
    const formEditMaquina = document.getElementById('form-edit-maquina');
    if (formEditMaquina) {
        formEditMaquina.addEventListener('submit', function (e) {
            e.preventDefault();

            const getVal = (id) => {
                const el = document.getElementById(id);
                return el ? el.value : '';
            };

            const data = {
                id: getVal('id_maquina_edit'),
                denominacao: getVal('denominacao_edit'),
                marca: getVal('marca_edit'),
                modelo: getVal('modelo_edit'),
                numero_identificacao: getVal('numero_identificacao_edit'),
                numero_serie: getVal('numero_serie_edit'),
                ano_fabricacao: getVal('ano_fabricacao_edit'),
                setor: getVal('setor_edit'),
                tipomaquina: getVal('tipomaquina_edit')
            };

            fetch('../apis/processa_maquinas.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(err.mensagem || 'Erro no servidor'); });
                    }
                    return response.json();
                })
                .then(data => {
                    sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                    location.reload();
                })
                .catch(error => {
                    console.error('Erro ao editar máquina:', error);
                    alert('Erro ao editar máquina: ' + error.message);
                });
        });
    }

    // Handlers para Tipo de Máquina (Cadastro)
    const formCadTipoMaquina = document.getElementById('form-cad-tipomaquina');
    if (formCadTipoMaquina) {
        formCadTipoMaquina.addEventListener('submit', function (e) {
            e.preventDefault();
            const nome = document.getElementById('tipomaquina_nome_cad').value;
            if (!nome) {
                alert('O nome do tipo de máquina é obrigatório.');
                return;
            }
            fetch('../apis/processa_tipomaquina.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tipomaquina_nome: nome })
            })
                .then(response => {
                    if (!response.ok) return response.json().then(err => { throw new Error(err.mensagem); });
                    return response.json();
                })
                .then(data => {
                    sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                    location.reload();
                })
                .catch(error => alert('Erro: ' + error.message));
        });
    }

    // Handlers para Tipo de Máquina (Edição)
    const formEditTipoMaquina = document.getElementById('form-edit-tipomaquina');
    if (formEditTipoMaquina) {
        formEditTipoMaquina.addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('id_tipomaquina_edit').value;
            const nome = document.getElementById('tipomaquina_nome_edit').value;
            fetch('../apis/processa_tipomaquina.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, tipomaquina_nome: nome })
            })
                .then(response => {
                    if (!response.ok) return response.json().then(err => { throw new Error(err.mensagem); });
                    return response.json();
                })
                .then(data => {
                    sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                    location.reload();
                })
                .catch(error => alert('Erro: ' + error.message));
        });
    }

    // Handlers para exclusão/status de Tipo Máquina
    const btnConfirmarDelTP = document.querySelector('#deletarTipoMaquina .confirmar');
    if (btnConfirmarDelTP) {
        btnConfirmarDelTP.addEventListener('click', function () {
            const id = document.querySelector('#deletarTipoMaquina #id_usuario').value;
            fetch(`../apis/processa_tipomaquina.php?id=${id}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    sessionStorage.setItem('pendingSuccessMessage', data.mensagem);
                    location.reload();
                })
                .catch(error => alert('Erro: ' + error.message));
        });
    }

    const btnDesativarTP = document.querySelector('#desativarTipMa .confirmar');
    if (btnDesativarTP) {
        btnDesativarTP.addEventListener('click', () => {
            const id = document.querySelector('#desativarTipMa #id_usuario').value;
            fetch('../apis/processa_tipomaquina.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, status: 'Inativo' })
            }).then(() => { location.reload(); });
        });
    }

    const btnAtivarTP = document.querySelector('#ativarTipMa .confirmar');
    if (btnAtivarTP) {
        btnAtivarTP.addEventListener('click', () => {
            const id = document.querySelector('#ativarTipMa #id_usuario').value;
            fetch('../apis/processa_tipomaquina.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, status: 'Ativo' })
            }).then(() => { location.reload(); });
        });
    }
});

function filtrarRequisito() {
    const selectStatus = document.querySelector("#select-filtro-requisito");
    const selectTipo = document.querySelector("#select-filtro-tipo");
    const linhas = document.querySelectorAll("#tabela-requisitos tr");

    if (!selectStatus || !selectTipo) return;

    const filtroStatus = selectStatus.value.toLowerCase().trim();
    const filtroTipo = selectTipo.value.toLowerCase().trim();

    linhas.forEach(linha => {
        const colunaTipo = linha.getElementsByTagName("td")[1];
        const colunaStatus = linha.getElementsByTagName("td")[2];

        if (colunaTipo && colunaStatus) {
            // Normalizando texto para remover acentos para comparação
            const textoTipo = colunaTipo.textContent.toLowerCase().trim().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            const matchesStatus = (filtroStatus === "todos" || textoStatus === filtroStatus);
            const matchesTipo = (filtroTipo === "todos" || textoTipo === filtroTipo);

            if (matchesStatus && matchesTipo) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

function filtrarTabela(idTabela, indiceColuna) {
    const select = event.target;
    const filtro = select.value.toLowerCase().trim();
    const linhas = document.querySelectorAll(`#${idTabela} tr`);

    linhas.forEach(linha => {
        const coluna = linha.getElementsByTagName("td")[indiceColuna];
        if (coluna) {
            const texto = coluna.textContent.toLowerCase().trim();
            if (filtro === "todos" || texto === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    });
}

let html5QrCode;

function lerQr(inputIndex) {
    const container = document.getElementById('reader-container');
    container.style.display = 'flex';

    // Instancia o scanner
    html5QrCode = new Html5Qrcode("reader");

    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        // Preenche o input correspondente (0 para matrícula, 1 para NI)
        const inputs = document.querySelectorAll(".input");
        inputs[inputIndex].value = decodedText;

        // Para a câmera e fecha o modal
        fecharScanner();
    };

    const config = {
        fps: 10,
        qrbox: function (viewfinderWidth, viewfinderHeight) {
            const side = Math.floor(Math.min(viewfinderWidth, viewfinderHeight) * 0.8);
            return { width: side, height: side };
        }
    };

    // Inicia a câmera traseira (environment)
    html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback)
        .catch((err) => {
            alert("Erro ao iniciar câmera: " + err);
            fecharScanner();
        });
}

function fecharScanner() {
    const container = document.getElementById('reader-container');
    if (html5QrCode) {
        html5QrCode.stop().then(() => {
            container.style.display = 'none';
        }).catch(() => {
            container.style.display = 'none';
        });
    } else {
        container.style.display = 'none';
    }
}
