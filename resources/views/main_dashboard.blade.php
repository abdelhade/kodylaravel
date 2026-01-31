@extends('kody2::layouts.auth')

@section('content')
<div class="container" style="margin-top: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Main Dashboard</h3>
                     <div class="card-tools">
                         <a href="{{ route('logout') }}" class="btn btn-tool" title="Logout">
                           <i class="fas fa-sign-out-alt"></i>
                         </a>
                     </div>
                </div>
                <div class="card-body">
                    <h4>Welcome, {{ session('login') }}</h4>
                    <p>Select a module to continue:</p>
                    
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                              <div class="inner">
                                <h3>Kody2</h3>
                                <p>Legacy System</p>
                              </div>
                              <div class="icon">
                                <i class="ion ion-bag"></i>
                              </div>
                              <a href="{{ route('kody2.dashboard') }}" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        
                        <!-- Add other modules here -->
                        <div class="col-lg-4 col-6">
                             <div class="small-box bg-success">
                               <div class="inner">
                                 <h3>POS</h3>
                                 <p>Point of Sale</p>
                               </div>
                               <div class="icon">
                                 <i class="ion ion-stats-bars"></i>
                               </div>
                               <a href="#" class="small-box-footer">Coming Soon <i class="fas fa-arrow-circle-right"></i></a>
                             </div>
                         </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
