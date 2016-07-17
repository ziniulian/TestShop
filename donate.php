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
	if ($page > $pages)
	{
		$page = $pages;
	}
	/* ------------ 分页设置 - E --------------------------- */

	$smarty->assign('donate_list',    get_cat_articles($page, $size));

	assign_pager('donate', 0, $count, $size, '', '', $page);	// 分页
	assign_dynamic('donate');
}

$smarty->display('donate.dwt', $cache_id);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

// 获取捐赠记录总数
function get_donate_count () {
	$where  = "og.goods_number=og.send_number AND og.goods_id IN (194, 195) GROUP BY og.order_id";
	return $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS["ecs"]->table("order_goods") . " AS og WHERE $where");
}

// 获取捐赠记录明细
function get_donate_list ($page = 1, $size = 20) {
	return array("test" => "Test~!!");
}

?>