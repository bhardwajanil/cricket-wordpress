/**
  * Angular JS File Version: 2.0.0
  */


if(typeof(RCACONFIG) === 'undefined'){
  RCACONFIG = {
    'templateUrl': '../views/',
    'ajaxUrl': '/api/',
  };  
}


var app = angular.module('rcaCricket', ['ngAnimate'])

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


  RCAAPI.prototype.getSeason = function(key, sec){
    var def = $q.defer();
    $http({
      url: RCACONFIG.ajaxUrl,
      method: "POST",
      params: {
        'key': key,
        'sec': sec,
        'action': 'rcaseasons'
      }
    })

    .success(function(data, status, headers, config){
      if(data && data.data && data.data.season){
        def.resolve(data.data.season);
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
        url: RCACONFIG.ajaxUrl,
        method: "POST",
        params: {
          'key' : key,
          'sec': sec,
          'action': 'rcarecentmatch'
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
      'sec': '@',
      'pageView': '@'
    },

    controller: function($scope, $sce, $element, $attrs, appConfig, $timeout) {
      $scope.dataStatus = 'loading'; //'ready', 'error'
      $scope.match = null;
      $scope.activeView = null;
      $scope.activeTeamInnings = null;
      $scope.ballComment  = null;
      $scope.appConfig = appConfig;


      function onMatchUpdate(match)
      {
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

        if(Math.abs(mDate.diff(moment(), 'minutes')) < 1){
          match.start_date.starts_in = 'Just Now';        
        }

        match.allInnings = {};
        if(match.batting_order.length > 1) {
            for(var i=0, b=null; b=match.batting_order[i]; i++){
              var k = b[0] + '_' + b[1];
              match.allInnings[k] = match.innings[k];
              match.allInnings[k].teamKey = b[0];
              match.allInnings[k].inningsNumber = b[1];
            }
        } else if(match.batting_order != "" && match.now.batting_team != "") {
            var ki = match.now.batting_team + '_' + match.now.innings;
            match.allInnings[ki] = match.innings[ki];
            match.allInnings[ki].teamKey = match.now.batting_team;
            match.allInnings[ki].inningsNumber = match.now.innings;
            
            var ka = match.now.bowling_team + '_' + match.now.innings;
            match.allInnings[ka] = match.innings[ka];
            match.allInnings[ka].teamKey = match.now.bowling_team;
            match.allInnings[ka].inningsNumber = match.now.innings;
        }


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


        if(match.status == "started") {
          if(match.now.batting_team == "b") {
            match.selectedScorecardTab = "1";
          } else {
            match.selectedScorecardTab = "0";
          }  
        } else if(match.status == "completed") {
          if(match.winner_team == "b") {
            match.selectedScorecardTab = "1";
          } else {
            match.selectedScorecardTab = "0";
          }
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


        // Code the balltype
        if( (match.status == "started") && (match.now.recent_overs_str != "") ) {
          match.balltypes = {};
          for (var i = match.now.recent_overs_str[0][1].length-1; i >= 0; i--) {
            match.balltypes[i] = match.now.recent_overs_str[0][1][i];

            if(match.balltypes[i] == "e1,wd") {
              match.balltypes[i] = "1 wd";
            } else if(match.balltypes[i] == "e2,wd") {
              match.balltypes[i] = "2wd";
            } else if(match.balltypes[i] == "e3,wd") {
              match.balltypes[i] = "3wd";
            } else if(match.balltypes[i] == "b4;e1,nb") {
              match.balltypes[i] = "4 & 1nb";
            } else if(match.balltypes[i] == "e4,lb") {
              match.balltypes[i] = "4 & 1nb";
            } else if(match.balltypes[i] == "b4;e1,nb") {
              match.balltypes[i] = "4 lb";
            } else if(match.balltypes[i] == "e1,lb") { 
              match.balltypes[i] = "1 lb";
            } else if(match.balltypes[i] == "b") {
              match.balltypes[i] = "";
            } else if(match.balltypes[i] == "r") {
              match.balltypes[i] = "";
            } else if(match.balltypes[i] == "r1;w") {
              match.balltypes[i] = "1 & W";
            } else if(match.balltypes[i] == "r1;e1,nb") {
              match.balltypes[i] = "1 & 1 nb";
            } else if(match.balltypes[i] == "r0") {
              match.balltypes[i] = "0";
            } else if(match.balltypes[i] == "r1") {
              match.balltypes[i] = "1";
            } else if(match.balltypes[i] == "r2") {
              match.balltypes[i] = "2";
            } else if(match.balltypes[i] == "r3") {
              match.balltypes[i] = "3";
            } else if(match.balltypes[i] == "b4") {
              match.balltypes[i] = "4";
            } else if(match.balltypes[i] == "b6") {
              match.balltypes[i] = "6";
            }
          }        
        }


        //Current Bowler Information
        if(match.now.bowler != null) {
          var bowlerInfo = match.players[match.now.bowler].match.innings[match.now.innings].bowling;
          match.BowlerScoreString = bowlerInfo.runs+"/"+bowlerInfo.wickets+" in "+bowlerInfo.overs;  
        }

        //Append the Bow Comment as HTML
        $scope.ballComment = $sce.trustAsHtml(match.now.last_ball.comment);

        //Required Score string
        if(match.now.req != "") {
          match.RequiredScoreStr = "Required "+match.now.req.runs+" runs in "+match.now.req.balls+" balls";  
        }

        if(match.msgs.match_comments != "") {
          match.Msgs = match.msgs.match_comments;
        }


        //Man of match Information
        if(match.innings != "" && match.man_of_match != "") {
            var manOfMatch = match.players[match.man_of_match];
            match.manOfMatchBowlerInnings = manOfMatch.match.innings[match.now.innings].bowling;
            if(match.manOfMatchBowlerInnings != "") {
              match.manOfMatchWickets = match.manOfMatchBowlerInnings.runs+"/"+match.manOfMatchBowlerInnings.wickets+" ("+match.manOfMatchBowlerInnings.overs+") ";  
            } else {
              match.manOfMatchWickets = "Nil";
            }        

            match.manOfMatchBatsmanInnings = manOfMatch.match.innings[match.now.innings].batting;
            if(match.manOfMatchBatsmanInnings != "") {
              match.manOfMatchRuns    = match.manOfMatchBatsmanInnings.runs+"("+match.manOfMatchBatsmanInnings.balls+")";
              match.manOfMatchBoundaries  = match.manOfMatchBatsmanInnings.fours+"x4 "+match.manOfMatchBatsmanInnings.sixes+"x6";  
            } else {
              match.manOfMatchRuns    = "Nil";
              match.manOfMatchBoundaries    = "Nil";
            }
        }
        

        if(match.winner_team){
          match.loser_team = (match.winner_team == 'a')?'b':'a';
        }


        $scope.dataStatus = 'ready';          
        D = match;
        // console.log(D);

        var timeoutValue = 10;
        if(match.status == "started") {
          timeoutValue = 1;
        }

          $timeout(function(){
            rcaAPI.getMatch($scope.rcaCricketMatch, 
              $scope.sec).then(onMatchUpdate);
          }, 1000 * timeoutValue);

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


app.directive('rcaSeasonMatches', function(rcaAPI){
  return {
    restrict: 'EA',
    replace: true,
    templateUrl: RCACONFIG.templateUrl + 'rca-cricket-season-matches.html',
    scope: {
      'sec': '@',
      'pageView': '@',
      'rcaSeasonMatches': '@'
    },

    controller: function($scope, $element, $attrs, appConfig, $timeout) {
      $scope.dataStatus = 'loading'; //'ready', 'error'
      $scope.season = null;
      $scope.appConfig = appConfig;


      function onSeasonUpdate(season){
        $scope.season = season;
        season.allMatches = {};
        season.liveMatches = {};
        season.offMatches = {};

        var i=0;
        for(var match in season.matches) {
          
          season.allMatches[i] = season.matches[match];

          var mDate     = moment(season.matches[match].start_date.iso);
          var oDate     = moment(season.matches[match].start_date.iso).format("Do MMM YYYY");
          var dateStr   = mDate.format("ddd Do MMM YYYY, h:mm a");          
          var deltaDays = Math.abs(mDate.diff(moment(), 'days'));

          season.allMatches[i].start_date.show_cal  = dateStr;
          season.allMatches[i].start_date.show_date = oDate;
          season.allMatches[i].start_date.starts_in = mDate.fromNow(true);          

          if(Math.abs(mDate.diff(moment(), 'minutes')) < 1){
            season.allMatches[i].start_date.starts_in = 'Just Now';        
          }

          i++;
        }

        $scope.dataStatus = 'ready';
        // console.log(season);

        $timeout(function(){
          rcaAPI.getSeason($scope.rcaSeasonMatches, 
            $scope.sec).then(onSeasonUpdate);
        }, 1000 * 1);
      }

      rcaAPI.getSeason($scope.rcaSeasonMatches, $scope.sec).then(
        onSeasonUpdate,
        function(er){
          $scope.dataStatus = 'error';
        }
      );

    }

  }
});


app.directive('rcaRecentMatches', function(rcaAPI){
  return {
    restrict: 'EA',
    replace: true,
    templateUrl: RCACONFIG.templateUrl + 'rca-cricket-recent-match.html',
    scope: {
      'sec': '@',
      'pageView': '@',
      'rcaRecentMatches': '@'
    },

    controller: function($scope, $element, $attrs, appConfig, $timeout) {
      $scope.dataStatus = 'loading'; //'ready', 'error'
      $scope.recent = null;
      $scope.appConfig = appConfig;


      function onRecentUpdate(recent){
        $scope.recent = recent;

        recent.matchKeys = {};
        for (var i = 0; i < recent.length; i++) {
          recent.matchKeys[i] = recent[i].key;
        }

        $scope.dataStatus = 'ready';          
        // D = recent;
        // console.log(D);

       
        $timeout(function(){
          rcaAPI.getRecentMatch($scope.rcaRecentMatches, 
            $scope.sec).then(onRecentUpdate);
        }, 1000 * 2);
      }

      rcaAPI.getRecentMatch($scope.rcaRecentMatches, $scope.sec).then(
        onRecentUpdate,
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