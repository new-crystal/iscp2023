<!-- mypage 팝업 -->
<div class="popup table_pop">
	<div class="pop_bg"></div>
	<div class="pop_contents">
		<h1 class="pop_title clearfix">
			<span class="lato short_txt"><?=$_SESSION["USER"]["first_name"]." ".$_SESSION["USER"]["last_name"]?> 님 <!--(<span class="lato"><?=$_SESSION["USER"]["affiliation"]?></span>)--></span>
			<img class="pop_close pointer floatR" src="./images/icon/icon_x.png" alt="아이콘_x">
		</h1>
		<div class="pop_cont">
			<div class="alert">
				<p class="point_txt">For Korean Participant Only</p>
				<p class="bold_txt">각 협회 및 기관 평점 인정 기준에 따라, 각 세션마다 출결 시간 기록이 필요합니다.</p>
				<p class="font_thin">· 현 평점 이수 현황은 온라인 시청에 한하여 반영됩니다.<br/>· 오프라인 출결확인은 현장 QR태그를 통해 확인 가능하며, 학회 종료 이후 현 My Page에서 확인 가능합니다.<br/>· Entrance Time / Exit Time은 입출입 시간으로 표기 되며, 최종 이수 평점은 브레이크 시간 및 기타 시간은 자동 제외 되어 계산 됩니다.<br>· 현 페이지의 기록 및 평점 내용은 현장 방송 사정에 따라 상이 할 수 있습니다.<br>· 학회 종료 후 최종 이수평점 확인은 SMS 문자 안내드릴 예정이며, 현 My Page에서도 확인 가능합니다.</p>
			</div>
			<div>
				<ul class="tab_pager clearfix">
					<?php
						for($i=0;$i<$_PERIOD_COUNT;$i++){
							$class_on = $i==0 ? "on" : "";
							$ymd = date_create($_PERIOD[$i]);
					?>
					<li class="<?=$class_on?>">
						<a href="javascript:;">
							<?php
								echo check_device() ? date_format($ymd, "M. j(D)")."<br>".date_format($ymd, "Y") : date_format($ymd, "M. j(D) Y");
							?>
						</a>
					</li>
					<?php
						}
					?>
				</ul>
				<div class="tab_wrap">
					<?php
						for($i=0;$i<$_PERIOD_COUNT;$i++){
							$class_on = $i==0 ? "on" : "";
							$ymd = $_PERIOD[$i];
							$daily_watch_time_min = 0;
					?>
					<div class="tab_cont <?=$class_on?>">
						<div class="color_table_wrap">
							<table class="color_table">
								<colgroup>
									<col style="width: 40%;">
									<col style="width: 40%;">
									<col style="width: 20%;">
								</colgroup>
								<thead>
									<tr>
										<th>Entrance Time</th>
										<th>Exit Time</th>
										<th>Watch Time</th>
									</tr>
								</thead>
								<tbody name="lecs">
									<tr class="centerT"><td colspan="4">No Data</td></tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
						<table class="custom_table">
							<colgroup>
								<col width="190px"/>
								<col width="*"/>
								<col width="190px"/>
							</colgroup>
							<tr>
								<th>Daily Watch Time</th>
								<td name="total_watch_time"> h</td>
								<td></td>
							</tr>
						</table>
						<table class="table_bt mb_custom_table">
							<colgroup>
								<col width="190px"/>
								<col width="*"/>
								<col width="190px"/>
							</colgroup>
							<thead>
								<tr>
									<th></th>
									<th>오늘 이수 평점</th>
									<th>현재까지 이수 총평점</th>
								</tr>
							</thead>
							<tbody name="score">
								<tr>
									<th></th>
									<td> 점</td>
									<td> 점</td>
								</tr>
							</tbody>
						</table>
					</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	const _PERIOD = JSON.parse('<?=json_encode($_PERIOD)?>');
	$(".table_open").click(function () {
		var member_idx = "<?=$_SESSION['USER']['idx']?>";
		var admin_idx = "<?=$_SESSION['ADMIN']['idx']?>";

		if (!member_idx && admin_idx) {
			alert('사용자 로그인 후 이용해주세요.');
		} else {
			$.ajax({
				url : "/main/ajax/client/ajax_lecture.php?flag=calc_score",
				type : "GET",
				dataType : "JSON",
				success : function(res){
					var ymd, inner, day;
					_PERIOD.forEach(function(ymd, index){
						// daily
						day = res.entrance_log[ymd];
						inner = '';
						if (day.watch_mins <= 0) {
							inner += '<tr class="centerT"><td colspan="4">No Data</td></tr>';
						} else {
							inner +=	'<tr>';
							inner +=		'<td>' + day.entrance_date + '</td>';
							inner +=		'<td>' + day.exit_date + '</td>';
							inner +=		'<td>' + day.watch_time + ' h</td>';
							inner +=	'</tr>';
						}
						$('[name=lecs]').eq(index).html(inner);
						$('[name=total_watch_time]').eq(index).html(day.watch_time + " h");

						// score
						inner = '';
						if (res.score.length <= 0) {
							inner += '<tr class="centerT"><td colspan="4">No Data</td></tr>';
						} else {
							res.score.forEach(function(group){
								inner +=	'<tr>';
								inner +=		'<th>' + group.name + '</th>';
								inner +=		'<td>' + group[ymd] + ' 점</td>';
								inner +=		'<td>' + group.total + ' 점</td>';
								inner +=	'</tr>';
							});
						}
						$('[name=score]').eq(index).html(inner);
					});

					$(".table_pop").addClass("on");
				},
				error : function(){
					alert("일시적으로 요청이 거절되었습니다.");
				}
			});
		}
	});

	//탭
	$(".table_pop .tab_pager li").click(function () {
		var _this = $(this);

		var _targets = $(".table_pop .tab_pager li");
		var i = 0;
		_targets.each(function(index){
			if ($(this).children('a').text() == _this.children('a').text()) {
				i = index;
				return false;
			}
		});
		_targets.removeClass("on");
		_this.addClass("on");

		var _conts = _this.parents('ul').siblings('.tab_wrap').children('.tab_cont');
		_conts.removeClass("on");
		_conts.eq(i).addClass("on");
	});
</script>