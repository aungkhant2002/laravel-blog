<li class="nav-item">
    <a class="nav-link {{ request()->url() == route($routeName) ? 'active' : '' }}"
       aria-current="page" href="{{ route($routeName) }}">{{ $title }}</a>
</li>
