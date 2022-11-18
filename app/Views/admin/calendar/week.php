<div class="body-content">
   <div class="event-header">
     <h1 id="mod"><b>Weekly Scheduled Tasks - <?php 
     $monday = strtotime('last monday', strtotime('tomorrow'));

     $sunday = strtotime('+6 days', $monday);
     echo date('M j', $monday) . " to " . date('M j, Y', $sunday);?></b></h1>
     
     <div class="d-flex justify-content-left" style="margin-left:20px;">
       <a href="<?= base_url('/calendar');?>" class="btn">Calendar</a>
       <a href="<?= base_url('/calendar/events');?>" class="btn">Scheduled Tasks</a>
       <a href="<?= base_url('/calendar/events/weekly/print');?>" target="_blank" class="btn">Print</a>
    </div>
    
 </div>
 <div class="col-sm-12 mt-3 bg-light" style=" padding:10px;">
   <?php if($week): ?>
      <table class="table table-bordered" id="table1">
        <thead>
           <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Area</th>
              <th>Client Branch</th>
              <th>Service</th>
              <th>Service Type</th>
              <th>Device Brand</th>
              <th>Aircon Type</th>
              <th>FCU No.</th>
              <th>Qty</th>
              <th>Employee</th>
              <th>Status</th>
              
           </tr>
        </thead>
        <tbody>
           
           <?php foreach($week as $w):  ?>
              <tr>
               <td><?php echo date('m-d-Y',strtotime($w->start_event)); ?></td>
               <td>
                  <?php if($w->time == "00:00:00"): ?>
                     <?php echo "N/A"; ?>
                  <?php else:?>
                     <?php echo $w->time; ?>
                  <?php endif;?>
               </td>
               <td><?php echo $w->area; ?></td>
               <td><?php echo $w->client_branch; ?></td>
               <td><?php echo $w->serv_name; ?></td>
               <td><?php echo $w->serv_type; ?></td>
               <td>
                  
               <?php $current =''; ?>

               <?php foreach($distinct as $data):  ?>
                  <?php if($w->id ==  $data->id): ?>
                  <?php if($current !=  $data->device_brand):  ?>
                     <?php echo  $data->device_brand;  ?> <hr>
                     <?php $current =$data->device_brand; ?>
                  <?php endif;  ?>
                  <?php endif;  ?>
               <?php endforeach; ?>
              </td>
              <td>
              <?php $current_aircon_type =''; ?>
                  <?php foreach($distinct as $data):  ?>
                     <?php if($w->id ==  $data->id): ?>
                      <?php if($current_aircon_type !=  $data->aircon_type):  ?>
                        <?php echo $data->aircon_type;  ?> <hr>
                        <?php $current_aircon_type =$data->aircon_type; ?>
                     <?php endif;  ?>
                     <?php endif;  ?>
                 <?php endforeach; ?>
           </td>
               <td>
               <?php foreach($distinct_event as $dis_event):  ?>  
                        
                        <!--  -->
                        <?php foreach($distinct as $dis):  ?>
                           <?php $current_fcu =0; $concut = ''; ?> 
                           <?php foreach($w->fcu_array as $fcu_data):  ?> 
                         

                           <?php if( (int) $dis_event->id == $dis->id):  ?>

                              <?php if( (int) $dis->id == $fcu_data->id):  ?>
                                 <?php if( (int) $dis->aircon_id == $fcu_data->aircon_id):  ?>

                                 <?php   $concut.= $fcu_data->fcu.' ' ?>

                              <?php endif;  ?> 
                              <?php endif;  ?> 
                           <?php endif;  ?>

                        <?php endforeach; ?>
                        <?php if( $concut != ''):  ?>
                        <?php echo  $concut;  ?> <hr> 
                         <?php endif;  ?>    
                       <?php endforeach; ?>
                        <!--  -->
                        
                 <?php endforeach; ?>

              </td> 
              <td>
              <?php $current =''; ?>
                  <?php foreach($distinct as $data):  ?>
                     <?php if($w->id ==  $data->id): ?>
                      <?php if($current !=  $data->device_brand):  ?>
                        <?php echo  $data->quantity;  ?> <hr>
                        <?php $current =$data->device_brand; ?>
                     <?php endif;  ?>
                     <?php endif;  ?>
                 <?php endforeach; ?>
              </td> 
              <td>
               <?php $data = explode(',',$w->emp_array);
               $count = 0;
               ?>
               <?php foreach($data as $emp):  ?>
                  <?php if($count < (count($data) - 1) ):  ?>
                     * <?php echo $emp; $count+=1; ?> <br>
                  <?php endif;  ?>
               <?php endforeach; ?>
            </td> 
            <?php if($w->status == 'Pending'):?>
              <td style="color:#4F6FA6;"><b>
               <?php echo $w->status; ?>
            </b>
         </td>
      <?php else:?>
         <td><b>
            <?php echo $w->status; ?>
         </b>
      </td>
   <?php endif;?>
   
</tr>
<?php endforeach; ?>

</tbody>
</table>
<?php else: ?>
   <h3 style="text-align:center;">Ooops.. No work for this Week!</h3>
<?php endif; ?>
</div>
</div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
   $(document).ready( function () {
     $('#table1').DataTable({
        pageLength : 5,
        lengthMenu: [[5, 10, 15,20], [5, 10, 15, 20,]]
     });
  } );
</script>