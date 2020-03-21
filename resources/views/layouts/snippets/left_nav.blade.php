<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <img src="{{ asset('images/logo-home.jfif') }}" alt="logo" height="30px" width="35px" style="margin-right: 10px; border-radius: 15%;">
    <a class="navbar-brand" href="{{ url('home') }}">Purple Algorithm</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Products">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fas fa-cubes"></i>
                    <span class="nav-link-text">Products</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponents">
                    <li>
                        <a href="{{ url('products') }}">All Products</a>
                    </li>
                    <li>
                        <a href="{{ url('product_type') }}">Product Types</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#inventorySection" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fas fa-align-justify"></i>
                    <span class="nav-link-text">Inventory</span>
                </a>
                <ul class="sidenav-second-level collapse" id="inventorySection">
                    <li>
                        <a href="{{ url('inventories') }}">All Inventories</a>
                    </li>
                    <li>
                        <a href="{{ url('distribution') }}">Dist. Inventory Update</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fas fa-users"></i>
                    <span class="nav-link-text">Clients</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseExamplePages">
                    <li>
                        <a href="{{ url('parties') }}">All Clients</a>
                    </li>
                    <li>
                        <a href="{{ url('party_type') }}">Client Type</a>
                    </li>

                    @if(Auth::user()->user_type != 'hr')
                    <li>
                        <a href="{{ route('adjust-balance.index') }}">Adjust Balance</a>
                    </li>
                    @endif

                </ul>
            </li>
            {{--
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fas fa-american-sign-language-interpreting"></i>
                    <span class="nav-link-text">Commissions</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseMulti">
                    <li>
                        <a href="{{ url('commissions') }}">View Commissions</a>
                    </li>
                    @if(Auth::user()->user_type == 'sales' || Auth::user()->user_type == 'warehouse' || Auth::user()->user_type == 'hr')
                    <!-- Show nothing -->
                    @else
                    <li>
                        <a href="{{ url('commissions/create') }}">Add Commissions</a>
                    </li>
                    @endif
                </ul>
            </li> --}}

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#invoiceCollapse" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fas far fa-file"></i>
                    <span class="nav-link-text">Invoices</span>
                </a>
                <ul class="sidenav-second-level collapse" id="invoiceCollapse">
                    <li>
                        <a href="{{ url('sales') }}">Sales</a>
                    </li>
                    <li>
                        <a href="{{ url('sales_return') }}">Sales Return</a>
                    </li>
                    <li>
                        <a href="{{ url('payment_received') }}">Payment Received</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link" href="{{ url('zones') }}">
                    <i class="fa fa-fw fas fa-map-marker"></i>
                    <span class="nav-link-text">Zone</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link" href="{{ url('hrs') }}">
                    <i class="fa fa-fw far fa-user"></i>
                    <span class="nav-link-text">HR Input</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link" href="{{ url('payment_methods') }}">
                    <i class="fa fa-fw fas fa-arrow-circle-down"></i>
                    <span class="nav-link-text">Payment Methods</span>
                </a>
            </li>

            @if(Auth::user()->user_type == 'management' ||Auth::user()->user_type == 'sub_management' || Auth::user()->user_type == 'superadmin')

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#userCollapse" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fas fa-address-book"></i>
                    <span class="nav-link-text">Users</span>
                </a>
                <ul class="sidenav-second-level collapse" id="userCollapse">
                    @if(Auth::user()->user_type == 'superadmin' || Auth::user()->user_type == 'sub_management')
                    <li>
                        <a href="{{ url('user') }}">Add Users</a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ url('view_users') }}">View Users</a>
                    </li>
                </ul>
            </li>
            {{--
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link" href="{{ route('distributors.index') }}">
                    <i class="fa-fw fas fa-project-diagram"></i>
                    <span class="nav-link-text">Distributors</span>
                </a>
            </li> --}} {{--
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#offerCollapse" data-parent="#exampleAccordion">
                    <i class="fas fa-hourglass-start"></i>
                    <span class="nav-link-text">Offers</span>
                </a>
                <ul class="sidenav-second-level collapse" id="offerCollapse">
                    @if(Auth::user()->user_type == 'superadmin' || Auth::user()->user_type == 'sub_management')
                    <li>
                        <a href="#">Offers</a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('offer-types.index') }}">Offer Type</a>
                    </li>
                </ul>
            </li> --}} @endif

        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <!-- <li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li> -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i>{{ Auth::user()->name }} ({{ ucwords(Auth::user()->user_type) }})</i>
                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>