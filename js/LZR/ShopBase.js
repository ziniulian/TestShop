(function (root, factory) {
	if (typeof exports === "object") {
		module.exports = factory();
	} else if (typeof define === "function" && define.amd) {
		define([], factory);
	} else {
		root.HelloWorld = factory;
	}
}(this, function () {
var LZR = { load: function(){}, loadAnnex: function(){} };
// 单件对象集合
LZR.singletons = {
	nodejsTools:{}
};	/*as:Object*/

// 获得一个ajax对象
LZR.getAjax = function ()/*as:Object*/ {
	var xmlHttp = null;
	try{
		xmlHttp = new XMLHttpRequest();
	} catch (MSIEx) {
		var activeX = [ "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP", "Microsoft.XMLHTTP" ];
		for (var i=0; i < activeX.length; i++) {
			try {
				xmlHttp = new ActiveXObject( activeX[i] );
			} catch (e) {}
		}
	}
	return xmlHttp;
};

// 父类构造器
LZR.initSuper = function (self/*as:Object*/, obj/*as:Object*/) {
	var s;
	if (obj && obj.lzrGeneralization_) {
		s = obj.lzrGeneralization_.prototype.super_;
	} else {
		s = self.super_;
	}

	for (var i=0; i<s.length; i++) {
		s[i].call(self, {lzrGeneralization_: s[i]});
	}
};

// 构造属性
LZR.setObj = function (obj/*as:Object*/, pro/*as:Object*/) {
	for (var s in pro) {
		var t = obj[s];
		if (t !== undefined) {
			var value = pro[s];
			switch (this.getClassName (t)) {
				case "LZR.Base.Val":
				case "LZR.Base.Val.Ctrl":
					switch (this.getClassName(value)) {
						case "LZR.Base.Val":
						case "LZR.Base.Val.Ctrl":
							obj[s] = value;
							break;
						default:
							// 调用值控制器赋值
							t.set (value, false);
							break;
					}
					break;
				default:
					// 普通赋值
					obj[s] = value;
					break;
			}
		}
	}
};

// 获取一个单件对象
LZR.getSingleton = function (cls/*as:fun*/, obj/*as:Object*/, nodejsClassName/*as:string*/)/*as:Object*/ {
	var o;
	if (nodejsClassName) {
		o = LZR.singletons.nodejsTools[nodejsClassName];
		if (!o) {
			o = require(nodejsClassName);
			LZR.singletons.nodejsTools[nodejsClassName] = o;
		}
	} else {
		o = LZR.singletons[cls.prototype.className_];
		if (!o) {
			o = new cls(obj);
			LZR.singletons[o.className_] = o;
		}
	}
	return o;
};

// 复制一个对象
LZR.clone = function (src/*as:Object*/, tag/*as:Object*/, objDep/*as:boolean*/, aryDep/*as:boolean*/)/*as:Object*/ {
	var s = this.getClassName(src);
	switch ( s ) {
		case "number":
		case "string":
		case "boolean":
		case "function":
		case "null":
		case "undefined":
			tag = src;
			break;
		case "Date":
			tag = new Date(src.valueOf());
			break;
		case "Array":
			// 普通数组克隆
			if (tag === null || tag === undefined) {
				tag = [];
			}
			for (s in src) {
				if (aryDep) {
					tag[s] = this.clone (src[s], tag[s], objDep, aryDep);
				} else {
					tag[s] = src[s];
				}
			}
			break;
		default:
			if (s.indexOf("LZR.") === 0 && src !== src.constructor.prototype) {
				// new 对象克隆
				if (src.clone) {
					// 有特殊克隆方法的对象克隆
					tag = src.clone(tag);
				} else {
					var p = src.constructor.prototype;
					var obj = {};
					for (s in src) {
						if (p[s] === undefined) {
							if (tag) {
								// 深度克隆
								if (tag[s]) {
									// 不需要深度克隆的特定属性
									obj[s] = tag[s];
								} else {
									obj[s] = this.clone(src[s], true);
								}
							} else {
								obj[s] = src[s];
							}
						}
					}
					tag = new src.constructor (obj);
				}
			} else {
				// 普通对象克隆
				if (tag === null || tag === undefined) {
					tag = {};
				}
				for (s in src) {
					if (objDep) {
						tag[s] = this.clone (src[s], tag[s], objDep, aryDep);
					} else {
						tag[s] = src[s];
					}
				}
			}
			break;
	}
	return tag;
};

// 获取类名
LZR.getClassName = function (obj/*as:Object*/)/*as:string*/ {
	if (null === obj)  return "null";

	var type = typeof obj;
	if (type != "object")  return type;

	// 自定义类属性
	type = obj.className_;
	if (type) {
		// if (type.indexOf("LZR.") === 0) {
			return type;
		// }
	}

	// Dom类型
	var c = Object.prototype.toString.apply ( obj );
	c = c.substring( 8, c.length-1 );

	// 其它类型
	if ( c == "Object" ) {
		var con = obj.constructor;
		if (con == Object) {
			return c;
		}

		if (obj.prototype && "classname" in obj.prototype.constructor && typeof obj.prototype.constructor.classname == "string") {
			return con.prototype.classname;
		}
	}

	return c;
};

// 删除一个对象的属性
LZR.del = function (obj/*as:Object*/, proName/*as:string*/) {
	var note;
	delete obj[proName];
};


/*************************************************
作者：子牛连
类名：HTML
说明：
创建日期：11-三月-2016 13:43:56
版本号：1.0
*************************************************/

LZR.load([
	"LZR"
], "LZR.HTML");
LZR.HTML = function (obj) {
	if (obj && obj.lzrGeneralization_) {
		obj.lzrGeneralization_.prototype.init_.call(this);
	} else {
		this.init_(obj);
	}
};
LZR.HTML.prototype.className_ = "LZR.HTML";
LZR.HTML.prototype.version_ = "1.0";

LZR.load(null, "LZR.HTML");

// LOG容器
LZR.HTML.logger = null;	/*as:Object*/

// 构造器
LZR.HTML.prototype.init_ = function (obj/*as:Object*/) {
	if (obj) {
		LZR.setObj (this, obj);
		this.hdObj_(obj);
	}
};

// 对构造参数的特殊处理
LZR.HTML.prototype.hdObj_ = function (obj/*as:Object*/) {
	
};

// 创建LOG
LZR.HTML.createLog = function () {
	if (!this.logger) {
		this.logger = document.getElementById("LZR_LOG");
		if (!this.logger) {
			this.logger = document.createElement( "pre" );
			this.logger.id = "LZR_LOG";
			if (document.body.children.length) {
				document.body.insertBefore(this.logger, document.body.children[0]);
			} else {
				document.body.appendChild(this.logger);
			}
		}
	}
};

// 覆盖LOG
LZR.HTML.log = function (memo/*as:string*/) {
	this.createLog();
	this.logger.innerHTML = memo;
};

// 追加LOG
LZR.HTML.alog = function (memo/*as:string*/) {
	this.createLog();
	this.logger.innerHTML += memo;
	this.logger.innerHTML += "<br>";
};


/*************************************************
作者：子牛连
类名：Base
说明：基础
创建日期：11-三月-2016 13:58:41
版本号：1.0
*************************************************/

LZR.load([
	"LZR.HTML"
], "LZR.HTML.Base");
LZR.HTML.Base = function (obj) {
	if (obj && obj.lzrGeneralization_) {
		obj.lzrGeneralization_.prototype.init_.call(this);
	} else {
		this.init_(obj);
	}
};
LZR.HTML.Base.prototype.className_ = "LZR.HTML.Base";
LZR.HTML.Base.prototype.version_ = "1.0";

LZR.load(null, "LZR.HTML.Base");

// 构造器
LZR.HTML.Base.prototype.init_ = function (obj/*as:Object*/) {
	if (obj) {
		LZR.setObj (this, obj);
		this.hdObj_(obj);
	}
};

// 对构造参数的特殊处理
LZR.HTML.Base.prototype.hdObj_ = function (obj/*as:Object*/) {
	
};


/*************************************************
作者：子牛连
类名：Base
说明：基础
创建日期：11-三月-2016 13:45:34
版本号：1.0
*************************************************/

LZR.load([
	"LZR"
], "LZR.Base");
LZR.Base = function (obj) {
	if (obj && obj.lzrGeneralization_) {
		obj.lzrGeneralization_.prototype.init_.call(this);
	} else {
		this.init_(obj);
	}
};
LZR.Base.prototype.className_ = "LZR.Base";
LZR.Base.prototype.version_ = "1.0";

LZR.load(null, "LZR.Base");

// 构造器
LZR.Base.prototype.init_ = function (obj/*as:Object*/) {
	if (obj) {
		LZR.setObj (this, obj);
		this.hdObj_(obj);
	}
};

// 对构造参数的特殊处理
LZR.Base.prototype.hdObj_ = function (obj/*as:Object*/) {
	
};

/*************************************************
作者：子牛连
类名：Json
说明：
创建日期：06-五月-2016 14:15:47
版本号：1.0
*************************************************/

LZR.loadAnnex({
	JSON: "/Lib/Util/JSON.js"
});

LZR.load([
	"LZR.Base"
], "LZR.Base.Json");
LZR.Base.Json = function (obj) {
	// 映射的源 JSON 对象
	this.src = JSON;	/*as:Object*/

	if (obj && obj.lzrGeneralization_) {
		obj.lzrGeneralization_.prototype.init_.call(this);
	} else {
		this.init_(obj);
	}
};
LZR.Base.Json.prototype.className_ = "LZR.Base.Json";
LZR.Base.Json.prototype.version_ = "1.0";

LZR.load(null, "LZR.Base.Json");

// 构造器
LZR.Base.Json.prototype.init_ = function (obj/*as:Object*/) {
	if (obj) {
		LZR.setObj (this, obj);
		this.hdObj_(obj);
	}
};

// 对构造参数的特殊处理
LZR.Base.Json.prototype.hdObj_ = function (obj/*as:Object*/) {
	
};

// 将对象转换成 json 文本
LZR.Base.Json.prototype.toJson = function (obj/*as:Object*/)/*as:string*/ {
	return this.src.stringify(obj);
};

// 将字符串转换成对象
LZR.Base.Json.prototype.toObj = function (json/*as:string*/)/*as:Object*/ {
	return this.src.parse(json);
};


/*************************************************
作者：子牛连
类名：Util
说明：工具包
创建日期：11-三月-2016 13:40:35
版本号：1.0
*************************************************/

LZR.load([
	"LZR"
], "LZR.Util");
LZR.Util = function (obj) {
	if (obj && obj.lzrGeneralization_) {
		obj.lzrGeneralization_.prototype.init_.call(this);
	} else {
		this.init_(obj);
	}
};
LZR.Util.prototype.className_ = "LZR.Util";
LZR.Util.prototype.version_ = "1.0";

LZR.load(null, "LZR.Util");

// 构造器
LZR.Util.prototype.init_ = function (obj/*as:Object*/) {
	if (obj) {
		LZR.setObj (this, obj);
		this.hdObj_(obj);
	}
};

// 对构造参数的特殊处理
LZR.Util.prototype.hdObj_ = function (obj/*as:Object*/) {
	
};

// 闭包调用
LZR.Util.prototype.bind = function (self/*as:Object*/, fun/*as:fun*/, args/*as:___*/)/*as:fun*/ {
	var arg = Array.prototype.slice.call(arguments, 2);
	return function () {
		var i, args = [];
		for ( i=0; i<arg.length; i++ ) {
			args.push ( arg[i] );
		}
		for ( i=0; i<arguments.length; i++ ) {
			args.push ( arguments[i] );
		}
		return fun.apply ( self, args );
	};
};

// 调用父类方法
LZR.Util.prototype.supCall = function (self/*as:Object*/, idx/*as:int*/, funam/*as:string*/, args/*as:___*/)/*as:Object*/ {
	var arg = Array.prototype.slice.call(arguments, 3);

	// 检查最后一个参数值
// console.log (arguments);
	var last = arguments.callee.caller.arguments;
// console.log (last);
	last = last[last.length - 1];
// console.log (last);

	// 确定父类
	var s;
	if (last && last.lzrGeneralization_) {
// console.log (last.lzrGeneralization_.prototype.className_);
		s = last.lzrGeneralization_.prototype.super_;
	} else {
		s = self.super_;
	}

	var f = s[idx].prototype[funam];		// 父类函数
	var n = f.length;		// 函数的形参个数

	// 填充不完整的参数
	while (arg.length < n) {
// console.log (arg.length + " : " + n);
		arg.push(undefined);
	}

	// 填充特殊的继承参数
	arg.push({
		lzrGeneralization_: s[idx]
	});
// console.log (arg);

	// 执行父类函数
	return f.apply ( self, arg );
};

// 判断一个对象的属性是否存在
LZR.Util.prototype.exist = function (obj/*as:Object*/, pro/*as:string*/)/*as:Object*/ {
	var ps = pro.split(".");
	for (var i = 0; i<ps.length; i++) {
		if (undefined === obj || null === obj) {
			return undefined;
		}
		obj = obj[ps[i]];
	}
	return obj;
};

// 休眠函数
LZR.Util.prototype.sleep = function (numberMillis/*as:int*/) {
	var now = new Date();
	var exitTime = now.getTime() + numberMillis;
	while (true) {
		now = new Date();
		if (now.getTime() > exitTime) {
			return;
		}
	}
};


/*************************************************
作者：子牛连
类名：Str
说明：字符串
创建日期：11-三月-2016 14:24:18
版本号：1.0
*************************************************/

LZR.load([
	"LZR.Base"
], "LZR.Base.Str");
LZR.Base.Str = function (obj) {
	if (obj && obj.lzrGeneralization_) {
		obj.lzrGeneralization_.prototype.init_.call(this);
	} else {
		this.init_(obj);
	}
};
LZR.Base.Str.prototype.className_ = "LZR.Base.Str";
LZR.Base.Str.prototype.version_ = "1.0";

LZR.load(null, "LZR.Base.Str");

// 构造器
LZR.Base.Str.prototype.init_ = function (obj/*as:Object*/) {
	if (obj) {
		LZR.setObj (this, obj);
		this.hdObj_(obj);
	}
};

// 对构造参数的特殊处理
LZR.Base.Str.prototype.hdObj_ = function (obj/*as:Object*/) {
	
};

// 转固定宽度的字符
LZR.Base.Str.prototype.format = function (s/*as:string*/, width/*as:int*/, subs/*as:string*/) {
	s += "";
	var n = s.length;
	if (width > n) {
		n = width - n;
		for (var i=0; i<n; i++) {
			s = subs + s;
		}
	}
	return s;
};

// 判断字符串是否以start字串开头
LZR.Base.Str.prototype.startWith = function (s/*as:string*/, start/*as:string*/) {
	var reg=new RegExp("^"+start);
	return reg.test(s);
};

// 判断字符串是否以end字串结束
LZR.Base.Str.prototype.endWith = function (s/*as:string*/, end/*as:string*/) {
	var reg=new RegExp(end+"$");
	return reg.test(s);
};


/*************************************************
作者：子牛连
类名：CallBacks
说明：回调函数集合
创建日期：11-三月-2016 14:27:33
版本号：1.0
*************************************************/

LZR.load([
	"LZR.Util",
	"LZR.Base",
	"LZR.Base.Str",
	"LZR.Base.CallBacks.CallBack"
], "LZR.Base.CallBacks");
LZR.Base.CallBacks = function (obj) {
	// 是否触发事件
	this.enableEvent = true;	/*as:boolean*/

	// 事件自动恢复
	this.autoEvent = true;	/*as:boolean*/

	// 调用对象
	this.obj = this;	/*as:Object*/

	// 回调函数个数
	this.count = 0;	/*as:int*/

	// 自身回调
	this.exe = null;	/*as:fun*/

	// 唯一ID
	this.id = 0;	/*as:int*/

	// 回调函数集合
	this.funs/*m*/ = {};	/*as:LZR.Base.CallBacks.CallBack*/

	// 通用工具
	this.utLzr/*m*/ = LZR.getSingleton(LZR.Util);	/*as:LZR.Util*/

	if (obj && obj.lzrGeneralization_) {
		obj.lzrGeneralization_.prototype.init_.call(this);
	} else {
		this.init_(obj);
	}
};
LZR.Base.CallBacks.prototype.className_ = "LZR.Base.CallBacks";
LZR.Base.CallBacks.prototype.version_ = "1.0";

LZR.load(null, "LZR.Base.CallBacks");

// 构造器
LZR.Base.CallBacks.prototype.init_ = function (obj/*as:Object*/) {
	this.exe = this.utLzr.bind (this, this.execute);
	if (obj) {
		LZR.setObj (this, obj);
		this.hdObj_(obj);
	}
};

// 对构造参数的特殊处理
LZR.Base.CallBacks.prototype.hdObj_ = function (obj/*as:Object*/) {
	
};

// 添加回调函数
LZR.Base.CallBacks.prototype.add = function (fun/*as:fun*/, name/*as:LZR.Base.Str*/, self/*as:boolean*/)/*as:string*/ {
	if (name === undefined || name === null) {
		name = this.id;
	}
	this.id ++;
	if (this.funs[name] === undefined) {
		this.count ++;
	}
	var o = {
		name: name,
		fun: fun
	};
	if (self === true) {
		o.selfInfo = true;
	}
	this.funs[name] = new LZR.Base.CallBacks.CallBack (o);
	return name;
};

// 删除回调函数
LZR.Base.CallBacks.prototype.del = function (name/*as:LZR.Base.Str*/)/*as:LZR.Base.CallBacks.CallBack*/ {
	var r = this.funs[name];
	if (r !== undefined) {
		LZR.del(this.funs, name);
		this.count --;
	}
	return r;
};

// 执行回调函数
LZR.Base.CallBacks.prototype.execute = function ()/*as:boolean*/ {
	var b = true;	// 回调函数正常执行则返回 true，否则返回 false
	if (this.enableEvent) {
		for (var s in this.funs) {
			switch (s) {
				case "length":
					break;
				default:
					if (this.funs[s].enableEvent) {
						var arg;
						if (this.funs[s].selfInfo) {
							arg = Array.prototype.slice.call ( arguments );
							arg.push({
								id: "selfInfo",
								root: this,
								parent: this.funs,
								self: this.funs[s],
								nam: this.funs[s].name
							});
						} else {
							arg = arguments;
						}
						if ( (this.funs[s].fun.apply ( this.obj, arg )) === false ) {
							b = false;
						}
					} else {
						this.funs[s].enableEvent = this.funs[s].autoEvent;
					}
					break;
			}
		}
	} else {
		this.enableEvent = this.autoEvent;
	}
	return b;
};


/*************************************************
作者：子牛连
类名：CallBack
说明：回调函数
创建日期：11-三月-2016 14:29:39
版本号：1.0
*************************************************/

LZR.load([
	"LZR.Base.CallBacks"
], "LZR.Base.CallBacks.CallBack");
LZR.Base.CallBacks.CallBack = function (obj) {
	// 名字
	this.name = "";	/*as:string*/

	// 是否触发事件
	this.enableEvent = true;	/*as:boolean*/

	// 事件自动恢复
	this.autoEvent = true;	/*as:boolean*/

	// 回调参数中是否添加自我的相关信息
	this.selfInfo = false;	/*as:boolean*/

	// 函数
	this.fun = null;	/*as:fun*/

	if (obj && obj.lzrGeneralization_) {
		obj.lzrGeneralization_.prototype.init_.call(this);
	} else {
		this.init_(obj);
	}
};
LZR.Base.CallBacks.CallBack.prototype.className_ = "LZR.Base.CallBacks.CallBack";
LZR.Base.CallBacks.CallBack.prototype.version_ = "1.0";

LZR.load(null, "LZR.Base.CallBacks.CallBack");

// 构造器
LZR.Base.CallBacks.CallBack.prototype.init_ = function (obj/*as:Object*/) {
	if (obj) {
		LZR.setObj (this, obj);
		this.hdObj_(obj);
	}
};

// 对构造参数的特殊处理
LZR.Base.CallBacks.CallBack.prototype.hdObj_ = function (obj/*as:Object*/) {
	
};


/*************************************************
作者：子牛连
类名：InfEvt
说明：事件集接口
创建日期：17-三月-2016 13:33:38
版本号：1.1
*************************************************/

LZR.load([
	"LZR.Base"
], "LZR.Base.InfEvt");
LZR.Base.InfEvt = function (obj) {
	// 事件集
	this.evt = {};	/*as:Object*/
};
LZR.Base.InfEvt.prototype.className_ = "LZR.Base.InfEvt";
LZR.Base.InfEvt.prototype.version_ = "1.0";

LZR.load(null, "LZR.Base.InfEvt");

// 设置事件调用对象
LZR.Base.InfEvt.prototype.setEventObj = function (obj/*as:Object*/) {
	this.setEventObjRecursion(this.evt, obj);
};

// 递归设置调用对象
LZR.Base.InfEvt.prototype.setEventObjRecursion = function (o/*as:Object*/, obj/*as:Object*/) {
	for (var s in o) {
		if (o.className_ === "LZR.Base.CallBacks") {
			o[s].obj = obj;
		} else {
			this.setEventObjRecursion(o[s], obj);
		}
	}
};


/*************************************************
作者：子牛连
类名：Ajax
说明：
创建日期：17-三月-2016 14:09:15
版本号：1.0
*************************************************/

LZR.load([
	"LZR.HTML.Base",
	"LZR.Base.Json",
	"LZR.Util",
	"LZR.Base.CallBacks",
	"LZR.Base.InfEvt"
], "LZR.HTML.Base.Ajax");
LZR.HTML.Base.Ajax = function (obj) /*interfaces:LZR.Base.InfEvt*/ {
	LZR.Base.InfEvt.call(this);

	// AJAX对象
	this.ajax = LZR.getAjax();	/*as:Object*/

	// Json转换工具
	this.utJson/*m*/ = LZR.getSingleton(LZR.Base.Json);	/*as:LZR.Base.Json*/

	// 常用工具
	this.utLzr/*m*/ = LZR.getSingleton(LZR.Util);	/*as:LZR.Util*/

	// Ajax应答
	this.evt.rsp/*m*/ = new LZR.Base.CallBacks();	/*as:LZR.Base.CallBacks*/

	if (obj && obj.lzrGeneralization_) {
		obj.lzrGeneralization_.prototype.init_.call(this);
	} else {
		this.init_(obj);
	}
};
LZR.HTML.Base.Ajax.prototype = LZR.clone (LZR.Base.InfEvt.prototype, LZR.HTML.Base.Ajax.prototype);
LZR.HTML.Base.Ajax.prototype.className_ = "LZR.HTML.Base.Ajax";
LZR.HTML.Base.Ajax.prototype.version_ = "1.0";

LZR.load(null, "LZR.HTML.Base.Ajax");

// 构造器
LZR.HTML.Base.Ajax.prototype.init_ = function (obj/*as:Object*/) {
	if (obj) {
		LZR.setObj (this, obj);
		this.hdObj_(obj);
	}
};

// 对构造参数的特殊处理
LZR.HTML.Base.Ajax.prototype.hdObj_ = function (obj/*as:Object*/) {
	
};

// 发送POST请求
LZR.HTML.Base.Ajax.prototype.post = function (url/*as:string*/, msg/*as:Object*/, msgType/*as:string*/, isAsyn/*as:boolean*/, isGet/*as:boolean*/)/*as:string*/ {
	if ( isAsyn ) {
		this.ajax.onreadystatechange = this.utLzr.bind ( this,  this.onRsp );
		isAsyn = true;
	} else {
		isAsyn = false;
	}

	// 处理 msg
	if ( msg && typeof msg == "object" ) {
		var ms="";
		for (var n in msg) {
			if ("" !== ms) {
				ms += "&";
			}
			ms += n;
			ms += "=";
			ms += this.utJson.toJson ( msg[n] );
		}
		msg = ms;
	}

	// 发送请求
	try {
		if ( isGet ) {
			this.ajax.open("GET", url, isAsyn);
		} else {
			this.ajax.open("POST", url, isAsyn);
			if ( !msgType ) {
				msgType = "application/x-www-form-urlencoded; charset=utf-8";
			}
			this.ajax.setRequestHeader("Content-Type", msgType);
		}
		this.ajax.send(msg);
	} catch ( e ) {
		if (isAsyn) {
			// this.evt.rsp.execute (null);
		}
		return null;
	}

	// 同步回调
	var s =  null;
	if ( !isAsyn && this.ajax.readyState == 4 ) {
		s = this.ajax.responseText;
		// this.ajax.close();
	}
	return s;
};

// 发送GET请求
LZR.HTML.Base.Ajax.prototype.get = function (url/*as:string*/, isAsyn/*as:boolean*/)/*as:string*/ {
	return this.post ( url, null, null, isAsyn, true );
};

// 异步POST请求
LZR.HTML.Base.Ajax.prototype.asynPost = function (url/*as:string*/, msg/*as:Object*/, msgType/*as:string*/) {
	this.post ( url, msg, msgType, true, false );
};

// Ajax应答触发的事件
LZR.HTML.Base.Ajax.prototype.onRsp = function (text/*as:string*/, status/*as:int*/) {
	if ( this.ajax.readyState == 4 ) {
		this.evt.rsp.execute (this.ajax.responseText, this.ajax.status);
	}
};

// 取消请求
LZR.HTML.Base.Ajax.prototype.abort = function () {
	this.ajax.abort();
};


var r = {root:LZR,obj:{},bind:LZR.getSingleton(LZR.Util).bind,ajx:new LZR.HTML.Base.Ajax(),utJson:LZR.getSingleton(LZR.Base.Json)};r.obj.root=r;
var fun = function (obj) {
			// 添加到购物车
			this.addToCart = function (goodsId, num, sn, tn) {
				if (num) {
					var goods = this.tools.utJson.toJson ({
						quick: 0,
						spec: [],
						goods_id: goodsId,
						number: num,
						parent: 0
					});

					var r = this.tools.ajx.post("flow.php?step=add_to_cart", "goods=" + goods);
					// 异常处理 （未完成） ..........

					if (tn) {
						var trees = this.tools.utJson.toJson ({
							quick: 0,
							spec: [],
							goods_id: 194,
							number: tn,
							parent: 0
						});
						this.tools.ajx.post("flow.php?step=add_to_cart", "goods=" + trees);
					}

					if (sn) {
						var seeds = this.tools.utJson.toJson ({
							quick: 0,
							spec: [],
							goods_id: 195,
							number: sn,
							parent: 0
						});
						this.tools.ajx.post("flow.php?step=add_to_cart", "goods=" + seeds);
					}

					location.href = "flow.php?step=cart";
				}
			};
		};
fun.prototype.tools = r;return fun;
}));