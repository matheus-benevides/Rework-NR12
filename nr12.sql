CREATE DATABASE IF NOT EXISTS nr12;
USE nr12;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `nr12`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--


CREATE TABLE `aluno` (
  `idaluno` int(11) NOT NULL,
  `aluno_nome` varchar(80) NOT NULL,
  `aluno_matricula` int(9) NOT NULL,
  `turmas_id` int(11) NOT NULL,
  `aluno_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`idaluno`, `aluno_nome`, `aluno_matricula`, `turmas_id`, `aluno_status`) VALUES
(330, 'GABRIEL HENRIQUE NUNES RODRIGUES', 23222887, 30, 'Ativo'),
(331, 'YSIS AGNES JUSTINO ACIOLI', 23222888, 30, 'Ativo'),
(332, 'ISABELLA VIEIRA NATAL DE MEIRA', 23222890, 30, 'Ativo'),
(333, 'HEITOR COUTINHO SIMÕES', 23222891, 30, 'Ativo'),
(334, 'ELIS REGINA APARECIDA RIBEIRO', 23222892, 30, 'Ativo'),
(335, 'KAUÃ MAYKON OLIVEIRA DOS SANTOS', 23222893, 30, 'Ativo'),
(336, 'MATHEUS BARBOSA DE ALMEIDA', 23222895, 30, 'Ativo'),
(337, 'HEITOR TEIXEIRA LARIDONDO BARBIZANI', 23222896, 30, 'Ativo'),
(338, 'ANA JULIA MAGRI LUIZ', 23222897, 30, 'Ativo'),
(339, 'BRUNO RANGEL AMADO CRUZ', 23222898, 30, 'Ativo'),
(340, 'ISAC DA SILVA SANTOS', 23222900, 30, 'Ativo'),
(341, 'EMYLLY CRISTINA MACHADO MATOS', 23222903, 30, 'Ativo'),
(342, 'LEANDRO EMANUEL DA SILVA OLIVEIRA', 23222904, 30, 'Ativo'),
(343, 'EDUARDA LOPES DE JESUS', 23222905, 30, 'Ativo'),
(344, 'LEY ALBERTO BRUNAZI', 23222906, 30, 'Ativo'),
(345, 'MARIA EDUARDA BARBOSA DA SILVA', 23222908, 30, 'Ativo'),
(346, 'GABRIEL DA SILVA SAMPAIO', 23222910, 30, 'Ativo'),
(347, 'JOSE LEANDRO SALVIONI ESPINDOLA', 23222912, 30, 'Ativo'),
(348, 'MARIA CLARA BEZZERRA ZANELATO', 23222918, 30, 'Ativo'),
(349, 'YASMIN VITÓRIA ROCHA CAMPOS', 23222920, 30, 'Ativo'),
(350, 'SILAS CAUÃ MOURA FIGUEREDO', 23222949, 30, 'Ativo'),
(351, 'DANIEL VICTOR BERNARDES LARIOS', 23222950, 30, 'Ativo'),
(352, 'DANIEL DE SOUZA SANTOS', 23222953, 30, 'Ativo'),
(353, 'JHENIFER RAFAELA SANTOS', 23222963, 30, 'Ativo'),
(354, 'GLEICY KELLY DE SOUZA', 23222964, 30, 'Ativo'),
(355, 'MARIA EDUARDA DE AGUIAR', 23222965, 30, 'Ativo'),
(356, 'JONATHA WALLESSON FERREIRA DE ANDRADE SILVA', 23222967, 30, 'Ativo'),
(357, 'DANITIELLE SOLDATI GILIOLE FERRARI', 24125714, 29, 'Ativo'),
(358, 'EDSON GIANEZE CAMPOS', 24125717, 29, 'Ativo'),
(359, 'CAIO FELIPE DELLA ROVERE DE SOUZA', 24125734, 29, 'Ativo'),
(360, 'MARIA EDUARDA DE LIMA', 24125736, 29, 'Ativo'),
(361, 'YASMIM VITORIA MENDES SERRA', 24125738, 29, 'Ativo'),
(362, 'MARIA CLAUDJANE DA SILVA', 24125742, 29, 'Ativo'),
(363, 'CARLA LAUANDRA SOUSA DA SILVA', 24125744, 29, 'Ativo'),
(364, 'JACIARA BARROS SÁ', 24125746, 29, 'Ativo'),
(365, 'ROBSON GABRIEL DA SILVA SANTOS MOURA', 24125748, 29, 'Ativo'),
(366, 'CAMILA MARIA CHAGAS DA SILVA', 24125750, 29, 'Ativo'),
(367, 'ANDRÉ BARBOSA DE PAULA FERREIRA', 24125752, 33, 'Ativo'),
(368, 'CALLISTER MURIAN NASCIMENTO BRIZIO', 24125754, 29, 'Ativo'),
(369, 'LUAN HENRIQUE FERREIRA', 24125756, 29, 'Ativo'),
(370, 'NICOLAS OLIVEIRA DA SILVA', 24125758, 33, 'Ativo'),
(371, 'KHAUÊ FRANCISCO DA SILVA BATISTA', 24125760, 29, 'Ativo'),
(372, 'HUGO ALVES FONSECA', 24125786, 33, 'Ativo'),
(373, 'MARYA DE LOURDES RIBEIRO QUEIROZ', 24125788, 33, 'Ativo'),
(374, 'YASMIN CAMILA DE SOUZA', 24125793, 33, 'Ativo'),
(375, 'LIVIA MARIANE SOARES BENICIO', 24125803, 29, 'Ativo'),
(376, 'WEMILLY MONIQUE DE AZEVEDO CARVALHO', 24125805, 29, 'Ativo'),
(377, 'JOSIVALDO ALVES PEREIRA JUNIOR', 24125809, 33, 'Ativo'),
(378, 'JOSÉ VÍTOR MACHADO YANES', 24125819, 33, 'Ativo'),
(379, 'DEYBERTH MIGUEL RODRIGUEZ FLORES', 24125825, 33, 'Ativo'),
(380, 'MARIA JOSE SILVA FELIX', 24125827, 29, 'Ativo'),
(381, 'KEVEN THIERRY DA SILVA VIEIRA', 24125832, 29, 'Ativo'),
(382, 'CHRISTIAN PEREIRA OLIVEIRA RODRIGUES', 24125834, 33, 'Ativo'),
(383, 'TALIS TRAUSI DUARTE GOMES', 24125836, 33, 'Ativo'),
(384, 'KAIQUE FERNANDES ARROIO', 24125838, 33, 'Ativo'),
(385, 'JOÃO PEDRO SIQUEIRA DO CARMO', 24125840, 33, 'Ativo'),
(386, 'IZABELLY FERREIRA BALORONE', 24125842, 33, 'Ativo'),
(387, 'ALLANA DE SOUZA MARQUES', 24125846, 33, 'Ativo'),
(388, 'KAUÃ BERNARDO DA SILVA', 24125848, 33, 'Ativo'),
(389, 'VITÓRIA GONÇALVES DOS SANTOS', 24125850, 33, 'Ativo'),
(390, 'JOSE HENRIQUE MOURA VASCONCELOS', 24125852, 33, 'Ativo'),
(391, 'VICTOR GABRIEL SECATO', 24125897, 33, 'Ativo'),
(392, 'GABRYEL EDUARDO FERREIRA MOREIRA', 24125938, 33, 'Ativo'),
(393, 'ANNA LAURA SILVA BONFIM', 24125940, 33, 'Ativo'),
(394, 'LARA LETICIA SOARES BENÍCIO', 24125942, 29, 'Ativo'),
(395, 'IZABELLI XAVIER SPERANDIO', 24125963, 33, 'Ativo'),
(396, 'YURI RAMELLO PASSOS', 24125974, 33, 'Ativo'),
(397, 'NADYLA VICTORIA MORAIS ROCHA', 24125984, 33, 'Ativo'),
(398, 'RYAN VIEIRA SOUZA', 24126049, 33, 'Ativo'),
(399, 'GABRIELA DE OLIVEIRA MARIA', 24126051, 33, 'Ativo'),
(400, 'BEATRIZ SOUZA DE OLIVEIRA', 24126075, 33, 'Ativo'),
(401, 'SAYMON PINHEIRO SANTOS', 24126110, 33, 'Ativo'),
(402, 'RICHARD DA COSTA SANTOS', 24126598, 28, 'Ativo'),
(403, 'BRENO HENRIQUE ALMEIDA', 24126600, 28, 'Ativo'),
(404, 'EDUARDA NOVELLI PANSANI', 24126602, 28, 'Ativo'),
(405, 'EMILY DOS SANTOS CARVALHO', 24126605, 28, 'Ativo'),
(406, 'FERNANDA RODRIGUES RIBEIRO DE BARROS', 24126607, 28, 'Ativo'),
(407, 'KETHILLYN EDUARDA DOS SANTOS ANJOS', 24126609, 28, 'Ativo'),
(408, 'OSMINDO ANTONIO TERCEIRO RAMALHO FIGUEIREDO', 24126611, 28, 'Ativo'),
(409, 'AMANDA BALBINO SCHWEBEL', 24126621, 28, 'Ativo'),
(410, 'ARTHUR SANTANA BASSO', 24126623, 28, 'Ativo'),
(411, 'ROBERTA CRISTINA PEREIRA DA SILVA', 24126625, 28, 'Ativo'),
(412, 'JULIA TEODORO OTAVIO BICHOFI', 24126647, 28, 'Ativo'),
(413, 'Kaio Henrique Santana de Freitas', 24126649, 28, 'Ativo'),
(414, 'LAURA DE OLIVEIRA DOMINGUES', 24126651, 28, 'Ativo'),
(415, 'VICTOR CATANOSSI OLIVEIRA', 24126653, 28, 'Ativo'),
(416, 'HENRIQUE POZZETTI GOUVEA', 24126655, 28, 'Ativo'),
(417, 'KADU FERNANDES DE OLIVEIRA', 24126765, 28, 'Ativo'),
(418, 'ALEXANDRE BERGAMINI PARANHOS', 24126834, 33, 'Ativo'),
(419, 'JOAO PEDRO ALVES DE SOUZA', 24126851, 28, 'Ativo'),
(420, 'HEITOR GABRIEL DOMINGUES RIBEIRO', 24126900, 28, 'Ativo'),
(421, 'CHRISLAN WESLLEN BALBINO DA SILVA', 24225580, 35, 'Ativo'),
(422, 'MARIANE CARVALHO DOS SANTOS', 24225586, 36, 'Ativo'),
(423, 'AYLA FERNANDA DOS SANTOS CARVALHO', 24225588, 26, 'Ativo'),
(424, 'RAFAELA BOCCHI DE SOUZA', 24225592, 35, 'Ativo'),
(425, 'JAQUELINE CARVALHO FONTOURA', 24225594, 36, 'Ativo'),
(426, 'NICKOL ALEJANDRA INCERRI URBINA', 24225605, 34, 'Ativo'),
(427, 'FELIPE VENANCIO DE ANDRADE', 24225607, 34, 'Ativo'),
(428, 'JOAO VITOR DE OLIVEIRA PEREIRA NEY', 24225609, 34, 'Ativo'),
(429, 'EMANUELY DOS  SANTOS MORALES', 24225611, 34, 'Ativo'),
(430, 'LUICK NASCIMENTO', 24225616, 26, 'Ativo'),
(431, 'KAUÃ PACHECO ALVES', 24225618, 26, 'Ativo'),
(432, 'FLAVIO RICARDO DE AMORIM JUNIOR', 24225620, 26, 'Ativo'),
(433, 'KAIQUE VINICIUS CORREA FAUSTINO', 24225626, 26, 'Ativo'),
(434, 'GUILHERME EVANGELISTA MORCELE DE OLIVEIRA', 24225628, 34, 'Ativo'),
(435, 'JOVANA DE MATOS PENHA', 24225630, 34, 'Ativo'),
(436, 'LADSON VITOR MARQUES DOS SANTOS', 24225632, 34, 'Ativo'),
(437, 'CHIARA  APARECIDA GOMES GERMANO', 24225643, 34, 'Ativo'),
(438, 'ASHLEY PEREIRA BALEEIRO MARTINS', 24225646, 35, 'Ativo'),
(439, 'DYOGO OLIVEIRA MARTINS', 24225648, 35, 'Ativo'),
(440, 'DANIELLE OLIVEIRA DOS SANTOS', 24225650, 36, 'Ativo'),
(441, 'THAYLAINE LUNARA SANTIAGO DOS SANTOS', 24225653, 26, 'Ativo'),
(442, 'VICTOR ALEXANDRE SANTANA QUEIROZ', 24225655, 36, 'Ativo'),
(443, 'JÚLIA RODRIGUES DE ALMEIDA', 24225657, 37, 'Ativo'),
(444, 'JENIFER GABRIELY GUTIERRES ZOAIS', 24225659, 37, 'Ativo'),
(445, 'RIAN NUNES GONÇALVES', 24225661, 37, 'Ativo'),
(446, 'VITORIA RAMALHO DA SILVA', 24225663, 37, 'Ativo'),
(447, 'LUCAS DAVI DE JESUS', 24225665, 37, 'Ativo'),
(448, 'LUIS HENRIQUE MIANE DOS SANTOS', 24225667, 37, 'Ativo'),
(449, 'YURIZAM ANNE MARQUES DA SILVA HERRERA', 24225669, 37, 'Ativo'),
(450, 'KAUANY PEREIRA DA SILVA', 24225671, 37, 'Ativo'),
(451, 'YASMIN CHAIANY DOS SANTOS PIERINI', 24225673, 37, 'Ativo'),
(452, 'DANIELA CRISTINA DE ALMEIDA', 24225675, 37, 'Ativo'),
(453, 'LERONY DE ARAÚJO CARDOSO', 24225677, 37, 'Ativo'),
(454, 'AMANDA SANTOS OLIVEIRA', 24225682, 32, 'Ativo'),
(455, 'GUSTAVO TAVARES ALVES', 24225684, 32, 'Ativo'),
(456, 'THIAGO MICHEL PARRA', 24225686, 32, 'Ativo'),
(457, 'ANAÊ VIEIRA SCIENCIA', 24225688, 32, 'Ativo'),
(458, 'MARIA RITA SANTOS SOARES', 24225690, 32, 'Ativo'),
(459, 'ANNA VITÓRIA JORGE DA SILVA', 24225692, 32, 'Ativo'),
(460, 'DAVI DA SILVA SOUZA', 24225694, 34, 'Ativo'),
(461, 'LAISLA DA COSTA PIRES', 24225698, 26, 'Ativo'),
(462, 'LUIZ GUSTAVO MOREIRA DOS SANTOS', 24225700, 26, 'Ativo'),
(463, 'ROBERTA MARIANA DA SILVA', 24225702, 27, 'Ativo'),
(464, 'LORENA RODRIGUES FANTINI', 24225704, 37, 'Ativo'),
(465, 'MARIA LUISA OLIVEIRA REIS', 24225706, 35, 'Ativo'),
(466, 'GABRIEL MUNHOZ PEREIRA', 24225715, 37, 'Ativo'),
(467, 'BEATRIZ BERIGO MARINHO LUCIO', 24225727, 27, 'Ativo'),
(468, 'CLARA MOLINA', 24225729, 37, 'Ativo'),
(469, 'GABRIEL GASQUES BARBOZA', 24225731, 38, 'Ativo'),
(470, 'MURIELLE DA SILVA INACIO', 24225733, 38, 'Ativo'),
(471, 'CINARA MOTA SANTOS', 24225735, 38, 'Ativo'),
(472, 'STEPHANIE RAYANE DE ALMEIDA NATAL', 24225737, 37, 'Ativo'),
(473, 'PEDRO HENRIQUE DA SILVA DE CAMPOS', 24225748, 31, 'Ativo'),
(474, 'HALERRANDRO HENRICKY CUBO CORREIA', 24225750, 31, 'Ativo'),
(475, 'WEVERTON FREIRE', 24225752, 37, 'Ativo'),
(476, 'DANIEL ALVES ROCHA', 24225754, 38, 'Ativo'),
(477, 'GUILHERME MORAES NOVAIS', 24225756, 38, 'Ativo'),
(478, 'LETÍCIA GOMES FAGUNDES', 24225758, 27, 'Ativo'),
(479, 'CLAUDIA ORRANA BENEVENTE', 24225760, 27, 'Ativo'),
(480, 'SIDNEY ANTAS DE LACERDA', 24225762, 31, 'Ativo'),
(481, 'TAYANE DOS SANTOS SILVA', 24225764, 36, 'Ativo'),
(482, 'FELIPE NUNIS DE LIMA', 24225766, 35, 'Ativo'),
(483, 'VITOR DE SOUSA SANTOS', 24225768, 36, 'Ativo'),
(484, 'LEONARDO GABRIEL GARCIA CAMARGO', 24225770, 35, 'Ativo'),
(485, 'LUIZ ARMANDO VIEIRA DA SILVA', 24225772, 36, 'Ativo'),
(486, 'MIRELLA DE SOUZA MARTINS', 24225774, 35, 'Ativo'),
(487, 'KAILAINE DOS SANTOS MOTA', 24225776, 35, 'Ativo'),
(488, 'YASMIN MORILLA NOSSAS', 24225778, 36, 'Ativo'),
(489, 'GABRIELY TONINATTO LOPES DE OLIVEIRA', 24225780, 36, 'Ativo'),
(490, 'THAUANY VITÓRIA SANTIAGO PENQUIS', 24225800, 35, 'Ativo'),
(491, 'JOÃO GABRIEL DE FREITAS GARCIA VELOSO', 24225822, 27, 'Ativo'),
(492, 'MARIA CLARA ESTEVAO DA SILVA', 24225837, 34, 'Ativo'),
(493, 'VITORIA ROBERTO DOS SANTOS', 24225839, 34, 'Ativo'),
(494, 'ANDRÉ COLUZI DOS SANTOS', 24225841, 31, 'Ativo'),
(495, 'DAVI LUCAS DE SOUZA', 24225843, 31, 'Ativo'),
(496, 'LUIS FERNANDO DO SANTOS DUARTE', 24225845, 31, 'Ativo'),
(497, 'MATEUS EDUARDO DA SILVA SOUSA', 24225855, 27, 'Ativo'),
(498, 'ALVARO AUGUSTO CAMACHO', 24225857, 34, 'Ativo'),
(499, 'MAYARA DOS SANTOS SILVA', 24225859, 37, 'Ativo'),
(500, 'HENTHONY FAEL SALVIANO DOS SANTOS', 24225863, 32, 'Ativo'),
(501, 'ISADORA VILELA FACETO', 24225865, 32, 'Ativo'),
(502, 'HELOA VITORIA NOGUEIRA DOS SANTOS', 24225880, 31, 'Ativo'),
(503, 'MATHEUS FERREIRA DA SILVA', 24225882, 27, 'Ativo'),
(504, 'THALYA VILELA DA SILVA', 24225884, 38, 'Ativo'),
(505, 'LUIS AUGUSTO GAVERIO DA SILVA', 24225886, 38, 'Ativo'),
(506, 'GRACIELY RIBEIRO SOEIRO', 24225888, 38, 'Ativo'),
(507, 'LEONARDO FERREIRA MISSIAGIA', 24225890, 38, 'Ativo'),
(508, 'MATHEUS HENRIQUE DA SILVA AMARIO', 24225892, 38, 'Ativo'),
(509, 'KAREN BATISTA DOS SANTOS', 24225894, 34, 'Ativo'),
(510, 'MURILO DA SILVA SALLES', 24225897, 36, 'Ativo'),
(511, 'ITALLO GABRIEL PADILHA VIEIRA', 24225899, 35, 'Ativo'),
(512, 'HEITOR PESTANA TAVARES', 24225901, 35, 'Ativo'),
(513, 'VITOR ASSOLINI COSTA', 24225903, 36, 'Ativo'),
(514, 'CHRISLAYNE CRISTINA BALBINO DA SILVA', 24225905, 35, 'Ativo'),
(515, 'JHONNY VICENTE FREIRE', 24225907, 35, 'Ativo'),
(516, 'WEMILLY THISFFANY EMILIANO BARROS SILVA', 24225909, 38, 'Ativo'),
(517, 'MARIA EDUARDA DO NASCIMENTO RODRIGUES', 24225917, 36, 'Ativo'),
(518, 'RYCHARD MANTOVANI COSTA', 24225919, 32, 'Ativo'),
(519, 'KAUAN MENDES SILVA', 24225921, 32, 'Ativo'),
(520, 'GIULLIANO PATRICK RINALDI GARCIA', 24225923, 32, 'Ativo'),
(521, 'THAIANI LOPES DE OLIVEIRA', 24225926, 37, 'Ativo'),
(522, 'ARTUR PEREIRA RUIZ', 24225928, 38, 'Ativo'),
(523, 'JULIA NASCIMENTO LEITE', 24225931, 36, 'Ativo'),
(524, 'WELLINGTON SAMUEL SANTOS LIMA', 24225933, 38, 'Ativo'),
(525, 'EMANOELLE DOMINGUES DA SILVA', 24225935, 38, 'Ativo'),
(526, 'LAURA GONÇALVES TIM', 24225937, 27, 'Ativo'),
(527, 'KAILANY DE PAULA SILVA', 24225942, 38, 'Ativo'),
(528, 'LEONARDO AZEVEDO LOPES', 24225944, 32, 'Ativo'),
(529, 'KEVELYN PAVAN DE SOUSA', 24225946, 31, 'Ativo'),
(530, 'ISABELLA DEL MOURO BELAI RIBEIRO', 24225948, 32, 'Ativo'),
(531, 'DAVI SANTOS CONCEIÇÃO', 24225950, 32, 'Ativo'),
(532, 'YAGO CHARLES RAMALHO NUNES', 24225953, 35, 'Ativo'),
(533, 'PEDRO AUGUSTO DOS SANTOS', 24225955, 35, 'Ativo'),
(534, 'JOÃO GABRIEL FARIA DE LIMA SILVA', 24225958, 35, 'Ativo'),
(535, 'GUSTAVO DAMIÃO FERREIRA', 24225960, 31, 'Ativo'),
(536, 'GUSTAVO VILELA DA SILVA', 24225962, 31, 'Ativo'),
(537, 'LUIS FERNANDO BAIO BARBOSA', 24225968, 32, 'Ativo'),
(538, 'ANA BEATRIZ DE MACENO FERREIRA', 24225970, 32, 'Ativo'),
(539, 'MARIA TEREZA DOS SANTOS E SILVA', 24225972, 31, 'Ativo'),
(540, 'ISADORA DA CRUZ VIANA', 24225974, 31, 'Ativo'),
(541, 'THALES AUGUSTO DE ALMEIDA BRONZATI', 24225978, 38, 'Ativo'),
(542, 'DANIEL MIRANDA GONÇALVES', 24225980, 31, 'Ativo'),
(543, 'MATHEUS DA SILVA OLIVEIRA MARQUES', 24225982, 34, 'Ativo'),
(544, 'LAURA BEATRIZ VICENTE ARAUJO', 24225984, 38, 'Ativo'),
(545, 'MEG STEYCEE RIBEIRO GARCIA', 24225986, 32, 'Ativo'),
(546, 'MARCO ANTONIO BUCALON', 24225988, 38, 'Ativo'),
(547, 'YASMIM VITÓRIA FERRARI', 24225997, 31, 'Ativo'),
(548, 'FELIPE ALEX SANTOS DE JESUS', 24226001, 31, 'Ativo'),
(549, 'LEONARDO HENRIQUE FERNANDES DA SILVA', 24226036, 37, 'Ativo'),
(550, 'IZABELLE ANY DOS SANTOS MARIN', 24226038, 34, 'Ativo'),
(551, 'VERONICA ALVES FERREIRA BARBOSA', 24226040, 31, 'Ativo'),
(552, 'CAIO LEONAN FERREIRA CUNHA', 24226042, 32, 'Ativo'),
(553, 'KAMILLY DIAS DO PRADO', 24226058, 36, 'Ativo'),
(554, 'RYAN GABRIEL GOMES DO ESPÍRITO SANTO', 24226063, 34, 'Ativo'),
(555, 'MARIANA NEVES DA CONCEIÇÃO', 24226086, 36, 'Ativo'),
(556, 'GABRIEL JÚNIOR DA SILVA SOUZA', 24226105, 36, 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `colaborador`
--

CREATE TABLE `colaborador` (
  `idcolaborador` int(11) NOT NULL,
  `colaborador_nome` varchar(99) NOT NULL,
  `colaborador_nif` varchar(15) NOT NULL,
  `colaborador_email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `setor_id` int(11) NOT NULL,
  `colaborador_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
  `colaborador_permissao` enum('Adm','Coordenador','Manutencao','Professor') NOT NULL,
  `senha_padrao` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `colaborador`
--

INSERT INTO `colaborador` (`idcolaborador`, `colaborador_nome`, `colaborador_nif`, `colaborador_email`, `senha`, `setor_id`, `colaborador_status`, `colaborador_permissao`, `senha_padrao`) VALUES
(1, 'Roberto', '6532032', 'roberto@email.com', '$argon2id$v=19$m=65536,t=4,p=1$aFhFTi41ZzZSa0cxU085Zw$PzUGWUNc9jehoRpnFAOY5AYB1mY9GQaOSuEC78hMqa8', 3, 'Ativo', 'Adm', 0),
(2, 'Flávio', '2143', 'flavio@email', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Adm', 1),
(4, 'Luiz', '7747', 'luiz@email', '$argon2id$v=19$m=65536,t=4,p=1$Unp5bEtRaDF3VnVFUGwyUw$zStkFiZuhhrA4ZyRqFaAdR5Sz8HpxWZGGM0eKiP71bY', 1, 'Ativo', 'Coordenador', 1),
(5, 'Alexandre', '32142434', 'alexandre@gmail.com', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(6, 'Sergio', '233323', 'sergio@gmail.com', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(40, 'CLAUDEMIR APARECIDO FLORES', '', 'cflores@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Coordenador', 1),
(41, 'ALEXANDRE FELIX DE ARAUJO', '', 'afelix@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(42, 'ALMIR LOTITO LIMA', '', 'almir.lotito@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(43, 'BRUNO ALVES DE SOUZA', '', 'bruno.souza@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(44, 'CLEITON CEZAR MONTEIRO', '', 'cleiton.cezar@sp.senai.br', '$argon2id$v=19$m=65536,t=4,p=1$dTN2RElJL1JXS1o3T1JvSQ$krJtBcwf4zPp6Qn2ImkrlAAH4rMgi3TBUdxwWqnh6fc', 1, 'Ativo', 'Professor', 1),
(45, 'EMANUEL FERNANDES MADRID', '', 'emanuel.madrid@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(46, 'EVERTON LUIZ CERANTULA', '', 'everton.cerantula@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(47, 'GUILHERME BARBOSA DE ALMEIDA', '', 'guilherme.almeida@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(48, 'JERRI FERNANDES DA SILVA', '', 'jerri.silva@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(49, 'LUIZ CARLOS FERREIRA JUNIOR', '', 'luizcarlos.junior@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(50, 'MARCIO DONIZETE GASPAROTO', '', 'marcio.gasparoto@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(51, 'MARCIO GARCIA', '', 'marcio.garcia@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(52, 'SERGIO EDUARDO BRUNASSI', '', 'sergio.brunassi@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(53, 'WELLINGTON GONCALVES NORBERTO', '', 'wellington.norberto@sp.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$ejlXUVEvTG8zazQ4dUl6Nw$vALxm8vL3fK8F+vM0w2CX24J9exmDjkMj2FjTmaAhhc', 1, 'Ativo', 'Professor', 1),
(57, 'Roberto Moraes', '1068806', 'r.junior@sp.senai.br', '$argon2id$v=19$m=65536,t=4,p=1$cHFHbUlSWFpLbmlKRVU5Sg$pwFnGR1AdDq/sUCmbcLSrupgIbs/zKB3m4LQcumcqAw', 1, 'Ativo', 'Coordenador', 0),
(58, 'kaua', '1', 'kaua@email.com', '$argon2id$v=19$m=65536,t=4,p=1$aWI1TU83TkxLd3NoMHVWaQ$GfPtUR/yhX1m0JIwxjM2eKty041blxnet+5Ji0eMx40', 1, 'Ativo', 'Adm', 0),
(59, 'Kaua Vitor Reis', '1227', 'kaua.v.reis6@aluno.senai.br', '$argon2id$v=19$m=65536,t=4,p=1$WkExaUhJRU55cFR2clZ2bg$Gk5iIpGJlF9awsKZ12LtUXUdfxcQwO1rZF/8pidBpgg', 1, 'Ativo', 'Adm', 1),
(60, 'Joao Pedro Rodrigues', '2221', 'joao.p.silva443@aluno.senai.br', '$argon2id$v=19$m=65536,t=4,p=1$MFh3eTFVdDdCVWE3dUppMg$BVgJXfcvU9cAh7oKVU5iIoQSbYGUXgZFGfkOy1/PoSM', 1, 'Ativo', 'Adm', 1),
(61, 'Miguel Casteletti Rosa', '123321', 'miguel.c.rosa6@aluno.senai.br', '$argon2id$v=19$m=65536,t=4,p=1$SGJINkZGbkR6TWlIRWppaQ$Kwh07jFdT7FMPHQCcDq5nfiUkvGYR8FuXdTU7cUvzuY', 2, 'Ativo', 'Adm', 0),
(62, 'Rafael Adriano Oliveira da Silva', '4002892', 'rafael.a.silva64@aluno.senai.br', '$argon2id$v=19$m=131072,t=4,p=2$TTJyY05VRDVuNExhWTRMcA$hW03XQZSVr7PaOv5boWn6lUURaFVPTNICim97lg7mMU', 3, 'Ativo', 'Adm', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso`
--

CREATE TABLE `curso` (
  `idcurso` int(11) NOT NULL,
  `curso_nome` varchar(255) NOT NULL,
  `curso_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `curso`
--

INSERT INTO `curso` (`idcurso`, `curso_nome`, `curso_status`) VALUES
(19, 'Mecânico de Manutenção de Máquinas Agrícolas e Veículos Pesados', 'Ativo'),
(62, 'Mecânico de Usinagem', 'Ativo'),
(67, 'Soldador', 'Ativo'),
(68, 'Técnico em Fabricação Mecânica', 'Ativo'),
(69, 'Mecânico de Manutenção de Máquinas Agrícolas e Veículos Pesados', 'Ativo'),
(70, 'Auxiliar de Mecânico de Veículos Pesados', 'Ativo'),
(71, 'Operador de Máquinas de Usinagem de Madeira Convencionais e a CNC', 'Ativo'),
(72, 'Mecânico de Manutenção de Veículos Pesados Rodoviários', 'Inativo'),
(73, 'Técnico em Soldagem', 'Ativo'),
(74, 'Curso Teste Matheus', 'Ativo'),
(75, 'Miguelandia', 'Inativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `defeitos`
--

CREATE TABLE `defeitos` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `colaborador_id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `maquina_id` int(11) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `requisitos_ids` varchar(255) DEFAULT NULL,
  `requisitos_especifico_ids` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `defeitos`
--

INSERT INTO `defeitos` (`id`, `descricao`, `colaborador_id`, `aluno_id`, `maquina_id`, `data_registro`, `requisitos_ids`, `requisitos_especifico_ids`) VALUES
(11, 'erro', 5, 98, 122, '2024-11-13 10:12:26', '214,215,216,217,218,227,228,264,265,266,267,268', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico`
--

CREATE TABLE `historico` (
  `historicoid` int(11) NOT NULL,
  `maquina_id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `colaborador_id` int(11) NOT NULL,
  `historico_data` date NOT NULL,
  `historico_hora` time NOT NULL,
  `historico_status` enum('Checado','Não checado') DEFAULT NULL,
  `requisito_id` int(11) DEFAULT NULL,
  `requisito_especifico_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `historico`
--

INSERT INTO `historico` (`historicoid`, `maquina_id`, `aluno_id`, `colaborador_id`, `historico_data`, `historico_hora`, `historico_status`, `requisito_id`, `requisito_especifico_id`) VALUES
(691, 108, 330, 5, '2024-11-13', '07:57:21', NULL, 205, NULL),
(692, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 206, NULL),
(693, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 207, NULL),
(694, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 208, NULL),
(695, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 209, NULL),
(696, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 210, NULL),
(697, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 212, NULL),
(698, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 213, NULL),
(699, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 214, NULL),
(700, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 215, NULL),
(701, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 216, NULL),
(702, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 217, NULL),
(703, 108, 150, 5, '2024-11-13', '07:57:21', NULL, 218, NULL),
(704, 96, 150, 5, '2024-11-13', '08:03:11', NULL, 219, NULL),
(705, 96, 150, 5, '2024-11-13', '08:03:11', NULL, 220, NULL),
(706, 96, 150, 5, '2024-11-13', '08:03:11', NULL, 221, NULL),
(707, 96, 150, 5, '2024-11-13', '08:03:11', NULL, 222, NULL),
(708, 96, 150, 5, '2024-11-13', '08:03:11', NULL, 223, NULL),
(709, 96, 150, 5, '2024-11-13', '08:03:11', NULL, 224, NULL),
(710, 96, 150, 5, '2024-11-13', '08:03:11', NULL, 225, NULL),
(711, 96, 150, 5, '2024-11-13', '08:03:11', NULL, 226, NULL),
(712, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 205, NULL),
(713, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 206, NULL),
(714, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 207, NULL),
(715, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 208, NULL),
(716, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 209, NULL),
(717, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 212, NULL),
(718, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 213, NULL),
(719, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 214, NULL),
(720, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 215, NULL),
(721, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 216, NULL),
(722, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 217, NULL),
(723, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 218, NULL),
(724, 129, 98, 5, '2024-11-13', '09:11:49', NULL, 228, NULL),
(725, 96, 150, 5, '2026-11-13', '09:16:08', NULL, 219, NULL),
(726, 96, 150, 5, '2026-11-13', '09:16:08', NULL, 220, NULL),
(727, 96, 150, 5, '2026-11-13', '09:16:08', NULL, 221, NULL),
(728, 96, 150, 5, '2026-11-13', '09:16:08', NULL, 222, NULL),
(729, 96, 150, 5, '2026-11-13', '09:16:08', NULL, 223, NULL),
(730, 96, 150, 5, '2026-11-13', '09:16:08', NULL, 224, NULL),
(731, 96, 150, 5, '2026-11-13', '09:16:08', NULL, 225, NULL),
(732, 96, 150, 5, '2026-11-13', '09:16:08', NULL, 226, NULL),
(733, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 205, NULL),
(734, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 206, NULL),
(735, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 207, NULL),
(736, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 208, NULL),
(737, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 209, NULL),
(738, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 210, NULL),
(739, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 212, NULL),
(740, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 213, NULL),
(741, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 214, NULL),
(742, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 215, NULL),
(743, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 216, NULL),
(744, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 217, NULL),
(745, 104, 331, 5, '2024-12-17', '11:14:46', NULL, 218, NULL),
(746, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 205, NULL),
(747, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 206, NULL),
(748, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 207, NULL),
(749, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 208, NULL),
(750, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 209, NULL),
(751, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 210, NULL),
(752, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 212, NULL),
(753, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 213, NULL),
(754, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 214, NULL),
(755, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 215, NULL),
(756, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 216, NULL),
(757, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 217, NULL),
(758, 104, 331, 5, '2024-12-17', '10:17:38', NULL, 218, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `manutencao`
--

CREATE TABLE `manutencao` (
  `idmanutencao` int(11) NOT NULL,
  `manutencao_data` datetime NOT NULL,
  `maquina_id` int(11) NOT NULL,
  `colaborador_id` int(11) NOT NULL,
  `manutencao_estado` enum('Quebrado','Consertado') NOT NULL,
  `manutencao_descricao` varchar(150) DEFAULT NULL,
  `tipo_manutencao` enum('Preventiva','Corretiva') NOT NULL,
  `manutencao_realizada` datetime NOT NULL,
  `manutencao_status` enum('Ativo','Inativo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `manutencao`
--

INSERT INTO `manutencao` (`idmanutencao`, `manutencao_data`, `maquina_id`, `colaborador_id`, `manutencao_estado`, `manutencao_descricao`, `tipo_manutencao`, `manutencao_realizada`, `manutencao_status`) VALUES
(42, '2024-11-18 08:57:42', 96, 2, 'Quebrado', 'dsfgh', 'Corretiva', '0000-00-00 00:00:00', 'Ativo'),
(43, '2024-11-18 00:00:00', 96, 2, 'Consertado', NULL, 'Preventiva', '2024-11-18 08:57:59', 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `maquina`
--

CREATE TABLE `maquina` (
  `idmaquina` int(11) NOT NULL,
  `tipomaquina_id` int(11) NOT NULL,
  `maquina_ni` varchar(20) NOT NULL,
  `setor_id` int(11) NOT NULL, 
  `maquina_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
  `maquina_peso` varchar(255) DEFAULT NULL,
  `maquina_fabricante` varchar(50) DEFAULT NULL,
  `maquina_modelo` varchar(65) DEFAULT NULL,
  `maquina_ano` varchar(4) DEFAULT NULL,
  `maquina_capacidade` varchar(120) DEFAULT NULL,
  `requisitos_id` int(11) DEFAULT NULL,
  `data_criacao` date DEFAULT NULL,
  `intervalo_manutencao` enum('3','6','12') DEFAULT NULL,
  `data_proxima_manutencao` date DEFAULT NULL,
  `motor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `maquina`
--

INSERT INTO `maquina` (`idmaquina`, `tipomaquina_id`, `maquina_ni`, `setor_id`, `maquina_status`, `maquina_peso`, `maquina_fabricante`, `maquina_modelo`, `maquina_ano`, `maquina_capacidade`, `requisitos_id`, `data_criacao`, `intervalo_manutencao`, `data_proxima_manutencao`, `motor_id`) VALUES
(96, 40, '1052694', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(97, 40, '1052695', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(98, 40, '1052696', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(99, 40, '1052697', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(100, 40, '1052698', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(101, 40, '1052699', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(102, 40, '1052700', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(103, 40, '1052701', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(104, 40, '1052702', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(105, 40, '1052703', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(106, 40, '1052704', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(107, 40, '1052705', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(108, 40, '1052706', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(109, 40, '1052707', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(110, 40, '1052708', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(111, 40, '1053903', 1, 'Inativo', '1500', 'ROMI', 'T240', '2013', '500mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(112, 34, '1049167', 1, 'Inativo', '0', 'SENIOR 3', 'SENIOR 3', '2012', '900mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(113, 31, '1073628', 1, 'Inativo', '0', 'Mello', 'Mello', '2012', '-', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(114, 37, '1071646', 1, 'Inativo', '0', 'Mello', 'Mello', '2012', '-', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(115, 36, '1034937', 1, 'Inativo', '0', 'KONE', 'ZN 4025', '0', '-', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(116, 33, '1107340', 2, 'Inativo', '26', 'PEMA', 'SU315', '2014', '-', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(117, 39, '1078329', 2, 'Inativo', '500', 'BAMTECH', 'CS-70', '2012', '-', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(118, 45, '1213963', 1, 'Inativo', '2300', 'ROMI', 'GL240', '2011', '1000mm', NULL, '2024-11-02', '6', '2025-05-02', NULL),
(119, 46, '995411', 1, 'Inativo', '2300', 'ROMI', '30D', '2011', '1000mm', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(120, 42, '1126815', 1, 'Inativo', '227', 'Bright', 'CB460B', '2014', '24”', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(121, 35, '904874', 1, 'Inativo', '5500', 'Nardini', 'Discovery Skybull750', '2009', '1000mm', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(122, 47, '1213964', 1, 'Inativo', '5500', 'ROMI', 'D600', '2018', '600mm', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(124, 28, '1007423', 1, 'Inativo', '1930', 'KONE', 'KFU-2 ', '2011', '900 x 350 x 460', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(125, 28, '1007424', 1, 'Inativo', '1930', 'KONE', 'KFU-2 ', '2011', '900 x 350 x 460', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(126, 28, '1040682', 1, 'Inativo', '1930', 'KONE', 'KFU-2 ', '2012', '900 x 350 x 460', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(127, 28, '1040683', 1, 'Inativo', '1930', 'KONE', 'KFU-2 ', '2012', '900 x 350 x 460', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(128, 28, '1040684', 1, 'Inativo', '1930', 'KONE', 'KFU-2 ', '2012', '900 x 350 x 460', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(129, 28, '1040685', 1, 'Inativo', '1930', 'KONE', 'KFU-2 ', '2012', '900 x 350 x 460', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(130, 44, '1037401', 1, 'Inativo', '0', 'KONE', 'ZN 4025', '0', '-', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(131, 44, '1037402', 1, 'Inativo', '0', 'KONE', 'ZN 4025', '0', '-', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(132, 32, '1032341', 1, 'Inativo', '0', 'KONE', '-', '0', '-', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(133, 32, '1032342', 1, 'Inativo', '0', 'KONE', '-', '0', '-', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(134, 43, '1038143', 3, 'Inativo', '3000', ' F-500 B', ' F-500 B', '2012', '4200mm x 2500mm x 2500mm', NULL, '2024-11-03', '6', '2025-05-03', 11),
(135, 38, '568948', 1, 'Inativo', '0', 'JOWA', ' B-100', '0', '-', NULL, '2024-11-03', '6', '2025-05-03', 12),
(136, 38, '517172', 1, 'Inativo', '0', 'SCHULZ', 'SCHULZ', '0', '-', NULL, '2024-11-03', '6', '2025-05-03', 12),
(137, 30, '921971', 2, 'Inativo', '12', 'THOR', 'industrial', '2012', '-', NULL, '2024-11-03', '6', '2025-05-03', NULL),
(149, 49, '1001576', 3, 'Inativo', '0', 'FR ', '1208so', '2011', '-', NULL, '2024-11-24', '6', '2025-05-24', 12),
(151, 56, '934200', 3, 'Inativo', '0', 'ALTENDORF', 'WA8', '0', '-', NULL, '2024-12-08', '6', '2025-06-08', 12),
(152, 53, '794100', 3, 'Inativo', '5000', 'Giben', 'Smart SP-90', '0', '-', NULL, '2024-12-15', '6', '2025-06-15', 11),
(153, 58, '1049167', 3, 'Inativo', '0', 'SENIOR 3', 'SENIOR 3', '2012', '900mm x 800mm x 800mm', NULL, '2024-12-15', '6', '2025-06-15', 12),
(154, 54, '1228259', 3, 'Inativo', '167', 'AUTOMÁTIC ', '100', '2019', '3000mm x 1000mm x 850mm', NULL, '2024-12-15', '6', '2025-06-15', 11),
(155, 52, '1235429', 3, 'Inativo', '1930', 'PROSMAQ', 'MP-200', '2020', 'Mesa - 3496mm x 2991mm, Altura máquina 2800mm, Altura de corte - 1600mm, Distancia do trilho - 5200mm', NULL, '2024-12-15', '6', '2025-06-15', 12),
(156, 48, '1006226', 3, 'Inativo', '300', 'Vima', 'DES-1600', '0', '1900mm x 610mm x905mm', NULL, '2024-12-16', '6', '2025-06-16', 9),
(157, 59, '1038142', 3, 'Inativo', '0', 'Giben', 'PTP-3214', '2011', '-', NULL, '2024-12-16', '6', '2025-06-16', 9),
(158, 29, '1045355', 3, 'Inativo', '10000', 'MACLINEA', 'CB97SOFT', '2012', '11.m x 2.m x 1.5m', NULL, '2024-12-16', '6', '2025-06-16', 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `maquina_requisitos`
--

CREATE TABLE `maquina_requisitos` (
  `idmaquina_requisitos` int(11) NOT NULL,
  `maquina_id` int(11) DEFAULT NULL,
  `requisitos_especificos` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `motor`
--

CREATE TABLE `motor` (
  `idmotor` int(11) NOT NULL,
  `motor_fabricante` varchar(70) DEFAULT NULL,
  `motor_modelo` varchar(80) DEFAULT NULL,
  `motor_potencia` varchar(10) DEFAULT NULL,
  `motor_tensão` varchar(10) DEFAULT NULL,
  `motor_corrente` varchar(10) DEFAULT NULL,
  `motor_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `motor`
--

INSERT INTO `motor` (`idmotor`, `motor_fabricante`, `motor_modelo`, `motor_potencia`, `motor_tensão`, `motor_corrente`, `motor_status`) VALUES
(8, 'TUPIA', 'TEKNOMOTOR', '3CV', '220V', '7.0', 'Ativo'),
(9, 'FANUC', 'Oi-MC', '11CV', '220V', '60A', 'Ativo'),
(10, 'WEG', '', '3,5CV', '220V', '60HZ', 'Ativo'),
(11, 'SIEMENS', '', '25CV', '220V', '49A', 'Ativo'),
(12, 'WEG', '', '7,5CV', '220V', '16A', 'Ativo'),
(13, 'STM', 'SENIOR', '380W', '220V', '10A', 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `requisitos`
--

CREATE TABLE `requisitos` (
  `idrequisitos` int(11) NOT NULL,
  `requisito_topico` varchar(255) NOT NULL,
  `tipo_req` enum('Seguranca','Operacional','Preventivo') NOT NULL,
  `requisitos_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `requisitos`
--

INSERT INTO `requisitos` (`idrequisitos`, `requisito_topico`, `tipo_req`, `requisitos_status`) VALUES
(205, 'As proteções fixas estão integras conforme inventario educacional.', 'Seguranca', 'Ativo'),
(206, 'As proteções móveis fazem a abertura e fechamento de maneira normal sem travamentos', 'Seguranca', 'Ativo'),
(207, 'As proteções móveis mantém-se na posição aberta e fechada', 'Seguranca', 'Ativo'),
(208, 'Os visores de policarbonato estão com boa visibilidade e isento de riscos e trincas.', 'Seguranca', 'Ativo'),
(209, 'Puxadores manípulos estão íntegros', 'Seguranca', 'Ativo'),
(210, 'Boa condição geral quanto ao funcionamento elétrico do dispositivo.', 'Seguranca', 'Ativo'),
(212, 'Ao apertar o botão de emergência máquina para quando é acionado', 'Seguranca', 'Ativo'),
(213, 'Ao apertar o botão de emergência ele mantém-se retido quando acionado', 'Seguranca', 'Ativo'),
(214, 'O botão de emergência está com a identificação visível', 'Seguranca', 'Ativo'),
(215, 'Botão de rearme está com correto funcionamento', 'Seguranca', 'Ativo'),
(216, 'O botão de rearme está com a identificação visível', 'Seguranca', 'Ativo'),
(217, 'A chave geral está com correto funcionamento', 'Seguranca', 'Ativo'),
(218, 'As sinalização de advertência e instruções estão em bom estado de conservação ', 'Seguranca', 'Ativo'),
(219, 'Verificar os níveis de óleo lubrificante', 'Operacional', 'Ativo'),
(220, 'Retirar excessos de cavacos da área de usinagem', 'Operacional', 'Ativo'),
(221, 'Lubrificar guias e barramento', 'Operacional', 'Ativo'),
(222, 'Inspecionar raspadores de cavacos', 'Operacional', 'Ativo'),
(223, 'Posicionar partes moveis na posição de descanso.', 'Operacional', 'Ativo'),
(224, 'Limpar visor da porta', 'Operacional', 'Ativo'),
(225, 'Lubrificar placa', 'Operacional', 'Ativo'),
(226, 'Lubrificar a manga do cabeçote móvel (acessório)', 'Operacional', 'Ativo'),
(227, 'As proteções fixas estão em correto funcionamento', 'Seguranca', 'Ativo'),
(228, 'Chaves eletromecânicas e magnéticas estão em boa condição geral quanto ao funcionamento elétrico do dispositivo', 'Seguranca', 'Ativo'),
(229, 'Sinalização de advertência e instruções estão em boa condição geral quanto a sujeira, rasgo, descolamento.', 'Seguranca', 'Ativo'),
(230, 'Rolamento do eixo de equilibrio (Eixo principal)', 'Operacional', 'Ativo'),
(231, 'Porca rápida', 'Operacional', 'Ativo'),
(232, 'Flanges e cones de fixação da roda', 'Operacional', 'Ativo'),
(233, 'Pré-aquecer a máquina', 'Operacional', 'Ativo'),
(234, 'Limpar filtros (tela) do tanque de fluído refrigerante', 'Operacional', 'Ativo'),
(235, 'Desgaste das correias e sapata da esteira', 'Operacional', 'Ativo'),
(236, 'Verificar desgastes dos trilhos da mesa de apoio', 'Operacional', 'Ativo'),
(237, 'Inspecionar qualidade do corte das fresas e disco de serra', 'Operacional', 'Ativo'),
(238, 'Verificar sistema de travamento geral', 'Operacional', 'Ativo'),
(239, 'Inspecionar sensores', 'Operacional', 'Ativo'),
(240, 'Verificar sistema pneumático', 'Operacional', 'Ativo'),
(241, 'Desgaste das correias da esteira', 'Operacional', 'Ativo'),
(242, 'Inspecionar qualidade do corte das brocas', 'Operacional', 'Ativo'),
(243, 'Verificar sistema de travamento das guias', 'Operacional', 'Ativo'),
(244, 'Analisar possiveis ruídos e vibrações', 'Operacional', 'Ativo'),
(245, 'Verificar estado da pedra abrasiva', 'Operacional', 'Ativo'),
(246, 'Limpar Visor de proteção', 'Operacional', 'Ativo'),
(247, 'Limpar máquina após uso', 'Operacional', 'Ativo'),
(248, 'Verificar Rolamentos', 'Operacional', 'Ativo'),
(249, 'Verificar fresa e disco de corte', 'Operacional', 'Ativo'),
(250, 'Retirar excessos de material da área de usinagem', 'Operacional', 'Ativo'),
(251, 'Inspecionar sistemas de travamentos dos manípulos', 'Operacional', 'Ativo'),
(252, 'Verificar avarias no sistema exaustão', 'Operacional', 'Ativo'),
(253, 'Verificar sistemas de proteção', 'Operacional', 'Ativo'),
(254, 'Inspecionar disco antes do funcionamento', 'Operacional', 'Ativo'),
(255, 'Verificar acionamento dos botões', 'Operacional', 'Ativo'),
(256, 'Verificar vazamento no sistema de refrigeração', 'Operacional', 'Ativo'),
(257, 'Verificar nível e qualidade do fluído refrigerante', 'Operacional', 'Ativo'),
(258, 'Limpar tanque do armazenamento do fluído', 'Operacional', 'Ativo'),
(259, 'Verificar vazamentos de ar comprimido', 'Operacional', 'Ativo'),
(260, 'Verificar vazamento de líquido refrigerante', 'Operacional', 'Ativo'),
(261, 'Verificar desgaste dos eletrodos', 'Operacional', 'Ativo'),
(262, 'Verificar pedal de acionamento', 'Operacional', 'Ativo'),
(263, 'Inspecionar possiveis ruídos após ligar o equipamento', 'Operacional', 'Ativo'),
(264, 'As proteções fixas estão em boa condição geral quanto ao funcionamento elétrico do dispositivo.', 'Seguranca', 'Ativo'),
(265, 'A chave geral esta sem anormalidades de acordo com a visibilidade (riscos, trincas nas portas frontal e traseiras) estão integras', 'Seguranca', 'Ativo'),
(266, 'A fixação (Alinhamento, afrouxamento, trinca) das chaves eletromecânicas e magnéticas estão corretas', 'Seguranca', 'Ativo'),
(267, 'A fixação (Alinhamento, afrouxamento, trinca) refentre as proteções móveis está correta', 'Seguranca', 'Ativo'),
(268, 'A visibilidade dos visores de policarbonato(riscos, trincas) está conforme manual do fabricante.', 'Seguranca', 'Ativo'),
(269, 'As proteções móveis fazem a abertura e fechamento de maneira normal sem travamentos na porta de acesso interno do painel de energia', 'Seguranca', 'Ativo'),
(270, 'O sistema de ar da máquina está com correta fixação (alinhamento, afrouxamento, trinca e vazamentos de ar)', 'Seguranca', 'Ativo'),
(271, 'Puxadores, Manípulos, travas e proteções estão íntegros', 'Seguranca', 'Ativo'),
(272, 'As proteções móveis fazem a abertura e fechamento de maneira normal sem travamentos na porta de acesso ao painel de energia e CPU.', 'Seguranca', 'Ativo'),
(273, 'As chaves eletromecânicas e magnéticas estão acionando ou ligando', 'Seguranca', 'Ativo'),
(275, 'Danos aparentes nos manipulos, travas e estrutura geral da máquina', 'Operacional', 'Ativo'),
(276, 'Verificar Correias, polias, guias, barramentos e rolamentos.', 'Operacional', 'Ativo'),
(277, 'Verificar as proteções de seguranças estão em seus devidos lugares, frouxas, danificadas e fechadas.', 'Operacional', 'Ativo'),
(278, 'Observar ruídos excessivos', 'Operacional', 'Ativo'),
(279, 'Lubrificar guias, sistema de carro porta serras e sistemas de ar.', 'Operacional', 'Ativo'),
(280, 'Verificar desgastes da corrente do carro porta serras e sistemas de ar.', 'Operacional', 'Ativo'),
(281, 'Limpar resíduos de material proviniente do uso.', 'Operacional', 'Ativo'),
(282, 'Limpar máquina geral.', 'Operacional', 'Ativo'),
(283, 'Inspecionar vazamentos de ar comprimido.', 'Operacional', 'Ativo'),
(284, 'Chaves eletromecânicas e magnéticas estão em correto funcionamento', 'Seguranca', 'Ativo'),
(285, 'Chaves eletromecânicas e magnéticas estão em bom estado de conservação.', 'Seguranca', 'Ativo'),
(286, 'Inspeção de correntes.', 'Operacional', 'Ativo'),
(287, 'Maquina não contém danos Aparentes', 'Operacional', 'Ativo'),
(289, 'Lubrificação das barras de rosca dos manipulos e rolamentos', 'Operacional', 'Ativo'),
(290, 'Verificar desgastes das fresas, serras e rondanas plásticas.', 'Operacional', 'Ativo'),
(291, 'Limpar resíduos de material decorrentes do uso.', 'Operacional', 'Ativo'),
(292, 'Limpar filtro sistema pneumático', 'Operacional', 'Ativo'),
(293, 'Lubrificar guias, barramento e rolamentos', 'Operacional', 'Ativo'),
(294, 'Inspecionar laminas de corte', 'Operacional', 'Ativo'),
(295, 'Verificar vazamentos no sistema de ar', 'Operacional', 'Ativo'),
(296, 'Limpar com pincel diariamente sistema de corte', 'Operacional', 'Ativo'),
(297, 'Verificar diariamente sinalização geral da máquina', 'Operacional', 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `setor`
--

CREATE TABLE `setor` (
  `idsetor` int(11) NOT NULL,
  `setor_nome` varchar(110) NOT NULL,
  `unidade_id` int(11) NOT NULL,
  `setor_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `setor`
--

INSERT INTO `setor` (`idsetor`, `setor_nome`, `unidade_id`, `setor_status`) VALUES
(1, 'Mecânica', 4, 'Ativo'),
(2, 'Solda', 4, 'Ativo'),
(3, 'Madeira', 4, 'Inativo'),
(4, 'Plástico', 4, 'Ativo'),
(5, 'Pintura', 4, 'Inativo'),
(6, 'Montagem', 4, 'Ativo'),
(7, 'Usinagem', 4, 'Ativo'),
(8, 'Eletroeletrônica', 4, 'Ativo'),
(9, 'Caldeiraria', 4, 'Inativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacao_erro`
--

CREATE TABLE `solicitacao_erro` (
  `idsolicitacao_erro` int(11) NOT NULL,
  `id_colaborador` int(11) NOT NULL,
  `data_solicitacao` datetime DEFAULT NULL,
  `desc_erro` varchar(255) DEFAULT NULL,
  `situacao` enum('Nova','Resolvido') DEFAULT 'Nova',
  `data_solucao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `solicitacao_erro`
--

INSERT INTO `solicitacao_erro` (`idsolicitacao_erro`, `id_colaborador`, `data_solicitacao`, `desc_erro`, `situacao`, `data_solucao`) VALUES
(27, 59, '2025-10-21 16:18:39', 'TESTE TI FAZENDO OBS', 'Resolvido', '2025-10-21 16:18:48'),
(28, 59, '2025-10-22 15:09:24', 'TESTE MATHEUSAAAAAA', 'Resolvido', '2025-10-22 15:09:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipomaquina`
--

CREATE TABLE `tipomaquina` (
  `idtipomaquina` int(11) NOT NULL,
  `tipomaquina_nome` varchar(80) NOT NULL,
  `tipomaquina_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
  `tipomaquina_arquivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tipomaquina`
--

INSERT INTO `tipomaquina` (`idtipomaquina`, `tipomaquina_nome`, `tipomaquina_status`, `tipomaquina_arquivo`) VALUES
(28, 'FRESADORA UNIVERSAL', 'Ativo', NULL),
(29, 'COLADEIRA DE BORDO UNILATERAL', 'Ativo', NULL),
(30, 'MOTO ESMERIL DE BANCADA SOLDA', 'Ativo', NULL),
(31, 'RETIFICA CILÍNDRICA', 'Ativo', NULL),
(32, 'FURADEIRA DE COLUNA', 'Ativo', NULL),
(33, 'SERRA PEMA SU315', 'Ativo', NULL),
(34, 'REFILADORA', 'Ativo', NULL),
(35, 'CENTRO DE USINAGEM FANUC', 'Ativo', NULL),
(36, 'SERRA DE FITA', 'Ativo', NULL),
(37, 'RETIFICA PLANA', 'Ativo', NULL),
(38, 'MOTO ESMERIL DE BANCADA MECÂNICA', 'Ativo', NULL),
(39, 'SOLDADORA A PONTO POR RESISTÊNCIA ELÉTRICA', 'Ativo', NULL),
(40, 'TORNO MECÂNICO UNIVERSAL', 'Ativo', NULL),
(42, 'BALANCEADORA', 'Ativo', NULL),
(43, 'FURADEIRA MÚLTIPLA LIDEAR', 'Ativo', NULL),
(44, 'FURADEIRA DE BANCADA', 'Ativo', NULL),
(45, 'TORNO CNC GL240', 'Ativo', NULL),
(46, 'TORNO 30D', 'Ativo', NULL),
(47, 'CENTRO DE USINAGEM D600', 'Ativo', NULL),
(48, 'DESEMPENADEIRA', 'Ativo', NULL),
(49, 'FRESADORA CNC VETOR', 'Ativo', NULL),
(50, 'FURADEIRA HORIZONTAL', 'Ativo', NULL),
(51, 'CENTRO DE USINAGEM GIBEN', 'Ativo', NULL),
(52, 'LAMINADORA DE ESPUMA', 'Ativo', NULL),
(53, 'SECCIONADORA', 'Ativo', NULL),
(54, 'PERCINTADORA', 'Ativo', NULL),
(55, 'LAMINADORA', 'Ativo', NULL),
(56, 'SERRA CIRCULAR ESQUADREJADEIRA', 'Ativo', NULL),
(58, 'REFILADORA MANUAL', 'Ativo', NULL),
(59, 'CENTRO DE USINAGEM GIBEM', 'Ativo', NULL),
(62, 'teste', 'Ativo', '/nr12/uploads/historico_filtrado.xlsx'),
(63, 'teste2', 'Ativo', '/nr12/uploads/historico_filtrado.xlsx'),
(64, 'teste', 'Ativo', '/nr12/uploads/historico_filtrado2.xlsx');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipomaquina_requisito`
--

CREATE TABLE `tipomaquina_requisito` (
  `idtipomaquinarequisito` int(11) NOT NULL,
  `tipomaquina_id` int(11) NOT NULL,
  `requisitos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `tipomaquina_requisito`
--

INSERT INTO `tipomaquina_requisito` (`idtipomaquinarequisito`, `tipomaquina_id`, `requisitos_id`) VALUES
(248, 40, 205),
(249, 40, 206),
(250, 40, 207),
(251, 40, 208),
(252, 40, 209),
(253, 40, 210),
(254, 40, 212),
(255, 40, 213),
(256, 40, 214),
(257, 40, 215),
(258, 40, 216),
(259, 40, 217),
(260, 40, 218),
(261, 40, 219),
(262, 40, 220),
(263, 40, 221),
(264, 40, 222),
(265, 40, 223),
(266, 40, 224),
(267, 40, 225),
(268, 40, 226),
(292, 42, 205),
(293, 42, 210),
(294, 42, 212),
(295, 42, 213),
(296, 42, 227),
(297, 42, 228),
(298, 42, 229),
(299, 42, 230),
(300, 42, 231),
(301, 42, 232),
(302, 42, 264),
(303, 47, 205),
(304, 47, 206),
(305, 47, 207),
(306, 47, 208),
(307, 47, 209),
(308, 47, 212),
(309, 47, 213),
(310, 47, 214),
(311, 47, 215),
(312, 47, 216),
(313, 47, 217),
(314, 47, 218),
(315, 47, 219),
(316, 47, 220),
(317, 47, 221),
(318, 47, 222),
(319, 47, 223),
(320, 47, 224),
(321, 47, 225),
(322, 47, 226),
(323, 47, 227),
(324, 47, 228),
(325, 47, 233),
(326, 47, 234),
(327, 47, 264),
(328, 47, 265),
(329, 47, 266),
(330, 47, 267),
(331, 47, 268),
(332, 35, 205),
(333, 35, 206),
(334, 35, 207),
(335, 35, 208),
(336, 35, 209),
(337, 35, 212),
(338, 35, 213),
(339, 35, 214),
(340, 35, 215),
(341, 35, 216),
(342, 35, 217),
(343, 35, 218),
(344, 35, 219),
(345, 35, 220),
(346, 35, 221),
(347, 35, 222),
(348, 35, 223),
(349, 35, 224),
(350, 35, 225),
(351, 35, 226),
(352, 35, 228),
(353, 35, 233),
(354, 35, 234),
(355, 35, 265),
(356, 35, 266),
(357, 35, 267),
(358, 35, 268),
(359, 29, 205),
(360, 29, 207),
(361, 29, 212),
(362, 29, 213),
(363, 29, 221),
(364, 29, 228),
(365, 29, 229),
(366, 29, 235),
(367, 29, 236),
(368, 29, 237),
(369, 29, 238),
(370, 29, 239),
(371, 29, 240),
(372, 29, 264),
(373, 29, 268),
(374, 29, 269),
(375, 29, 270),
(376, 29, 271),
(377, 28, 205),
(378, 28, 206),
(379, 28, 207),
(380, 28, 208),
(381, 28, 209),
(382, 28, 212),
(383, 28, 213),
(384, 28, 214),
(385, 28, 215),
(386, 28, 216),
(387, 28, 217),
(388, 28, 218),
(389, 28, 219),
(390, 28, 220),
(391, 28, 221),
(392, 28, 222),
(393, 28, 223),
(394, 28, 224),
(395, 28, 228),
(396, 44, 205),
(397, 44, 206),
(398, 44, 207),
(399, 44, 208),
(400, 44, 209),
(401, 44, 212),
(402, 44, 213),
(403, 44, 214),
(404, 44, 215),
(405, 44, 216),
(406, 44, 217),
(407, 44, 218),
(408, 44, 219),
(409, 44, 220),
(410, 44, 221),
(411, 44, 222),
(412, 44, 223),
(413, 44, 224),
(414, 44, 225),
(415, 44, 226),
(416, 44, 228),
(417, 44, 233),
(418, 44, 234),
(419, 44, 265),
(420, 44, 266),
(421, 44, 267),
(422, 44, 268),
(423, 32, 205),
(424, 32, 206),
(425, 32, 207),
(426, 32, 208),
(427, 32, 209),
(428, 32, 212),
(429, 32, 213),
(430, 32, 214),
(431, 32, 215),
(432, 32, 216),
(433, 32, 217),
(434, 32, 218),
(435, 32, 219),
(436, 32, 220),
(437, 32, 221),
(438, 32, 222),
(439, 32, 223),
(440, 32, 224),
(441, 32, 225),
(442, 32, 226),
(443, 32, 228),
(444, 32, 233),
(445, 32, 234),
(446, 32, 265),
(447, 32, 266),
(448, 32, 267),
(449, 32, 268),
(450, 43, 205),
(451, 43, 207),
(452, 43, 208),
(453, 43, 212),
(454, 43, 213),
(455, 43, 221),
(456, 43, 228),
(457, 43, 229),
(458, 43, 236),
(459, 43, 239),
(460, 43, 240),
(461, 43, 241),
(462, 43, 242),
(463, 43, 243),
(464, 43, 268),
(465, 43, 269),
(466, 43, 271),
(467, 38, 205),
(468, 38, 206),
(469, 38, 207),
(470, 38, 208),
(471, 38, 209),
(472, 38, 212),
(473, 38, 213),
(474, 38, 214),
(475, 38, 215),
(476, 38, 216),
(477, 38, 217),
(478, 38, 218),
(479, 38, 219),
(480, 38, 220),
(481, 38, 221),
(482, 38, 222),
(483, 38, 223),
(484, 38, 224),
(485, 38, 225),
(486, 38, 226),
(487, 38, 228),
(488, 38, 229),
(489, 38, 233),
(490, 38, 234),
(491, 38, 244),
(492, 38, 245),
(493, 38, 246),
(494, 38, 247),
(495, 38, 265),
(496, 38, 266),
(497, 38, 267),
(498, 38, 268),
(499, 30, 205),
(500, 30, 228),
(501, 30, 229),
(502, 30, 244),
(503, 30, 245),
(504, 30, 246),
(505, 30, 247),
(506, 30, 264),
(507, 34, 205),
(508, 34, 207),
(509, 34, 208),
(510, 34, 212),
(511, 34, 213),
(512, 34, 221),
(513, 34, 228),
(514, 34, 229),
(515, 34, 248),
(516, 34, 249),
(517, 34, 250),
(518, 34, 251),
(519, 34, 252),
(520, 34, 253),
(521, 34, 268),
(522, 34, 269),
(523, 34, 271),
(524, 31, 205),
(525, 31, 206),
(526, 31, 207),
(527, 31, 208),
(528, 31, 209),
(529, 31, 212),
(530, 31, 213),
(531, 31, 214),
(532, 31, 215),
(533, 31, 216),
(534, 31, 217),
(535, 31, 218),
(536, 31, 219),
(537, 31, 220),
(538, 31, 221),
(539, 31, 222),
(540, 31, 223),
(541, 31, 224),
(542, 31, 225),
(543, 31, 226),
(544, 31, 228),
(545, 31, 233),
(546, 31, 234),
(547, 31, 265),
(548, 31, 266),
(549, 31, 267),
(550, 31, 268),
(551, 37, 205),
(552, 37, 206),
(553, 37, 207),
(554, 37, 208),
(555, 37, 209),
(556, 37, 212),
(557, 37, 213),
(558, 37, 214),
(559, 37, 215),
(560, 37, 216),
(561, 37, 217),
(562, 37, 218),
(563, 37, 219),
(564, 37, 220),
(565, 37, 221),
(566, 37, 222),
(567, 37, 223),
(568, 37, 224),
(569, 37, 225),
(570, 37, 226),
(571, 37, 228),
(572, 37, 233),
(573, 37, 234),
(574, 37, 265),
(575, 37, 266),
(576, 37, 267),
(577, 37, 268),
(578, 36, 205),
(579, 36, 206),
(580, 36, 207),
(581, 36, 208),
(582, 36, 209),
(583, 36, 212),
(584, 36, 213),
(585, 36, 214),
(586, 36, 215),
(587, 36, 216),
(588, 36, 217),
(589, 36, 218),
(590, 36, 219),
(591, 36, 220),
(592, 36, 221),
(593, 36, 222),
(594, 36, 223),
(595, 36, 224),
(596, 36, 225),
(597, 36, 226),
(598, 36, 228),
(599, 36, 233),
(600, 36, 234),
(601, 36, 265),
(602, 36, 266),
(603, 36, 267),
(604, 36, 268),
(605, 33, 205),
(606, 33, 212),
(607, 33, 213),
(608, 33, 228),
(609, 33, 229),
(610, 33, 254),
(611, 33, 255),
(612, 33, 256),
(613, 33, 257),
(614, 33, 258),
(615, 33, 264),
(616, 46, 205),
(617, 46, 206),
(618, 46, 207),
(619, 46, 208),
(620, 46, 209),
(621, 46, 212),
(622, 46, 213),
(623, 46, 214),
(624, 46, 215),
(625, 46, 216),
(626, 46, 217),
(627, 46, 218),
(628, 46, 219),
(629, 46, 220),
(630, 46, 221),
(631, 46, 222),
(632, 46, 223),
(633, 46, 224),
(634, 46, 225),
(635, 46, 226),
(636, 46, 228),
(637, 46, 233),
(638, 46, 234),
(639, 46, 265),
(640, 46, 266),
(641, 46, 267),
(642, 46, 268),
(643, 45, 205),
(644, 45, 206),
(645, 45, 207),
(646, 45, 208),
(647, 45, 209),
(648, 45, 212),
(649, 45, 213),
(650, 45, 214),
(651, 45, 215),
(652, 45, 216),
(653, 45, 217),
(654, 45, 218),
(655, 45, 219),
(656, 45, 220),
(657, 45, 221),
(658, 45, 222),
(659, 45, 223),
(660, 45, 224),
(661, 45, 225),
(662, 45, 226),
(663, 45, 228),
(664, 45, 233),
(665, 45, 234),
(666, 45, 265),
(667, 45, 266),
(668, 45, 267),
(669, 45, 268),
(670, 49, 205),
(671, 49, 208),
(672, 49, 212),
(673, 49, 213),
(674, 49, 215),
(675, 49, 216),
(676, 49, 217),
(677, 49, 228),
(678, 49, 229),
(679, 49, 266),
(680, 49, 267),
(681, 49, 268),
(682, 49, 271),
(683, 49, 272),
(684, 49, 207),
(685, 49, 273),
(686, 49, 275),
(687, 49, 276),
(688, 49, 277),
(689, 49, 278),
(690, 49, 279),
(691, 49, 280),
(692, 49, 281),
(693, 49, 282),
(694, 49, 283),
(695, 56, 205),
(696, 56, 206),
(697, 56, 207),
(698, 56, 208),
(699, 56, 212),
(700, 56, 213),
(701, 56, 214),
(702, 56, 215),
(703, 56, 216),
(704, 56, 217),
(705, 56, 229),
(706, 56, 267),
(707, 56, 284),
(708, 56, 285),
(709, 56, 277),
(710, 56, 278),
(711, 56, 286),
(712, 56, 287),
(713, 56, 289),
(714, 56, 290),
(715, 56, 291),
(716, 54, 205),
(717, 54, 206),
(718, 54, 207),
(719, 54, 212),
(720, 54, 213),
(721, 54, 214),
(722, 54, 228),
(723, 54, 229),
(724, 54, 264),
(725, 54, 271),
(726, 54, 292),
(727, 54, 293),
(728, 54, 294),
(729, 54, 295),
(730, 54, 296),
(731, 54, 297),
(732, 59, 205),
(733, 59, 207),
(734, 59, 208),
(735, 59, 212),
(736, 59, 213),
(737, 59, 214),
(738, 59, 215),
(739, 59, 216),
(740, 59, 217),
(741, 59, 229),
(742, 59, 265),
(743, 59, 267),
(744, 59, 271),
(745, 59, 272),
(746, 59, 273),
(747, 59, 285);

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `idturmas` int(11) NOT NULL,
  `turma_nome` varchar(120) NOT NULL,
  `turma_periodo` enum('Manhã','Tarde','Noite','Integral') NOT NULL,
  `turma_inicio` date NOT NULL,
  `turma_fim` date NOT NULL,
  `turma_curso` varchar(60) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `turmas_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
  `colaborador_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`idturmas`, `turma_nome`, `turma_periodo`, `turma_inicio`, `turma_fim`, `turma_curso`, `curso_id`, `turmas_status`, `colaborador_id`) VALUES
(14, 'MALP2_ACIVG', 'Manhã', '2005-03-31', '0000-00-00', '', 19, 'Inativo', 1),
(26, 'MAMVP1A_BUNGE', 'Manhã', '2023-06-06', '2024-06-06', '', 70, 'Ativo', 5),
(27, 'MAMVP1B_BUNGE', 'Manhã', '2023-06-06', '2024-06-06', '', 70, 'Ativo', 5),
(28, 'MMAVP2_GUA', 'Manhã', '2023-06-06', '2024-06-06', '', 69, 'Ativo', 5),
(29, 'MS2', 'Manhã', '2023-06-06', '2024-06-06', '', 67, 'Ativo', 6),
(30, 'MU3_COFCO/AD', 'Manhã', '2023-06-06', '2024-06-06', '', 62, 'Ativo', 5),
(31, 'TAMVP1_FACCHINI', 'Tarde', '2023-06-06', '2024-06-06', '', 70, 'Ativo', 5),
(32, 'TF1_FACCHINI', 'Tarde', '2023-06-06', '2024-06-06', '', 68, 'Ativo', 6),
(33, 'TF2', 'Tarde', '2023-06-06', '2024-06-06', '', 68, 'Ativo', 5),
(34, 'TMV1_COFCO', 'Tarde', '2023-06-06', '2024-06-06', '', 72, 'Ativo', 6),
(35, 'TOP1A', 'Tarde', '2023-06-06', '2024-06-06', '', 71, 'Ativo', 5),
(36, 'TOP1B', 'Tarde', '2023-06-06', '2024-06-06', '', 71, 'Ativo', 6),
(37, 'TTS1A_FACCHINI', 'Tarde', '2023-06-06', '2024-06-06', '', 73, 'Ativo', 5),
(38, 'TTS1B_FACCHINI', 'Tarde', '2023-06-06', '2024-06-06', '', 73, 'Ativo', 6),
(43, 'teste - 2024', 'Tarde', '2024-11-14', '2024-11-22', '', 68, 'Ativo', 41);

-- --------------------------------------------------------

--
-- Estrutura para tabela `unidade`
--

CREATE TABLE `unidade` (
  `idunidade` int(11) NOT NULL,
  `unidade_nome` varchar(80) NOT NULL,
  `unidade_cidade` varchar(60) NOT NULL,
  `unidade_estado` varchar(50) NOT NULL,
  `unidade_numero` int(11) NOT NULL,
  `unidade_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `unidade`
--

INSERT INTO `unidade` (`idunidade`, `unidade_nome`, `unidade_cidade`, `unidade_estado`, `unidade_numero`, `unidade_status`) VALUES
(4, 'Senai Euclides Fachinni', 'Votuporanga', 'São Paulo', 850, 'Ativo'),
(5, 'Senai Mirassol', 'Mirassol', 'São Paulo', 890, 'Ativo'),
(6, 'Votuporanga Senai', 'Votuporanga', 'sp', 123, 'Ativo');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`idaluno`),
  ADD KEY `fk_aluno_turmas2_idx` (`turmas_id`);

--
-- Índices de tabela `colaborador_nome`
--
ALTER TABLE `colaborador`
  ADD PRIMARY KEY (`idcolaborador`),
  ADD KEY `fk_colaborador_setor_idx` (`setor_id`);

--
-- Índices de tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`idcurso`);

--
-- Índices de tabela `defeitos`
--
ALTER TABLE `defeitos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `colaborador_id` (`colaborador_id`),
  ADD KEY `aluno_id` (`aluno_id`),
  ADD KEY `maquina_id` (`maquina_id`);

--
-- Índices de tabela `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`historicoid`),
  ADD KEY `fk_historico_maquina1_idx` (`maquina_id`),
  ADD KEY `fk_historico_aluno1_idx` (`aluno_id`),
  ADD KEY `fk_historico_colaborador1_idx` (`colaborador_id`),
  ADD KEY `requisito_id_idx` (`requisito_id`),
  ADD KEY `fk_requisito_especifico` (`requisito_especifico_id`);

--
-- Índices de tabela `manutencao`
--
ALTER TABLE `manutencao`
  ADD PRIMARY KEY (`idmanutencao`),
  ADD KEY `fk_manutencao_maquina1_idx` (`maquina_id`),
  ADD KEY `fk_manutencao_colaborador1_idx` (`colaborador_id`);

--
-- Índices de tabela `maquina`
--
ALTER TABLE `maquina`
  ADD PRIMARY KEY (`idmaquina`),
  ADD KEY `fk_maquina_tipomaquina1_idx` (`tipomaquina_id`),
  ADD KEY `fk_maquina_setor1_idx` (`setor_id`),
  ADD KEY `fk_maquina_requisitos` (`requisitos_id`),
  ADD KEY `fk_maquina_motor` (`motor_id`);

--
-- Índices de tabela `maquina_requisitos`
--
ALTER TABLE `maquina_requisitos`
  ADD PRIMARY KEY (`idmaquina_requisitos`),
  ADD KEY `maquina_id` (`maquina_id`);

--
-- Índices de tabela `motor`
--
ALTER TABLE `motor`
  ADD PRIMARY KEY (`idmotor`);

--
-- Índices de tabela `requisitos`
--
ALTER TABLE `requisitos`
  ADD PRIMARY KEY (`idrequisitos`);

--
-- Índices de tabela `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`idsetor`),
  ADD KEY `fk_setor_unidade1_idx` (`unidade_id`);

--
-- Índices de tabela `solicitacao_erro`
--
ALTER TABLE `solicitacao_erro`
  ADD PRIMARY KEY (`idsolicitacao_erro`),
  ADD KEY `fk_id_colaborador_idx` (`id_colaborador`);

--
-- Índices de tabela `tipomaquina`
--
ALTER TABLE `tipomaquina`
  ADD PRIMARY KEY (`idtipomaquina`);

--
-- Índices de tabela `tipomaquina_requisito`
--
ALTER TABLE `tipomaquina_requisito`
  ADD PRIMARY KEY (`idtipomaquinarequisito`),
  ADD KEY `tipomaquina_id_idx` (`tipomaquina_id`),
  ADD KEY `requisitos_id_idx` (`requisitos_id`);

--
-- Índices de tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`idturmas`),
  ADD KEY `fk_turmas_curso1_idx` (`curso_id`),
  ADD KEY `colaborador_id_idx` (`colaborador_id`);

--
-- Índices de tabela `unidade`
--
ALTER TABLE `unidade`
  ADD PRIMARY KEY (`idunidade`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela ``
--
ALTER TABLE `aluno`
  MODIFY `idaluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=557;

--
-- AUTO_INCREMENT de tabela `colaborador`
--
ALTER TABLE `colaborador`
  MODIFY `idcolaborador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `idcurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de tabela `defeitos`
--
ALTER TABLE `defeitos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `historico`
--
ALTER TABLE `historico`
  MODIFY `historicoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=759;

--
-- AUTO_INCREMENT de tabela `manutencao`
--
ALTER TABLE `manutencao`
  MODIFY `idmanutencao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `maquina`
--
ALTER TABLE `maquina`
  MODIFY `idmaquina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT de tabela `maquina_requisitos`
--
ALTER TABLE `maquina_requisitos`
  MODIFY `idmaquina_requisitos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `motor`
--
ALTER TABLE `motor`
  MODIFY `idmotor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `requisitos`
--
ALTER TABLE `requisitos`
  MODIFY `idrequisitos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT de tabela `setor`
--
ALTER TABLE `setor`
  MODIFY `idsetor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `solicitacao_erro`
--
ALTER TABLE `solicitacao_erro`
  MODIFY `idsolicitacao_erro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `tipomaquina`
--
ALTER TABLE `tipomaquina`
  MODIFY `idtipomaquina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `tipomaquina_requisito`
--
ALTER TABLE `tipomaquina_requisito`
  MODIFY `idtipomaquinarequisito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=748;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `idturmas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `unidade`
--
ALTER TABLE `unidade`
  MODIFY `idunidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadasa
--
a
--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_aluno_turmas2` FOREIGN KEY (`turmas_id`) REFERENCES `turmas` (`idturmas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `colaborador`
--
ALTER TABLE `colaborador`
  ADD CONSTRAINT `fk_colaborador_setor` FOREIGN KEY (`setor_id`) REFERENCES `setor` (`idsetor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
