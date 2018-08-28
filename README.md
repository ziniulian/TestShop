# TestShop


已完成：
--------------------------------
- 登录页面
- 登录失败页面
- 多数量、多商品同时加入购物车 并跳转到购物车页面
- 解决通联支付不响应已付款的问题 （2016-7-11 测试有问题，但2016-7-12 测试无问题）
- 购物车页面
- update_cart 作为结算入口，修正完商品数量后，跳转至订单确认页面
- 收货地址选择页面
- 订单页面（默认运费到付、通联支付）
- 支付页面
- 订单回馈页面
- 用户中心 订单页面
- 用户中心 购物车页面
- 后台的权限管理
- 后台去除Ecshop LOGO
- 捐赠界面单独查询
- 注册页面
- 用户中心 收藏页面（clips）
- 删除后台管理页的升级提示
- 导入用户信息
- 用户中心 收货地址管理（transaction）
- 用户中心 用户信息 密码修改
- 树、苗自动补货和自动发货问题

*******************************************************************



计划：
--------------------------------
- 用户中心 个人捐赠记录查询
- 商品列表的购买按钮改为加入购物车
- 纯树、苗订单自动发货后，仍显示未发货问题
- 添加到购物车 时的错误处理
- 登录、注册时 js 没有执行功能
- 页首添加收藏夹图标
- 页首添加捐赠查询图标

- 用户信息对接问题

	（INSERT INTO `tsp_users`(`email`, `user_name`, `password`, `ec_salt`, `mobile_phone`, `true_name`) VALUES ('a@b', '1', '2542', '911', '222', '测试')）

- 用户中心 欢迎页
- 用户加入真实姓名 和 昵称
- 邮件忘记密码页面
- 问题忘记密码功能
- 自定义订单号
- 店铺公告内容从后台读取
- 树、苗 数据查询接口
- 树、苗 数据备份
- 使用LZR的收藏方法 ： /js/common.js/collect()
- 压缩 LZR
- 整理LZR用字符常量

*******************************************************************


开发明细：
-------------------------------------------------------------------

##### 2018-8-28 （ o3调试 ）：
	兼容PHP7.0以上的 mysqli_connect 函数
	更换文件夹位置
	首页跳转至店铺

##### 2018-8-28 （ 修改网站标题名 ）：
	修改网站标题名
	添加 myNam 路径
	删除缓存文件（但必须保留文件夹结构）
	设置 openshift3 相对应的数据库连接字及用户名密码

##### 2018-8-27 （ 添加GPL许可 ）：
	添加GPL许可
	添加数据库管理工具 phpMyAdmin
	重设数据库连接字、用户名、密码

*******************************************************************
