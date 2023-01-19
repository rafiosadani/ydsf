<?php 
include 'config.php';
$date = date("Y");
$stmt = $connection->prepare("SELECT * FROM config_report");
$stmt->execute();
$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Setting Pdf and Email</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    console.log(sessionStorage.getItem('status'));
    if (sessionStorage.getItem('status') == null || sessionStorage.getItem('status') == '') {window.location = "<?php echo $site_url ?>";}else{}
  </script>
	<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.jqueryui.min.css"> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
	<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
	<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->
	<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.jqueryui.min.js"></script> -->
	<!-- <script type="text/javascript" src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
  <script src="ckeditor.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url.'style.css' ?>">
</head>
<body style="margin: 5%">
 <h2>Set Up</h2>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item "><a href="<?php echo $base_url."index.php" ?>"><span class="glyphicon glyphicon-home"></span>  Home  </a></li>
      <li class="breadcrumb-item active">Set Up</li>
    </ol>
  </nav>
	<div class="panel panel-primary">
		<div class="panel-heading"><h3 class="panel-title"><span class="glyphicon glyphicon-wrench"></span>   Set Up </h3></div>
		<div class="panel-body">
			<form method="post" action="upload.php" enctype="multipart/form-data">
					<div class="form-group">
						<div id="sla-data-range" class="mrp-container ">
						<span class="mrp-icon"><i class="fa fa-calendar"></i></span>
						<div class="mrp-monthdisplay">
							<span class="mrp-lowerMonth">Jul 2018</span>
							<span class="mrp-to"> to </span>
							<span class="mrp-upperMonth">Jan 2019</span>
						</div>
						<input type="hidden" name="periode" id="periode">
						<!-- <button type="button" id="btn-coba">test</button> -->
					</div>
					</div>
					<div class="form-group">
						<label for="sambutan">Kata Sambutan</label>
						<textarea class="form-control" name="sambutan" rows="5" id="sambutan"></textarea>
					</div> 
					<div class="form-group">
						<label for="artikel">Artikel</label>
						<textarea class="form-control" name="artikel" rows="5" id="artikel"></textarea>
					</div>
					<div class="form-group">
						<label for="foto">Foto Direktur</label>
						<input type="file" id="foto" name="foto" required>
					</div>
					<div class="form-group">
						<label for="image1">Foto Halaman 1</label>
						<input type="file" id="image1" name="image1" required>
					</div> 
					<div class="form-group">
						<label for="image2">Foto Halaman 2</label>
						<input type="file" id="image2" name="image2" required>
					</div>
					<input style="width: 300px" name="submit" type="submit" class="btn btn-primary" value="Change">  
				</form>
			</div>
		</div>	
		<div class = "panel panel-primary">
			<div class = "panel-heading">
				<h3 class = "panel-title"><span class="glyphicon glyphicon-wrench"></span>   Current Setting  </h3>
			</div>
			<div class="panel-body">
				<table class="table table-borderless">
          <tr>
            <td>Periode</td>
            <td> : </td>
            <td><?php echo $fetch['periode']; ?></td>
          </tr>
					<tr>
						<td>Halaman depan</td>
						<td> : </td>
						<td><?php echo $fetch['sambutan'] ?></td>
					</tr>
					<tr>
						<td>Artikel</td>
						<td> : </td>
						<td><?php echo $fetch['artikel'] ?></td>
					</tr>
					<tr>
						<td>Foto</td>
						<td> : </td>
						<td><img width="300" height="300" src="<?php echo 'img/'.$fetch['small_image'] ?>"></td>
					</tr>
					<tr>
						<td>Image page 1</td>
						<td> : </td>
						<td><img width="300" height="300" src="<?php echo 'img/'.$fetch['image_page1'] ?>"></td>
					</tr>
					<tr>
						<td>Image page 2</td>
						<td> : </td>
						<td><img width="300" height="300" src="<?php echo 'img/'.$fetch['image_page2'] ?>"></td>
					</tr>
				</table>
				<button type="button" class="btn btn-primary" onclick="history.back();">Back</button>
			</div>
		</div>


	</body>
  <script>
    CKEDITOR.replace( 'sambutan' );
    CKEDITOR.replace('artikel');

  </script>
	<script>
		var MONTHS = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
		var defaultDate = new Date();

