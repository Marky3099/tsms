// Calendar JS ------------------------------------------

  document.addEventListener('DOMContentLoaded', function() {

  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    handleWindowResize: false,
    selectable: true,   
    // editable: true,
    headerToolbar: {
      left: 'prev,next',
      center: 'title',
      right: 'today',
    },
    events: event,
    // dateClick: function(info) {
    // // alert('Date: ' + info.dateStr);
    //  var myModal = new bootstrap.Modal(document.getElementById('mymodal'));
    //  var ad = document.getElementById('start_event');
    //  ad.value = info.dateStr;
    //  myModal.show();
    // },
    eventClick: function(info) {
     var myModal = new bootstrap.Modal(document.getElementById('mymodal2'));
     var tt = document.getElementById('start_event');
     // var i = document.getElementById('time');
     var ad = document.getElementById('id');
    
     var t = document.getElementById('title_update');
     var ti = document.getElementById('time_update');
     var s = document.getElementById('serv_id_update');
     var a = document.getElementById('aircon_id_update');
     var q = document.getElementById('quantity_update');
    var r = document.getElementById('start_event_update');


      // select cliend and branch
      var s1 = document.getElementById('area_update');
      var s2 = document.getElementById('client_id_update');
      s1.innerHTML='';
      s2.innerHTML='';
      
      var int_index_area = 0;
      var count = 0;

      areas.map((one_by_one_area)=>{
         var opt_one = document.createElement('option');
          opt_one.value = one_by_one_area.area;
          opt_one.innerHTML = one_by_one_area.area;
          s1.appendChild(opt_one);
          if (one_by_one_area.area == info.event.extendedProps.area ) {
            s1.value = one_by_one_area.area;
            int_index_area = count;
          }
          count +=1;
      });
    

     c_area.forEach((one, index_here)=>{

        

        if (int_index_area == index_here) {


          one.forEach((value, index)=>{

            var opt_client = document.createElement('option');
                      opt_client.value = value.client_id;
                      opt_client.innerHTML = value.client_branch;
                      s2.append(opt_client);

                      if (value.client_branch == info.event.extendedProps.client_branch ) {
                        s2.value = value.client_id;
                      }
          })

        }
         
      });
      s2.value = info.event.extendedProps.client_id;
      // -------------------------------------------------------------------------
      // select brand and aircon type
      var s3 = document.getElementById('device_brand_update');
      var s4 = document.getElementById('aircon_id_update');
      s3.innerHTML='';
      s4.innerHTML='';
      
      var int_index_area1 = 0;
      var count1 = 0;

      brand.map((one_by_one_area)=>{
        console.log(one_by_one_area);
         var opt_one = document.createElement('option');
          opt_one.value = one_by_one_area.device_brand;
          opt_one.innerHTML = one_by_one_area.device_brand;
          s3.appendChild(opt_one);

          if (one_by_one_area.device_brand == info.event.extendedProps.device_brand ) {
            s3.value = one_by_one_area.device_brand;
            int_index_area1 = count1;
          }
          count1 +=1;
      });

      
     dev_brand.forEach((ones, index_here1)=>{

        if (int_index_area1 == index_here1) {

          ones.forEach((value, index)=>{

            var opt_client1 = document.createElement('option');
                      opt_client1.value = value.aircon_id;
                      opt_client1.innerHTML = value.aircon_type;
                      s4.append(opt_client1);

                      if (value.aircon_type == info.event.extendedProps.aircon_type ) {
                        s4.value = value.aircon_id;
                      }
          })

        }
         
      });
      s4.value = info.event.extendedProps.aircon_id;
      tt.value = info.event.start_event;
      ad.value = info.event.id;
      r.value = new Date(info.event.start).toLocaleDateString("fr-CA");
      t.value = info.event.title;
      ti.value = info.event.extendedProps.time;
     
      s.value = info.event.extendedProps.serv_id;
      a.value = info.event.extendedProps.aircon_id;
      q.value = info.event.extendedProps.quantity;


// ---------------------------------------------------------------------
       document.getElementById('emp_id_update').innerHTML='';

      var arr = info.event.extendedProps.emp_array.split(',');

      emp_all.map((all_emp)=>{
        let i = 0;
         while(arr) {
             if(parseInt(arr[i]) == all_emp.emp_id){
              $("#emp_id_update").append(`
                  <option value="`+ all_emp.emp_id+`" selected>`+all_emp.emp_name+`</option>`
                );
              break;
             }

             if (emp_all.length == i) {
              $("#emp_id_update").append(`
                  <option value="`+ all_emp.emp_id+`">`+all_emp.emp_name+`</option>`
                );
              break;
             }
            
            i++;
          }

      });

      $('#emp_id_update').select2({
        dropdownParent: $('#mymodal2')
      });

     // myModal.show();
// ---------------------------------------------------------------------------
    document.getElementById('fcuno_update').innerHTML='';

      var arr1 = info.event.extendedProps.fcu_array.split(',');

      fcu_all.map((all_fcu)=>{
        let a = 0;
         while(arr1) {
             if(parseInt(arr1[a]) == all_fcu.fcuno){
              $("#fcuno_update").append(`
                  <option value="`+ all_fcu.fcuno+`" selected>`+all_fcu.fcu+`</option>`
                );
              break;
             }

             if (fcu_all.length == a) {
              $("#fcuno_update").append(`
                  <option value="`+ all_fcu.fcuno+`">`+all_fcu.fcu+`</option>`
                );
              break;
             }
            
            a++;
          }

      });

      $('#fcuno_update').select2({
        dropdownParent: $('#mymodal2')
      });
     myModal.show();

    // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
    // alert('View: ' + info.view.type);
    },
  });



  calendar.render();
});



