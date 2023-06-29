<?php
include_once('./include/head.php');
include_once('./include/header.php');

$total_count = 0;
$current_page = $_GET["page"] ? @(int) $_GET["page"] : 0;
$current_page = ($current_page > 0) ? $current_page : 1;
$start = 10 * ($current_page - 1);

$sql =	"
			SELECT
				b.idx, b.title_en, b.title_ko, f.path, DATE_FORMAT(b.register_date, '%Y-%m-%d') AS register_date, b.view
			FROM board AS b
			LEFT JOIN(
				SELECT
					idx, CONCAT(path,'/',save_name) AS path
				FROM `file`
			)AS f
			ON b.thumnail = f.idx
			WHERE b.is_deleted = 'N'
			AND b.`type` = 1
			";

$total_count = count(get_data($sql));

$sql .= " ORDER BY b.register_date DESC LIMIT {$start}, 10 ";
$list = get_data($sql);
?>

<section class="board container notice">
	<div class="sub_background_box">
		<div class="sub_inner">
			<div>
				<h2>News & Notice</h2>
				<div class="color-bar"></div>
				<!-- <ul class="clearfix"> -->
				<!-- 	<li>Home</li> -->
				<!-- 	<li>News & Notice</li> -->
				<!-- 	<li>Notice</li> -->
				<!-- </ul> -->
			</div>
		</div>
	</div>
	<div class="inner">
		<ul class="">
			<!--tab_pager-->
			<!-- <li><a href="./board_news.php">News</a></li> -->
			<!-- <li class="on"><a href="./board_notice.php">Notice</a></li> -->
			<!-- <li><a href="./board_faq.php">FAQ</a></li> -->
			<div class="circle_title">News & Notice</div>
		</ul>
		<div>
			<?php
			if (count($list) > 0) {
			?>
				<div class="table_wrap">
					<table class="table table_responsive left_border_table">
						<thead>
							<tr>
								<!-- <th class="new_icon"></th> -->
								<?php
								$table_title_arr = ($language == "ko") ? ["번호", "제목", "작성일"] : ["No", "Title", "Date"];
								foreach ($table_title_arr as $th_text) {
								?>
									<th><?= $th_text ?></th>
								<?php
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
							$col_title = "title_" . $language;
							for ($i = 0; $i < count($list); $i++) {
								$l = $list[$i];
							?>
								<tr>
									<!--
									<td class="new_icon">
									<?php
									$boardtime = $l["register_date"];

									$timenow = date("Y-m-d");
									$time_yesterday = date("Y-m-d", strtotime($day . " -1 day"));
									if ($boardtime >= $time_yesterday && $boardtime <= $timenow) {
										echo '<p class="label">new</p>';
									}
									?>
									</td>-->
									<td><?= number_format($total_count - (($current_page - 1) * 10) - $i) ?></td>
									<td class="leftT"><a href="./board_notice_detail.php?num=<?= number_format($total_count - (($current_page - 1) * 10) - $i); ?>&no=<?= $l["idx"] ?>&p=<?= $current_page ?>"><?= stripslashes($l[$col_title]) ?></a>
									</td>
									<td><?= $boardtime ?></td>
									<!-- <td class="gray_txt"><?= number_format($l["view"]) ?></td> -->
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			<?php
			} else {
			?>
				<div class='no_data'>Will be updated</div>
			<?php
			}
			?>
			<!-- pagination -->
			<div class="pagination">
				<ul class="clearfix">
					<?php
					$total_page = ($total_count % 10 != 0) ? intval($total_count / 10) + 1 : intval($total_count / 10);

					$pagination_raw = 10;
					$pagination_total_page = ($total_page % $pagination_raw != 0) ? intval($total_page / $pagination_raw) + 1 : intval($total_page / $pagination_raw);
					$pagination_current_page = ($current_page % $pagination_raw == 0) ? intval($current_page / $pagination_raw) - 1 : intval($current_page / $pagination_raw) + 1;
					$pagination_current_page = ($pagination_current_page > 1) ? $pagination_current_page : 1;

					$url = "?page=";

					// 이전페이지
					if ($pagination_current_page > 1) {
						echo "<li><a href='./board_notice.php" . ($url . ($pagination_raw * ($pagination_current_page - 1))) . "'><img src='./img/icons/arrows_left.png'></a></li>";
					}

					$max = $pagination_raw > $total_page ? $total_page : $pagination_raw;
					for ($a = 0; $a < $max; $a++) {
						$page = ($pagination_raw * ($pagination_current_page - 1)) + 1 + $a;
						$on = ($current_page == $page) ? "on" : "";

						echo "<li class='" . $on . "'><a href='./board_notice.php" . ($url . $page) . "'>" . $page . "</a></li>";
					}

					// 다음페이지
					if ($pagination_total_page > $current_page) {
						echo "<li><a href='./board_notice.php" . ($url . ($page + 1)) . "'><img src='./img/icons/arrows_right.png'></a></li>";
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</section>


<style>
	section.notice .table th {
		color: #00666B;
	}

	section.notice.board td a {
		max-width: 500px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
</style>

<?php include_once('./include/footer.php'); ?>