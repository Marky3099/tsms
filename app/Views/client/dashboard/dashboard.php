<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Custom fonts for this template-->
  <link
  href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
  rel="stylesheet">


  <!-- Custom styles for this template-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dashstyle.css')?>">


  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/main.min.css')?>">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

</head>
<body>
 <!-- Begin Page Content -->
 <div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 10px;">
    <h3 class="hfont">Dashboard</h3>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                          class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                        </div>


                        <!-- Modal for displaying Pending Appointments -->

                       <div class="container">
                          <div class="modal fade" id="pendingModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title">Pending Appointments</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                  <?php if($pending):?>
                                    <table class="table table-bordered table1">
                                      <thead>
                                        <tr>
                                          <th>Date</th>
                                          <th>Time</th>
                                          <th>Appt Code</th>
                                          <th>Service</th>
                                          <th>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        
                                        <?php foreach($pending as $p):  ?>
                                          <tr>
                                            <td><?php echo date("M d, Y",strtotime($p['appt_date'])); ?></td>
                                            <?php $time = explode(":",$p['appt_time']);?>
                                             <?php if($time[0] == '00'):?>
                                                 <td>N/A</td>
                                              <?php elseif ($time[0]>=12):?>
                                                  <?php $hour = $time[0] - 12;?>
                                                  <?php $amPm = "PM";?>
                                                  <td><?php echo $hour . ":" . $time[1] . " " . $amPm;?></td>
                                              <?php else:?>
                                                  <?php $hour = $time[0]; ?>
                                                  <?php $amPm = "AM"; ?>
                                                  <td><?php echo $hour . ":" . $time[1] . " " . $amPm;?></td>
                                             <?php endif;?>
                                            <td><?php echo $p['appt_code']; ?></td>
                                            <td><?php echo $p['serv_name']; ?></td>
                                            <td><?php echo $p['appt_status'];?></td>
                                           
                                        </tr>
                                      <?php endforeach;?>
                                    </tbody>
                                  </table>
                                  
                                <?php else:?>
                                  <div class="Nowork">
                                    <p class="noworkstatement"><i class="fa-solid text-success fa-circle-exclamation"></i>&nbsp;No Pending Appointment</p>
                                  </div>
                                <?php endif;?>
                                
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Modal for displaying Approved Appointments -->
                    <div class="container">
                          <div class="modal fade" id="approveModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title">Approved Appointments</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                  <?php if($approve):?>
                                    <table class="table table-bordered table1">
                                      <thead>
                                        <tr>
                                          <th>Date</th>
                                          <th>Time</th>
                                          <th>Appt Code</th>
                                          <th>Service</th>
                                          <th>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        
                                        <?php foreach($approve as $p):  ?>
                                          <tr>
                                            <td><?php echo date("M d, Y",strtotime($p['appt_date'])); ?></td>
                                            <?php $time = explode(":",$p['appt_time']);?>
                                             <?php if($time[0] == '00'):?>
                                                 <td>N/A</td>
                                              <?php elseif ($time[0]>=12):?>
                                                  <?php $hour = $time[0] - 12;?>
                                                  <?php $amPm = "PM";?>
                                                  <td><?php echo $hour . ":" . $time[1] . " " . $amPm;?></td>
                                              <?php else:?>
                                                  <?php $hour = $time[0]; ?>
                                                  <?php $amPm = "AM"; ?>
                                                  <td><?php echo $hour . ":" . $time[1] . " " . $amPm;?></td>
                                             <?php endif;?>
                                            <td><?php echo $p['appt_code']; ?></td>
                                            <td><?php echo $p['serv_name']; ?></td>
                                            <td><?php echo $p['appt_status'];?></td>
                                           
                                        </tr>
                                      <?php endforeach;?>
                                    </tbody>
                                  </table>
                                  
                                <?php else:?>
                                  <div class="Nowork">
                                    <p class="noworkstatement"><i class="fa-solid text-success fa-circle-exclamation"></i>&nbsp;No Approved Appointment Yet</p>
                                  </div>
                                <?php endif;?>
                                
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>       

                      <!-- Modal for displaying Completed Appointments -->
                    <div class="container">
                          <div class="modal fade" id="completeModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title">Completed Appointments</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                  <?php if($complete):?>
                                    <table class="table table-bordered table1">
                                      <thead>
                                        <tr>
                                          <th>Date</th>
                                          <th>Time</th>
                                          <th>Appt Code</th>
                                          <th>Service</th>
                                          <th>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        
                                        <?php foreach($complete as $p):  ?>
                                          <tr>
                                            <td><?php echo date("M d, Y",strtotime($p['appt_date'])); ?></td>
                                            <?php $time = explode(":",$p['appt_time']);?>
                                             <?php if($time[0] == '00'):?>
                                                 <td>N/A</td>
                                              <?php elseif ($time[0]>=12):?>
                                                  <?php $hour = $time[0] - 12;?>
                                                  <?php $amPm = "PM";?>
                                                  <td><?php echo $hour . ":" . $time[1] . " " . $amPm;?></td>
                                              <?php else:?>
                                                  <?php $hour = $time[0]; ?>
                                                  <?php $amPm = "AM"; ?>
                                                  <td><?php echo $hour . ":" . $time[1] . " " . $amPm;?></td>
                                             <?php endif;?>
                                            <td><?php echo $p['appt_code']; ?></td>
                                            <td><?php echo $p['serv_name']; ?></td>
                                            <td><?php echo $p['appt_status'];?></td>
                                           
                                        </tr>
                                      <?php endforeach;?>
                                    </tbody>
                                  </table>
                                  
                                <?php else:?>
                                  <div class="Nowork">
                                    <p class="noworkstatement"><i class="fa-solid text-success fa-circle-exclamation"></i>&nbsp;No Complete Appointment Yet</p>
                                  </div>
                                <?php endif;?>
                                
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>           

                       <!-- Modal for displaying Reject Appointments -->
                    <div class="container">
                          <div class="modal fade" id="rejectModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title">Rejected Appointments</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                  <?php if($reject):?>
                                    <table class="table table-bordered table1">
                                      <thead>
                                        <tr>
                                          <th>Date</th>
                                          <th>Time</th>
                                          <th>Appt Code</th>
                                          <th>Service</th>
                                          <th>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        
                                        <?php foreach($reject as $p):  ?>
                                          <tr>
                                            <td><?php echo date("M d, Y",strtotime($p['appt_date'])); ?></td>
                                            <?php $time = explode(":",$p['appt_time']);?>
                                             <?php if($time[0] == '00'):?>
                                                 <td>N/A</td>
                                              <?php elseif ($time[0]>=12):?>
                                                  <?php $hour = $time[0] - 12;?>
                                                  <?php $amPm = "PM";?>
                                                  <td><?php echo $hour . ":" . $time[1] . " " . $amPm;?></td>
                                              <?php else:?>
                                                  <?php $hour = $time[0]; ?>
                                                  <?php $amPm = "AM"; ?>
                                                  <td><?php echo $hour . ":" . $time[1] . " " . $amPm;?></td>
                                             <?php endif;?>
                                            <td><?php echo $p['appt_code']; ?></td>
                                            <td><?php echo $p['serv_name']; ?></td>
                                            <td><?php echo $p['appt_status'];?></td>
                                           
                                        </tr>
                                      <?php endforeach;?>
                                    </tbody>
                                  </table>
                                  
                                <?php else:?>
                                  <div class="Nowork">
                                    <p class="noworkstatement"><i class="fa-solid text-success fa-circle-exclamation"></i>&nbsp;No Reject Appointment</p>
                                  </div>
                                <?php endif;?>
                                
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>   
</div>

