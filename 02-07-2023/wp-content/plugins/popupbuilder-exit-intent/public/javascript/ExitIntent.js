function SGPBExitIntent()
{
	this.exitIntntType;
	this.expireTime;
	this.popupObj = {};
	this.alertText;
	this.cookiePageLevel;
	this.exitSoftFromTop;
	this.formLinkClick = false;
}

SGPBExitIntent.cookieName = 'SGPBExitIntent';

SGPBExitIntent.prototype.setPopupObj = function(popupObj)
{
	this.popupObj = popupObj;
};

SGPBExitIntent.prototype.getPopupObj = function()
{
	return this.popupObj;
};

SGPBExitIntent.prototype.setType = function(type)
{
	this.exitIntntType = type;
};

SGPBExitIntent.prototype.getType = function()
{
	return this.exitIntntType;
};

SGPBExitIntent.prototype.setExpireTime = function(time)
{
	this.expireTime = time;
};

SGPBExitIntent.prototype.getExpireTime = function()
{
	return this.expireTime;
};

SGPBExitIntent.prototype.setAlertText = function(text)
{
	this.alertText = text;
};

SGPBExitIntent.prototype.getAlertText = function() {
	return this.alertText;
};

SGPBExitIntent.prototype.setCookiePageLevel = function(cookieLevel)
{
	this.cookiePageLevel = cookieLevel;
};

SGPBExitIntent.prototype.getCookiePageLevel = function()
{
	return this.cookiePageLevel;
};

SGPBExitIntent.prototype.setExitSoftFromTop = function(exitSoftFromTop)
{
	this.exitSoftFromTop = exitSoftFromTop;
};

SGPBExitIntent.prototype.getExitSoftFromTop = function()
{
	return this.exitSoftFromTop;
};

SGPBExitIntent.prototype.buildExitIntent = function(id)
{
	var type = this.getType();
	var that = this;

	this.linkClickListener();

	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		if (window.history.state == null) {
			window.history.pushState({
				popupbuiler: "exit-intent"
			}, "");
		}
		if (type == 'aggressive') {
			window.onpopstate = function () {
				that.triggerOpenPopup(id);
			}
		}
		document.addEventListener("visibilitychange", function() {
			that.triggerOpenPopup(id);
		});
		document.onvisibilitychange = function() {
		  that.triggerOpenPopup(id);
		};
	}

	if (type == 'soft') {
		this.softMode(id);
	}
	else if (type == 'aggressive') {
		this.aggressiveMode(id, 'aggressive');
	}
	else if (type == 'softAndAggressive') {
		this.softAndAggressiveMode(id);
	}
	else if (type == 'aggressiveWithoutPopup') {
		this.aggressiveMode(id, 'aggressive1');
	}
};

SGPBExitIntent.prototype.softMode = function(id)
{
	var that = this;
	var leaveFromTop = this.getExitSoftFromTop();

	sgAddEvent(document, 'mouseout', function(e) {
		if (e.toElement == null && e.relatedTarget == null) {
			var result = that.canOpen(id, 'soft');
			if (result) {
				return;
			}

			if (!leaveFromTop) {
				var popupObj = that.getPopupObj();
				var popupId = popupObj.id;

				that.openExitIntentPopup(popupId)
			}
			var e = e ? e : window.event;

			/*If this is an autocomplete element.*/
			if (e.target.tagName.toLowerCase() == 'input') {
				return;
			}

			/*Get the current viewport width.*/
			var vpWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

			/*If the current mouse X position is within 50px of the right edge
				of the viewport, return.*/
			if (e.clientX >= (vpWidth - 50)) {
				return;
			}

			/*If the current mouse Y position is not within 50px of the top
				edge of the viewport, return.*/
			if (e.clientY >= 50)
				return;

			/*Reliable, works on mouse exiting window and
				user switching active program*/
			var from = e.relatedTarget || e.toElement;
			if (!from && leaveFromTop) {
				that.openExitIntentPopup(popupId);
				return;
			}
		}
	});
};

