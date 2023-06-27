var auth = new function()
{		
	this.LoginCheck = function()
	{
		var token = cookie.getCookie(cookie.USER_TOKEN);

		if (token != null && token != "")
		{
			return true;
		}
		else
		{
			return false;
		}
	};
	
	this.getAppToken = function()
	{
		var token = cookie.getCookie(cookie.USER_TOKEN);

		return token;
	};

};