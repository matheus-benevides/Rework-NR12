# Diagrama do Banco de Dados - NR12

Este documento descreve a estrutura do banco de dados `nr12`, incluindo suas tabelas, colunas, tipos de dados e relacionamentos.

## Modelo Entidade-Relacionamento (ER)

```mermaid
erDiagram
    ALUNO {
        int idaluno PK
        varchar aluno_nome
        int aluno_matricula
        int turmas_id FK
        enum aluno_status
    }
    COLABORADOR {
        int idcolaborador PK
        varchar colaborador_nome
        varchar colaborador_nif
        varchar colaborador_email
        varchar senha
        int setor_id FK
        enum colaborador_status
        enum colaborador_permissao
        boolean senha_padrao
    }
    CURSO {
        int idcurso PK
        varchar curso_nome
        enum curso_status
    }
    DEFEITOS {
        int id PK
        text descricao
        int colaborador_id FK
        int aluno_id FK
        int maquina_id FK
        timestamp data_registro
        varchar requisitos_ids
        varchar requisitos_especifico_ids
    }
    HISTORICO {
        int historicoid PK
        int maquina_id FK
        int aluno_id FK
        int colaborador_id FK
        date historico_data
        time historico_hora
        enum historico_status
        int requisito_id FK
        int requisito_especifico_id FK
    }
    MANUTENCAO {
        int idmanutencao PK
        datetime manutencao_data
        int maquina_id FK
        int colaborador_id FK
        enum manutencao_estado
        varchar manutencao_descricao
        enum tipo_manutencao
        datetime manutencao_realizada
        enum manutencao_status
    }
    MAQUINA {
        int idmaquina PK
        int tipomaquina_id FK
        varchar maquina_ni
        int setor_id FK
        enum maquina_status
        varchar maquina_peso
        varchar maquina_fabricante
        varchar maquina_modelo
        varchar maquina_ano
        varchar maquina_capacidade
        int requisitos_id FK
        date data_criacao
        enum intervalo_manutencao
        date data_proxima_manutencao
        int motor_id FK
    }
    MAQUINA_REQUISITOS {
        int idmaquina_requisitos PK
        int maquina_id FK
        text requisitos_especificos
    }
    MOTOR {
        int idmotor PK
        varchar motor_fabricante
        varchar motor_modelo
        varchar motor_potencia
        varchar motor_tensao
        varchar motor_corrente
        enum motor_status
    }
    REQUISITOS {
        int idrequisitos PK
        varchar requisito_topico
        enum tipo_req
        enum requisitos_status
    }
    SETOR {
        int idsetor PK
        varchar setor_nome
        int unidade_id FK
        enum setor_status
    }
    SOLICITACAO_ERRO {
        int idsolicitacao_erro PK
        int id_colaborador FK
        datetime data_solicitacao
        varchar desc_erro
        enum situacao
        datetime data_solucao
    }
    TIPOMAQUINA {
        int idtipomaquina PK
        varchar tipomaquina_nome
        enum tipomaquina_status
        varchar tipomaquina_arquivo
    }
    TIPOMAQUINA_REQUISITO {
        int idtipomaquinarequisito PK
        int tipomaquina_id FK
        int requisitos_id FK
    }
    TURMAS {
        int idturmas PK
        varchar turma_nome
        enum turma_periodo
        date turma_inicio
        date turma_fim
        varchar turma_curso
        int curso_id FK
        enum turmas_status
        int colaborador_id FK
    }
    UNIDADE {
        int idunidade PK
        varchar unidade_nome
        varchar unidade_cidade
        varchar unidade_estado
        int unidade_numero
        enum unidade_status
    }

    TURMAS ||--o{ ALUNO : "contém"
    SETOR ||--o{ COLABORADOR : "pertence"
    SETOR ||--o{ MAQUINA : "contém"
    UNIDADE ||--o{ SETOR : "contém"
    CURSO ||--o{ TURMAS : "vinculada"
    COLABORADOR ||--o{ TURMAS : "responsável"
    COLABORADOR ||--o{ DEFEITOS : "registra"
    ALUNO ||--o{ DEFEITOS : "causa"
    MAQUINA ||--o{ DEFEITOS : "possui"
    MAQUINA ||--o{ HISTORICO : "registro"
    ALUNO ||--o{ HISTORICO : "opera"
    COLABORADOR ||--o{ HISTORICO : "supervisiona"
    REQUISITOS ||--o{ HISTORICO : "verificado"
    MAQUINA ||--o{ MANUTENCAO : "sofre"
    COLABORADOR ||--o{ MANUTENCAO : "realiza"
    TIPOMAQUINA ||--o{ MAQUINA : "define"
    MOTOR ||--o{ MAQUINA : "equipado"
    MAQUINA ||--o{ MAQUINA_REQUISITOS : "possui"
    TIPOMAQUINA ||--o{ TIPOMAQUINA_REQUISITO : "vinculado"
    REQUISITOS ||--o{ TIPOMAQUINA_REQUISITO : "vinculado"
    COLABORADOR ||--o{ SOLICITACAO_ERRO : "abre"
```

## Tabelas e Detalhes

### `aluno`
Armazena informações dos alunos matriculados nas turmas.

