<?php require "../controllers/validar_acesso.php"; ?>
<?php require '../components/modals/all_modals.php'; ?>

<?php
// LÓGICA DE BUSCA DE ASSOCIAÇÕES EXISTENTES
$requisitos_associados = [];
if (isset($_POST['tipo']) && !empty($_POST['tipo'])) {
    $tipomaquina_id = $_POST['tipo'];

    // Usando a conexão $conn que você já possui no projeto
    $sql_assoc = "SELECT requisitos_id FROM tipomaquina_requisito WHERE tipomaquina_id = ?";
    $stmt_assoc = $conn->prepare($sql_assoc);
    $stmt_assoc->bind_param("i", $tipomaquina_id);
    $stmt_assoc->execute();
    $res_assoc = $stmt_assoc->get_result();

    while ($row = $res_assoc->fetch_assoc()) {
        $requisitos_associados[] = $row['requisitos_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br" data-tema="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisitos - NR12</title>

    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/style.css">  
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/modal.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/icons/favicon.ico" type="image/x-icon">

    <style>
        #lista-requisitos {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            min-height: 60px;
        }

        #lista-requisitos::-webkit-scrollbar {
            width: 6px;
        }

        #lista-requisitos::-webkit-scrollbar-thumb {
            background: #bbb;
            border-radius: 10px;
        }

        .checklist-container {
            width: 100%;
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: var(--corFundo2);
            padding: 10px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .checklist-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 8px 5px;
            border-bottom: 1px solid #eee;
            transition: background 0.2s;
            border-radius: 5px 5px 0 0;
        }
        
        .checklist-item:last-child {
            border-bottom: none;
        }
        
        .checklist-item:hover {
            background-color: var(--hoverTr);
        }
        
        .checklist-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: var(--corDestaque);
        }
        
        .checklist-item label {
            cursor: pointer;
            font-size: 14px;
            color: var(--corTxt3);
            line-height: 1.4;
            font-weight: 500;
        }

        .selecionado-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            gap: 10px;
            background: #fff;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #eee;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.3s ease;
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

    <?php require '../components/nav.php'; ?>

    <section class="sec-main dontmove" style="align-items: center; justify-content: center;">

        <div class="modal-box" style="width: 50em; height: auto">
            <div class="modal-header">
                <h3>Relacionar Requisitos</h3>
            </div>

            <form id="form-suporte" class="modal-form" method="POST" action="">

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

                <div class="modal-row">
                    <div class="modal-input">
                        <label for="tipo">Tipo de Máquina: </label>
                        <div class="input-wrapper">
                            <select name="tipo" id="tipo" onchange="this.form.submit()">
                                <option value="">Selecione...</option>
                                <?php
                                $sql = "SELECT idtipomaquina, tipomaquina_nome FROM tipomaquina ORDER BY tipomaquina_nome";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($resultado = $result->fetch_assoc()) {
                                        $selected = (isset($_POST['tipo']) && $_POST['tipo'] == $resultado['idtipomaquina']) ? 'selected' : '';
                                        echo '<option value="' . $resultado['idtipomaquina'] . '" ' . $selected . '>' . $resultado['tipomaquina_nome'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
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
                                $texto = $resultado['requisito_topico'];
                                $tipo = $resultado['tipo_req'];

                                // Verifica se o requisito já está associado
                                $checked = in_array($id, $requisitos_associados) ? 'checked' : '';

                                echo "
                                    <div class='checklist-item' data-tipo='$tipo'>
                                        <input type='checkbox' name='requisitos_selecionados[]' value='$id' id='req_$id' data-nome='$texto' $checked onclick='atualizarListaSelecionados(this)'>
                                        <label for='req_$id'>$texto</label>
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
                            <p id="placeholder-msg" style="color: #888; font-style: italic; margin: 0;">Nenhum requisito selecionado.</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="associar_requisitos" class="btn-confirmar-full confirmar" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer;">
                        Salvar Associação
                    </button>
                </div>

            </form>
        </div>
    </section>

    <script>
        // LÓGICA DE AUTO-PREENCHIMENTO AO CARREGAR A PÁGINA
        document.addEventListener("DOMContentLoaded", function() {
            // Busca todos os checkboxes que vieram marcados do PHP
            const marcados = document.querySelectorAll('input[name="requisitos_selecionados[]"]:checked');
            marcados.forEach(checkbox => {
                atualizarListaSelecionados(checkbox);
            });
        });

        function atualizarListaSelecionados(checkbox) {
            const lista = document.getElementById('lista-requisitos');
            const id = checkbox.value;
            const nome = checkbox.getAttribute('data-nome');

            if (checkbox.checked) {
                const placeholder = document.getElementById('placeholder-msg');
                if (placeholder) placeholder.remove();

                // Evita duplicar se a função for chamada duas vezes
                if (!document.getElementById('selecionado-' + id)) {
                    const div = document.createElement('div');
                    div.id = 'selecionado-' + id;
                    div.className = 'selecionado-wrapper';

                    div.innerHTML = `
                        <i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 1.2rem;"></i>
                        <span style="flex-grow: 1; font-size: 14px; color: #333;">${nome}</span>
                        <button type="button" onclick="desmarcarRequisito('${id}')" style="background: none; color: #ff4d4d; border: none; cursor: pointer; padding: 5px;">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    `;
                    lista.appendChild(div);
                }
            } else {
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

        // Filtros permanecem iguais
        document.getElementById('pesquisa').addEventListener('input', function() {
            const termo = this.value.toLowerCase();
            const itens = document.querySelectorAll('.checklist-item');
            itens.forEach(item => {
                const texto = item.innerText.toLowerCase();
                item.style.display = texto.includes(termo) ? 'flex' : 'none';
            });
        });

        document.getElementById('filtro').addEventListener('change', function() {
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
    </script>

    <script src="../../js/scripts.js" defer></script>
</body>

</html>