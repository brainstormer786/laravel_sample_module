@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
      </div>
    @endif

  </section>

  <!-- Main content -->
  <section class="invoice">

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table id="usersTable" class="table table-hover sortable">
          <thead>
            <tr>
              <th class="col-xs-1 not-sortable">Id</th>
              <th class="col-xs-2">Name</th>
              <th class="col-xs-1">Link</th>
              <th class="not-sortable col-xs-3"></th>
            </tr>
          </thead>
          <tbody>
          	@foreach($pages as $page)
	            <tr>
                <td>{{ $page->id }}</td>
	              <td>{{ $page->name }}</td>
	              <td>{{ $page->link_name_pag }}</td>
	              <td>
	                <div class="row">
      		            
                    <form method="POST" action="{{ url('page/'.$page->id.'/restore') }}" class="float-left" onSubmit="return confirm('Do you really want to restore this page?')">
                      {{ csrf_field() }}
                      <input type="submit" class="btn btn-success delete-user" value="Restore Page"/>
                    </form>
                  </div>

	              </td> 
	            </tr>
        @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>

        {!! $pages->appends(collect(Request::all())->map(function($item) {
            return is_null($item) ? '' : $item;
            })->toArray())->render() !!}
      <!-- /.row -->
      <div class="row">

      </div>

  </section>
  <!-- /.content -->
</div>
@endsection

@section('afterJs')

  <script>
    $(document).ready(function(){


    });

  </script>

@endsection