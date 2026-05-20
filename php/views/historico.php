<?php require __DIR__ . '/../controllers/validar_acesso.php'; ?>
<?php require __DIR__ . '/../configs/conexao.php'; ?>
<?php require __DIR__ . '/../components/modals/all_modals.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historico - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">


    <style>
        .checklist-container {
            width: 100%;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid var(--corBordas);
            border-radius: 8px;
            background-color: var(--corFundo2);
            padding: 12px;
            display: grid;
            gap: 10px;
        }

        .checklist-container::-webkit-scrollbar {
            width: 6px;
        }

        .checklist-container::-webkit-scrollbar-thumb {
            background: var(--hoverTr);
            border-radius: 10px;
        }

        .checklist-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 15px;
            background: var(--corFundo);
            border: 1px solid var(--corBordas);
            border-radius: 6px;
        }

        .checklist-item.selected {
            border-color: var(--confirmar);
            background: rgba(0, 255, 0, 0.05);
        }

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
            flex-shrink: 0;
        }

        .checklist-item.selected .check-indicator {
            background: var(--confirmar);
            border-color: var(--confirmar);
            color: white;
        }

        .checklist-item.nao-checado {
            border-color: #dc3545;
            background: rgba(220, 53, 69, 0.05);
        }

        .checklist-item.nao-checado .check-indicator {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .checklist-item label {
            font-size: 14px;
            color: var(--corTxt3);
            font-weight: 500;
            margin: 0;
            flex-grow: 1;
        }
    </style>
</head>

<body>
    <?php require __DIR__ . '/../components/nav.php'; ?>

    <section class="sec-main">

        <?php require __DIR__ . '/../components/header.php'; ?>

        <?php
        // Capturar filtros
        $busca_atual = isset($_GET['search']) ? $_GET['search'] : '';
        $filtro_maquina = isset($_GET['filtro-maquina']) ? trim($_GET['filtro-maquina']) : '';
        $filtro_colaborador = isset($_GET['filtro-colaborador']) ? trim($_GET['filtro-colaborador']) : '';

        // Queries leves para filtros rápidos
        $maquinas_lista = [];
        $r = $conn->query("SELECT DISTINCT CONCAT(COALESCE(NULLIF(m.modelo, ''), m.denominacao), ' (', m.numero_identificacao, ')') AS nome_ni
                           FROM historico h
                           LEFT JOIN manutencao_tds2026.maquinas m ON h.maquina_id = m.id
                           WHERE m.id IS NOT NULL
                           ORDER BY nome_ni ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $maquinas_lista[] = $row['nome_ni']; }

        $colaboradores_lista = [];
        $r = $conn->query("SELECT DISTINCT c.colaborador_nome
                           FROM historico h
                           LEFT JOIN colaborador c ON h.colaborador_id = c.idcolaborador
                           WHERE c.colaborador_nome IS NOT NULL
                           ORDER BY c.colaborador_nome ASC");
        if ($r) { while ($row = $r->fetch_assoc()) $colaboradores_lista[] = $row['colaborador_nome']; }
        ?>

        <div class="page-actions-bar">
            <form action="" method="GET" class="page-search-form">
                <div class="page-search-box <?php echo $busca_atual ? 'has-content' : ''; ?>">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($busca_atual); ?>" placeholder="Pesquisar histórico...">
                    <?php if ($busca_atual): ?>
                        <a href="?" class="page-clear-btn"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
                <?php if (!empty($maquinas_lista)): ?>
                <div class="page-filter-box">
                    <label>Máquina:</label>
                    <select name="filtro-maquina" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($maquinas_lista as $m): ?>
                            <option value="<?= htmlspecialchars($m) ?>" <?= $filtro_maquina === $m ? 'selected' : '' ?>><?= htmlspecialchars($m) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <?php if (!empty($colaboradores_lista)): ?>
                <div class="page-filter-box">
                    <label>Colaborador:</label>
                    <select name="filtro-colaborador" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($colaboradores_lista as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>" <?= $filtro_colaborador === $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="tabela-bg2">
            <div class="tabela-titulo">
                <i class="bi bi-clock-history"></i>
                <h2>Histórico</h2>
            </div>
            <div class="tabela-wrapper">
            <table class="tabela-main">
                <thead>
                    <th>Máquina (NI)</th>
                    <th>Aluno</th>
                    <th>Colaborador</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Detalhes</th>
                </thead>
                <tbody id="tabela-historico-srv">
                    <?php
                    // Configuração da Paginação
                    $registros_por_pagina = 10;
                    $pagina_atual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($pagina_atual < 1) $pagina_atual = 1;
                    $offset = ($pagina_atual - 1) * $registros_por_pagina;

                    // Query Base
                    $where = "WHERE 1=1";
                    if (!empty($busca_atual)) {
                        $termo = $conn->real_escape_string($busca_atual);
                        $where = " WHERE (COALESCE(NULLIF(m.modelo, ''), m.denominacao) LIKE '%$termo%' 
                                   OR m.numero_identificacao LIKE '%$termo%' 
                                   OR a.aluno_nome LIKE '%$termo%' 
                                   OR c.colaborador_nome LIKE '%$termo%')";
                    }
                    // Filtro de Máquina
                    if ($filtro_maquina !== '') {
                        $maq_safe = $conn->real_escape_string($filtro_maquina);
                        $where .= " AND CONCAT(COALESCE(NULLIF(m.modelo, ''), m.denominacao), ' (', m.numero_identificacao, ')') = '$maq_safe'";
                    }
                    // Filtro de Colaborador
                    if ($filtro_colaborador !== '') {
                        $where .= " AND c.colaborador_nome = '" . $conn->real_escape_string($filtro_colaborador) . "'";
                    }

                    // Contagem Total
                    $sql_count = "SELECT COUNT(*) as total FROM (
                                    SELECT 1 FROM historico h 
                                    LEFT JOIN aluno a ON h.aluno_id = a.idaluno
                                    LEFT JOIN colaborador c ON h.colaborador_id = c.idcolaborador
                                    LEFT JOIN manutencao_tds2026.maquinas m ON h.maquina_id = m.id
                                    $where
                                    GROUP BY h.historico_data, h.historico_hora, h.maquina_id, h.aluno_id, h.colaborador_id
                                  ) as sub";
                    $total_resultado = $conn->query($sql_count);
                    $total_registros = ($total_resultado && $total_resultado->num_rows > 0) ? $total_resultado->fetch_assoc()['total'] : 0;
                    $total_paginas = ceil($total_registros / $registros_por_pagina);

                    // Query Principal com Paginação
                    $sql = "SELECT 
                                h.historico_data,
                                h.historico_hora,
                                h.maquina_id,
                                h.aluno_id,
                                h.colaborador_id,
                                a.aluno_nome,
                                c.colaborador_nome,
                                COALESCE(NULLIF(m.modelo, ''), m.denominacao) AS maquina_modelo,
                                m.numero_identificacao AS maquina_ni
                            FROM historico h
                            LEFT JOIN aluno a ON h.aluno_id = a.idaluno
                            LEFT JOIN colaborador c ON h.colaborador_id = c.idcolaborador
                            LEFT JOIN manutencao_tds2026.maquinas m ON h.maquina_id = m.id
                            $where
                            GROUP BY h.historico_data, h.historico_hora, h.maquina_id, h.aluno_id, h.colaborador_id
                            ORDER BY h.historico_data DESC, h.historico_hora DESC
                            LIMIT $registros_por_pagina OFFSET $offset";

                    $resultado = $conn->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            $data_br = date('d/m/Y', strtotime($linha["historico_data"]));
                            $hora_br = date('H:i', strtotime($linha["historico_hora"]));

                            echo "<tr>";
                            echo "<td>" . ($linha["maquina_modelo"] ?? 'N/A') . " (" . ($linha["maquina_ni"] ?? '-') . ")</td>";
                            echo "<td>" . ($linha["aluno_nome"] ?? '<span style="opacity:0.5">N/A</span>') . "</td>";
                            echo "<td>" . ($linha["colaborador_nome"] ?? 'N/A') . "</td>";
                            echo "<td>" . $data_br . "</td>";
                            echo "<td>" . $hora_br . "</td>";
                            
                            $maq_id = $linha['maquina_id'];
                            $al_id = $linha['aluno_id'] ?? '';
                            $colab_id = $linha['colaborador_id'] ?? '';
                            
                            echo "<td>";
                            echo "<div style='display: flex; gap: 5px; justify-content: center;'>";
                            echo "<button class='btnAcao editar' title='Ver Detalhes' onclick='abrirModalDetalhes(\"{$linha['historico_data']}\", \"{$linha['historico_hora']}\", \"$maq_id\", \"$al_id\", \"$colab_id\")'>";
                            echo "<i class='bi bi-eye'></i>";
                            echo "</button>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; padding:30px; opacity:0.6;'><i class='bi bi-info-circle' style='font-size:1.5rem; display:block; margin-bottom:10px;'></i>Nenhum registro de histórico encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <?php
                $pag_params = http_build_query(array_filter([
                    'search' => $busca_atual,
                    'filtro-maquina' => $filtro_maquina,
                    'filtro-colaborador' => $filtro_colaborador,
                ], fn($v) => $v !== ''));
            ?>
            <div class="page-pagination">
                <?php if ($pagina_atual > 1): ?>
                    <a href="?<?= $pag_params ?>&page=<?= $pagina_atual - 1 ?>" class="pag-btn"><i class="bi bi-chevron-left"></i> Anterior</a>
                <?php else: ?>
                    <span class="pag-btn disabled"><i class="bi bi-chevron-left"></i> Anterior</span>
                <?php endif; ?>
                <span class="pag-current">Página <?php echo $pagina_atual; ?> de <?php echo max(1, $total_paginas); ?></span>
                <?php if ($pagina_atual < $total_paginas): ?>
                    <a href="?<?= $pag_params ?>&page=<?= $pagina_atual + 1 ?>" class="pag-btn">Próxima <i class="bi bi-chevron-right"></i></a>
                <?php else: ?>
                    <span class="pag-btn disabled">Próxima <i class="bi bi-chevron-right"></i></span>
                <?php endif; ?>
            </div>
         </div>

    </section>

    <!-- Modal Detalhes Histórico -->
    <div class="modal-fundo" id="modalDetalhesHistorico" style="display: none;">
        <div class="modal-box" style="width: 50em; max-width: 90vw; height: auto;">
            <div class="modal-header">
                <h3>Detalhes do Checklist</h3>
                <button onclick="document.getElementById('modalDetalhesHistorico').style.display='none'"><i class="bi bi-x-lg"></i></button>
            </div>
            
            <form class="modal-form" style="padding-bottom: 20px;">
                <div class="modal-input">
                    <label>Requisitos Marcados neste Evento:</label>
                    <div class="checklist-container" id="tabela-detalhes-historico">
                        <!-- Conteúdo será injetado via JS -->
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../../js/scripts.js" defer></script>
    <script>
        function abrirModalDetalhes(data, hora, maq_id, aluno_id, colab_id) {
            const url = `../../php/apis/get_historico_detalhes.php?data=${data}&hora=${hora}&maquina_id=${maq_id}&aluno_id=${aluno_id}&colaborador_id=${colab_id}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if(data.sucesso) {
                        const container = document.getElementById('tabela-detalhes-historico');
                        container.innerHTML = '';
                        
                        data.dados.forEach(item => {
                            const isChecado = item.status.toLowerCase() === 'checado';
                            const classeContainer = isChecado ? 'selected' : 'nao-checado';
                            const icone = isChecado ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>';
                            
                            container.innerHTML += `
                                <div class='checklist-item ${classeContainer}'>
                                    <div class='check-indicator'>${icone}</div>
                                    <label>${item.topico}</label>
                                </div>
                            `;
                        });
                        
                        document.getElementById('modalDetalhesHistorico').style.display = 'flex';
                    } else {
                        alert(data.erro || "Erro ao buscar detalhes do checklist.");
                    }
                })
                .catch(error => {
                    console.error("Erro na requisição AJAX", error);
                    alert("Erro ao se conectar ao servidor.");
                });
        }
    </script>
</body>

</html>
