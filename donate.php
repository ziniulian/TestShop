<?php

/**
 * donate
 * 查询捐赠记录 BY LZR
 * 2016-7-17
*/


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/* 清除缓存 */
clear_cache_files();

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

/* 获得当前页码 */
$page   = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

/* 获得页面的缓存ID */
$cache_id = sprintf('%X', crc32($page . '-' . $_CFG['lang']));

if (!$smarty->is_cached('donate.dwt', $cache_id))
{
	/* 如果页面没有被缓存则重新获得页面的内容 */
	assign_template();
	$position = assign_ur_here(0, "捐赠记录");
	$smarty->assign('page_title',      $position['title']);    // 页面标题
	$smarty->assign('ur_here',         $position['ur_here']);  // 当前位置
	$smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-c$cat_id.xml" : 'feed.php?cat=' . $cat_id); // RSS URL

	/* ------------ 分页设置 - S --------------------------- */
	$size = 20;
	$count = get_donate_count();
	$pages = ($count > 0) ? ceil($count / $size) : 1;
	if ($page > $pages) {
		$page = $pages;
	}
	/* ------------ 分页设置 - E --------------------------- */

	if ($count > 0) {
		$smarty->assign('donate_list', get_donate_list($page, $size));
	}

	assign_pager('donate', 0, $count, $size, '', '', $page);	// 分页
	assign_dynamic('donate');
}

$smarty->display('donate.dwt', $cache_id);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

// 获取捐赠记录总数
function get_donate_count () {

	/*	---------- 测试SQL
		SELECT COUNT(DISTINCT og.order_id) AS con FROM `tsp_order_goods` AS og WHERE og.goods_number=og.send_number AND og.goods_id IN (194, 195)
	*/

	$where  = "og.goods_number=og.send_number AND og.goods_id IN (194, 195)";
	return $GLOBALS['db']->getOne("SELECT COUNT(DISTINCT og.order_id) AS con FROM " . $GLOBALS["ecs"]->table("order_goods") . " AS og WHERE $where");
}

// 获取捐赠记录明细
function get_donate_list ($page = 1, $size = 20) {

	/*	---------- 测试SQL
		SELECT gog.orid AS orid, oi.order_sn AS sn, u.user_name AS nam, oi.pay_time AS tim, IF(ogt.tnm IS NULL,0,ogt.tnm) AS tnm, IF(ogs.snm IS NULL,0,ogs.snm) AS snm FROM ((((
		(SELECT DISTINCT og.order_id AS orid FROM `tsp_order_goods` AS og WHERE og.goods_number=og.send_number AND og.goods_id in (194, 195) ORDER BY og.order_id DESC LIMIT 0,20) AS gog
		LEFT JOIN
		(SELECT og.order_id AS orid, og.send_number AS tnm FROM `tsp_order_goods` AS og WHERE og.goods_id = 194) AS ogt
		ON gog.orid = ogt.orid)
		LEFT JOIN
		(SELECT og.order_id AS orid, og.send_number AS snm FROM `tsp_order_goods` AS og WHERE og.goods_id = 195) AS ogs
		ON gog.orid = ogs.orid)
		LEFT JOIN
		`tsp_order_info` AS oi
		ON gog.orid = oi.order_id)
		LEFT JOIN
		`tsp_users` AS u
		ON oi.user_id = u.user_id)
	*/

	$sql = "SELECT gog.orid AS orid, oi.order_sn AS sn, u.user_name AS nam, oi.pay_time AS tim, IF(ogt.tnm IS NULL,0,ogt.tnm) AS tnm, IF(ogs.snm IS NULL,0,ogs.snm) AS snm FROM (((( " .
		"(SELECT DISTINCT og.order_id AS orid FROM " . $GLOBALS["ecs"]->table("order_goods") . " AS og WHERE og.goods_number=og.send_number AND og.goods_id in (194, 195) ORDER BY og.order_id DESC " .
			"LIMIT " . ($page - 1) * $size . "," . $size . ") AS gog " .	// 分页
		"LEFT JOIN " .
		"(SELECT og.order_id AS orid, og.send_number AS tnm FROM " . $GLOBALS["ecs"]->table("order_goods") . " AS og WHERE og.goods_id = 194) AS ogt " .
		"ON gog.orid = ogt.orid) " .
		"LEFT JOIN " .
		"(SELECT og.order_id AS orid, og.send_number AS snm FROM " . $GLOBALS["ecs"]->table("order_goods") . " AS og WHERE og.goods_id = 195) AS ogs " .
		"ON gog.orid = ogs.orid) " .
		"LEFT JOIN " .
		$GLOBALS["ecs"]->table("order_info") . " AS oi " .
		"ON gog.orid = oi.order_id) " .
		"LEFT JOIN " .
		$GLOBALS["ecs"]->table("users") . " AS u " .
		"ON oi.user_id = u.user_id)";

	$res = $GLOBALS['db']->GetAll($sql);

	$arr = array();
	foreach ($res AS $row) {
		$arr[$row["orid"]]["sn"] = $row["sn"];
		$arr[$row["orid"]]["nam"] = $row["nam"];
		$arr[$row["orid"]]["tim"] = local_date('Y-m-d H:i:s', $row['tim']);		// 时间戳转换
		$arr[$row["orid"]]["tnm"] = $row["tnm"];
		$arr[$row["orid"]]["snm"] = $row["snm"];
		$arr[$row["orid"]]["total"] = $row["tnm"] * 15 + $row["snm"] * 2.5;		// 捐赠金额计算
	}

	return $arr;
}

?>