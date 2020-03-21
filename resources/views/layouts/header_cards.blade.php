<div class="row">

    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">Reports</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('reports') }}">
                <span class="float-left">View reports</span>
                <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">Inventory</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('inventories.index') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-support"></i>
                </div>
                <div class="mr-5">Clients</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('parties.index') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
        <i class="fa fa-angle-right"></i>
      </span>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-support"></i>
                </div>
                <div class="mr-5">Sales</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="{{ route('sales.index') }}">
                <span class="float-left">View Details</span>
                <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                 </span>
            </a>
        </div>
    </div>
    
</div>