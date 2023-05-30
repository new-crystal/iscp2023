<?php
$_nation_order = ($_SESSION["language"] == "ko") ? "nation_ko" : "nation_en";

$_nation_query =	"
						SELECT
							*
						FROM nation
						ORDER BY {$_nation_order} ASC
					";

$_abstract_category_query =	"
								SELECT 
									idx, title_en, title_ko
								FROM info_poster_abstract_category
								WHERE is_deleted = 'N'
							";
?>