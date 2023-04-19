<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <title>Colabora</title>
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
  />
  </head>
      <!-- Header -->
  <body>

    <nav class="navbar" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href="index.html">
          <img src="img/Ativo 1 black.png" style="max-height: 3.75rem">
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
          <a class="navbar-item" href="#">Início</a>
          <a class="navbar-item" href="#">Produtos</a>
          <a class="navbar-item" href="#">Contato</a>
          <a class="navbar-item" href="#">FAQ</a>
        </div>

        <div class="navbar-end">
          <div class="navbar-item">
            <form action="#" method="GET">
              <div class="field has-addons">
                <div class="control">
                  <input class="input" type="text" placeholder="Pesquisar...">
                </div>
                <div class="control">
                  <button class="button is-info" style="background-color: #00d1b2;">Buscar</button>
                </div>
              </div>
            </form>
          </div>
        <div class="navbar-end">
          <div class="navbar-item">
            <div class="buttons">
              <a href="#" class="button is-primary is-rounded">Cadraste-se</a>
              <a href="#" class="button is-primary is-rounded button is-light"onclick="document.getElementById('singIn').style.display='block'">Entrar</a>
    <!-- box de login  -->
    <div id="singIn" class="modal">
      <div class=" is-justify-content-center mt-5">
        <div class="columns is-centered">
          <div class="column is-half">
            <div class="box">
              <h1 class="title has-text-centered">Login</h1>
              <form>
                <div class="field">
                  <label class="label">Email</label>
                  <div class="control">
                    <input class="input" type="email" placeholder="exemplo@exemplo.com">
                  </div>
                </div>
      
                <div class="field">
                  <label class="label">Senha</label>
                  <div class="control">
                    
                    <input class="input" id="senha"type="password" placeholder="********" >
                 
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </div>
                  
                </div>
      
                <div class="field">
                  <div class="control">
                    <button class="button is-link is-fullwidth">Entrar</button>
                  </div>
                </div>
      
                <div class="field">
                  <div class="control">
                    <a href="#">Não consigo entrar</a>
                  </div>
                </div>
              </form>
              <button type="button" onclick="document.getElementById('singIn').style.display='none'" class="button is-info">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
      
      </div>
    <!-- fim do box login -->
            </div>
          </div>
        </div>

        </div>
      </div>
    </nav>
    <!-- Cadastro -->
    <section class="section">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-half">
            <h2 class="title is-2 has-text-centered">Cadastre-se</h2>
            <form class="container mx-auto py-8" method="POST" action="register">
                <div class="field">
                  <label class="label">Nome completo</label>
                  <div class="control">
                    <input name="nome" class="input" type="text" placeholder="Seu nome completo">
                  </div>
                </div>
              
                <div class="field">
                  <label class="label">E-mail</label>
                  <div class="control">
                    <input name="email" class="input" type="email" placeholder="Seu endereço de e-mail">
                  </div>
                </div>
              
                <div class="field">
                  <label class="label">CPF</label>
                  <div class="control">
                    <input name="cpf" class="input" type="text" placeholder="Seu CPF">
                  </div>
                </div>
              
                <div class="field">
                  <label class="label">Telefone</label>
                  <div class="control">
                    <input name="telefone" class="input" type="tel" placeholder="Seu telefone">
                  </div>
                </div>
              
                <div class="field">
                  <label class="label">Endereço ou localidade</label>
                  <div class="control">
                    <input name="endereco" class="input" type="text" placeholder="Seu endereço ou localidade">
                  </div>
                </div>
              
                <div class="field">
                  <label class="label">CEP</label>
                  <div class="control">
                    <input nome="cep" class="input" type="text" placeholder="Seu CEP">
                  </div>
                </div>
              
                <div class="field">
                  <label class="label">Cidade</label>
                  <div class="control">
                    <input nome="cid" class="input" type="text" placeholder="Sua cidade">
                  </div>
                </div>
              
                <div class="field">
                  <label class="label">Senha</label>
                  <div class="control">
                    <input name="senha" class="input" id="senha3"type="password" placeholder="Sua senha">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </div>
                </div>
              
                <div class="field">
                  <label class="label">Confirmar senha</label>
                  <div class="control">
                    <input  class="input" id="senha2" type="password" placeholder="Confirme sua senha">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </div>
                </div>
              
                <div class="field">
                  <div class="control">
                    <button type="submit" class="button is-primary">
                      Cadastrar
                    </button>
                  </div>
                </div>
              </form>
          </div>
        </div>
      </div>
    </section>
            
            </body>  
            <footer>
              <div class="estilo-footer">
                  <div class="row-footer">
                      <br>
                      <small>&copy;UEPA2022</small>
                      <br><br>
                  </div>
              </div>
      
          </footer>
    <script src="script.js"></script>
    <script> 
      let btn = document.querySelector('.fa-eye')
    
    btn.addEventListener('click', ()=>{
      let inputSenha = document.querySelector('#senha')
      
      if(inputSenha.getAttribute('type') == 'password'){
        inputSenha.setAttribute('type', 'text')
      } else {
        inputSenha.setAttribute('type', 'password')
      }
    })
    
//     function verSenha(inputSenha) {
//     if (inputSenha.getAttribute('type') === 'password') {
//       inputSenha.setAttribute('type', 'text');
//     } else {
//       inputSenha.setAttribute('type', 'password');
//     }
//   }
//   const btn = document.querySelector('.fa-eye');
//   const inputSenha1 = document.querySelector('#senha1');
//   const inputSenha2 = document.querySelector('#senha2');
//   const inputSenha3 = document.querySelector('#senha3');
  
//   btn.addEventListener('click', () => {
//     verSenha(inputSenha1);
//     verSenha(inputSenha2);
//     verSenha(inputSenha3);
//   });
      </script>
    </html>
               