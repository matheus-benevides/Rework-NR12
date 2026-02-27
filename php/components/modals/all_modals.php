<?php
require_once '../configs/conexao.php';
?>

<!-- Adicionar Curso -->
<div class="modal-fundo" id="adicaoCurso" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Registrar Curso</h3>
            <button class="" onclick="closeModal('adicaoCurso')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-cad-curso" class="modal-form">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nome_curso_cad">Nome do Curso:</label>
                    <input type="text" id="nome_curso_cad" placeholder="Ex: Desenvolvimento de Sistemas">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
                <br>
                <button type="button" class="btn-confirmar-full btn" onclick="showModal('cursosLote')">
                    Cadastrar em Lote <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Adicionar Curso em Lote -->
<div class="modal-fundo" id="cursosLote">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Cadastro em Lote</h3>
            <button class="" onclick="closeModal('cursosLote')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="form-cad-curso-lote" class="modal-form">
            <label for="arquivo-curso" class="modal-input arquivos-div">
                <div class="input-wrapper" id="arquivos-input-curso">
                    <i style="font-size: var(--text-4xl); color: var(--corDestaque)"
                        class="bi bi-cloud-arrow-up-fill"></i>
                    <p class="label-arquivo" id="label-arquivo-curso">Arraste ou Pressione o Arquivo.</p>
                    <p>Somente arquivos .csv, .xlsx e .xls</p>
                    <input type="file" name="arquivo" id="arquivo-curso" accept=".csv, .xlsx, .xls" multiple>
                </div>
            </label>

            <!-- Área de Preview -->
            <div id="preview-curso" class="preview-lote"></div>

            <div class="modal-footer footer-lote">
                <a href="../../_documentos/modelo_cursos.csv" download class="btn-modelo">
                    <i class="bi bi-download"></i> Modelo CSV
                </a>
                <button type="submit" class="btn-confirmar-full confirmar">Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Editar Curso -->
<div class="modal-fundo" id="edicaoCurso" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Curso</h3>
            <button class="" onclick="closeModal('edicaoCurso')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-edit-curso" class="modal-form">
            <input type="hidden" id="id_curso_edit">
            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nome_curso_edit">Nome do Curso:</label>
                    <input type="text" id="nome_curso_edit" placeholder="Ex: Desenvolvimento de Sistemas">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Editar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Desativar Curso -->
<div class="modal-fundo" id="desativarCurso" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Desativar Curso</h3>
            <button onclick="closeModal('desativarCurso')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer desativar?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_curso_delete">
            <button id="btn-confirmar-deletar-curso" class="btn-confirmar-full confirmar">Sim</button>
        </div>
    </div>
</div>

<!-- Ativar Curso -->
<div class="modal-fundo" id="ativarCurso" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Ativar Curso</h3>
            <button onclick="closeModal('ativarCurso')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Ativar esse Curso?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_curso_ativar">
            <button id="btn-confirmar-ativar-curso" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('ativarCurso')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Adicionar Turmas -->
<div class="modal-fundo" id="adicaoTurma" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Registrar Turma</h3>
            <button class="" onclick="closeModal('adicaoTurma')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-cad-turma" class="modal-form">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nome_turma_cad">Nome da Turma:</label>
                    <input type="text" id="nome_turma_cad" placeholder="Ex: TDS2026">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="periodo_turma_cad">Período:</label>
                        <select name="periodo" id="periodo_turma_cad">
                            <option value="" disabled selected>Selecione o Período</option>
                            <option value="Manhã">Manhã</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Noite">Noite</option>
                            <option value="Integral">Integral</option>
                        </select>
                    </div>
                    <div class="input-wrapper">
                        <label for="colaborador_turma_cad">Colaborador:</label>
                        <select name="colaborador" id="colaborador_turma_cad">
                            <option value="" selected disabled>Selecione um colaborador</option>
                            <?php
                            $buscar = "SELECT * FROM colaborador";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idcolaborador'] . "'>" . $linha['colaborador_nome'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-row datas_div">
                <div class="modal-input">
                    <label for="fim_turma_cad">Fim da Turma:</label>
                    <div class="input-wrapper">
                        <input type="date" id="fim_turma_cad">
                    </div>
                </div>
                <div class="modal-input">
                    <label for="inicio_turma_cad">Inicio da Turma:</label>
                    <div class="input-wrapper">
                        <input type="date" id="inicio_turma_cad">
                    </div>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="curso_turma_cad">Curso:</label>
                        <select id="curso_turma_cad">
                            <option value="" selected disabled>Selecione um curso</option>
                            <?php
                            $buscar = "SELECT * FROM curso";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idcurso'] . "'>" . $linha['curso_nome'] . "</option>";
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
                <br>
                <button type="button" class="btn-confirmar-full btn" onclick="showModal('turmasLote')">
                    Cadastrar em Lote <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Adicionar Turma em Lote -->
<div class="modal-fundo" id="turmasLote">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Cadastro em Lote</h3>
            <button class="" onclick="closeModal('turmasLote')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="form-cad-turma-lote" class="modal-form">
            <label for="arquivo-turma" class="modal-input arquivos-div">
                <div class="input-wrapper" id="arquivos-input-turma">
                    <i style="font-size: var(--text-4xl); color: var(--corDestaque)"
                        class="bi bi-cloud-arrow-up-fill"></i>
                    <p class="label-arquivo" id="label-arquivo-turma">Arraste ou Pressione o Arquivo.</p>
                    <p>Somente arquivos .csv, .xlsx e .xls</p>
                    <input type="file" name="arquivo" id="arquivo-turma" accept=".csv, .xlsx, .xls" multiple>
                </div>
            </label>

            <!-- Área de Preview -->
            <div id="preview-turma" class="preview-lote"></div>

            <div class="modal-footer footer-lote">
                <a href="../../_documentos/modelo_turmas.csv" download class="btn-modelo">
                    <i class="bi bi-download"></i> Modelo CSV
                </a>
                <button type="submit" class="btn-confirmar-full confirmar">Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Editar Turmas -->
