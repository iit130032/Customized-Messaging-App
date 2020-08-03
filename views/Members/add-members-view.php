<!DOCTYPE html>
<html ng-app = "templeApp">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Members</title>

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
    <script type="text/javascript" src="../../scripts/views/app/members.js"></script>
    <script type="text/javascript" src="../../scripts/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/datatables-bulma@1.0.1/js/dataTables.bulma.min.js"></script>
   
  </head>
  
  <body>
        <?php include_once '../Shared/header.php';?>

        <section class="section">
            <div ng-controller="MembersController">

                <div class="container">
                    <div id="ViewSection">
                        <div class="columns">
                            <div class="column is-one-quarter">
                                <h1 class="title"> See your members. </h1> 
                            </div>
                            <div class="column">
                                <button class="button is-link" type="button" id="addMembers">Add New Member</button> 
                            </div>
                        </div>
                               
                       <div class="columns">
                            <div class="column">
                                <table class ="table is-hoverable is-striped" style="width:100%" id="tblMembers" ng-init=loadMembers();>
                                    <thead>
                                        <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Contact Name</th>
                                        <th>Full Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        
                                        </tr>
                                    </thead>
                            
                                </table>
                            </div>
                       </div>
                       
                    </div> 
                </div>

                <div class="container"> 
                    <div id="EditSection">
                        <h1 class="title">Let's add a member..!!</h1>
                        <form class="form-signin" id="formSaveMember">
                            <div class="columns">
                                <div class="column is-half">
                                    <div class="columns is-mobile">
                                        <div class="column is-one-fifth">
                                            <div class="field">
                                                <label class="label">Title</label>
                                                <div class="control">
                                                    <div class="select is-info is-rounded">
                                                        <select id="title" name="title" ng-model="Member.Title">
                                                        <option ng-repeat="title in TitleList" ng-value="title">{{title}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="column">
                                            <div class="field">
                                                <label class="label">Contact Name</label>
                                                <div class="control has-icons-left">
                                                    <input class="input is-info is-rounded" name="contactName" id="contactName" type="text" autocomplete="contactName" placeholder="Name to contact" ng-model="Member.ContactName">
                                                        <span class="icon is-small is-left"> <i class="fas fa-user"></i></span>
                                                </div>
                                                <p class="help is-info">Messages will address to : {{Member.ContactName}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="field">
                                        <label class="label">Full Name</label>
                                        <div class="control has-icons-left">
                                            <input class="input is-info is-rounded" name="fullName" id="fullName" type="text" autocomplete="fullName" placeholder="Full Name" ng-model="Member.FullName">
                                            <span class="icon is-small is-left"> <i class="fas fa-user"></i></span>
                                        </div>   
                                    </div>

                                    <div class="field">
                                        <label class="label">Contact Mobile No</label>
                                        <div class="control has-icons-left">
                                        <input class="input is-info is-rounded" name="contactMobile" id="contactMobile" type="tele" autocomplete="contactMobile" placeholder="Mobile No to contact" ng-model="Member.ContactMobile">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        </div>
                                        <p class="help is-info">Messages will be sent to : {{Member.ContactMobile}} </p>
                                    </div>

                                    <div class="field">
                                        <label class="label">Contact Address</label>
                                        <div class="control has-icons-left">
                                        <textarea class="textarea is-info is-rounded" name="contactAddress" id="contactAddress" type="text" autocomplete="contactAddress" placeholder="Address to contact" ng-model="Member.ContactAddress"></textarea>
                                        </div>
                                    
                                    </div>
                                    <br> <br> <br> <br>

                                    <div class="field">
                                        <div class="control">
                                            <button class="button is-primary" type="button" ng-click="saveMembers();">Save</button>
                                            <button class="button" type="button" ng-click="resetForm();" >Clear</button>
                                            <button class="button is-link" type="button" id="viewMembers">View Members</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="column is-half">
                                    <div class="field">
                                        <label class="label">Email</label>
                                        <div class="control has-icons-left">
                                        <input class="input is-info is-rounded" name="email" type="email" placeholder="Email" ng-model="Member.Email">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>

                                    <br>
                                    <div class="field">
                                        <div class="control">
                                            <label class="checkbox label"> <input type="checkbox" id='chkScheduleSMS' ng-model="Member.IsSheduleSMS"> &nbsp;Schedule SMS</label>
                                        </div>
                                    
                                    </div>
                                

                                    <div id='pnlScheduleSMS' style="overflow: scroll; height:684px; width: 640px" ng-show="Member.IsSheduleSMS">
                                        <div class="columns">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Description</th>
                                                        <th>Date</th>
                                                        <th>One Time</th>
                                                        <th><a href="#" ng-click="addConPerRow()"><i class="fas fa-plus"></i></a></th>
                                                        <!-- <th><button class="button" type="button" ng-click="addConPerRow()" >Add</button></th> -->
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="c in Member.ContactPersons">
                                                        <td>
                                                            <input class="input is-info is-rounded" type="text" ng-model="c.Description" name="Description_{{c.Id}}" placeholer ="description" /> 
                                                        </td>
                                                        <td>
                                                        
                                                            <input type="text" class="input is-info is-rounded scheduleDatePicker" ng-model="c.Date" id="Date_{{c.Id}}" />

                                                        </td>

                                                        <td>
                                                            <input type="checkbox" ng-model="c.IsOneTime" name="IsOneTime_{{c.Id}}">
                                                        </td>
                                                        
                                                        <td>
                                                            <div ng-if="c.IsDelBtn">
                                                            <span><a href="#" ng-click="removeConPerRow(c.Id)"><i class="fa fa-trash" aria-hidden="true"></i></a></span>
                                                            <!-- <button class="button" type="button" ng-click="removeConPerRow(c.Id)" >Remove</button> -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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