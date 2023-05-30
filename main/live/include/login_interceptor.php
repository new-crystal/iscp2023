<?php
	if ($_SESSION["ADMIN"]["idx"] == "") {
		if($_SESSION["USER"]["idx"] == "") {
			echo "
			<script>
				window.parent.postMessage({
					functionName : 'need_login'
				}, '*');
			</script>
			";
			exit;
		} else {
			$sql_pmt =	"SELECT
							COUNT(rr.idx) AS cnt
						FROM request_registration AS rr
						INNER JOIN payment AS pmt
							ON pmt.idx = rr.payment_no
						WHERE rr.`status` = 2
						AND rr.register = '".$_SESSION["USER"]["idx"]."'";
			if (sql_fetch($sql_pmt)['cnt'] <= 0) {
				echo "
				<script>
					window.parent.postMessage({
						functionName : 'need_payment'
					}, '*');
				</script>
				";
			}
		}
	}
?>