<!-- Content Row -->
<div class="row">

  <!-- Card for displaying the total count of today's event -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body1">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">
              Pending Appointment</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">#:&nbsp;<a href="#" data-toggle="modal" data-target="#pendingModal" id="iconbox"><?= json_encode($count_pending);?></a></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300" id="iconbox"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Weekly -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body1">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">
                Approved Appointment</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">#: <a href="#" data-toggle="modal" data-target="#approveModal" id="iconbox"><?= json_encode($count_approve);?></a></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-gray-300" id="iconbox"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--Completed -->


      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body1">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-uppercase mb-1">Completed: <?= json_encode($count_complete);?> out of <?= json_encode($count_total);?>
              </div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" ><a href="#" data-toggle="modal" data-target="#completeModal" id="iconbox">
                    
                   <?php if(json_encode($count_total) > 0):?>
                      <?= json_encode($percent);?>%
                      <?php else:?>0%
                    <?php endif;?>
                  </a></div>
                </div>
                <div class="col">
                  <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-success" role="progressbar"
                    style="width: <?php if(json_encode($count_total) > 0):?>
                    <?= json_encode($percent);?>%
                    <?php else:?>0%
                    <?php endif;?>;" aria-valuenow="<?= json_encode($count_complete);?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300" id="iconbox"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body1">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">
              Rejected</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">#:&nbsp;<a href="#" data-toggle="modal" data-target="#rejectModal" id="iconbox"><?= json_encode($count_reject);?></a></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300" id="iconbox"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Calendar -->

