<?php

namespace App\Controllers;
use App\Models\All_events;
use App\Models\Emp;
use App\Models\Client;
use App\Models\Serv;
use App\Models\Event_emp;
use App\Models\Event_emp_views;
use App\Models\Aircon;
use App\Models\Event_fcu;
use App\Models\Fcu_no;
use App\Models\Event_fcu_views;
use App\Models\Event;
class FullCalendar extends BaseController
{
    
    public function index()
    {
        if($_SESSION['position'] != USER_ROLE_ADMIN){
            if($_SESSION['position'] == USER_ROLE_EMPLOYEE){
                return $this->response->redirect(site_url('/calendar/emp'));
            }
            else{
                return $this->response->redirect(site_url('/appointment'));
            }
        }

    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();
          // dd($datas['distinct'] );
    


        $event = new All_events();
        $emp = new Emp();
        $event_fcu = new Event_fcu_views();
        $fcu_no = new Fcu_no();
        $event_emp = new Event_emp();
        $client = new Client();
        $serv = new Serv();
        $aircon = new Aircon();
        $events = new Event();
        
        $datas['events'] = $events->orderBy('id', 'ASC')->findAll();
        $datas['event'] = array();
        $datas['branch'] = array();
        $datas['client'] = $client->orderBy('client_id', 'ASC')->findAll();
        $datas['area'] = $client->select('area')->groupBy('area')->findAll();
        $datas['emp'] = $emp->orderBy('emp_id', 'ASC')->findAll();
        $datas['fcu_no'] = $fcu_no->orderBy('fcuno', 'ASC')->findAll();
        $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->findAll();
        $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
        $datas['serv'] = $serv->orderBy('serv_id', 'ASC')->findAll();
        $datas['servName'] = $serv->select('serv_name, serv_color, serv_type')->groupBy('serv_name')->findAll();
        $datas['servType'] = $serv->orderBy('serv_name','ASC')->findAll();
        $datas['aircon'] = $aircon->orderBy('aircon_id', 'ASC')->findAll();
        $datas['device_brand'] = $aircon->select('device_brand')->groupBy('device_brand')->findAll();
        // dd($datas['event_aircon']);
        foreach($datas['area'] as $k => $val) {
            
            $area = [];

            foreach($datas['client'] as $key => $value) {
                if($val['area'] == $value['area']){
                  array_push($area , (object)[
                    'client_id' => (int)$value['client_id'],
                    'client_branch' =>$value['client_branch']
                ]);
              }

          }

          $datas['client_area'][]= (object)[
            $val['area'] => $area
        ];
        $datas['client_area2'][]=$area;
    }

    $datas['all_events'] = $event->orderBy('id', 'ASC')->findAll();
        // $datas['all_events'] = $event->where('STATUS', 'Done')->findAll();
        // dd($data[0]['title']);
    foreach ($datas['all_events'] as $key => $value) {
    $emp_arr = "";
    $fcu_arr =array();

        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
             $emp_arr .= $datas['event_emp'][$key]['emp_id'].",";
         }
     }
        

       // dd($datas['event_fcu']);
       foreach ($datas['event_fcu'] as $key => $value_fcu) {
             if ($value['id'] == $value_fcu['id']) {
                 array_push($fcu_arr , (object)[
            'id' => (int)$value_fcu['id'],
            'aircon_id' => (int)$value_fcu['aircon_id'],
            'fcuno' =>(int)$value_fcu['fcuno'],
            'quantity' =>(int)$value_fcu['quantity'],
            'device_brand' =>$value_fcu['device_brand'],
            'aircon_type' =>$value_fcu['aircon_type'],
            'fcu' =>$value_fcu['fcu'],
        ]);
               
           }   
           
        } 
        

        
     $datas['event'][]= (object)[
        "id"=> $value['id'],
        "title"=> $value['title'],
        "start"=> $value['start_event'],
                 // "repeatable"=> $value['repeatable'],
        "time"=>$value['TIME'],
        "serv_id"=> $value['serv_id'],
                 // "aircon_id"=> $value['aircon_id'],
        "client_id"=> $value['client_id'],
        "serv_name"=> $value['serv_name'],
                 // "device_brand"=> $value['device_brand'],
                 // "aircon_type"=> $value['aircon_type'],
                 // "quantity"=> $value['quantity'],
        "area"=> $value['area'],
        "client_branch"=> $value['client_branch'],
        "emp_array"=> $emp_arr,
        "fcu_array"=> $fcu_arr,
        "color" => $value['serv_color'],
    ];

    
    

}
         // dd($datas['event_aircon']);


