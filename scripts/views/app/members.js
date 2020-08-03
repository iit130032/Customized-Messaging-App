var jq = $.noConflict();

templeApp.controller('MembersController',['$scope', '$http','$window',function($scope,$http,$window){

    angular.element(document).ready(function () {
        
        $scope.TitleList = ['Mr','Mrs','Ms','Ven'];

        $scope.Member = {
            Id : -1,
            Title: $scope.TitleList[0],
            ContactName: "",
            FullName: "",
            ContactMobile: "",
            ContactAddress:"",
            Email: "",
            IsSheduleSMS: false,
            ContactPersons: []  
        };

        var viewBtn = jq('#viewMembers');
        var addBtn = jq('#addMembers');
        var chkboxScheduleSMS = jq('#chkScheduleSMS');
        var pnlScheduleSMS = jq('#pnlScheduleSMS');
        var pnlEditMember = jq('#EditSection');
        var pnlViewMember = jq('#ViewSection'); 

        pnlScheduleSMS.hide();
        pnlEditMember.hide();  // hide member edit panel

        chkboxScheduleSMS.change(function() {
            if(this.checked) {
                pnlScheduleSMS.show();
            }
            else{
                pnlScheduleSMS.hide();
            }
        });


        jq('body').on('focus',".scheduleDatePicker", function(){
            jq(this).datepicker({
                changeMonth: true,
                changeYear: true
            });
        });


        viewBtn.on('click', function () {
            $window.location.reload();
            // pnlEditMember.effect( "drop", "slow" );
            // jq('#tblMembers').dataTable().fnClearTable();
            // pnlViewMember.show();
        
        });

        addBtn.on('click', function () {
            $scope.Member = $scope.getNewMember();
            $scope.$apply();
            pnlViewMember.effect( "drop", "slow" );
            pnlEditMember.show();
            
        });

        $scope.getNewMember = function(){
            var newMember = {
                Id: 0,
                Title: $scope.TitleList[0],
                ContactName: "",
                FullName: "",
                ContactMobile: "",
                ContactAddress:"",
                Email: "",
                IsSheduleSMS: false,
                ContactPersons: [] 
            };
    
            return newMember;
    
        } 
       
    });

    



    //load the grid
    $scope.loadMembers = function (){
        var table =  jq('#tblMembers').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "../../../businesslogic/members/view-members.php",
            "columnDefs":[ 
            {
                targets: 6,
                "render": function (data, type, row) {
                    return '<a href="#" class="edit-member"><i class="fa fa-edit"></i></a>';
                
                }
            },
            {
                targets: 7,
                "render": function (data, type, row) {
                    return '<a href="#" class="delete-member"><i class="fa fa-trash"></i></a>';
                }
            },
            
            ],

            "drawCallback": function (settings) {
                jq('a.edit-member').unbind('click');
                jq('a.edit-member').click(function () {
                    var rowData = table.row(jq(this).parents('tr')).data();
                    $scope.SetEditMember(rowData[0]);
                   
                });

                jq('a.delete-member').unbind('click');
                jq('a.delete-member').click(function () {
                    var rowData = table.row(jq(this).parents('tr')).data();
                    $scope.deleteMember(rowData[0]);
                    
                });
            }
        });

    }
    //



    $scope.addConPerRow = function () {
        if ($scope.Member.ContactPersons.length == 1) {
            $scope.Member.ContactPersons[0].IsDelBtn = true;
        }

        var incrementId = $scope.Member.ContactPersons.length + 1;

        var result = jq.grep($scope.Member.ContactPersons, function (e) {
            return e.Id == incrementId;
        });

        incrementId = (result.length > 0) ? incrementId + 1 : incrementId

        var contactPersonEmptyObject = { Id: incrementId, Description: "", Date: "", IsOneTime: true, IsDelBtn: true };
        $scope.Member.ContactPersons.push(contactPersonEmptyObject);

    };

    $scope.removeConPerRow = function (id) {
        var results =  jq.grep($scope.Member.ContactPersons, function (e) {
            return e.Id != id;
        });
        $scope.Member.ContactPersons = results;

        if ($scope.Member.ContactPersons.length == 1) {
            $scope.Member.ContactPersons[0].IsDelBtn = false;
        }
        
    };

    $scope.IsValidMember = function(){
        //TO DO:
            return true;
    }

    $scope.UpdateMember = function(){
        
        $http({
            url: "../../BusinessLogic/Members/update-members.php",
            method: "POST",
            data:  JSON.stringify($scope.Member)
        }).then(function(response) {

            if(response.data.code == 400){
                sweetAlertError('Oops!',response.data.message);
                console.log(response);
            }
            else if(response.data.code == 200){
                sweetAlertSuccess('Good!',response.data.message);
                console.log(response.data.message);
            }
            else{
                console.log(response);
            }
        
        });
    }

    $scope.AddMember = function(){

        $http({
            url: "../../BusinessLogic/Members/add-members.php",
            method: "POST",
            data:  JSON.stringify($scope.Member)
        }).then(function(response) {

        if(response.data.code == 400){
            sweetAlertError('Oops!',response.data.message);
        }
        else if(response.data.code == 200){
            sweetAlertSuccess('Good!',response.data.message);
        }
        else{
            console.log(response.data.message);
        }
        
        });
    }

    $scope.saveMembers = function(){

        if($scope.IsValidMember()==false){
            sweetAlertError('Oops!','Invalid Data Found..!!');
            return false;
        }

        if($scope.Member.Id > 0){
            $scope.UpdateMember();
        }
        else{
            $scope.AddMember();
        }

    }

    $scope.deleteMember= function(memberId){

        sweetAlertConfirm('Delete member','Are you sure you want to permanently delete this member?','Yes.Delete',true,function(){
                    
            $http({
            url: "../../BusinessLogic/Members/delete-members.php",
            method: "POST",
            data:  memberId
            }).then(function(response) {      
                if(response.data.code == 400){
                    sweetAlertError('Oops!','Something went wrong.!');
                    console.log(response.data.message);
                }
                else if(response.data.code == 200){
                    sweetAlertSuccessFromSide('Successfully deleted member');
                    $window.location.reload();
                }
                else{
                    console.log(response.data.message);
                }
            
            });
        
        });
    
    }

    $scope.resetForm = function(){
        $scope.Member = $scope.getNewMember();
        $scope.$apply();
    }

    $scope.SetEditMember = function(memberId){     
        $http({
        url: "../../BusinessLogic/Members/get-members.php",
        method: "POST",
        data:  memberId
        }).then(function(response) {
            if(response.data.code == 200){
                //$scope.SetEditMember(response.data.message);
                $scope.Member = JSON.parse(response.data.message);
                angular.element('#ViewSection').effect( "drop", "slow" );
                angular.element('#EditSection').show();
                angular.element('#pnlScheduleSMS').show();

            }
            else if(response.data.code == 400){
                sweetAlertError('Oops!','Unable to load member.!');
                console.log(response.data.message);
            }
            else{
                console.log(response.data.message);
            }
            
        });       
    }

}]);