<div class="modal-fundo" id="edicaoTurma" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Turma</h3>
            <button class="" onclick="closeModal('edicaoTurma')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-edit-turma" class="modal-form">
            <input type="hidden" id="id_turma_edit">
            <div class="modal-input">
                <label for="nome_turma_edit">Nome da Turma:</label>
                <div class="input-wrapper">
                    <input type="text" id="nome_turma_edit" placeholder="Ex: TDS2026">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="periodo_turma_edit">Período:</label>
                        <select id="periodo_turma_edit">
                            <option value="" disabled>Selecione o Período</option>
                            <option value="Manhã">Manhã</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Noite">Noite</option>
                            <option value="Integral">Integral</option>
                        </select>
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="colaborador_turma_edit">Colaborador:</label>
                        <select id="colaborador_turma_edit">
                            <option value="" selected disabled>Selecione um colaborador</option>
                            <?php
                            $buscar = "SELECT * FROM colaborador";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idcolaborador'] . "'>" . $linha['colaborador_nome'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="fim_turma_edit">Fim da Turma:</label>
                        <input type="date" id="fim_turma_edit">
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="inicio_turma_edit">Inicio da Turma:</label>
                        <input type="date" id="inicio_turma_edit">
                    </div>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="curso_turma_edit">Curso:</label>
                        <select id="curso_turma_edit">
                            <option value="" selected disabled>Selecione um curso</option>
                            <?php
                            $buscar = "SELECT * FROM curso";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idcurso'] . "'>" . $linha['curso_nome'] . "</option>";
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Editar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
    </div>
    </form>
</div>

<!-- Deletar Turmas -->
<div class="modal-fundo" id="deletarTurma" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Desativar Turma</h3>
            <button onclick="closeModal('deletarTurma')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer deletar turma?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_turma_delete">
            <button id="btn-confirmar-deletar-turma" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('deletarTurma')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Ativar Turma -->
<div class="modal-fundo" id="ativarTurma" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Ativar Turma</h3>
            <button onclick="closeModal('ativarTurma')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer ativar esta turma?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_turma_ativar">
            <button id="btn-confirmar-ativar-turma" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('ativarTurma')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>



<!-- Adicionar Aluno -->
<div class="modal-fundo" id="adicaoAluno" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Registro de Aluno</h3>
            <button class="" onclick="closeModal('adicaoAluno')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-cad-aluno" class="modal-form">

            <div class="modal-input">
                <label for="nome_aluno_cad">Nome:</label>
                <div class="input-wrapper">
                    <input type="text" id="nome_aluno_cad" placeholder="Ex: Matheus dos Ateus">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="email_aluno_cad">E-mail do Aluno:</label>
                        <input type="email" id="email_aluno_cad" placeholder="aluno@email.com">
                    </div>
                </div>

                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="matricula_aluno_cad">Matricula do Aluno:</label>
                        <input type="text" id="matricula_aluno_cad" placeholder="123456">
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="turma_aluno_cad">Turma:</label>
                        <select id="turma_aluno_cad">
                            <option value="">Selecione a Turma</option>
                            <?php
                            $buscar = "SELECT * FROM turmas";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idturmas'] . "'>" . $linha['turma_nome'] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
                <br>
                <button type="button" class="btn-confirmar-full btn" onclick="showModal('alunosLote')">
                    Cadastrar em Lote <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal-fundo" id="alunosLote">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Cadastro em Lote</h3>
            <button class="" onclick="closeModal('alunosLote')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="form-cad-aluno-lote" class="modal-form">
            <label for="arquivo-aluno" class="modal-input arquivos-div">
                <div class="input-wrapper" id="arquivos-input-aluno">
                    <i style="font-size: var(--text-4xl); color: var(--corDestaque)"
                        class="bi bi-cloud-arrow-up-fill"></i>
                    <p class="label-arquivo" id="label-arquivo-aluno">Arraste ou Pressione o Arquivo.</p>
                    <p>Somente arquivos .csv, .xlsx e .xls</p>
                    <input type="file" name="arquivo" id="arquivo-aluno" accept=".csv, .xlsx, .xls" multiple>
                </div>
            </label>

            <!-- Área de Preview -->
            <div id="preview-aluno" class="preview-lote"></div>

            <div class="modal-footer footer-lote">
                <a href="../../_documentos/modelo_alunos.csv" download class="btn-modelo">
                    <i class="bi bi-download"></i> Modelo CSV
                </a>
                <button type="submit" class="btn-confirmar-full confirmar">Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Editar Aluno -->
<div class="modal-fundo" id="edicaoAluno" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Aluno</h3>
            <button class="" onclick="closeModal('edicaoAluno')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-edit-aluno" class="modal-form">
            <input type="hidden" id="id_aluno_edit">
            <div class="modal-input">
                <label for="nome_aluno_edit">Nome:</label>
                <div class="input-wrapper">
                    <input type="text" id="nome_aluno_edit" placeholder="Ex: Matheus dos Ateus">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="email_aluno_edit">E-mail do Aluno:</label>
                        <input type="email" id="email_aluno_edit" placeholder="aluno@email.com">
                    </div>
                </div>

                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="matricula_aluno_edit">Matricula do Aluno:</label>
                        <input type="text" id="matricula_aluno_edit" placeholder="123456">
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="turma_aluno_edit">Turma:</label>
                        <select id="turma_aluno_edit">
                            <option value="">Selecione a Turma</option>
                            <?php
                            $buscar = "SELECT * FROM turmas";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idturmas'] . "'>" . $linha['turma_nome'] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Editar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Desativar Aluno -->
<div class="modal-fundo" id="desativarAluno" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Desativar Aluno</h3>
            <button onclick="closeModal('desativarAluno')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer desativar este aluno?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_aluno_desativar">
            <button id="btn-confirmar-desativar-aluno" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('desativarAluno')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Deletar Aluno -->
<div class="modal-fundo" id="deletarAluno" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Deletar Aluno Permanente</h3>
            <button onclick="closeModal('deletarAluno')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer deletar permanentemente este aluno?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_aluno_delete">
            <button id="btn-confirmar-deletar-aluno" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('deletarAluno')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Ativar Aluno -->
<div class="modal-fundo" id="ativarAluno" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Ativar Aluno</h3>
            <button onclick="closeModal('ativarAluno')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer ativar este aluno?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_aluno_ativar">
            <button id="btn-confirmar-ativar-aluno" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('ativarAluno')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Adicionar Unidade -->