$datas['main'] = 'admin/calendar/calendar';
return view("templates/template",$datas);
}
public function addAircon($id)
{
    if($_SESSION['position'] != USER_ROLE_ADMIN){
            if($_SESSION['position'] == USER_ROLE_ADMIN){
                return $this->response->redirect(site_url('/calendar/emp'));
            }
            else{
                return $this->response->redirect(site_url('/appointment'));
            }
        }
    $event_fcu = new Event_fcu();
    $fcu_no = new Fcu_no();
    $aircon = new Aircon();
    $datas['id'] = $id;
    $datas['aircon'] = $aircon->orderBy('aircon_id', 'ASC')->findAll();
    $datas['device_brand'] = $aircon->select('device_brand')->groupBy('device_brand')->findAll();
    $datas['fcu_no'] = $fcu_no->orderBy('fcuno', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->findAll();
    foreach($datas['device_brand'] as $k => $val) {
        
        $device_brand = [];

        foreach($datas['aircon'] as $key => $value) {
            if($val['device_brand'] == $value['device_brand']){
              array_push($device_brand , (object)[
                'aircon_id' => (int)$value['aircon_id'],
                'aircon_type' =>$value['aircon_type']
            ]);
          }

      }
      $datas['brand'][]= (object)[
        $val['device_brand'] => $device_brand
    ];
    
    $datas['brand2'][]=$device_brand;
}

$fcu_arr = "";
foreach ($datas['event_fcu'] as $key => $value_fcus) {
    if ( $value['id'] == $value_fcus['id']) {
     $fcu_arr .= $datas['event_fcu'][$key]['fcuno'].",";
 }
}
$datas['event'][]= (object)[
   "device_brand"=> $value['device_brand'],
   "aircon_type"=> $value['aircon_type'],
   "fcu_array"=> $fcu_arr,
                 // "quantity"=> $value['quantity']
];
return view("admin/calendar/airconDetails",$datas);
}
public function Aircon_add($id){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
            if($_SESSION['position'] == USER_ROLE_ADMIN){
                return $this->response->redirect(site_url('/calendar/emp'));
            }
            else{
                return $this->response->redirect(site_url('/appointment'));
            }
        }
        // dd($_POST);
    $event_fcu = new Event_fcu();

    $fcu_no = new Fcu_no();
    $aircon = new Aircon();

    foreach ($_POST['aircon_id'] as $index => $aircon) {
        

        foreach ($_POST['fcuno'.$index] as $key => $floor_num) {
                // dd((int)$aircon);
           $event_fcu->insert([
            'id'=> $id,
            'aircon_id'=> (int)$aircon,
            'quantity'=> (int)$_POST['quantity'][$index],
            'fcuno'=>$floor_num
        ]);
           
       }


   }


   return $this->response->redirect(site_url('/calendar'));
}
public function index1()
{

            if($_SESSION['position'] == USER_ROLE_ADMIN){
                return $this->response->redirect(site_url('/calendar'));
            }
            else if($_SESSION['position'] == USER_ROLE_CLIENT){
                return $this->response->redirect(site_url('/appointment'));
            }
       

    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();
          // dd($datas['distinct'] );
    


        $event = new All_events();
        $emp = new Emp();
        $event_fcu = new Event_fcu_views();
        $fcu_no = new Fcu_no();
        $event_emp = new Event_emp();
        $client = new Client();
        $serv = new Serv();
        $aircon = new Aircon();
        $events = new Event();
        
        $datas['events'] = $events->orderBy('id', 'ASC')->findAll();
        $datas['event'] = array();
        $datas['branch'] = array();
        $datas['client'] = $client->orderBy('client_id', 'ASC')->findAll();
        $datas['area'] = $client->select('area')->groupBy('area')->findAll();
        $datas['emp'] = $emp->orderBy('emp_id', 'ASC')->findAll();
        $datas['fcu_no'] = $fcu_no->orderBy('fcuno', 'ASC')->findAll();
        $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->findAll();
        $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
        $datas['serv'] = $serv->orderBy('serv_id', 'ASC')->findAll();
        $datas['servName'] = $serv->select('serv_name, serv_color, serv_type')->groupBy('serv_name')->findAll();
        $datas['servType'] = $serv->orderBy('serv_name','ASC')->findAll();
        $datas['aircon'] = $aircon->orderBy('aircon_id', 'ASC')->findAll();
        $datas['device_brand'] = $aircon->select('device_brand')->groupBy('device_brand')->findAll();
        // dd($datas['event_aircon']);
        foreach($datas['area'] as $k => $val) {
            
            $area = [];

            foreach($datas['client'] as $key => $value) {
                if($val['area'] == $value['area']){
                  array_push($area , (object)[
                    'client_id' => (int)$value['client_id'],
                    'client_branch' =>$value['client_branch']
                ]);
              }

          }

          $datas['client_area'][]= (object)[
            $val['area'] => $area
        ];
        $datas['client_area2'][]=$area;
    }

    $datas['all_events'] = $event->orderBy('id', 'ASC')->findAll();
        // $datas['all_events'] = $event->where('STATUS', 'Done')->findAll();
        // dd($data[0]['title']);
    foreach ($datas['all_events'] as $key => $value) {
    $emp_arr = "";
    $fcu_arr =array();

        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
             $emp_arr .= $datas['event_emp'][$key]['emp_id'].",";
         }
     }
        

       // dd($datas['event_fcu']);
       foreach ($datas['event_fcu'] as $key => $value_fcu) {
             if ($value['id'] == $value_fcu['id']) {
                 array_push($fcu_arr , (object)[
            'id' => (int)$value_fcu['id'],
            'aircon_id' => (int)$value_fcu['aircon_id'],
            'fcuno' =>(int)$value_fcu['fcuno'],
            'quantity' =>(int)$value_fcu['quantity'],
            'device_brand' =>$value_fcu['device_brand'],
            'aircon_type' =>$value_fcu['aircon_type'],
            'fcu' =>$value_fcu['fcu'],
        ]);
               
           }   
           
        } 
        

        
     $datas['event'][]= (object)[
        "id"=> $value['id'],
        "title"=> $value['title'],
        "start"=> $value['start_event'],
                 // "repeatable"=> $value['repeatable'],
        "time"=>$value['TIME'],
        "serv_id"=> $value['serv_id'],
                 // "aircon_id"=> $value['aircon_id'],
        "client_id"=> $value['client_id'],
        "serv_name"=> $value['serv_name'],
                 // "device_brand"=> $value['device_brand'],
                 // "aircon_type"=> $value['aircon_type'],
                 // "quantity"=> $value['quantity'],
        "area"=> $value['area'],
        "client_branch"=> $value['client_branch'],
        "emp_array"=> $emp_arr,
        "fcu_array"=> $fcu_arr,
        "color" => $value['serv_color'],
    ];

    
    

}


         // dd($datas['event']);