<div class="body-content">
  <div class="col-sm-8">
    <div class="crud-text"><h3>Calendar</h3></div>
 </div>
<div class="card legend-box" id="cal1">
    <div class="card-header">Legend</div>
    <div class="card-body">
      <ul class="legend-list">
        <?php foreach ($servName as $s): ?>
          <li ><i class="fas fa-circle" style="color: <?=$s['serv_color'];?>"></i><?=$s['serv_name'];?></li>
        <?php endforeach ?>
      </ul>
    </div>
    </div>

<div id='calendar' class="col-lg-12 col-md-10" style="width:100%;"></div>
<div id='datepicker'></div>
</div>
</div>
<!-- insert -->
<div id="mymodal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document" id="dialog">
    <div class="modal-content">
     <form action="<?= base_url('/calendar/insert');?>" method="POST"> 
      <div class="modal-header">
        <h4 class="modal-title">Add Schedule</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="adata">

        <input type="hidden" name="start_event" id="start_event" value="">
        <div class="form-group">
          <input class="form-control" type="hidden" name="title" id="title" placeholder="Title">
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="time">Time</label><br>
            <input type="time" name="time" id="time" value="00:00:00">
          </div>
          <div class="form-group col-md-6">
            <label for="repeatable">Repeat</label><br>
            <select id="repeatable" name = "repeatable">
              <option value="None">None</option>
              <option value="Weekly">Weekly</option>
              <option value="Monthly">Monthly</option>
            </select>
          </div>
        </div>
        <h3>Client Details:</h3>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="area">Branch Area</label><br>
            <select id="area" name="area" class="form-control">
              <?php foreach($area as $cl):  ?>
                <option value=<?php echo $cl['area']; ?>><?php echo $cl['area'];?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="client_id">Branch Name</label><br>
            <select id="client_id" name="client_id" class="form-control" required>

            </select>
          </div>
        </div>
        <div class="form-group">
          
          <label for="serv_id">Service</label><br>
          <select id="serv_id" name="serv_id" class="form-control" required>
            <?php foreach($servName as $s):  ?>
              <optgroup label="<?= $s['serv_name']; ?>">
                <?php foreach($servType as $st):  ?>
                  <?php if($st['serv_name'] == $s['serv_name']):?>
                    <option value=<?= $st['serv_id'];?>><?= $st['serv_type'];?></option>
                  <?php endif;?>
                <?php endforeach; ?>
              </optgroup>
            <?php endforeach; ?>
          </select>
        </div>
        <h3>Aircon Details:</h3>
        <div class="form-row">
          <div class="form-group col-md-3">
            
            <label for="dbrand">Device Brand</label>
            <select id="device_brand" name="device_brand[]" class="form-control " data-id="0"required>
              <option value="">Select Brand</option>
              <?php foreach($device_brand as $d_b):  ?>
                <option value=<?php echo $d_b['device_brand']; ?>><?php echo $d_b['device_brand'];?></option>
              <?php endforeach; ?>
            </select>
          </div> 
          <div class="form-group col-md-3">
            
            <label for="aircont">Aircon Type</label>

            <select id="aircon_id_0" name="aircon_id[]" class="form-control aircon" required>
              <option value="">Select Type</option>
            </select>
          </div> 
          <div class="form-group col-md-3">
            
            <label for="fcunos">Fcuno</label>
            <select id="fcuno" name="fcuno0[]" class="selectpicker" data-width="100%" multiple data-selected-text-format="count > 3">
              <?php foreach($fcu_no as $f):  ?>
                <option value="<?php echo $f['fcuno']; ?>"><p id="s2option"><?php echo $f['fcu'];?></p></option>
              <?php endforeach; ?>
            </select>
          </div> 
          <div class="form-group col-md-2">
            
            <label for="fcunos">Quantity</label>
            <input type="number" class="form-control" name="quantity[]" id="quantity" min="1" value="1" required>
          </div> 
          <div class="form-group col-md-1"><br>
            <span id="add_aut" class="btn btn-primary"><i class="fa-solid fa-plus"></i></span>
          </div>
        </div>
        <div id="auth-rows"></div>
        <div class="form-group">
          
          <label for="emp_id">Employee</label><br>
          <select id="emp_id" name="emp_id[]" class="form-control selectpicker" multiple data-selected-text-format="count > 8" required>
            <?php foreach($emp as $em):  ?>
              <option value=<?php echo $em['emp_id']; ?>><?php echo $em['emp_name'];?></option>
            <?php endforeach; ?>
          </select>
        </div> 


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
  </div>
