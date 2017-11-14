function checkCookie()
{
    if (document.cookie)
    {
        var checked = getCookie("checked");
        if (checked === "true")
        {
            var user = getCookie("user");
            if (user !== null && user !== "")
            {
                document.getElementById("user").value = user;
                document.getElementById("remember_me").checked = true;
            }
        }
    }
}

function createCookie()
{
    if (document.getElementById("remember_me").checked)
    {
        document.cookie = "checked=true;expires=Fri, 31 Dec 9999 23:59:59 GMT";
        document.cookie = "user=" + document.getElementById("user").value + ";expires=Fri, 31 Dec 9999 23:59:59 GMT";
    }
    else
    {
        document.cookie = "checked=false";
        document.cookie = "user=null";
    }
}

function handleSubmit(evt)
{
	if (evt.preventDefault)
	{
            evt.preventDefault();
	}
	else
	{
            evt.returnValue = false;
	}
	createCookie();
	document.getElementById("form1").submit();
}

function getCookie(cname)
{
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function createEventListeners()
{
    var form1 = document.getElementById("form1");
    if (form1.addEventListener)
    {
        form1.addEventListener("submit", handleSubmit, false);
    }
    else if (form1.attachEvent)
    {
        form1.attachEvent("onsubmit", handleSubmit);
    }
}

if (window.addEventListener)
{
    window.addEventListener("load", createEventListeners, false);
    window.addEventListener("load", checkCookie, false);
}
else if (window.attachEvent)
{
    window.attachEvent("onload", createEventListeners);
    window.attachEvent("onload", checkCookie);
}