$datas['main'] = 'employee/calendar/calendar';
return view("templates/template",$datas);
}

public function event(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
    $event = new All_events();
        // $emp = new Emp();
    $client = new Client();
    $serv = new Serv();
    $event_emp = new Event_emp_views();
    $event_fcu = new Event_fcu_views();
    // $aircon = new Aircon();

    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();
          // dd($datas['distinct'] );

    $datas['event'] = array();
    $datas['client'] = $client->orderBy('client_id', 'ASC')->findAll();
        // $datas['emp'] = $emp->orderBy('emp_id', 'ASC')->findAll();
    $datas['serv'] = $serv->orderBy('serv_id', 'ASC')->findAll();
    $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->orderBy('fcuno', 'ASC')->findAll();
    // $datas['aircon'] = $aircon->orderBy('aircon_id', 'ASC')->findAll();
    $datas['all_events'] = $event->orderBy('start_event', 'ASC')->findAll();
        // dd($datas['groupby_fcu']);
    foreach ($datas['all_events'] as $key => $value) {

        $emp_arr = "";
        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
               $emp_arr .= $datas['event_emp'][$key]['emp_name'].",";
           }
       }
       $fcu_arr = array();

       // dd($datas['event_fcu']);
       foreach ($datas['event_fcu'] as $key => $value_fcu) {
             if ($value['id'] == $value_fcu['id']) {
                 array_push($fcu_arr , (object)[
            'id' => (int)$value_fcu['id'],
            'aircon_id' => (int)$value_fcu['aircon_id'],
            'fcuno' =>(int)$value_fcu['fcuno'],
            'quantity' =>(int)$value_fcu['quantity'],
            'device_brand' =>$value_fcu['device_brand'],
            'aircon_type' =>$value_fcu['aircon_type'],
            'fcu' =>$value_fcu['fcu'],
        ]);
               
           }   
           
        } 
 $datas['event'][]= (object)[
  "id"=> $value['id'],
  "title"=>$value['title'],
  "start_event"=> $value['start_event'],
  "time"=> $value['TIME'],
  "serv_id"=> $value['serv_id'],
  "client_id"=>$value['client_id'],
  // "aircon_array"=>$aircon_arr,
  "serv_name"=>$value['serv_name'],
  "serv_type"=>$value['serv_type'],
  "area"=> $value['area'],
  "emp_array"=> $emp_arr,
  "fcu_array"=> $fcu_arr,
  "client_branch"=> $value['client_branch'],
  "status"=> $value['STATUS'],
];
}
            // dd( $datas['event']);
$datas['main'] = 'admin/calendar/events';
return view("templates/template",$datas);

}