$(function () {
  startMonth = 7;
  startYear = 2018;
  endMonth = defaultDate.getMonth();
  endYear = defaultDate.getFullYear();
  fiscalMonth = 7;
  if(startMonth < 10)
  	startDate = parseInt("" + startYear + '0' + startMonth + "");
  else
    startDate = parseInt("" + startYear  + startMonth + "");
  if(endMonth < 10)
  	endDate = parseInt("" + endYear + '0' + endMonth + "");
  else
    endDate = parseInt("" + endYear + endMonth + "");
  
  content = '<div class="row mpr-calendarholder">';
  calendarCount = endYear - startYear;
  if(calendarCount == 0)
    calendarCount++;
  var d = new Date();
  for(y = 0; y < 2; y++){
		content += '<div class="col-xs-6" ><div class="mpr-calendar row" id="mpr-calendar-' + (y+1) + '">'
 						 + '<h5 class="col-xs-12"><i class="mpr-yeardown fa fa-chevron-circle-left"></i><span>' + (startYear + y).toString() + '</span><i class="mpr-yearup fa fa-chevron-circle-right"></i></h5><div class="mpr-monthsContainer"><div class="mpr-MonthsWrapper">';
    for(m=0; m < 12; m++){
      var monthval;
      if((m+1) < 10)
        monthval = "0" + (m+1);
      else
        monthval = "" + (m+1);
			content += '<span data-month="' + monthval  + '" class="col-xs-3 mpr-month">' + MONTHS[m] + '</span>';
    }
    content += '</div></div></div></div>';
  }
  content += '</div>';
  
  $(document).on('click','.mpr-month',function(e){
    e.stopPropagation();
  		$month = $(this);
    	var monthnum = $month.data('month');
    	var year = $month.parents('.mpr-calendar').children('h5').children('span').html();
        if($month.parents('#mpr-calendar-1').length > 0){
          //Start Date
          startDate = parseInt("" + year + monthnum);
          if(startDate > endDate){
            
            if(year != parseInt(endDate/100))
              $('.mpr-calendar:last h5 span').html(year);
               endDate = startDate;
          }
        }else{
          //End Date
          endDate = parseInt("" + year + monthnum);
          if(startDate > endDate){
            if(year != parseInt(startDate/100))
              $('.mpr-calendar:first h5 span').html(year);
            startDate = endDate;
          }
        }
    
    	paintMonths();
  });
  
  
  $(document).on('click','.mpr-yearup',function(e){
    	e.stopPropagation();
  		var year = parseInt($(this).prev().html());
    	year++;
    	$(this).prev().html(""+year);
   	 	$(this).parents('.mpr-calendar').find('.mpr-MonthsWrapper').fadeOut(175,function(){
        paintMonths();
        $(this).parents('.mpr-calendar').find('.mpr-MonthsWrapper').fadeIn(175);
      });
  });
  
  $(document).on('click','.mpr-yeardown',function(e){
    	e.stopPropagation();
  		var year = parseInt($(this).next().html());
    	year--;
    	$(this).next().html(""+year);
   	 	//paintMonths();
      $(this).parents('.mpr-calendar').find('.mpr-MonthsWrapper').fadeOut(175,function(){
        paintMonths();
        $(this).parents('.mpr-calendar').find('.mpr-MonthsWrapper').fadeIn(175);
      });
  });
  
  $(document).on('click','.mpr-ytd', function(e){
    e.stopPropagation();
    var d = new Date();
    startDate = parseInt(d.getFullYear() + "01");
    var month = d.getMonth() + 1;
    if(month < 9)
      month = "0" + month;
    endDate = parseInt("" + d.getFullYear() + month);
    $('.mpr-calendar').each(function(){
      var $cal = $(this);
      var year = $('h5 span',$cal).html(d.getFullYear());
    });
    $('.mpr-calendar').find('.mpr-MonthsWrapper').fadeOut(175,function(){
        paintMonths();
        $('.mpr-calendar').find('.mpr-MonthsWrapper').fadeIn(175);
    });
  });
  
  $(document).on('click','.mpr-prev-year', function(e){
    e.stopPropagation();
    var d = new Date();
    var year = d.getFullYear()-1;
    startDate = parseInt(year + "01");
    endDate = parseInt(year + "12");
    $('.mpr-calendar').each(function(){
      var $cal = $(this);
      $('h5 span',$cal).html(year);
    });
    $('.mpr-calendar').find('.mpr-MonthsWrapper').fadeOut(175,function(){
        paintMonths();
        $('.mpr-calendar').find('.mpr-MonthsWrapper').fadeIn(175);
    });
  });
  
  $(document).on('click','.mpr-fiscal-ytd', function(e){
    e.stopPropagation();
    var d = new Date();
    var year;
    if((d.getMonth()+1) < fiscalMonth)
      year = d.getFullYear() - 1;
    else
      year = d.getFullYear();
    if(fiscalMonth < 10)
      fm = "0" + fiscalMonth;
    else
      fm = fiscalMonth;
    if(d.getMonth()+1 < 10)
      cm = "0" + (d.getMonth()+1);
    else
      cm = (d.getMonth()+1);
    startDate = parseInt("" + year + fm);
    endDate = parseInt("" + d.getFullYear() + cm);
    $('.mpr-calendar').each(function(i){
      var $cal = $(this);
      if(i == 0)
      	$('h5 span',$cal).html(year);
      else
        $('h5 span',$cal).html(d.getFullYear());
    });
    $('.mpr-calendar').find('.mpr-MonthsWrapper').fadeOut(175,function(){
        paintMonths();
        $('.mpr-calendar').find('.mpr-MonthsWrapper').fadeIn(175);
    });
  });
  
  $(document).on('click','.mpr-prev-fiscal', function(){
    var d = new Date();
    var year;
    if((d.getMonth()+1) < fiscalMonth)
      year = d.getFullYear() - 2;
    else
      year = d.getFullYear() - 1;
    if(fiscalMonth < 10)
      fm = "0" + fiscalMonth;
    else
      fm = fiscalMonth;
    if(fiscalMonth -1 < 10)
      efm = "0" + (fiscalMonth-1);
    else
      efm = (fiscalMonth-1);
    startDate = parseInt("" + year + fm);
    endDate = parseInt("" + (d.getFullYear() - 1) + efm);
    $('.mpr-calendar').each(function(i){
      var $cal = $(this);
      if(i == 0)
      	$('h5 span',$cal).html(year);
      else
        $('h5 span',$cal).html(d.getFullYear()-1);
    });
    $('.mpr-calendar').find('.mpr-MonthsWrapper').fadeOut(175,function(){
        paintMonths();
        $('.mpr-calendar').find('.mpr-MonthsWrapper').fadeIn(175);
    });
  });
  
  var mprVisible = false;
  var mprpopover = $('.mrp-container').popover({
    container: "body",
    placement: "bottom",
    html: true,
    content: content
  }).on('show.bs.popover', function () {
    $('.popover').remove();
    var waiter = setInterval(function(){
      if($('.popover').length > 0){
        clearInterval(waiter);
        setViewToCurrentYears();
    		paintMonths();
      }
    },50);
  }).on('shown.bs.popover', function(){
    mprVisible = true;
  }).on('hidden.bs.popover', function(){
    mprVisible = false;
  }); 
  
  $(document).on('click','.mpr-calendarholder',function(e){
    e.preventDefault();
    e.stopPropagation();
  });
  $(document).on("click",".mrp-container",function(e){
    if(mprVisible){
      e.preventDefault();
    	e.stopPropagation();
      mprVisible = false;
    }
  });
  $(document).on("click",function(e){
    if(mprVisible){
    	$('.mpr-calendarholder').parents('.popover').fadeOut(200,function(){
        $('.mpr-calendarholder').parents('.popover').remove();
        $('.mrp-container').trigger('click');
      });
      mprVisible = false;
    }
  });
});

