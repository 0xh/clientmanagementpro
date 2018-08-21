(function() {
	function require(path, parent, orig) {
		var resolved = require.resolve(path);
		if (null == resolved) {
			orig = orig || path;
			parent = parent || "root";
			var err = new Error('Failed to require "' + orig + '" from "' + parent + '"');
			err.path = orig;
			err.parent = parent;
			err.require = true;
			throw err
		}
		var module = require.modules[resolved];
		if (!module._resolving && !module.exports) {
			var mod = {};
			mod.exports = {};
			mod.client = mod.component = true;
			module._resolving = true;
			module.call(this, mod.exports, require.relative(resolved), mod);
			delete module._resolving;
			module.exports = mod.exports
		}
		return module.exports
	}
	require.modules = {};
	require.aliases = {};
	require.resolve = function(path) {
		if (path.charAt(0) === "/") path = path.slice(1);
		var paths = [path, path + ".js", path + ".json", path + "/index.js", path + "/index.json"];
		for (var i = 0; i < paths.length; i++) {
			var path = paths[i];
			if (require.modules.hasOwnProperty(path)) return path;
			if (require.aliases.hasOwnProperty(path)) return require.aliases[path]
		}
	};
	require.normalize = function(curr, path) {
		var segs = [];
		if ("." != path.charAt(0)) return path;
		curr = curr.split("/");
		path = path.split("/");
		for (var i = 0; i < path.length; ++i) {
			if (".." == path[i]) {
				curr.pop()
			} else if ("." != path[i] && "" != path[i]) {
				segs.push(path[i])
			}
		}
		return curr.concat(segs).join("/")
	};
	require.register = function(path, definition) {
		require.modules[path] = definition
	};
	require.alias = function(from, to) {
		if (!require.modules.hasOwnProperty(from)) {
			throw new Error('Failed to alias "' + from + '", it does not exist')
		}
		require.aliases[to] = from
	};
	require.relative = function(parent) {
		var p = require.normalize(parent, "..");

		function lastIndexOf(arr, obj) {
			var i = arr.length;
			while (i--) {
				if (arr[i] === obj) return i
			}
			return -1
		}

		function localRequire(path) {
			var resolved = localRequire.resolve(path);
			return require(resolved, parent, path)
		}
		localRequire.resolve = function(path) {
			var c = path.charAt(0);
			if ("/" == c) return path.slice(1);
			if ("." == c) return require.normalize(p, path);
			var segs = parent.split("/");
			var i = lastIndexOf(segs, "deps") + 1;
			if (!i) i = 0;
			path = segs.slice(0, i + 1).join("/") + "/deps/" + path;
			return path
		};
		localRequire.exists = function(path) {
			return require.modules.hasOwnProperty(localRequire.resolve(path))
		};
		return localRequire
	};
	require.register("abpetkov-transitionize/transitionize.js", function(exports, require, module) {
		module.exports = Transitionize;

		function Transitionize(element, props) {
			if (!(this instanceof Transitionize)) return new Transitionize(element, props);
			this.element = element;
			this.props = props || {};
			this.init()
		}
		Transitionize.prototype.isSafari = function() {
			return /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor)
		};
		Transitionize.prototype.init = function() {
			var transitions = [];
			for (var key in this.props) {
				transitions.push(key + " " + this.props[key])
			}
			this.element.style.transition = transitions.join(", ");
			if (this.isSafari()) this.element.style.webkitTransition = transitions.join(", ")
		}
	});
	require.register("ftlabs-fastclick/lib/fastclick.js", function(exports, require, module) {
		function FastClick(layer) {
			"use strict";
			var oldOnClick, self = this;
			this.trackingClick = false;
			this.trackingClickStart = 0;
			this.targetElement = null;
			this.touchStartX = 0;
			this.touchStartY = 0;
			this.lastTouchIdentifier = 0;
			this.touchBoundary = 10;
			this.layer = layer;
			if (!layer || !layer.nodeType) {
				throw new TypeError("Layer must be a document node")
			}
			this.onClick = function() {
				return FastClick.prototype.onClick.apply(self, arguments)
			};
			this.onMouse = function() {
				return FastClick.prototype.onMouse.apply(self, arguments)
			};
			this.onTouchStart = function() {
				return FastClick.prototype.onTouchStart.apply(self, arguments)
			};
			this.onTouchMove = function() {
				return FastClick.prototype.onTouchMove.apply(self, arguments)
			};
			this.onTouchEnd = function() {
				return FastClick.prototype.onTouchEnd.apply(self, arguments)
			};
			this.onTouchCancel = function() {
				return FastClick.prototype.onTouchCancel.apply(self, arguments)
			};
			if (FastClick.notNeeded(layer)) {
				return
			}
			if (this.deviceIsAndroid) {
				layer.addEventListener("mouseover", this.onMouse, true);
				layer.addEventListener("mousedown", this.onMouse, true);
				layer.addEventListener("mouseup", this.onMouse, true)
			}
			layer.addEventListener("click", this.onClick, true);
			layer.addEventListener("touchstart", this.onTouchStart, false);
			layer.addEventListener("touchmove", this.onTouchMove, false);
			layer.addEventListener("touchend", this.onTouchEnd, false);
			layer.addEventListener("touchcancel", this.onTouchCancel, false);
			if (!Event.prototype.stopImmediatePropagation) {
				layer.removeEventListener = function(type, callback, capture) {
					var rmv = Node.prototype.removeEventListener;
					if (type === "click") {
						rmv.call(layer, type, callback.hijacked || callback, capture)
					} else {
						rmv.call(layer, type, callback, capture)
					}
				};
				layer.addEventListener = function(type, callback, capture) {
					var adv = Node.prototype.addEventListener;
					if (type === "click") {
						adv.call(layer, type, callback.hijacked || (callback.hijacked = function(event) {
							if (!event.propagationStopped) {
								callback(event)
							}
						}), capture)
					} else {
						adv.call(layer, type, callback, capture)
					}
				}
			}
			if (typeof layer.onclick === "function") {
				oldOnClick = layer.onclick;
				layer.addEventListener("click", function(event) {
					oldOnClick(event)
				}, false);
				layer.onclick = null
			}
		}
		FastClick.prototype.deviceIsAndroid = navigator.userAgent.indexOf("Android") > 0;
		FastClick.prototype.deviceIsIOS = /iP(ad|hone|od)/.test(navigator.userAgent);
		FastClick.prototype.deviceIsIOS4 = FastClick.prototype.deviceIsIOS && /OS 4_\d(_\d)?/.test(navigator.userAgent);
		FastClick.prototype.deviceIsIOSWithBadTarget = FastClick.prototype.deviceIsIOS && /OS ([6-9]|\d{2})_\d/.test(navigator.userAgent);
		FastClick.prototype.needsClick = function(target) {
			"use strict";
			switch (target.nodeName.toLowerCase()) {
				case "button":
				case "select":
				case "textarea":
					if (target.disabled) {
						return true
					}
					break;
				case "input":
					if (this.deviceIsIOS && target.type === "file" || target.disabled) {
						return true
					}
					break;
				case "label":
				case "video":
					return true
			}
			return /\bneedsclick\b/.test(target.className)
		};
		FastClick.prototype.needsFocus = function(target) {
			"use strict";
			switch (target.nodeName.toLowerCase()) {
				case "textarea":
					return true;
				case "select":
					return !this.deviceIsAndroid;
				case "input":
					switch (target.type) {
						case "button":
						case "checkbox":
						case "file":
						case "image":
						case "radio":
						case "submit":
							return false
					}
					return !target.disabled && !target.readOnly;
				default:
					return /\bneedsfocus\b/.test(target.className)
			}
		};
		FastClick.prototype.sendClick = function(targetElement, event) {
			"use strict";
			var clickEvent, touch;
			if (document.activeElement && document.activeElement !== targetElement) {
				document.activeElement.blur()
			}
			touch = event.changedTouches[0];
			clickEvent = document.createEvent("MouseEvents");
			clickEvent.initMouseEvent(this.determineEventType(targetElement), true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
			clickEvent.forwardedTouchEvent = true;
			targetElement.dispatchEvent(clickEvent)
		};
		FastClick.prototype.determineEventType = function(targetElement) {
			"use strict";
			if (this.deviceIsAndroid && targetElement.tagName.toLowerCase() === "select") {
				return "mousedown"
			}
			return "click"
		};
		FastClick.prototype.focus = function(targetElement) {
			"use strict";
			var length;
			if (this.deviceIsIOS && targetElement.setSelectionRange && targetElement.type.indexOf("date") !== 0 && targetElement.type !== "time") {
				length = targetElement.value.length;
				targetElement.setSelectionRange(length, length)
			} else {
				targetElement.focus()
			}
		};
		FastClick.prototype.updateScrollParent = function(targetElement) {
			"use strict";
			var scrollParent, parentElement;
			scrollParent = targetElement.fastClickScrollParent;
			if (!scrollParent || !scrollParent.contains(targetElement)) {
				parentElement = targetElement;
				do {
					if (parentElement.scrollHeight > parentElement.offsetHeight) {
						scrollParent = parentElement;
						targetElement.fastClickScrollParent = parentElement;
						break
					}
					parentElement = parentElement.parentElement
				} while (parentElement)
			}
			if (scrollParent) {
				scrollParent.fastClickLastScrollTop = scrollParent.scrollTop
			}
		};
		FastClick.prototype.getTargetElementFromEventTarget = function(eventTarget) {
			"use strict";
			if (eventTarget.nodeType === Node.TEXT_NODE) {
				return eventTarget.parentNode
			}
			return eventTarget
		};
		FastClick.prototype.onTouchStart = function(event) {
			"use strict";
			var targetElement, touch, selection;
			if (event.targetTouches.length > 1) {
				return true
			}
			targetElement = this.getTargetElementFromEventTarget(event.target);
			touch = event.targetTouches[0];
			if (this.deviceIsIOS) {
				selection = window.getSelection();
				if (selection.rangeCount && !selection.isCollapsed) {
					return true
				}
				if (!this.deviceIsIOS4) {
					if (touch.identifier === this.lastTouchIdentifier) {
						event.preventDefault();
						return false
					}
					this.lastTouchIdentifier = touch.identifier;
					this.updateScrollParent(targetElement)
				}
			}
			this.trackingClick = true;
			this.trackingClickStart = event.timeStamp;
			this.targetElement = targetElement;
			this.touchStartX = touch.pageX;
			this.touchStartY = touch.pageY;
			if (event.timeStamp - this.lastClickTime < 200) {
				event.preventDefault()
			}
			return true
		};
		FastClick.prototype.touchHasMoved = function(event) {
			"use strict";
			var touch = event.changedTouches[0],
				boundary = this.touchBoundary;
			if (Math.abs(touch.pageX - this.touchStartX) > boundary || Math.abs(touch.pageY - this.touchStartY) > boundary) {
				return true
			}
			return false
		};
		FastClick.prototype.onTouchMove = function(event) {
			"use strict";
			if (!this.trackingClick) {
				return true
			}
			if (this.targetElement !== this.getTargetElementFromEventTarget(event.target) || this.touchHasMoved(event)) {
				this.trackingClick = false;
				this.targetElement = null
			}
			return true
		};
		FastClick.prototype.findControl = function(labelElement) {
			"use strict";
			if (labelElement.control !== undefined) {
				return labelElement.control
			}
			if (labelElement.htmlFor) {
				return document.getElementById(labelElement.htmlFor)
			}
			return labelElement.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")
		};
		FastClick.prototype.onTouchEnd = function(event) {
			"use strict";
			var forElement, trackingClickStart, targetTagName, scrollParent, touch, targetElement = this.targetElement;
			if (!this.trackingClick) {
				return true
			}
			if (event.timeStamp - this.lastClickTime < 200) {
				this.cancelNextClick = true;
				return true
			}
			this.cancelNextClick = false;
			this.lastClickTime = event.timeStamp;
			trackingClickStart = this.trackingClickStart;
			this.trackingClick = false;
			this.trackingClickStart = 0;
			if (this.deviceIsIOSWithBadTarget) {
				touch = event.changedTouches[0];
				targetElement = document.elementFromPoint(touch.pageX - window.pageXOffset, touch.pageY - window.pageYOffset) || targetElement;
				targetElement.fastClickScrollParent = this.targetElement.fastClickScrollParent
			}
			targetTagName = targetElement.tagName.toLowerCase();
			if (targetTagName === "label") {
				forElement = this.findControl(targetElement);
				if (forElement) {
					this.focus(targetElement);
					if (this.deviceIsAndroid) {
						return false
					}
					targetElement = forElement
				}
			} else if (this.needsFocus(targetElement)) {
				if (event.timeStamp - trackingClickStart > 100 || this.deviceIsIOS && window.top !== window && targetTagName === "input") {
					this.targetElement = null;
					return false
				}
				this.focus(targetElement);
				if (!this.deviceIsIOS4 || targetTagName !== "select") {
					this.targetElement = null;
					event.preventDefault()
				}
				return false
			}
			if (this.deviceIsIOS && !this.deviceIsIOS4) {
				scrollParent = targetElement.fastClickScrollParent;
				if (scrollParent && scrollParent.fastClickLastScrollTop !== scrollParent.scrollTop) {
					return true
				}
			}
			if (!this.needsClick(targetElement)) {
				event.preventDefault();
				this.sendClick(targetElement, event)
			}
			return false
		};
		FastClick.prototype.onTouchCancel = function() {
			"use strict";
			this.trackingClick = false;
			this.targetElement = null
		};
		FastClick.prototype.onMouse = function(event) {
			"use strict";
			if (!this.targetElement) {
				return true
			}
			if (event.forwardedTouchEvent) {
				return true
			}
			if (!event.cancelable) {
				return true
			}
			if (!this.needsClick(this.targetElement) || this.cancelNextClick) {
				if (event.stopImmediatePropagation) {
					event.stopImmediatePropagation()
				} else {
					event.propagationStopped = true
				}
				event.stopPropagation();
				event.preventDefault();
				return false
			}
			return true
		};
		FastClick.prototype.onClick = function(event) {
			"use strict";
			var permitted;
			if (this.trackingClick) {
				this.targetElement = null;
				this.trackingClick = false;
				return true
			}
			if (event.target.type === "submit" && event.detail === 0) {
				return true
			}
			permitted = this.onMouse(event);
			if (!permitted) {
				this.targetElement = null
			}
			return permitted
		};
		FastClick.prototype.destroy = function() {
			"use strict";
			var layer = this.layer;
			if (this.deviceIsAndroid) {
				layer.removeEventListener("mouseover", this.onMouse, true);
				layer.removeEventListener("mousedown", this.onMouse, true);
				layer.removeEventListener("mouseup", this.onMouse, true)
			}
			layer.removeEventListener("click", this.onClick, true);
			layer.removeEventListener("touchstart", this.onTouchStart, false);
			layer.removeEventListener("touchmove", this.onTouchMove, false);
			layer.removeEventListener("touchend", this.onTouchEnd, false);
			layer.removeEventListener("touchcancel", this.onTouchCancel, false)
		};
		FastClick.notNeeded = function(layer) {
			"use strict";
			var metaViewport;
			var chromeVersion;
			if (typeof window.ontouchstart === "undefined") {
				return true
			}
			chromeVersion = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1];
			if (chromeVersion) {
				if (FastClick.prototype.deviceIsAndroid) {
					metaViewport = document.querySelector("meta[name=viewport]");
					if (metaViewport) {
						if (metaViewport.content.indexOf("user-scalable=no") !== -1) {
							return true
						}
						if (chromeVersion > 31 && window.innerWidth <= window.screen.width) {
							return true
						}
					}
				} else {
					return true
				}
			}
			if (layer.style.msTouchAction === "none") {
				return true
			}
			return false
		};
		FastClick.attach = function(layer) {
			"use strict";
			return new FastClick(layer)
		};
		if (typeof define !== "undefined" && define.amd) {
			define(function() {
				"use strict";
				return FastClick
			})
		} else if (typeof module !== "undefined" && module.exports) {
			module.exports = FastClick.attach;
			module.exports.FastClick = FastClick
		} else {
			window.FastClick = FastClick
		}
	});
	require.register("switchery/switchery.js", function(exports, require, module) {
		var transitionize = require("transitionize"),
			fastclick = require("fastclick");
		module.exports = Switchery;
		var defaults = {
			color: "#64bd63",
			secondaryColor: "#dfdfdf",
			className: "switchery",
			disabled: false,
			disabledOpacity: .5,
			speed: "0.4s"
		};

		function Switchery(element, options) {
			if (!(this instanceof Switchery)) return new Switchery(element, options);
			this.element = element;
			this.options = options || {};
			for (var i in defaults) {
				if (this.options[i] == null) {
					this.options[i] = defaults[i]
				}
			}
			if (this.element != null && this.element.type == "checkbox") this.init()
		}
		Switchery.prototype.hide = function() {
			this.element.style.display = "none"
		};
		Switchery.prototype.show = function() {
			var switcher = this.create();
			this.insertAfter(this.element, switcher)
		};
		Switchery.prototype.create = function() {
			this.switcher = document.createElement("span");
			this.jack = document.createElement("small");
			this.switcher.appendChild(this.jack);
			this.switcher.className = this.options.className;
			return this.switcher
		};
		Switchery.prototype.insertAfter = function(reference, target) {
			reference.parentNode.insertBefore(target, reference.nextSibling)
		};
		Switchery.prototype.isChecked = function() {
			return this.element.checked
		};
		Switchery.prototype.isDisabled = function() {
			return this.options.disabled || this.element.disabled
		};
		Switchery.prototype.setPosition = function(clicked) {
			var checked = this.isChecked(),
				switcher = this.switcher,
				jack = this.jack;
			if (clicked && checked) checked = false;
			else if (clicked && !checked) checked = true;
			if (checked === true) {
				this.element.checked = true;
				if (window.getComputedStyle) jack.style.left = parseInt(window.getComputedStyle(switcher).width) - parseInt(window.getComputedStyle(jack).width) + "px";
				else jack.style.left = parseInt(switcher.currentStyle["width"]) - parseInt(jack.currentStyle["width"]) + "px";
				if (this.options.color) this.colorize();
				this.setSpeed()
			} else {
				jack.style.left = 0;
				this.element.checked = false;
				this.switcher.style.boxShadow = "inset 0 0 0 0 " + this.options.secondaryColor;
				this.switcher.style.borderColor = this.options.secondaryColor;
				this.switcher.style.backgroundColor = "";
				this.setSpeed()
			}
		};
		Switchery.prototype.setSpeed = function() {
			var switcherProp = {},
				jackProp = {
					left: this.options.speed.replace(/[a-z]/, "") / 2 + "s"
				};
			if (this.isChecked()) {
				switcherProp = {
					border: this.options.speed,
					"box-shadow": this.options.speed,
					"background-color": this.options.speed.replace(/[a-z]/, "") * 3 + "s"
				}
			} else {
				switcherProp = {
					border: this.options.speed,
					"box-shadow": this.options.speed
				}
			}
			transitionize(this.switcher, switcherProp);
			transitionize(this.jack, jackProp)
		};
		Switchery.prototype.setAttributes = function() {
			var id = this.element.getAttribute("id"),
				name = this.element.getAttribute("name");
			if (id) this.switcher.setAttribute("id", id);
			if (name) this.switcher.setAttribute("name", name)
		};
		Switchery.prototype.colorize = function() {
			this.switcher.style.backgroundColor = this.options.color;
			this.switcher.style.borderColor = this.options.color;
			this.switcher.style.boxShadow = "inset 0 0 0 16px " + this.options.color
		};
		Switchery.prototype.handleOnchange = function(state) {
			if (typeof Event === "function" || !document.fireEvent) {
				var event = document.createEvent("HTMLEvents");
				event.initEvent("change", true, true);
				this.element.dispatchEvent(event)
			} else {
				this.element.fireEvent("onchange")
			}
		};
		Switchery.prototype.handleChange = function() {
			var self = this,
				el = this.element;
			if (el.addEventListener) {
				el.addEventListener("change", function() {
					self.setPosition()
				})
			} else {
				el.attachEvent("onchange", function() {
					self.setPosition()
				})
			}
		};
		Switchery.prototype.handleClick = function() {
			var self = this,
				switcher = this.switcher;
			if (this.isDisabled() === false) {
				fastclick(switcher);
				if (switcher.addEventListener) {
					switcher.addEventListener("click", function() {
						self.setPosition(true);
						self.handleOnchange(self.element.checked)
					})
				} else {
					switcher.attachEvent("onclick", function() {
						self.setPosition(true);
						self.handleOnchange(self.element.checked)
					})
				}
			} else {
				this.element.disabled = true;
				this.switcher.style.opacity = this.options.disabledOpacity
			}
		};
		Switchery.prototype.disableLabel = function() {
			var parent = this.element.parentNode,
				labels = document.getElementsByTagName("label"),
				attached = null;
			for (var i = 0; i < labels.length; i++) {
				if (labels[i].getAttribute("for") === this.element.id) {
					attached = true
				}
			}
			if (attached === true || parent.tagName.toLowerCase() === "label") {
				if (parent.addEventListener) {
					parent.addEventListener("click", function(e) {
						e.preventDefault()
					})
				} else {
					parent.attachEvent("onclick", function(e) {
						e.returnValue = false
					})
				}
			}
		};
		Switchery.prototype.markAsSwitched = function() {
			this.element.setAttribute("data-switchery", true)
		};
		Switchery.prototype.markedAsSwitched = function() {
			return this.element.getAttribute("data-switchery")
		};
		Switchery.prototype.init = function() {
			this.hide();
			this.show();
			this.setPosition();
			this.setAttributes();
			this.markAsSwitched();
			this.disableLabel();
			this.handleChange();
			this.handleClick()
		}
	});
	require.alias("abpetkov-transitionize/transitionize.js", "switchery/deps/transitionize/transitionize.js");
	require.alias("abpetkov-transitionize/transitionize.js", "switchery/deps/transitionize/index.js");
	require.alias("abpetkov-transitionize/transitionize.js", "transitionize/index.js");
	require.alias("abpetkov-transitionize/transitionize.js", "abpetkov-transitionize/index.js");
	require.alias("ftlabs-fastclick/lib/fastclick.js", "switchery/deps/fastclick/lib/fastclick.js");
	require.alias("ftlabs-fastclick/lib/fastclick.js", "switchery/deps/fastclick/index.js");
	require.alias("ftlabs-fastclick/lib/fastclick.js", "fastclick/index.js");
	require.alias("ftlabs-fastclick/lib/fastclick.js", "ftlabs-fastclick/index.js");
	require.alias("switchery/switchery.js", "switchery/index.js");
	if (typeof exports == "object") {
		module.exports = require("switchery")
	} else if (typeof define == "function" && define.amd) {
		define(function() {
			return require("switchery")
		})
	} else {
		this["Switchery"] = require("switchery")
	}
})();