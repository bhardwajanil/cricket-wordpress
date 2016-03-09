if(typeof(RCACONFIG) === 'undefined'){
  RCACONFIG = {
    'templateUrl': '../views/',
    'ajaxUrl': '/api/',
  };  
}


var app = angular.module('rcaCricket', [
  'ngAnimate'
])

.constant('appConfig', {
  path: {
    img: 'http://img.litzscore.com/',
  },
  cricket: {
    possibleInnings: ['1', '2', '9'],
    possibleTeams: ['a', 'b'],
  }
})

.service('rcaAPI', function($q, $http){
  
  var RCAAPI = function(){

  };

  RCAAPI.prototype.getMatch = function(key, sec){
    var def = $q.defer();
    $http({
      url: RCACONFIG.ajaxUrl,// + '/?action=rcamatch',
      method: "POST",
      params: {
        'action': 'rcamatch',
        'key': key,
        'sec': sec
      }
    })
    .success(function(data, status, headers, config){
      if(data && data.data && data.data.card){
        def.resolve(data.data.card);
      }else{
        def.reject(data, status);
      }
    })
    .error(function(data, status, headers, config){
      def.reject(data, status);
    });

    return def.promise;
  };

  RCAAPI.prototype.getRecentMatch = function(key, sec){
    var def = $q.defer();
      $http({
        url: RCACONFIG.ajaxUrl,// + '/?action=rcarecentmatch',
        method: "POST",
        params: {
          'action': 'rcarecentmatch',
          'key' : key,
          'sec': sec
        }
      })
      .success(function(data, status, headers, config){
        if(data && data.data && data.data.cards){
          def.resolve(data.data.cards);
        }else{
          def.reject(data, status);
        }
      })
      .error(function(data, status, headers, config){
        def.reject(data, status);
      });

      return def.promise;
  };
  return new RCAAPI();
})

app.directive('rcaCricketMatch', function(rcaAPI){
  return {
    restrict: 'EA',
    replace: true,
    templateUrl: RCACONFIG.templateUrl + 'rca-cricket-match.html',
    scope: {
      'rcaCricketMatch': '@',
      'sec': '@'
    },

    controller: function($scope, $element, $attrs, appConfig, $timeout) {
      $scope.dataStatus = 'loading'; //'ready', 'error'
      $scope.match = null;
      $scope.activeView = null;
      $scope.activeTeamInnings = null;
      $scope.appConfig = appConfig;

      $scope.teamFlagUrl = function(key){
        if(RCACONFIG['flags'] && RCACONFIG.flags[key]){
          return RCACONFIG.flags[key];
        }else{
          return 'http://img.litzscore.com/flags/' + key + '_s.png'
        }
      }

      function onMatchUpdate(match){

        $scope.match = match;
        
        var mDate = moment.unix(match.start_date.timestamp);
        var deltaDays = Math.abs(mDate.diff(moment(), 'days'));
        var dateStr = mDate.format("ddd Do MMM YYYY, h:mm a");
        var oDate = moment.unix(match.start_date.timestamp).format("Do MMM YYYY");
        
        // if( deltaDays < 7 ){
        //   dateStr = mDate.calendar();
        // }

        match.start_date.show_cal = dateStr;
        match.start_date.starts_in = mDate.fromNow(true);
        match.start_date.show_date = oDate;

        var manofMatch = match.man_of_match;
        match.manofMatch = manofMatch;

        if(Math.abs(mDate.diff(moment(), 'minutes')) < 1){
          match.start_date.starts_in = 'Just Now';        
        }

        if(match.winner_team){
          match.loser_team = (match.winner_team == 'a')?'b':'a';
        }

        match.allInnings = {};
        for(var i=0, b=null; b=match.batting_order[i]; i++){
          var k = b[0] + '_' + b[1];
          match.allInnings[k] = match.innings[k];
          match.allInnings[k].teamKey = b[0];
          match.allInnings[k].inningsNumber = b[1];
        }

        // Team X Bench Players
        var teamXPlayers = match.teams['a'].match.players;
        var teamXPlaying = match.teams['a'].match.playing_xi;
        if(teamXPlaying == null) {
          var teamXSubstitute = teamXPlayers;
        } else {
          var teamXSubstitute = teamXPlayers.filter(function(obj) { return teamXPlaying.indexOf(obj) == -1; });
        }
        match.teams['a'].match.benchPlayers = teamXSubstitute;
        match.benchXPlayersCount = teamXSubstitute.length;

        // Team Y Bench Players
        var teamYPlayers = match.teams['b'].match.players;
        var teamYPlaying = match.teams['b'].match.playing_xi;
        if(teamYPlaying == null) {
          var teamYSubstitute = teamYPlayers;
        } else {
          var teamYSubstitute = teamYPlayers.filter(function(obj) { return teamYPlaying.indexOf(obj) == -1; });
        }        
        match.teams['b'].match.benchPlayers = teamYSubstitute;
        match.benchYPlayersCount = teamYSubstitute.length;


        if(!($scope.activeView) && match.batting_order.length > 0){
          $scope.activeView = 'scorecard';
        }else if(!$scope.activeView){
          $scope.activeView = 'teams';
        }

        if(!($scope.activeTeam) && match.teams['a']){
          $scope.activeTeam = 'team_0';
        }else if(!$scope.activeTeam){
          $scope.activeTeam = 'team_1';
        }

        $scope.dataStatus = 'ready';          
        D = match;
        console.log(D);

        $timeout(function(){
          rcaAPI.getMatch($scope.rcaCricketMatch, 
            $scope.sec).then(onMatchUpdate);
        }, 1000 * 1);


      }

      rcaAPI.getMatch($scope.rcaCricketMatch, $scope.sec).then(
        onMatchUpdate,
        function(er){
          $scope.dataStatus = 'error';
        }
      );

    }

  }
});

