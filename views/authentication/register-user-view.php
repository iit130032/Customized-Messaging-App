
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <!-- <link rel="stylesheet" href="../../node_modules\bulma\css\bulma.min.css"> -->
    <link rel="stylesheet" href="../../styles/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script type="text/javascript" src="../../scripts/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../../scripts/jquery.min.js"></script>
    <script type="text/javascript" src="../../scripts/views/authentication/register-user.js"></script>

    <link rel="stylesheet" href="..\..\styles\sweetalert2.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> -->
    
   
  </head>
  <body>
    <section class="section">
      <div class="container">
        <h1 class="title">
          Let's create an account first!
        </h1>
        <p class="subtitle">
          My first website with <strong>Bulma</strong>!
        </p>
      </div>
    </section>
    <section class="section">
      <div class="container">
         
        <form class="form-signin" method="post" action="../../BusinessLogic/Authentication/register.php">
          <div class="columns">
            <div class="column is-half">
              <div class="field">
                <label class="label">Username</label>
                <div class="control has-icons-left">
                  <input class="input is-info is-rounded" name="username" type="text" autocomplete="username" placeholder="User Name">
                  <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                  </span>
                </div>
                <!-- <p class="help is-danger">Oops! This username is already taken!</p> -->
              </div>

              <div class="field">
                <label class="label">Full Name</label>
                <div class="control has-icons-left">
                  <input class="input is-info is-rounded" name="fullName" type="text" autocomplete="fullName" placeholder="Full Name">
                  <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                  </span>
                </div>
                <!-- <p class="help is-danger">Oops! This username is already taken!</p> -->
              </div>

              <div class="field">
                <label class="label">Organization</label>
                <div class="control has-icons-left">
                  <input class="input is-info is-rounded" name="organization" type="text" autocomplete="organization" placeholder="organization">
                  <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                  </span>
                </div>
              </div>

              <div class="field">
                <label class="label">Password</label>
                <div class="control has-icons-left">
                  <input class="input is-info is-rounded" name="password" type="password"  autocomplete="password" placeholder="Password">
                  <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                  </span>             
                </div>
              </div>

              <div class="field">
                <label class="label">Confirm Password</label>
                <div class="control has-icons-left">
                  <input class="input is-info is-rounded" name="verifiedPassword" type="password" autocomplete="verifiedPassword" placeholder="Password">
                  <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                  </span>             
                </div>
                <!-- <p class="help is-danger">Oops! Passwords do not match.</p> -->
              </div>

          </div>
          <div class="column is-half">
              <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                  <input class="input is-info is-rounded" name="email" type="email" placeholder="Email">
                  <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                  
                </div>
                <!-- <p class="help is-danger">This email is invalid</p> -->
              </div>

              <div class="field">
                <label class="label">Mobile No</label>
                <div class="control has-icons-left">
                  <input class="input is-info is-rounded" name="mobile" type="tele" placeholder="mobile">
                  <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                  
                </div>
                <!-- <p class="help is-danger">This email is invalid</p> -->
              </div>

              <div class="field">
                <label class="label">Telephone</label>
                <div class="control has-icons-left">
                  <input class="input is-info is-rounded" name="tele" type="tele" placeholder="tele">
                  <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                  
                </div>
                <!-- <p class="help is-danger">This email is invalid</p> -->
              </div>

              <div class="field">
              <label class="label">User Type</label>
                <div class="control">
                  <label class="radio">
                  <input type="radio" name="userType" value="1">Full Access User</label>
                  <label class="radio">
                  <input type="radio" name="userType" value="2" checked>Quick Access User</label>
                </div>
              </div>

          </div>
        </div>
            <div class="columns">
                <div class="column">
                  <div class="field">
                    <div class="control">
                      <label class="checkbox">
                        <input type="checkbox" id="chkAgree">
                        I agree to the <a href="#">terms and conditions</a>
                      </label>
                    </div>
                  </div>

                  <div class="field">
                    <div class="control">
                      <button class="button is-primary" type="submit" id="registerUser">Sign In</button>
                    </div>
                  </div> 

                </div>
            </div> 
                    
         </form>
             
       </div>
   </section>
   <?php include_once '../Shared/footer.php';?>
 </body>
</html>