public function getfilter(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
    $event = new All_events();
        // $emp = new Emp();
    $client = new Client();
    $serv = new Serv();
    $event_emp = new Event_emp_views();
    $event_fcu = new Event_fcu_views();
    // $aircon = new Aircon();

    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();
          // dd($datas['distinct'] );

    
    $datas['event'] = array();
    $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->orderBy('fcuno', 'ASC')->findAll();

    if(isset($_GET['start_date']) && isset($_GET['to_date']))
    {
        $start_date = $_GET['start_date'];
        $to_date = $_GET['to_date'];

        $datas['all_events'] = $event->where('start_event BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($to_date)).'"')->findAll();
        foreach ($datas['all_events'] as $key => $value) {
            $emp_arr = "";
            foreach ($datas['event_emp'] as $key => $value_emps) {
                if ( $value['id'] == $value_emps['id']) {
                 $emp_arr .= $datas['event_emp'][$key]['emp_name'].",";
             }
         }
         $fcu_arr = array();
         foreach ($datas['event_fcu'] as $key => $value_fcu) {
               if ($value['id'] == $value_fcu['id']) {
                   array_push($fcu_arr , (object)[
              'id' => (int)$value_fcu['id'],
              'aircon_id' => (int)$value_fcu['aircon_id'],
              'fcuno' =>(int)$value_fcu['fcuno'],
              'quantity' =>(int)$value_fcu['quantity'],
              'device_brand' =>$value_fcu['device_brand'],
              'aircon_type' =>$value_fcu['aircon_type'],
              'fcu' =>$value_fcu['fcu'],
          ]);
                 
             }   
             
          }      
     

    $datas['event'][]= (object)[
        "id"=> $value['id'],
        "title"=>$value['title'],
        "start_event"=> $value['start_event'],
        "time"=> $value['TIME'],
        "serv_id"=> $value['serv_id'],
        "client_id"=>$value['client_id'],
        // "aircon_array"=>$aircon_arr,
        "serv_name"=>$value['serv_name'],
        "serv_type"=>$value['serv_type'],
        "area"=> $value['area'],
        "emp_array"=> $emp_arr,
        "fcu_array"=> $fcu_arr,
        "client_branch"=> $value['client_branch'],
        "status"=> $value['STATUS'],
      ];
}


}
$datas['main'] = 'admin/calendar/events';
return view('templates/template',$datas);
}
public function printpdf($strt,$end){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
    $session = session();
    $event = new All_events();
    $event_emp = new Event_emp_views();
    $event_fcu = new Event_fcu_views();

    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();
          // dd($datas['distinct'] );

    $datas['date'] = [$strt,$end];
    $datas['event'] = array();
    $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->orderBy('fcuno', 'ASC')->findAll();

    $datas['all_events'] = $event->where('start_event BETWEEN "'. date('Y-m-d', strtotime($strt)). '" and "'. date('Y-m-d', strtotime($end)).'"')->findAll();

    foreach ($datas['all_events'] as $key => $value) {
        $emp_arr = "";
        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
             $emp_arr .= $datas['event_emp'][$key]['emp_name'].",";
         }
     }
     $fcu_arr = array();

       // dd($datas['event_fcu']);
       foreach ($datas['event_fcu'] as $key => $value_fcu) {
             if ($value['id'] == $value_fcu['id']) {
                 array_push($fcu_arr , (object)[
            'id' => (int)$value_fcu['id'],
            'aircon_id' => (int)$value_fcu['aircon_id'],
            'fcuno' =>(int)$value_fcu['fcuno'],
            'quantity' =>(int)$value_fcu['quantity'],
            'device_brand' =>$value_fcu['device_brand'],
            'aircon_type' =>$value_fcu['aircon_type'],
            'fcu' =>$value_fcu['fcu'],
        ]);
               
           }   
           
        }    
 

        $datas['event'][]= (object)[
            "id"=> $value['id'],
            "title"=>$value['title'],
            "start_event"=> $value['start_event'],
            "time"=> $value['TIME'],
            "serv_id"=> $value['serv_id'],
            "client_id"=>$value['client_id'],
            // "aircon_array"=>$aircon_arr,
            "serv_name"=>$value['serv_name'],
            "serv_type"=>$value['serv_type'],
            // "device_array"=> $device_arr,
                            // "aircon_type"=> $value['aircon_type'],
            // "quantity_array"=> $quantity_arr,
            "area"=> $value['area'],
            "emp_array"=> $emp_arr,
            "fcu_array"=> $fcu_arr,
            "client_branch"=> $value['client_branch'],
            "status"=> $value['STATUS'],
          ];
          }



return view('admin/calendar/eventPrint',$datas);

}

public function insert(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
// dd($_POST);
    $Event = new Event();
    $Event_emp = new Event_emp();
    $event_fcu = new Event_fcu();
    $Client = new Client();
        // $event_fcu = new Event_fcu();
    $fcu_no = new Fcu_no();
    $aircon = new Aircon();
    
    $client_name = $_POST["client_id"];
    $client_branch = $Client->where('client_id',$client_name)->first();
    
    $weeklyEvent = [];
    $monthlyEvent = [];
    // dd($_POST);
    if(isset($_POST["title"]))
    {
        
        if($_POST['repeatable'] == "Weekly"){
            function getWeekly($y) {
                return new \DatePeriod(
                    new \DateTime("first ".date("l", strtotime($_POST['start_event']))." of $y"),
                    \DateInterval::createFromDateString('next '.date("l", strtotime($_POST['start_event']))),
                    new \DateTime("last day of december $y"),
                    
                );
            }

                // Usage:
            foreach (getWeekly(date("Y",strtotime($_POST['start_event']))) as $getw) {
                array_push($weeklyEvent, $getw->format("Y-m-d"));
            }
               

            for ($i=0; $i < count($weeklyEvent); $i++) { 
                $_POST['start_event'] = $weeklyEvent[$i];

                $_POST["title"] = date("g:ia",strtotime($_POST["time"]))." ".$client_branch['client_branch'];
                
                $success = $Event->insert($_POST);

                foreach($_POST['emp_id'] as $key => $value) {
                    $Event_emp->insert([
                        'emp_id'=> (int) $value,
                        'id' => (int) $success
                    ]);
                }

                foreach ($_POST['aircon_id'] as $index => $aircon) {
        foreach ($_POST['fcuno'.$index] as $key => $floor_num) {
           $event_fcu->insert([
            'id'=> (int) $success,
            'aircon_id'=> (int)$aircon,
            'quantity'=> (int)$_POST['quantity'][$index],
            'fcuno'=>$floor_num
        ]);
           
       }

   }
           }
                // dd($i);
       } else if($_POST['repeatable'] == "Monthly"){
        function getMonthly($y) {
            return new \DatePeriod(
                new \DateTime(date("Y-m-d", strtotime($_POST['start_event']))),
                \DateInterval::createFromDateString('next month'),
                new \DateTime("last day of december $y"),
                
            );
        }

                    // Usage:
        foreach (getMonthly(date("Y",strtotime($_POST['start_event']))) as $getm) {
            array_push($monthlyEvent, $getm->format("Y-m-d"));
        }

        for ($i=0; $i < count($monthlyEvent); $i++) { 
            $_POST['start_event'] = $monthlyEvent[$i];
            $_POST["title"] = date("g:ia",strtotime($_POST["time"]))." ".$client_branch['client_branch'];
            $success = $Event->insert($_POST);
            foreach($_POST['emp_id'] as $key => $value) {
                $Event_emp->insert([
                    'emp_id'=> (int) $value,
                    'id' => (int) $success
                ]);
            }
            foreach ($_POST['aircon_id'] as $index => $aircon) {
                foreach ($_POST['fcuno'.$index] as $key => $floor_num) {
           $event_fcu->insert([
            'id'=> (int) $success,
            'aircon_id'=> (int)$aircon,
            'quantity'=> (int)$_POST['quantity'][$index],
            'fcuno'=>$floor_num
        ]);
           
       }

   }
       }

   }

   else{
    $_POST["title"] = date("g:ia",strtotime($_POST["time"]))." ".$client_branch['client_branch'];
    $success = $Event->insert($_POST);
    
    foreach($_POST['emp_id'] as $key => $value) {
        $Event_emp->insert([
            'emp_id'=> (int) $value,
            'id' => (int) $success
        ]);
    }
    // dd($_POST);
    foreach ($_POST['aircon_id'] as $index => $aircon) {
        foreach ($_POST['fcuno'.$index] as $key => $floor_num) {
           $event_fcu->insert([
            'id'=> (int) $success,
            'aircon_id'=> (int)$aircon,
            'quantity'=> (int)$_POST['quantity'][$index],
            'fcuno'=>$floor_num
        ]);
           
       }

   }

}            

            // $eId = (int)$success;

        // return $this->response->redirect(site_url('/calendar/add-aircon/'.$eId));
return $this->response->redirect(site_url('/calendar'));

}

return json_encode(["error"=>"error"],412);
}

