<link rel="stylesheet" href="<?= base_url('assets/css/style.css')?>">

<!-- rate service -->
<div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Service Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?=base_url('/appointment/rate-service')?>">
      <div class="modal-body">
        <div class="container">
          <center><h2>Service's Review</h2></center>
          <div class="row">
            <div class="col-lg-4">
               <p class="servq">Service Quality</p>
            </div>
            <div class="rate col-lg-6">
              <input type="radio" id="star5" name="rate" value="5" />
              <label for="star5" title="Amazing">5 stars</label>
              <input type="radio" id="star4" name="rate" value="4" />
              <label for="star4" title="Good">4 stars</label>
              <input type="radio" id="star3" name="rate" value="3" />
              <label for="star3" title="Fair">3 stars</label>
              <input type="radio" id="star2" name="rate" value="2" />
              <label for="star2" title="Poor">2 stars</label>
              <input type="radio" id="star1" name="rate" value="1" />
              <label for="star1" title="Terrible">1 star</label>
            </div>
            <div class="col-lg-2 result"></div>
          </div>
          <textarea name="comments" placeholder="Share more thoughts on our service..." rows="4" cols="50"></textarea>
          <center><h2>Technician's Review</h2></center>
          <div class="techRate">
            
          </div>
          
        </div>
        
        
        <h6></h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- view appointments -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
           <div class="col-md-6">
            
               <table class="table-hover" style="width:100%">
                  <tr>
                    <th>Date:</th>
                    <td id="modal_start_event"></td>
                  </tr>
                  <tr>
                    <th>Time:</th>
                    <td id="modal_time"></td>
                  </tr>
                  <tr>
                    <th>Appt Code:</th>
                    <td id="modal_appt_code"></td>
                  </tr>
                  <tr>
                    <th>Area:</th>
                    <td id="modal_area"></td>
                  </tr>
                  <tr>
                    <th>Client Branch:</th>
                    <td id="modal_branch"></td>
                  </tr>
                  <tr>
                    <th>Service Name:</th>
                    <td id="modal_serv_name"></td>
                  </tr>
              </table>
            </div>
           <div class="col-md-6">
            <table class="table-hover" style="width:100%">
                  <tr>
                    <th>Service Type:</th>
                    <td id="modal_serv_type"></td>
                  </tr>
                  <tr>
                    <th>Device Brand:</th>
                    <td id="modal_dev_brand"></td>
                  </tr>
                  <tr>
                    <th>Aircon Type:</th>
                    <td id="modal_aircon_type"></td>
                  </tr>
                  <tr>
                    <th>FCU #:</th>
                    <td id="modal_fcu"></td>
                  </tr>
                  <tr>
                    <th>Quantity:</th>
                    <td id="modal_qty"></td>
                  </tr>
                  <tr>
                    <th>Status:</th>
                    <td id="modal_status"></td>
                  </tr>
                  
              </table>
           </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="body-content">
	<div class="crud-text"> <h3>Schedule Appointment</h3></div>

  <div class="d-flex justify-content-left">
    <a href="<?=base_url("/appointment/create")?>" class="btn">Add Appointment</a>
 </div>
 <div class="mt-3">
   <?php if($view_appoint):?>
    <table class="table table-bordered" id="appt-table" style="font-size: 1.2rem;">
     <thead>
        <tr>
           <th>Date</th>
           <th>Time</th>
           <th>Appt Code</th>
           <th>Status</th>
           <th>Review</th>
           <th>Action</th>
        </tr>
     </thead>
     <tbody>
      <?php foreach($view_appoint as $appt):  ?>
        <tr>
           <td><?php echo $appt->appt_date; ?></td>
           <?php $time = explode(":",$appt->appt_time);?>
                 <?php if($time[0] == '00'):?>
                     <td>N/A</td>
                  <?php elseif ($time[0]>=12):?>
                      <?php $hour = $time[0] - 12;?>
                      <?php $amPm = "PM";?>
                      <td><?php echo $hour . ":" . $time[1] . " " . $amPm;?></td>
                  <?php else:?>
                      <?php $hour = $time[0]; ?>
                      <?php $amPm = "AM"; ?>
                      <td><?php echo  ltrim($hour, '0') . ":" . $time[1] . " " . $amPm;?></td>
                  <?php endif;?>
           <td><?php echo $appt->appt_code; ?></td>
           <td><?php echo $appt->appt_status; ?></td>
           <td>
            <?php if($appt->appt_status == 'Done'):?>
              <?php if($appt->rate == 0):?>
                <a href=# id="<?php echo $appt->appt_id;?>" class="btn btn-success btn-sm ratea" data-toggle="modal" data-target="#rateModal">Rate</a>
              <?php endif;?>
            <?php endif;?>
           </td>
           <td>
            
            <a href="#" id="<?php echo $appt->appt_id;?>" class="btn btn-info btn-sm view">View</a>
            <?php if($appt->appt_date >= date('Y-m-d') && $appt->appt_status != 'Cancelled' && $appt->appt_status != 'Done'):?>
              <a href="<?php echo base_url('/appointment/'.$appt->appt_id);?>" class="btn btn-primary btn-sm">Edit</a>
               
              <a href="<?php echo base_url('/appointment/delete/'.$appt->appt_id);?>"class="btn btn-danger btn-sm del">Cancel</a>
            <?php endif;?>
          </td>
       </tr>
    <?php endforeach; ?>
 </tbody>
