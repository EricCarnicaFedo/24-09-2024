<?php
include('conexaobd.php');
session_start();

// Verifica se o usuário está logado e é um veterinário
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] != 'veterinario') {
    header("Location: login.php");
    exit();
}

// Obtém o ID da clínica do veterinário logado
$clinica_id = $_SESSION['clinica_id'];

// Consulta os clientes relacionados à clínica
$sql = "SELECT * FROM clientes WHERE clinica_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$clinica_id]);
$clientes = $stmt->fetchAll();

?>

<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!----======== CSS ======== -->
  <link rel="stylesheet" href="inicio.css">
  <link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="agenda.css">
<link rel="stylesheet" href="editar.css">
  <!---------========= fontes =========------->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
  <!----===== Boxicons CSS ===== -->

  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

  <!--<title>Dashboard Sidebar Menu</title>-->
</head>


<header id="navbar" class="flex justify-between items-center text-white p-4">
    <nav>
        <div class="titulonavbar">
            <i class="bx bxs-animal-paw"></i>
            <span class="text">Agenda</span>
        </div>
        <ul class="navbarconteudo">
            <!-- Manter apenas os itens desejados -->
        </ul>
    </nav>

    <div class="flex items-center space-x-4">
        <!-- Verifica se o nome do usuário está na sessão -->
        <span class="hidden md:inline-block">Bem-vindo, <?php echo isset($_SESSION['nome_usuario']) ? $_SESSION['nome_usuario'] : 'Usuário'; ?></span>

        <a href="logout.php" class="hover:underline">Sair</a>
        <i class="bx bx-bell"></i>
        <img src="https://placehold.co/30x30" alt="User avatar" class="w-8 h-8 rounded-full">
    </div>

    <i class='bx bx-menu menu-button' id="menu-button" style="font-size: 30px;"></i>
    <i class='bx bx-cog customize-button' id="customize-button" style="font-size: 20px;"></i>
    <div id="color-picker">
        <label for="navbar-color">Choose navbar color:</label>
        <input type="color" id="navbar-color" name="navbar-color" value="#4CAF50">
    </div>
</header>



  <div id="sidebar" class="sidebar">
    <div class="sidebar-header">
      <i class='bx bx-home-alt' style="font-size: 40px; color: white;  "></i>
      <h2>VetEtec</h2>
      <!-- Ícone de exemplo -->
    </div>
    <a href="javascript:void(0)" class="closebtn" id="close-sidebar"> <i class='bx bxs-chevron-right'></i></a>
    
    <a href="inicio.html"><i class="bx bx-home"></i><pan class="sidebar-text">Início</span></a>
    <a href="notificacoes.php"><i class='bx bx-bell'></i> <span class="sidebar-text">Notificações</span></a>
  <a href="#"><i class='bx bxs-user'></i> <span class="sidebar-text">Analíticas</span></a>
  <a href="agenda.php"><i class='bx bx-calendar'></i> <span class="sidebar-text">Agenda</span></a>
  <a href="pets.php"><i class='bx bxs-cat'></i> <span class="sidebar-text">Pets</span></a>
  <a href="historico.php"><i class='bx bxs-time'></i> <span class="sidebar-text">Historico</span></a>
  <a href="cadastroteste.php"><i class='bx bxs-file-plus'></i> <span class="sidebar-text">Cadastros</span></a>
  <a href="logout.php" style="margin-top: 100px;">
  <i class='bx bx-log-out'></i> <span class="sidebar-text">Sair</span>
</a>
    <a href="#"><i class='bx bx-moon theme-toggle' id="theme-toggle"></i> <span class="sidebar-text  tema   ">Tema</span></a>

  </div>
  <body class="bg-gray-100">
    <div class="flex">
        <!-- Main content -->
        <div class="flex-1">
        <main class="p-6">
    <div class="bg-white p-6 rounded shadow-md">
        <div class="flex items-center space-x-4 mb-6">
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded flex items-center"><i class="fas fa-arrow-left mr-2"></i> VOLTAR</button>
            <h1 class="text-xl font-bold">Lista de Clientes</h1>
        </div>
        <div class="flex justify-between items-center mb-4 flex-wrap">
            <div class="flex space-x-4">
            <a href="adicionarcliente.php" class="open-popup-btn" style="margin-left: 10px; padding: 5px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center;">
    <i class='bx bxs-plus-circle'></i> Novo
