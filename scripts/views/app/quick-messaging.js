
templeApp.controller('quickMessagingController',['$scope', '$http','$window',function($scope,$http,$window){

    $scope.fileName = "";
    $scope.message = "";
    $scope.messageLengthDisplayText = "";
    $scope.maxMessageCharLength = 30; //temporary hard coded
    $scope.remainingChars = $scope.maxMessageCharLength;

    angular.element('#phoneNo-upload').change(function() {
        var file = $('#phoneNo-upload')[0].files[0].name;
        $scope.fileName = file;
        $scope.$apply();
    });

    $scope.setRemainingChars = function(){
        $scope.remainingChars = $scope.maxMessageCharLength - $scope.message.length;
       
        if($scope.remainingChars <= 0) {
            $scope.messageLengthDisplayText = $scope.maxMessageCharLength + ' character limit reached.';
        } else {
            $scope.messageLengthDisplayText =  'character limit :' +  $scope.maxMessageCharLength + '. ' + $scope.remainingChars + 'remaining.';
        }
    };

}]);