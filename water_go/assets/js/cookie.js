var cookie = new function()
{

	this.USER_TOKEN = "USER_TOKEN";
	
	this.setCookie = function(cName, cValue, cDay)
	{
		var expire = new Date();
        expire.setDate(expire.getDate() + cDay);
        cookies = cName + '=' + escape(cValue) + '; path=/ '; // í•œê¸€ ê¹¨ì§ì„ ë§‰ê¸°ìœ„í•´ escape(cValue)ë¥¼ í•©ë‹ˆë‹¤.
        if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
        document.cookie = cookies;
	};

	this.getCookie = function(cName)
	{
		cName = cName + '=';
		var cookieData = document.cookie;
		var start = cookieData.indexOf(cName);
		var cValue = '';
		if (start != -1)
		{
			start += cName.length;
			var end = cookieData.indexOf(';', start);
			if (end == -1)
				end = cookieData.length;
			cValue = cookieData.substring(start, end);
		}
		return unescape(cValue);
	};
	
	this.deleteCookie = function(cName)
	{
		var expireDate = new Date();
		  
		//ì–´ì œ ë‚ ì§œë¥¼ ì¿ í‚¤ ì†Œë©¸ ë‚ ì§œë¡œ ì„¤ì •í•œë‹¤.
		expireDate.setDate( expireDate.getDate() - 1 );
		document.cookie = cName + "= " + "; expires=" + expireDate.toGMTString() + "; path=/";
	};

};