@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    @if ($message = Session::get('error'))
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <!-- Please check the form below for errors -->
        {{ $message }}
      </div>
    @endif
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">{{ isset($page) ? 'Update':'Create' }} Page</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
            @if(isset($page))
              <form class="form-horizontal" action="{{ url('page/'.$page->id) }}" method="post" enctype="multipart/form-data">
              @method('PUT')
            @else
              <form class="form-horizontal" action="{{ url('page') }}" method="post" enctype="multipart/form-data">
            @endif

            @csrf
            
            <div class="box-body">
              <div class="col-md-12">
                  
                 <div class="form-group has-feedback">
                  <label for="inputPassword3" class="col-sm-2 control-label">Name<span class="text-danger">*</span></label>

                  <div class="col-sm-8">
                    <input id="page-name" type="text" name="page[name]" value="{{ old('page.name') ?? $page->name ?? '' }}" class="form-control {{ $errors->has('page.name') ? 'is-invalid':'' }}" placeholder="Page Name" required>
                    <div class="invalid-feedback text-danger">
                      @if ($errors->has('page.name'))
                          {{ $errors->first('page.name') }}
                      @endif
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Comments<span class="text-danger">*</span></label>

                  <div class="col-sm-8">
                    <input type="text" name="page[comments]" class="form-control" value="{{ old('page.comments') ?? $page->comments ?? '' }}" placeholder="Name the feature where this page is going to be used" required="">
                    <div class="invalid-feedback text-danger">
                      @if ($errors->has('page.comments'))
                          {{ $errors->first('page.comments') }}
                      @endif
                    </div>
                  </div>
                </div>
                  
                <div class="form-group has-feedback">
                  <label for="inputPassword3" class="col-sm-2 control-label">Content<span class="text-danger">*</span></label>

                  <div class="col-sm-8">
                    <textarea name="page[content]" id="description" class="form-control {{ $errors->has('page.content') ? 'is-invalid':'' }}" required>{{ old('page.content') ?? $page->content ?? '' }}</textarea>
                    <div class="invalid-feedback text-danger">
                      @if ($errors->has('page.content'))
                          {{ $errors->first('page.content') }}
                      @endif
                    </div>
                  </div>
                </div>
               
              </div>
             
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right" style="margin-left:10px">{{ isset($page) ? 'Update':'Create' }}</button>
              <button type="button" onclick="preview()" class="btn btn-primary pull-right" style="margin-left:10px">Preview</button>
              <a href="{{ url('page') }}" class="btn btn-default pull-right">Cancel</a>
            </div>
            <!-- /.box-footer -->
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
@endsection

@section('afterJs')

<script>
  $(document).ready(function(){
    $('.btn-cap').on('click', function(){
      var elem = $(this).closest('.form-group').find('input[type="text"],input[type="email"]');
      var text = elem.val();
      text = text.substr(0,1).toUpperCase()+text.substr(1);
      elem.val(text);
    });

    CKEDITOR.replace('description',
                {   toolbar: 'MA'
                
                    }
        
        );
  });

  function preview(){
    var pageName = $("#page-name").val();
    var pageContent = CKEDITOR.instances['description'].getData(); 
    if(!pageName || !pageContent){
      alert("kindly add page name and content to see preview");
      return;
    }else{
      localStorage.setItem('pageName', pageName);
      localStorage.setItem('pageContent', pageContent);
      window.open('{{ url('') }}' + '/previewPage', '_blank');
    }
  }
</script>
@endsection