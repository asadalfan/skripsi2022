@inject('sidebarItemHelper', 'JeroenNoten\LaravelAdminLte\Helpers\SidebarItemHelper')

@php
$user_types = null;
@endphp
@foreach ($item as $key => $i)
@if (str_replace('"', "", json_encode($key)) == 'user_types')
@php
$user_types = explode(' ', str_replace('"', "", json_encode($i)));
@endphp
@endif
@endforeach

@if (! $user_types || in_array(Auth::user()->type, $user_types))
@if ($sidebarItemHelper->isHeader($item))

{{-- Header --}}
@include('adminlte::partials.sidebar.menu-item-header')

@elseif ($sidebarItemHelper->isLegacySearch($item) || $sidebarItemHelper->isCustomSearch($item))

{{-- Search form --}}
@include('adminlte::partials.sidebar.menu-item-search-form')

@elseif ($sidebarItemHelper->isMenuSearch($item))

{{-- Search menu --}}
@include('adminlte::partials.sidebar.menu-item-search-menu')

@elseif ($sidebarItemHelper->isSubmenu($item))

{{-- Treeview menu --}}
@include('adminlte::partials.sidebar.menu-item-treeview-menu')

@elseif ($sidebarItemHelper->isLink($item))

{{-- Link --}}
@include('adminlte::partials.sidebar.menu-item-link')

@endif
@endif
