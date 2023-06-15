@extends('layouts.frontend')

@section('content')

<div class="row dynamic-page">
    <h2 id="page-heading"></h2>
    <div id="page-content">
		
	</div>
</div>

@endsection

@section('afterJs')

<script>

	$(document).ready(function(){
		var pageName = localStorage.getItem('pageName');
		var pageContent = localStorage.getItem('pageContent');
		console.log(pageName,pageContent);
		if(!pageName){
			pageName = 'No page found';
		}
		$("#page-heading").html(pageName);
		$("#page-content").html(pageContent);
	})
    
</script>

@endsection