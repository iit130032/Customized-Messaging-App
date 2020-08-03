<!DOCTYPE html>
<html ng-app = "templeApp">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instant Messaging</title>

    <link rel="stylesheet" href="../../styles/bulma.min.css">
    <link rel="stylesheet" href="../../styles/sweetalert2.min.css">
    <link rel="stylesheet" href="../../styles/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables-bulma@1.0.1/css/dataTables.bulma.min.css">
    <link rel="stylesheet" href="../../styles/datatables.min.css">

    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script type="text/javascript" src="../../scripts/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../../scripts/jquery.min.js"></script>
    <script type="text/javascript" src="../../scripts/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../../scripts/angular.min.js"></script>
    <script type="text/javascript" src="../../scripts/views/app/app.js"></script>
    <script type="text/javascript" src="../../scripts/views/app/common.js"></script>
    <script type="text/javascript" src="../../scripts/views/app/quick-messaging.js"></script>
    <script type="text/javascript" src="../../scripts/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/datatables-bulma@1.0.1/js/dataTables.bulma.min.js"></script>
   
  </head>
  
  <body>
        <?php include_once '../Shared/header.php';?>

        <section class="section">
            <div ng-controller ='quickMessagingController'>
                <div class="container"> 
                    <div id="EditSection">
                        <h1 class="title">Instant Messaging</h1>
                        <br> <br> 
                        <form class="form-signin" id="formSendQuickMessage">
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <div class="file is-primary has-name">
                                            <label class="file-label">
                                                <input class="file-input" type="file" id="phoneNo-upload" name="phoneNo-upload" accept=".csv" >
                                                    <span class="file-cta">
                                                        <span class="file-icon"> <i class="fas fa-upload"></i></span>
                                                        <span class="file-label">Upload Phone Numbers..</span>
                                                    </span>
                                                    <span class="file-name">{{fileName}}</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Message</label>
                                        <div class="control has-icons-left">
                                            <textarea class="textarea is-info is-rounded" name="message" id="message" type="text" ng-model="message" maxlength="{{maxMessageCharLength}}" ng-trim="false" ng-keyup="setRemainingChars();" autocomplete="message" placeholder="Place your message here"></textarea>
                                        </div>
                                        <p class="help is-info">{{messageLengthDisplayText}}</p>
                                    </div>

                                    <br> <br> <br> <br>

                                    <div class="field">
                                        <div class="control">
                                            <button class="button" type="button">Clear</button>
                                            <button class="button is-link" type="button" id="viewMembers">XXX</button>
                                            <button class="button is-primary" type="button">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </form>
                    </div> 
                </div>

            </div>

        </section>
            <?php include_once '../Shared/footer.php';?>
    </body>
</html>