<?php
  $this->load->view('includes/header')
?>

<style>
.fc-timegrid-slot {
    height: 35px !important
}
/* .fc-v-event .fc-event-title-container:hover{
  background-color: lightblue;
} */
.fc-timegrid-event .fc-event-main:hover {
    padding: 1px 1px 0px;
    background-color: lightslategrey;
}
</style>

    <!-- page content starts -->
    <div class="page-content">
      <div class="header">Create Schedule </div>
      <div class="" style="margin-top:20px;overflow: auto">
        <div class="row mb-4">
          <div class="col-md-2">
            <label>Station</label>
            <select class="form-control" id="station" onchange="changeStation()">
              <option value="">Select Station</option>
              <option value="Mooyah">Mooyah</option>
              <option value="Dining">Dining</option>
              <option value="Zen">Zen</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Employees</label>
            <select class="form-control" id="employees">
              <option value="">Select Employee</option>
              <!-- <? //$users = $this->db->order_by("id","desc")->get_where("tbl_users", ["role"=>"employee", "status"=>"Active"])->result(); 
                 //foreach($users as $k => $u){
              ?>
                <option value="<? //echo $u->id ?>"><? //echo $u->first_name." ".$u->last_name ?></option>
              <? //} ?> -->  
            </select>
          </div>
          <div class="col-md-3" style="margin-top: 25px;">
            <button type="button" class="btn btn-primary" onclick="addSchedule()">Submit</button>
          </div>
          <div class="col-md-4" style="display: flex; margin-top: 25px">
            <div style="border: 1px solid black; padding: 4px; width: 30px; height: 25px; background-color: <? echo MOOYAH ?>"></div><p style="padding: 2px;">Mooyah</p>    
            <div style="border: 1px solid black; padding: 4px; width: 30px; height: 25px; background-color: <? echo DINING ?>"></div><p style="padding: 2px;">Dining</p>
            <div style="border: 1px solid black; padding: 4px; width: 30px; height: 25px; background-color: <? echo ZEN ?>"></div><p style="padding: 2px;">Zen</p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-11">
            <div id='calendar'></div>     
          </div>
<!--           <div class="col-md-3">
            <div></div>     
          </div>       -->
        </div>
        
      </div>
    </div>
    <!--  -->
    <!-- page content ends -->
    <input type="hidden" name="stime" id="stime">
    <input type="hidden" name="etime" id="etime">

    
<?php
  $this->load->view('includes/footer')
?>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<? 

  $sdata = [];                
  $schedules = $this->db->get_where("tbl_schedules")->result(); 
  foreach($schedules as $s){

    $color = 'blue';
		$station = $s->station;
		if($station == 'Mooyah'){
			$color = MOOYAH;
		}elseif($station == 'Dining'){
			$color = DINING;
		}elseif($station == 'Zen'){
			$color = ZEN;
		}
    
    $edata = $this->db->get_where('tbl_users', ['role'=>'employee','id'=>$s->employee_id])->row();
    $sdata[] = [
      "title" => $edata->first_name." ".$edata->last_name,
      "start" => $s->start_time,
      "end" => $s->end_time,
      "color" => $color
    ];
  }
?>

<script>

  function convert(str) {
    var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
  }

  function loadCalender(cdata) {
    console.log(cdata);
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: { center: 'dayGridMonth,timeGridWeek,listWeek' },
      initialView: 'timeGridWeek',
      selectable: true,
      slotMinTime: '06:00:00',
      slotMaxTime: '24:00:00',
      height:"350px",
      slotDuration: {
        "hours": 1
      },
      select: function(info) {
        
        var stime = new Date(info.start);
        var etime = new Date(info.end);

        var start_time = convert(stime)+" "+stime.toString().split(" ")[4];
        var end_time = convert(etime)+" "+etime.toString().split(" ")[4];

        $("#stime").val(start_time);
        $("#etime").val(end_time);

        var station = $("#station").val();
        var day = info.start.toString().split(" ")[0];
        
        if(station == ""){
          Swal.fire(
              'Error',
              'Please Select Station',
              'error'
          )
          return false;
        }

        $.ajax({
          method: 'post',
          url: "<? echo base_url('dashboard/getEmployees') ?>",
          data: {'start_time': start_time, 'end_time': end_time, 'station': station, "day": day},
          // dataType:'json',
          success: function(data){
            console.log(data);
            $("#employees").html(data);
          },
          error: function(data){
            console.log(data);
          }
        })


        // addSchedule(start_time, end_time);
        /* calendar.addEvent({
          "title": "Demo event",
          start: info.start,
          end: info.end
        }); */

      },
      // dateClick: function() {
      //   alert('a day has been clicked!');
      // },
      events: cdata
    });
    calendar.render();
  }

  function changeStation(){
    var station = $("#station").val();
    if(station){
      $.ajax({
        method: 'post',
        url: "<? echo base_url('dashboard/getSchedules') ?>",
        data: {'station': station},
        dataType:'json',
        success: function(data){
          if(data.status){
            loadCalender(data.sdata);
          }
        },
        error: function(){
          
        }
      })
    }
  }

  $(document).ready(function(){
    var data = <? echo json_encode($sdata) ?>;
    loadCalender(data);
  })

  function addSchedule(){
    var station = $("#station").val();
    var employees = $("#employees").val();
    var start_time = $("#stime").val();
    var end_time = $("#etime").val();

    if(station == ""){
      Swal.fire(
          'Error',
          'Please Select Station',
          'error'
      )
      return false;
    }

    if(employees == ""){
      Swal.fire(
          'Error',
          'Please Select Employee',
          'error'
      )
      return false;
    }

    $.ajax({
      method: 'post',
      url: "<? echo base_url('dashboard/insertSchedule') ?>",
      data: {'station': station, "employee_id": employees, 'start_time': start_time, 'end_time': end_time},
      dataType:'json',
      success: function(data){
        if(data.status){
          Swal.fire(
            'Success',
            data.msg,
            'success'
          )
          setTimeout(() => {
            window.location.reload();
          }, 3000);
        }else{
          Swal.fire(
            'Error',
            data.msg,
            'error'
          )
        }
      },
      error: function(){
        
      }
    })

  }

</script>