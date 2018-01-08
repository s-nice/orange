/* BrowserDetect came from http://www.quirksmode.org/js/detect.html */

  var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera",
			versionSearch: "Version"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		/* for newer Netscapes (6+)*/
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		/* for older Netscapes (4-)*/
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

  };

  BrowserDetect.init();
/*
  function connect_server(address){
      server_address = address;
      if (typeof MozWebSocket != "undefined") {
          socket_di = new MozWebSocket("ws://"+address,
				   "connect-server-protocol");
      } else {
          socket_di = new WebSocket("ws://"+address,
				   "connect-server-protocol");
      }
  }
*/
  function to_login_server(sobj){
      if (typeof MozWebSocket != "undefined") {
          socket = new MozWebSocket("ws://"+sobj.url,
				   "data-server-protocol");
      } else {
          socket = new WebSocket("ws://"+sobj.url,
				   "data-server-protocol");
      }

      try{
          socket.onopen = function() {
              socket.send(JSON.stringify(sobj));
              sobj.socket = socket; 
          } 

          socket.onmessage =function got_packet(msg) {
              sobj.user_list = msg.data;
              /*alert("===="+msg.data+"====");*/
              var oo = eval('(' + msg.data + ')');
                      //alert(oo.type);
              switch(oo.type){
                  case 1:/*get user list*/
                      break;
                  case 2:/*p2p*/
                      sobj.OnSendText(oo);
                      break;
                  case 3: /*login*/
                      sobj.OnLogin(oo);
                      sobj.timer = window.setInterval(function(){HeartBeat(sobj);},5000);
                      break;
                  case 4: /*create group*/
                	  sobj.OnCreateGroup(oo);
                      break;
                  case 5: /*Recv Text*/
                      sobj.OnRecvText(oo);
                      break;
                  case 6: /*del group*/
                      sobj.OnDelGroup(oo);
                      break;
                  case 7: /*accept invite join group*/
                      sobj.OnAcceptInviteJoinGroup(oo);
                      break;
                  case 9: /*invite join group*/
                      sobj.OnInviteJoinGroup(oo);
                      break;
                  case 10: /*refuse invite join group*/
                      sobj.OnRefuseInviteJoinGroup(oo);
                      break;
                  case 11: /*modify group*/
                      sobj.OnModifyGroup(oo);
                      break;
                  case 12: /*serach group*/
                      sobj.OnSearchGroup(oo);
                      break;
                  case 13: /**/
                      sobj.OnGetGroupInfoList(oo);
                      break;
                  case 14: /**/
                      sobj.OnKickGroupUser(oo);
                      break;
                  case 15: /**/
                      sobj.OnDelGroupUser(oo);
                      break;
                  case 16: /**/
                      sobj.OnAddGroupUserInfo(oo);
                      break;
                  case 17: /**/
                      sobj.OnLeaveGroupInfo(oo);
                      break;
                  case 18: /**/
                      sobj.OnApplyJoinGroup(oo);
                      break;
                  case 19: /**/
                      sobj.OnAcceptApplyJoinGroup(oo);
                      break;
                  case 20: /**/
                      sobj.OnRefuseApplyJoinGroup(oo);
                      break;
                  case 21: /**/
                      sobj.OnGetGroupMember(oo);
                      break;
                  case 22: /**/
                      sobj.OnSearchMember(oo);
                      break;
                  case 23: /**/
                      sobj.OnConnectResult(oo);
                      break;
                  case 24: /**/
                      sobj.OnLogoutResult(oo);
                      clearInterval(sobj.timer);
                      break;
                  case 25: /**/
                      sobj.OnUpdateStatus(oo);
                      break;
                  case 26: /**/
                      sobj.OnRecvBinary(oo);
                      break;
                  case 27: /**/
                      sobj.OnJoinGroupErrorResponse(oo);
                      break;
                  case 33: /**/
                      sobj.OnGetGroupUserInfo(oo);
                      break;
                  case 34: /**/
                      sobj.OnAddGroupInfo(oo);
                      break;
                  case 35: /**/
                      sobj.OnLogin2(oo);
                      break;
                  case 36: /**/
                      sobj.OnLogoutResult2(oo);
                      break;
                  case 38: /**/
                      sobj.OnRecvCustomText(oo);
                      break;
                  case 40: /**/
                      sobj.OnChatManagerResult(oo);
                      break;
                  case 41: /**/
                      sobj.OnBlockList(oo);
                      break;
                  case 43: /**/
                      sobj.OnChatMsgNum(oo);
                      break;
                  case 45: /**/
                      sobj.OnGroupList(oo);
                      break;
                  case 46: /**/
                      sobj.OnGroupMemberList(oo);
                      break;
                  default:
                      break;
              }
          }

          //socket.onclose = function(){
          //}
      }catch(exception) {
          var explorer = window.navigator.userAgent;
    	  if (explorer.indexOf("MSIE 9.0") < 0) {
    		  alert('<p>Error' + exception);
    	  }
      }
      return socket;
  }

  function login(login_info,user,passwd,nStatus,ip,port,url){
      var interval;
      login_info.type      = "3";
      login_info.user      = user;
      login_info.passwd    = passwd;
      login_info.nStatus   = nStatus;
      login_info.ip        = ip;
      login_info.port      = port;
      login_info.url       = url
      login_info.login_status  = -1;
      try{

          login_info.socket = to_login_server(login_info);

      }catch(exception) {
          var explorer = window.navigator.userAgent;
    	  if (explorer.indexOf("MSIE 9.0") < 0) {
    		  alert('<p>Error' + exception);
    	  }  
      }
      return login_info;
  }

  function login2(login_info,user,passwd,sSessionID,nStatus,ip,port,url){
      login_info.type      = "42";
      login_info.user      = user;
      login_info.passwd    = passwd;
      login_info.sSessionID    = sSessionID;
      login_info.nStatus   = nStatus;
      login_info.ip        = ip;
      login_info.port      = port;
      login_info.url       = url
      login_info.login_status  = -1;
      try{
    	  
          login_info.socket = to_login_server(login_info);

      }catch(exception) {
          // alert('<p>Error' + exception);  
          $.bug(1) && console && console.log('<p>Error' + exception);
      }
      return login_info;
  }
  function SendTextMessage(sobj,grouptype,nGroupID,toUserID,sSeqID,message){
	    $.WebChat.IEActiveConnect(); //解决IE断开的问题
        var msg = new Object();
        msg.type      = '2';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        msg.message   = message;
        msg.toUserID    = toUserID;
        msg.seq       = sSeqID;
        $.bug(2) && console && console.log('发送文本消息：',msg)
        sobj.socket.send(JSON.stringify(msg));
  }

  function CreateGroup(sobj,grouptype,groupXml, dstUserXml){
	  var msg = new Object();
        msg.type       = '4';
        msg.grouptype  = grouptype;
        msg.groupXml   = groupXml;
        msg.dstUserXml = dstUserXml;
        $.bug(2) && console && console.log('创建群组',msg);
        sobj.socket.send(JSON.stringify(msg));
  }
  //no_use
  function DelGroup(sobj,grouptype,nGroupID){
        var msg = new Object();
        msg.type      = '6';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        sobj.socket.send(JSON.stringify(msg));
  }

  //no_use
  function AcceptInviteJoinGroup(sobj,grouptype,nGroupID,nSrcUserID){
        var msg = new Object();
        msg.type      = '7';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        msg.nSrcUserID   = nSrcUserID;
        $.bug(2) && console && console.log('给群组添加用户',msg);
        sobj.socket.send(JSON.stringify(msg));
  }

  function subscribeUserStatus(sobj,nUserID){
        var msg = new Object();
        msg.type       = '8';
        msg.nUserID = nUserID;
        sobj.socket.send(JSON.stringify(msg));
  }
  //给群组添加成员方法
  function InviteJoinGroup(sobj,grouptype,sGroupXml,sDstUserXml,sAdditInfo){
        var msg = new Object();
        msg.type       = '9';
        msg.grouptype  = grouptype;
        msg.groupXml   = sGroupXml;
        msg.dstUserXml = sDstUserXml;
        msg.message    = sAdditInfo;
        $.bug(2) && console && console.log('给群组添加成员出口',msg);
        sobj.socket.send(JSON.stringify(msg));
  }
  //no_use
  function RefuseInviteJoinGroup(sobj,grouptype,nGroupID,nSrcUserID,sAdditInfo){
        var msg = new Object();
        msg.type       = '10';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        msg.nSrcUserID = nSrcUserID;
        msg.message    = sAdditInfo;
        sobj.socket.send(JSON.stringify(msg));
  }
  //no_use
  function ModifyGroupInfo(sobj,grouptype,nGroupID,sGroupXml){
        var msg = new Object();
        msg.type       = '11';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        msg.groupXml   = sGroupXml;
        sobj.socket.send(JSON.stringify(msg));
  }
  //no_use
  function SearchGroup(sobj,grouptype,szUnsharpName,nStartNum,nSearchNum){
        var msg = new Object();
        msg.type       = '12';
        msg.grouptype  = grouptype;
        msg.szUnsharpName   = szUnsharpName;
        msg.nStartNum = nStartNum;
        msg.nSearchNum    = nSearchNum;
        sobj.socket.send(JSON.stringify(msg));
  }

  function LeaveGroup(sobj,grouptype,nGroupID){
        var msg = new Object();
        msg.type       = '28';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        $.bug(2) && console && console.log('退出群组',msg)
        sobj.socket.send(JSON.stringify(msg));
  }

  function DelGroupUser(sobj,grouptype,nGroupID,nUserID){
        var msg = new Object();
        msg.type       = '29';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        msg.nUserID   = nUserID;
        sobj.socket.send(JSON.stringify(msg));
  }
  //no_use
  function ApplyJoinGroup(sobj,grouptype,nGroupID,sAddInfo){
        var msg = new Object();
        msg.type       = '30';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        msg.message   = sAddInfo;
        sobj.socket.send(JSON.stringify(msg));
  }
  //no_use
  function AcceptApplyJoinGroup(sobj,grouptype,nGroupID,nUserID){
        var msg = new Object();
        msg.type       = '31';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        msg.nUserID   = nUserID;
        sobj.socket.send(JSON.stringify(msg));
  }
  //no_use
  function RefuseApplyJoinGroup(sobj,grouptype,nGroupID,nUserID,sReason){
        var msg = new Object();
        msg.type       = '32';
        msg.grouptype  = grouptype;
        msg.nGroupID   = nGroupID;
        msg.nUserID   = nUserID;
        msg.message   = sReason;
        sobj.socket.send(JSON.stringify(msg));
  }
  //发送二进制文件
  function SendBinaryMessage(sobj,grouptype,eChatDataType,nGroupID,toUserID,sSeqID,message){
	    $.WebChat.IEActiveConnect(); //解决IE断开的问题
        var msg = new Object();
        msg.type       = '37';
        msg.grouptype  = grouptype;
        msg.eChatDataType  = eChatDataType;
        msg.nGroupID   = nGroupID;
        msg.toUserID   = toUserID;
        msg.seq   = sSeqID;
        msg.message   = message;
        $.bug(2) && console && console.log('发送二进制消息：',msg)
        sobj.socket.send(JSON.stringify(msg));
  }

  function ChatManager(sobj,grouptype,toUserID,eSetChatOper){
      var msg = new Object();
      msg.type       = '39';
      msg.grouptype  = grouptype;
      msg.eSetChatOper  = eSetChatOper;
      msg.toUserID   = toUserID;
      $.bug(2) && console && console.log('设置黑名单:',msg);
	sobj.socket.send(JSON.stringify(msg));
  }
  
  function HeartBeat(sobj){
      var msg = new Object();
      msg.timer       = '9999';
      sobj.socket.send(JSON.stringify(msg));
  }
  
  function GetAllPushMsg(sobj){
      var msg = new Object();
      msg.type       = '44';
      sobj.socket.send(JSON.stringify(msg));
  }
