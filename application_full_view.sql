select `applications`.`id` AS `id`,
    `applications`.`data`->>'$.enterprise.name' AS `name`,
    `status_join`.`name` AS `status`,
    `constitution_type_join`.`name` AS `constitution_type`,
    `applications`.`data`->>'$.enterprise.area_type' AS `area_type`,
    `enterprise_district_join`.`name` AS `enterprise_district`,
    `enterprise_constituency_join`.`name` AS `enterprise_constituency`,
    `enterprise_tehsil_join`.`name` AS `enterprise_tehsil`,
    `enterprise_block_join`.`name` AS `enterprise_block_town`,
    `enterprise_panchayat_join`.`name` AS `enterprise_panchayat_ward`,
    `applications`.`data`->>'$.enterprise.address' AS `enterprise_address`,
    `applications`.`data`->>'$.enterprise.pincode' AS `enterprise_pincode`,
    `activity_type_join`.`name` AS `activity_type`,
    `activity_join`.`name` AS `activity`,
    CASE WHEN `applications`.`data`->>'$.enterprise.activity_type_id' = 201
        THEN `applications`.`data`->>'$.enterprise.products'
        ELSE `applications`.`data`->>'$.enterprise.activity_details'
    END AS `activity_detail`,
    `applications`.`data`->>'$.enterprise.employment' AS `proposed_employment`,

    `applications`.`data`->>'$.owner.name' AS `applicant`,
    `applications`.`data`->>'$.owner.mobile' AS `mobile`,
    `applications`.`data`->>'$.owner.email' AS `email`,
    CONCAT(`applications`.`data`->>'$.owner.guardian_prefix', `applications`.`data`->>'$.owner.guardian') as `guardian`,
    `owner_district_join`.`name` AS `owner_district`,
    `owner_constituency_join`.`name` AS `owner_constituency`,
    `owner_tehsil_join`.`name` AS `owner_tehsil`,
    `owner_block_join`.`name` AS `owner_block_town`,
    `owner_panchayat_join`.`name` AS `owner_panchayat_ward`,
    `applications`.`data`->>'$.owner.address' AS `owner_address`,
    `applications`.`data`->>'$.owner.pincode' AS `owner_pincode`,
    `applications`.`data`->>'$.owner.gender' AS `gender`,
    `applications`.`data`->>'$.owner.birth_date' AS `birth_date`,
    `applications`.`data`->>'$.owner.aadhaar' AS `aadhaar`,
    `applications`.`data`->>'$.owner.pan' AS `pan`,
    `applications`.`data`->>'$.owner.marital_status' AS `marital_status`,
    `applications`.`data`->>'$.owner.spouse_aadhaar' AS `spouse_aadhaar`,
    `applications`.`data`->>'$.owner.is_specially_abled' AS `specially_abled`,
    `applications`.`data`->>'$.owner.belongs_to_minority' AS `minority`,
    `social_category_join`.`name` AS `social_category`,

    `applications`.`data`->>'$.cost.land_status' AS `land_status`,
    `applications`.`data`->>'$.cost.land_cost' AS `land_cost`,
    `applications`.`data`->>'$.cost.building_status' AS `building_status`,
    `applications`.`data`->>'$.cost.building_cost' AS `building_cost`,
    `applications`.`data`->>'$.cost.building_area' AS `building_area`,
    `applications`.`data`->>'$.cost.assets_cost' AS `assets_cost`,
    `applications`.`data`->>'$.cost.assets_detail' AS `assets_detail`,
    `applications`.`data`->>'$.cost.machinery_cost' AS `machinery_cost`,
    `applications`.`data`->>'$.cost.machinery_detail' AS `machinery_detail`,
    `applications`.`data`->>'$.cost.working_capital' AS `working_capital`,

    `applications`.`data`->>'$.finance.own_contribution' AS `own_contribution_percentage`,

    `bank_join`.`name` AS `bank`,
    `bank_branch_join`.`name` AS `bank_branch`,
    `bank_branch_join`.`ifsc` AS `bank_branch_ifsc`,
    `bank_branch_join`.`address` AS `bank_branch_address`,

    `bank_join`.`id` AS `bank_id`,
    `bank_branch_join`.`id` AS `bank_branch_id`,
    `enterprise_district_join`.`id` AS `district_id`,
    `status_join`.`id` AS `status_id`,
    CASE WHEN `applications`.`updated_at` IS NULL
        THEN `applications`.`created_at`
        ELSE `applications`.`updated_at`
    END AS `updated_at`

FROM `applications`
LEFT JOIN `regions` `enterprise_district_join` ON `applications`.`data`->>'$.enterprise.district_id' = `enterprise_district_join`.`id`
LEFT JOIN `regions` `enterprise_constituency_join` ON `applications`.`data`->>'$.enterprise.constituency_id' = `enterprise_constituency_join`.`id`
LEFT JOIN `regions` `enterprise_tehsil_join` ON `applications`.`data`->>'$.enterprise.tehsil_id' = `enterprise_tehsil_join`.`id`
LEFT JOIN `regions` `enterprise_block_join` ON `applications`.`data`->>'$.enterprise.block_id' = `enterprise_block_join`.`id`
LEFT JOIN `regions` `enterprise_panchayat_join` ON `applications`.`data`->>'$.enterprise.panchayat_id' = `enterprise_panchayat_join`.`id`
LEFT JOIN `enums` `activity_type_join` ON `applications`.`data`->>'$.enterprise.activity_type_id' = `activity_type_join`.`id`
LEFT JOIN `activities` `activity_join` ON `applications`.`data`->>'$.enterprise.activity_id' = `activity_join`.`id`
LEFT JOIN `enums` `constitution_type_join` ON `applications`.`data`->>'$.enterprise.constitution_type_id' = `constitution_type_join`.`id`
LEFT JOIN `regions` `owner_district_join` ON `applications`.`data`->>'$.owner.district_id' = `owner_district_join`.`id`
LEFT JOIN `regions` `owner_constituency_join` ON `applications`.`data`->>'$.owner.constituency_id' = `owner_constituency_join`.`id`
LEFT JOIN `regions` `owner_tehsil_join` ON `applications`.`data`->>'$.owner.tehsil_id' = `owner_tehsil_join`.`id`
LEFT JOIN `regions` `owner_block_join` ON `applications`.`data`->>'$.owner.block_id' = `owner_block_join`.`id`
LEFT JOIN `regions` `owner_panchayat_join` ON `applications`.`data`->>'$.owner.panchayat_id' = `owner_panchayat_join`.`id`
LEFT JOIN `enums` `social_category_join` ON `applications`.`data`->>'$.owner.social_category_id' = `social_category_join`.`id`
LEFT JOIN `bank_branches` `bank_branch_join` ON `applications`.`data`->>'$.finance.bank_branch_id' = `bank_branch_join`.`id`
LEFT JOIN `banks` `bank_join` ON `bank_branch_join`.`bank_id` = `bank_join`.`id`
LEFT JOIN `enums` `status_join` ON `applications`.`status_id` = `status_join`.`id`


WHERE `applications`.`id` > 25000
ORDER BY `applications`.`id` DESC
LIMIT 0, 5