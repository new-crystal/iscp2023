<?php
	$mb_info_query =	"
							SELECT
								mb.email,
								CONCAT(mb.first_name, ' ', mb.last_name) AS name_text,
								IFNULL(mb.affiliation, '-') AS affiliation,
								IFNULL(nt.nation_ko, '-') AS nation_text
							FROM member AS mb
							LEFT JOIN nation AS nt
								ON nt.idx = mb.nation_no
							WHERE mb.idx = '{$member_idx}'
						";
	$mb_info = sql_fetch($mb_info_query);
?>
<div class="clearfix2">
	<div class="tab_box">
		<ul class="tab_wrap clearfix">
			<li><a href="./member_detail.php?idx=<?=$member_idx?>">회원 정보</a></li>
			<li><a href="./member_detail2.php?idx=<?=$member_idx?>">Poster</a></li>
			<!-- <li><a href="./member_detail3.php?idx=<?=$member_idx?>">Lecture</a></li> -->
			<li><a href="./member_detail4.php?idx=<?=$member_idx?>">Registration</a></li>
			<!-- <li><a href="./member_detail5.php?idx=<?=$member_idx?>">수강내역</a></li> -->
			<!-- <li><a href="./member_detail6.php?idx=<?=$member_idx?>">Event Zone</a></li> -->
		</ul>
	</div>
	<div class="info clearfix">
		<p><?=$mb_info['email']?> / <?=$mb_info['name_text']?> / <?=$mb_info['affiliation']?> / <?=$mb_info['nation_text']?>  </p>
		<!-- <a href="./member_nametag.php?idx=<?=$member_idx?>" target="_BLANK">네임택 보기</a> -->
	</div>
</div>