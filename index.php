<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GYM MYSTER</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <img  src="" width="100px">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      <body class="fundo-academia">
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Alunos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?page=cadastrar-aluno">Cadastrar</a></li>
            <li><a class="dropdown-item" href="?page=listar-aluno">Listar</a></li>
          </ul>
        </li>

      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            planos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?page=cadastrar-planos">Cadastrar</a></li>
            <li><a class="dropdown-item" href="?page=listar-planos">Listar</a></li>
          </ul>
        </li>

              <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Matriculas
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?page=cadastrar-matriculas">Cadastrar</a></li>
            <li><a class="dropdown-item" href="?page=listar-matriculas">Listar</a></li?page=listar-aluno>
          </ul>
        </li>

        
        </li>

      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>


	<div class="container mt-3">
		<div class="row">
			<div class="col">
				<?php
          include('config.php');

					switch (@$_REQUEST['page']) {

            // aluno
						case 'cadastrar-aluno':
							include('cadastrar-aluno.php');
							break;

              case 'listar-aluno':
              include('listar-aluno.php');
              break;

              case 'editar-aluno':
              include('editar-aluno.php');
              break;
						
              case 'salvar-aluno':
              include('salvar-aluno.php');
              break;

              // planos
            case 'cadastrar-planos':
              include('cadastrar-planos.php');
              break;

              case 'listar-planos':
              include('listar-planos.php');
              break;

              case 'editar-planos':
              include('editar-planos.php');
              break;
            
              case 'salvar-planos':
              include('salvar-planos.php');
              break;

            // matriculas
            case 'cadastrar-matriculas':
              include('cadastrar-matriculas.php');
              break;

              case 'listar-matriculas':
              include('listar-matriculas.php');
              break;

              case 'editar-matriculas':
              include('editar-matriculas.php');
              break;
            
              case 'salvar-matriculas':
              include('salvar-matriculas.php');
              break;


						default:
							print "<h1>Seja Bem Vindo ao Sistema da GYM MYSTER</h1>";
							break;
					}

					?>
			</div>
		</div>
	</div>

	<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>