<div class="modal-fundo" id="adicaoUnidade" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Registrar Unidade</h3>
            <button class="" onclick="closeModal('adicaoUnidade')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-cad-unidade" class="modal-form">

            <div class="modal-input">
                <label for="nome_unidade_cad">Nome:</label>
                <div class="input-wrapper">
                    <input type="text" id="nome_unidade_cad" placeholder="Ex: Senai da Silva">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="cidade_unidade_cad">Cidade:</label>
                        <input type="text" id="cidade_unidade_cad" placeholder="Ex: Votucity">
                    </div>
                </div>

                <div class="modal-input">
                    <label for="estado_unidade_cad">Estado:</label>
                    <select id="estado_unidade_cad">
                        <option value="" disabled selected>Selecione o Estado</option>
                        <option value="Acre">AC</option>
                        <option value="Alagoas">AL</option>
                        <option value="Amapá">AP</option>
                        <option value="Amazonas">AM</option>
                        <option value="Bahia">BA</option>
                        <option value="Ceará">CE</option>
                        <option value="Distrito Federal">DF</option>
                        <option value="Espírito Santo">ES</option>
                        <option value="Goiás">GO</option>
                        <option value="Maranhão">MA</option>
                        <option value="Mato Grosso">MT</option>
                        <option value="Mato Grosso do Sul">MS</option>
                        <option value="Minas Gerais">MG</option>
                        <option value="Pará">PA</option>
                        <option value="Paraíba">PB</option>
                        <option value="Paraná">PR</option>
                        <option value="Pernambuco">PE</option>
                        <option value="Piauí">PI</option>
                        <option value="Rio de Janeiro">RJ</option>
                        <option value="Rio Grande do Norte">RN</option>
                        <option value="Rio Grande do Sul">RS</option>
                        <option value="Rondônia">RO</option>
                        <option value="Roraima">RR</option>
                        <option value="Santa Catarina">SC</option>
                        <option value="São Paulo">SP</option>
                        <option value="Sergipe">SE</option>
                        <option value="Tocantins">TO</option>
                    </select>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-input">
                    <label for="numero_unidade_cad">Número:</label>
                    <div class="input-wrapper">
                        <input type="text" id="numero_unidade_cad" placeholder="Ex: 123">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
                <br>
                <button type="button" class="btn-confirmar-full btn" onclick="showModal('unidadeLote')">
                    Cadastrar em Lote <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Adicionar Unidade em Lote -->
<div class="modal-fundo" id="unidadeLote" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Cadastro em Lote - Unidades</h3>
            <button class="" onclick="closeModal('unidadeLote')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="form-cad-unidade-lote" class="modal-form">
            <label for="arquivo-unidade" class="modal-input arquivos-div">
                <div class="input-wrapper" id="arquivos-input-unidade">
                    <i style="font-size: var(--text-4xl); color: var(--corDestaque)"
                        class="bi bi-cloud-arrow-up-fill"></i>
                    <p class="label-arquivo" id="label-arquivo-unidade">Arraste ou Pressione o Arquivo.</p>
                    <p>Somente arquivos .csv, .xlsx e .xls</p>
                    <input type="file" name="arquivo" id="arquivo-unidade" accept=".csv, .xlsx, .xls" multiple>
                </div>
            </label>

            <!-- Área de Preview -->
            <div id="preview-unidade" class="preview-lote"></div>

            <div class="modal-footer footer-lote">
                <a href="../../_documentos/modelo_unidades.csv" download class="btn-modelo">
                    <i class="bi bi-download"></i> Modelo CSV
                </a>
                <button type="submit" class="btn-confirmar-full confirmar">Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Editar Unidade -->
<div class="modal-fundo" id="edicaoUnidade" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Unidade</h3>
            <button class="" onclick="closeModal('edicaoUnidade')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-edit-unidade" class="modal-form">
            <input type="hidden" id="id_unidade_edit">
            <div class="modal-input">
                <label for="nome_unidade_edit">Nome:</label>
                <div class="input-wrapper">
                    <input type="text" id="nome_unidade_edit" placeholder="Ex: Senai da Silva">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="cidade_unidade_edit">Cidade:</label>
                        <input type="text" id="cidade_unidade_edit" placeholder="Ex: Votucity">
                    </div>
                </div>

                <div class="modal-input">
                    <label for="estado_unidade_edit">Estado:</label>
                    <select id="estado_unidade_edit">
                        <option value="" disabled>Selecione o Estado</option>
                        <option value="Acre">AC</option>
                        <option value="Alagoas">AL</option>
                        <option value="Amapá">AP</option>
                        <option value="Amazonas">AM</option>
                        <option value="Bahia">BA</option>
                        <option value="Ceará">CE</option>
                        <option value="Distrito Federal">DF</option>
                        <option value="Espírito Santo">ES</option>
                        <option value="Goiás">GO</option>
                        <option value="Maranhão">MA</option>
                        <option value="Mato Grosso">MT</option>
                        <option value="Mato Grosso do Sul">MS</option>
                        <option value="Minas Gerais">MG</option>
                        <option value="Pará">PA</option>
                        <option value="Paraíba">PB</option>
                        <option value="Paraná">PR</option>
                        <option value="Pernambuco">PE</option>
                        <option value="Piauí">PI</option>
                        <option value="Rio de Janeiro">RJ</option>
                        <option value="Rio Grande do Norte">RN</option>
                        <option value="Rio Grande do Sul">RS</option>
                        <option value="Rondônia">RO</option>
                        <option value="Roraima">RR</option>
                        <option value="Santa Catarina">SC</option>
                        <option value="São Paulo">SP</option>
                        <option value="Sergipe">SE</option>
                        <option value="Tocantins">TO</option>
                    </select>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-input">
                    <label for="numero_unidade_edit">Número:</label>
                    <div class="input-wrapper">
                        <input type="text" id="numero_unidade_edit" placeholder="Ex: 123">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Editar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Desativar Unidade -->
<div class="modal-fundo" id="desativarUnidade" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Desativar Unidade</h3>
            <button onclick="closeModal('desativarUnidade')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer desativar esta unidade?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_unidade_desativar">
            <button id="btn-confirmar-desativar-unidade" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('desativarUnidade')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Ativar Unidade -->
<div class="modal-fundo" id="ativarUnidade" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Ativar Unidade</h3>
            <button onclick="closeModal('ativarUnidade')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer ativar esta unidade?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_unidade_ativar">
            <button id="btn-confirmar-ativar-unidade" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('ativarUnidade')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Adicionar Setor -->