| Coluna | Tipo | Descrição |
|---|---|---|
| `idaluno` | int (PK) | Identificador único do aluno |
| `aluno_nome` | varchar(80) | Nome completo do aluno |
| `aluno_matricula` | int(9) | Número da matrícula |
| `turmas_id` | int (FK) | Referência à tabela `turmas` |
| `aluno_status` | enum | Ativo ou Inativo |

### `colaborador`
Armazena informações dos funcionários (Adm, Professores, Coordenadores).

| Coluna | Tipo | Descrição |
|---|---|---|
| `idcolaborador` | int (PK) | Identificador único do colaborador |
| `colaborador_nome` | varchar(99) | Nome do colaborador |
| `colaborador_nif` | varchar(15) | NIF do colaborador |
| `colaborador_email` | varchar(100) | E-mail corporativo |
| `senha` | varchar(255) | Senha criptografada (Argon2) |
| `setor_id` | int (FK) | Referência à tabela `setor` |
| `colaborador_status` | enum | Ativo ou Inativo |
| `colaborador_permissao` | enum | Adm, Coordenador, Manutencao, Professor |
| `senha_padrao` | tinyint(1) | Flag para troca de senha obrigatória |

### `maquina`
Armazena informações detalhadas de cada máquina.

| Coluna | Tipo | Descrição |
|---|---|---|
| `idmaquina` | int (PK) | Identificador único da máquina |
| `tipomaquina_id` | int (FK) | Referência à tabela `tipomaquina` |
| `maquina_ni` | varchar(20) | Número de Inventário |
| `setor_id` | int (FK) | Referência à tabela `setor` |
| `maquina_status` | enum | Ativo ou Inativo |
| `maquina_peso` | varchar(255) | Peso da máquina |
| `maquina_fabricante` | varchar(50) | Fabricante |
| `maquina_modelo` | varchar(65) | Modelo |
| `maquina_ano` | varchar(4) | Ano de fabricação |
| `maquina_capacidade` | varchar(120) | Capacidade operacional |
| `requisitos_id` | int (FK) | Referência à tabela `requisitos` |
| `data_criacao` | date | Data de cadastro no sistema |
| `intervalo_manutencao` | enum | Frequência (3, 6, 12 meses) |
| `data_proxima_manutencao` | date | Próxima data prevista de manutenção |
| `motor_id` | int (FK) | Referência à tabela `motor` |

### `historico`
Registro de checagem e uso das máquinas.

| Coluna | Tipo | Descrição |
|---|---|---|
| `historicoid` | int (PK) | Identificador único |
| `maquina_id` | int (FK) | Máquina utilizada |
| `aluno_id` | int (FK) | Aluno que operou |
| `colaborador_id` | int (FK) | Professor presente |
| `historico_data` | date | Data da operação |
| `historico_hora` | time | Hora da operação |
| `historico_status` | enum | Checado ou Não checado |
| `requisito_id` | int (FK) | Requisito geral verificado |
| `requisito_especifico_id` | int (FK) | Requisito específico verificado |

### `manutencao`
Controle de manutenções preventivas e corretivas.

| Coluna | Tipo | Descrição |
|---|---|---|
| `idmanutencao` | int (PK) | Identificador único |
| `manutencao_data` | datetime | Data da solicitação |
| `maquina_id` | int (FK) | Máquina em manutenção |
| `colaborador_id` | int (FK) | Responsável pela manutenção |
| `manutencao_estado` | enum | Quebrado ou Consertado |
| `manutencao_descricao` | varchar(150) | Observações |
| `tipo_manutencao` | enum | Preventiva ou Corretiva |
| `manutencao_realizada` | datetime | Data da execução |
| `manutencao_status` | enum | Ativo ou Inativo |

### `requisitos`
Checklist de segurança e operação.

| Coluna | Tipo | Descrição |
|---|---|---|
| `idrequisitos` | int (PK) | Identificador único |
| `requisito_topico` | varchar(255) | Descrição do item de segurança |
| `tipo_req` | enum | Seguranca, Operacional, Preventivo |
| `requisitos_status` | enum | Ativo ou Inativo |

### `turmas`
Definição dos grupos de alunos.

| Coluna | Tipo | Descrição |
|---|---|---|
| `idturmas` | int (PK) | Identificador único |
| `turma_nome` | varchar(120) | Nome/Sigla da turma |
| `turma_periodo` | enum | Manhã, Tarde, Noite, Integral |
| `turma_inicio` | date | Início do curso |
| `turma_fim` | date | Término do curso |
| `curso_id` | int (FK) | Referência à tabela `curso` |
| `turmas_status` | enum | Ativo ou Inativo |
| `colaborador_id` | int (FK) | Professor responsável |

### `setor`
Divisões físicas da oficina.

| Coluna | Tipo | Descrição |
|---|---|---|
| `idsetor` | int (PK) | Identificador único |
| `setor_nome` | varchar(110) | Nome do setor (ex: Mecânica, Solda) |
| `unidade_id` | int (FK) | Unidade SENAI |
| `setor_status` | enum | Ativo ou Inativo |

---
*Gerado por Antigravity em 01/04/2026*
