@if ( session('error') && session('error') != 'denied' && session('error') != 'exist' )
<div class="col-lg-12 col-12">
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Error</h4>
        <p>{!! Session::get('error') !!}</p>
    </div>
</div>
@endif

@if( session('errors') != NULL )
<div class="col-lg-12 col-12">
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Error</h4>
        @if( is_array( session('errors') ) )
            @foreach( session('errors') as $error )
                <p>{{ $error }}</p>
            @endforeach
        @else
            <p>{{ session('errors') }} </p>
        @endif
    </div>
</div>
@endif

@if (session('error') == 'denied')
<div class="col-lg-12 col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> {{ __('message.title.denied') }}</h4>
        {{ __('message.denied') }}
    </div>
</div>
@endif

@if (session('error') == 'exist')
<div class="col-lg-12 col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> {{ __('message.title.errors') }}</h4>
        {{ __('message.exist') }}
    </div>
</div>
@endif

@if (session('success') == "edit")
<div class="col-lg-12 col-12">
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.success.edit') }}
    </div>
</div>
@elseif ( session('success') == "create" )
<div class="col-lg-12 col-12">
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.success.create') }}
    </div>
</div>
@elseif ( session('sync') )
<div class="col-lg-12 col-12">
    <div class="alert alert-sync alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.sync') }}
    </div>
</div>
@endif

@if( session('success') == 'warning' )
<div class="col-lg-12 col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.warning') }}
    </div>
</div>
@endif

@if ( session('restore') )
<div class="col-lg-12 col-12">
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.restore') }}
    </div>
</div>
@endif

@if ( session('delete') )
<div class="col-lg-12 col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.delete') }}
    </div>
</div>
@endif

@if( session('approve') )
<div class="col-lg-12 col-12">
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.success.approve') }}
    </div>
</div>
@endif

@if( session('approved') )
<div class="col-lg-12 col-12">
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.approved') }}
    </div>
</div>
@endif

@if (session('decline'))
<div class="col-lg-12 col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.decline') }}
    </div>
</div>
@endif

@if( session('acknowledge') )
<div class="col-lg-12 col-12">
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.success') }}</h4>
        {{ __('message.acknowledge') }}
    </div>
</div>
@endif

@if ( session('failed') )
<div class="col-lg-12 col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.failed') }}</h4>
        {{ __('message.failed') }}
    </div>
</div>
@endif

@if ( session('denied') )
<div class="col-lg-12 col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.denied') }}</h4>
        {{ __('message.denied') }}
    </div>
</div>
@endif

@if ( session('not_same_password') )
<div class="col-lg-12 col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.failed') }}</h4>
        {{ __('message.different_password') }}
    </div>
</div>
@endif

@if ( session('no_data') )
<div class="col-lg-12 col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ __('message.title.no-data') }}</h4>
        {{ __('message.no-data') }}
    </div>
</div>
@endif