<div class="modal-fundo" id="adicaoSetor" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Registrar Setor</h3>
            <button class="" onclick="closeModal('adicaoSetor')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-cad-setor" class="modal-form">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nome_setor_cad">Nome:</label>
                    <input type="text" id="nome_setor_cad" placeholder="Ex: Senai da Silva">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="unidade_setor_cad">Unidade:</label>
                        <select id="unidade_setor_cad">
                            <option value="" disabled selected>Selecione a unidade</option>

                            <?php
                            $buscar = "SELECT * FROM unidade";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idunidade'] . "'>" . $linha['unidade_nome'] . "</option>";
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
                <br>
                <button type="button" class="btn-confirmar-full btn" onclick="showModal('setoresLote')">
                    Cadastrar em Lote <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Adicionar Setor em Lote -->
<div class="modal-fundo" id="setoresLote" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Cadastro em Lote - Setores</h3>
            <button class="" onclick="closeModal('setoresLote')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="form-cad-setor-lote" class="modal-form">
            <label for="arquivo-setor" class="modal-input arquivos-div">
                <div class="input-wrapper" id="arquivos-input-setor">
                    <i style="font-size: var(--text-4xl); color: var(--corDestaque)"
                        class="bi bi-cloud-arrow-up-fill"></i>
                    <p class="label-arquivo" id="label-arquivo-setor">Arraste ou Pressione o Arquivo.</p>
                    <p>Somente arquivos .csv, .xlsx e .xls</p>
                    <input type="file" name="arquivo" id="arquivo-setor" accept=".csv, .xlsx, .xls" multiple>
                </div>
            </label>

            <!-- Área de Preview -->
            <div id="preview-setor" class="preview-lote"></div>

            <div class="modal-footer footer-lote">
                <a href="../../_documentos/modelo_setores.csv" download class="btn-modelo">
                    <i class="bi bi-download"></i> Modelo CSV
                </a>
                <button type="submit" class="btn-confirmar-full confirmar">Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Editar Setor -->
<div class="modal-fundo" id="editarSetor" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Setor</h3>
            <button class="" onclick="closeModal('editarSetor')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-edit-setor" class="modal-form">
            <input type="hidden" id="id_setor_edit">
            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nome_setor_edit">Nome:</label>
                    <input type="text" id="nome_setor_edit" placeholder="Ex: Senai da Silva">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="unidade_setor_edit">Unidade:</label>
                        <select id="unidade_setor_edit">
                            <option value="" disabled>Selecione a unidade</option>

                            <?php
                            $buscar = "SELECT * FROM unidade";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idunidade'] . "'>" . $linha['unidade_nome'] . "</option>";
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Editar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Desativar Setor -->
<div class="modal-fundo" id="desativarSetor" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Desativar Setor</h3>
            <button onclick="closeModal('desativarSetor')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer desativar setor?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_setor_desativar">
            <button id="btn-confirmar-desativar-setor" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('desativarSetor')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Ativar Setor -->
<div class="modal-fundo" id="ativarSetor" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Ativar Setor</h3>
            <button onclick="closeModal('ativarSetor')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer ativar este setor?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_setor_ativar">
            <button id="btn-confirmar-ativar-setor" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('ativarSetor')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Adicionar Colaborador -->
