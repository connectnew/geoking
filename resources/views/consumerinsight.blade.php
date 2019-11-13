@extends('layouts.dashboard')

@section('body')

    <div class="">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-12">

				<div class="main_div">
					<div class="first_half">
					   <ul class="first_half_ul">
						 <li style="background:#616466;">{{__('Real-Time Reviews')}}</li>
						 <li><?php
						//echo "" . date("Y/m/d");
						echo "" . date("M d, h:i a");

						?></li>
					  </ul>
					</div>
					
					
					
					<div class=" rv-slider">
	<div class="row">
<aside class="col-md-12">

<!-- ================== 1-carousel bootstrap  ==================  -->
<div id="carousel1_indicator" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carousel1_indicator" data-slide-to="0" class="active"></li>
    <li data-target="#carousel1_indicator" data-slide-to="1"></li>
    <li data-target="#carousel1_indicator" data-slide-to="2"></li>
  </ol>  
  <div class="carousel-inner">
	  <?php $i=1; ?>
	    @foreach($reviewsArr as $review)
	    
									@if($review->comment)
									 <div class="carousel-item <?php if($i == 1){ echo 'active'; }?>"><q>{{ $review->comment}}</q><br>
									  <span class="displayName">{{ $review->reviewer_name}}. <span class="createTime"><?php echo date("d/m/Y", strtotime($review->created_at)); ?></span></span>
<!--
										<div class="comment_section"><q>{{ $review->comment}}</q>
										 <div class="displayName">{{ $review->reviewer_name}}. <span class="createTime"><?php echo date("d/m/Y", strtotime($review->created_at)); ?></span></div>
										 
										</div>
-->
										</div>
									     <?php $i++;  ?>
									@endif	   
								@endforeach  
  
  </div>
  <a class="carousel-control-prev" href="#carousel1_indicator" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">{{__('Previous')}}</span>
  </a>
  <a class="carousel-control-next" href="#carousel1_indicator" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">{{__('Next')}}</span>
  </a>
</div> 
<!-- ==================  1-carousel bootstrap ==================  .// -->		
	</aside> <!-- col.// -->

	</div>
</div>
					
					
					
<!--
					<div id="slider" class="review-slider">
						  <a href="#" class="control_next">></a>
						  <a href="#" class="control_prev"><</a>
						  <ul>
							  
							   @foreach($reviewsArr as $review)
									@if($review->comment)
									<li><div class="comment_section"><q>{{ $review->comment}}</q>
										 <div class="displayName">{{ $review->reviewer_name}}. <span class="createTime"><?php echo date("d/m/Y", strtotime($review->created_at)); ?></span></div>
										 
										</div>
									</li>               
									@endif	   
								@endforeach  
				  </ul>  
				</div>
-->
				</div>
                
            </div>
        </div>
        
        
        
        
        
				<div class="cloud-word-widget">
					<div class="cloud-word-widget-filters">
					<select name="period1"  id="review_period" onchange='filterReviews();'>
						<option value=''>{{__('period')}}</option>
						<option value='1'>Last 1 month</option>
						<option value='3'>Last 3 month</option> 
						<option value='6'>Last 6 month</option>
						<option value='12'>Last 1 year</option>

					</select>
					<input type="date" id="review_period1" onchange='filterReviews();'  placeholder="period" name="period">
					<select name="review_location[]" id="review_location" onchange='filterReviews();' multiple>
						<option value="">{{__('location')}}</option>
						@foreach($locations as $location)
						<option value="{{$location->id}}" >{{$location->title}}</option>
						@endforeach
					</select>
					<select name="review_rating" id="review_rating" onchange='filterReviews();'>
						<option value="">{{__('rating')}}</option>
						<option value='5'>5</option>
						<option value='4'>4</option>
						<option value='3'>3</option>
						<option value='2'>2</option>
						<option value='1'>1</option>
					</select>
					</div>
					
						<div id="chartdiv"></div>
						
				</div>
    </div>

<style>



