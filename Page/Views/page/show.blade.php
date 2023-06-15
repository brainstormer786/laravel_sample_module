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
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">{{ $user->first_name." ".$user->middle_name." ".$user->last_name." ".$user->generation.' - ('.$user->id.')' }}</h3>
            <div class="text-info pull-right">
              <h3 class="box-title">Login: <span class="{{ $user->status=='active' ? 'text-success':'text-danger' }}">{{ ucfirst($user->status) }}</span></h3> - 
              <h3 class="box-title">Membership: <span class="{{ $user->membership_status=='active' ? 'text-success':'text-danger' }}">{{ ucfirst($user->membership_status ?? '') }}</span></h3>
            </div>
          </div>
          <div class="box-body">
            <div class="col-xs-12 table-responsive">
              <table class="table without-border">
                <tbody>
                  <tr>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Username:</strong></div></td>
                    <td class="col-xs-2">{{ $user->username }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Created:</strong></div></td>
                    <td class="col-xs-2">{{ $user->created }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>&nbsp;</strong></div></td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong><a href="{{ url('user/'.$user->id.'/edit') }}">Edit</a> || <a href="#">hc</a></div></td>
                  </tr>
                  <tr>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>&nbsp;</strong></div></td>
                    <td class="col-xs-2">&nbsp;</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Email:</strong></div></td>
                    <td class="col-xs-2">{{ $user->email }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Aff:</strong></div></td>
                    <td class="col-xs-2">{{ 'affiliate' }}</td>
                  </tr>
                  <tr>
                    <td class="col-xs-2" rowspan="2"><div class="col-12 pull-right"><strong>Address:</strong></div></td>
                    <td class="col-xs-2" rowspan="2">{!! $user->address1."<br/>".$user->address2."<br/>".$user->city.", ".$user->state." ".$user->zip !!}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Phone:</strong></div></td>
                    <td class="col-xs-2">{{ $user->phone }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Membership:</strong></div></td>
                    <td class="col-xs-2">{{ $user->membership_status }}</td>
                  </tr>
                  <tr>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Found:</strong></div></td>
                    <td class="col-xs-2">{{ "" }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>DOB/SSN:</strong></div></td>
                    <td class="col-xs-2">{{ $user->dob }}</td>
                  </tr>
                  <tr>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Sex:</strong></div></td>
                    <td class="col-xs-2">{{ $user->sex }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Passed EVS:</strong></div></td>
                    <td class="col-xs-2">{{ $user->evs_pass }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Reporting Bureau:</strong></div></td>
                    <td class="col-xs-2">No</td>
                  </tr>
                  <tr>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Cell:</strong></div></td>
                    <td class="col-xs-2">{{ $user->cell_phone }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>User Level:</strong></div></td>
                    <td class="col-xs-2">{{ $user->level->level ?? '' }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Post Date:</strong></div></td>
                    <td class="col-xs-2">{{ $user->sug_pay_date }}</td>
                  </tr>
                  <tr>
                    <td class="col-xs-2" rowspan="2"><div class="col-12 pull-right"><strong>Mother's maiden name:</strong></div></td>
                    <td class="col-xs-2" rowspan="2">{{ $user->question_mother_maiden_name }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Verified Employment:</strong></div></td>
                    <td class="col-xs-2">{{ $user->verified_employment==1 ? 'Yes':'No' }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Verified Reference:</strong></div></td>
                    <td class="col-xs-2">{{ $user->verified_ref==1 ? 'Yes':'No' }}</td>
                  </tr>
                  <tr>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Last Transaction Status:</strong></div></td>
                    <td class="col-xs-2">{{ "Settled" }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Signup With:</strong></div></td>
                    <td class="col-xs-2">{{ "Credit Card" }}</td>
                  </tr>
                  <tr>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>PDS Token:</strong></div></td>
                    <td class="col-xs-2">{{ $user->pds_token }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>PDS Response Status:</strong></div></td>
                    <td class="col-xs-2">{{ $user->pds_response_status=="1" ? "Successful":"Failed" }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>PDS Response Message:</strong></div></td>
                    <td class="col-xs-2">{{ $user->pds_response }}</td>
                  </tr>
                  <tr>
                    <td class="col-xs-2" rowspan="2"><div class="col-12 pull-right"><strong>Close Account:</strong></div></td>
                    <td class="col-xs-2" rowspan="2"><a href="#">Close account</a></td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Open Account:</strong></div></td>
                    <td class="col-xs-2">{{ $user->status=='active' ? 'Open':"" }}</td>
                    <td class="col-xs-2"><div class="col-12 pull-right"><strong>Salt Profile ID:</strong></div></td>
                    <td class="col-xs-2">{{ "" }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Notes</a></li>
            <li><a href="#tab_2" data-toggle="tab">Credit</a></li>
            <li><a href="#tab_3" data-toggle="tab">Orders</a></li>
            <li><a href="#tab_3" data-toggle="tab">SBal</a></li>
            <li><a href="#tab_3" data-toggle="tab">Invoice</a></li>
            <li><a href="#tab_3" data-toggle="tab">Membership</a></li>
            <li><a href="#tab_3" data-toggle="tab">Commissions</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Payments <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Monthly Payment Amount</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Payments</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Pay Monthly Fee</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Other <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Biz</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Login</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Activity Log</a></li>
                <li role="presentation" class="divider">Log</li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Docs</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Bureau Status</a></li>
              </ul>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">&nbsp;</div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">&nbsp;</div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">&nbsp;</div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
@endsection

@section('afterJs')
<!-- FastClick -->
<script>
  $(document).ready(function(){
    $('.btn-cap').on('click', function(){
      var elem = $(this).closest('.form-group').find('input[type="text"],input[type="email"]');
      var text = elem.val();
      text = text.substr(0,1).toUpperCase()+text.substr(1);
      elem.val(text);
    });
    $('.nav-tabs li').on('click', function(){
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
    });
  });
</script>
@endsection