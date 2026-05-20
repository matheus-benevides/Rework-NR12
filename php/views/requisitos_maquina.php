<?php
require __DIR__ . "/../controllers/validar_acesso.php";
require __DIR__ . '/../components/modals/all_modals.php';

// Carrega os relacionamentos atuais para exibir na interface
$sql_assoc = "SELECT tipomaquina_id, requisitos_id FROM tipomaquina_requisito";
$res_assoc = $conn->query($sql_assoc);
$maquinaRequisitos = [];
if ($res_assoc) {
    while ($row = $res_assoc->fetch_assoc()) {
        $maquinaRequisitos[$row['tipomaquina_id']][] = $row['requisitos_id'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisitos de Máquinas - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #lista-requisitos {
            background: var(--corFundo);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid var(--corBordas);
            max-height: 200px;
            overflow-y: auto;
            min-height: 60px;
        }

        .checklist-container::-webkit-scrollbar {
            width: 6px;
        }

        .checklist-container::-webkit-scrollbar-thumb {
            background: var(--hoverTr);
            border-radius: 10px;
        }

        #lista-requisitos::-webkit-scrollbar {
            width: 6px;
        }

        #lista-requisitos::-webkit-scrollbar-thumb {
            background: var(--hoverTr);
            border-radius: 10px;
        }

        .checklist-container {
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid var(--corBordas);
            border-radius: 8px;
            background-color: var(--corFundo2);
            padding: 12px;
            display: grid;
            gap: 10px;
        }

        .checklist-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 15px;
            background: var(--corFundo);
            border: 1px solid var(--corBordas);
            border-radius: 6px;
            transition: all 0.2s ease;
            cursor: pointer;
            user-select: none;
        }

        .checklist-item:hover {
            background-color: var(--hoverTr);
            border-color: var(--corDestaque);
            transform: translateY(-1px);
        }

        .checklist-item.selected {
            border-color: var(--confirmar);
            background: rgba(0, 255, 0, 0.05);
        }

        .checklist-item input[type="checkbox"] {
            display: none;
        }

        /* Indicador circular igual ao de selecionados */
        .checklist-item .check-indicator {
            width: 20px;
            height: 20px;
            border: 2px solid var(--corBordas);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: transparent;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .checklist-item.selected .check-indicator {
            background: var(--confirmar);
            border-color: var(--confirmar);
            color: white;
        }

        .checklist-item label {
            cursor: pointer;
            font-size: 14px;
            color: var(--corTxt3);
            font-weight: 500;
            margin: 0;
            flex-grow: 1;
        }

        .selecionado-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            gap: 10px;
            background: var(--corFundo2);
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px solid var(--corBordas);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.3s ease;
        }

        .selecionado-wrapper:hover {
            background: var(--hoverTr);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <?php require __DIR__ . '/../components/nav.php'; ?>

    <section class="sec-main">
        <?php require __DIR__ . '/../components/header.php'; ?>

        <div class="page-actions-bar">
            <form action="" method="GET" class="page-search-form">
                <?php $busca_atual = isset($_GET['search']) ? $_GET['search'] : ''; ?>
                <div class="page-search-box <?php echo $busca_atual ? 'has-content' : ''; ?>">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($busca_atual); ?>" placeholder="Pesquisar...">
                    <?php if ($busca_atual): ?>
                        <a href="?" class="page-clear-btn"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-link-45deg"></i>
                <h2>Requisitos de Máquinas</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>ID</th>
                    <th>Descrição Máquina</th>
                    <th>Qtd. Requisitos Associados</th>
                    <th>Ações</th>
                </thead>
                <tbody id="tabela-requisitos-maquina-srv">
                    <?php
                    // Configuração da Paginação
                    $registros_por_pagina = 10;
                    $pagina_atual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($pagina_atual < 1) $pagina_atual = 1;
                    $offset = ($pagina_atual - 1) * $registros_por_pagina;

                    // Query Base
                    $where = "WHERE 1=1";
                    if (!empty($busca_atual)) {
                        $termo_seguro = $conn->real_escape_string($busca_atual);
                        $where .= " AND (tipomaquina_nome LIKE '%$termo_seguro%')";
                    }

                    // Query de Contagem
                    $sql_count = "SELECT COUNT(*) as total FROM tipomaquina $where";
                    $total_resultado = $conn->query($sql_count);
                    $total_registros = $total_resultado->fetch_assoc()['total'];
                    $total_paginas = ceil($total_registros / $registros_por_pagina);

                    // Query Principal com Paginação
                    $sql = "SELECT idtipomaquina, tipomaquina_nome FROM tipomaquina $where ORDER BY tipomaquina_nome ASC LIMIT $registros_por_pagina OFFSET $offset";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($linha = $result->fetch_assoc()) {
                            $id = $linha['idtipomaquina'];
                            $nome = htmlspecialchars($linha['tipomaquina_nome']);
                            $qtd = isset($maquinaRequisitos[$id]) ? count($maquinaRequisitos[$id]) : 0;

                            echo "<tr>";
                            echo "<td>{$id}</td>";
                            echo "<td>{$nome}</td>";
                            echo "<td><span class='status-ativo' style='background-color: var(--corBase); color: #fff;'>{$qtd} Requisitos</span></td>";
                            echo "<td>
                                    <div style='display: flex; gap: 5px; justify-content: center;'>
                                        <button class='btnAcao editar' title='Relacionar Requisitos' type='button' style='width: auto; padding: 5px 15px;' onclick=\"abrirModalRelacionar({$id}, '{$nome}')\">
                                            <i class='bi bi-link-45deg'></i> Relacionar
                                        </button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center; padding:30px; opacity:0.6;'><i class='bi bi-info-circle' style='font-size:1.5rem; display:block; margin-bottom:10px;'></i>Nenhuma descrição de máquina encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
                        <div class="page-pagination">
                <?php if ($pagina_atual > 1): ?>
                    <a href="?search=<?php echo urlencode($busca_atual); ?>&page=<?php echo $pagina_atual - 1; ?>" class="pag-btn"><i class="bi bi-chevron-left"></i> Anterior</a>
                <?php else: ?>
                    <span class="pag-btn disabled"><i class="bi bi-chevron-left"></i> Anterior</span>
                <?php endif; ?>
                <span class="pag-current">Página <?php echo $pagina_atual; ?> de <?php echo max(1, $total_paginas); ?></span>
                <?php if ($pagina_atual < $total_paginas): ?>
                    <a href="?search=<?php echo urlencode($busca_atual); ?>&page=<?php echo $pagina_atual + 1; ?>" class="pag-btn">Próxima <i class="bi bi-chevron-right"></i></a>
                <?php else: ?>
                    <span class="pag-btn disabled">Próxima <i class="bi bi-chevron-right"></i></span>
                <?php endif; ?>
            </div>
         </div>

    </section>

    <!-- MODAL RELACIONAR REQUISITOS -->
    <div class="modal-fundo" id="relacionarRequisitos" style="display: none">
        <div class="modal-box" style="width: 50em; height: auto">
            <div class="modal-header">
                <h3>Relacionar Requisitos: <span id="nome_maquina_display" style="color: var(--corDestaque);"></span>
                </h3>
                <button type="button" onclick="closeModal('relacionarRequisitos')"><i class="bi bi-x-lg"></i></button>
            </div>

            <form id="form-relacionar-requisitos" class="modal-form">
                <!-- Passa o ID da máquina selecionada via hidden input -->
                <input type="hidden" name="tipo" id="tipo" value="">

                <div class="modal-row">
                    <div class="modal-input">
                        <label for="filtro">Filtrar por Tipo de Requisitos: </label>
                        <div class="input-wrapper">
                            <select name="filtro" id="filtro">
                                <option value="Todos" selected>Todos</option>
                                <option value="Seguranca">Segurança</option>
                                <option value="Operacional">Operacional</option>
                                <option value="Preventivo">Preventivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-input">
                        <label for="pesquisa">Pesquisar por Nome: </label>
                        <div class="input-wrapper">
                            <input type="text" name="pesquisa" id="pesquisa" placeholder="Digite para buscar...">
                        </div>
                    </div>
                </div>

                <div class="modal-input">
                    <label>Requisitos:</label>
                    <div class="checklist-container" id="container-principal">
                        <?php
                        $sql = "SELECT idrequisitos, requisito_topico, tipo_req FROM requisitos WHERE requisitos_status = 'Ativo' ORDER BY idrequisitos";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($resultado = $result->fetch_assoc()) {
                                $id = $resultado['idrequisitos'];
                                $texto = htmlspecialchars($resultado['requisito_topico']);
                                $tipo = $resultado['tipo_req'];

                                echo "
                                    <div class='checklist-item' data-tipo='$tipo' id='card_$id' onclick=\"toggleRequirement('$id')\">
                                        <input type='checkbox' name='requisitos_selecionados[]' value='$id' id='req_$id' data-nome='$texto' onclick='event.stopPropagation(); atualizarListaSelecionados(this)'>
                                        <div class='check-indicator'><i class='bi bi-check-lg'></i></div>
                                        <label for='req_$id' onclick='event.preventDefault()'>$texto</label>
                                    </div>";
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="modal-row" style="margin-top: 20px;">
                    <div class="modal-input" style="width: 100%;">
                        <label>Itens Selecionados (Checklist):</label>
                        <div id="lista-requisitos">
                            <p id="placeholder-msg" style="color: var(--corTxt3); font-style: italic; margin: 0;">Nenhum
                                requisito selecionado.</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="associar_requisitos" class="btn-confirmar-full confirmar"
                        style="background: var(--confirmar); color: white; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer;">
                        Salvar Associação
                    </button>
                </div>

            </form>
        </div>
    </div>


    <script>
        // LÓGICA DE EXIBIÇÃO DA MODAL COM DADOS DA LÓGICA PHP
        const maquinaRequisitos = <?= json_encode($maquinaRequisitos) ?>;

        function abrirModalRelacionar(id, nome) {
            document.getElementById('tipo').value = id;
            document.getElementById('nome_maquina_display').innerText = nome;

            // 1. Limpar todas as seleções atuais
            document.querySelectorAll('.checklist-item').forEach(card => {
                card.classList.remove('selected');
                card.querySelector('input').checked = false;
            });

            // 2. Limpar visualização da lista na UI
            document.getElementById('lista-requisitos').innerHTML = '<p id="placeholder-msg" style="color: #888; font-style: italic; margin: 0;">Nenhum requisito selecionado.</p>';

            // 3. Marcar apenas o que pertence Ã  máquina selecionada
            const reqs = maquinaRequisitos[id] || [];
            reqs.forEach(reqId => {
                const cb = document.getElementById('req_' + reqId);
                if (cb) {
                    cb.checked = true;
                    const card = document.getElementById('card_' + reqId);
                    if (card) card.classList.add('selected');
                    atualizarListaSelecionados(cb);
                }
            });

            // 4. Mostrar a modal
            if (typeof showModal === "function") {
                showModal('relacionarRequisitos');
            } else {
                document.getElementById('relacionarRequisitos').style.display = 'flex';
            }
        }

        function toggleRequirement(id) {
            const cb = document.getElementById('req_' + id);
            if (cb) {
                cb.checked = !cb.checked;
                atualizarListaSelecionados(cb);
            }
        }

        // LÓGICA DE LISTA SELECIONADA (Checkbox para a Lista Visual abaixo)
        function atualizarListaSelecionados(checkbox) {
            const lista = document.getElementById('lista-requisitos');
            const id = checkbox.value;
            const nome = checkbox.getAttribute('data-nome');
            const card = document.getElementById('card_' + id);

            if (checkbox.checked) {
                if (card) card.classList.add('selected');
                const placeholder = document.getElementById('placeholder-msg');
                if (placeholder) placeholder.remove();

                if (!document.getElementById('selecionado-' + id)) {
                    const div = document.createElement('div');
                    div.id = 'selecionado-' + id;
                    div.className = 'selecionado-wrapper';

                    div.innerHTML = `
                        <i class="bi bi-check-circle-fill" style="color: var(--confirmar); font-size: 1.2rem;"></i>
                        <span style="flex-grow: 1; font-size: 14px; color: var(--corTxt3);">${nome}</span>
                        <button type="button" onclick="desmarcarRequisito('${id}')" style="background: none; color: var(--corDestaque); border: none; cursor: pointer; padding: 5px;">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    `;
                    lista.appendChild(div);
                }
            } else {
                if (card) card.classList.remove('selected');
                const itemParaRemover = document.getElementById('selecionado-' + id);
                if (itemParaRemover) itemParaRemover.remove();
                verificarListaVazia();
            }
        }

        function desmarcarRequisito(id) {
            const checkboxOriginal = document.getElementById('req_' + id);
            if (checkboxOriginal) {
                checkboxOriginal.checked = false;
                atualizarListaSelecionados(checkboxOriginal);
            }
        }

        function verificarListaVazia() {
            const lista = document.getElementById('lista-requisitos');
            if (lista.querySelectorAll('.selecionado-wrapper').length === 0) {
                lista.innerHTML = '<p id="placeholder-msg" style="color: #888; font-style: italic; margin: 0;">Nenhum requisito selecionado.</p>';
            }
        }

        // Filtros da modal
        document.getElementById('pesquisa').addEventListener('input', function () {
            const termo = this.value.toLowerCase();
            const itens = document.querySelectorAll('.checklist-item');
            itens.forEach(item => {
                const texto = item.innerText.toLowerCase();
                item.style.display = texto.includes(termo) ? 'flex' : 'none';
            });
        });

        document.getElementById('filtro').addEventListener('change', function () {
            const tipoSelecionado = this.value;
            const itens = document.querySelectorAll('.checklist-item');
            itens.forEach(item => {
                const tipoItem = item.getAttribute('data-tipo');
                if (tipoSelecionado === 'Todos' || tipoItem === tipoSelecionado) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        // Submissão do Formulário via Fetch API
        const formRelacionar = document.getElementById('form-relacionar-requisitos');
        if (formRelacionar) {
            formRelacionar.addEventListener('submit', async function (e) {
                e.preventDefault();

                const tipomaquinaId = document.getElementById('tipo').value;
                const checkboxes = document.querySelectorAll('input[name="requisitos_selecionados[]"]:checked');
                const requisitosIds = Array.from(checkboxes).map(cb => cb.value);

                if (!tipomaquinaId) {
                    alert('Nenhuma máquina selecionada.');
                    return;
                }

                const btnSubmit = formRelacionar.querySelector('button[type="submit"]');
                const originalText = btnSubmit.innerHTML;
                btnSubmit.innerHTML = 'Salvando...';
                btnSubmit.disabled = true;

                try {
                    const response = await fetch('../apis/processa_tipomaquina_requisitos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            tipomaquina_id: tipomaquinaId,
                            requisitos_ids: requisitosIds
                        })
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
                    alert('Erro de conexão ao salvar associação.');
                } finally {
                    btnSubmit.innerHTML = originalText;
                    btnSubmit.disabled = false;
                }
            });
        }
    </script>

    <!-- Usando script central de JS da aplicação -->
    <script src="../../js/scripts.js" defer></script>
</body>

</html>
