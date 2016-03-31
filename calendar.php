<?php
include 'dbconn.php';
//include('main-menu.php');
class Calendar {  
     
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
     
    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show() {
        $year  = null;
         
        $month = null;
         
        if(null==$year&&isset($_GET['year'])){
 
            $year = $_GET['year'];
         
        }else if(null==$year){
 
            $year = date("Y",time());  
         
        }          
         
        if(null==$month&&isset($_GET['month'])){
 
            $month = $_GET['month'];
         
        }else if(null==$month){
 
            $month = date("m",time());
         
        }                  
         
        $this->currentYear=$year;
         
        $this->currentMonth=$month;
         
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                // Create weeks in a month
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                     
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j);
                                    }
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
         
        if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
             
            $cellContent = $this->currentDay;
             
            $this->currentDay++;   
             
        }else{
             
            $this->currentDate =null;
 
            $cellContent=null;
        }
            

         
        return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'"> <a id="clickable_date"  class="cell cell-info cell-lg" data-toggle="modal" data-target="#test1" style="text-decoration:none;"> '.$cellContent.' </a></li>';
    }
     
    /**
    * create navigation
    */
    private function _createNavi(){
          echo "<br><br><br><br><br>";
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return

            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}
?>

<html>
    <head>
        <title> Availability time </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>
    </head>

    <body>

        <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#test1">Ako si date petsa 1</button> silbi mao n siya si date sa calendar.-->
            <div id="test1" class="modal fade" role="dialog" style="z-index: 1400;">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-body">
                        <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal"  data-target="#reserve">Reserve</button> -->

                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal"  data-target="#view" style="float: middle;">View Reservations</button>          
                  </div>      
                </div>
              </div>
            </div>

          <!-- <div id="reserve" class="modal fade" role="dialog" style="z-index: 1600;">
              <div class="modal-dialog">
            <!-- Modal content-->
               <!-- <div class="modal-content">
                      <div class="modal-body">
                          <!-- HEADER -->
                           <!-- <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"> &times; </button>
                                <h3 class="modal-title">Please select time<h3>
                            </div>  
                            <!-- BODY -->
                           <!-- <div class="modal-body">
                            <form role="form">
                                <div class="form-group">
                               <!-- <table>
                                    <?php for ($i = 0; $i < 10; $i++) { ?>
                                        <tr>
                                            <td><input type="radio" name="reserve" value="<?php echo $i;?>" /></td>
                                            <td><?php echo $i; ?> - <?php echo $i+1; ?></td>
                                        </tr>
                                    <?php }?>
                                </table> -->

                                  <!--  <label for="timeopen" class="col-sm-2 control-label">
                                      Time Start
                                    </label>
                                    <input type="time" name="timeopen" required>
                               
            <br><br>
                                    <label for="timeclose" class="col-sm-2 control-label">
                                      Time End
                                    </label>
                                    <input type="time" name="timeclose" required>
                            <!--<input type="submit" name="submit" value="Reserve"/> -->
                           <!-- </div>
                            </form>
                        </div> 
        

                              <!--  <div class="modal-body">
                                    <form role="form">
                                        <div class="form-group">
                                            <input type="text" class= "form-control" placeholder="Name">
                                        </div>  

                                        <div class= "form-group">
                                            <input type="text" class="form-control" placeholder="Password">
                                        </div>  
                                    </form>
                                </div>
                            <!-- FOOTER -->
                               <!-- <div class="modal-footer">
                                    <button class="btn btn-primary"> Reserve </button>
                                </div>  
                      </div>      
                </div>
              </div>
            </div> -->

            <div id="view" class="modal fade" role="dialog" style="z-index: 1600;">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                      <div class="modal-body">
                          content DISPLAY DATA form reservation
                      </div>      
                </div>
              </div>
            </div>
    </body>
</html>
