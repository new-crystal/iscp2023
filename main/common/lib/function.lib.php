<?php
$_nation_order = ($_SESSION["language"] == "ko") ? "nation_ko" : "nation_en";

$_nation_query =	"
						SELECT
							*
						FROM nation
						ORDER BY {$_nation_order} ASC
					";
?>