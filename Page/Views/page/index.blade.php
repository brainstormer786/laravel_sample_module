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
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-book"></i> Pages
            <small class="pull-right">
              @if(isset($display) && $display=='')
                <a id="show-all" href="javascript:">Show all records</a>
              @elseif(isset($display) && $display=='all')
                <a id="show-20" href="javascript:">Show 20 records</a>
              @endif
              &nbsp;-&nbsp;
              @if(isset($search) && $search)
                <a href="javascript:" id="toggle-filters" value="1">Hide filters</a>
              @else
                <a href="javascript:" id="toggle-filters" value="0">Show filters</a>
              @endif
            </small>
          </h2>
        </div>
        <!-- /.col -->
      </div>

      
        <input type="hidden" name="sort" value="{{ $searchParams['sort'] ?? '' }}" />
        <input type="hidden" id="display-rec" name="display" value="{{ isset($display) ? $display:"" }}" />
        <input type="hidden" name="search" value="Search" />

        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive" style="min-height: 500px;">
            <table id="usersTable" class="table table-hover sortable">
              <thead>
  	            <tr>
  	              <th class="col-xs-1 not-sortable">Id</th>
  	              <th class="col-xs-2">Name</th>
  	              <th class="col-xs-1">Comments</th>
                  <th class="col-xs-1">Updated at</th>
  	              <th class="not-sortable col-xs-3"></th>
  	            </tr>
              </thead>
              <form id="search-form" action="">
                  <tbody class="avoid-sort">
                    <tr id="search-row">
                      <td><input type="text" name="id" value="{{ $searchParams['id'] ?? '' }}" class="form-control input-sm" paceholder="Search id" /></td>
                      <td><input type="text" name="name" value="{{ $searchParams['name'] ?? '' }}" class="form-control input-sm" paceholder="Search name" /></td>
                      <td><input type="text" name="comments" value="{{ $searchParams['comments'] ?? '' }}" class="form-control input-sm" paceholder="Search Comments" /></td>
                      <td><input type="text" name="updated_at" value="{{ $searchParams['updated_at'] ?? '' }}" class="form-control input-sm datepicker" id="datepicker" paceholder="Select date" /></td>
                      <td><input type="submit" class="btn" name="search" value="Search" /></td>
                    </tr>
                  </tbody>
              </form>
              <tbody>
                @if(count($pages)>0)
                	@foreach($pages as $page)
    		            <tr>
                      <td>{{ $page->id }}</td>
    		              <td>{{ $page->name }}</td>
    		              <td>{{ $page->comments }}</td>
                      <td>{{ isset($page->updated_at) ? date('m/d/Y', strtotime($page->updated_at)):'' }}</td>
    		              <td>
    		                <div class="row">
            		            <a href="{{ url('page/'.$page->id.'/edit') }}" class="btn btn-primary float-left" style="margin-right: 5px;">Edit</a>
                              @if($page->link_name_pag)
                                  <a target="_blank" href="{{ url( $page->link_name_pag ) }}" class="btn btn-primary float-left" style="margin-right: 5px;">Preview</a>
                              @endif
                              <form method="POST" action="{{ 'page/'.$page->id }}" class="float-left" onSubmit="return confirm('Do you really want to hide this page?')">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                      <input type="submit" class="btn btn-danger delete-user" value="Hide Page"/>
                              </form>
                          </div>

    		              </td> 
    		            </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5">No, page found.</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>

      @if($display!='all')
        {!! $pages->appends(collect(Request::all())->map(function($item) {
            return is_null($item) ? '' : $item;
            })->toArray())->render() !!}
      @endif
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
      $('.datepicker').datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent:true
      });

    });

  </script>

@endsection