public function update(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
        // dd($this->request->getVar('emp_id_update'));
    // dd($_POST);

    $Event = new Event();
    $Client = new Client();
    $Event_emp = new Event_emp();
    $Event_fcu = new Event_fcu();
    $event_id = $this->request->getVar('id');
    $client_name = $this->request->getVar('client_id_update');

    $client_branch = $Client->where('client_id',$client_name)->first();
    
    $event_update = [
        'start_event' => $this->request->getVar('start_event_update'),
        'title' => date("g:ia",strtotime($this->request->getVar('time_update')))." ".$client_branch['client_branch'],
        'time' => $this->request->getVar('time_update'),
            // 'aircon_id' => (int)($this->request->getVar('aircon_id_update')),
        'client_id'  => (int)($this->request->getVar('client_id_update')),
            // 'fcuno' => (int)($this->request->getVar('fcuno_update')),
        'serv_id' => (int)($this->request->getVar('serv_id_update')),
        
        
            // 'quantity' => $this->request->getVar('quantity_update'),
    ];

    $Event->update($event_id,$event_update);
    $Event_emp->where('id', $event_id)->delete();


    if (isset($_POST['emp_id_update'])) {
        foreach($_POST['emp_id_update'] as $key => $value) {
            $Event_emp->insert([
                'emp_id'=> (int) $value,
                'id' => $event_id
            ]);
        }
    }

        $Event_fcu->where('id', $event_id)->delete();

        foreach ($_POST['aircon_update_id'] as $index => $aircon) {
        foreach ($_POST['fcuno_update_'.$aircon] as $key => $floor_num) {
           $Event_fcu->insert([
            'id'=> (int) $event_id,
            'aircon_id'=> (int)$aircon,
            'quantity'=> (int)$_POST['quantity'][$index],
            'fcuno'=>$floor_num
        ]);

           
       }

   }
   
    
    
    return $this->response->redirect(site_url('/calendar'));
    
    return json_encode(["error"=>"error"],412);
}
public function delete($id){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
    $Event = new Event();
    $Event->where('id', $id)->delete($id);
    $session = session();
    $session->setFlashdata('msg', 'value');
    return $this->response->redirect(site_url('/calendar/events'));
}

public function load(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
    $event = new Event();

    $event->orderBy('id', 'ASC')->findAll();

    if ($event) {
        return json_encode(["data"=>$event],200);
    }
}