// ------------------------------------------------
 $('#emp_id').select2({
        dropdownParent: $('#mymodal')
    });
    $('#fcuno').select2({
        dropdownParent: $('#mymodal')
    });

    
          $.each(areas1[0], function(key, v) {
          // alert(value.client_id+" "+value.client_branch);
           // console.log(v);
           $.each(v, function(key, value) {
          $("#client_id").append('<option value='+value.client_id+'>'+value.client_branch+'</option>');
        });
      });



    $("#area_update").change(function(){
      $("#client_id_update").empty();
        var current_value = document.getElementById("area_update").selectedIndex;

        $.each(areas1[current_value], function(key, v) {
          // alert(value.client_id+" "+value.client_branch);
          
           $.each(v, function(key, value) {
             // console.log(value.client_branch);
          $("#client_id_update").append('<option value='+value.client_id+'>'+value.client_branch+'</option>')
          });
        });
        // $("#area").append('<option value='+'>My option</option>');
    });


    $("#area").change(function(){
      $("#client_id").empty();
          var current_value = document.getElementById("area").selectedIndex;
          $.each(areas1[current_value], function(key, v) {
            // alert(value.client_id+" "+value.client_branch);
             // console.log(v);
             $.each(v, function(key, value) {
            $("#client_id").append('<option value='+value.client_id+'>'+value.client_branch+'</option>')
          });
        });
        // $("#area").append('<option value='+'>My option</option>');
    });




 //    
 //      // console.log(areas);
   

      $.each(devbrand[0], function(key, v) {
          // alert(value.client_id+" "+value.client_branch);
           // console.log(v);
           $.each(v, function(key, value) {
          $("#aircon_id").append('<option value='+value.aircon_id+'>'+value.aircon_type+'</option>');
          $("#aircon_id_update").append('<option value='+value.aircon_id+'>'+value.aircon_type+'</option>');
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

    $("#device_brand").change(function(){
      $("#aircon_id").empty();
        var current_value = document.getElementById("device_brand").selectedIndex;
        $.each(devbrand[current_value], function(key, v) {
          // alert(value.client_id+" "+value.client_branch);
           console.log(v);
           $.each(v, function(key, value) {
          $("#aircon_id").append('<option value='+value.aircon_id+'>'+value.aircon_type+'</option>')
        });
        });
        // $("#area").append('<option value='+'>My option</option>');
    });