<?php

/**
 * donate
 * 捐赠页面 BY LZR
 * 2016-8-11
*/


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

	/* 如果页面没有被缓存则重新获得页面的内容 */
	assign_template();
	$position = assign_ur_here(0, "义务捐赠");
	$smarty->assign('page_title',      $position['title']);    // 页面标题
	$smarty->assign('ur_here',         $position['ur_here']);  // 当前位置
	$smarty->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-c$cat_id.xml" : 'feed.php?cat=' . $cat_id); // RSS URL

if ($_SESSION['user_id'] > 0) {
	$smarty->display('donateDo.dwt', $cache_id);
} else {
	ecs_header("Location:./user.php\n");
	exit;
}

?>