public function daily(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }

    date_default_timezone_set('Asia/Hong_Kong'); 

    $date = new \DateTime();
    $date->setTimezone(new \DateTimeZone('+0800'));

    $event = new All_events();
        // $emp = new Emp();
    $client = new Client();
    $serv = new Serv();
    $event_emp = new Event_emp_views();
    $event_fcu = new Event_fcu_views();
    // $aircon = new Aircon();

    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();

    $datas['day'] = array();
    $datas['client'] = $client->orderBy('client_id', 'ASC')->findAll();
        // $datas['emp'] = $emp->orderBy('emp_id', 'ASC')->findAll();
    $datas['serv'] = $serv->orderBy('serv_id', 'ASC')->findAll();
    $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->orderBy('fcuno', 'ASC')->findAll();
    // $datas['aircon'] = $aircon->orderBy('aircon_id', 'ASC')->findAll();
    $datas['today'] = $event->where('start_event', date('Y-m-d'))->findAll();
        // dd($data[0]['title']);
    foreach ($datas['today'] as $key => $value) {

        $emp_arr = "";
        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
             $emp_arr .= $datas['event_emp'][$key]['emp_name'].",";
         }
     }
     $fcu_arr = array();

       // dd($datas['event_fcu']);
       foreach ($datas['event_fcu'] as $key => $value_fcu) {
             if ($value['id'] == $value_fcu['id']) {
                 array_push($fcu_arr , (object)[
            'id' => (int)$value_fcu['id'],
            'aircon_id' => (int)$value_fcu['aircon_id'],
            'fcuno' =>(int)$value_fcu['fcuno'],
            'quantity' =>(int)$value_fcu['quantity'],
            'device_brand' =>$value_fcu['device_brand'],
            'aircon_type' =>$value_fcu['aircon_type'],
            'fcu' =>$value_fcu['fcu'],
        ]);
               
           }   
           
        }  
 $datas['day'][]= (object)[
  "id"=> $value['id'],
  "title"=>$value['title'],
  "start_event"=> $value['start_event'],
  "time"=> $value['TIME'],
  "serv_id"=> $value['serv_id'],
  "client_id"=>$value['client_id'],
//   "aircon_array"=>$aircon_arr,
  "serv_name"=>$value['serv_name'],
  "serv_type"=>$value['serv_type'],
//   "device_array"=> $device_arr,
//   "quantity_array"=> $quantity_arr,
  "area"=> $value['area'],
  "emp_array"=> $emp_arr,
  "fcu_array"=> $fcu_arr,
  "client_branch"=> $value['client_branch'],
  "status"=> $value['STATUS'],
];
}
$datas['main'] = 'admin/calendar/today';
return view("templates/template",$datas);
}
public function printDaily(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }

    date_default_timezone_set('Asia/Hong_Kong'); 

    $date = new \DateTime();
    $date->setTimezone(new \DateTimeZone('+0800'));

   $event = new All_events();
        // $emp = new Emp();
    $client = new Client();
    $serv = new Serv();
    $event_emp = new Event_emp_views();
    $event_fcu = new Event_fcu_views();
    
    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();


    $datas['day'] = array();
    $datas['client'] = $client->orderBy('client_id', 'ASC')->findAll();
        // $datas['emp'] = $emp->orderBy('emp_id', 'ASC')->findAll();
    $datas['serv'] = $serv->orderBy('serv_id', 'ASC')->findAll();
    $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->orderBy('fcuno', 'ASC')->findAll();

    $datas['today'] = $event->where('start_event', date('Y-m-d'))->findAll();
        // dd($data[0]['title']);
    foreach ($datas['today'] as $key => $value) {

        $emp_arr = "";
        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
             $emp_arr .= $datas['event_emp'][$key]['emp_name'].",";
         }
     }
     $fcu_arr = array();

         // dd($datas['event_fcu']);
         foreach ($datas['event_fcu'] as $key => $value_fcu) {
               if ($value['id'] == $value_fcu['id']) {
                   array_push($fcu_arr , (object)[
              'id' => (int)$value_fcu['id'],
              'aircon_id' => (int)$value_fcu['aircon_id'],
              'fcuno' =>(int)$value_fcu['fcuno'],
              'quantity' =>(int)$value_fcu['quantity'],
              'device_brand' =>$value_fcu['device_brand'],
              'aircon_type' =>$value_fcu['aircon_type'],
              'fcu' =>$value_fcu['fcu'],
          ]);
                 
             }   
             
          }     
 $datas['day'][]= (object)[
  "id"=> $value['id'],
  "title"=>$value['title'],
  "start_event"=> $value['start_event'],
  "time"=> $value['TIME'],
  "serv_id"=> $value['serv_id'],
  "client_id"=>$value['client_id'],
//   "aircon_array"=>$aircon_arr,
  "serv_name"=>$value['serv_name'],
  "serv_type"=>$value['serv_type'],
//   "device_array"=> $device_arr,
//   "quantity_array"=> $quantity_arr,
  "area"=> $value['area'],
  "emp_array"=> $emp_arr,
  "fcu_array"=> $fcu_arr,
  "client_branch"=> $value['client_branch'],
  "status"=> $value['STATUS'],
];
}

