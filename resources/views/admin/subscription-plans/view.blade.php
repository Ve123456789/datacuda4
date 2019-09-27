@include('lib.header')
    <body>
        <!-- Main navbar -->
        @include('lib.nav')
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main sidebar -->
                @include('lib.sidebar')
                <!-- /main sidebar -->
                <!-- Main content -->
                <div class="content-wrapper">
                    <div class="page-header">
                        <div class="page-header-content">
                            <div class="page-title">
                                <h5>
                                    <a href="{{ url('admin/homeplans') }}" >
                                        <i class="icon-arrow-left52 position-left"></i> 
                                        <span class="text-semibold">Subscription Plans</span>
                                    </a>
                                </h5>
                                <a class="heading-elements-toggle">
                                    <i class="icon-more"></i>
                                </a>
                            </div>

                            <div class="heading-elements">
                                <div class="heading-btn-group">
                                    <a href="javascript:void(0)" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="breadcrumb-line breadcrumb-line-component"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
                            <ul class="breadcrumb">
                                <li><a href="{{ url('admin/dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                                <li><a href="{{ url('admin/subscription-plans') }}">Subscription Plans</a></li>
                                <li><a href="{{ route('subscriptionPlanView', ['planId' => $data->id]) }}">View</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!---- Form ----->                    
                    <div class="row" > 
                        <div class="col-lg-8 col-lg-offset-2 col-md-6 col-md-offset-2">
                            @include('shared.errors')
                            @include('shared.success')
                            <form class="form-horizontal" method="POST" action="{{ route('subscriptionPlanUpdate', ['planId' => $data->id]) }}" >
                                @csrf
                                @method('PUT')
                                <div class="panel panel-flat">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">Update/View Subscription Plan</h5>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                                <li><a data-action="reload"></a></li>
                                                <li><a data-action="close"></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <!-- name of the subscription plan -->
                                        <div class="form-group">
                                            <label class="control-label col-lg-2">
                                                Name
                                                <span class="text-danger text-center p-1">*</span> 
                                            </label>
                                            <div class="col-lg-8">
                                                <input class="form-control" disabled value="{{ $data->name }}"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-2">
                                                Commission
                                                <span class="text-danger text-center p-1">*</span> 
                                            </label>
                                            <div class="col-lg-8">
                                                <input aria-describedby="commissionHelp" class="form-control" name="commission" maxlength="10" placeholder="Please enter Commssion" value="{{ old('commission') ?? $data->commission }}" autocomplete="off"/>
                                                <small id="commissionHelp" class="form-text text-muted">Commission is Numeric value. Do not add '%'</small>
                                                <div class="text-danger p-1" >{{ $errors->first('commission') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-2">
                                                Amount
                                                <span class="text-danger text-center p-1">*</span> 
                                            </label>
                                            <div class="col-lg-8">
                                                <input aria-describedby="amountHelp" class="form-control" name="amount" maxlength="10" placeholder="Enter the Amount" value="{{ old('amount') ?? $data->amount }}" autocomplete="off"/>
                                                <small id="amountHelp" class="form-text text-muted">Amount is Numeric value will consider in Doller ($).</small>
                                                <div class="text-danger p-1" >{{ $errors->first('amount') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-2">
                                                Storage
                                                <span class="text-danger text-center p-1">*</span> 
                                            </label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input class="form-control" name="storage_quantity" placeholder="Storage Quantity (number)" maxlength="2" autocomplete="off" value="{{ old('storage_quantity') ?? $data->storage_quantity }}" />
                                                        <div class="text-danger p-1" >{{ $errors->first('storage_quantity') }}</div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select name="storage_unit" class="form-control">
                                                            <option value="mb" {{ $data->storage_unit === 'mb' ? 'selected' : '' }}>MB</option>
                                                            <option value="gb" {{ $data->storage_unit === 'gb' ? 'selected' : '' }}>GB</option>
                                                            <option value="tb" {{ $data->storage_unit === 'tb' ? 'selected' : '' }}>TB</option>
                                                        </select>
                                                        <div class="text-danger p-1" >{{ $errors->first('storage_unit') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-2">
                                                Validity
                                                <span class="text-danger text-center p-1">*</span> 
                                            </label>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input class="form-control" name="vailidity_quantity" placeholder="Validity Quantity (number)" maxlength="2" autocomplete="off" value="{{ old('vailidity_quantity') ??  $data->vailidity_quantity }}" />
                                                        <div class="text-danger p-1" >{{ $errors->first('vailidity_quantity') }}</div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select name="validity_unit" class="form-control">
                                                            <option value="days" {{ $data->validity_unit === 'days' ? 'selected' : '' }}>Days</option>
                                                            <option value="months" {{ $data->validity_unit === 'months' ? 'selected' : '' }}>Months</option>
                                                            <option value="years" {{ $data->validity_unit === 'years' ? 'selected' : '' }}>Years</option>
                                                        </select>
                                                        <div class="text-danger p-1" >{{ $errors->first('validity_unit') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-2">
                                                Benifits
                                                <span class="text-danger text-center p-1">*</span> 
                                            </label>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" name="benifits" aria-describedby="benifitsHelp" rows="6" placeholder="Enter new line to add next benifits">{{ implode(PHP_EOL, old('benifits') ?? $data->benifits) }}</textarea>
                                                <small id="benifitsHelp" class="form-text text-muted">Press enter for next benifit.</small>
                                                <div class="text-danger text-left p-1" >{{ $errors->first('benifits') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-2">
                                                Is Additional?
                                                <span class="text-danger text-center p-1">*</span> 
                                            </label>
                                            <div class="col-lg-8 text-left">
                                                <input type="checkbox" name="additional" {{ $data->additional ? 'checked' : null }} />
                                                <div class="text-danger p-1" >{{ $errors->first('additional') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-2">
                                                Additional Plans Linked?
                                            </label>
                                            <div class="col-lg-8 text-left">
                                                <select name="additional_plan_id" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($plans as $id => $plan)
                                                    @if ($id !== $data->id)
                                                    <option value="{{ $id }}" @if($data->additional_plan_id === $id) selected @endif >{{ ucwords ($plan) }}</option>
                                                    @endif
                                                @endforeach
                                                </select>
                                                <small id="commissionHelp" class="form-text text-muted">Required if Additional is select.</small>
                                                <div class="text-danger p-1" >{{ $errors->first('additional_plan_id') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-2">
                                                Is Active?
                                                <span class="text-danger text-center p-1">*</span> 
                                            </label>
                                            <div class="col-lg-8 text-left">
                                                <input type="checkbox" name="active" {{ $data->active ? 'checked' : null }} />
                                                <div class="text-danger p-1" >{{ $errors->first('active') }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            <button class="btn btn-primary">
                                                Update 
                                                <i class="icon-arrow-right14 position-right"></i>
                                            </button>
                                        </div>                                    
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!---- Form ----->  
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
</html>