</a>




                <button class="bg-yellow-500 text-white px-4 py-2 rounded flex items-center"><i class="fas fa-print mr-2"></i> Imprimir</button>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded flex items-center"><i class="fas fa-file-export mr-2"></i> Exportar Planilha</button>
            </div>
            <div class="flex items-center space-x-2 flex-wrap mt-4 md:mt-0">
                <label for="estado" class="mr-2">Estado</label>
                <select id="estado" class="border-gray-300 border p-2 rounded">
                    <option>Ativo</option>
                </select>
                <label for="desde" class="ml-4 mr-2">Desde</label>
                <select id="desde" class="border-gray-300 border p-2 rounded">
                    <option>Janeiro</option>
                </select>
                <label for="ate" class="ml-4 mr-2">Até</label>
                <select id="ate" class="border-gray-300 border p-2 rounded">
                    <option>Dezembro</option>
                </select>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded ml-4 flex items-center"><i class="fas fa-filter mr-2"></i> Filtrar</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nome</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Telefone</th>
                        <th class="py-2 px-4 border-b">Endereço</th>
                        <th class="py-2 px-4 border-b">Cidade</th>
                        <th class="py-2 px-4 border-b">Estado</th>
                        <th class="py-2 px-4 border-b">CEP</th>
                        <th class="py-2 px-4 border-b">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require("classecliente.php");

                    $cliente = new Cliente();  
                    $clientes = $cliente->listar($_SESSION['clinica_id']); // Passa o clinica_id

                    foreach ($clientes as $registro) {
                    ?>
                    <tr>
                        <td style="padding: 10px; text-align: center;"><?php echo $registro["idCliente"]; ?></td>
                        <td style="padding: 10px; text-align: center;"><?php echo $registro["nome"]; ?></td>
                        <td style="padding: 10px; text-align: center;"><?php echo $registro["email"]; ?></td>
                        <td style="padding: 10px; text-align: center;"><?php echo $registro["telefone"]; ?></td>
                        <td style="padding: 10px; text-align: center;"><?php echo $registro["endereco"]; ?></td>
                        <td style="padding: 10px; text-align: center;"><?php echo $registro["cidade"]; ?></td>
                        <td style="padding: 10px; text-align: center;"><?php echo $registro["estado"]; ?></td>
                        <td style="padding: 10px; text-align: center;"><?php echo $registro["cep"]; ?></td>
                        <td style="padding: 10px; text-align: center;">
                        <button id="openPopup" class="open-popup-btn" style="margin-left: 10px; padding: 5px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="abrirPopup('<?php echo $registro['idCliente']; ?>', '<?php echo $registro['nome']; ?>', '<?php echo $registro['email']; ?>', '<?php echo $registro['telefone']; ?>', '<?php echo $registro['endereco']; ?>', '<?php echo $registro['cidade']; ?>', '<?php echo $registro['estado']; ?>', '<?php echo $registro['cep']; ?>')">
    <i class="fas fa-pencil-alt"></i>
</button>

<button style="margin-left: 5px; padding: 5px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="if(confirm('Tem certeza que deseja deletar este cliente?')) location.href='deletar_cliente.php?id=<?php echo $registro['idCliente']; ?>'">
    <i class="fas fa-trash-alt"></i>
</button>

</td>

<script>
function abrirPopup(id) {
    // Aqui você pode preencher os campos com dados do registro
    document.querySelector('input[name="id"]').value = id;

    // Mostra o popup
    document.getElementById("popup").style.display = "block";
}
</script>

<?php require 'popup_cliente.php'; // Inclua o popup aqui fora do loop ?>

                            
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="botaozin">
            <div class="flex justify-between items-center mt-4">
                <span class="text-gray-600">Mostrando de 1 até <?php echo count($clientes); ?> de <?php echo count($clientes); ?> registros</span>
                <div>
                    <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-l">Anterior</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-r">Próximo</button>
                </div>
            </div>
        </div>
    </div>
</main>
<main class="p-6">
    <div class="bg-white p-6 rounded shadow-md">
        <div class="flex items-center space-x-4 mb-6">
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> VOLTAR
            </button>
            <h1 class="text-xl font-bold">Consultas Marcadas</h1>
        </div>
        <div class="flex justify-between items-center mb-4 flex-wrap">
            <div class="flex space-x-4">
                <a href="adicionarconsulta.php" class="open-popup-btn" style="margin-left: 10px; padding: 5px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center;">
                    <i class='bx bxs-plus-circle'></i> Novo
                </a>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded flex items-center">
                    <i class="fas fa-print mr-2"></i> Imprimir
                </button>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded flex items-center">
                    <i class="fas fa-file-export mr-2"></i> Exportar Planilha
                </button>
            </div>
            <div class="flex items-center space-x-2 flex-wrap mt-4 md:mt-0">
                <label for="estado" class="mr-2">Estado</label>
                <select id="estado" class="border-gray-300 border p-2 rounded">
                    <option>Ativo</option>
                </select>
                <label for="desde" class="ml-4 mr-2">Desde</label>
                <select id="desde" class="border-gray-300 border p-2 rounded">
                    <option>Janeiro</option>
                </select>
                <label for="ate" class="ml-4 mr-2">Até</label>
                <select id="ate" class="border-gray-300 border p-2 rounded">
                    <option>Dezembro</option>
                </select>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded ml-4 flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Nome do Animal</th>
                        <th class="py-2 px-4 border-b">Raça</th>
                        <th class="py-2 px-4 border-b">Proprietário</th>
                        <th class="py-2 px-4 border-b">Data da Consulta</th>
                        <th class="py-2 px-4 border-b">Hora da Consulta</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Ações</th>
                        <th class="py-2 px-4 border-b"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                require("classeconsulta.php");

                $consulta = new Consulta();  
                $consultas = $consulta->listar($_SESSION['clinica_id']); // Passa o clinica_id

                foreach ($consultas as $registro) {
                    // Define a cor com base no status
                    switch ($registro["status"]) {
                        case 'Agendada':
                            $statusColor = 'bg-yellow-500'; // Amarelo
                            break;
                        case 'Realizada':
                            $statusColor = 'bg-green-500'; // Verde
                            break;
                        case 'Cancelada':
                            $statusColor = 'bg-red-500'; // Vermelho
                            break;
                        default:
                            $statusColor = 'bg-gray-500'; // Cor padrão se o status não for reconhecido
                            break;
                    }
                ?>
                <tr>
                    <td style="padding: 10px; text-align: center;"><?php echo $registro["nome_animal"]; ?></td>
                    <td style="padding: 10px; text-align: center;"><?php echo $registro["raca"]; ?></td>
                    <td style="padding: 10px; text-align: center;"><?php echo $registro["proprietario_nome"]; ?></td>
                    <td style="padding: 10px; text-align: center;"><?php echo $registro["data_consulta"]; ?></td>
                    <td style="padding: 10px; text-align: center;"><?php echo $registro["hora_consulta"]; ?></td>
                    <td style="padding: 10px; text-align: center;">
                        <span class="text-white px-2 py-1 rounded <?php echo $statusColor; ?>">
                            <?php echo $registro["status"]; ?>
                        </span>
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        <button onclick="window.open('popup_cliente.php?id=<?php echo $registro['idConsulta']; ?>', '_blank')" class="open-popup-btn">
                            <i class="fas fa-pencil-alt"></i> 
                        </button>
                        <button style="margin-left: 5px; padding: 5px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="if(confirm('Tem certeza que deseja deletar esta consulta?')) location.href='deletar_consulta.php?id=<?php echo $registro['idConsulta']; ?>'">
                            <i class="fas fa-trash-alt"></i> <!-- Ícone de lixeira -->
                        </button>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="botaozin">
            <div class="flex justify-between items-center mt-4">
                <span class="text-gray-600">Mostrando de 1 até <?php echo count($consultas); ?> de <?php echo count($consultas); ?> registros</span>
                <div>
                    <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-l">Anterior</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-r">Próximo</button>
                </div>
            </div>
        </div>
    </div>
</main>


    <main class="p-6">
    <div class="bg-white p-6 rounded shadow-md">
        <div class="flex items-center space-x-4 mb-6">
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded flex items-center"><i class="fas fa-arrow-left mr-2"></i> VOLTAR</button>
            <h1 class="text-xl font-bold">Horários Disponíveis</h1>
        </div>
        <div class="flex justify-between items-center mb-4 flex-wrap">
            <div class="flex space-x-4">
                <button class="bg-blue-500 text-white px-4 py-2 rounded flex items-center"><i class="bx bxs-plus-circle mr-2"></i> Novo</button>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded flex items-center"><i class="fas fa-print mr-2"></i> Imprimir</button>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded flex items-center"><i class="fas fa-file-export mr-2"></i> Exportar Planilha</button>
            </div>
            <div class="flex items-center space-x-2 flex-wrap mt-4 md:mt-0">
                <label for="estado" class="mr-2">Estado</label>
                <select id="estado" class="border-gray-300 border p-2 rounded">
                    <option>Ativo</option>
                </select>
                <label for="desde" class="ml-4 mr-2">Desde</label>
                <select id="desde" class="border-gray-300 border p-2 rounded">
                    <option>Janeiro</option>
                </select>
                <label for="ate" class="ml-4 mr-2">Até</label>
                <select id="ate" class="border-gray-300 border p-2 rounded">
                    <option>Dezembro</option>
                </select>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded ml-4 flex items-center"><i class="fas fa-filter mr-2"></i> Filtrar</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-right">Data</th>
                        <th class="py-2 px-4 border-b text-right">Horário</th>
                        <th class="py-2 px-4 border-b text-right">Disponibilidade</th>
                        <th class="py-2 px-4 border-b text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require("classehorarios.php");

                    $horario = new Horarios();  
                    $horariosDisponiveis = $horario->listar($_SESSION['clinica_id']); // Assume que você tem um método listar para pegar os horários da clínica

                    foreach ($horariosDisponiveis as $registro) {
                        $statusClass = $registro['disponibilidade'] === 'Disponível' ? 'bg-green-500' : 'bg-yellow-500';
                        $statusTexto = $registro['disponibilidade'] === 'Disponível' ? 'Disponível' : 'Reservado';
                    ?>
                        <tr>
                            <td class="py-2 px-4 border-b text-right"><?php echo $registro["data"]; ?></td>
                            <td class="py-2 px-4 border-b text-right"><?php echo $registro["horario"]; ?></td>
                            <td class="py-2 px-4 border-b text-right"><span class="<?php echo $statusClass; ?> text-white px-2 py-1 rounded"><?php echo $statusTexto; ?></span></td>
                            <td class="py-2 px-4 border-b text-right">
                                <button class="bg-blue-500 text-white px-2 py-1 rounded ml-2"><i class="fas fa-eye"></i> Ver Detalhes</button>
                                <?php if ($registro['disponibilidade'] === 'Disponível') { ?>
                                    <button class="bg-yellow-500 text-white px-2 py-1 rounded ml-2"><i class="fas fa-calendar-plus"></i> Agendar</button>
                                <?php } else { ?>
                                    <button class="bg-gray-500 text-white px-2 py-1 rounded ml-2" disabled><i class="fas fa-calendar-plus"></i> Agendar</button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="botaozin">
            <div class="flex justify-between items-center mt-4">
                <span class="text-gray-600">Mostrando de 1 até <?php echo count($horariosDisponiveis); ?> de <?php echo count($horariosDisponiveis); ?> registros</span>
                <div>
                    <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-l">Anterior</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-r">Próximo</button>
                </div>
            </div>
        </div>
    </div>
</main>
    <footer class="footer">
      <div class="footer-content">
        <h2 class="footer-title">Gestão Veterinária</h2>
        <p class="footer-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris at sapien eu justo ultrices feugiat at id quam. Vivamus eu tellus vel ex pretium hendrerit. Phasellus eget vehicula ex, sit amet dictum felis.</p>
        <ul class="footer-links">
          <li><a href="#">Início</a></li>
          <li><a href="#">Sobre</a></li>
          <li><a href="#">Serviços</a></li>
          <li><a href="#">Equipe</a></li>
          <li><a href="#">Contato</a></li>
        </ul>
        <div class="social-icons">
          <a href="#"><img src="https://img.icons8.com/ios-filled/50/ffffff/facebook-new.png" alt="Facebook"></a>
          <a href="#"><img src="https://img.icons8.com/ios-filled/50/ffffff/twitter.png" alt="Twitter"></a>
          <a href="#"><img src="https://img.icons8.com/ios-filled/50/ffffff/linkedin.png" alt="LinkedIn"></a>
          <a href="#"><img src="https://img.icons8.com/ios-filled/50/ffffff/instagram-new.png" alt="Instagram"></a>
        </div>
        <div class="contact-info">
          <div class="contact-info-item">
            <img src="https://img.icons8.com/material-rounded/24/ffffff/phone--v1.png" alt="Telefone">
            +1 234 567 890
          </div>
          <div class="contact-info-item">
            <img src="https://img.icons8.com/material-rounded/24/ffffff/email-open--v1.png" alt="E-mail">
            exemplo@exemplo.com
          </div>
        </div>
        <div class="subscribe">
          <input type="email" class="subscribe-input" placeholder="Digite seu e-mail">
          <button class="subscribe-button">Assinar</button>
        </div>
        <div class="company-info">
          <h3>Sobre Nós</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris at sapien eu justo ultrices feugiat at id quam. Vivamus eu tellus vel ex pretium hendrerit. Phasellus eget vehicula ex, sit amet dictum felis.</p>
        </div>
        <div class="quick-links">
          <h3>Links Rápidos</h3>
          <ul>
            <li><a href="#">Política de Privacidade</a></li>
            <li><a href="#">Termos de Serviço</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Suporte</a></li>
          </ul>
        </div>
        <div class="about-section">
          <h3>Nossa Missão</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris at sapien eu justo ultrices feugiat at id quam. Vivamus eu tellus vel ex pretium hendrerit. Phasellus eget vehicula ex, sit amet dictum felis.</p>
        </div>
        <div class="animal-images">
          <img src="https://placeimg.com/100/100/animals" alt="Animal">
          <img src="https://placeimg.com/100/100/animals" alt="Animal">
          <img src="https://placeimg.com/100/100/animals" alt="Animal">
          <img src="https://placeimg.com/100/100/animals" alt="Animal">
        </div>
      </div>
    </footer>
    <script>
     const themeToggle = document.getElementById('theme-toggle');
      const customizeButton = document.getElementById('customize-button');
      const colorPicker = document.getElementById('color-picker');
      const navbar = document.getElementById('navbar');
      const body = document.body;
      const sidebar = document.getElementById('sidebar');
      const menuButton = document.getElementById('menu-button');
      const closeSidebar = document.getElementById('close-sidebar');
      let customNavbarColor = '#afd4c3'; // Cor padrão da barra de navegação e da barra lateral
      themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-theme');
        themeToggle.classList.toggle('bx-sun');
        // Restaurar a cor personalizada ao alternar entre temas claro e escuro
        if (body.classList.contains('dark-theme')) {
          navbar.style.backgroundColor = '#121212'; // Cor de fundo padrão do tema escuro
          sidebar.style.backgroundColor = '#121212'; // Cor de fundo padrão do tema escuro para a barra lateral
        } else {
          navbar.style.backgroundColor = customNavbarColor; // Restaurar a cor personalizada da barra de navegação
          sidebar.style.backgroundColor = customNavbarColor; // Restaurar a cor personalizada da barra lateral
        }
      });
      customizeButton.addEventListener('click', () => {
        colorPicker.style.display = colorPicker.style.display === 'block' ? 'none' : 'block';
      });
      document.getElementById('navbar-color').addEventListener('input', (event) => {
        customNavbarColor = event.target.value; // Armazenar a cor personalizada
        navbar.style.backgroundColor = customNavbarColor; // Atualizar a cor da barra de navegação
        sidebar.style.backgroundColor = customNavbarColor; // Atualizar a cor da barra lateral
      });
      menuButton.addEventListener('click', () => {
        sidebar.style.left = '0';
        navbar.style.transform = 'translateY(-100%)';
      });
      closeSidebar.addEventListener('click', () => {
        sidebar.style.left = '-250px';
        navbar.style.transform = 'translateY(0)';
      });
    document.getElementById('customize-button').addEventListener('click', function() {
      this.classList.toggle('rotated'); // Adiciona ou remove a classe 'rotated' ao clicar
  });
   document.addEventListener('DOMContentLoaded', function() {
      var conteudo = document.querySelector('.conteudo');
      setTimeout(function() {
        conteudo.classList.add('entrou');
      }, 500); // Ajuste o tempo conforme necessário
    });

// Mostrar o popup
document.getElementById('openPopup').addEventListener('click', function () {
        document.getElementById('popupContainer').style.display = 'flex';
    });

    // Fechar o popup
    document.getElementById('closePopup').addEventListener('click', function () {
        document.getElementById('popupContainer').style.display = 'none';
    });
    </script>

    
</body>
</html>