<div class="modal-fundo" id="adicaoColaborador" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Registrar Colaborador</h3>
            <button class="" onclick="closeModal('adicaoColaborador')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-cad-colaborador" class="modal-form">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nome_colaborador_cad">Nome:</label>
                    <input type="text" name="nome" id="nome_colaborador_cad" placeholder="Ex: Matheus dos Ateus"
                        required>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="email_colaborador_cad">Email:</label>
                        <input type="email" name="email" id="email_colaborador_cad" placeholder="exemplo@email.com"
                            required>
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="senha_colaborador_cad">Senha:</label>
                        <input type="password" name="senha" id="senha_colaborador_cad" value="senaisp" readonly placeholder="*****">
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="tipo_colaborador_cad">Tipo de Colaborador:</label>
                        <select name="tipo" id="tipo_colaborador_cad">
                            <option value="sem Valor" disabled selected>Selecione o tipo de colaborador</option>
                            <option value="Adm">ADM</option>
                            <option value="Professor">Professor</option>
                            <option value="Colaborador">Coordenador</option>
                            <option value="Manutencao">Manutenção</option>
                        </select>
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="nif_colaborador_cad">NIF:</label>
                        <input type="text" name="nif" id="nif_colaborador_cad" placeholder="10042006SENAI" required>
                    </div>
                </div>
            </div>

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="setor_colaborador_cad">Setor:</label>
                    <select name="setor" id="setor_colaborador_cad" required>
                        <option value="" disabled selected>Selecione um setor</option>
                        <?php
                        $buscar = "SELECT * FROM setor";
                        $resultado = $conn->query($buscar);
                        if ($resultado && $resultado->num_rows > 0) {
                            while ($linha = $resultado->fetch_assoc()) {
                                echo "<option value='" . $linha['idsetor'] . "'>" . $linha['setor_nome'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
                <br>
                <button type="button" class="btn-confirmar-full btn" onclick="showModal('colaboradoresLote')">
                    Cadastrar em Lote <i class="bi bi-plus-lg"></i>
                </button>
            </div>
    </div>
    </form>
</div>

<!-- Adicionar Colaborador em Lote -->
<div class="modal-fundo" id="colaboradoresLote" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Cadastro em Lote - Colaboradores</h3>
            <button class="" onclick="closeModal('colaboradoresLote')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="form-cad-colaborador-lote" class="modal-form">
            <label for="arquivo-colaborador" class="modal-input arquivos-div">
                <div class="input-wrapper" id="arquivos-input-colaborador">
                    <i style="font-size: var(--text-4xl); color: var(--corDestaque)"
                        class="bi bi-cloud-arrow-up-fill"></i>
                    <p class="label-arquivo" id="label-arquivo-colaborador">Arraste ou Pressione o Arquivo.</p>
                    <p>Somente arquivos .csv, .xlsx e .xls</p>
                    <input type="file" name="arquivo" id="arquivo-colaborador" accept=".csv, .xlsx, .xls" multiple>
                </div>
            </label>

            <!-- Área de Preview -->
            <div id="preview-colaborador" class="preview-lote"></div>

            <div class="modal-footer footer-lote">
                <a href="../../_documentos/modelo_colaboradores.csv" download class="btn-modelo">
                    <i class="bi bi-download"></i> Modelo CSV
                </a>
                <button type="submit" class="btn-confirmar-full confirmar">Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Editar Colaborador -->
<div class="modal-fundo" id="editarColaborador" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Colaborador</h3>
            <button class="" onclick="closeModal('editarColaborador')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-edit-colaborador" class="modal-form">
            <input type="hidden" id="id_colaborador_edit">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nome_colaborador_edit">Nome:</label>
                    <input type="text" name="nome" id="nome_colaborador_edit" placeholder="Ex: Matheus dos Ateus"
                        required>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="email_colaborador_edit">Email:</label>
                        <input type="email" name="email" id="email_colaborador_edit" placeholder="exemplo@email.com"
                            required>
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="senha_colaborador_edit">Senha:</label>
                        <input type="password" name="senha" id="senha_colaborador_edit" readonly placeholder="*****">
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="tipo_colaborador_edit">Tipo de Colaborador:</label>
                        <select name="tipo" id="tipo_colaborador_edit">
                            <option value="sem Valor" disabled selected>Selecione o tipo de colaborador</option>
                            <option value="Adm">ADM</option>
                            <option value="Professor">Professor</option>
                            <option value="Colaborador">Coordenador</option>
                            <option value="Manutencao">Manutenção</option>
                        </select>
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="nif_colaborador_edit">NIF:</label>
                        <input type="text" name="nif" id="nif_colaborador_edit" placeholder="10042006SENAI" required>
                    </div>
                </div>
            </div>

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="setor_colaborador_edit">Setor:</label>
                    <select name="setor" id="setor_colaborador_edit" required>
                        <option value="" disabled selected>Selecione um setor</option>
                        <?php
                        $buscar = "SELECT * FROM setor";
                        $resultado = $conn->query($buscar);
                        if ($resultado && $resultado->num_rows > 0) {
                            while ($linha = $resultado->fetch_assoc()) {
                                echo "<option value='" . $linha['idsetor'] . "'>" . $linha['setor_nome'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Editar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
    </div>
    </form>
</div>

<!-- Desativar Colaborador (Renomeado e Ajustado) -->
<div class="modal-fundo" id="desativarColaborador" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Desativar Colaborador</h3>
            <button onclick="closeModal('desativarColaborador')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer desativar este colaborador?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_colaborador_delete">
            <button id="btn-confirmar-deletar-colaborador" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('desativarColaborador')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Ativar Colaborador (NOVO) -->
<div class="modal-fundo" id="ativarColaborador" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Ativar Colaborador</h3>
            <button onclick="closeModal('ativarColaborador')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer ativar este colaborador?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_colaborador_ativar">
            <button id="btn-confirmar-ativar-colaborador" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('ativarColaborador')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>
</div>

<!-- Desativar Colaborador -->
<!-- <div class="modal-fundo" id="desativarColaborador" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Desativar Colaborador</h3>
            <button onclick="closeModal('desativarColaborador')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer desativar colaborador?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="number" name="id_usuario" id="id_usuario" style="display: none;">
            <button onclick="" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('desativarColaborador')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div> -->

<!-- Resetar Senha Colaborador -->
<div class="modal-fundo" id="resetPass" style="display: none;">
    <div class="modal-box" style="width: 450px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Resetar Senha</h3>
            <button onclick="closeModal('resetPass')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer resetar a senha deste usuário para 'senaisp'?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="number" name="id_usuario_reset" id="id_usuario_reset" style="display: none;">
            <button onclick="resetarSenha(document.getElementById('id_usuario_reset').value)"
                class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('resetPass')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Adição Motores -->
<div class="modal-fundo" id="adicaoMotor" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Cadastrar Motor</h3>
            <button class="" onclick="closeModal('adicaoMotor')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form action="../actions/cursos/registrar.php" class="modal-form" method="POST">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="fabricante">Fabricante:</label>
                    <input type="text" name="fabricante" id="fabricante" placeholder="Ex: MWM, HERCULES">
                </div>

                <div class="input-wrapper">
                    <label for="modelo">Modelo:</label>
                    <input type="text" name="modelo" id="modelo">
                </div>


                <div class="input-wrapper">
                    <label for="potencia">Potência:</label>
                    <input type="text" name="potencia" id="potencia">
                </div>

                <div class="input-wrapper">
                    <label for="tensao">Tensão</label>
                    <input type="text" name="tensao" id="tensao">
                </div>

                <div class="input-wrapper">
                    <label for="corrente">Corrente</label>
                    <input type="text" name="corrente" id="corrente">
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edição Motores -->

<div class="modal-fundo" id="editarMotor" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Motor</h3>
            <button class="" onclick="closeModal('editarMotor')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form action="../actions/cursos/registrar.php" class="modal-form" method="POST">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="fabricante">Fabricante:</label>
                    <input type="text" name="fabricante" id="fabricante" placeholder="Ex: MWM, HERCULES">
                </div>

                <div class="input-wrapper">
                    <label for="modelo">Modelo:</label>
                    <input type="text" name="modelo" id="modelo">
                </div>


                <div class="input-wrapper">
                    <label for="potencia">Potência:</label>
                    <input type="text" name="potencia" id="potencia">
                </div>

                <div class="input-wrapper">
                    <label for="tensao">Tensão</label>
                    <input type="text" name="tensao" id="tensao">
                </div>

                <div class="input-wrapper">
                    <label for="corrente">Corrente</label>
                    <input type="text" name="corrente" id="corrente">
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Finalizar edição <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Deletar Motores -->
<div class="modal-fundo" id="deletarMotor" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Deletar Motor</h3>
            <button onclick="closeModal('deletarMotor')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer deletar motor?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="number" name="id_usuario" id="id_usuario" style="display: none;">
            <button onclick="" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('deletarMotor')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Desativar Motores -->
<div class="modal-fundo" id="desativarMotor" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Desativar Motor</h3>
            <button onclick="closeModal('desativarMotor')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer desativar motor?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="number" name="id_usuario" id="id_usuario" style="display: none;">
            <button onclick="" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('desativarMotor')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Adição Máquina -->
<div class="modal-fundo" id="adicaoMaquina" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Registrar Máquina</h3>
            <button class="" onclick="closeModal('adicaoMaquina')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form action="../actions/maquina/registrar.php" class="modal-form" method="POST">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="tipo">Tipo de Máquina:</label>
                    <select name="tipo" id="tipo">
                        <option value="sem Valor" disabled selected>Selecione o Tipo de Máquina</option>
                        <?php
                        $buscar = "SELECT * FROM tipomaquina";
                        $resultado = $conn->query($buscar);
                        if ($resultado && $resultado->num_rows > 0) {
                            while ($linha = $resultado->fetch_assoc()) {
                                echo "<option value='" . $linha['idtipomaquina'] . "'>" . $linha['tipomaquina_nome'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="intervalo">Intervalo de Manutenção:</label>
                        <select name="intervalo" id="intervalo">
                            <option value="sem Valor" disabled selected>Selecione o intervalo de manutenção</option>
                            <option value="3">3 Meses</option>
                            <option value="6">6 Meses</option>
                            <option value="12">1 Ano (12 Meses)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="setor">Setor:</label>
                        <select name="setor" id="setor">
                            <option value="sem Valor" disabled selected>Selecione um Setor</option>
                            <?php
                            $buscar = "SELECT * FROM setor";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idsetor'] . "'>" . $linha['setor_nome'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="intervalo">Motor:</label>
                        <select name="setor" id="setor">
                            <option value="sem Valor" disabled selected>Selecione um Motor</option>
                            <?php
                            $buscar = "SELECT * FROM motor";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idmotor'] . "'>" . $linha['motor_nome'] . $linha['motor_fabricante'] . " - " . $linha['motor_modelo'] . " - " . $linha['motor_potencia'] . " - " . $linha['motor_tensão'] . " - " . $linha['motor_corrente'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="ni">NI:</label>
                        <input type="text" name="ni" id="ni" placeholder="Ex: N1,N2,N2">
                        <label for="" style="color: var(--corBase); font-size: var(--text-sm)">Separados Por " ,
                            "</label>
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="peso">Peso:</label>
                        <input type="number" name="peso" id="peso" placeholder="Ex: 1KG">
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="fabricante">Fabricante:</label>
                        <input type="text" name="Fabricante" id="Fabricante" placeholder="Ex: ROMI">
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="modelo">Modelo:</label>
                        <input type="text" name="modelo" id="modelo" placeholder="Ex: AN12">
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="intervalo">Ano:</label>
                        <input type="text" name="nome" id="nome" placeholder="Ex: Desenvolvimento de Sistemas">
                    </div>
                </div>
            </div>

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nome">Capacidade:</label>
                    <input type="text" name="nome" id="nome" placeholder="Ex: Desenvolvimento de Sistemas">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Editar Maquina -->
<div class="modal-fundo" id="edicaoMaquina" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Máquina</h3>
            <button class="" onclick="closeModal('edicaoMaquina')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form action="../actions/maquina/registrar.php" class="modal-form" method="POST">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="tipo">Tipo de Máquina:</label>
                    <select name="tipo" id="tipo">
                        <option value="sem Valor" disabled selected>Selecione o Tipo de Máquina</option>
                        <?php
                        $buscar = "SELECT * FROM tipomaquina";
                        $resultado = $conn->query($buscar);
                        if ($resultado && $resultado->num_rows > 0) {
                            while ($linha = $resultado->fetch_assoc()) {
                                echo "<option value='" . $linha['idtipomaquina'] . "'>" . $linha['tipomaquina_nome'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="intervalo">Intervalo de Manutenção:</label>
                        <select name="intervalo" id="intervalo">
                            <option value="sem Valor" disabled selected>Selecione o intervalo de manutenção</option>
                            <option value="3">3 Meses</option>
                            <option value="6">6 Meses</option>
                            <option value="12">1 Ano (12 Meses)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="setor">Setor:</label>
                        <select name="setor" id="setor">
                            <option value="sem Valor" disabled selected>Selecione um Setor</option>
                            <?php
                            $buscar = "SELECT * FROM setor";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idsetor'] . "'>" . $linha['setor_nome'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="intervalo">Motor:</label>
                        <select name="setor" id="setor">
                            <option value="sem Valor" disabled selected>Selecione um Motor</option>
                            <?php
                            $buscar = "SELECT * FROM motor";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idmotor'] . "'>" . $linha['motor_nome'] . $linha['motor_fabricante'] . " - " . $linha['motor_modelo'] . " - " . $linha['motor_potencia'] . " - " . $linha['motor_tensão'] . " - " . $linha['motor_corrente'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="ni">NI:</label>
                        <input type="text" name="ni" id="ni" placeholder="Ex: N1,N2,N2">
                        <label for="" style="color: var(--corBase); font-size: var(--text-sm)">Separados Por " ,
                            "</label>
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="peso">Peso:</label>
                        <input type="number" name="peso" id="peso" placeholder="Ex: 1KG">
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="fabricante">Fabricante:</label>
                        <input type="text" name="Fabricante" id="Fabricante" placeholder="Ex: ROMI">
                    </div>
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="modelo">Modelo:</label>
                        <input type="text" name="modelo" id="modelo" placeholder="Ex: AN12">
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="intervalo">Ano:</label>
                        <input type="text" name="nome" id="nome" placeholder="Ex: Desenvolvimento de Sistemas">
                    </div>
                </div>
            </div>

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nome">Capacidade:</label>
                    <input type="text" name="nome" id="nome" placeholder="Ex: Desenvolvimento de Sistemas">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Deletar Máquina -->
<div class="modal-fundo" id="deletarMaquina" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Deletar Máquina</h3>
            <button onclick="closeModal('deletarMaquina')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer deletar máquina?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="number" name="id_usuario" id="id_usuario" style="display: none;">
            <button onclick="" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('deletarMaquina')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Adicionar Manutenção -->
<div class="modal-fundo" id="adicaoManutencao">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Cadastrar Manutenção</h3>
            <button class="" onclick="closeModal('adicaoManutencao')"><i class="bi bi-x-lg"></i></button>
        </div>
        <form action="../actions/maquina/registrar.php" class="modal-form" method="POST">
            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="pesquisarnimaquina">Pesquisar NI da Máquina:</label>
                        <input type="text" id="tipoMaquinaInput" name="pesquisarnimaquina">
                    </div>
                </div>
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="nimaquina">Selecione a Máquina:</label>
                        <select name="nimaquina" id="nimaquina">
                            <option value="sem Valor" selected disabled>Selecione o NI</option>
                            <?php
                            $buscar = "SELECT * FROM maquina";
                            $resultado = $conn->query($buscar);
                            if ($resultado && $resultado->num_rows > 0) {
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='" . $linha['idmaquina'] . "'>" . $linha['maquina_ni'] . " - " . $linha['maquina_fabricante'] . " - " . $linha['maquina_modelo'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-input">
                    <div class="input-wrapper">
                        <label for="manutencao_prev">Manutenção Preventiva</label>
                        <input type="checkbox" name="manutencao_prev" id="manutencao_prev">
                    </div>
                </div>
                <div class="modal-input">
                    <label for="descricao">Descrição:</label>
                    <div class="input-wrapper">
                        <textarea style="min-height: 180px; max-height: 180px;" name="" id=""
                            placeholder="Descreva com poucas palavras o erro ou dúvida."></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Deletar Manutenção -->
<div class="modal-fundo" id="deletarManutencao" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Deletar Manutenção</h3>
            <button onclick="closeModal('deletarManutencao')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer deletar manutenção?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="number" name="id_usuario" id="id_usuario" style="display: none;">
            <button onclick="" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('deletarManutencao')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Desativar Manutenção -->
<div class="modal-fundo" id="desativarManutencao" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Desativar Manutenção</h3>
            <button onclick="closeModal('desativarManutencao')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer desativar manutenção?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="number" name="id_usuario" id="id_usuario" style="display: none;">
            <button onclick="" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('desativarManutencao')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Adicionar Tipos de Maquinas -->
<div class="modal-fundo" id="adicaoTipoMaquina" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Tipo de Máquina</h3>
            <button class="" onclick="closeModal('adicaoTipoMaquina')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-cad-curso" class="modal-form">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="tipoMaquina">Tipo de Máquina:</label>
                    <input type="text" id="tipoMaquinaInput">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edição de Tipo Máquina -->
<div class="modal-fundo" id="edicaoTipoMaquina" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Tipo de Máquina</h3>
            <button class="" onclick="closeModal('edicaoTipoMaquina')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-cad-curso" class="modal-form">

            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="tipoMaquina">Tipo de máquina:</label>
                    <input type="text" id="tipoMaquinaInput">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Editar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Deletar Máquina -->
<div class="modal-fundo" id="deletarTipoMaquina" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Deletar Tipo Máquina</h3>
            <button onclick="closeModal('deletarTipoMaquina')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer deletar tipo máquina?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="number" name="id_usuario" id="id_usuario" style="display: none;">
            <button onclick="" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('deletarTipoMaquina')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Adicionar Suporte -->
<div class="modal-fundo" id="adicaoSuporte">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Suporte</h3>
            <button class="" onclick="closeModal('adicaoSuporte')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-suporte" class="modal-form" method="" action="">
            <div class="modal-input">
                <label for="colaborador_nome">Colaborador:</label>
                <div class="input-wrapper">
                    <input type="text" id="colaborador_suporte_cad" value="<?php echo $nome_usuario; ?>" disabled>
                    <input type="hidden" id="id_colaborador_suporte_cad" value="<?php echo $id_usuario; ?>">
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-input">
                    <label for="onde">Onde:</label>
                    <div class="input-wrapper">
                        <select name="onde" id="onde">
                            <option value="sem Valor" disabled selected>Selecione em qual parte foi encontrada um erro
                            </option>
                            <option value="Sistema">Login</option>
                            <option value="Maquina">Dashboard</option>
                            <option value="Outros">Cursos</option>
                            <option value="Outros">Turmas</option>
                            <option value="Outros">Alunos</option>
                            <option value="Outros">Unidades</option>
                            <option value="Outros">Setores</option>
                            <option value="Outros">Colaboradores</option>
                            <option value="Outros">Motores</option>
                            <option value="Outros">Máquinas</option>
                            <option value="Outros">Manutenção</option>
                            <option value="Outros">Histórico</option>
                            <option value="Outros">Suporte</option>
                            <option value="Outros">Perfil</option>
                            <option value="Outros">Notificações</option>
                            <option value="Outros">Tema</option>
                            <option value="Outros">Sair</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                </div>
                <div class="modal-input">
                    <label for="tipo">Tipo:</label>
                    <div class="input-wrapper">
                        <select name="tipo" id="" tipo>
                            <option value="sem Valor" disabled selected>Selecione um Tipo</option>
                            <option value="Erro de Sistema">Erro de Sistema</option>
                            <option value="Dúvida">Dúvida</option>
                            <option value="Solicitação de Ajuste">Solicitação de Ajuste</option>
                            <option value="Incidente">Incidente</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-row">
                <div class="modal-input">
                    <label for="urgencia">Urgência:</label>
                    <div class="input-wrapper"
                        style="display: flex; flex-direction: row; justify-content: space-around">
                        <div style="display: flex; gap: 10px; color: var(--corBase); font-size: var(--text-md)">
                            <input type="radio" name="urgencia" id="urgencia" value="Critica"><span>Crítica</span>
                        </div>
                        <div style="display: flex; gap: 10px; color: var(--clipes); font-size: var(--text-md)">
                            <input type="radio" name="urgencia" id="urgencia" value="Alta"><span>Alta</span>
                        </div>
                        <div style="display: flex; gap: 10px; color: var(--editar); font-size: var(--text-md)">
                            <input type="radio" name="urgencia" id="urgencia" value="Media"><span>Média</span>
                        </div>
                        <div style="display: flex; gap: 10px; color: var(--confirmar); font-size: var(--text-md)">
                            <input type="radio" name="urgencia" id="urgencia" value="Baixa"><span>Baixa</span>
                        </div>
                    </div>
                    <span style="color: var(--corBase); margin-top: 10px; padding-left: 10px;">Você consideraria qual
                        nível de urgência para esse erro ou dúvida?</span>
                </div>
            </div>

            <div class="modal-input">
                <label for="descricao">Descrição:</label>
                <div class="input-wrapper">
                    <textarea style="min-height: 180px; max-height: 180px;" name="descricao" id="desc_suporte_cad"
                        placeholder="Descreva com poucas palavras o erro ou dúvida."></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Enviar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Div Notificação -->
<div class="modal-fundo modal-notificacao" id='notificacao-modal' style="display: none">
    <div class="modal-box">
        <div class="modal-header" id="modal-notif"
            style="background: var(--corDestaque); color: var(--txtClaro); padding: 10px; border-radius: 10px 10px 0px 0px;">
            <h3 id="notif-texto" style="color: var(--txtClaro);">Notificações</h3>
            <button style='color: var(--txtClaro);' onclick="closeModal('notificacao-modal')"><i
                    class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-notificacao-corpo">
            <div id="notificacoes-lista" style="height: 500px; overflow: auto;">
                <!-- As notificações serão inseridas aqui dinamicamente -->
                <?php
                $totalNoti = 0;
                $dataAtual = date('Y-m-d');

                $sql = "SELECT 
                            maquina.idmaquina,
                            maquina.maquina_ni,
                            maquina.maquina_modelo,
                            maquina.data_proxima_manutencao,
                            DATEDIFF(maquina.data_proxima_manutencao, '$dataAtual') AS dias,
                            setor.setor_nome
                        FROM maquina
                        INNER JOIN setor
                            ON setor.idsetor = maquina.setor_id
                        WHERE maquina.data_proxima_manutencao IS NOT NULL
                          AND DATEDIFF(maquina.data_proxima_manutencao, '$dataAtual') <= 10
                        ORDER BY maquina.data_proxima_manutencao";

                $resultado = $conn->query($sql);

                if ($resultado && $resultado->num_rows > 0) {
                    while ($linha = $resultado->fetch_assoc()) {
                        $totalNoti++;
                        $dias = (int) $linha['dias'];

                        // Define status
                        if ($dias < 0) {
                            $texto = "Vencida desde " . date('d/m/Y', strtotime($linha['data_proxima_manutencao']));
                            $classe = "notificacao-vencida";
                        } else {
                            $texto = "Manutenção em " . date('d/m/Y', strtotime($linha['data_proxima_manutencao']));
                            $classe = "notificacao-proxima";
                        }
                        echo "
                            <div class='notificacao $classe'>
                                <div>
                                    <h4>Modelo: {$linha['maquina_modelo']}</h4>
                                    <h5>NI: {$linha['maquina_ni']}</h5>
                                    <h5>Setor: {$linha['setor_nome']}</h5>
                                </div>
                                <div>
                                    $texto
                                </div>
                            </div>
                            ";
                    }
                } else {
                    echo "<p style='text-align:center'>Nenhuma manutenção pendente.</p>";
                }
                ?>
            </div>
            <div id="total-notificacoes" style="display:none;">
                <?= $totalNoti ?>
            </div>
        </div>
    </div>
</div>

<div class="modal-fundo" id="sucesso" style="display: none;">
    <div class="modal-box" id="sucesso-box">
        <div class="modal-header">
            <h5 id="sucesso-txt">Sucesso</h5>
            <button style='color: var(--txtClaro); font-size: var(--text-base)' onclick="closeModal('sucesso')"><i
                    class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-row">
            <p id="sucesso-msg" style="font-size: var(--text-sm);">A operação de
                <?php echo $_GET['sucesso'] ?? 'sucesso' ?> foi
                concluida com sucesso.
            </p>
        </div>
    </div>
</div>

<div class="modal-fundo" id="changePassword" style="display: none;">
    <div class="modal-box" style="width: 500px; max-width: 90%;">
        <div class="modal-header">
            <h3>Trocar Senha</h3>
        </div>
        <form id="form-change-password" class="modal-form">
            <div class="modal-row"
                style="margin-bottom: 20px; color: var(--corTxt3); text-align: center; padding: 0 10px;">
                <p style="font-size: var(--text-sm);">Por motivos de segurança, você deve alterar sua senha padrão.</p>
            </div>
            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="nova_senha">Nova Senha:</label>
                    <input type="password" name="nova_senha" id="nova_senha" required placeholder="Nova Senha">
                </div>
            </div>
            <div class="modal-input">
                <div class="input-wrapper">
                    <label for="confirmar_senha">Confirmar Senha:</label>
                    <input type="password" name="confirmar_senha" id="confirmar_senha" required
                        placeholder="Confirme a Senha">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Alterar Senha <i class="bi bi-check-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Adicionar Requisito -->
<div class="modal-fundo" id="adicaoRequisito" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Registrar Requisito</h3>
            <button class="" onclick="closeModal('adicaoRequisito')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-cad-requisito" class="modal-form">
            <div class="modal-input">
                <label for="nome_requisito_cad">Nome:</label>
                <div class="input-wrapper">
                    <input type="text" id="nome_requisito_cad" placeholder="Ex: Botão de Emergência">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <label for="tipo_requisito_cad">Tipo de Requisito:</label>
                    <div class="input-wrapper">
                        <select id="tipo_requisito_cad">
                            <option value="" disabled selected>Selecione o Tipo</option>
                            <option value="Seguranca">Segurança</option>
                            <option value="Operacional">Operacional</option>
                            <option value="Preventivo">Preventivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Cadastrar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Editar Requisito -->
<div class="modal-fundo" id="edicaoRequisito" style="display: none">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar Requisito</h3>
            <button class="" onclick="closeModal('edicaoRequisito')"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="form-edit-requisito" class="modal-form">
            <input type="hidden" id="id_requisito_edit">
            <div class="modal-input">
                <label for="nome_requisito_edit">Nome:</label>
                <div class="input-wrapper">
                    <input type="text" id="nome_requisito_edit" placeholder="Ex: Botão de Emergência">
                </div>
            </div>

            <div class="modal-row">
                <div class="modal-input">
                    <label for="tipo_requisito_edit">Tipo de Requisito:</label>
                    <div class="input-wrapper">
                        <select id="tipo_requisito_edit">
                            <option value="" disabled selected>Selecione o Tipo</option>
                            <option value="Seguranca">Segurança</option>
                            <option value="Operacional">Operacional</option>
                            <option value="Preventivo">Preventivo</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-confirmar-full confirmar">
                    Editar <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Desativar Requisito -->
<div class="modal-fundo" id="deletarRequisito" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Deletar Requisito</h3>
            <button onclick="closeModal('deletarRequisito')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer inativar o requisito?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_requisito_delete">
            <button id="btn-confirmar-deletar-requisito" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('deletarRequisito')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>

<!-- Ativar Requisito -->
<div class="modal-fundo" id="ativarRequisito" style="display: none;">
    <div class="modal-box" style="width: 400px; padding: 20px;">
        <div class="modal-header" style="margin-bottom: 20px;">
            <h3>Ativar Requisito</h3>
            <button onclick="closeModal('ativarRequisito')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div style="text-align: center; margin-bottom: 25px; color: var(--corTxt3);">
            <p>Tem certeza que quer ativar o requisito?</p>
        </div>
        <div style="width: 100%; display: flex; gap: 10px; justify-content: center;">
            <input type="hidden" id="id_requisito_ativar">
            <button id="btn-confirmar-ativar-requisito" class="btn-confirmar-full confirmar">Sim</button>
            <button onclick="closeModal('ativarRequisito')" type="button" class="btn-confirmar-full confirmar"
                style="background-color: var(--corBase);">Não</button>
        </div>
    </div>
</div>