return view("admin/calendar/dailyPrint",$datas);
}
public function weekly(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
    $event = new All_events();
        // $emp = new Emp();
    // $client = new Client();
    // $serv = new Serv();
    $event_emp = new Event_emp_views();
    $event_fcu = new Event_fcu_views();

    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();

    $monday = date('Y-m-d', strtotime('monday this week'));
    $sunday = date('Y-m-d', strtotime('sunday this week'));

    $datas['week'] = array();
    // $datas['client'] = $client->orderBy('client_id', 'ASC')->findAll();
        // $datas['emp'] = $emp->orderBy('emp_id', 'ASC')->findAll();
    // $datas['serv'] = $serv->orderBy('serv_id', 'ASC')->findAll();
    $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->orderBy('fcuno', 'ASC')->findAll();

    $datas['weekly'] = $event->where('start_event BETWEEN "'. date('Y-m-d', strtotime($monday)). '" and "'. date('Y-m-d', strtotime($sunday)).'"ORDER BY start_event ASC')->findAll();
        // dd($datas['weekly']);
    foreach ($datas['weekly'] as $key => $value) {

        $emp_arr = "";
        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
             $emp_arr .= $datas['event_emp'][$key]['emp_name'].",";
         }
     }
     $fcu_arr = array();

    //  dd($datas['event_fcu']);
     foreach ($datas['event_fcu'] as $key => $value_fcu) {
           if ($value['id'] == $value_fcu['id']) {
               array_push($fcu_arr , (object)[
          'id' => (int)$value_fcu['id'],
          'aircon_id' => (int)$value_fcu['aircon_id'],
          'fcuno' =>(int)$value_fcu['fcuno'],
          'quantity' =>(int)$value_fcu['quantity'],
          'device_brand' =>$value_fcu['device_brand'],
          'aircon_type' =>$value_fcu['aircon_type'],
          'fcu' =>$value_fcu['fcu'],
      ]);
             
         }   
         
      }    
 $datas['week'][]= (object)[
  "id"=> $value['id'],
  "title"=>$value['title'],
  "start_event"=> $value['start_event'],
  "time"=> $value['TIME'],
  "serv_id"=> $value['serv_id'],
  "client_id"=>$value['client_id'],
//   "aircon_array"=>$aircon_arr,
  "serv_name"=>$value['serv_name'],
  "serv_type"=>$value['serv_type'],
//   "device_array"=> $device_arr,
//   "quantity_array"=> $quantity_arr,
  "area"=> $value['area'],
  "emp_array"=> $emp_arr,
  "fcu_array"=> $fcu_arr,
  "client_branch"=> $value['client_branch'],
  "status"=> $value['STATUS'],
];
}
// dd($datas['week']);
$datas['main'] = 'admin/calendar/week';
return view("templates/template",$datas);
}
public function printWeekly(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
    $event = new All_events();
        // $emp = new Emp();
    // $client = new Client();
    // $serv = new Serv();
    $event_emp = new Event_emp_views();
    $event_fcu = new Event_fcu_views();
    // $aircon = new Aircon();
    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();

    $monday = date('Y-m-d', strtotime('monday this week'));
    $sunday = date('Y-m-d', strtotime('sunday this week'));

    $datas['week'] = array();
    // $datas['client'] = $client->orderBy('client_id', 'ASC')->findAll();
        // $datas['emp'] = $emp->orderBy('emp_id', 'ASC')->findAll();
    // $datas['serv'] = $serv->orderBy('serv_id', 'ASC')->findAll();
    $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->orderBy('fcuno', 'ASC')->findAll();
    // $datas['aircon'] = $aircon->orderBy('aircon_id', 'ASC')->findAll();
    $datas['weekly'] = $event->where('start_event BETWEEN "'. date('Y-m-d', strtotime($monday)). '" and "'. date('Y-m-d', strtotime($sunday)).'"ORDER BY start_event ASC')->findAll();
        // dd($data[0]['title']);
    foreach ($datas['weekly'] as $key => $value) {

        $emp_arr = "";
        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
             $emp_arr .= $datas['event_emp'][$key]['emp_name'].",";
         }
     }
     $fcu_arr = array();

     // dd($datas['event_fcu']);
     foreach ($datas['event_fcu'] as $key => $value_fcu) {
           if ($value['id'] == $value_fcu['id']) {
               array_push($fcu_arr , (object)[
          'id' => (int)$value_fcu['id'],
          'aircon_id' => (int)$value_fcu['aircon_id'],
          'fcuno' =>(int)$value_fcu['fcuno'],
          'quantity' =>(int)$value_fcu['quantity'],
          'device_brand' =>$value_fcu['device_brand'],
          'aircon_type' =>$value_fcu['aircon_type'],
          'fcu' =>$value_fcu['fcu'],
      ]);
             
         }   
         
      }   
 $datas['week'][]= (object)[
  "id"=> $value['id'],
  "title"=>$value['title'],
  "start_event"=> $value['start_event'],
  "time"=> $value['TIME'],
  "serv_id"=> $value['serv_id'],
  "client_id"=>$value['client_id'],
//   "aircon_array"=>$aircon_arr,
  "serv_name"=>$value['serv_name'],
  "serv_type"=>$value['serv_type'],
//   "device_array"=> $device_arr,
//   "quantity_array"=> $quantity_arr,
  "area"=> $value['area'],
  "emp_array"=> $emp_arr,
  "fcu_array"=> $fcu_arr,
  "client_branch"=> $value['client_branch'],
  "status"=> $value['STATUS'],
];
}

