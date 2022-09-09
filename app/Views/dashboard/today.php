<div class="body-content">
<div class="event-header">
 <h1 id="mod"><b>Today's Scheduled Tasks - <?= date('F j, Y');?></b></h1>
   
    <div class="d-flex justify-content-left" style="margin-left:20px;">
        <a href="<?= base_url('/calendar');?>" class="btn">Calendar</a>
        <a href="<?= base_url('/calendar/events');?>" class="btn">Scheduled Tasks</a>
        <a href="<?= base_url('/calendar/events/today/print');?>" class="btn">Download</a>
   </div>
    
 </div>
 <div class="col-sm-12 mt-3 bg-light" style=" padding:10px;">
   <?php if($day): ?>
      <table class="table table-bordered" id="table1">
       <thead>
          <tr>
             <th>Event Title</th>
             <th>Date</th>
             <th>Time</th>
             <th>Area</th>
             <th>Client Branch</th>
             <th>Service</th>
             <th>Device Brand</th>
             <th>Aircon Type</th>
             <th>FCU No.</th>
             <th>Quantity</th>
             <th>Employee</th>
             <th>Status</th>
             
          </tr>
       </thead>
       <tbody>
          
          <?php foreach($day as $d):  ?>
          <tr>
             <td>
               <?php if($d->title == NULL): ?>
                  <?php echo "N/A"; ?>
               <?php else:?>
               <?php echo $d->title; ?>
                  <?php endif;?>
               </td>
             <td><?php echo date('m-d-Y',strtotime($d->start_event)); ?></td>
             <td>
               <?php if($d->time == "00:00:00"): ?>
                  <?php echo "N/A"; ?>
               <?php else:?>
               <?php echo $d->time; ?>
                  <?php endif;?>
             </td>
             <td><?php echo $d->area; ?></td>
             <td><?php echo $d->client_branch; ?></td>
             <td><?php echo $d->serv_name; ?></td>
             <td><?php echo $d->device_brand; ?></td>
             <td><?php echo $d->aircon_type; ?></td>
             <td>
               <?php $data1 = explode(',',$d->fcu_array);
                     $count1 = 0;
                ?>
                  <?php foreach($data1 as $fc):  ?>
                     <?php if($count1 < (count($data1) - 1) ):  ?>
                      <?php echo $fc; $count1+=1; ?> <br>
                      <?php endif;  ?>
                  <?php endforeach; ?>
             </td> 
             <td><?php echo $d->quantity; ?></td>
             <td>
               <?php $data = explode(',',$d->emp_array);
                     $count = 0;
                ?>
                  <?php foreach($data as $emp):  ?>
                     <?php if($count < (count($data) - 1) ):  ?>
                     * <?php echo $emp; $count+=1; ?> <br>
                      <?php endif;  ?>
                  <?php endforeach; ?>
             </td> 
             <?php if($d->status == 'Pending'):?>
             <td style="color:#4F6FA6;"><b>
               <?php echo $d->status; ?>
                  </b>
               </td>
               <?php else:?>
               <td><b>
               <?php echo $d->status; ?>
                  </b>
               </td>
            <?php endif;?>
           
          </tr>
          <?php endforeach; ?>
         
       </tbody>
     </table>
     <?php else: ?>
      <h3 style="text-align:center;">Ooops.. No work for today!</h3>
     <?php endif; ?>
</div>
</div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready( function () {
    $('#table1').DataTable();
} );
</script>