</style>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
jQuery(document).ready(function ($) {


    setInterval(function () {
        moveRight();
    }, 5000);
  
	var slideCount = $('#slider ul li').length;
	var slideWidth = $('#slider ul li').width();
	var slideHeight = $('#slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	$('#slider').css({ width: slideWidth, height: slideHeight });
	
	//$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
	$('#slider ul').css({ width: sliderUlWidth });
	
    $('#slider ul li:last-child').prependTo('#slider ul');

    function moveLeft() {
        $('#slider ul').animate({
			speed: 300,
            left: + slideWidth
        }, 1500, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    function moveRight() {
        $('#slider ul').animate({
			speed: 300,
            left: - slideWidth
        }, 1500, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    $('a.control_prev').click(function () {
        moveLeft();
    });

    $('a.control_next').click(function () {
        moveRight();
    });

	

//$('#review_location').select2();

 //~ $('#review_location').multiselect({
	  //~ allSelectedText: 'All',
   //~ includeSelectAllOption : true,
		//~ nonSelectedText: 'location'
  //~ });
});    

</script>


<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/plugins/wordCloud.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
	var series;
am4core.ready(function() {

// Themes begin
//am4core.useTheme(am4themes_moonrisekingdom);

am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv", am4plugins_wordCloud.WordCloud);
chart.fontFamily = 'Roboto,RobotoDraft,Helvetica,Arial,sans-serif';
series = chart.series.push(new am4plugins_wordCloud.WordCloudSeries());
series.randomness = 0;
series.accuracy = 3;
//series.minFontSize = '5px';
//series.maxFontSize = '20%';
/////////series.rotationThreshold = 0.5;
series.maxCount = 50;
series.data = <?php echo $words; ?>;

series.dataFields.word = "tag";
series.dataFields.value = "count";

series.heatRules.push({
 "target": series.labels.template,
 "property": "fill",
 "min": am4core.color("#000000"),
 "max": am4core.color("#094fb3"),
 "dataField": "value"
});

series.labels.template.fill = am4core.color("#094fb3");

//series.labels.template.url = "https://stackoverflow.com/questions/tagged/{word}";
//series.labels.template.urlTarget = "_blank";
series.labels.template.tooltipText = "{word}: {value}";

var hoverState = series.labels.template.states.create("hover");
hoverState.properties.fill = am4core.color("#FF0000");

var subtitle = chart.titles.create();
//subtitle.text = "(click to open)";

var title = chart.titles.create();
title.text = "Reviews CloudWord";
title.fontSize = 22;
title.fontWeight = "400";
title.align = "left";
title.textColor = "#ccc";
title.color = "#ccc";			
			
}); // end am4core.ready()


   function filterReviews(){
	  var ratingVal =  $("#review_rating").val();
	  var periodVal =  $("#review_period1").val();
	  var locationVal =  $("#review_location").val();

		
		$.ajax({
		 url: "filter-reviews",  
		 data : { 'rating' : ratingVal , 'period' : periodVal , 'location' : locationVal    },
         success: function(result) { 
                //  alert(result);
             
        

		  var ChartData = result;
  var CD = ChartData.split("},{");
  
  var NewChartDataArray = [];
  for(i=0; i<CD.length; i++)
  {
    var D = CD[i];
    D = D.replace("{","");
    D = D.replace("}","");
    D = "{" + D + "}";
    
    NewChartDataArray.push(JSON.parse(D));
  }
 
		series.data = NewChartDataArray;
		//Updating the graph to show the new data
		chart.validateData();
			 }
         
         }); 	
   }
</script>

<style>
	
	.no-review-data {

    position: relative;
    text-align: center;
    top: 20%;
    z-index: 99999999;
    font-size: 24px;

}
	.select2-results .select2-results__option {

    font-size: 10px !important;
    margin: 0px 0px!important;
    line-height:10px;

}.select2-results__option {

    font-size: 10px !important;

}
	.cloud-word-widget-filters .select2-container .select2-selection--single .select2-selection__rendered {
	display: block;
	padding-left: 8px;
	padding-right: 13px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
}
	.cloud-word-widget-filters .select2-container--default .select2-selection--single {

    background: none !important;
    border: none !important;
    border-radius: 4px;
    height: 34px !important;

}

 .cloud-word-widget-filters	.select2-container--default .select2-selection--single .select2-selection__rendered {

    color: #444;
    line-height: 24px;
    font-size: 14px;
    height: 34px !important;
    margin-right:10px !important;

}
	.cloud-word-widget-filters .select2 {

    width: auto !important;

}

	select{ width:100px}
.cloud-word-widget-filters{	
	//position: absolute;

right: 50%;
z-index: 9999999999;
margin-top: 18px;
}
	#chartdiv {
  width: 100%;
  height: 650px;
  border: 1px solid #ccc;
  padding: 20px;
  background: #fff;
}

.cloud-word-widget {
	width: 42%;
	//height: 600px;
	margin: 50px 50px 50px 0px;
	
	padding-top: 30px;
}

.carousel-indicators {
	display: none !important;
}
.carousel-item {
	min-height: 300px;
	background: #e3e3e3 !important;
}
.carousel-item{min-height:300px; background:#ccc; }

.carousel-inner {
	height: 122px;
}
.carousel-control-prev {
	left:unset !important;
	right: 40px !important;
}

.rv-slider aside {
	padding-left: 0px !important;
}
.carousel-item {
	padding: 10px 20px;
	font-size: 17px;
}

.carousel-control-next, .carousel-control-prev {

	top: 61px !important;

	width: 50px !important;

}
.main_div .first_half_ul li {
	font-size: 18px !important;
}

#review_period1 {
	position: absolute;
	right: 100px;
	z-index: opacity;
	opacity: 0;
	z-index: 9999999999;
	top: 12px;
}
#review_period1 {
    right: 0;
    z-index: 9999999999;
    margin-right: 156px;
    margin-top: -5px;

}
</style>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!--container end.//-->