function setViewToCurrentYears(){
  	var startyear = parseInt(startDate / 100);
    var endyear = parseInt(endDate / 100);
  	$('.mpr-calendar h5 span').eq(0).html(startyear);
  	$('.mpr-calendar h5 span').eq(1).html(endyear);
}

function paintMonths(){
    $('.mpr-calendar').each(function(){
      var $cal = $(this);
      var year = $('h5 span',$cal).html();
      $('.mpr-month',$cal).each(function(i){
        if((i+1) > 9)
          cDate = parseInt("" + year + (i+1));
        else
          cDate = parseInt("" + year+ '0' + (i+1));
        if(cDate >= startDate && cDate <= endDate){
            $(this).addClass('mpr-selected');
        }else{
          $(this).removeClass('mpr-selected');
        }
      });
    });
  $('.mpr-calendar .mpr-month').css("background","");
    //Write Text
    var startyear = parseInt(startDate / 100);
    var startmonth = parseInt(safeRound((startDate / 100 - startyear)) * 100);
    var endyear = parseInt(endDate / 100);
    var endmonth = parseInt(safeRound((endDate / 100 - endyear)) * 100);
    $('.mrp-monthdisplay .mrp-lowerMonth').html(MONTHS[startmonth - 1] + " " + startyear);
    $('.mrp-monthdisplay .mrp-upperMonth').html(MONTHS[endmonth - 1] + " " + endyear);
    $('#periode').val(startyear+"-"+fix(startmonth)+"~"+endyear+"-"+fix(endmonth));
    $('.mpr-lowerDate').val(startDate);
    $('.mpr-upperDate').val(endDate);
  	if(startyear == parseInt($('.mpr-calendar:first h5 span').html()))
  		$('.mpr-calendar:first .mpr-selected:first').css("background","#40667A");
    if(endyear == parseInt($('.mpr-calendar:last h5 span').html()))
      $('.mpr-calendar:last .mpr-selected:last').css("background","#40667A");
  }
  function fix(angka){
  	if (angka < 10) { angka = "0"+angka}
  	return angka;
  }
  function safeRound(val){
    return Math.round(((val)+ 0.00001) * 100) / 100;
  }
  // $('#btn-coba').click(function() {
  // 	alert($("#periode").val());
  // });


	</script>
	</html>