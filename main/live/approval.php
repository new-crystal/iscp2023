<?php include_once("./include/header.php")?>
		<section class="container approval">
			<h2 class="title">Question</h2>
			<ul class="question_slick wheel_zoom">
				<li>ICOMES has grown as a worldwide academic society with <br/>more than 1,000 participants and eminent representative <br/>speakers in obesity every year since 2015 at its launch. <br/>ICOMES is an international academic conference that <br/>promotes cooperation. </li>	
				<li>ICOMES has grown as a worldwide academic society with <br/>more than 1,000 participants and eminent representative <br/>speakers in obesity every year since 2015 at its launch. <br/>ICOMES is an international academic conference that <br/>promotes cooperation. </li>	
				<li>ICOMES has grown as a worldwide academic society with <br/>more than 1,000 participants and eminent representative <br/>speakers in obesity every year since 2015 at its launch. <br/>ICOMES is an international academic conference that <br/>promotes cooperation. </li>	
				<li>ICOMES has grown as a worldwide academic society with <br/>more than 1,000 participants and eminent representative <br/>speakers in obesity every year since 2015 at its launch. <br/>ICOMES is an international academic conference that <br/>promotes cooperation. </li>
			</ul>
			<div class="custom_option">
				<div class="pagingInfo"></div>
				<div><button class="custom_arrow next_arrow"></button></div>
				<div><button class="custom_arrow prev_arrow"></button></div>
			</div>
		</section>	
		<script>
			


			// 마우스 휠 동작에 따른 폰트 사이즈 확대/축소
			
			$("ul.wheel_zoom li").bind("mousewheel DOMMouseScroll", function(e){
				// determines direction of scroll
				var delta = e.originalEvent.wheelDelta || -e.originalEvent.detail; 
				var curSize = parseInt($("ul.wheel_zoom li").css('font-size'), 10);
				console.log(e);

				// scroll down
				if(delta>0){
					curSize -= 1;
				}else{ //scroll up
					curSize += 1;
				}
				$("ul.wheel_zoom li").css({"font-size" : curSize+"px"});

			});
			
			
			
			// 슬릭 이벤트
			var $status = $('.pagingInfo');
			var $slickElement = $('.question_slick');

			$slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
				//currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
				if(!slick.$dots){
					return;
				}
			
				var i = (currentSlide ? currentSlide : 0) + 1;
				$status.text(i + '/' + (slick.$dots[0].children.length));
			});

			$slickElement.slick({
				autoplay: true,
				dots: true,
				prevArrow: '.prev_arrow',
				nextArrow: '.next_arrow'
			});
			
			
			
			
			
		</script>
	</body>
</html>