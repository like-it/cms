{{R3M}}
<div class="dropdown dropup">
    <div class="btn-group">
        <button
            class="btn btn-outline-primary dropdown-toggle limit"
            type="button"
            data-toggle="dropdown"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            {{if($request.limit==25)}}
            25
            {{elseif($request.limit==50)}}
            50
            {{elseif($request.limit==100)}}
            100
            {{elseif($request.limit==250)}}
            250
            {{elseif($request.limit==500)}}
            500
            {{elseif($request.limit==1000)}}
            1000
            {{else}}
            10
            {{/if}}
        </button>
        <div
            class="dropdown-menu"
        >
            {{for.each($limits as $limit)}}
            {{$require.basename = $limit|uppercase.first.sentence:'.'}}
            {{require($controller.dir.component + $require.module + '/Settings/Domain/Limit/' + $require.basename + '.tpl')}}
            {{/for.each}}
        </div>
    </div>
</div>