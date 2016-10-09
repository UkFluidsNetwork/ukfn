    <div id='talksNav'>
        <h2 class="line-break">{{ $talksMenu['header'] }}</h2>
            <div id='talks-side-menu' class=''>
            @foreach ($talksMenu['talks'] as $menuItem)
                
            <div class='panel panel-default'>
                <a href="/talks/view/{{ $menuItem->id }}" class="list-group-item noborder panel-body">
                    <span class="display-block text-danger">
                        <div class="panel-title line-break-half">{{ $menuItem->title }} </div>
                    </span>
                    <span class="display-block text-muted">
                        <icon class="glyphicon glyphicon-user icon-item-padding display-table-cell"></icon> 
                        <span class="display-table-cell"> {{ $menuItem->speaker }}</span>
                    </span>
                    <span class="display-block text-muted">
                        <icon class="glyphicon glyphicon-time icon-item-padding display-table-cell"></icon> 
                        <span class="display-table-cell">{{ $menuItem->when }}</span>
                    </span>
                    <span class="display-block text-muted">
                        <icon class="glyphicon glyphicon-map-marker icon-item-padding display-table-cell" style=""></icon>
                        <span class="display-table-cell">{{ $menuItem->venue }}</span>
                    </span>
                </a>
            </div>
                        
            @endforeach
            
            {{ Html::link('/talks/all', 'See All', ['class' => 'btn btn-default btn-lg text-uppercase btn-block']) }}
            
        </div>
    </div>    
