var userAgent = new function()
{
	this.TAG_APP = "APP";
	this.TAG_APP_OS = "APP_OS";
	this.TAG_APP_LANGUAGE = "APP_LANGUAGE";
	this.TAG_APP_LATITUDE = "APP_LATITUDE";
	this.TAG_APP_LONGITUDE = "APP_LONGITUDE";
	this.TAG_APP_PUSH_KEY = "APP_PUSH_KEY";
	this.TAG_APP_DEVICE_ID = "APP_DEVICE_ID";
	this.TAG_APP_VERSIONCODE = "APP_VERSIONCODE";
	this.TAG_APP_OS_VERSION = "APP_OS_VERSION";
	
	this.getLatitude = function()
	{
		var value = userAgent.getValue("APP_LATITUDE");
		
		if(value == null || value == "")
		{
			value = '0';
			value = '37.566535';
		}
		
		return value;
	};
	
	this.getLongitude = function()
	{
		var value = userAgent.getValue("APP_LONGITUDE");
		
		if(value == null || value == "")
		{
			value = '0';
			value = '126.9779691';
		}
		
		return value;
	};
	
	this.getValue = function(key)
	{
		var value = "";
		var userAgent = window.navigator.userAgent;

		var arr1 = userAgent.split('[');

		if(arr1.length > 1)
		{
			var aaa = arr1[1];
			var arr2 = aaa.split(']');
			var bbb = arr2[0];
			var aar3 = bbb.split(',');

			for(var i=0; i<aar3.length; i++)
			{
				var item = aar3[i].split('@!@');
				var tag = item[0];
				
				if(key == tag)
				{
					value = item[1];
					break;
				}
			}
		}
		else
		{
//			alert(false);
		}
		
		return value;
	};

	this.printUserAgent = function()
	{
		var value = "";
		var userAgent = window.navigator.userAgent;

		var arr1 = userAgent.split('[');
		
		if(arr1.length > 1)
		{
			var aaa = arr1[1];
			var arr2 = aaa.split(']');
			var bbb = arr2[0];
			var aar3 = bbb.split(',');

			for(var i=0; i<aar3.length; i++)
			{
				document.writeln(aar3[i]);
//				var item = aar3[i].split(':');
//				var tag = item[0];
//				
//				if(key == tag)
//				{
//					value = item[1];
//					break;
//				}
			}
		}
		
		return value;
	};

};