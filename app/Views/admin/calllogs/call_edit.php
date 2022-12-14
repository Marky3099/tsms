<link rel="stylesheet" href="<?= base_url('assets/css/formstyle.css')?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.css');?>">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
<div class="body-content" style="height: 100%;">
  <div class="edit-form">
    <form method="post" id="update_user" name="update_user" 
    action="<?= base_url('/calllogs/update') ?>">
    <input type="hidden" name="cl_id" id="id" value="<?php echo $cl_obj['cl_id']; ?>">
    
    <div class="form-box" style="height: 600px; top: 45%;">
      <h3>Edit Log Information</h3>
      
      <div class="user-box">
        <label>Branch Area</label>
        <label class="tdate">Date</label><br>
        <input type="text" name="date" id="date" class="form-control datepicker datee" placeholder="mm-dd-yyyy" value="<?php echo $new_date; ?>" autocomplete="off" required>
        <div class="select-dropdown" style="width: 40%;">
          <select id="area_update" name="area_update">
            <?php foreach($area as $a):  ?>
              <option value="<?php echo $a['area'];?>"<?php if($a['area'] == $cl_views['area']) echo 'selected="selected"';?>><?php echo $a['area'];?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <label>Branch Name</label>
      <div class="select-dropdown">
        <select id="client_id_update" name="client_id_update"></select>
      </div>

      <div class="user-box">
        <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
        <input type="text" name="caller" value="<?php echo $cl_obj['caller']; ?>">
      </div>

      <div class="user-box">
        <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
        <input type="text" name="particulars" size="50" value="<?php echo $cl_obj['particulars']; ?>">
      </div>

      <div class="user-box" style="height: 75px">
        <label>Device Brand</label>
        <label id="Atype">Aircon Type</label>
        <div class="select-dropdown" style="width: 40%; position: relative;">
          <select id="device_brand_update" name="device_brand_update">
            <?php foreach($device_brand as $d_b):  ?>
              <option value="<?php echo $d_b['device_brand']; ?>"<?php if($d_b['device_brand']==$cl_views['device_brand'])echo 'selected="selected"';?>><?php echo $d_b['device_brand'];?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="select-dropdown" style="width: 40%; margin-left: 257px; top: -46px;">
          <select id="aircon_id_update" name="aircon_id_update">
          </select>
        </div>
      </div>

      <div class="user-box">
        <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
        <input type="number" name="qty" min="1" value="<?php echo $cl_obj['qty']; ?>">
      </div>

      <div class="user-box" style="margin-top: 5px;">
        <label>FCU Number</label>
        <select id="fcuno_update" name="fcuno_update[]" multiple="multiple">
          <?php foreach($fcu_no as $f):  ?>
            <?php foreach($fcu_views as $fv):  ?>
              <option value="<?php echo $f['fcuno'];?>"<?php if($f['fcuno']==$fv['fcuno'])echo 'selected';?>><p id="s2option"><?php echo $f['fcu'];?></p></option>
            <?php endforeach; ?>
          <?php endforeach; ?>
        </select>
    
      </div>

      <div class="container1">
        <button type="submit" class="btn btn-success">Update</button>
        <a href='<?= base_url('/calllogs');?>' class="back-btn">Back</a>
      </div> 
    </div>

  </div>
</form>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">

  $('#fcuno_update').select2();
  var areas = <?php echo json_encode($client_area); ?> ;
  var client_current_area = <?php echo json_encode($cl_obj); ?> ;
      //     $.each(areas[0], function(key, v) {
      //     // alert(value.client_id+" "+value.client_branch);
      //      // console.log(v);
      //      $.each(v, function(key, value) {
      //     $("#client_id").append('<option value='+value.client_id+'>'+value.client_branch+'</option>');
      //   });
      // });



      
      $("#client_id_update").empty();
      var current_value = document.getElementById("area_update").selectedIndex;
      
      $.each(areas[current_value], function(key, v) {
          // alert(value.client_id+" "+value.client_branch);
          
          $.each(v, function(key, value) {
           
            if (client_current_area.client_id == value.client_id) {
              $("#client_id_update").append('<option value='+value.client_id+' selected>'+value.client_branch+'</option>')
              
            }else{
              $("#client_id_update").append('<option value='+value.client_id+'>'+value.client_branch+'</option>')
            }
          });
        });
      
      $("#area_update").change(function(){
        $("#client_id_update").empty();
        var current_value = document.getElementById("area_update").selectedIndex;

        $.each(areas[current_value], function(key, v) {
          // alert(value.client_id+" "+value.client_branch);
          
          $.each(v, function(key, value) {
           console.log(value.client_branch);
           $("#client_id_update").append('<option value='+value.client_id+'>'+value.client_branch+'</option>')
         });
        });
        // $("#area").append('<option value='+'>My option</option>');
      });


  // ---------------------------------------------
  var devbrand = <?php echo json_encode($brand); ?> ;

  $("#aircon_id_update").empty();
  var current_value = document.getElementById("device_brand_update").selectedIndex;
  $.each(devbrand[current_value], function(key, v) {
          // alert(value.client_id+" "+value.client_branch);
          
          $.each(v, function(key, value) {
            if (client_current_area.aircon_id == value.aircon_id) {
              $("#aircon_id_update").append('<option value='+value.aircon_id+' selected>'+value.aircon_type+'</option>')
            }else{
              $("#aircon_id_update").append('<option value='+value.aircon_id+'>'+value.aircon_type+'</option>')
            }
          });
        });

  $("#device_brand_update").change(function(){
    $("#aircon_id_update").empty();
    var current_value = document.getElementById("device_brand_update").selectedIndex;
    $.each(devbrand[current_value], function(key, v) {
          // alert(value.client_id+" "+value.client_branch);
          console.log(v);
          $.each(v, function(key, value) {
            $("#aircon_id_update").append('<option value='+value.aircon_id+'>'+value.aircon_type+'</option>')
          });
        });
        // $("#area").append('<option value='+'>My option</option>');
      });

  var disableDates = ["1-1","1-2","25-2","9-4","14-4","16-4","1-5","9-5","12-6","29-8","21-8","31-10","1-11","2-11","30-11","8-12","24-12","25-12","30-12","31-12"];
      
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        beforeShowDay: function(date){
            dmy = date.getDate() + "-" + (date.getMonth() + 1);
            if(disableDates.indexOf(dmy) != -1 || date.getDay() == 0 || date.getDay() == 6){
                return false;
            }
            else{
                return true;
            }
        }
    });


  
</script>