</div>
</div>
<!-- update -->
<div class="modal fade" id="mymodal2" tabindex="-1" role="dialog">
  <div class="modal-dialog" id="dialog2" role="document">
    <div class="modal-content">
     
      <div class="modal-header">
        <h3 class="modal-title">Your Schedule</h3>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('/calendar/update');?>" method="POST"> 
        <div class="modal-body" id="adata">
          <input type="hidden" name="id" id="id" value="">
          <!-- <h5>Title</h5> -->
          <input class="form-control" type="hidden" name="title_update" id="title_update" placeholder="Title">
          <label for="event_code">Event Code: </label>
          <input type="text" name="event_code" id="event_code" value="" disabled>
          <div class="form-row">
            <div class="form-group col-md-6">
             <label for="start_event_update">Date</label><br>
             <input type="date" name="start_event_update" id="start_event_update" disabled>
           </div>
           <div class="form-group col-md-6">
            <label for="time_update">Time</label><br>
            <input type="time" name="time_update" id="time_update" disabled>
          </div>
        </div>
        <h3>Client Details:</h3>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="area_update">Branch Area</label><br>
            <select id="area_update" name="area_update" class="form-control" disabled>
              
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="client_id_update">Branch Name</label><br>
            <select id="client_id_update" name="client_id_update" class="form-control" disabled>

            </select>
          </div>
        </div>
        
        <div class="form-group">
          
          <label for="serv_id_update">Service</label><br>
          <select class="form-control" id="serv_id_update" name="serv_id_update" disabled>
            <?php foreach($servName as $s):  ?>
              <optgroup label="<?= $s['serv_name']; ?>">
                <?php foreach($servType as $st):  ?>
                  <?php if($st['serv_name'] == $s['serv_name']):?>
                    <option value=<?= $st['serv_id'];?>><?= $st['serv_type'];?></option>
                  <?php endif;?>
                <?php endforeach; ?>
              </optgroup>
            <?php endforeach; ?>
          </select>
        </div> 

         <h3>Aircon Details:</h3>

        <!-- =================================================== -->
        <div id="auth-rows-edit"></div>


        <!-- <div class="form-row" >
          <div class="form-group col-md-12" align="center" style="background-color:lightgreen;">
            <span id="add_aut_update" class="btn btn-primary"><i class="fa-solid fa-plus"></i></span>
          </div> 
        </div> -->

        <div class="form-group">
          
          <label for="emp_id_update">Employee</label><br>
          <select id="emp_id_update" name="emp_id_update[]" class="form-control selectpicker" multiple data-selected-text-format="count > 8" disabled>
            <!--  -->
          </select>
        </div> 
      </div>
      <div class="modal-footer">
        <div class="form-group">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.js"></script>




<!-- Time Picker -->
<script src = "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>  
<!-- <script src = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>   -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<!--  -->

<!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script> -->
<script src="<?=base_url("assets/js/main.min.js")?>"></script>

<script type="text/javascript">

$(document).ready( function () {
    $('.table1').DataTable({
        pageLength : 5,
        lengthMenu: [[5, 10, 15,20], [5, 10, 15, 20,]]
      });
});


var event = <?php echo json_encode($event); ?>;

var areas = <?php echo json_encode($area); ?>;
var c_area = <?php echo json_encode($client_area2); ?> ;

var emp_all = <?php echo json_encode($emp); ?>;

var areas1 = <?php echo json_encode($client_area); ?> ;
var airconD = <?php echo json_encode($client_area); ?> ;
var distinct = <?php echo json_encode($distinct); ?> ;
var distinctEvent = <?php echo json_encode($distinct_event); ?> ;
var deviceBrand = <?php echo json_encode($device_brand); ?> ;

</script>
<script type="text/javascript" src="<?=base_url('assets/js/empCalendar.js')?>"></script>
</body>
