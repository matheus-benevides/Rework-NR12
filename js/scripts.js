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
}

function showPass() {
    // Coleto e armazenos o Btn do Olho e o Input de Senha

    let eye = document.getElementById("btnEyeLogin");
    let inputPass = document.getElementById("senhaLogin");


    if (eye.innerHTML.match('<i class="bi bi-eye-slash"></i>')) {
        inputPass.type = "text";
        eye.innerHTML = '<i class="bi bi-eye-fill"></i>';
    } else {
        inputPass.type = "password";
        eye.innerHTML = '<i class="bi bi-eye-slash"></i>';
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
        inputs[0].placeholder = "Matrícula";
        inputs[1].placeholder = "NI da Máquina";
        icons[0].className = "bi bi-person-badge-fill";
        icons[1].className = "bi bi-cpu-fill";

        btnEsp[0].style.visibility = "visible";
        btnEsp[1].style.visibility = "visible";

        btnEsp[0].innerHTML = '<i class="bi bi-qr-code-scan"></i>';
        btnEsp[1].innerHTML = '<i class="bi bi-qr-code-scan"></i>';
        btnEsp[0].onclick = () => lerQr(0);
        btnEsp[1].onclick = () => lerQr(1);

        btnTrocar.innerHTML = "Voltar para Login Colaborador";
        modoAluno = true;
    } else {
        inputs[0].type = "email";
        inputs[1].type = "password";

        inputs[0].name = 'email';
        inputs[1].name = 'senhaLogin';
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

    arrow.addEventListener('mouseenter', () => {
        arrow.style.animation = 'arrow 0.8s 2 linear';
    });

    arrow.addEventListener('mouseleave', () => {
        arrow.style.animation = 'none';
    });

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
                    main.style = 'padding-left: 16%';
                    clearTimeout();
                }, 65)
            }
            else {
                setTimeout(() => {
                    divImg.style.display = 'flex';
                    divConfig.style.display = 'flex';
                    navLinks.style.display = 'flex';
                    main.style = 'padding-left: 16%';
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
        document.getElementById("ativarAluno").style.display = "flex";
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
    } else if (qual == "editarUnidade") {
        document.getElementById("editarUnidade").style.display = "flex";
    } else if (qual == "deletarUnidade") {
        document.getElementById("deletarUnidade").style.display = "flex";
    } else if (qual == "adicaoSetor") {
        document.getElementById("adicaoSetor").style.display = "flex";
    } else if (qual == "editarSetor") {
        document.getElementById("editarSetor").style.display = "flex";
    } else if (qual == "desativarSetor") {
        document.getElementById("desativarSetor").style.display = "flex";
    } else if (qual == "adicaoColaborador") {
        document.getElementById("adicaoColaborador").style.display = "flex";
    } else if (qual == "editarColaborador") {
        document.getElementById("editarColaborador").style.display = "flex";
    } else if (qual == "deletarColaborador") {
        document.getElementById("deletarColaborador").style.display = "flex";
    } else if (qual == "desativarColaborador") {
        document.getElementById("desativarColaborador").style.display = "flex";
    } else if (qual == 'resetPass') {
        document.getElementById('resetPass').style.display = 'flex';
        document.getElementById("id_usuario_reset").value = id;
    } else if (qual == "adicaoMotor") {
        document.getElementById('adicaoMotor').style.display = "flex";
    } else if (qual == "editarMotor") {
        document.getElementById('editarMotor').style.display = "flex";
    } else if (qual == "deletarMotor") {
        document.getElementById('deletarMotor').style.display = "flex";
    } else if (qual == "adicaoMaquina") {
        document.getElementById("adicaoMaquina").style.display = "flex";
    } else if (qual == "deletarMaquina") {
        document.getElementById("deletarMaquina").style.display = "flex";
    } else if (qual == "edicaoMaquina") {
        document.getElementById("edicaoMaquina").style.display = "flex";
    } else if (qual == "desativarMotor") {
        document.getElementById('desativarMotor').style.display = "flex";
    } else if (qual == "notificacao-modal") {
        document.getElementById("notificacao-modal").style.display = "flex";
    } else if (qual == "adicaoSuporte") {
        document.getElementById("adicaoSuporte").style.display = "flex";
    }
}

function closeModal(qual) {
    if (qual == "adicaoCurso") {
        document.getElementById("adicaoCurso").style.display = "none";
    } else if (qual == "desativarCurso") {
        document.getElementById("desativarCurso").style.display = "none";
    } else if (qual == "ativarCurso") {
        document.getElementById("ativarCurso").style.display = "none";
    } else if (qual == "edicaoCurso") {
        document.getElementById("edicaoCurso").style.display = "none";
    } else if (qual == "adicaoAluno") {
        document.getElementById("adicaoAluno").style.display = "none";
    } else if (qual == "edicaoAluno") {
        document.getElementById("edicaoAluno").style.display = "none";
    } else if (qual == "desativarAluno") {
        document.getElementById("desativarAluno").style.display = "none";
    } else if (qual == "ativarAluno") {
        document.getElementById("ativarAluno").style.display = "none";
    } else if (qual == "deletarAluno") {
        document.getElementById("deletarAluno").style.display = "none";
    } else if (qual == "adicaoTurma") {
        document.getElementById("adicaoTurma").style.display = "none";
    } else if (qual == "edicaoTurma") {
        document.getElementById("edicaoTurma").style.display = "none";
    } else if (qual == "deletarTurma") {
        document.getElementById("deletarTurma").style.display = "none";
    } else if (qual == "ativarTurma") {
        document.getElementById("ativarTurma").style.display = "none";
    } else if (qual == "adicaoUnidade") {
        document.getElementById("adicaoUnidade").style.display = "none";
    } else if (qual == "editarUnidade") {
        document.getElementById("editarUnidade").style.display = "none";
    } else if (qual == "deletarUnidade") {
        document.getElementById("deletarUnidade").style.display = "none";
    } else if (qual == "adicaoSetor") {
        document.getElementById("adicaoSetor").style.display = "none";
    } else if (qual == "editarSetor") {
        document.getElementById("editarSetor").style.display = "none";
    } else if (qual == "desativarSetor") {
        document.getElementById("desativarSetor").style.display = "none";
    } else if (qual == "adicaoColaborador") {
        document.getElementById("adicaoColaborador").style.display = "none";
    } else if (qual == "editarColaborador") {
        document.getElementById("editarColaborador").style.display = "none";
    } else if (qual == "deletarColaborador") {
        document.getElementById("deletarColaborador").style.display = "none";
    } else if (qual == "desativarColaborador") {
        document.getElementById("desativarColaborador").style.display = "none";
    } else if (qual == 'resetPass') {
        document.getElementById('resetPass').style.display = "none";
    } else if (qual == "adicaoMotor") {
        document.getElementById('adicaoMotor').style.display = "none";
    } else if (qual == "editarMotor") {
        document.getElementById('editarMotor').style.display = "none";
    } else if (qual == "deletarMotor") {
        document.getElementById('deletarMotor').style.display = "none";
    } else if (qual == "desativarMotor") {
        document.getElementById('desativarMotor').style.display = "none";
    } else if (qual == "adicaoMaquina") {
        document.getElementById("adicaoMaquina").style.display = "none";
    } else if (qual == "deletarMaquina") {
        document.getElementById("deletarMaquina").style.display = "none";
    } else if (qual == "edicaoMaquina") {
        document.getElementById("edicaoMaquina").style.display = "none";
    } else if (qual == "notificacao-modal") {
        document.getElementById("notificacao-modal").style.display = "none";
    } else if(qual == "adicaoSuporte"){
        document.getElementById("adicaoSuporte").style.display = "none";
    } else {
        document.getElementById("acesso").style.display = "none";
    }
}

function resetarSenha(id) {
    window.location.href = '../actions/colaboradores/reset_senha.php?id=' + id;
}

document.addEventListener("DOMContentLoaded", function () {
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
    if (tabelaCursos12 != undefined) { // Verificando tabela 11
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
});


function filtrarTabela() {
    const select1 = document.querySelector("#select-filtro-status");
    const linhas = document.querySelectorAll("#tabela-cursos tr");

    if (!select1) return;

    const filtro = select1.value.toLowerCase().trim();

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

function filtrarTabela2() {
    const select2 = document.querySelector("#select-filtro-turmas");
    const linhas = document.querySelectorAll("#tabela-turmas tr");

    if (!select2) return;

    const filtro = select2.value.toLowerCase().trim();

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


function filtrarTurmas() {
    const select = document.querySelector("#select-filtro-turmas");
    const linhas = document.querySelectorAll("#tabela-turmas tr");

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

function filtrarSetor() {
    const select = document.getElementById("filtro-setor");
    const filtro = select.value.toLowerCase();
    const tabela = document.getElementById("tabela-setores");
    const linhas = tabela.getElementsByTagName("tr");

    for (let i = 1; i < linhas.length; i++) {
        const linha = linhas[i];
        const colunas = linha.getElementsByTagName("td");
        const colunaStatus = colunas[3];

        if (colunaStatus) {
            const textoStatus = colunaStatus.textContent.toLowerCase().trim();

            if (filtro === "todos" || textoStatus === filtro) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        }
    }
}

filtrarSetor = () => {
    const select = document.querySelector("#select-filtro-setor");
    const linhas = document.querySelectorAll("#tabela-setores tr");

    if (!select) return;

    const filtro = select.value.toLowerCase().trim();

    linhas.forEach(linha => {
        const colunaStatus = linha.getElementsByTagName("td")[3];

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
document.addEventListener("DOMContentLoaded", function () {

    const selectTurmas = document.querySelector("#select-filtro-turmas");
    if (selectTurmas) {
        selectTurmas.addEventListener("change", filtrarTurmas);
    }

    const selectCursos = document.querySelector("#select-filtro-status");
    if (selectCursos) {
        selectCursos.addEventListener("change", filtrarTabela);
    }

    const selectAlunos = document.querySelector("#select-filtro-alunos");
    if (selectAlunos) {
        selectAlunos.addEventListener("change", filtrarAlunos);
    }

    const selectSetores = document.querySelector("#select-filtro-setor");
    if (selectSetores) {
        selectSetores.addEventListener("change", filtrarSetor);
    }
    const selectMaquinas = document.querySelector("#select-filtro-maquinas");
    if (selectSetores) {
        selectSetores.addEventListener("change", filtrarMaquinas);
    }
});

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

    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

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