<?php
include_once('./include/head.php');
include_once('./include/header.php');

$sql_title =	"SELECT
						GROUP_CONCAT(title) AS title_concat
					FROM (
						SELECT 
							title_" . $language . " AS title
						FROM info_general_commitee
						WHERE is_deleted = 'N'
						AND title_" . $language . " <> ''
						GROUP BY title_" . $language . "
						ORDER BY idx
					) AS res";
$titles = explode(',', sql_fetch($sql_title)['title_concat']);
?>
<section class="container organizing">
    <div class="sub_background_box">
        <div class="sub_inner">
            <div>
                <h2>Organization</h2>
                <div class="color-bar"></div>
                <!-- <ul>
					<li>Home</li>
					<li>ISCP 2023</li>
					<li>Organization</li>
				</ul> -->
            </div>
        </div>
    </div>
    <div class="inner">
        <div class="">
            <!-- <div class="circle_title">
				Organizing Committee
			</div> -->
            <div class="table_wrap x_scroll">
                <table class="table left_border_table table_responsive">
                    <colgroup>
                        <col class="organization_col">
                        <col class="organization_col2">
                        <col width="*">
                    </colgroup>
                    <!-- <thead>
                        <tr>
                            <th>Members</th>
                            <th>Name</th>
                            <th>Affiliation</th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <tr>
                            <td class="table_title" rowspan="3">Co-Chairs</td>
                            <td class="background">Sang Hong Baek</td>
                            <td class="background">The Catholic University of Korea College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left">Young Keun On</td>
                            <td>Sungkyunkwan University School of Medicine</td>
                        </tr>
                        <tr>
                            <td class="background border_left">
                                Won-Young Lee
                            </td>
                            <td class="background">Sungkyunkwan University School of Medicine</td>
                        </tr>
                        <tr>
                            <td class="table_title">Vice Chair</td>
                            <td>Kyung-Yul Lee</td>
                            <td>Yonsei University College of Medicine </td>
                        </tr>
                        <tr>
                            <td class="table_title" rowspan="2">Co-Secretary General </td>
                            <td class="background">Sung-Hwan Kim</td>
                            <td class="background">The Catholic University of Korea College of Medicine </td>
                        </tr>
                        <tr>
                            <td class="border_left">Eun-Jung Rhee </td>
                            <td>Sungkyunkwan University School of Medicine</td>
                        </tr>
                        <tr>
                            <td class="table_title">Vice Secretory General</td>
                            <td class="background">Jong-Chan Youn </td>
                            <td class="background">The Catholic University of Korea College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">Treasurer</td>
                            <td>Dae Hyeok Kim</td>
                            <td>Inha University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Jae-hyuk Lee</td>
                            <td class="background">Myongji Hospital </td>
                        </tr>
                        <tr>
                            <td class="table_title" rowspan="2">Scientific Program Committee </td>
                            <td>Hae-Young Lee</td>
                            <td>Seoul National University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Seung-Hyun Ko </td>
                            <td class="background">The Catholic University of Korea College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">International Liaison Committee </td>
                            <td>Yong-Jin Kim</td>
                            <td>Seoul National University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Dae-Jung Kim </td>
                            <td class="background">Ajou University School of Medicine</td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">Local Liaison Committee </td>
                            <td>Hyeon Chang Kim</td>
                            <td>Yonsei University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Jang-Whan Bae</td>
                            <td class="background">Chungbuk National University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">Public Relation Committee </td>
                            <td>Young Bin Song</td>
                            <td>Sungkyunkwan University School of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Hun-Jun Park </td>
                            <td class="background">The Catholic University of Korea College of Medicine</td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">Information Technology Committee </td>
                            <td>Sung Kee Ryu</td>
                            <td>Ewha Womans University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Sungha Park</td>
                            <td class="background">Yonsei University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">Registration Committee </td>
                            <td>Yo-han Jeong</td>
                            <td>Yonsei University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Hyung-Min Kwon</td>
                            <td class="background">Seoul National University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">Accommodation & Transportation Committee </td>
                            <td>Woo-Baek Chung </td>
                            <td>The Catholic University of Korea College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Seong-Hoon Choi</td>
                            <td class="background">Hallym University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">Sponsorship and Exhibition Committee </td>
                            <td>Sang-Hyun Kim</td>
                            <td>Seoul National University College of Medicine </td>
                        </tr>
                        <tr>
                            <td class="border_left background">Sang-Ho Jo </td>
                            <td class="background">Hallym University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">Protocol and Social Program Committee</td>
                            <td>Jin Oh Choi </td>
                            <td>Sungkyunkwan University School of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Soon Jun Hong</td>
                            <td class="background">Korea University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="table_title">Publication Committee</td>
                            <td>Junghyun Noh</td>
                            <td>Inje University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="table_title" rowspan="2">Primary Physicians' Committee</td>
                            <td class="background">Joon-Han Shin</td>
                            <td class="background">Ajou University School of Medicine </td>
                        </tr>
                        <tr>
                            <td class="border_left">Sang Hak Lee </td>
                            <td>Yonsei University College of Medicine</td>
                        </tr>

                        <tr>
                            <td class="table_title" rowspan="2">Auditors</td>
                            <td class="background">Seung Hwan Han</td>
                            <td class="background">Gachon University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left">Sung-Hee Cho</td>
                            <td>Seoul National University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="table_title" rowspan="34">Domestic Faculty</td>
                            <td class="background">Jin Ju Park </td>
                            <td class="background">Seoul National University College of Medicine</td>
                        </tr>

                        <tr>
                            <td class="border_left">Hae Ok Jung</td>
                            <td>The Catholic University of Korea College of Medicine </td>
                        </tr>
                        <tr>
                            <td class="border_left background">Yoonju Song </td>
                            <td class="background">The Catholic University of Korea College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Sang Won Han</td>
                            <td>Inje University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Mi-Seung Shin </td>
                            <td class="background">Gachon University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Dong Su Kim</td>
                            <td>Inje University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Song Vogue Ahn </td>
                            <td class="background">Ewha Womans University </td>
                        </tr>

                        <tr>
                            <td class="border_left">Jae-sun Eom </td>
                            <td>Yonsei University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Kwang-Il Kim </td>
                            <td class="background">Seoul National University College of Medicin </td>
                        </tr>

                        <tr>
                            <td class="border_left">Jae-Joong Kim </td>
                            <td>University of Ulsan College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Jeong-Min Lee</td>
                            <td class="background">The Catholic University of Korea College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Kwang Joon Kim </td>
                            <td>Yonsei University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Jong-Il Choi </td>
                            <td class="background">Korea University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Seung-Woon Rha </td>
                            <td>Korea University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Jong-Yun Lee</td>
                            <td class="background">National Medical Center </td>
                        </tr>

                        <tr>
                            <td class="border_left">Hun-Sung Kim </td>
                            <td>The Catholic University of Korea College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Hyeong-Kyu Park </td>
                            <td class="background">Soon Chun Hyang University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Myung A Kim </td>
                            <td>Seoul National University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Sang Hyun Ihm </td>
                            <td class="background">The Catholic University of Korea College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Jong-Young Lee </td>
                            <td>Sungkyunkwan University School of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Hahn Young Kim </td>
                            <td class="background">Konkuk University Medical School </td>
                        </tr>

                        <tr>
                            <td class="border_left">Cheol Whan Lee </td>
                            <td>University of Ulsan College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Dae Ryong Kang </td>
                            <td class="background">Yonsei University, Wonju College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Bum-Soon Choi </td>
                            <td>The Catholic University of Korea College of Medicine </td>
                        </tr>
                        <tr>
                            <td class="border_left background">Gyu Chul Oh </td>
                            <td class="background">The Catholic University of Korea College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Jong-Min Song</td>
                            <td>University of Ulsan College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Sook Jeon </td>
                            <td class="background">Kyung Hee University School of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Il Seo </td>
                            <td>Yonsei University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Chan-Hee Jung </td>
                            <td class="background">Soon Chun Hyang University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Hack-Lyoung Kim</td>
                            <td>Seoul National University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Jin Oh Na</td>
                            <td class="background">Korea University College of Medicine </td>
                        </tr>

                        <tr>
                            <td class="border_left">Byung-Chul Lee </td>
                            <td>Hallym University College of Medicine</td>
                        </tr>
                        <tr>
                            <td class="border_left background">Sang-Eun Lee </td>
                            <td class="background">Ewha Womans University College of Medicine</td>
                        </tr>

                        <tr>
                            <td class="border_left">Min-Wook Jang</td>
                            <td>Hallym University College of Medicine</td>
                        </tr>

                        <!-- <tr>
							<td>2022 Vice-president</td>
							<td>Jae Bum Kim</td>
							<td>Seoul National University</td>
						</tr>
						<tr>
							<td>Chairman</td>
							<td>Donghoon Choi</td>
							<td>Yonsei University</td>
						</tr>
						<tr>
							<td>Secretary General</td>
							<td>Chul Sik Kim</td>
							<td>Yonsei University</td>
						</tr>
						<tr>
							<td rowspan="5">Vice-Secretary General</td>
							<td>Kyung-Soo Kim</td>
							<td>CHA University</td>
						</tr>
						<tr>
							<td class="border_left">Sunghwan Suh</td>
							<td>Dong-A University</td>
						</tr>
						<tr>
							<td class="border_left">Heung Yong Jin</td>
							<td>Jeonbuk National University</td>
						</tr>
						<tr>
							<td class="border_left">Hoyoun Won</td>
							<td>Chung-Ang University</td>
						</tr>
						<tr>
							<td class="border_left">Jiwon Hwang</td>
							<td>Inje University</td>
						</tr>
						<tr>
							<td>Treasurer</td>
							<td>Soon Jun Hong</td>
							<td>Korea University</td>
						</tr>
						<tr>
							<td>Director, Planning Committee</td>
							<td>Dae Jung Kim</td>
							<td>Ajou University</td>
						</tr>
						<tr>
							<td>Director, Scientific Program Committee</td>
							<td>Sang-Hak Lee</td>
							<td>Yonsei University</td>
						</tr>
						<tr>
							<td>Director, Publication Committee</td>
							<td>Jaetaek Kim</td>
							<td>Chung-Ang University</td>
						</tr>
						<tr>
							<td>Director, Public Relations Committee</td>
							<td>In-Kyung Jeong</td>
							<td>Kyung Hee University</td>
						</tr>
						<tr>
							<td>Director, International Liaison Committee</td>
							<td>Sung Hee Choi</td>
							<td>Seoul National University</td>
						</tr>
						<tr>
							<td>Director, Insurance and Legislation Committee</td>
							<td>Hyun Jae Kang</td>
							<td>Seoul National University</td>
						</tr>
						<tr>
							<td>Director, Education Committee</td>
							<td>Byung Jin Kim</td>
							<td>Sungkyunkwan University</td>
						</tr>
						<tr>
							<td>Director, Clinical Practice Guideline Committee</td>
							<td>Sang-Hyun Kim</td>
							<td>Seoul National University</td>
						</tr>
						<tr>
							<td>Director, Clinic Research Committee</td>
							<td>Sungha Park</td>
							<td>Yonsei University</td>
						</tr>
						<tr>
							<td>Director, Basic Research Committee</td>
							<td>Young Mi Park</td>
							<td>Ewha Womans University</td>
						</tr>
						<tr>
							<td>Director, Food and Nutrition Committee</td>
							<td>Min-Jeong Shin</td>
							<td>Korea University</td>
						</tr>
						<tr>
							<td rowspan="4">Director without Portfolio</td>
							<td>Kee Ho Song</td>
							<td>Konkuk University</td>
						</tr>
						<tr>
							<td class="border_left">Seong Hun Choi</td>
							<td>Hallym University</td>
						</tr>
						<tr>
							<td class="border_left">Ung Kim</td>
							<td>Yeungnam University</td>
						</tr>
						<tr>
							<td class="border_left">Young Joon Hong</td>
							<td>Chonnam National University</td>
						</tr>
						<tr>
							<td rowspan="2">Auditors</td>
							<td>Goo Taeg Oh</td>
							<td>Ewha Womans University</td>
						</tr>
						<tr>
							<td class="border_left">Sung Rae Kim</td>
							<td>The Catholic University of Korea</td>
						</tr> -->
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <!-- <div class="circle_title">
                Scientific Program Committee
            </div> -->
            <div class="table_wrap x_scroll">
                <!-- <table class="table centerT left_border_table table_responsive">
                    <colgroup>
                        <col class="organization_col">
                        <col class="organization_col2">
                        <col width="*">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Members</th>
                            <th>Name</th>
                            <th>Affiliation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Director</td>
                            <td>Sang-Hak Lee</td>
                            <td>Yonsei University</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Secretary</td>
                            <td>SungWan Chun</td>
                            <td>Soonchunhyang University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Chan Joo Lee</td>
                            <td>Yonsei University</td>
                        </tr>
                        <tr>
                            <td>Vice secretary</td>
                            <td>Seung-Jun Lee</td>
                            <td>Yonsei University</td>
                        </tr>
                        <tr>
                            <td rowspan="15">Members</td>
                            <td>Pil-Ki Min</td>
                            <td>Yonsei University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Han-Mo Yang</td>
                            <td>Seoul National University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Jang-Hoon Lee</td>
                            <td>Kyungpook National University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Chul-Ung Choi</td>
                            <td>Korea University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Young Jun Hong</td>
                            <td>Chonnam National University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Masahiro Koseki</td>
                            <td>Osaka University, Japan</td>
                        </tr>
                        <tr>
                            <td class="border_left">Kyung-Soo Kim</td>
                            <td>CHA University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Jeong-Min Kim</td>
                            <td>Seoul National University</td>
                        </tr> -->
                <!-- <tr> -->
                <!-- 	<td class="border_left">Hyun Min Kim</td> -->
                <!-- 	<td>Chung-Ang University</td> -->
                <!-- </tr> -->
                <!-- <tr>
                            <td class="border_left">Sung Hee Choi</td>
                            <td>Seoul National University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Yong Sook Kim</td>
                            <td>Chonnam National University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Tae-Sik Park</td>
                            <td>Gachon University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Hong-Hee Won</td>
                            <td>Sungkyunkwan University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Jae-Hoon Choi</td>
                            <td>Hanyang University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Kyung-Sun Heo</td>
                            <td>Chungnam National University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Hyeon Jeong Lim</td>
                            <td>Kyung Hee University</td>
                        </tr>
                        <tr>
                            <td rowspan="4">Advisors</td>
                            <td>Dong-Eog Kim</td>
                            <td>Dongguk University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Sahng Wook Park</td>
                            <td>Yonsei University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Young Mi Park</td>
                            <td>Ewha Womans University</td>
                        </tr>
                        <tr>
                            <td class="border_left">Chang Yeop Han</td>
                            <td>University of Washington, USA</td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
        </div>
    </div>
</section>

<?php include_once('./include/footer.php'); ?>