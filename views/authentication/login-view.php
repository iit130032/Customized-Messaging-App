<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="../../styles/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="../../scripts/views/authentication/login.js" ></script>  
  </head>
  
  <body>
    <section class="section">
      <div class="container">
        <h1 class="title">
          Please Log In to continue...
        </h1>
        <p class="subtitle">
          My first website with <strong>Bulma</strong>!
        </p>
      </div>
    </section>
    <section class="section">
      <div class="container">
          <div class="columns is-centered">
            <div class="column is-half">
              <form class="form-signin" method="post" action="../../BusinessLogic/Authentication/login.php">
                <div class="field">
                  <label class="label">Username</label>
                  <div class="control has-icons-left">
                    <input class="input is-info is-rounded" name="username" type="text" placeholder="User Name">
                    <span class="icon is-small is-left">
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Password</label>
                  <div class="control has-icons-left">
                    <input class="input is-info is-rounded" name="password" type="password" placeholder="Password">
                    <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                    </span>             
                  </div>
                </div>

                <div class="field">
                  <div class="control">
                    <button class="button is-primary" type="submit">Log In</button>
                  </div>
                </div>  
             </form>
           </div>          
          </div> 
          <br> <br> <br> <br>
          <div class="columns is-centered">
            <div class ="column is-half">
            <div class="field">
                  <div class="control">
                  <label class="label">No account yet? &nbsp;
                  <button class="button is-link" type="button" onclick="redirectToRegister();">Sign Up</button>
                  </label>
                
                    
                  </div>
                </div> 
            </div>
          </div>
      </div>
   </section>

   <?php include_once '../Shared/footer.php';?>
   
 </body>
</html>