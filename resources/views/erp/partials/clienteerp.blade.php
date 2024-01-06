<div class="col l2 m2 amber accent-4 hide-on-small-only">&nbsp;</div>
<div class="col l4 m4 s6 amber accent-4"><a href="{{ route('jahx.dashboard') }}" class="">Castelo do Queijo</a></div>
<div class="col l4 m4 s6 amber accent-4">
	<div class="right-align">
        <a href="#" class="dropdown-button" data-activates="dropdown1">{{ Auth::user()->name }}<i class="tiny material-icons">arrow_drop_down</i></a>
        <ul id='dropdown1' class='dropdown-content'>
		    <li><a href="{{ route('jahx.usuario') }}">Meus dados</a></li>
		    <li class="divider"></li>
		    <li>
		    	<a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="material-icons">close</i>Sair
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
		    </li>
		</ul>
    </div>
</div>
<div class="col l2 m2 amber accent-4 hide-on-small-only">&nbsp;</div>