SGPBExitIntent.prototype.linkClickListener = function()
{
	var that = this;
	var atags = document.getElementsByTagName('a');
	if (atags) {
		for (var tag in atags) {
			sgAddEvent(atags[tag], 'click', function(e) {
				that.formLinkClick = true;
			});
		}
	}
};

SGPBExitIntent.prototype.aggressiveMode = function(id, aggressiveMode)
{
	var that = this;

	sgAddEvent(window, 'beforeunload', function(e) {
		var result = that.canOpen(id, aggressiveMode);

		if (result || that.formLinkClick) {
			return;
		}

		(e || window.event).returnValue = that.triggerOpenPopup(id);
		e.returnValue = that.triggerOpenPopup(id);
	});
};

SGPBExitIntent.prototype.softAndAggressiveMode = function(id)
{
	this.softMode(id);
	this.aggressiveMode(id, 'aggressive');
};

SGPBExitIntent.prototype.triggerOpenPopup = function(id)
{
	if (this.getType() !== 'aggressiveWithoutPopup') {
		this.openExitIntentPopup(id);
		return false;
	}

	return this.getAlertText();
};

SGPBExitIntent.prototype.openExitIntentPopup = function(id)
{
	var that = this;
	setTimeout(function(){
		var popupWindow = SGPBPopup.getPopupWindowDataById(id);
		if (popupWindow == false || !popupWindow.isOpen) {
			that.getPopupObj().prepareOpen();
		}
	}, 0);
};

SGPBExitIntent.prototype.canOpen = function(id, type)
{
	if (!SGPopup.getCookie(SGPBExitIntent.cookieName+id+type)) {
		this.setExitIntentCookie(id, type);
		return false;
	}

	return true;
};

SGPBExitIntent.prototype.setExitIntentCookie = function(id, type)
{
	var that = this;

	/*For Aggressive without popup case.*/
	if (type == 'aggressive1') {
		that.setCookies(id, type);
	}
	sgAddEvent(window, 'sgpbDidOpen', function(e) {
		that.setCookies(id, type);
	});
};

SGPBExitIntent.prototype.setCookies = function(id, type)
{
	var that = this;
	var date = this.getExpireTime();
	var pageLevel = that.getCookiePageLevel();
	var currentUrl = window.location.href;
	date = parseInt(date);
	if (typeof pageLevel != 'undefined' && pageLevel == 'on') {
		pageLevel = currentUrl;
	}
	/*Date == -1 for always case*/
	if (date !== -1) {
		if (date == 0) {
			/*Date == 0 for session case*/
			SGPBPopup.setCookie(SGPBExitIntent.cookieName + id + type, id, -1, pageLevel);
			return true;
		}
		SGPBPopup.setCookie(SGPBExitIntent.cookieName + id + type, id, date, pageLevel);

		return true;
	}
};

SgpbEventListener.prototype.sgpbExitIntent = function(listenerObj, eventData)
{
	var popupId = listenerObj.popupObj.id;
	var pageLevel = (typeof eventData['sgpb-exit-intent-cookie-level'] == 'undefined') ? false : eventData['sgpb-exit-intent-cookie-level'];
	var leaveFromTop = (typeof eventData['sgpb-exit-intent-soft-from-top'] == 'undefined') ? false : eventData['sgpb-exit-intent-soft-from-top'];

	var exitPopupObj = new SGPBExitIntent();

	exitPopupObj.setPopupObj(listenerObj.popupObj);
	exitPopupObj.setExpireTime(parseInt(eventData['sgpb-exit-intent-expire-time']));
	exitPopupObj.setType(eventData['value']);
	exitPopupObj.setExitSoftFromTop(leaveFromTop);
	exitPopupObj.setAlertText(eventData['sgpb-exit-intent-alert']);
	exitPopupObj.setCookiePageLevel(pageLevel);
	exitPopupObj.buildExitIntent(popupId);
};