return view("admin/calendar/weeklyPrint",$datas);
}
public function monthly(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
    $event = new All_events();
        // $emp = new Emp();
    // $client = new Client();
    // $serv = new Serv();
    $event_emp = new Event_emp_views();
    $event_fcu = new Event_fcu_views();
    // $aircon = new Aircon();
    $monday = date('Y-m-d', strtotime('monday this week'));
    $sunday = date('Y-m-d', strtotime('sunday this week'));

    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();

    $datas['month'] = array();
    // $datas['client'] = $client->orderBy('client_id', 'ASC')->findAll();
        // $datas['emp'] = $emp->orderBy('emp_id', 'ASC')->findAll();
    // $datas['serv'] = $serv->orderBy('serv_id', 'ASC')->findAll();
    $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->orderBy('fcuno', 'ASC')->findAll();
    // $datas['aircon'] = $aircon->orderBy('aircon_id', 'ASC')->findAll();
    $datas['monthly'] = $event->where('MONTH(start_event) = MONTH(CURRENT_DATE()) ORDER BY start_event ASC')->findAll();
        // dd($data[0]['title']);
    foreach ($datas['monthly'] as $key => $value) {

        $emp_arr = "";
        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
             $emp_arr .= $datas['event_emp'][$key]['emp_name'].",";
         }
     }
     $fcu_arr = array();

     // dd($datas['event_fcu']);
     foreach ($datas['event_fcu'] as $key => $value_fcu) {
           if ($value['id'] == $value_fcu['id']) {
               array_push($fcu_arr , (object)[
          'id' => (int)$value_fcu['id'],
          'aircon_id' => (int)$value_fcu['aircon_id'],
          'fcuno' =>(int)$value_fcu['fcuno'],
          'quantity' =>(int)$value_fcu['quantity'],
          'device_brand' =>$value_fcu['device_brand'],
          'aircon_type' =>$value_fcu['aircon_type'],
          'fcu' =>$value_fcu['fcu'],
      ]);
             
         }   
         
      } 
 $datas['month'][]= (object)[
   "id"=> $value['id'],
  "title"=>$value['title'],
  "start_event"=> $value['start_event'],
  "time"=> $value['TIME'],
  "serv_id"=> $value['serv_id'],
  "client_id"=>$value['client_id'],
//   "aircon_array"=>$aircon_arr,
  "serv_name"=>$value['serv_name'],
  "serv_type"=>$value['serv_type'],
//   "device_array"=> $device_arr,
//   "quantity_array"=> $quantity_arr,
  "area"=> $value['area'],
  "emp_array"=> $emp_arr,
  "fcu_array"=> $fcu_arr,
  "client_branch"=> $value['client_branch'],
  "status"=> $value['STATUS'],
];
}
$datas['main'] = 'admin/calendar/month';
return view("templates/template",$datas);
}
public function printMonthly(){
    if($_SESSION['position'] != USER_ROLE_ADMIN){
        return $this->response->redirect(site_url('/dashboard'));
    }
    $event = new All_events();
        // $emp = new Emp();
    // $client = new Client();
    // $serv = new Serv();
    $event_emp = new Event_emp_views();
    $event_fcu = new Event_fcu_views();
    // $aircon = new Aircon();
    $db = \Config\Database::connect();
          $query   = $db->query('SELECT DISTINCT aircon_id,id,device_brand,aircon_type,quantity
            FROM event_fcu_views');
          $datas['distinct'] = $query->getResult();

    $db1 = \Config\Database::connect();
          $query   = $db1->query('SELECT DISTINCT id
            FROM event_fcu_views');
          $datas['distinct_event'] = $query->getResult();

    $monday = date('Y-m-d', strtotime('monday this week'));
    $sunday = date('Y-m-d', strtotime('sunday this week'));

    $datas['month'] = array();
    // $datas['client'] = $client->orderBy('client_id', 'ASC')->findAll();
        // $datas['emp'] = $emp->orderBy('emp_id', 'ASC')->findAll();
    // $datas['serv'] = $serv->orderBy('serv_id', 'ASC')->findAll();
    $datas['event_emp'] = $event_emp->orderBy('id', 'ASC')->findAll();
    $datas['event_fcu'] = $event_fcu->orderBy('id', 'ASC')->orderBy('fcuno', 'ASC')->findAll();
    // $datas['aircon'] = $aircon->orderBy('aircon_id', 'ASC')->findAll();
    $datas['monthly'] = $event->where('MONTH(start_event) = MONTH(CURRENT_DATE()) ORDER BY start_event ASC')->findAll();
        // dd($data[0]['title']);
    foreach ($datas['monthly'] as $key => $value) {

        $emp_arr = "";
        foreach ($datas['event_emp'] as $key => $value_emps) {
            if ( $value['id'] == $value_emps['id']) {
             $emp_arr .= $datas['event_emp'][$key]['emp_name'].",";
         }
     }
     $fcu_arr = array();

     // dd($datas['event_fcu']);
     foreach ($datas['event_fcu'] as $key => $value_fcu) {
           if ($value['id'] == $value_fcu['id']) {
               array_push($fcu_arr , (object)[
          'id' => (int)$value_fcu['id'],
          'aircon_id' => (int)$value_fcu['aircon_id'],
          'fcuno' =>(int)$value_fcu['fcuno'],
          'quantity' =>(int)$value_fcu['quantity'],
          'device_brand' =>$value_fcu['device_brand'],
          'aircon_type' =>$value_fcu['aircon_type'],
          'fcu' =>$value_fcu['fcu'],
      ]);
             
         }   
         
      }       
 $datas['month'][]= (object)[
   "id"=> $value['id'],
  "title"=>$value['title'],
  "start_event"=> $value['start_event'],
  "time"=> $value['TIME'],
  "serv_id"=> $value['serv_id'],
  "client_id"=>$value['client_id'],
//   "aircon_array"=>$aircon_arr,
  "serv_name"=>$value['serv_name'],
  "serv_type"=>$value['serv_type'],
//   "device_array"=> $device_arr,
//   "quantity_array"=> $quantity_arr,
  "area"=> $value['area'],
  "emp_array"=> $emp_arr,
  "fcu_array"=> $fcu_arr,
  "client_branch"=> $value['client_branch'],
  "status"=> $value['STATUS'],
];
}

return view("admin/calendar/monthlyPrint",$datas);
}
}
?>