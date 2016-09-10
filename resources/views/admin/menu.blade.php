<div id='adminnav' class='list-group'>    
    <div>
        {{ Html::link('/admin', 'ADMIN', array(
                    'class' => 'panel-title list-group-item active noborderradius')
                    ) }}            
    </div>
    
    <div>
        {{ Html::link('#admin-subnav-sig', 'SIG', array(
                    'data-parent' => '#adminnav', 
                    'data-toggle' => 'collapse', 
                    'class' => 'panel-title list-group-item noborderradius')
                    ) }}

        <div id='admin-subnav-sig' class='collapse list-group' >
            {{ Html::link('#', 'View All', array(
                        'class' => 'list-group-item noborder')
                        ) }}
            {{ Html::link('#', 'Edit List', array(
                        'class' => 'list-group-item noborder')
                        ) }}                    
        </div>
    </div>

    <div>
        {{ Html::link('#admin-subnav-mailing', 'Mailing List', array(
                    'data-parent' => '#adminnav', 
                    'data-toggle' => 'collapse', 
                    'class' => 'panel-title list-group-item noborderradius')
                    ) }}

        <div id='admin-subnav-mailing' class='collapse list-group' >
            {{ Html::link('/admin/mailingall', 'View All', array('class' => 'list-group-item noborder')) }}
            {{ Html::link('#', 'Send mail', array('class' => 'list-group-item noborder')) }}   
            {{ Html::link('#', 'Edit List', array('class' => 'list-group-item noborder')) }}                    
        </div>
    </div>
</div>    