app.directive('rcaCricketRecentMatch', function(rcaAPI){
  return {
    restrict: 'EA',
    replace: true,
    templateUrl: RCACONFIG.templateUrl + 'rca-cricket-recent-match.html',
    scope: {
      'rcaCricketRecentMatch': '@',
      'sec': '@'
    },

    controller: function($scope, $element, $attrs, appConfig, $timeout) {
      $scope.dataStatus = 'loading'; //'ready', 'error'
      $scope.match = null;
      $scope.activeView = null;
      $scope.appConfig = appConfig;

      $scope.teamFlagUrl = function(key){
        if(RCACONFIG['flags'] && RCACONFIG.flags[key]){
          return RCACONFIG.flags[key];
        }else{
          return 'http://img.litzscore.com/flags/' + key + '_s.png'
        }
      }


      function onMatchUpdate(match){

        $scope.match = match;
        

        var mDate = moment.unix(match.start_date.timestamp);
        var deltaDays = Math.abs(mDate.diff(moment(), 'days'));
        var dateStr = mDate.format("dddd, MMMM Do YYYY, h:mm:ss a");
        
        if( deltaDays < 7 ){
          dateStr = mDate.calendar();
        }

        match.start_date.show_cal = dateStr;
        match.start_date.starts_in = mDate.fromNow();

        if(Math.abs(mDate.diff(moment(), 'minutes')) < 2){
          match.start_date.starts_in = 'Now';        
        }

        if(match.winner_team){
          match.loser_team = (match.winner_team == 'a')?'b':'a';
        }


        match.allInnings = {};
        for(var i=0, b=null; b=match.batting_order[i]; i++){
          var k = b[0] + '_' + b[1];
          match.allInnings[k] = match.innings[k];
          match.allInnings[k].teamKey = b[0];
          match.allInnings[k].inningsNumber = b[1];
        }

        if(!($scope.activeView) && match.batting_order.length > 0){
          $scope.activeView = 'scorecard';
        }else if(!$scope.activeView){
          $scope.activeView = 'overview';
        }

        $scope.dataStatus = 'ready';          
        D = match;
        console.log(D);

        $timeout(function(){
          rcaAPI.getRecentMatch($scope.rcaCricketRecentMatch, 
            $scope.sec).then(onMatchUpdate);
        }, 1000 * 30);
      }

      rcaAPI.getRecentMatch($scope.rcaCricketRecentMatch, $scope.sec).then(
        onMatchUpdate,
        function(er){
          $scope.dataStatus = 'error';
        }
      );
    }
  }
});


function showTab(event) {
  var sourceParent = event.parentElement.parentElement;
  var sourceChilds = sourceParent.getElementsByClassName("rca-tab-content");
  var sourceLinkParent = sourceParent.getElementsByClassName("rca-tab-link");
  for (var i=0; i < sourceChilds.length; i++) {
    sourceChilds.item(i).className = 'rca-padding rca-tab-content';
  }
  for (var i=0; i < sourceLinkParent.length; i++) {
    sourceLinkParent.item(i).className = 'rca-tab-link';
  }
  var dataTab= event.getAttribute("data-tab");
  var tabClass = document.getElementById(dataTab).className;

  event.className = 'rca-tab-link active';
  document.getElementsByClassName('score-details').className = tabClass;
  document.getElementById(dataTab).className = tabClass + ' active';
}