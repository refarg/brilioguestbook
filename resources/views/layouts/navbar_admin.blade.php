@php
    $active = $active ?? null;
@endphp
<li class="nav-item menu-open">
<a href="#" class="nav-link">
    <i class="nav-icon fas fa-person-booth"></i>
    <p>
    Guest Book
    <i class="fas fa-angle-left right"></i>
    </p>
</a>
<ul class="nav nav-treeview">
    <li class="nav-item">
    <a href="{{ route('admin.guestbook.index') }}" class="nav-link @yield('guestbook-index')">
        <i class="fas fa-table nav-icon"></i>
        <p>Index</p>
    </a>
    </li>
</ul>
</li>