</table>
<?php else: ?>
 <h1>No Appointment Yet!</h1>
<?php endif; ?>
</div>
</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
   var msg = ''; 
   var del = '';
   var add = '';
   var update = '';
   <?php if(session()->has('msg')){?>
      msg = true;
      del = 'Appointment is Deleted Successfully';
   <?php }elseif(session()->has('add')){?>
      add = true;
      del = 'New Appointment is Added Successfully';
   <?php }elseif(session()->has('update')){?>
      update = true;
      del = 'Appointment Details are Updated Successfully';
      <?php }?>;

    <?php if(session()->has('Error')){?>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: '<?= session()->getFlashdata('Error')?>',
    })
   <?php }?>;

      $(document).on('click','.view',function(e){
      // console.log(e.target.id);
      var id = e.target.id;
      // console.log(id);
      var options = { year: 'numeric', month: 'long', day: 'numeric' };

      var myModal = new bootstrap.Modal(document.getElementById('viewModal'));
      $.ajax({
         method: 'Post',
         url: 'http://localhost/tsms/appointment/view',
         data:{
            'appt_id': id
         },
         success: function(response){
          console.log(response);
            var date = new Date(response.appt_data.appt_date);
            var startEvent = date.toLocaleDateString("en-US",(options));
            var apptCode = response.appt_data.appt_code;
            var clientId = response.appt_data.client_id;
            var clientData = response.client_data;
            var area;
            var branch;
            var servId = response.appt_data.serv_id;
            var servData = response.serv_data;
            var servName;
            var servType;
            var time = response.appt_data.appt_time.split(":");
            var formatTime;
            var devBrand = response.appt_data.device_brand;
            var airconType = response.appt_data.aircon_type;
            var fcuNoArr = new Array();
            var fcuData = response.fcu_data;
            var fcuNo;
            var qty = response.appt_data.qty;
            var statusData = response.appt_data.appt_status;

            $('#modalTitle').html("["+apptCode+"] Schedule");
            $('#modal_start_event').html(startEvent);
            $('#modal_appt_code').html(apptCode);
            
            if(time[0] == '00'){
               formatTime = 'N/A';
            }else if (time[0]>=12){
                var hour = time[0] - 12;
                var amPm = "PM";
                formatTime = hour + ":" + time[1] + " " + amPm;
            } else {
                var hour = time[0]; 
                var amPm = "AM";
                formatTime = parseInt(hour) + ":" + time[1] + " " + amPm;
            }
            
            $('#modal_time').html(formatTime);

            for (var a = 0; a < clientData.length; a++) {
               if(clientId == clientData[a].client_id){
                  area = clientData[a].area;
                  branch = clientData[a].client_branch;
               }
            }
            $('#modal_area').html(area);
            $('#modal_branch').html(branch);

            for (var b = 0; b < servData.length; b++) {
               if(servId == servData[b].serv_id){
                  servName = servData[b].serv_name;
                  servType = servData[b].serv_type;
               }
            }
            $('#modal_serv_name').html(servName);
            $('#modal_serv_type').html(servType);
            $('#modal_dev_brand').html(devBrand);
            $('#modal_aircon_type').html(airconType);

            for (var i = 0; i < fcuData.length; i++) {
               if(id == fcuData[i].appt_id){
                  fcuNoArr.push(response.fcu_data[i].fcu);
               }
            }
            fcuNo = fcuNoArr.toString();
            $('#modal_fcu').html(fcuNo);
            $('#modal_qty').html(qty);
            $('#modal_status').html(statusData);
            console.log(response);
            myModal.show();
            }
         })
      })


      $('.ratea').click(function(){
        var id = $(this).attr('id');
        var employeeId = new Array();
        var myModal = new bootstrap.Modal(document.getElementById('rateModal'));
        $.ajax({
           method: 'Get',
           url: 'http://localhost/tsms/appointment/getEmp',
           data:{
              'appt_id': id
           },
           success: function(response){
            var events = response.eventEmp;
            // console.log(events);
            var apptEvents = new Array();
            var eventId;
            var apptId;
            var idEmp = new Array();
            for(var i =0; i<events.length; i++){
              var apptData = response.eventEmp[i];
              var appt = apptData.appt_code.split("-");
              var code = appt[2];
              if(code == id){
                apptEvents.push(apptData);
                eventId = apptData.id;
                apptId = code;
              }
            }
            // console.log(eventId);
            $('.techRate').empty();
            for (var i = 0; i < apptEvents.length; i++) {
              var empId = apptEvents[i].emp_id;
              idEmp.push(empId);
              // console.log(`resulttech`+empId+`"`);
              // console.log('.resulttech'+empId);

              $('.techRate').append(`<h5>`+apptEvents[i].emp_name+`</h5><div class="row rowa">
            <div class="col-lg-5">
               <p class="servq">Technician Quality</p>
            </div>
            <input type="hidden" value="`+eventId+`" name="event_id">
            <input type="hidden" value="`+id+`" name="appt_id">
            <input type="hidden" value="`+empId+`" name="emp_id[]" multiple>
            
            <div class="tech col-lg-6">
              <input type="radio" id="star5`+empId+`" name="rate_`+empId+`" value="5" />
              <label for="star5`+empId+`" title="Amazing">5 stars</label>
              <input type="radio" id="star4`+empId+`" name="rate_`+empId+`" value="4" />
              <label for="star4`+empId+`" title="Good">4 stars</label>
              <input type="radio" id="star3`+empId+`" name="rate_`+empId+`" value="3" />
              <label for="star3`+empId+`" title="Fair">3 stars</label>
              <input type="radio" id="star2`+empId+`" name="rate_`+empId+`" value="2" />
              <label for="star2`+empId+`" title="Poor">2 stars</label>
              <input type="radio" id="star1`+empId+`" name="rate_`+empId+`" value="1" />
              <label for="star1`+empId+`" title="Terrible">1 star</label>
            </div>
            <div class="col-lg-1 resulttech" id= a`+empId+`></div>
          </div>
          <textarea name="techComments[]" placeholder="Leave a comment..." rows="4" cols="50" multiple></textarea>`);
            }
           // console.log(idEmp);
           }
         })
      })


      // $('#star5').click(function(){
      //   $('.result').html('<h6>Amazing</h6>');
      // })
      // $('#star4').click(function(){
      //   $('.result').html('<h6>Good</h6>');
      // })
      // $('#star3').click(function(){
      //   $('.result').html('<h6>Fair</h6>');
      // })
      // $('#star2').click(function(){
      //   $('.result').html('<h6>Poor</h6>');
      // })
      // $('#star1').click(function(){
      //   $('.result').html('<h6>Terrible</h6>');
      // })
      
   </script>
   <script type="text/javascript" src="<?= base_url('assets/js/crud.js')?>"></script>
