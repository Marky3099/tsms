<div class="body-content">
	<div class="crud-text"> <h1>Schedule Appointment</h1></div>

    <div class="d-flex justify-content-left">
        <a href="<?=base_url("/appointment/create")?>" class="btn">Add Appointment</a>
   </div>
<!--     <?php
     if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
      }
     ?> -->
     <?php 
        // Display Response
        if(session()->has('message')){
        ?>
           <div class="alert <?= session()->getFlashdata('alert-class') ?>">
              <?= session()->getFlashdata('message') ?>
           </div>
        <?php
        }
        ?>
  <div class="mt-3">
   <?php if($view_appoint):?>
     <table class="table table-bordered" id="table1">
       <thead>
          <tr>
             <th>Date</th>
             <th>Time</th>
             <th>Branch Area</th>
             <th>Branch Name</th>
             <th>Service</th>
             <th>Service Type</th>
             <th>Device Brand</th>
             <th>Aircon Type</th>
             <th>FCU No.</th>
             <th>Qty.</th>
             <th>Status</th>
             <th>Action</th>
          </tr>
       </thead>
       <tbody>
         <?php foreach($view_appoint as $appt):  ?>
          <tr>
             <td><?php echo $appt->appt_date; ?></td>
             <td><?php echo $appt->appt_time; ?></td>
             <td><?php echo $appt->area; ?></td>
             <td><?php echo $appt->client_branch; ?></td>
             <td><?php echo $appt->serv_name; ?></td>
             <td>N/A</td>
             <td><?php echo $appt->device_brand; ?></td>
             <td><?php echo $appt->aircon_type; ?></td>
             <td> <?php $data1 = explode(',',$appt->fcu_arr);
                     $count1 = 0;
                ?>
                  <?php foreach($data1 as $fc):  ?>
                     <?php if($count1 < (count($data1) - 1) ):  ?>
                      <?php echo $fc; $count1+=1; ?> <br>
                      <?php endif;  ?>
                  <?php endforeach; ?></td>
             <td><?php echo $appt->qty; ?></td>
             <td><?php echo $appt->appt_status; ?></td>
             <td>
              <a href="<?php echo base_url('/appointment/'.$appt->appt_id);?>" class="btn btn-primary btn-sm">Edit</a>
              <a href="<?php echo base_url('/appointment/delete/'.$appt->appt_id);?>"class="btn btn-danger btn-sm del">Delete</a>
              </td>
          </tr>
          <?php endforeach; ?>
       </tbody>
     </table>
     <?php else: ?>
        <h1>No Appointmeent Yet!</h1>
      <?php endif; ?>
  </div>
</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">

   $('.del').click(function(e){
    e.preventDefault();
    const href = $(this).attr('href');
    Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            document.location.href = href;
            
          }
        })

 });
   <?php if(session()->getFlashdata('msg')) {?>
      // alert('Delete');
      Swal.fire({
             icon: 'success',
             title: 'Deleted!',
             text: 'Record has been deleted.',
             type: 'success'
            })
   <?php }?>
   <?php if(session()->getFlashdata('add')) {?>
      // alert('Delete');
      Swal.fire({
             icon: 'success',
             title: 'Appointment Added!',
             text: 'New Appointment is added Successfully',
             type: 'success'
            })
   <?php }?>
   <?php if(session()->getFlashdata('update')) {?>
      // alert('Delete');
      Swal.fire({
             icon: 'success',
             title: 'Appointment Updated!',
             text: 'Appointment details Updated Successfully',
             type: 'success'
            })
   <?php }?>
   $(document).ready( function () {
    $('#table1').DataTable({
    pageLength : 5,
    lengthMenu: [[5, 10, 15,20], [5, 10, 15, 20,]]
  });
} );
</script>
