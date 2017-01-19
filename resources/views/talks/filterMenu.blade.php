    <div id='talksNav'>
        <h2 class="line-break">Filter Talks</h2>
        <div id='talks-side-menu'>
            <div ng-repeat="(key,value) in talkCtrl.thisAggregators">
                <input type="checkbox" ng-checked="true"  ng-click="talkCtrl.updateFilterAggregators(value)"> @{{ value }}</input>    
            </div>
            <div ng-repeat="(key,value) in talkCtrl.types">
                <input type="checkbox" inverted data-ng-model='talkCtrl.types[key]'> @{{ key }}
            </div>
        </div>
    </div>    
