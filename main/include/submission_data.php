<?php
// department
$department_list = array(
	array("idx" => 1, "name_en" => "Cardiology"),
	array("idx" => 2, "name_en" => "Endocrinology"),
	array("idx" => 3, "name_en" => "Internal Medicine"),
	array("idx" => 4, "name_en" => "Family Medicine"),
	array("idx" => 5, "name_en" => "Nursing"),
	array("idx" => 6, "name_en" => "Basic Science"),
	array("idx" => 7, "name_en" => "Pediatric"),
	array("idx" => 8, "name_en" => "Food & Nutrition"),
	array("idx" => 9, "name_en" => "Neurology"),
	array("idx" => 10, "name_en" => "Nephrology"),
	array("idx" => 11, "name_en" => "Pharmacology"),
	array("idx" => 12, "name_en" => "Pharmacy"),
	array("idx" => 13, "name_en" => "Preventive Medicine"),
	array("idx" => 14, "name_en" => "Excercise Physiology"),
	array("idx" => 15, "name_en" => "Clinical Pathology"),
	array("idx" => 16, "name_en" => "Other Professional")
);
function get_department_option_text($department_list, $selected)
{
	$department_option_text = '<option value="" hidden>Choose</option>';
	foreach ($department_list as $dp) {
		$department_option_text .= '<option value="' . $dp['idx'] . '" ' . ($dp['idx'] == $selected ? 'selected' : '') . '>' . $dp['name_en'] . '</option>';
	}
	return $department_option_text;
}

// topic
$topic1_list = array(
	array("idx" => 1, "order" => 1, "name_en" => "Ischemic heart disease/ coronary artery disease"),
	array("idx" => 2, "order" => 2, "name_en" => "Anti-platelets and anticoagulation"),
	array("idx" => 3, "order" => 3, "name_en" => "Heart failure with reduced ejection fraction and preserved ejection fraction"),
	array("idx" => 4, "order" => 4, "name_en" => "Cardiomyopathies"),
	array("idx" => 5, "order" => 5, "name_en" => "Cardio-renal syndromes"),
	array("idx" => 6, "order" => 6, "name_en" => "Preventive Cardiology"),
	array("idx" => 7, "order" => 7, "name_en" => "Cardiac arrhythmias"),
	array("idx" => 8, "order" => 8, "name_en" => "Peripheral arterial disease"),
	array("idx" => 9, "order" => 9, "name_en" => "Pulmonary hypertension"),
	array("idx" => 10, "order" => 10, "name_en" => "Geriatric pharmacology"),
	array("idx" => 11, "order" => 11, "name_en" => "Women’s heart health"),
	array("idx" => 12, "order" => 12, "name_en" => "Basic science and genetics"),
	array("idx" => 13, "order" => 13, "name_en" => "COVID-19 related cardio-pharmacotherapy"),
	array("idx" => 14, "order" => 14, "name_en" => "Diabetes & Obesity"),
	array("idx" => 15, "order" => 15, "name_en" => "Hyperlipidemia and CVD"),
	array("idx" => 16, "order" => 16, "name_en" => "Epidemiology"),
	array("idx" => 17, "order" => 17, "name_en" => "Precision medicine/ Digital healthcare  ")
);
$topic2_list = array(
	array("idx" =>  1, "parent" => 1, "order" => 1, "name_en" => "TG rich lipoprotein metabolism"),
	array("idx" =>  2, "parent" => 1, "order" => 2, "name_en" => "HDL & reverse cholesterol transport"),
	array("idx" =>  3, "parent" => 1, "order" => 3, "name_en" => "Omics of lipids & atherosclerosis"),
	array("idx" =>  4, "parent" => 1, "order" => 4, "name_en" => "Lipid science: others"),

	array("idx" =>  5, "parent" => 2, "order" => 1, "name_en" => "Endothelial cell/Smooth muscle cell/macrophages in atherosclerosis"),
	array("idx" =>  6, "parent" => 2, "order" => 2, "name_en" => "Inflammation & immunity in atherosclerosis"),
	array("idx" =>  7, "parent" => 2, "order" => 3, "name_en" => "Noncoding RNA in lipid metabolism/atherosclerosis"),
	array("idx" =>  8, "parent" => 2, "order" => 4, "name_en" => "Platelet & thrombosis"),
	array("idx" =>  9, "parent" => 2, "order" => 5, "name_en" => "Vascular biology of arteries: others"),

	array("idx" => 10, "parent" => 3, "order" => 1, "name_en" => "Epidemiology of dyslipidemia & risk factors"),
	array("idx" => 11, "parent" => 3, "order" => 2, "name_en" => "Inhereted dyslipidemia"),
	array("idx" => 12, "parent" => 3, "order" => 3, "name_en" => "Diabetes, obesity & NASH"),
	array("idx" => 13, "parent" => 3, "order" => 4, "name_en" => "Genomics, epigenetics & population genetics"),
	array("idx" => 14, "parent" => 3, "order" => 5, "name_en" => "Risk factors: others"),

	array("idx" => 15, "parent" => 4, "order" => 1, "name_en" => "Epidemiology of ASCVD & biomarkers"),
	array("idx" => 16, "parent" => 4, "order" => 2, "name_en" => "Imaging of atherosclerosis"),
	array("idx" => 17, "parent" => 4, "order" => 3, "name_en" => "Lipid-lowering/anti-atherosclerosis therapies"),
	array("idx" => 18, "parent" => 4, "order" => 4, "name_en" => "Nutrition & nutraceuticals"),
	array("idx" => 19, "parent" => 4, "order" => 5, "name_en" => "Clinical vascular disease & prevention: others"),
	//array("idx"=> 20, "parent"=> 5, "order"=> 5, "name_en"=>"Others")
);
function get_topic1_option_text($topic_list, $selected)
{
	$topic_option_text = '<option value="" hidden>select</option>';
	foreach ($topic_list as $tp) {
		$topic_option_text .= '<option value="' . $tp['idx'] . '" ' . ($tp['idx'] == $selected ? 'selected' : '') . '>' . $tp['order'] . '. ' . $tp['name_en'] . '</option>';
	}
	return $topic_option_text;
}
function get_topic2_option_text($topic_list, $selected, $parent)
{
	$topic_option_text = '<option value="" hidden>select</option>';
	foreach ($topic_list as $tp) {
		$topic_option_text .= '<option value="' . $tp['idx'] . '" data-parent="' . $tp['parent'] . '" ' . ($tp['idx'] == $selected ? 'selected' : '') . ' ' . ($tp['parent'] == $parent ? '' : 'hidden') . '>' . $tp['parent'] . '.' . $tp['order'] . '. ' . $tp['name_en'] . '</option>';
	}
	return $topic_option_text;
}
