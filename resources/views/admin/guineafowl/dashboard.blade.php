@extends('admin.dashboard')
@section('side_dash_link')
    {{route('admin.home','guinea_fowl')}}
@endsection
@section('profile')
<a class="dropdown-item" href="{{route('admin.profile','guinea_fowl')}}">Profile</a>
    {{-- <a class="dropdown-item" href="#">Activity Log</a> --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('admin.logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i>logout</a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
@endsection

@section('sidenav-links')
    {{-- <div class="sb-sidenav-menu-heading">Livestock Manager</div> --}}
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon"><i class="fas fa-crow"></i></div>
        Birds
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{route('admin.bird.population','guinea_fowl')}}">Population</a>
            <a class="nav-link" href="{{ route('admin.bird.mortality','guinea_fowl')}}">Mortality</a>
            <a class="nav-link" href="{{ route('admin.bird.pen','guinea_fowl')}}">House</a>
        </nav>
    </div>
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
        <div class="sb-nav-link-icon"><i class="fas fa-egg"></i></div>
        Eggs
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav" >
            <a class="nav-link" href="{{route('admin.egg.production','guinea_fowl')}}">Production</a>
        </nav>
    </div>
    {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseFeed" aria-expanded="false" aria-controls="collapseFeed">
        <div class="sb-nav-link-icon"><i class="fas fa-cookie-bite"></i></div>
        Feed
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseFeed" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link collapsed" href="{{route('admin.feed.stock','guinea_fowl')}}">Stock</a>
            <a class="nav-link collapsed" href="{{route('admin.feeding.record','guinea_fowl')}}">Feeding</a>
        </nav>
    </div>
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseMed" aria-expanded="false" aria-controls="collapseMed">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
        Medication and Vaccination
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseMed" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link collapsed" href="{{route('admin.medicine','guinea_fowl')}}">
               Medication
            </a>
            <a class="nav-link collapsed" href="{{route('admin.vaccine','guinea_fowl')}}">
                Vaccination
            </a>
        </nav>
    </div>
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseSale" aria-expanded="false" aria-controls="collapseSale">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Sales
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseSale" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link collapsed" href="{{route('admin.sale.bird','guinea_fowl')}}">
                Bird Sale
            </a>
            <a class="nav-link collapsed" href="{{route('admin.sale.egg','guinea_fowl')}}">
                Egg Sale
            </a>
            <a class="nav-link collapsed" href="{{route('admin.sale.meat','guinea_fowl')}}">
                Meat Sale
            </a>
             <a class="nav-link collapsed" href="{{ route('admin.sale.all','guinea_fowl')}}">
                Summary
            </a>
        </nav>
    </div>
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseLogicstic" aria-expanded="false" aria-controls="collapseLogicstic">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Logistic
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseLogicstic" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link collapsed" href="{{route('admin.farm.equipment','guinea_fowl')}}">
               Equipment
            </a>
        </nav>
    </div>

    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseFin" aria-expanded="false" aria-controls="collapseFin">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Finance
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseFin" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link collapsed" href="{{route('admin.transaction','guinea_fowl')}}">
                Transaction
            </a>
            <a class="nav-link collapsed" href="{{route('admin.statement','guinea_fowl')}}">
                Statement
            </a>
        </nav>
    </div>
     @if (auth()->user()->hasRole('SUPER_ADMIN'))
       <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Staff
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseAdmin" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link collapsed" href="{{route('admin.employee','guinea_fowl')}}">
                    Employees
                </a>
                <a class="nav-link collapsed" href="{{route('admin.users','guinea_fowl')}}">
                    Users
                </a>
            </nav>
        </div>
    @endif

@endsection
